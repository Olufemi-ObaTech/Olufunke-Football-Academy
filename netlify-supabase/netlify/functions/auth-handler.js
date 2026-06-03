/**
 * Netlify Function: auth-handler.js
 * ----------------------------------
 * Handles Supabase OAuth callbacks and magic-link redirects.
 * Triggered via the /auth/callback redirect in netlify.toml.
 *
 * Flow:
 *   Browser → Supabase OAuth → /auth/callback → this function → redirect to dashboard
 */

const { createClient } = require('@supabase/supabase-js');

// Use SERVICE ROLE key server-side (never exposed to browser)
const supabase = createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

exports.handler = async (event) => {
  const { code, error, error_description } = event.queryStringParameters || {};

  // ── Handle OAuth errors from Supabase ──────────────────────────
  if (error) {
    console.error('[auth-handler] OAuth error:', error_description);
    return {
      statusCode: 302,
      headers: {
        Location: `${process.env.NEXT_PUBLIC_SITE_URL}/login?error=${encodeURIComponent(error_description)}`,
      },
      body: '',
    };
  }

  // ── Exchange code for session ───────────────────────────────────
  if (code) {
    try {
      const { data, error: exchangeError } = await supabase.auth.exchangeCodeForSession(code);

      if (exchangeError) throw exchangeError;

      console.log('[auth-handler] Session created for user:', data.user?.email);

      // Redirect to dashboard after successful auth
      return {
        statusCode: 302,
        headers: {
          Location: `${process.env.NEXT_PUBLIC_SITE_URL}/dashboard`,
        },
        body: '',
      };
    } catch (err) {
      console.error('[auth-handler] Exchange error:', err.message);
      return {
        statusCode: 302,
        headers: {
          Location: `${process.env.NEXT_PUBLIC_SITE_URL}/login?error=auth_failed`,
        },
        body: '',
      };
    }
  }

  // ── No code provided ───────────────────────────────────────────
  return {
    statusCode: 302,
    headers: { Location: `${process.env.NEXT_PUBLIC_SITE_URL}/login` },
    body: '',
  };
};
