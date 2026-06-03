/**
 * src/lib/api.js — API helpers
 * ──────────────────────────────
 * Thin wrappers around the Netlify serverless functions.
 * These run as /.netlify/functions/<name> in production.
 */

const BASE = process.env.NODE_ENV === 'development'
  ? 'http://localhost:8888/.netlify/functions'  // netlify dev local port
  : '/.netlify/functions';

/**
 * Get the current user's JWT from Supabase session.
 * Pass this as Authorization header for auth-required endpoints.
 */
async function getAuthHeader() {
  // Dynamic import to avoid SSR issues
  const { supabase } = await import('./supabaseClient');
  const { data } = await supabase.auth.getSession();
  const token = data?.session?.access_token;
  return token ? { Authorization: `Bearer ${token}` } : {};
}

// ── Players ───────────────────────────────────────────────────

export async function fetchPlayers() {
  const res = await fetch(`${BASE}/players`);
  if (!res.ok) throw new Error('Failed to fetch players');
  return res.json();
}

export async function fetchPlayer(id) {
  const res = await fetch(`${BASE}/players?id=${id}`);
  if (!res.ok) throw new Error('Player not found');
  return res.json();
}

export async function createPlayer(playerData) {
  const headers = await getAuthHeader();
  const res = await fetch(`${BASE}/players`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', ...headers },
    body: JSON.stringify(playerData),
  });
  if (!res.ok) throw new Error('Failed to create player');
  return res.json();
}

export async function updatePlayer(id, playerData) {
  const headers = await getAuthHeader();
  const res = await fetch(`${BASE}/players?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', ...headers },
    body: JSON.stringify(playerData),
  });
  if (!res.ok) throw new Error('Failed to update player');
  return res.json();
}

// ── Quiz ──────────────────────────────────────────────────────

export async function fetchQuiz(week = 1) {
  const res = await fetch(`${BASE}/quiz?week=${week}`);
  if (!res.ok) throw new Error('Failed to fetch quiz');
  return res.json();
}

export async function submitQuiz(weekId, answers) {
  const headers = await getAuthHeader();
  const res = await fetch(`${BASE}/quiz`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', ...headers },
    body: JSON.stringify({ week_id: weekId, answers }),
  });
  const data = await res.json();
  if (!res.ok) throw new Error(data.error || 'Quiz submission failed');
  return data;
}

export async function fetchLeaderboard() {
  const res = await fetch(`${BASE}/quiz?leaderboard=true`);
  if (!res.ok) throw new Error('Failed to fetch leaderboard');
  return res.json();
}

// ── Contact ───────────────────────────────────────────────────

export async function sendContactMessage({ name, email, subject, message }) {
  const res = await fetch(`${BASE}/contact`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ name, email, subject, message }),
  });
  const data = await res.json();
  if (!res.ok) throw new Error(data.error || 'Message failed to send');
  return data;
}
