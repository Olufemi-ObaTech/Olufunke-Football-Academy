import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';
import { supabase } from '../../lib/supabaseClient';
import { useSession } from '@supabase/auth-helpers-react';

function iqRating(pct) {
  if (pct >= 90) return { label: '🧠 Football Genius', color: 'success' };
  if (pct >= 75) return { label: '⭐ Expert Analyst',   color: 'primary' };
  if (pct >= 60) return { label: '🎯 Tactical Thinker', color: 'info'    };
  if (pct >= 40) return { label: '⚽ Solid Fan',        color: 'warning' };
  return               { label: '📚 Keep Learning',    color: 'secondary'};
}

export default function QuizLeaderboard() {
  const router  = useRouter();
  const { id }  = router.query;
  const session = useSession();

  const [quiz,        setQuiz]        = useState(null);
  const [leaderboard, setLeaderboard] = useState([]);
  const [myBest,      setMyBest]      = useState(null);
  const [stats,       setStats]       = useState({ total: 0, avg: 0, top: 0, qCount: 0 });
  const [loading,     setLoading]     = useState(true);

  useEffect(() => {
    if (!id) return;
    async function load() {
      const { data: qw } = await supabase.from('quiz_weeks').select('*').eq('id', id).single();
      if (!qw) { router.push('/quiz'); return; }
      setQuiz(qw);

      const { data: lb } = await supabase
        .from('quiz_attempts')
        .select('id, score, total_questions, time_taken, guest_name, user_id')
        .eq('quiz_week_id', id)
        .order('score', { ascending: false })
        .order('time_taken', { ascending: true })
        .limit(20);
      setLeaderboard(lb || []);

      const { count: qCount } = await supabase
        .from('quiz_questions').select('id', { count: 'exact', head: true }).eq('quiz_week_id', id);

      const total  = (lb || []).length;
      const avg    = total > 0 ? Math.round((lb.reduce((s, a) => s + a.score, 0) / total) * 10) / 10 : 0;
      const top    = total > 0 ? Math.max(...lb.map(a => a.score)) : 0;
      setStats({ total, avg, top, qCount: qCount || 0 });

      if (session) {
        const { data: best } = await supabase
          .from('quiz_attempts').select('*')
          .eq('quiz_week_id', id).eq('user_id', session.user.id)
          .order('score', { ascending: false }).limit(1).single();
        setMyBest(best || null);
      }
      setLoading(false);
    }
    load();
  }, [id, session]);

  if (loading) return <><NavBar active="quiz" /><div className="container py-5 text-center"><p>Loading…</p></div><Footer /></>;
  if (!quiz) return null;

  return (
    <>
      <Head><title>{quiz.title} — Leaderboard | OFA</title></Head>
      <NavBar active="quiz" />

      {/* Header */}
      <section className="py-4 text-white" style={{ background: 'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)' }}>
        <div className="container">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb mb-2">
              <li className="breadcrumb-item"><Link href="/quiz" className="text-warning">Football IQ Quiz</Link></li>
              <li className="breadcrumb-item active text-white">{quiz.title}</li>
            </ol>
          </nav>
          <div className="d-flex align-items-center gap-3 flex-wrap">
            <div style={{ fontSize: '2.5rem' }}>🏆</div>
            <div>
              <h1 className="fw-bold mb-1 fs-3">{quiz.title}</h1>
              <div className="d-flex gap-2 flex-wrap">
                {quiz.theme && <span className="badge bg-warning text-dark">{quiz.theme}</span>}
                <span className={`badge ${quiz.is_active ? 'bg-success' : 'bg-secondary'}`}>
                  {quiz.is_active ? '🔴 Live' : 'Ended'}
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row g-4">
            {/* Leaderboard table */}
            <div className="col-lg-8">
              <div className="card border-0 shadow-sm rounded-3">
                <div className="card-header py-3 fw-bold" style={{ background: '#10316B', color: '#fff' }}>
                  <i className="bi bi-trophy-fill me-2 text-warning"></i>Top 20 Leaderboard
                  <span className="badge bg-warning text-dark ms-2">{stats.total} entries</span>
                </div>
                <div className="card-body p-0">
                  {leaderboard.length === 0 ? (
                    <div className="text-center py-5 text-muted">
                      <div style={{ fontSize: '3rem' }}>📋</div>
                      <p className="mt-2">No attempts yet. Be the first!</p>
                      {quiz.is_active && (
                        <Link href={`/quiz/${quiz.id}/take`} className="btn btn-success">
                          <i className="bi bi-play-fill me-1"></i>Take the Quiz
                        </Link>
                      )}
                    </div>
                  ) : (
                    <div className="table-responsive">
                      <table className="table table-hover mb-0 align-middle">
                        <thead className="table-light">
                          <tr>
                            <th className="ps-4" style={{ width: 60 }}>Rank</th>
                            <th>Player</th>
                            <th className="text-center">Score</th>
                            <th className="text-center d-none d-md-table-cell">Time</th>
                            <th className="text-center">Rating</th>
                          </tr>
                        </thead>
                        <tbody>
                          {leaderboard.map((lb, i) => {
                            const p   = lb.total_questions > 0 ? Math.round((lb.score/lb.total_questions)*100) : 0;
                            const { label, color } = iqRating(p);
                            const isMe = myBest && myBest.id === lb.id;
                            return (
                              <tr key={lb.id} className={isMe ? 'table-warning' : ''}>
                                <td className="ps-4 fw-bold">
                                  {i===0?'🥇':i===1?'🥈':i===2?'🥉':<span className="text-muted">#{i+1}</span>}
                                </td>
                                <td>
                                  <div className="d-flex align-items-center gap-2">
                                    <div className="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                      style={{ width:36,height:36,background:i<3?'#10316B':'#e9ecef',color:i<3?'#fff':'#666',fontWeight:'bold',fontSize:'.85rem' }}>
                                      {(lb.guest_name||'P').charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                      <div className="fw-semibold">{lb.guest_name || 'Player'}</div>
                                      {isMe && <small className="text-warning fw-bold">← You</small>}
                                    </div>
                                  </div>
                                </td>
                                <td className="text-center">
                                  <span className="fw-bold fs-5" style={{ color:'#10316B' }}>{lb.score}</span>
                                  <span className="text-muted small">/{lb.total_questions}</span>
                                  <div className="small text-muted">{p}%</div>
                                </td>
                                <td className="text-center d-none d-md-table-cell text-muted small">
                                  {lb.time_taken ? `${Math.floor(lb.time_taken/60)}m ${lb.time_taken%60}s` : '—'}
                                </td>
                                <td className="text-center">
                                  <span className={`badge bg-${color} small`}>{label}</span>
                                </td>
                              </tr>
                            );
                          })}
                        </tbody>
                      </table>
                    </div>
                  )}
                </div>
              </div>
            </div>

            {/* Sidebar */}
            <div className="col-lg-4">
              {/* My result */}
              {myBest ? (
                <div className="card border-0 shadow-sm rounded-3 mb-4" style={{ borderTop: '4px solid #4CAF50' }}>
                  <div className="card-body text-center p-4">
                    <div style={{ fontSize: '2.5rem' }}>🎯</div>
                    <h5 className="fw-bold mt-2 mb-1" style={{ color:'#10316B' }}>Your Best Score</h5>
                    <div className="display-4 fw-bold" style={{ color:'#4CAF50' }}>
                      {myBest.score}<span className="fs-4 text-muted">/{myBest.total_questions}</span>
                    </div>
                    <div className="mt-3 d-flex flex-column gap-2">
                      <Link href={`/quiz/result/${myBest.id}`} className="btn btn-outline-primary w-100">
                        <i className="bi bi-eye me-1"></i>View Full Results
                      </Link>
                      {quiz.is_active && (
                        <Link href={`/quiz/${quiz.id}/take`} className="btn btn-warning w-100 fw-bold">
                          <i className="bi bi-arrow-repeat me-1"></i>Play Again
                        </Link>
                      )}
                    </div>
                  </div>
                </div>
              ) : quiz.is_active && (
                <div className="card border-0 shadow-sm rounded-3 mb-4" style={{ borderTop: '4px solid #10316B' }}>
                  <div className="card-body text-center p-4">
                    <div style={{ fontSize: '2.5rem' }}>⚽</div>
                    <h5 className="fw-bold mt-2 mb-1" style={{ color:'#10316B' }}>Ready to Play?</h5>
                    <p className="text-muted small">Take the quiz and see where you rank!</p>
                    <Link href={`/quiz/${quiz.id}/take`} className="btn btn-success w-100 fw-bold">
                      <i className="bi bi-play-fill me-1"></i>Take the Quiz
                    </Link>
                  </div>
                </div>
              )}

              {/* Stats */}
              <div className="card border-0 shadow-sm rounded-3 mb-4">
                <div className="card-header fw-bold py-3" style={{ background:'#f8f9fa' }}>
                  <i className="bi bi-bar-chart-fill me-2 text-primary"></i>Quiz Stats
                </div>
                <div className="card-body">
                  {[
                    ['Total Attempts', stats.total],
                    ['Average Score',  `${stats.avg}/${stats.qCount}`],
                    ['Top Score',      `${stats.top}/${stats.qCount}`],
                    ['Questions',       stats.qCount],
                  ].map(([label, val]) => (
                    <div key={label} className="d-flex justify-content-between py-2 border-bottom">
                      <span className="text-muted">{label}</span>
                      <strong>{val}</strong>
                    </div>
                  ))}
                </div>
              </div>

              <Link href="/quiz" className="btn btn-outline-secondary w-100">
                <i className="bi bi-arrow-left me-1"></i>All Quizzes
              </Link>
            </div>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
}
