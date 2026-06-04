import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';

const STYLE = `
.pdash{background:#f0f4f8;min-height:calc(100vh - 72px);}
.phero{background:linear-gradient(135deg,#0f1f3d 0%,#10316B 50%,#1a5c2a 100%);padding:28px 24px;position:relative;overflow:hidden;}
.phero::before{content:'';position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.04);}
.phero-av{width:68px;height:68px;border-radius:18px;object-fit:cover;border:3px solid #fbbf24;flex-shrink:0;position:relative;z-index:1;}
.phero-av-init{width:68px;height:68px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:900;color:#fff;flex-shrink:0;background:linear-gradient(135deg,#fbbf24,#f59e0b);position:relative;z-index:1;}
.pgcard{border-radius:16px;padding:18px 16px;display:flex;align-items:center;gap:12px;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,.2);backdrop-filter:blur(10px);box-shadow:0 6px 24px rgba(0,0,0,.1);transition:transform .18s;text-decoration:none;}
.pgcard:hover{transform:translateY(-3px);}
.pgcard .pgi{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;background:rgba(255,255,255,.18);position:relative;z-index:1;}
.pgcard .pgv{font-size:1rem;font-weight:900;line-height:1;position:relative;z-index:1;color:#fff;}
.pgcard .pgl{font-size:.7rem;font-weight:600;opacity:.8;margin-top:2px;position:relative;z-index:1;color:#fff;}
.ppnl{background:#fff;border-radius:16px;box-shadow:0 2px 16px rgba(0,0,0,.06);overflow:hidden;margin-bottom:20px;border:1px solid #e8edf2;}
.ppnl-h{padding:13px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #f0f4f8;}
.ppnl-h .ph{font-size:.88rem;font-weight:700;color:#0d1117;display:flex;align-items:center;gap:8px;}
.ppnl-h .phi{width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.85rem;}
.pl{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:700;}
.pl-g{background:#dcfce7;color:#15803d;}.pl-y{background:#fef9c3;color:#a16207;}.pl-r{background:#fee2e2;color:#b91c1c;}.pl-b{background:#dbeafe;color:#1d4ed8;}
.pbar{height:6px;border-radius:6px;background:#e8edf2;overflow:hidden;}
.pbar-fill{height:100%;border-radius:6px;}
.pending-card{background:linear-gradient(135deg,#0f1f3d,#10316B);border-radius:20px;padding:48px 32px;text-align:center;color:#fff;position:relative;overflow:hidden;}
`;

