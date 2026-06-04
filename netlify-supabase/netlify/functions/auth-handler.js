/**
 * Netlify Function: auth-handler.js
 * Handles Supabase OAuth callbacks and magic-link redirects.
 * Triggered via /auth/callback redirect in netlify.toml.
 *
 * Strategy: redirect the browser back to a Next.js page (/auth/confirm)
 * that uses the Supabase JS client to exchange the code client-side.
 * This is the correct PKCE flow — server-side session exchange doesn't
 * work here because the session tokens can't be set in the browser cookies.
 */

const SITE_URL = process.env.NEXT_PUBLIC_SITE_URL || 'https://olufunkefootballacademy.netlify.app';

exports.handler = async (event) => {
  const params = event.queryStringParameters || {};
  const { code, error, error_description, token_hash, type } = params;

  // ── OAuth/magic-link error from Supabase ─────────────────────
  if (error) {
    console.error('[auth-handler] Auth error:', error_description || error);
    const msg = encodeURIComponent(error_description || error);
    return redirect(`${SITE_URL}/login?error=${msg}`);
  }

  // ── PKCE code flow (OAuth + magic link) ──────────────────────
  // Pass code through to the client-side page which does the exchange.
  if (code) {
    const dest = `${SITE_URL}/auth/confirm?code=${encodeURIComponent(code)}`;
    return redirect(dest);
  }

  // ── Email OTP token_hash flow (email confirmations) ──────────
  if (token_hash && type) {
    const dest = `${SITE_URL}/auth/confirm?token_hash=${encodeURIComponent(token_hash)}&type=${encodeURIComponent(type)}`;
    return redirect(dest);
  }

  // ── Fallback ─────────────────────────────────────────────────
  return redirect(`${SITE_URL}/login`);
};

function redirect(location) {
  return {
    statusCode: 302,
    headers: { Location: location },
    body: '',
  };
}
