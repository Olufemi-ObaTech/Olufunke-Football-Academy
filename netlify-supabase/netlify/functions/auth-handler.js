/**
 * Netlify Function: auth-handler.js
 * Handles Supabase OAuth callbacks and magic-link redirects.
 * Triggered via /auth/callback redirect in netlify.toml.
 */

const { createClient } = require('@supabase/supabase-js');

const SITE_URL = process.env.NEXT_PUBLIC_SITE_URL || 'https://olufunkef00tballacademy.netlify.app';

const supabase = createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL    || 'https://fpqkewuoymyodveqbfjc.supabase.co',
  process.env.SUPABASE_SERVICE_ROLE_KEY   || ''
);

exports.handler = async (event) => {
  const { code, error, error_description } = event.queryStringParameters || {};

  // ── OAuth error from Supabase ──────────────────────────────────
  if (error) {
    console.error('[auth-handler] OAuth error:', error_description);
    return {
      statusCode: 302,
      headers: {
        Location: `${SITE_URL}/login?error=${encodeURIComponent(error_description || error)}`,
      },
      body: '',
    };
  }

  // ── Exchange code for session ──────────────────────────────────
  if (code) {
    try {
      const { data, error: exchangeError } = await supabase.auth.exchangeCodeForSession(code);
      if (exchangeError) throw exchangeError;

      console.log('[auth-handler] Session created:', data.user?.email);

      return {
        statusCode: 302,
        headers: { Location: `${SITE_URL}/dashboard` },
        body: '',
      };
    } catch (err) {
      console.error('[auth-handler] Exchange error:', err.message);
      return {
        statusCode: 302,
        headers: { Location: `${SITE_URL}/login?error=auth_failed` },
        body: '',
      };
    }
  }

  return {
    statusCode: 302,
    headers: { Location: `${SITE_URL}/login` },
    body: '',
  };
};