export default function Dashboard() {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [profile,   setProfile]   = useState(null);
  const [courses,   setCourses]   = useState([]);
  const [progress,  setProgress]  = useState({});
  const [attempts,  setAttempts]  = useState([]);
  const [loading,   setLoading]   = useState(true);

  useEffect(() => {
    if (session === null) { router.replace('/login'); return; }
    if (!session) return;

    async function load() {
      const uid = session.user.id;

      const [{ data: prof }, { data: c }, { data: prog }, { data: att }] = await Promise.all([
        supabase.from('profiles').select('*').eq('id', uid).single(),
        supabase.from('courses').select('id, title, category').order('id'),
        supabase.from('player_progress').select('*').eq('user_id', uid),
        supabase.from('quiz_attempts')
          .select('score, total_questions, created_at, quiz_weeks(title, week_number)')
          .eq('user_id', uid)
          .order('created_at', { ascending: false })
          .limit(5),
      ]);

      setProfile(prof);
      setCourses(c || []);
      const progMap = {};
      (prog || []).forEach(p => { progMap[p.course_id] = p; });
      setProgress(progMap);
      setAttempts(att || []);
      setLoading(false);
    }
    load();
  }, [session]);

  const signOut = async () => {
    await supabase.auth.signOut();
    router.push('/login');
  };

  const completedCourses = Object.values(progress).filter(p => p.status === 'completed').length;
  const overallPct = courses.length > 0 ? Math.round((completedCourses / courses.length) * 100) : 0;

  const statusColor = { started:'#94a3b8', in_progress:'#d97706', completed:'#15803d' };
  const statusLabel = { started:'Not Started', in_progress:'In Progress', completed:'Completed' };
  const statusBg    = { started:'#f1f5f9', in_progress:'#fef9c3', completed:'#dcfce7' };

  if (!session || loading) {
    return (
      <>
        <NavBar />
        <div className="d-flex align-items-center justify-content-center" style={{minHeight:'60vh'}}>
          <div className="text-center"><div className="spinner-border text-primary"></div><p className="mt-3">Loading dashboard…</p></div>
        </div>
        <Footer />
      </>
    );
  }

  const userEmail = session.user.email;
  const firstName = (profile?.full_name || userEmail || 'Player').split(' ')[0];
  const initial   = (profile?.full_name || userEmail || 'P').charAt(0).toUpperCase();
  const isApproved = profile?.role === 'player' || profile?.role === 'admin';

  return (
    <>
      <Head><title>OFA | My Dashboard</title></Head>
      <style>{STYLE}</style>
      <NavBar />

      <div className="pdash">
        {/* Hero */}
        <div className="phero">
          <div className="container-fluid px-3 px-md-4">
            <div className="d-flex align-items-center gap-4 flex-wrap">
              <div className="phero-av-init">{initial}</div>
              <div className="flex-grow-1" style={{position:'relative',zIndex:1}}>
                <h2 className="fw-bold text-white mb-1" style={{fontSize:'1.4rem'}}>Welcome back, {firstName}! ⚽</h2>
                <div className="d-flex flex-wrap gap-2 align-items-center">
                  <span className="pl" style={{background:'rgba(255,255,255,.15)',color:'#fff'}}>{userEmail}</span>
                  <span className="pl pl-g"><i className="bi bi-check-circle-fill"></i> Active</span>
                </div>
              </div>
              <button className="btn btn-sm fw-bold px-4" onClick={signOut}
                style={{background:'rgba(239,68,68,.2)',color:'#fca5a5',border:'1px solid rgba(239,68,68,.3)',borderRadius:10,zIndex:1}}>
                <i className="bi bi-box-arrow-right me-1"></i>Log Out
              </button>
            </div>
          </div>
        </div>

        <div className="container-fluid px-3 px-md-4 py-4">

          {/* Quick-access cards */}
          <div className="row g-3 mb-4">
            {[
              ['/program',           'linear-gradient(135deg,rgba(16,49,107,.9),rgba(30,77,183,.85))', 'bi-trophy-fill',         'Program',    'Training & drills'],
              ['/football-education','linear-gradient(135deg,rgba(5,150,105,.9),rgba(16,185,129,.85))','bi-mortarboard-fill',    'E-Learning', 'Courses & lessons'],
              ['/quiz',              'linear-gradient(135deg,rgba(124,58,237,.9),rgba(139,92,246,.85))','bi-patch-question-fill','IQ Quiz',    'Test your knowledge'],
              ['/store',             'linear-gradient(135deg,rgba(220,38,38,.9),rgba(239,68,68,.85))', 'bi-shop-window',         'OFA Store',  'Gear & booking'],
            ].map(([href, bg, icon, label, sub]) => (
              <div className="col-6 col-md-3" key={href}>
                <Link href={href} className="pgcard" style={{background:bg}}>
                  <div className="pgi"><i className={`bi ${icon}`}></i></div>
                  <div><div className="pgv">{label}</div><div className="pgl">{sub}</div></div>
                </Link>
              </div>
            ))}
          </div>

          <div className="row g-4">
            {/* LEFT */}
            <div className="col-lg-4">
              {/* Profile */}
              <div className="ppnl">
                <div className="ppnl-h">
                  <div className="ph"><div className="phi" style={{background:'#dbeafe'}}><i className="bi bi-person-badge-fill" style={{color:'#2563eb'}}></i></div>My Profile</div>
                </div>
                <div className="p-4">
                  <div className="text-center mb-4">
                    <div className="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-white shadow"
                      style={{width:72,height:72,background:'linear-gradient(135deg,#10316B,#4CAF50)',fontSize:'1.8rem'}}>
                      {initial}
                    </div>
                    <div className="fw-bold mt-2" style={{fontSize:'.95rem',color:'#0d1117'}}>{profile?.full_name || '—'}</div>
                    <div className="text-muted" style={{fontSize:'.75rem'}}>{userEmail}</div>
                  </div>
                  <div className="row g-2">
                    {[['Role', profile?.role || 'player'], ['Member Since', new Date(session.user.created_at).toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'})]].map(([l,v]) => (
                      <div className="col-6" key={l}>
                        <div style={{background:'#f8fafc',borderRadius:10,padding:'10px 12px'}}>
                          <div style={{fontSize:'.65rem',fontWeight:800,letterSpacing:'.06em',color:'#94a3b8',textTransform:'uppercase'}}>{l}</div>
                          <div style={{fontSize:'.82rem',fontWeight:600,color:'#0d1117',marginTop:2,textTransform:'capitalize'}}>{v}</div>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              </div>

              {/* Quiz History */}
              <div className="ppnl">
                <div className="ppnl-h">
                  <div className="ph"><div className="phi" style={{background:'#f3e8ff'}}><i className="bi bi-patch-question-fill" style={{color:'#9333ea'}}></i></div>Quiz History</div>
                </div>
                <div className="p-3">
                  {attempts.length === 0 ? (
                    <div className="text-center py-4 text-muted">
                      <i className="bi bi-patch-question fs-1 d-block mb-2 opacity-25"></i>
                      <p className="mb-2" style={{fontSize:'.83rem'}}>No quizzes taken yet.</p>
                      <Link href="/quiz" className="btn btn-sm btn-outline-primary">Take the Quiz</Link>
                    </div>
                  ) : attempts.map((a, i) => {
                    const p = a.total_questions > 0 ? Math.round((a.score/a.total_questions)*100) : 0;
                    return (
                      <div key={i} className="d-flex justify-content-between align-items-center p-2 mb-2 rounded-3" style={{background:'#f8fafc',border:'1px solid #e8edf2'}}>
                        <div>
                          <div className="fw-semibold" style={{fontSize:'.83rem',color:'#0d1117'}}>{a.quiz_weeks?.title || 'Quiz'}</div>
                          <div className="text-muted" style={{fontSize:'.72rem'}}>{new Date(a.created_at).toLocaleDateString('en-GB')}</div>
                        </div>
                        <span className="fw-bold" style={{color:'#10316B'}}>{a.score}/{a.total_questions}</span>
                      </div>
                    );
                  })}
                </div>
              </div>
            </div>

            {/* RIGHT */}
            <div className="col-lg-8">
              {/* Learning Progress */}
              <div className="ppnl">
                <div className="ppnl-h">
                  <div className="ph"><div className="phi" style={{background:'#f3e8ff'}}><i className="bi bi-mortarboard-fill" style={{color:'#9333ea'}}></i></div>My Learning Progress</div>
                  <span className="pl" style={{background:'#f3e8ff',color:'#9333ea'}}>{overallPct}% done</span>
                </div>
                <div className="p-4">
                  <div className="p-3 rounded-3 mb-4" style={{background:'linear-gradient(135deg,rgba(16,49,107,.06),rgba(76,175,80,.06))',border:'1px solid #e8edf2'}}>
                    <div className="d-flex justify-content-between align-items-center mb-2">
                      <span className="fw-semibold" style={{fontSize:'.82rem',color:'#0d1117'}}>Overall Completion</span>
                      <span className="fw-bold" style={{color:'#15803d',fontSize:'.88rem'}}>{completedCourses}/{courses.length} courses</span>
                    </div>
                    <div className="pbar" style={{height:10}}>
                      <div className="pbar-fill" style={{width:`${overallPct}%`,background:'linear-gradient(90deg,#10316B,#4CAF50)'}}></div>
                    </div>
                  </div>

                  {courses.length === 0 ? (
                    <p className="text-muted text-center py-3">No courses available yet.</p>
                  ) : courses.map(course => {
                    const cp     = progress[course.id];
                    const pct    = cp?.progress_percent || 0;
                    const status = cp?.status || 'not_started';
                    const color  = statusColor[status] || '#94a3b8';
                    const label  = statusLabel[status] || 'Not Started';
                    const bg     = statusBg[status]    || '#f1f5f9';
                    return (
                      <div className="mb-3" key={course.id}>
                        <div className="d-flex justify-content-between align-items-center mb-1">
                          <Link href="/football-education" className="fw-semibold text-decoration-none" style={{fontSize:'.83rem',color:'#0d1117'}}>
                            {course.title}
                          </Link>
                          <span className="pl" style={{background:bg,color,fontSize:'.68rem'}}>{label}</span>
                        </div>
                        <div className="pbar">
                          <div className="pbar-fill" style={{width:`${pct}%`,background:color}}></div>
                        </div>
                      </div>
                    );
                  })}

                  <Link href="/football-education" className="btn btn-sm fw-bold w-100 mt-2"
                    style={{background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',borderRadius:10,padding:9}}>
                    <i className="bi bi-play-fill me-1"></i>Continue Learning
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </>
  );
}
