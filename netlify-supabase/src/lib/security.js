/**
 * src/lib/security.js — Security utilities for OFA Academy
 * ──────────────────────────────────────────────────────────
 * Client-side security helpers: input sanitization, CSRF token,
 * rate limiting, and session validation.
 */

// ── Input Sanitization ──────────────────────────────────────────
const DANGEROUS_PATTERNS = [
  /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
  /javascript:/gi,
  /on\w+\s*=/gi,
  /data:\s*text\/html/gi,
];

/**
 * Sanitize user input — strips dangerous HTML/JS patterns.
 * Use on all user-provided text before sending to API.
 */
export function sanitizeInput(str) {
  if (typeof str !== 'string') return str;
  let clean = str.trim();
  // Strip HTML tags
  clean = clean.replace(/<[^>]*>/g, '');
  // Strip dangerous patterns
  DANGEROUS_PATTERNS.forEach((pattern) => {
    clean = clean.replace(pattern, '');
  });
  return clean;
}

/**
 * Sanitize an entire form object — applies sanitizeInput to all string values.
 */
export function sanitizeForm(formData) {
  const cleaned = {};
  for (const [key, value] of Object.entries(formData)) {
    cleaned[key] = typeof value === 'string' ? sanitizeInput(value) : value;
  }
  return cleaned;
}

// ── Client-side Rate Limiting ───────────────────────────────────
const rateLimitStore = {};

/**
 * Simple client-side rate limiter — prevents rapid form submissions.
 * @param {string} key - Unique identifier (e.g., 'contact-form', 'login')
 * @param {number} maxAttempts - Max allowed attempts in the window
 * @param {number} windowMs - Time window in milliseconds (default: 60s)
 * @returns {boolean} true if allowed, false if rate-limited
 */
export function checkRateLimit(key, maxAttempts = 5, windowMs = 60000) {
  const now = Date.now();
  if (!rateLimitStore[key]) {
    rateLimitStore[key] = [];
  }
  // Remove expired entries
  rateLimitStore[key] = rateLimitStore[key].filter((t) => now - t < windowMs);
  if (rateLimitStore[key].length >= maxAttempts) {
    return false; // Rate limited
  }
  rateLimitStore[key].push(now);
  return true;
}

// ── CSRF Token ──────────────────────────────────────────────────
let csrfToken = null;

/**
 * Generate a random CSRF token for form submissions.
 */
export function generateCSRFToken() {
  const array = new Uint8Array(32);
  if (typeof window !== 'undefined' && window.crypto) {
    window.crypto.getRandomValues(array);
  } else {
    // Fallback for SSR
    for (let i = 0; i < array.length; i++) {
      array[i] = Math.floor(Math.random() * 256);
    }
  }
  csrfToken = Array.from(array, (b) => b.toString(16).padStart(2, '0')).join('');
  return csrfToken;
}

/**
 * Get the current CSRF token (generates one if needed).
 */
export function getCSRFToken() {
  if (!csrfToken) generateCSRFToken();
  return csrfToken;
}

// ── Session Validation ──────────────────────────────────────────
/**
 * Check if a Supabase session is valid and not expired.
 */
export function isSessionValid(session) {
  if (!session?.expires_at) return false;
  const expiresAt = new Date(session.expires_at * 1000);
  return expiresAt > new Date();
}

// ── Secure Headers for API calls ────────────────────────────────
/**
 * Build secure headers for API requests.
 */
export function getSecureHeaders(extraHeaders = {}) {
  return {
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-Token': getCSRFToken(),
    ...extraHeaders,
  };
}

// ── Password Strength Validation ────────────────────────────────
/**
 * Validate password meets minimum security requirements.
 * Returns { valid: boolean, errors: string[] }
 */
export function validatePassword(password) {
  const errors = [];
  if (!password || password.length < 8) errors.push('Must be at least 8 characters');
  if (!/[A-Z]/.test(password)) errors.push('Must contain an uppercase letter');
  if (!/[a-z]/.test(password)) errors.push('Must contain a lowercase letter');
  if (!/\d/.test(password)) errors.push('Must contain a number');
  return { valid: errors.length === 0, errors };
}

// ── Email Validation ────────────────────────────────────────────
/**
 * Validate email format — stricter than HTML5 built-in.
 */
export function validateEmail(email) {
  const re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
  return re.test(String(email).toLowerCase());
}
