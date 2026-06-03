/**
 * Netlify Function: quiz.js
 * ──────────────────────────
 * Handles quiz questions, submissions and leaderboard via Supabase.
 *
 * Endpoints:
 *   GET  ?week=<number>       → get quiz questions for a week
 *   POST (body: {answers[]})  → submit quiz answers, save attempt
 *   GET  ?leaderboard=true    → top 10 scores
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
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body),
  };
}

exports.handler = async (event) => {
  const { week, leaderboard } = event.queryStringParameters || {};

  try {
    // ── GET leaderboard ─────────────────────────────────────────
    if (event.httpMethod === 'GET' && leaderboard === 'true') {
      const { data, error } = await supabase
        .from('quiz_attempts')
        .select('score, completed_at, users(email)')
        .order('score', { ascending: false })
        .limit(10);

      if (error) throw error;
      return json(200, { leaderboard: data });
    }

    // ── GET questions for a week ─────────────────────────────────
    if (event.httpMethod === 'GET') {
      const weekNumber = parseInt(week) || 1;

      const { data: quizWeek, error: weekError } = await supabase
        .from('quiz_weeks')
        .select('id, title, week_number')
        .eq('week_number', weekNumber)
        .single();

      if (weekError) return json(404, { error: 'Quiz week not found' });

      const { data: questions, error: qError } = await supabase
        .from('quiz_questions')
        .select(`
          id,
          question_text,
          quiz_options ( id, option_text )
        `)
        .eq('quiz_week_id', quizWeek.id)
        .order('id');

      if (qError) throw qError;

      // Strip correct_answer from public response
      return json(200, { quiz: quizWeek, questions });
    }

    // ── POST — Submit answers ───────────────────────────────────
    if (event.httpMethod === 'POST') {
      const user = await getAuthUser(event);
      if (!user) return json(401, { error: 'You must be logged in to submit a quiz' });

      const body = JSON.parse(event.body || '{}');
      const { week_id, answers } = body;

      if (!week_id || !Array.isArray(answers)) {
        return json(400, { error: 'week_id and answers array are required' });
      }

      // Check for duplicate attempt
      const { data: existing } = await supabase
        .from('quiz_attempts')
        .select('id')
        .eq('user_id', user.id)
        .eq('quiz_week_id', week_id)
        .single();

      if (existing) {
        return json(409, { error: 'You have already attempted this quiz' });
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
      const { data: attempt, error: attemptError } = await supabase
        .from('quiz_attempts')
        .insert([{
          user_id: user.id,
          quiz_week_id: week_id,
          score,
          total_questions: answers.length,
          answers_json: answers,
        }])
        .select()
        .single();

      if (attemptError) throw attemptError;

      return json(201, {
        message: 'Quiz submitted successfully',
        score,
        total: answers.length,
        attempt,
      });
    }

    return json(405, { error: 'Method not allowed' });

  } catch (err) {
    console.error('[quiz function]', err);
    return json(500, { error: 'Internal server error', detail: err.message });
  }
};
