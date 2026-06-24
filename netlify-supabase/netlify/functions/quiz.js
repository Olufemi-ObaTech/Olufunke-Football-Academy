/**
 * Netlify Function: quiz.js
 * ──────────────────────────
 * Handles quiz questions, submissions and leaderboard via Supabase.
 * Secured with rate limiting, input sanitization, CORS validation.
 *
 * Endpoints:
 *   GET  ?active=true       → get the currently active quiz week
 *   GET  ?week=<number>     → get quiz questions for a specific week number
 *   POST (body: {week_id, answers[], guest_name?}) → submit answers
 *   GET  ?leaderboard=true  → top 10 scores
 */

const { createClient } = require('@supabase/supabase-js');
const {
  rateLimit, handleCors, jsonResponse, rateLimitedResponse,
  sanitize, parseBody, getClientIp,
} = require('./_shared/security');

const supabase = createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

async function getAuthUser(event) {
  const token = (event.headers['authorization'] || '').replace('Bearer ', '').trim();
  if (!token) return null;
  const { data, error } = await supabase.auth.getUser(token);
  return error ? null : data.user;
}

exports.handler = async (event) => {
  // ── CORS preflight ──────────────────────────────────────────
  const cors = handleCors(event);
  if (cors) return cors;

  const ip = getClientIp(event);
  const { week, active, leaderboard } = event.queryStringParameters || {};

  try {
    // ── GET leaderboard (rate: 30/min) ──────────────────────────
    if (event.httpMethod === 'GET' && leaderboard === 'true') {
      const rl = rateLimit(ip, 'quiz-read', 30, 60000);
      if (!rl.allowed) return rateLimitedResponse(event, rl.retryAfter);

      const { data, error } = await supabase
        .from('quiz_attempts')
        .select('score, completed_at, profiles(full_name)')
        .order('score', { ascending: false })
        .limit(10);

      if (error) throw error;
      return jsonResponse(200, { leaderboard: data }, event);
    }

    // ── GET active quiz week (rate: 30/min) ─────────────────────
    if (event.httpMethod === 'GET' && active === 'true') {
      const rl = rateLimit(ip, 'quiz-read', 30, 60000);
      if (!rl.allowed) return rateLimitedResponse(event, rl.retryAfter);

      const { data: quizWeek, error: weekError } = await supabase
        .from('quiz_weeks')
        .select('id, title, description, week_number')
        .eq('is_active', true)
        .order('week_number', { ascending: false })
        .limit(1)
        .single();

      if (weekError || !quizWeek) {
        return jsonResponse(404, { error: 'No active quiz week found' }, event);
      }

      return await getQuestionsForWeek(quizWeek, event);
    }

    // ── GET questions for a specific week number (rate: 30/min) ──
    if (event.httpMethod === 'GET') {
      const rl = rateLimit(ip, 'quiz-read', 30, 60000);
      if (!rl.allowed) return rateLimitedResponse(event, rl.retryAfter);

      const weekNumber = parseInt(week) || 1;
      if (weekNumber < 1 || weekNumber > 999) {
        return jsonResponse(400, { error: 'Invalid week number' }, event);
      }

      const { data: quizWeek, error: weekError } = await supabase
        .from('quiz_weeks')
        .select('id, title, description, week_number')
        .eq('week_number', weekNumber)
        .single();

      if (weekError || !quizWeek) {
        return jsonResponse(404, { error: 'Quiz week not found' }, event);
      }

      return await getQuestionsForWeek(quizWeek, event);
    }

    // ── POST — Submit answers (rate: 3/min) ─────────────────────
    if (event.httpMethod === 'POST') {
      const rl = rateLimit(ip, 'quiz-submit', 3, 60000);
      if (!rl.allowed) return rateLimitedResponse(event, rl.retryAfter);

      const user = await getAuthUser(event);
      const raw = parseBody(event);
      if (!raw) return jsonResponse(400, { error: 'Invalid request body' }, event);

      const { week_id, answers, guest_name } = raw;
      const cleanGuestName = guest_name ? sanitize(guest_name).slice(0, 50) : null;

      if (!week_id || !Array.isArray(answers)) {
        return jsonResponse(400, { error: 'week_id and answers array are required' }, event);
      }

      if (answers.length > 100) {
        return jsonResponse(400, { error: 'Too many answers submitted' }, event);
      }

      // Require either a logged-in user or a guest name
      if (!user && !cleanGuestName) {
        return jsonResponse(400, { error: 'Please provide your name to submit as a guest.' }, event);
      }

      // Check for duplicate attempt (logged-in users only)
      if (user) {
        const { data: existing } = await supabase
          .from('quiz_attempts')
          .select('id')
          .eq('user_id', user.id)
          .eq('quiz_week_id', week_id)
          .single();

        if (existing) {
          return jsonResponse(409, {
            error: 'You have already attempted this quiz. Only one attempt per quiz week.',
          }, event);
        }
      }

      // Fetch correct answers
      const questionIds = answers
        .map((a) => a.question_id)
        .filter((id) => typeof id === 'string' || typeof id === 'number');

      const { data: correctOptions, error: coError } = await supabase
        .from('quiz_options')
        .select('id, quiz_question_id, is_correct')
        .in('quiz_question_id', questionIds);

      if (coError) throw coError;

      // Score calculation
      let score = 0;
      answers.forEach(({ question_id, selected_option_id }) => {
        const correct = correctOptions.find(
          (o) => o.quiz_question_id === question_id && o.is_correct
        );
        if (correct && correct.id === selected_option_id) score++;
      });

      // Save attempt
      const insertData = {
        quiz_week_id: week_id,
        score,
        total_questions: answers.length,
        answers: answers,
        completed_at: new Date().toISOString(),
      };

      if (user) {
        insertData.user_id = user.id;
      } else {
        insertData.guest_name = cleanGuestName;
      }

      const { data: attempt, error: attemptError } = await supabase
        .from('quiz_attempts')
        .insert([insertData])
        .select()
        .single();

      if (attemptError) throw attemptError;

      return jsonResponse(201, {
        message: 'Quiz submitted successfully!',
        score,
        total: answers.length,
        attempt,
      }, event);
    }

    return jsonResponse(405, { error: 'Method not allowed' }, event);

  } catch (err) {
    console.error('[quiz function]', err);
    return jsonResponse(500, { error: 'Internal server error' }, event);
  }
};

// ── Helper: fetch questions for a quiz week ─────────────────────
async function getQuestionsForWeek(quizWeek, event) {
  const { data: questions, error: qError } = await supabase
    .from('quiz_questions')
    .select(`
      id,
      question,
      quiz_options ( id, option_text )
    `)
    .eq('quiz_week_id', quizWeek.id)
    .order('order');

  if (qError) throw qError;

  return jsonResponse(200, { quiz: quizWeek, questions }, event);
}
