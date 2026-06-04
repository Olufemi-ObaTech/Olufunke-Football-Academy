import { useEffect, useState, useRef } from 'react';
import Head from 'next/head';
import { useRouter } from 'next/router';
import { supabase } from '../../../lib/supabaseClient';
import NavBar from '../../../components/NavBar';
import Footer from '../../../components/Footer';
import { useSession } from '@supabase/auth-helpers-react';

export default function TakeQuiz() {
  const router  = useRouter();
  const { id }  = router.query;
  const session = useSession();

  const [quiz,       setQuiz]       = useState(null);
  const [questions,  setQuestions]  = useState([]);
  const [answers,    setAnswers]    = useState({});
  const [current,    setCurrent]    = useState(0);
  const [timeLeft,   setTimeLeft]   = useState(null);
  const [elapsed,    setElapsed]    = useState(0);
  const [submitting, setSubmitting] = useState(false);
  const [guestName,  setGuestName]  = useState('');
  const [showModal,  setShowModal]  = useState(false);
  const [loading,    setLoading]    = useState(true);
  const timerRef = useRef(null);

  useEffect(() => {
    if (!id) return;
    async function load() {
      const { data: qw } = await supabase.from('quiz_weeks').select('*').eq('id', id).single();
      if (!qw) { router.push('/quiz'); return; }

      const { data: qs } = await supabase
        .from('quiz_questions')
        .select('*, quiz_options(*)')
        .eq('quiz_week_id', id)
        .order('order');

      const shuffled = (qs || []).sort(() => Math.random() - 0.5).slice(0, 10);
      setQuiz(qw);
      setQuestions(shuffled);
      setTimeLeft(qw.time_limit || 600);
      setLoading(false);
    }
    load();
  }, [id]);

  // Timer
  useEffect(() => {
    if (timeLeft === null || timeLeft <= 0) return;
    timerRef.current = setInterval(() => {
      setTimeLeft(t => {
        if (t <= 1) { clearInterval(timerRef.current); handleSubmit(true); return 0; }
        return t - 1;
      });
      setElapsed(e => e + 1);
    }, 1000);
    return () => clearInterval(timerRef.current);
  }, [timeLeft !== null && timeLeft > 0]);

  const fmt = (s) => `${String(Math.floor(s/60)).padStart(2,'0')}:${String(s%60).padStart(2,'0')}`;
  const answeredCount = Object.keys(answers).length;
  const pct = questions.length ? Math.round((answeredCount / questions.length) * 100) : 0;

  const handleSubmit = async (auto = false) => {
    if (submitting) return;
    setSubmitting(true);
    clearInterval(timerRef.current);

    const answersLog = {};
    for (const q of questions) {
      const selectedId = answers[q.id] ? parseInt(answers[q.id]) : null;
      const correctOpt = (q.quiz_options || []).find(o => o.is_correct);
      answersLog[q.id] = {
        selected:   selectedId,
        correct:    correctOpt?.id || null,
        is_correct: selectedId && correctOpt && selectedId === correctOpt.id,
      };
    }
    const score = Object.values(answersLog).filter(a => a.is_correct).length;

    const attemptData = {
      quiz_week_id:    id,
      user_id:         session?.user?.id || null,
      guest_name:      session ? null : (guestName || 'Anonymous'),
      score,
      total_questions: questions.length,
      time_taken:      elapsed,
      answers:         answersLog,
      ip_address:      null,
    };

    const { data: attempt } = await supabase.from('quiz_attempts').insert([attemptData]).select().single();
    if (attempt) router.push(`/quiz/result/${attempt.id}`);
  };

  if (loading) return <><NavBar active="quiz" /><div className="container py-5 text-center"><p>Loading quiz…</p></div><Footer /></>;

  return (
    <>
      <Head><title>Take Quiz — {quiz?.title}</title></Head>
      <NavBar active="quiz" />

      {/* Header */}
      <section className="py-4 text-white" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <div className="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
              <h1 className="fw-bold mb-1 fs-3">🧠 {quiz?.title}</h1>
              <span className="badge bg-white text-dark">{questions.length} Questions</span>
              <span className="badge bg-success ms-1"><i className="bi bi-shuffle me-1"></i>Randomised</span>
            </div>
            <div className="text-center">
              <div className={`fw-bold fs-4${timeLeft <= 30 ? ' text-danger' : timeLeft <= 60 ? ' text-warning' : ''}`}>
                <i className="bi bi-clock me-1"></i>{fmt(timeLeft || 0)}
              </div>
              <small className="opacity-75">Time Remaining</small>
            </div>
          </div>
          <div className="progress mt-3" style={{height:6}}>
            <div className="progress-bar bg-warning" style={{width:`${pct}%`,transition:'width .3s'}}></div>
          </div>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-lg-8">
              {/* Guest name */}
              {!session && (
                <div className="card border-0 shadow-sm rounded-3 mb-4" style={{borderLeft:'4px solid #4CAF50'}}>
                  <div className="card-body p-4">
                    <h6 className="fw-bold mb-2"><i className="bi bi-person-circle me-2 text-success"></i>Enter Your Name for the Leaderboard</h6>
                    <input type="text" className="form-control" placeholder="Your name (optional)" maxLength={60} value={guestName} onChange={e=>setGuestName(e.target.value)} />
                    <small className="text-muted">Leave blank to appear as &quot;Anonymous&quot;</small>
                  </div>
                </div>
              )}

              {/* Current question */}
              {questions.length > 0 && (() => {
                const q = questions[current];
                const opts = (q.quiz_options || []).sort((a,b) => (a.order||0)-(b.order||0));
                return (
                  <div className="card border-0 shadow-sm rounded-3">
                    <div className="card-body p-4 p-md-5">
                      <div className="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <span className="text-muted small fw-semibold">Question {current+1} of {questions.length}</span>
                        <div className="d-flex gap-2">
                          <span className={`badge bg-${q.difficulty==='easy'?'success':q.difficulty==='hard'?'danger':'warning text-dark'}`}>
                            {q.difficulty}
                          </span>
                          {q.category && <span className="badge bg-light text-dark border">{q.category}</span>}
                        </div>
                      </div>
                      <h4 className="fw-bold mb-4" style={{color:'#10316B',lineHeight:1.5}}>{q.question}</h4>
                      <div className="row g-3">
                        {opts.map((opt, oi) => {
                          const selected = answers[q.id] === String(opt.id);
                          return (
                            <div className="col-md-6" key={opt.id}>
                              <label
                                className="d-block p-3 rounded-3 border"
                                style={{cursor:'pointer',background:selected?'#e8f5e9':'',borderColor:selected?'#4CAF50':'#dee2e6',transition:'all .2s'}}
                                onClick={() => setAnswers(p => ({...p, [q.id]: String(opt.id)}))}
                              >
                                <div className="d-flex align-items-center gap-3">
                                  <div className="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                    style={{width:36,height:36,background:selected?'#4CAF50':'#e9ecef',color:selected?'#fff':'#333',fontSize:'.9rem'}}>
                                    {String.fromCharCode(65+oi)}
                                  </div>
                                  <span className="fw-semibold">{opt.option_text}</span>
                                </div>
                              </label>
                            </div>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                );
              })()}

              {/* Navigation */}
              <div className="d-flex justify-content-between mt-3 gap-3">
                <button className="btn btn-outline-secondary" disabled={current===0} onClick={()=>setCurrent(c=>c-1)}>
                  <i className="bi bi-arrow-left me-1"></i>Previous
                </button>
                {current < questions.length-1 ? (
                  <button className="btn btn-primary" onClick={()=>setCurrent(c=>c+1)}>
                    Next<i className="bi bi-arrow-right ms-1"></i>
                  </button>
                ) : (
                  <button className="btn btn-success btn-lg fw-bold px-5" onClick={()=>setShowModal(true)}>
                    <i className="bi bi-send-fill me-2"></i>Submit Quiz
                  </button>
                )}
              </div>

              {/* Dot nav */}
              <div className="d-flex flex-wrap gap-2 justify-content-center mt-4">
                {questions.map((q,i) => (
                  <button key={i} onClick={()=>setCurrent(i)}
                    className={`btn btn-sm rounded-circle${i===current?' btn-primary':answers[q.id]?' btn-success':' btn-outline-secondary'}`}
                    style={{width:36,height:36,padding:0}}>
                    {i+1}
                  </button>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Submit modal */}
      {showModal && (
        <div className="modal show d-block" style={{background:'rgba(0,0,0,.5)'}}>
          <div className="modal-dialog modal-dialog-centered">
            <div className="modal-content border-0 shadow">
              <div className="modal-header" style={{background:'#10316B',color:'#fff'}}>
                <h5 className="modal-title fw-bold"><i className="bi bi-send-fill me-2"></i>Submit Quiz?</h5>
                <button className="btn-close btn-close-white" onClick={()=>setShowModal(false)}></button>
              </div>
              <div className="modal-body p-4">
                {answeredCount < questions.length && (
                  <div className="alert alert-warning"><i className="bi bi-exclamation-triangle-fill me-2"></i>You have <strong>{questions.length-answeredCount}</strong> unanswered question(s).</div>
                )}
                <p>Are you sure you want to submit? You cannot change answers after submission.</p>
                <div className="d-flex justify-content-between text-muted small">
                  <span><i className="bi bi-check-circle me-1 text-success"></i>Answered: <strong>{answeredCount}</strong></span>
                  <span><i className="bi bi-dash-circle me-1 text-warning"></i>Skipped: <strong>{questions.length-answeredCount}</strong></span>
                  <span><i className="bi bi-list-ol me-1 text-primary"></i>Total: <strong>{questions.length}</strong></span>
                </div>
              </div>
              <div className="modal-footer">
                <button className="btn btn-outline-secondary" onClick={()=>setShowModal(false)}>Go Back</button>
                <button className="btn btn-success fw-bold px-4" disabled={submitting} onClick={()=>handleSubmit(false)}>
                  {submitting ? <><span className="spinner-border spinner-border-sm me-2"></span>Submitting…</> : <><i className="bi bi-send-fill me-2"></i>Yes, Submit</>}
                </button>
              </div>
            </div>
          </div>
        </div>
      )}

      <Footer />
    </>
  );
}
