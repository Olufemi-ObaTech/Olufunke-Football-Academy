import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';
import { supabase } from '../../lib/supabaseClient';
import { useSession } from '@supabase/auth-helpers-react';

export default function QuizIndex() {
  const session = useSession();
  const [activeQuiz,   setActiveQuiz]   = useState(null);
  const [pastQuizzes,  setPastQuizzes]  = useState([]);
  const [myBest,       setMyBest]       = useState(null);
  const [loading,      setLoading]      = useState(true);
  const [liveTime,     setLiveTime]     = useState('');
  const [liveDate,     setLiveDate]     = useState('');

  useEffect(() => {
    const tick = () => {
      const now = new Date();
      setLiveTime(now.toLocaleTimeString('en-GB', { timeZone: 'Africa/Lagos', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true }));
      setLiveDate(now.toLocaleDateString('en-GB', { timeZone: 'Africa/Lagos', weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }));
    };
    tick();
    const timer = setInterval(tick, 1000);
    return () => clearInterval(timer);
  }, []);

  useEffect(() => {
    async function load() {
      const { data: active } = await supabase
        .from('quiz_weeks').select('*').eq('is_active', true)
        .order('created_at', { ascending: false }).limit(1).single();

      const { data: past } = await supabase
        .from('quiz_weeks').select('*').eq('is_active', false)
        .order('created_at', { ascending: false });

      setActiveQuiz(active || null);
      setPastQuizzes(past || []);

      if (active && session) {
        const { data: best } = await supabase
          .from('quiz_attempts')
          .select('*')
          .eq('quiz_week_id', active.id)
          .eq('user_id', session.user.id)
          .order('score', { ascending: false })
          .limit(1).single();
        setMyBest(best || null);
      }
      setLoading(false);
    }
    load();
  }, [session]);

  const ratings = [
    { emoji:'🧠', label:'Football Genius', range:'90–100%', color:'success' },
    { emoji:'⭐', label:'Expert Analyst',  range:'75–89%',  color:'primary' },
    { emoji:'🎯', label:'Tactical Thinker',range:'60–74%',  color:'info'    },
    { emoji:'⚽', label:'Solid Fan',       range:'40–59%',  color:'warning' },
    { emoji:'📚', label:'Keep Learning',   range:'0–39%',   color:'secondary'},
  ];

  const pct = (a) => a && a.total_questions > 0 ? Math.round((a.score/a.total_questions)*100) : 0;
  const iqRating = (p) => {
    if (p >= 90) return { label:'🧠 Football Genius', color:'success' };
    if (p >= 75) return { label:'⭐ Expert Analyst',  color:'primary' };
    if (p >= 60) return { label:'🎯 Tactical Thinker',color:'info'    };
    if (p >= 40) return { label:'⚽ Solid Fan',       color:'warning' };
    return              { label:'📚 Keep Learning',   color:'secondary'};
  };

  return (
    <>
      <Head><title>Olufunke FA | Weekly Football IQ Quiz</title></Head>
      <NavBar active="quiz" />

      {/* Hero */}
      <section className="py-5 text-white text-center" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <div className="mb-3" style={{fontSize:'3.5rem'}}>🧠⚽</div>
          <h1 className="fw-bold display-5">Weekly Football IQ Quiz</h1>
          <p className="lead opacity-75 mb-3">Test your football knowledge — open to everyone, no login required!</p>
          <div className="d-flex justify-content-center gap-3 flex-wrap mb-3">
            <span className="badge bg-warning text-dark fs-6 px-3 py-2"><i className="bi bi-lightning-fill me-1"></i>New Quiz Every Week</span>
            <span className="badge bg-white text-dark fs-6 px-3 py-2"><i className="bi bi-trophy-fill me-1 text-warning"></i>Live Leaderboard</span>
            <span className="badge bg-success fs-6 px-3 py-2"><i className="bi bi-people-fill me-1"></i>Open to All</span>
          </div>
          {liveDate && (
            <div className="d-flex justify-content-center align-items-center gap-2 mt-2">
              <span className="badge bg-dark bg-opacity-50 fs-6 px-3 py-2" style={{letterSpacing:'.5px'}}>
                <i className="bi bi-geo-alt-fill text-warning me-1"></i>Lagos, Nigeria
                &nbsp;|&nbsp;
                <i className="bi bi-calendar3 me-1"></i>{liveDate}
                &nbsp;|&nbsp;
                <i className="bi bi-clock-fill me-1"></i>{liveTime} <span style={{fontSize:'.75em',opacity:.8}}>WAT</span>
              </span>
            </div>
          )}
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          {loading ? <p className="text-center py-5">Loading quiz…</p> : (
          <>
            {/* Active Quiz */}
            {activeQuiz ? (
              <div className="mb-5">
                <h2 className="fw-bold mb-4" style={{color:'#10316B'}}><i className="bi bi-fire text-danger me-2"></i>This Week&apos;s Quiz</h2>
                <div className="card border-0 shadow rounded-4 overflow-hidden">
                  <div className="row g-0">
                    <div className="col-md-8">
                      <div className="card-body p-4 p-md-5">
                        <div className="d-flex gap-2 flex-wrap mb-3">
                          <span className="badge bg-danger fs-6 px-3 py-2"><i className="bi bi-broadcast me-1"></i>LIVE NOW</span>
                          {activeQuiz.theme && <span className="badge bg-primary fs-6 px-3 py-2"><i className="bi bi-tag-fill me-1"></i>{activeQuiz.theme}</span>}
                        </div>
                        <h3 className="fw-bold mb-2" style={{color:'#10316B'}}>{activeQuiz.title}</h3>
                        {activeQuiz.description && <p className="text-muted mb-3">{activeQuiz.description}</p>}

                        {myBest ? (
                          <div className="alert alert-success d-flex align-items-center gap-3 mb-3">
                            <i className="bi bi-check-circle-fill fs-3"></i>
                            <div>
                              <strong>Your best score: {myBest.score}/{myBest.total_questions}</strong>
                              <span className={`badge bg-${iqRating(pct(myBest)).color} ms-2`}>{iqRating(pct(myBest)).label}</span>
                            </div>
                          </div>
                        ) : null}

                        <div className="d-flex gap-3 flex-wrap">
                          <Link href={`/quiz/${activeQuiz.id}/take`} className="btn btn-success btn-lg fw-bold px-5 shadow-sm">
                            <i className="bi bi-play-fill me-2"></i>{myBest ? 'Play Again' : 'Take the Quiz Now'}
                          </Link>
                          <Link href={`/quiz/${activeQuiz.id}`} className="btn btn-outline-primary btn-lg">
                            <i className="bi bi-bar-chart-fill me-1"></i>Leaderboard
                          </Link>
                        </div>
                      </div>
                    </div>
                    <div className="col-md-4 d-none d-md-flex align-items-center justify-content-center" style={{background:'linear-gradient(135deg,#10316B,#4CAF50)',minHeight:260}}>
                      <div className="text-center text-white p-4">
                        <div style={{fontSize:'4rem'}}>🏆</div>
                        <h5 className="fw-bold mt-2">Prove Your Football IQ</h5>
                        <p className="opacity-75 small">Climb the leaderboard and earn your badge</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ) : (
              <div className="text-center py-5 mb-5">
                <div style={{fontSize:'4rem'}}>⏳</div>
                <h3 className="fw-bold mt-3" style={{color:'#10316B'}}>No Active Quiz Right Now</h3>
                <p className="text-muted">A new quiz drops every week. Check back soon!</p>
              </div>
            )}

            {/* IQ Ratings Guide */}
            <div className="mb-5">
              <h4 className="fw-bold mb-3" style={{color:'#10316B'}}><i className="bi bi-award-fill me-2 text-warning"></i>Football IQ Ratings</h4>
              <div className="row g-3">
                {ratings.map(r => (
                  <div className="col-6 col-md-4 col-lg" key={r.label}>
                    <div className="card border-0 shadow-sm text-center p-3 h-100">
                      <div style={{fontSize:'2rem'}}>{r.emoji}</div>
                      <span className={`badge bg-${r.color} mt-2 mb-1`}>{r.label}</span>
                      <small className="text-muted">{r.range}</small>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* Past Quizzes */}
            {pastQuizzes.length > 0 && (
              <div>
                <h2 className="fw-bold mb-4" style={{color:'#10316B'}}><i className="bi bi-clock-history me-2"></i>Past Quizzes</h2>
                <div className="row g-3">
                  {pastQuizzes.map(q => (
                    <div className="col-md-6 col-lg-4" key={q.id}>
                      <div className="card border-0 shadow-sm rounded-3 h-100">
                        <div className="card-body">
                          <div className="d-flex justify-content-between align-items-start mb-2">
                            <span className="badge bg-secondary">Ended</span>
                            {q.theme && <span className="badge bg-light text-dark border">{q.theme}</span>}
                          </div>
                          <h6 className="fw-bold mb-1" style={{color:'#10316B'}}>{q.title}</h6>
                          <Link href={`/quiz/${q.id}`} className="btn btn-sm btn-outline-primary w-100 mt-2">
                            <i className="bi bi-bar-chart-fill me-1"></i>View Leaderboard
                          </Link>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}
          </>
          )}
        </div>
      </section>
      <Footer />
    </>
  );
}
