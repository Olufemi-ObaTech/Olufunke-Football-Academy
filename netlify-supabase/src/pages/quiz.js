/**
 * pages/quiz.js — Weekly Football IQ Quiz
 * Fetches the active quiz week (not hardcoded week 1).
 * Allows guest submissions — no login required to play.
 */

import { useState, useEffect } from 'react';
import Head from 'next/head';
import { useSession } from '@supabase/auth-helpers-react';
import { fetchQuiz, submitQuiz, fetchLeaderboard } from '../lib/api';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';

export default function QuizPage() {
  const session = useSession();

  const [quiz,        setQuiz]        = useState(null);
  const [questions,   setQuestions]   = useState([]);
  const [answers,     setAnswers]     = useState({});  // { questionId: optionId }
  const [guestName,   setGuestName]   = useState('');
  const [result,      setResult]      = useState(null);
  const [leaderboard, setLeaderboard] = useState([]);
  const [loading,     setLoading]     = useState(true);
  const [submitting,  setSubmitting]  = useState(false);
  const [error,       setError]       = useState('');

  useEffect(() => {
    async function load() {
      try {
        // Fetch active week (week=0 tells the API to use is_active=true)
        const [quizData, lbData] = await Promise.all([
          fetchActiveQuiz(),
          fetchLeaderboard(),
        ]);
        setQuiz(quizData.quiz);
        setQuestions(quizData.questions || []);
        setLeaderboard(lbData.leaderboard || []);
      } catch (err) {
        setError('Failed to load quiz. Please try again later.');
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

    // Guest name required if not logged in
    if (!session && !guestName.trim()) {
      setError('Please enter your name to submit as a guest.');
      return;
    }

    const unanswered = questions.filter((q) => !answers[q.id]);
    if (unanswered.length > 0) {
      setError(`Please answer all ${questions.length} questions before submitting.`);
      return;
    }

    setSubmitting(true);
    setError('');

    try {
      const formattedAnswers = Object.entries(answers).map(([question_id, selected_option_id]) => ({
        question_id,
        selected_option_id,
      }));

      const res = await submitQuiz(quiz.id, formattedAnswers, guestName.trim() || null);
      setResult(res);
    } catch (err) {
      setError(err.message || 'Submission failed. Please try again.');
    } finally {
      setSubmitting(false);
    }
  };

  if (loading) {
    return (
      <>
        <NavBar active="quiz" />
        <p style={{ fontFamily: 'sans-serif', padding: 24, textAlign: 'center' }}>
          Loading quiz…
        </p>
      </>
    );
  }

  if (!quiz) {
    return (
      <>
        <Head><title>Football IQ Quiz | OFA</title></Head>
        <NavBar active="quiz" />
        <main style={{ fontFamily: 'sans-serif', maxWidth: 700, margin: '0 auto', padding: 24, textAlign: 'center' }}>
          <h1>⚽ Weekly Football IQ Quiz</h1>
          <p style={{ color: '#666', marginTop: 24 }}>No active quiz this week. Check back soon!</p>
        </main>
        <Footer />
      </>
    );
  }

  return (
    <>
      <Head><title>Football IQ Quiz | OFA</title></Head>
      <NavBar active="quiz" />

      {/* Hero */}
      <section className="py-4 text-white text-center" style={{ background: 'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)' }}>
        <div className="container">
          <h1 className="fw-bold">⚽ Weekly Football IQ Quiz</h1>
          <p className="lead opacity-75 mb-0">Test your football knowledge — anyone can play, no login required!</p>
        </div>
      </section>

      <main className="container py-5" style={{ maxWidth: 760 }}>
        <h2 className="fw-bold mb-1" style={{ color: '#10316B' }}>{quiz.title}</h2>
        {quiz.description && <p className="text-muted mb-4">{quiz.description}</p>}

        {error && (
          <div className="alert alert-danger">
            <i className="bi bi-exclamation-triangle-fill me-2"></i>{error}
          </div>
        )}

        {/* ── Result screen ─────────────────────────────────────── */}
        {result ? (
          <div className="p-4 rounded-3 text-center shadow" style={{ background: '#f0fff4', border: '2px solid #38a169' }}>
            <h3 className="fw-bold">Quiz Complete! 🎉</h3>
            <p style={{ fontSize: 64, fontWeight: 'bold', color: '#38a169', margin: '12px 0' }}>
              {result.score} / {result.total}
            </p>
            <p className="text-muted">{result.message}</p>
            {session ? (
              <a href="/dashboard" className="btn btn-primary mt-2">View your dashboard →</a>
            ) : (
              <a href="/login" className="btn btn-outline-primary mt-2">Login to track your scores →</a>
            )}
          </div>
        ) : (
          /* ── Quiz form ──────────────────────────────────────────── */
          <form onSubmit={handleSubmit}>
            {/* Guest name field */}
            {!session && (
              <div className="mb-4 p-3 bg-light rounded-3">
                <label className="form-label fw-semibold">
                  Your Name <span className="text-danger">*</span>
                  <small className="text-muted ms-2">(shown on leaderboard)</small>
                </label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Enter your name"
                  value={guestName}
                  onChange={(e) => setGuestName(e.target.value)}
                  maxLength={60}
                  required
                />
                <small className="text-muted">
                  <a href="/login">Login</a> to track your score history.
                </small>
              </div>
            )}

            {questions.map((q, qIndex) => (
              <div
                key={q.id}
                className="mb-4 p-4 rounded-3"
                style={{ border: '1px solid #e2e8f0', background: '#fff' }}
              >
                <p className="fw-bold mb-3">
                  {qIndex + 1}. {q.question_text}
                </p>
                {(q.quiz_options || []).map((opt) => (
                  <label
                    key={opt.id}
                    className="d-flex align-items-center gap-2 p-2 mb-2 rounded-2"
                    style={{
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

            <button
              type="submit"
              disabled={submitting}
              className="btn btn-success btn-lg w-100 fw-bold"
            >
              {submitting ? 'Submitting…' : 'Submit Answers'}
            </button>
          </form>
        )}

        {/* ── Leaderboard ──────────────────────────────────────── */}
        {leaderboard.length > 0 && (
          <section className="mt-5">
            <h2 className="fw-bold" style={{ color: '#10316B' }}>🏆 Leaderboard</h2>
            <div className="table-responsive">
              <table className="table table-sm table-hover align-middle">
                <thead style={{ background: '#10316B', color: '#fff' }}>
                  <tr>
                    <th>#</th>
                    <th>Player</th>
                    <th className="text-center">Score</th>
                  </tr>
                </thead>
                <tbody>
                  {leaderboard.map((entry, i) => (
                    <tr key={i}>
                      <td className="fw-bold">{i + 1}</td>
                      <td>{entry.profiles?.full_name || 'Anonymous'}</td>
                      <td className="text-center fw-bold">{entry.score}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </section>
        )}
      </main>

      <Footer />
    </>
  );
}

// ── Fetch the active quiz week from Netlify function ─────────────────────────
async function fetchActiveQuiz() {
  const BASE = process.env.NODE_ENV === 'development'
    ? 'http://localhost:8888/.netlify/functions'
    : '/.netlify/functions';

  // First try to get active week
  const res = await fetch(`${BASE}/quiz?active=true`);
  if (res.ok) return res.json();

  // Fallback: get week 1
  const fallback = await fetch(`${BASE}/quiz?week=1`);
  if (!fallback.ok) throw new Error('No quiz available');
  return fallback.json();
}
