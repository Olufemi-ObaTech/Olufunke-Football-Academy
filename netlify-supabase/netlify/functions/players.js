/**
 * Netlify Function: players.js
 * ─────────────────────────────
 * CRUD serverless API for the OFA Academy players table in Supabase.
 * Secured with rate limiting, input sanitization, CORS validation.
 *
 * Endpoints (all prefixed /.netlify/functions/players):
 *   GET    ?id=<uuid>   → get single player
 *   GET                 → list all approved players
 *   POST                → create player (admin only)
 *   PUT    ?id=<uuid>   → update player (admin only)
 *   DELETE ?id=<uuid>   → delete player (admin only)
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

// ── Auth Helper ──────────────────────────────────────────────────
async function getAuthUser(event) {
  const authHeader = event.headers['authorization'] || '';
  const token = authHeader.replace('Bearer ', '').trim();
  if (!token) return null;

  const { data, error } = await supabase.auth.getUser(token);
  return error ? null : data.user;
}

// ── UUID validation ──────────────────────────────────────────────
function isValidUUID(str) {
  return /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i.test(str);
}

// ── Handler ───────────────────────────────────────────────────────
exports.handler = async (event) => {
  // ── CORS preflight ──────────────────────────────────────────
  const cors = handleCors(event);
  if (cors) return cors;

  const method = event.httpMethod;
  const { id } = event.queryStringParameters || {};
  const ip = getClientIp(event);

  // ── Rate limiting: 30 reads/min, 10 writes/min ──────────────
  const isWrite = ['POST', 'PUT', 'DELETE'].includes(method);
  const { allowed, retryAfter } = rateLimit(
    ip, `players-${isWrite ? 'write' : 'read'}`,
    isWrite ? 10 : 30, 60000
  );
  if (!allowed) return rateLimitedResponse(event, retryAfter);

  try {
    // ── GET ──────────────────────────────────────────────────────
    if (method === 'GET') {
      if (id) {
        if (!isValidUUID(id)) {
          return jsonResponse(400, { error: 'Invalid player ID format' }, event);
        }
        const { data, error } = await supabase
          .from('players')
          .select('id, full_name, position, age, approved, photo_url, created_at')
          .eq('id', id)
          .single();

        if (error) return jsonResponse(404, { error: 'Player not found' }, event);
        return jsonResponse(200, { player: data }, event);
      }

      const { data, error } = await supabase
        .from('players')
        .select('id, full_name, position, age, photo_url, goals, assists, matches, quote')
        .eq('approved', true)
        .order('full_name');

      if (error) throw error;
      return jsonResponse(200, { players: data }, event);
    }

    // ── Auth-required routes ─────────────────────────────────────
    const user = await getAuthUser(event);
    if (!user) return jsonResponse(401, { error: 'Unauthorized — please log in' }, event);

    const { data: profile } = await supabase
      .from('profiles')
      .select('role')
      .eq('id', user.id)
      .single();

    if (!profile || profile.role !== 'admin') {
      return jsonResponse(403, { error: 'Forbidden — admin access required' }, event);
    }

    // ── POST — Create player ─────────────────────────────────────
    if (method === 'POST') {
      const raw = parseBody(event);
      if (!raw) return jsonResponse(400, { error: 'Invalid request body' }, event);

      const body = sanitizeBody(raw);
      const { full_name, position, age, photo_url } = body;

      if (!full_name || !position) {
        return jsonResponse(400, { error: 'full_name and position are required' }, event);
      }

      if (full_name.length > 100 || position.length > 50) {
        return jsonResponse(400, { error: 'Input exceeds maximum length' }, event);
      }

      const { data, error } = await supabase
        .from('players')
        .insert([{ full_name, position, age: parseInt(age) || null, photo_url, user_id: user.id }])
        .select()
        .single();

      if (error) throw error;
      return jsonResponse(201, { player: data }, event);
    }

    // ── PUT — Update player ──────────────────────────────────────
    if (method === 'PUT') {
      if (!id || !isValidUUID(id)) {
        return jsonResponse(400, { error: 'Valid player ID is required' }, event);
      }

      const raw = parseBody(event);
      if (!raw) return jsonResponse(400, { error: 'Invalid request body' }, event);

      const body = sanitizeBody(raw);
      const { full_name, position, age, photo_url, approved } = body;

      const { data, error } = await supabase
        .from('players')
        .update({ full_name, position, age: parseInt(age) || null, photo_url, approved })
        .eq('id', id)
        .select()
        .single();

      if (error) throw error;
      return jsonResponse(200, { player: data }, event);
    }

    // ── DELETE — Remove player ───────────────────────────────────
    if (method === 'DELETE') {
      if (!id || !isValidUUID(id)) {
        return jsonResponse(400, { error: 'Valid player ID is required' }, event);
      }

      const { error } = await supabase
        .from('players')
        .delete()
        .eq('id', id);

      if (error) throw error;
      return jsonResponse(200, { message: 'Player deleted successfully' }, event);
    }

    return jsonResponse(405, { error: 'Method not allowed' }, event);

  } catch (err) {
    console.error('[players function]', err);
    return jsonResponse(500, { error: 'Internal server error' }, event);
  }
};
