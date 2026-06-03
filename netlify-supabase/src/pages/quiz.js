/**
 * pages/quiz.js — Weekly Quiz Page
 * Fetches questions from the Netlify /quiz function and submits answers.
 */

import { useState, useEffect } from 'react';
import { useSession } from '@supabase/auth-helpers-react';
import { fetchQuiz, submitQuiz, fetchLeaderboard } from '../lib/api';

export default function QuizPage() {
  const session = useSession();

  const [quiz,        setQuiz]        = useState(null);
  const [questions,   setQuestions]   = useState([]);
  const [answers,     setAnswers]     = useState({});  // { questionId: optionId }
  const [result,      setResult]      = useState(null);
  const [leaderboard, setLeaderboard] = useState([]);
  const [loading,     setLoading]     = useState(true);
  const [submitting,  setSubmitting]  = useState(false);
  const [error,       setError]       = useState('');

  useEffect(() => {
    async function load() {
      try {
        const [quizData, lbData] = await Promise.all([
          fetchQuiz(1),
          fetchLeaderboard(),
        ]);
        setQuiz(quizData.quiz);
        setQuestions(quizData.questions || []);
        setLeaderboard(lbData.leaderboard || []);
      } catch (err) {
        setError('Failed to load quiz. Please try again.');
      } finally {
        setLoading(false);
      }
    }
    load();
  }, []);

  const handleSelect = (questionId, optionId) => {
    setAnswers((prev) => ({ ...prev, [questionId]: optionId }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!session) {
      setError('You must be logged in to submit the quiz.');
      return;
    }

    const unanswered = questions.filter((q) => !answers[q.id]);
    if (unanswered.length > 0) {
      setError('Please answer all questions before submitting.');
      return;
    }

    setSubmitting(true);
    setError('');

    try {
      const formattedAnswers = Object.entries(answers).map(([question_id, selected_option_id]) => ({
        question_id,
        selected_option_id,
      }));

      const res = await submitQuiz(quiz.id, formattedAnswers);
      setResult(res);
    } catch (err) {
      setError(err.message);
    } finally {
      setSubmitting(false);
    }
  };

  if (loading) return <p style={{ fontFamily: 'sans-serif', padding: 24 }}>Loading quiz...</p>;

  return (
    <main style={{ fontFamily: 'sans-serif', maxWidth: 700, margin: '0 auto', padding: 24 }}>
      <h1>⚽ Weekly Quiz</h1>

      {quiz && <h2>{quiz.title}</h2>}

      {error && <p style={{ color: 'red' }}>⚠ {error}</p>}

      {/* ── Result screen ───────────────────────────────────── */}
      {result ? (
        <div style={{ background: '#f0fff4', border: '2px solid #38a169', borderRadius: 8, padding: 24, textAlign: 'center' }}>
          <h3>Quiz Complete!</h3>
          <p style={{ fontSize: 48, fontWeight: 'bold', color: '#38a169' }}>
            {result.score} / {result.total}
          </p>
          <p>{result.message}</p>
          <a href="/dashboard" style={{ color: '#0070f3' }}>View your dashboard →</a>
        </div>
      ) : (
        /* ── Quiz form ──────────────────────────────────────── */
        <form onSubmit={handleSubmit}>
          {questions.map((q, qIndex) => (
            <div key={q.id} style={{ marginBottom: 28, padding: 20, border: '1px solid #e2e8f0', borderRadius: 8 }}>
              <p style={{ fontWeight: 'bold', marginBottom: 12 }}>
                {qIndex + 1}. {q.question_text}
              </p>
              {(q.quiz_options || []).map((opt) => (
                <label
                  key={opt.id}
                  style={{
                    display: 'flex',
                    alignItems: 'center',
                    gap: 10,
                    padding: '8px 12px',
                    marginBottom: 6,
                    borderRadius: 6,
                    cursor: 'pointer',
                    background: answers[q.id] === opt.id ? '#ebf8ff' : 'transparent',
                    border: `1px solid ${answers[q.id] === opt.id ? '#0070f3' : '#e2e8f0'}`,
                  }}
                >
                  <input
                    type="radio"
                    name={q.id}
                    value={opt.id}
                    checked={answers[q.id] === opt.id}
                    onChange={() => handleSelect(q.id, opt.id)}
                  />
                  {opt.option_text}
                </label>
              ))}
            </div>
          ))}

          {!session && (
            <p style={{ color: '#d69e2e', marginBottom: 12 }}>
              ⚠ <a href="/login">Login</a> to submit your answers and save your score.
            </p>
          )}

          <button
            type="submit"
            disabled={submitting || !session}
            style={{
              padding: '12px 24px',
              background: session ? '#0070f3' : '#cbd5e0',
              color: '#fff',
              border: 'none',
              borderRadius: 6,
              fontSize: 16,
              cursor: session ? 'pointer' : 'not-allowed',
            }}
          >
            {submitting ? 'Submitting...' : 'Submit Answers'}
          </button>
        </form>
      )}

      {/* ── Leaderboard ──────────────────────────────────────── */}
      {leaderboard.length > 0 && (
        <section style={{ marginTop: 48 }}>
          <h2>🏆 Leaderboard</h2>
          <ol>
            {leaderboard.map((entry, i) => (
              <li key={i} style={{ padding: '6px 0', borderBottom: '1px solid #eee' }}>
                {entry.users?.email} — <strong>{entry.score}</strong> pts
              </li>
            ))}
          </ol>
        </section>
      )}
    </main>
  );
}
