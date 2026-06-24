/**
 * Netlify Function: contact.js
 * ─────────────────────────────
 * Saves contact form submissions to Supabase contact_messages table.
 * Secured with rate limiting, input sanitization, and CORS validation.
 *
 * POST body: { name, email, subject, message }
 */

const { createClient } = require('@supabase/supabase-js');
const {
  rateLimit, handleCors, jsonResponse, rateLimitedResponse,
  sanitizeBody, parseBody, getClientIp,
} = require('./_shared/security');

const supabase = createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

exports.handler = async (event) => {
  // ── CORS preflight ──────────────────────────────────────────
  const cors = handleCors(event);
  if (cors) return cors;

  if (event.httpMethod !== 'POST') {
    return jsonResponse(405, { error: 'Method not allowed' }, event);
  }

  // ── Rate limiting: 5 contact submissions per minute per IP ──
  const ip = getClientIp(event);
  const { allowed, retryAfter } = rateLimit(ip, 'contact', 5, 60000);
  if (!allowed) {
    return rateLimitedResponse(event, retryAfter);
  }

  try {
    const raw = parseBody(event);
    if (!raw) {
      return jsonResponse(400, { error: 'Invalid request body' }, event);
    }

    const { name, email, subject, message } = sanitizeBody(raw);

    // ── Input validation ─────────────────────────────────────────
    if (!name || !email || !message) {
      return jsonResponse(400, { error: 'name, email, and message are required' }, event);
    }

    if (name.length > 100) {
      return jsonResponse(400, { error: 'Name is too long (max 100 characters)' }, event);
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      return jsonResponse(400, { error: 'Invalid email address' }, event);
    }

    if (message.length > 2000) {
      return jsonResponse(400, { error: 'Message is too long (max 2000 characters)' }, event);
    }

    // ── Save to Supabase ─────────────────────────────────────────
    const { data, error } = await supabase
      .from('contact_messages')
      .insert([{
        name,
        email,
        subject: subject || 'General Enquiry',
        message,
      }])
      .select()
      .single();

    if (error) throw error;

    // ── Trigger n8n webhook (optional) ──────────────────────────
    if (process.env.N8N_CONTACT_WEBHOOK) {
      try {
        await fetch(process.env.N8N_CONTACT_WEBHOOK, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, email, subject, message, id: data.id }),
        });
      } catch (webhookErr) {
        console.warn('[contact] n8n webhook failed:', webhookErr.message);
      }
    }

    return jsonResponse(201, {
      message: 'Your message has been received. We will get back to you soon.',
      id: data.id,
    }, event);

  } catch (err) {
    console.error('[contact function]', err);
    return jsonResponse(500, { error: 'Failed to save message. Please try again.' }, event);
  }
};
