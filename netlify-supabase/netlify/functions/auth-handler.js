/**
 * Netlify Function: auth-handler.js
 * Handles Supabase OAuth callbacks and magic-link redirects.
 * Triggered via /auth/callback redirect in netlify.toml.
 *
 * Security: validates parameters, prevents open redirects,
 * and sanitizes error messages before redirecting.
 */

const SITE_URL = process.env.NEXT_PUBLIC_SITE_URL || 'https://olufunkefootballacademy.com';

// ── Allowed redirect destinations ────────────────────────────────
const ALLOWED_HOSTS = [
  'olufunkefootballacademy.com',
  'www.olufunkefootballacademy.com',
  'olufunkefootballacademy.netlify.app',
];

function isSafeRedirect(url) {
  try {
    const parsed = new URL(url);
    return ALLOWED_HOSTS.includes(parsed.hostname);
  } catch {
    return false;
  }
}

exports.handler = async (event) => {
  const params = event.queryStringParameters || {};
  const { code, error, error_description, token_hash, type } = params;

  // ── OAuth/magic-link error from Supabase ─────────────────────
  if (error) {
    console.error('[auth-handler] Auth error:', error_description || error);
    // Sanitize error message — only allow alphanumeric, spaces, and basic punctuation
    const safeMsg = (error_description || error)
      .replace(/[^a-zA-Z0-9 .,!?_-]/g, '')
      .slice(0, 200);
    const msg = encodeURIComponent(safeMsg);
    return redirect(`${SITE_URL}/login?error=${msg}`);
  }

  // ── PKCE code flow (OAuth + magic link) ──────────────────────
  if (code) {
    // Validate code format — should be alphanumeric + hyphens
    const cleanCode = String(code).replace(/[^a-zA-Z0-9_-]/g, '').slice(0, 500);
    const dest = `${SITE_URL}/auth/confirm?code=${encodeURIComponent(cleanCode)}`;
    if (!isSafeRedirect(dest)) return redirect(`${SITE_URL}/login`);
    return redirect(dest);
  }

  // ── Email OTP token_hash flow (email confirmations) ──────────
  if (token_hash && type) {
    const cleanHash = String(token_hash).replace(/[^a-zA-Z0-9_=-]/g, '').slice(0, 500);
    const cleanType = String(type).replace(/[^a-z_]/g, '').slice(0, 30);
    const dest = `${SITE_URL}/auth/confirm?token_hash=${encodeURIComponent(cleanHash)}&type=${encodeURIComponent(cleanType)}`;
    if (!isSafeRedirect(dest)) return redirect(`${SITE_URL}/login`);
    return redirect(dest);
  }

  // ── Fallback ─────────────────────────────────────────────────
  return redirect(`${SITE_URL}/login`);
};

function redirect(location) {
  return {
    statusCode: 302,
    headers: {
      Location: location,
      'Cache-Control': 'no-cache, no-store, must-revalidate',
      'X-Content-Type-Options': 'nosniff',
    },
    body: '',
  };
}
