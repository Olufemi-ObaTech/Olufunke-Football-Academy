/**
 * supabase-client.js — Shared Supabase client factory
 * ─────────────────────────────────────────────────────
 * Used by Netlify serverless functions (Node.js environment).
 * Do NOT import this file in browser/frontend code.
 * Use src/lib/supabaseClient.js for the browser client instead.
 */

const { createClient } = require('@supabase/supabase-js');

let _anonClient  = null;
let _adminClient = null;

/**
 * Anon client — respects Row Level Security.
 * Safe for operations that should be user-scoped.
 */
const SUPABASE_URL = process.env.NEXT_PUBLIC_SUPABASE_URL;

if (!SUPABASE_URL) {
  throw new Error('Missing NEXT_PUBLIC_SUPABASE_URL environment variable');
}

function getAnonClient() {
  if (!_anonClient) {
    const anonKey = process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY;
    if (!anonKey) throw new Error('Missing NEXT_PUBLIC_SUPABASE_ANON_KEY environment variable');
    _anonClient = createClient(
      SUPABASE_URL,
      anonKey,
      {
        auth: {
          persistSession: false,  // Netlify functions are stateless
          autoRefreshToken: false,
        },
      }
    );
  }
  return _anonClient;
}

/**
 * Admin client — bypasses Row Level Security.
 * Use ONLY in server-side functions, never expose to browser.
 */
function getAdminClient() {
  if (!_adminClient) {
    const serviceKey = process.env.SUPABASE_SERVICE_ROLE_KEY;
    if (!serviceKey) throw new Error('Missing SUPABASE_SERVICE_ROLE_KEY environment variable');
    _adminClient = createClient(
      SUPABASE_URL,
      serviceKey,
      {
        auth: {
          persistSession: false,
          autoRefreshToken: false,
        },
      }
    );
  }
  return _adminClient;
}

/**
 * Create a client authenticated as a specific user via their JWT.
 * Useful for server-side operations that should still respect RLS.
 */
function getUserClient(accessToken) {
  const anonKey = process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY;
  if (!anonKey) throw new Error('Missing NEXT_PUBLIC_SUPABASE_ANON_KEY environment variable');
  return createClient(
    SUPABASE_URL,
    anonKey,
    {
      global: {
        headers: { Authorization: `Bearer ${accessToken}` },
      },
      auth: {
        persistSession: false,
        autoRefreshToken: false,
      },
    }
  );
}

module.exports = { getAnonClient, getAdminClient, getUserClient };
