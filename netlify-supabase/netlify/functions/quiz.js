/**
 * Netlify Function: quiz.js
 * ──────────────────────────
 * Handles quiz questions, submissions and leaderboard via Supabase.
 *
 * Endpoints:
 *   GET  ?active=true       → get the currently active quiz week
 *   GET  ?week=<number>     → get quiz questions for a specific week number
 *   POST (body: {week_id, answers[], guest_name?}) → submit answers (guests allowed)
 *   GET  ?leaderboard=true  → top 10 scores
 */

const { createClient } = require('@supabase/supabase-js');

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

function json(statusCode, body) {
  return {
    statusCode,
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': process.env.NEXT_PUBLIC_SITE_URL || '*',
    },
    body: JSON.stringify(body),
  };
}

exports.handler = async (event) => {
  if (event.httpMethod === 'OPTIONS') {
    return { statusCode: 204, headers: { 'Access-Control-Allow-Origin': '*' }, body: '' };
  }

  const { week, active, leaderboard } = event.queryStringParameters || {};

  try {
    // ── GET leaderboard ─────────────────────────────────────────
    if (event.httpMethod === 'GET' && leaderboard === 'true') {
      const { data, error } = await supabase
        .from('quiz_attempts')
        .select('score, completed_at, profiles(full_name)')
        .order('score', { ascending: false })
        .limit(10);

      if (error) throw error;
      return json(200, { leaderboard: data });
    }

    // ── GET active quiz week ────────────────────────────────────
    if (event.httpMethod === 'GET' && active === 'true') {
      const { data: quizWeek, error: weekError } = await supabase
        .from('quiz_weeks')
        .select('id, title, description, week_number')
        .eq('is_active', true)
        .order('week_number', { ascending: false })
        .limit(1)
        .single();

      if (weekError || !quizWeek) {
        return json(404, { error: 'No active quiz week found' });
      }

      return await getQuestionsForWeek(quizWeek);
    }

    // ── GET questions for a specific week number ────────────────
    if (event.httpMethod === 'GET') {
      const weekNumber = parseInt(week) || 1;

      const { data: quizWeek, error: weekError } = await supabase
        .from('quiz_weeks')
        .select('id, title, description, week_number')
        .eq('week_number', weekNumber)
        .single();

      if (weekError || !quizWeek) {
        return json(404, { error: 'Quiz week not found' });
      }

      return await getQuestionsForWeek(quizWeek);
    }

    // ── POST — Submit answers (guests allowed) ──────────────────
    if (event.httpMethod === 'POST') {
      const user = await getAuthUser(event);
      const body = JSON.parse(event.body || '{}');
      const { week_id, answers, guest_name } = body;

      if (!week_id || !Array.isArray(answers)) {
        return json(400, { error: 'week_id and answers array are required' });
      }

      // Require either a logged-in user or a guest name
      if (!user && !guest_name) {
        return json(400, { error: 'Please provide your name to submit as a guest.' });
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
          return json(409, { error: 'You have already attempted this quiz. Only one attempt per quiz week.' });
        }
      }

      // Fetch correct answers
      const { data: correctOptions, error: coError } = await supabase
        .from('quiz_options')
        .select('id, question_id, is_correct')
        .in('question_id', answers.map((a) => a.question_id));

      if (coError) throw coError;

      // Score calculation
      let score = 0;
      answers.forEach(({ question_id, selected_option_id }) => {
        const correct = correctOptions.find(
          (o) => o.question_id === question_id && o.is_correct
        );
        if (correct && correct.id === selected_option_id) score++;
      });

      // Save attempt
      const insertData = {
        quiz_week_id:     week_id,
        score,
        total_questions:  answers.length,
        answers:          answers,
        completed_at:     new Date().toISOString(),
      };

      if (user) {
        insertData.user_id = user.id;
      } else {
        insertData.guest_name = guest_name;
      }

      const { data: attempt, error: attemptError } = await supabase
        .from('quiz_attempts')
        .insert([insertData])
        .select()
        .single();

      if (attemptError) throw attemptError;

      return json(201, {
        message: 'Quiz submitted successfully!',
        score,
        total:   answers.length,
        attempt,
      });
    }

    return json(405, { error: 'Method not allowed' });

  } catch (err) {
    console.error('[quiz function]', err);
    return json(500, { error: 'Internal server error', detail: err.message });
  }
};

// ── Helper: fetch questions for a quiz week ─────────────────────────────────
async function getQuestionsForWeek(quizWeek) {
  const { data: questions, error: qError } = await supabase
    .from('quiz_questions')
    .select(`
      id,
      question_text,
      quiz_options ( id, option_text )
    `)
    .eq('quiz_week_id', quizWeek.id)
    .order('order');

  if (qError) throw qError;

  // Strip correct_answer flags from public response (scored server-side on submit)
  return {
    statusCode: 200,
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': process.env.NEXT_PUBLIC_SITE_URL || '*',
    },
    body: JSON.stringify({ quiz: quizWeek, questions }),
  };
}
