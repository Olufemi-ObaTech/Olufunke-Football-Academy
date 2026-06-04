import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import NavBar from '../../../components/NavBar';
import Footer from '../../../components/Footer';
import { supabase } from '../../../lib/supabaseClient';

function iqRating(pct) {
  if (pct >= 90) return { label: '🧠 Football Genius', color: 'success' };
  if (pct >= 75) return { label: '⭐ Expert Analyst',   color: 'primary' };
  if (pct >= 60) return { label: '🎯 Tactical Thinker', color: 'info'    };
  if (pct >= 40) return { label: '⚽ Solid Fan',        color: 'warning' };
  return               { label: '📚 Keep Learning',    color: 'secondary'};
}
function iqEmoji(pct) {
  if (pct >= 90) return '🧠';
  if (pct >= 75) return '⭐';
  if (pct >= 60) return '🎯';
  if (pct >= 40) return '⚽';
  return '📚';
}

export default function QuizResult() {
  const router = useRouter();
  const { id } = router.query;

  const [attempt,       setAttempt]       = useState(null);
  const [quiz,          setQuiz]          = useState(null);
  const [questions,     setQuestions]     = useState([]);
  const [leaderboard,   setLeaderboard]   = useState([]);
  const [rank,          setRank]          = useState(null);
  const [totalAttempts, setTotalAttempts] = useState(0);
  const [loading,       setLoading]       = useState(true);

  useEffect(() => {
    if (!id) return;
    async function load() {
      // Load attempt
      const { data: att } = await supabase
        .from('quiz_attempts').select('*').eq('id', id).single();
      if (!att) { router.push('/quiz'); return; }
      setAttempt(att);

      // Load quiz week
      const { data: qw } = await supabase
        .from('quiz_weeks').select('*').eq('id', att.quiz_week_id).single();
      setQuiz(qw);

      // Load only the questions that were in this attempt
      const answeredIds = Object.keys(att.answers || {}).map(Number);
      if (answeredIds.length > 0) {
        const { data: qs } = await supabase
          .from('quiz_questions')
          .select('*, quiz_options(*)')
          .in('id', answeredIds);
        setQuestions(qs || []);
      }

      // Leaderboard top 10
      const { data: lb } = await supabase
        .from('quiz_attempts')
        .select('id, score, total_questions, time_taken, guest_name, user_id')
        .eq('quiz_week_id', att.quiz_week_id)
        .order('score', { ascending: false })
        .order('time_taken', { ascending: true })
        .limit(10);
      setLeaderboard(lb || []);

      // Rank
      const { count } = await supabase
        .from('quiz_attempts')
        .select('id', { count: 'exact', head: true })
        .eq('quiz_week_id', att.quiz_week_id)
        .or(`score.gt.${att.score}`);
      setRank((count || 0) + 1);

      const { count: total } = await supabase
        .from('quiz_attempts')
        .select('id', { count: 'exact', head: true })
        .eq('quiz_week_id', att.quiz_week_id);
      setTotalAttempts(total || 0);

      setLoading(false);
    }
    load();
  }, [id]);

  if (loading) return <><NavBar active="quiz" /><div className="container py-5 text-center"><p>Loading result…</p></div><Footer /></>;
  if (!attempt || !quiz) return null;

  const percentage = attempt.total_questions > 0
    ? Math.round((attempt.score / attempt.total_questions) * 100) : 0;
  const { label: iqLabel, color: iqColor } = iqRating(percentage);

  return (
    <>
      <Head><title>Quiz Result — {quiz.title}</title></Head>
      <NavBar active="quiz" />

      {/* Hero */}
      <section className="py-5 text-white text-center" style={{ background: 'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)' }}>
        <div className="container">
          <div style={{ fontSize: '4rem' }} className="mb-2">{iqEmoji(percentage)}</div>
          <h1 className="fw-bold display-5 mb-2">{iqLabel}</h1>
          <div className="display-3 fw-bold mb-1">
            {attempt.score}<span className="fs-3 opacity-75">/{attempt.total_questions}</span>
          </div>
          <div className="fs-4 mb-3 opacity-90">{percentage}% Correct</div>
          <div className="d-flex justify-content-center gap-3 flex-wrap">
            <span className="badge bg-white text-dark fs-6 px-3 py-2">
              <i className="bi bi-trophy-fill me-1 text-warning"></i>Rank #{rank} of {totalAttempts}
            </span>
            {attempt.time_taken && (
              <span className="badge bg-white text-dark fs-6 px-3 py-2">
                <i className="bi bi-clock me-1 text-primary"></i>
                {Math.floor(attempt.time_taken / 60)}m {attempt.time_taken % 60}s
              </span>
            )}
            <span className={`badge bg-${iqColor} fs-6 px-3 py-2`}>{iqLabel}</span>
          </div>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row g-4">

            {/* Answer Review */}
            <div className="col-lg-8">
              <h4 className="fw-bold mb-4" style={{ color: '#10316B' }}>
                <i className="bi bi-clipboard-check me-2"></i>Answer Review
              </h4>

              {questions.map((q, qIdx) => {
                const answerData  = (attempt.answers || {})[q.id];
                const selectedId  = answerData?.selected  ? Number(answerData.selected)  : null;
                const correctId   = answerData?.correct   ? Number(answerData.correct)   : null;
                const isCorrect   = answerData?.is_correct || false;
                const opts = (q.quiz_options || []).sort((a,b)=>(a.order||0)-(b.order||0));

                return (
                  <div key={q.id} className="card border-0 shadow-sm rounded-3 mb-3"
                    style={{ borderLeft: `4px solid ${isCorrect ? '#4CAF50' : '#dc3545'}` }}>
                    <div className="card-body p-4">
                      <div className="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <span className="text-muted small fw-semibold">Question {qIdx + 1}</span>
                        <div className="d-flex gap-2">
                          <span className={`badge bg-${isCorrect ? 'success' : 'danger'}`}>
                            <i className={`bi bi-${isCorrect ? 'check' : 'x'}-circle-fill me-1`}></i>
                            {isCorrect ? 'Correct' : 'Incorrect'}
                          </span>
                          {q.difficulty && (
                            <span className="badge bg-light text-dark border">{q.difficulty}</span>
                          )}
                        </div>
                      </div>

                      <h6 className="fw-bold mb-3" style={{ color: '#10316B' }}>{q.question}</h6>

                      <div className="row g-2">
                        {opts.map(opt => {
                          const isSel  = selectedId === opt.id;
                          const isCorr = opt.is_correct;
                          return (
                            <div className="col-md-6" key={opt.id}>
                              <div className={`p-3 rounded-3 border d-flex align-items-center gap-2
                                ${isCorr ? 'border-success bg-success bg-opacity-10' :
                                  isSel && !isCorr ? 'border-danger bg-danger bg-opacity-10' : ''}`}>
                                <i className={`bi bi-${isCorr ? 'check-circle-fill text-success' : isSel ? 'x-circle-fill text-danger' : 'circle text-muted'} flex-shrink-0`}></i>
                                <span className={isCorr ? 'fw-semibold text-success' : isSel ? 'text-danger' : 'text-muted'}>
                                  {opt.option_text}
                                </span>
                                {isSel && !isCorr && <span className="badge bg-danger ms-auto">Your answer</span>}
                                {isCorr && isSel   && <span className="badge bg-success ms-auto">Your answer ✓</span>}
                                {isCorr && !isSel  && <span className="badge bg-success ms-auto">Correct answer</span>}
                              </div>
                            </div>
                          );
                        })}
                      </div>

                      {!selectedId && (
                        <div className="mt-2 small text-warning">
                          <i className="bi bi-dash-circle me-1"></i>You skipped this question.
                        </div>
                      )}

                      {q.explanation && (
                        <div className="mt-3 p-3 rounded-3 bg-light border-start border-4 border-primary">
                          <small className="fw-bold text-primary"><i className="bi bi-lightbulb-fill me-1"></i>Explanation:</small>
                          <p className="mb-0 small mt-1">{q.explanation}</p>
                        </div>
                      )}
                    </div>
                  </div>
                );
              })}

              <div className="mt-4 d-flex gap-3 flex-wrap">
                <Link href="/quiz" className="btn btn-outline-secondary">
                  <i className="bi bi-arrow-left me-1"></i>All Quizzes
                </Link>
                <Link href={`/quiz/${quiz.id}`} className="btn btn-primary">
                  <i className="bi bi-bar-chart-fill me-1"></i>Full Leaderboard
                </Link>
              </div>
            </div>

            {/* Sidebar */}
            <div className="col-lg-4">
              {/* Score card */}
              <div className="card border-0 shadow rounded-3 mb-4 text-center" style={{ borderTop: '4px solid #4CAF50' }}>
                <div className="card-body p-4">
                  <div style={{ fontSize: '3rem' }}>{iqEmoji(percentage)}</div>
                  <h5 className="fw-bold mt-2" style={{ color: '#10316B' }}>
                    {attempt.guest_name || 'You'}
                  </h5>
                  <div className="display-4 fw-bold" style={{ color: '#4CAF50' }}>
                    {attempt.score}<span className="fs-5 text-muted">/{attempt.total_questions}</span>
                  </div>
                  <div className="progress my-3" style={{ height: 12 }}>
                    <div className={`progress-bar bg-${iqColor}`} style={{ width: `${percentage}%`, borderRadius: 6 }}></div>
                  </div>
                  <span className={`badge bg-${iqColor} fs-6 px-3 py-2`}>{iqLabel}</span>
                  <div className="mt-3 text-muted small">
                    <div><i className="bi bi-trophy me-1 text-warning"></i>Rank <strong>#{rank}</strong> of {totalAttempts}</div>
                    {attempt.time_taken && (
                      <div className="mt-1"><i className="bi bi-clock me-1 text-primary"></i>
                        {Math.floor(attempt.time_taken/60)}m {attempt.time_taken%60}s
                      </div>
                    )}
                  </div>
                </div>
              </div>

              {/* Mini Leaderboard */}
              <div className="card border-0 shadow-sm rounded-3 mb-4">
                <div className="card-header fw-bold py-3" style={{ background: '#10316B', color: '#fff' }}>
                  <i className="bi bi-trophy-fill me-2 text-warning"></i>Top 10
                </div>
                <div className="card-body p-0">
                  {leaderboard.map((lb, i) => (
                    <div key={lb.id} className={`d-flex align-items-center gap-2 px-3 py-2 border-bottom${lb.id === attempt.id ? ' bg-warning bg-opacity-25' : ''}`}>
                      <span className="fw-bold" style={{ width: 28 }}>
                        {i===0?'🥇':i===1?'🥈':i===2?'🥉':<span className="text-muted small">#{i+1}</span>}
                      </span>
                      <span className="flex-grow-1 small fw-semibold text-truncate">
                        {lb.guest_name || 'Player'}
                      </span>
                      <span className={`badge bg-${iqRating(lb.total_questions>0?Math.round((lb.score/lb.total_questions)*100):0).color} small`}>
                        {lb.score}/{lb.total_questions}
                      </span>
                    </div>
                  ))}
                </div>
              </div>

              {/* CTA */}
              <div className="card border-0 shadow-sm rounded-3 text-center p-4">
                <div style={{ fontSize: '2rem' }}>📣</div>
                <h6 className="fw-bold mt-2 mb-1" style={{ color: '#10316B' }}>Challenge Your Friends!</h6>
                <p className="text-muted small mb-3">Share this quiz and see who has the best football IQ.</p>
                {quiz.is_active && (
                  <Link href={`/quiz/${quiz.id}/take`} className="btn btn-outline-success btn-sm w-100 mb-2">
                    <i className="bi bi-arrow-repeat me-1"></i>Play Again
                  </Link>
                )}
                <Link href="/quiz" className="btn btn-primary btn-sm w-100">
                  <i className="bi bi-grid me-1"></i>More Quizzes
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
}
