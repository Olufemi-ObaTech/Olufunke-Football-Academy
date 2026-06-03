/**
 * Netlify Function: players.js
 * ─────────────────────────────
 * CRUD serverless API for the OFA Academy players table in Supabase.
 *
 * Endpoints (all prefixed /.netlify/functions/players):
 *   GET    ?id=<uuid>   → get single player
 *   GET                 → list all approved players
 *   POST                → create player (admin only)
 *   PUT    ?id=<uuid>   → update player
 *   DELETE ?id=<uuid>   → delete player (admin only)
 */

const { createClient } = require('@supabase/supabase-js');

const supabase = createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

// ── Helpers ──────────────────────────────────────────────────────

/**
 * Verify the JWT Bearer token from the request Authorization header.
 * Returns the authenticated user or null.
 */
async function getAuthUser(event) {
  const authHeader = event.headers['authorization'] || '';
  const token = authHeader.replace('Bearer ', '').trim();
  if (!token) return null;

  const { data, error } = await supabase.auth.getUser(token);
  return error ? null : data.user;
}

function jsonResponse(statusCode, body) {
  return {
    statusCode,
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body),
  };
}

// ── Handler ───────────────────────────────────────────────────────

exports.handler = async (event) => {
  const method = event.httpMethod;
  const { id } = event.queryStringParameters || {};

  try {
    // ── GET ──────────────────────────────────────────────────────
    if (method === 'GET') {
      if (id) {
        // Single player
        const { data, error } = await supabase
          .from('players')
          .select('id, full_name, position, age, approved, photo_url, created_at')
          .eq('id', id)
          .single();

        if (error) return jsonResponse(404, { error: 'Player not found' });
        return jsonResponse(200, { player: data });
      }

      // All approved players (public listing)
      const { data, error } = await supabase
        .from('players')
        .select('id, full_name, position, age, photo_url, goals, assists, matches, quote')
        .eq('approved', true)
        .order('full_name');

      if (error) throw error;
      return jsonResponse(200, { players: data });
    }

    // ── Auth-required routes ─────────────────────────────────────
    const user = await getAuthUser(event);
    if (!user) return jsonResponse(401, { error: 'Unauthorized' });

    // ── POST — Create player ─────────────────────────────────────
    if (method === 'POST') {
      const body = JSON.parse(event.body || '{}');
      const { full_name, position, age, photo_url } = body;

      if (!full_name || !position) {
        return jsonResponse(400, { error: 'full_name and position are required' });
      }

      const { data, error } = await supabase
        .from('players')
        .insert([{ full_name, position, age, photo_url, user_id: user.id }])
        .select()
        .single();

      if (error) throw error;
      return jsonResponse(201, { player: data });
    }

    // ── PUT — Update player ──────────────────────────────────────
    if (method === 'PUT') {
      if (!id) return jsonResponse(400, { error: 'Player id is required' });

      const body = JSON.parse(event.body || '{}');
      const { full_name, position, age, photo_url, approved } = body;

      const { data, error } = await supabase
        .from('players')
        .update({ full_name, position, age, photo_url, approved })
        .eq('id', id)
        .select()
        .single();

      if (error) throw error;
      return jsonResponse(200, { player: data });
    }

    // ── DELETE — Remove player ───────────────────────────────────
    if (method === 'DELETE') {
      if (!id) return jsonResponse(400, { error: 'Player id is required' });

      const { error } = await supabase
        .from('players')
        .delete()
        .eq('id', id);

      if (error) throw error;
      return jsonResponse(200, { message: 'Player deleted successfully' });
    }

    return jsonResponse(405, { error: 'Method not allowed' });

  } catch (err) {
    console.error('[players function]', err);
    return jsonResponse(500, { error: 'Internal server error', detail: err.message });
  }
};
