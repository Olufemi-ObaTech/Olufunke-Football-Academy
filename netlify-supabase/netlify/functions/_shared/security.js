/**
 * _shared/security.js — Server-side security utilities
 * ─────────────────────────────────────────────────────
 * Rate limiting, input validation, CORS headers, and
 * request validation for Netlify serverless functions.
 */

// ── In-memory Rate Limiter (per function cold start) ────────────
const rateLimitMap = new Map();

/**
 * Server-side rate limiter by IP address.
 * Note: In-memory map resets on cold start — acceptable for basic protection.
 * For production-grade limiting, use Redis or Netlify Edge rate limiting.
 *
 * @param {string} ip - Client IP address
 * @param {string} action - Action identifier (e.g., 'contact', 'login')
 * @param {number} maxRequests - Max requests in window
 * @param {number} windowMs - Window duration in ms (default: 60s)
 * @returns {{ allowed: boolean, remaining: number, retryAfter: number }}
 */
function rateLimit(ip, action, maxRequests = 10, windowMs = 60000) {
  const key = `${action}:${ip}`;
  const now = Date.now();

  if (!rateLimitMap.has(key)) {
    rateLimitMap.set(key, []);
  }

  const timestamps = rateLimitMap.get(key).filter((t) => now - t < windowMs);
  rateLimitMap.set(key, timestamps);

  if (timestamps.length >= maxRequests) {
    const oldest = timestamps[0];
    const retryAfter = Math.ceil((oldest + windowMs - now) / 1000);
    return { allowed: false, remaining: 0, retryAfter };
  }

  timestamps.push(now);
  return { allowed: true, remaining: maxRequests - timestamps.length, retryAfter: 0 };
}

// ── CORS Headers ────────────────────────────────────────────────
const ALLOWED_ORIGINS = [
  'https://olufunkefootballacademy.com',
  'https://www.olufunkefootballacademy.com',
  'https://olufunkefootballacademy.netlify.app',
  'http://localhost:3000',
  'http://localhost:8888',
];

/**
 * Build CORS headers based on the request origin.
 */
function getCorsHeaders(event) {
  const origin = event.headers['origin'] || event.headers['Origin'] || '';
  const allowedOrigin = ALLOWED_ORIGINS.includes(origin) ? origin : ALLOWED_ORIGINS[0];
  return {
    'Access-Control-Allow-Origin': allowedOrigin,
    'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
    'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With, X-CSRF-Token',
    'Access-Control-Max-Age': '86400',
  };
}

/**
 * Handle CORS preflight (OPTIONS) requests.
 */
function handleCors(event) {
  if (event.httpMethod === 'OPTIONS') {
    return {
      statusCode: 204,
      headers: getCorsHeaders(event),
      body: '',
    };
  }
  return null;
}

// ── JSON Response Helper ────────────────────────────────────────
/**
 * Standard JSON response with security headers.
 */
function jsonResponse(statusCode, body, event) {
  return {
    statusCode,
    headers: {
      'Content-Type': 'application/json',
      ...getCorsHeaders(event),
      'X-Content-Type-Options': 'nosniff',
      'X-Frame-Options': 'DENY',
      'X-XSS-Protection': '1; mode=block',
    },
    body: JSON.stringify(body),
  };
}

// ── Rate-Limited JSON Response ──────────────────────────────────
function rateLimitedResponse(event, retryAfter) {
  return {
    statusCode: 429,
    headers: {
      'Content-Type': 'application/json',
      ...getCorsHeaders(event),
      'Retry-After': String(retryAfter),
    },
    body: JSON.stringify({
      error: 'Too many requests. Please try again later.',
      retryAfter,
    }),
  };
}

// ── Input Sanitization ──────────────────────────────────────────
/**
 * Sanitize string input — strip HTML tags, dangerous patterns.
 */
function sanitize(str) {
  if (typeof str !== 'string') return str;
  return str
    .trim()
    .replace(/<[^>]*>/g, '')                         // Strip HTML tags
    .replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '')
    .replace(/javascript:/gi, '')
    .replace(/on\w+\s*=/gi, '')
    .slice(0, 5000);                                 // Max length cap
}

/**
 * Sanitize all string values in an object.
 */
function sanitizeBody(obj) {
  if (!obj || typeof obj !== 'object') return {};
  const cleaned = {};
  for (const [key, val] of Object.entries(obj)) {
    cleaned[key] = typeof val === 'string' ? sanitize(val) : val;
  }
  return cleaned;
}

// ── Parse & Validate Request Body ───────────────────────────────
/**
 * Safely parse JSON body with error handling.
 */
function parseBody(event) {
  try {
    return JSON.parse(event.body || '{}');
  } catch {
    return null;
  }
}

// ── Client IP extraction ────────────────────────────────────────
/**
 * Extract client IP from Netlify headers.
 */
function getClientIp(event) {
  return (
    event.headers['x-forwarded-for']?.split(',')[0]?.trim() ||
    event.headers['client-ip'] ||
    event.headers['x-real-ip'] ||
    'unknown'
  );
}

module.exports = {
  rateLimit,
  getCorsHeaders,
  handleCors,
  jsonResponse,
  rateLimitedResponse,
  sanitize,
  sanitizeBody,
  parseBody,
  getClientIp,
};
