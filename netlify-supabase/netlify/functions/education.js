/**
 * education.js — Education Hub API with role-based course filtering
 *
 * GET  /api/education/courses        → list courses (filters guardian-only for players)
 * GET  /api/education/courses/:id    → single course detail (blocks players from guardian-only)
 * GET  /api/education/guardian-lesson/:id → guardian-only lesson (BLOCKS players)
 */

const { createClient } = require('@supabase/supabase-js');
const { handleCors, jsonResponse, rateLimitedResponse, rateLimit, getClientIp } = require('./_shared/security');
const { isAuthenticated, blockPlayersFromGuardianCourse } = require('./_shared/auth-middleware');

const sb = () => createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

exports.handler = async (event) => {
  const corsResult = handleCors(event);
  if (corsResult) return corsResult;

  const ip   = getClientIp(event);
  const rl   = rateLimit(ip, 'education', 30, 60000);
  if (!rl.allowed) return rateLimitedResponse(event, rl.retryAfter);

  const rawPath = event.path.replace('/.netlify/functions/education', '').replace('/api/education', '');
  const method  = event.httpMethod;

  if (method !== 'GET') return jsonResponse(405, { error: 'Method not allowed' }, event);

  // ── Auth check ─────────────────────────────────────────────────
  const auth = await isAuthenticated(event);
  if (auth.error) return jsonResponse(auth.status, { error: auth.error }, event);

  const { profile } = auth;
  const role = profile.role; // 'admin' | 'coach' | 'player' | 'guardian'
  const supabase = sb();

  try {

    // ── GET /courses — List all courses with role filtering ──────
    if (rawPath === '/courses' || rawPath === '') {
      let query = supabase.from('courses').select('*, lessons(id, title, order_index)').eq('is_active', true);

      // Players and coaches CANNOT see guardian-only courses
      if (role === 'player' || role === 'coach') {
        query = query.eq('is_guardian_only', false);
      }

      const { data: courses, error } = await query.order('created_at');
      if (error) return jsonResponse(500, { error: 'Failed to load courses' }, event);

      return jsonResponse(200, {
        courses: courses || [],
        viewMode: role === 'guardian' ? 'full' : 'standard',
        isParentViewingMode: role === 'guardian',
      }, event);
    }

    // ── GET /guardian-lesson/:id — STRICTLY blocks players ───────
    if (rawPath.startsWith('/guardian-lesson/')) {
      const lessonId = rawPath.split('/')[2];
      if (!lessonId) return jsonResponse(400, { error: 'Lesson ID required' }, event);

      // This is the critical player block
      const blockCheck = await blockPlayersFromGuardianCourse(event);
      if (blockCheck.error) {
        return jsonResponse(blockCheck.status, {
          error: blockCheck.error,
          code: blockCheck.code || 'GUARDIAN_ONLY_CONTENT',
          message: 'This lesson is exclusively for Academy Guardians. Please visit the standard Education Hub for your courses.',
        }, event);
      }

      const { data: lesson, error } = await supabase
        .from('lessons')
        .select('*, courses!inner(id, title, is_guardian_only)')
        .eq('id', lessonId)
        .single();

      if (error || !lesson) return jsonResponse(404, { error: 'Lesson not found' }, event);
      if (!lesson.courses?.is_guardian_only)
        return jsonResponse(400, { error: 'Use the standard lesson endpoint for non-guardian courses' }, event);

      return jsonResponse(200, { lesson }, event);
    }

    // ── GET /courses/:id — Single course ─────────────────────────
    if (rawPath.startsWith('/courses/')) {
      const courseId = rawPath.split('/')[2];
      if (!courseId) return jsonResponse(400, { error: 'Course ID required' }, event);

      const { data: course, error } = await supabase
        .from('courses')
        .select('*, lessons(*)').eq('id', courseId).single();

      if (error || !course) return jsonResponse(404, { error: 'Course not found' }, event);

      // Block players/coaches from guardian-only courses
      if (course.is_guardian_only && (role === 'player' || role === 'coach')) {
        return jsonResponse(403, {
          error: 'Access denied. This course is exclusively for Olufunke FA Guardians.',
          code: 'GUARDIAN_ONLY_CONTENT',
        }, event);
      }

      return jsonResponse(200, { course }, event);
    }

    return jsonResponse(404, { error: 'Education endpoint not found' }, event);

  } catch (err) {
    console.error('Education API error:', err);
    return jsonResponse(500, { error: 'Internal server error' }, event);
  }
};
