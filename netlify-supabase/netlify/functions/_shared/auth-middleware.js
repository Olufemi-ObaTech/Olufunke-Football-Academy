/**
 * _shared/auth-middleware.js
 * Role-based JWT guards for Netlify serverless functions.
 * Uses Supabase service role to verify tokens and check profiles.
 */

const { createClient } = require('@supabase/supabase-js');

function getSupabase() {
  return createClient(
    process.env.NEXT_PUBLIC_SUPABASE_URL,
    process.env.SUPABASE_SERVICE_ROLE_KEY
  );
}

/**
 * Extract bearer token from Authorization header.
 */
function extractToken(event) {
  const auth = event.headers['authorization'] || event.headers['Authorization'] || '';
  return auth.startsWith('Bearer ') ? auth.slice(7) : null;
}

/**
 * Verify JWT and load profile. Returns { user, profile } or { error, status }.
 */
async function verifyAuth(event) {
  const token = extractToken(event);
  if (!token) return { error: 'Authorization token required', status: 401 };

  const supabase = getSupabase();
  const { data: { user }, error: authErr } = await supabase.auth.getUser(token);
  if (authErr || !user) return { error: 'Invalid or expired token', status: 401 };

  const { data: profile, error: profileErr } = await supabase
    .from('profiles')
    .select('role, status, full_name')
    .eq('id', user.id)
    .single();

  if (profileErr || !profile) return { error: 'User profile not found', status: 403 };

  return { user, profile, supabase };
}

/**
 * Require one of the given roles.
 * Usage: const result = await requireRole(event, 'guardian', 'admin');
 *        if (result.error) return jsonResponse(result.status, { error: result.error }, event);
 */
async function requireRole(event, ...allowedRoles) {
  const auth = await verifyAuth(event);
  if (auth.error) return auth;
  if (!allowedRoles.includes(auth.profile.role)) {
    return { error: `Access forbidden. Required role: ${allowedRoles.join(' or ')}`, status: 403 };
  }
  return auth;
}

/**
 * isGuardian guard — allows guardian and admin.
 */
async function isGuardian(event) {
  return requireRole(event, 'guardian', 'admin');
}

/**
 * isAdmin guard — allows admin only.
 */
async function isAdmin(event) {
  return requireRole(event, 'admin');
}

/**
 * isPlayer guard — allows player, coach, and admin. BLOCKS guardian.
 * Also used to check isGuardianOnly course access.
 */
async function isPlayer(event) {
  return requireRole(event, 'player', 'coach', 'admin');
}

/**
 * isAuthenticated guard — any logged-in user.
 */
async function isAuthenticated(event) {
  return verifyAuth(event);
}

/**
 * checkGuardianOnlyCourse — blocks players/coaches from guardian-only content.
 * Use on /api/education/guardian-lesson/* routes.
 */
async function blockPlayersFromGuardianCourse(event) {
  const auth = await verifyAuth(event);
  if (auth.error) return auth;
  if (auth.profile.role === 'player' || auth.profile.role === 'coach') {
    return {
      error: 'Access denied. This content is exclusive to Academy Guardians.',
      status: 403,
      code: 'GUARDIAN_ONLY_CONTENT',
    };
  }
  return auth;
}

/**
 * Write audit log for admin actions.
 */
async function auditLog(supabase, adminId, action, targetType, targetId) {
  try {
    await supabase.from('audit_logs').insert({
      admin_id: adminId,
      action,
      target_type: targetType,
      target_id: targetId,
    });
  } catch (e) {
    console.warn('Audit log failed:', e.message);
  }
}

module.exports = {
  verifyAuth,
  requireRole,
  isGuardian,
  isAdmin,
  isPlayer,
  isAuthenticated,
  blockPlayersFromGuardianCourse,
  auditLog,
  getSupabase,
};
