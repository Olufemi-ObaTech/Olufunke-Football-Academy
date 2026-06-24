/**
 * guardian-api.js — Guardian Portal API
 * Handles: dashboard, schedule, invoices, tickets, call requests, consent
 * Auth: All routes require role === 'guardian' or 'admin'
 */

const { createClient } = require('@supabase/supabase-js');
const { handleCors, jsonResponse, rateLimitedResponse, rateLimit, parseBody, sanitizeBody, getClientIp } = require('./_shared/security');
const { isGuardian, isAdmin, auditLog } = require('./_shared/auth-middleware');

const supabaseAdmin = () => createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

exports.handler = async (event) => {
  const corsResult = handleCors(event);
  if (corsResult) return corsResult;

  const ip      = getClientIp(event);
  const path    = event.path.replace('/.netlify/functions/guardian-api', '').replace('/api/guardian', '');
  const method  = event.httpMethod;

  // ── Rate limiting ──────────────────────────────────────────────
  const rl = rateLimit(ip, 'guardian-api', 30, 60000);
  if (!rl.allowed) return rateLimitedResponse(event, rl.retryAfter);

  // ── Auth guard ─────────────────────────────────────────────────
  const auth = await isGuardian(event);
  if (auth.error) return jsonResponse(auth.status, { error: auth.error }, event);

  const { user, profile, supabase } = auth;
  const sb = supabaseAdmin();

  try {

    // ── GET /dashboard ─────────────────────────────────────────
    if (method === 'GET' && path === '/dashboard') {
      const [
        { data: children },
        { data: invoices },
        { data: announcements },
        { data: consentHistory },
        { data: callRequests },
      ] = await Promise.all([
        sb.from('guardian_children').select('*').eq('guardian_id', user.id),
        sb.from('guardian_invoices').select('*').eq('guardian_id', user.id).order('due_date', { ascending: true }).limit(5),
        sb.from('announcements').select('*').contains('target_roles', ['guardian']).order('created_at', { ascending: false }).limit(3),
        sb.from('consent_history').select('*').eq('guardian_id', user.id).order('signed_at', { ascending: false }).limit(1).single(),
        sb.from('guardian_call_requests').select('*').eq('guardian_id', user.id).eq('status', 'pending').limit(1),
      ]);

      const outstanding = (invoices || []).filter(i => i.status !== 'paid').reduce((s, i) => s + Number(i.amount), 0);
      const nextDue = (invoices || []).filter(i => i.status !== 'paid').sort((a, b) => new Date(a.due_date) - new Date(b.due_date))[0];

      return jsonResponse(200, {
        guardian: { id: user.id, name: profile.full_name },
        children: children || [],
        financials: { outstanding, nextDue: nextDue || null },
        consent: consentHistory || null,
        announcements: announcements || [],
        pendingCallRequest: (callRequests || []).length > 0,
      }, event);
    }

    // ── GET /schedule/:childId ──────────────────────────────────
    if (method === 'GET' && path.startsWith('/schedule')) {
      const childIdParam = path.split('/')[2];

      // Verify this child belongs to the guardian
      if (childIdParam) {
        const { data: link } = await sb
          .from('guardian_children')
          .select('*')
          .eq('guardian_id', user.id)
          .eq('id', childIdParam)
          .single();
        if (!link) return jsonResponse(403, { error: 'Child not linked to this guardian' }, event);
      }

      const { data: fixtures } = await sb
        .from('next_fixtures')
        .select('*')
        .eq('is_active', true)
        .order('fixture_date', { ascending: true })
        .limit(5);

      const { data: results } = await sb
        .from('match_results')
        .select('*')
        .order('match_date', { ascending: false })
        .limit(10);

      return jsonResponse(200, {
        upcoming: fixtures || [],
        pastResults: results || [],
      }, event);
    }

    // ── GET /invoices ───────────────────────────────────────────
    if (method === 'GET' && path === '/invoices') {
      const { data: invoices } = await sb
        .from('guardian_invoices')
        .select('*')
        .eq('guardian_id', user.id)
        .order('created_at', { ascending: false });
      return jsonResponse(200, { invoices: invoices || [] }, event);
    }

    // ── POST /tickets ───────────────────────────────────────────
    if (method === 'POST' && path === '/tickets') {
      const ticketRl = rateLimit(ip, 'guardian-ticket', 3, 300000);
      if (!ticketRl.allowed) return rateLimitedResponse(event, ticketRl.retryAfter);

      const body = parseBody(event);
      if (!body) return jsonResponse(400, { error: 'Invalid request body' }, event);

      const clean = sanitizeBody(body);
      if (!clean.subject?.trim() || !clean.message?.trim())
        return jsonResponse(400, { error: 'Subject and message are required' }, event);
      if (!['billing','absence','general','safeguarding'].includes(clean.type))
        return jsonResponse(400, { error: 'Invalid ticket type' }, event);

      const { data: ticket, error } = await sb.from('guardian_tickets').insert({
        guardian_id: user.id,
        type: clean.type,
        subject: clean.subject.slice(0, 200),
        message: clean.message.slice(0, 2000),
      }).select().single();

      if (error) return jsonResponse(500, { error: 'Failed to create ticket' }, event);
      return jsonResponse(201, { ticket }, event);
    }

    // ── POST /call-request ──────────────────────────────────────
    if (method === 'POST' && path === '/call-request') {
      const callRl = rateLimit(ip, 'guardian-call', 2, 86400000);
      if (!callRl.allowed) return rateLimitedResponse(event, callRl.retryAfter);

      const body = parseBody(event);
      const clean = sanitizeBody(body || {});

      // Check no pending request already exists
      const { data: existing } = await sb
        .from('guardian_call_requests')
        .select('id')
        .eq('guardian_id', user.id)
        .eq('status', 'pending')
        .single();

      if (existing) return jsonResponse(409, { error: 'You already have a pending call request. Please wait for it to be scheduled.' }, event);

      const { data: req, error } = await sb.from('guardian_call_requests').insert({
        guardian_id: user.id,
        preferred_time: clean.preferred_time?.slice(0, 200),
      }).select().single();

      if (error) return jsonResponse(500, { error: 'Failed to create call request' }, event);
      return jsonResponse(201, { callRequest: req }, event);
    }

    // ── POST /consent/sign ──────────────────────────────────────
    if (method === 'POST' && path === '/consent/sign') {
      const body = parseBody(event);
      if (!body) return jsonResponse(400, { error: 'Invalid request body' }, event);

      // Mark previous consents as not current
      await sb.from('consent_history').update({ is_current: false }).eq('guardian_id', user.id);

      const { data: consent, error } = await sb.from('consent_history').insert({
        guardian_id: user.id,
        form_version: body.form_version || '1.0',
        pdf_url: body.pdf_url || null,
        is_current: true,
        expires_at: body.expires_at || null,
      }).select().single();

      if (error) return jsonResponse(500, { error: 'Failed to record consent' }, event);
      return jsonResponse(201, { consent }, event);
    }

    // ── GET /children ───────────────────────────────────────────
    if (method === 'GET' && path === '/children') {
      const { data: children } = await sb
        .from('guardian_children')
        .select('*')
        .eq('guardian_id', user.id);
      return jsonResponse(200, { children: children || [] }, event);
    }

    // ── POST /link-child ────────────────────────────────────────
    if (method === 'POST' && path === '/link-child') {
      const body = parseBody(event);
      if (!body) return jsonResponse(400, { error: 'Invalid request body' }, event);
      const clean = sanitizeBody(body);

      if (!clean.player_name?.trim())
        return jsonResponse(400, { error: 'Player name is required' }, event);

      const { data: child, error } = await sb.from('guardian_children').insert({
        guardian_id: user.id,
        player_name: clean.player_name.trim(),
        player_age: parseInt(clean.player_age) || null,
        player_position: clean.player_position || null,
        player_age_group: clean.player_age_group || null,
      }).select().single();

      if (error) return jsonResponse(500, { error: 'Failed to link child' }, event);
      return jsonResponse(201, { child }, event);
    }

    return jsonResponse(404, { error: 'Guardian API endpoint not found' }, event);

  } catch (err) {
    console.error('Guardian API error:', err);
    return jsonResponse(500, { error: 'Internal server error' }, event);
  }
};
