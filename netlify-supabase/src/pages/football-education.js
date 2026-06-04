import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';
import { supabase } from '../lib/supabaseClient';
import { useSession } from '@supabase/auth-helpers-react';

export default function FootballEducation() {
  const session = useSession();
  const [courses,   setCourses]   = useState([]);
  const [progress,  setProgress]  = useState({});
  const [filter,    setFilter]    = useState('all');
  const [loading,   setLoading]   = useState(true);

  useEffect(() => {
    async function load() {
      const { data: c } = await supabase
        .from('courses')
        .select('*, lessons(*)')
        .order('id');
      setCourses(c || []);

      if (session) {
        const { data: prog } = await supabase
          .from('player_progress')
          .select('course_id, status, progress_percent')
          .eq('user_id', session.user.id);
        const map = {};
        (prog || []).forEach(p => { map[p.course_id] = p; });
        setProgress(map);
      }
      setLoading(false);
    }
    load();
  }, [session]);

  const filtered = courses.filter(c => {
    if (filter === 'all') return true;
    const aud = c.target_audience || 'both';
    return aud === filter || aud === 'both';
  });

  const catColor = { technical:'primary', psychology:'warning', health:'danger', environment:'success', community:'info', education:'secondary' };
  const statusBadge = { started:['secondary','bi-play-circle','Started'], in_progress:['warning','bi-hourglass-split','In Progress'], completed:['success','bi-check-circle-fill','Completed'] };
  const filterBtns = [
    { key:'all',    label:'All',         cls:'btn-primary'         },
    { key:'player', label:'⚽ Players',  cls:'btn-outline-success' },
    { key:'coach',  label:'🎯 Coaches',  cls:'btn-outline-warning' },
    { key:'both',   label:'👥 Both',     cls:'btn-outline-info'    },
  ];

  return (
    <>
      <Head><title>OFA | Football Education</title></Head>
      <NavBar active="education" />

      {/* Hero */}
      <section className="py-5 text-white text-center" style={{ background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)' }}>
        <div className="container">
          <h1 className="fw-bold display-5">🎓 OFA E-Learning Platform</h1>
          <p className="lead opacity-75 mb-3">Standard lectures for players, coaches, and administrators — develop every dimension of your game.</p>
          <div className="d-flex justify-content-center gap-3 flex-wrap">
            <span className="badge bg-warning text-dark fs-6 px-3 py-2"><i className="bi bi-collection-play me-1"></i>{courses.length} Courses</span>
            <span className="badge bg-white text-dark fs-6 px-3 py-2"><i className="bi bi-book-fill me-1 text-primary"></i>{courses.reduce((s,c)=>s+(c.lessons?.length||0),0)} Lessons</span>
            <span className="badge bg-success fs-6 px-3 py-2"><i className="bi bi-people-fill me-1"></i>Players · Coaches · Admin</span>
          </div>
        </div>
      </section>

      {/* Courses */}
      <section className="py-5">
        <div className="container">
          <div className="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
            <div>
              <h2 className="fw-bold mb-1" style={{ color:'#10316B' }}>
                <i className="bi bi-play-circle-fill text-primary me-2"></i>📚 On-Demand Courses
              </h2>
              <p className="text-muted mb-0">Standard lectures designed for players, coaches, and administrators.</p>
            </div>
            <div className="d-flex gap-2 flex-wrap">
              {filterBtns.map(b => (
                <button key={b.key} onClick={() => setFilter(b.key)}
                  className={`btn btn-sm ${filter === b.key ? b.cls.replace('btn-outline-','btn-') : b.cls}`}>
                  {b.label}
                </button>
              ))}
            </div>
          </div>
          <hr className="mb-4" />

          {loading ? <p className="text-center py-5">Loading courses…</p> : (
            <div className="row g-4">
              {filtered.length === 0 ? (
                <div className="col-12 text-center py-5 text-muted">
                  <i className="bi bi-collection-play fs-1 d-block mb-2 opacity-25"></i>
                  No courses available yet.
                </div>
              ) : filtered.map(course => {
                const prog    = progress[course.id];
                const status  = prog?.status;
                const pct     = prog?.progress_percent || 0;
                const [sbg, sIcon, sLabel] = statusBadge[status] || [];
                const lessCount = course.lessons?.length || 0;
                const cc = catColor[course.category] || 'success';

                return (
                  <div className="col-md-4" key={course.id}>
                    <div className="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                      <div style={{ height:200, overflow:'hidden', position:'relative' }}>
                        <img src={course.image_path || '/images/OFA New Logo.jpg'} alt={course.title}
                          className="w-100 h-100" style={{ objectFit:'cover' }}
                          onError={e => e.target.src='/images/OFA New Logo.jpg'} />
                        {status === 'completed' && (
                          <div className="position-absolute top-0 end-0 m-2">
                            <span className="badge bg-success fs-6 shadow"><i className="bi bi-check-circle-fill me-1"></i>Completed</span>
                          </div>
                        )}
                      </div>
                      <div className="card-body d-flex flex-column">
                        <div className="d-flex justify-content-between align-items-start mb-2">
                          <span className={`badge bg-${cc}`}>{course.category}</span>
                          {status && (
                            <span className={`badge bg-${sbg}${status==='in_progress'?' text-dark':''}`}>
                              <i className={`bi ${sIcon} me-1`}></i>{sLabel}
                            </span>
                          )}
                        </div>
                        <h5 className="fw-bold" style={{ color:'#10316B' }}>{course.title}</h5>
                        <p className="text-muted small flex-grow-1">{course.description}</p>
                        <div className="text-muted small mb-2">
                          <i className="bi bi-collection-play me-1"></i>{lessCount} lessons
                        </div>

                        {status && (
                          <div className="mb-3">
                            <div className="d-flex justify-content-between small text-muted mb-1">
                              <span>Progress</span><span>{pct}%</span>
                            </div>
                            <div className="progress" style={{ height:8 }}>
                              <div className={`progress-bar bg-${pct>=100?'success':pct>0?'warning':'secondary'} progress-bar-striped`}
                                style={{ width:`${pct}%` }}></div>
                            </div>
                          </div>
                        )}

                        <div className="mt-auto">
                          {session ? (
                            <Link href={`/dashboard`} className="btn btn-sm btn-primary w-100">
                              <i className="bi bi-play-fill me-1"></i>
                              {status==='completed'?'Review Course':status==='in_progress'?'Continue Learning':'Start Learning'}
                            </Link>
                          ) : (
                            <Link href="/login" className="btn btn-sm btn-outline-primary w-100">
                              <i className="bi bi-lock me-1"></i>Login to Access
                            </Link>
                          )}
                        </div>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          )}
        </div>
      </section>

      {/* Skill Challenges */}
      <section className="py-5" style={{ background:'#f0f4ff' }}>
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-md-6">
              <h2 className="fw-bold mb-3" style={{ color:'#10316B' }}>🎮 ⚽ Skill Challenges &amp; Fantasy League</h2>
              <p>At Olufunke Football Academy, Skill Challenges and Fantasy League are designed to ignite competitive spirit and sharpen football intelligence through weekly interactive tasks.</p>
              <p>Players earn <strong>digital badges</strong> for completing quizzes, mastering drills, and climbing the leaderboard. The Fantasy League allows users to build dream teams based on real-world performance data.</p>
              <Link href="/quiz" className="btn btn-primary fw-bold"><i className="bi bi-controller me-1"></i>Join the Challenge</Link>
            </div>
            <div className="col-md-6">
              <div className="row g-3">
                {[['🏅','Digital Badges','Earn rewards for every milestone'],['📊','Leaderboard','Compete and climb the ranks'],['⚽','Fantasy League','Build your dream team'],['🧠','Weekly Quizzes','Test your football IQ']].map(([icon,title,desc])=>(
                  <div className="col-6" key={title}>
                    <div className="p-3 bg-white rounded-3 shadow-sm text-center">
                      <div className="fs-2 mb-2">{icon}</div>
                      <h6 className="fw-bold" style={{ color:'#10316B' }}>{title}</h6>
                      <small className="text-muted">{desc}</small>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* AI Matching */}
      <section className="py-5">
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-md-5 text-center order-md-2">
              <div className="p-5 rounded-3 shadow" style={{ background:'linear-gradient(135deg,#10316B,#4CAF50)' }}>
                <div className="text-white fs-1 mb-3">🤖</div>
                <h4 className="text-white fw-bold">AI-Powered</h4>
                <p className="text-white opacity-75">Smart algorithms connecting players with the right opportunities</p>
              </div>
            </div>
            <div className="col-md-7 order-md-1">
              <h2 className="fw-bold mb-3" style={{ color:'#10316B' }}>🤖 AI-Driven Player Matching</h2>
              <p>OFA&apos;s AI-Driven Player Matching system uses smart algorithms to connect players with trial opportunities, scouts, and development programs tailored to their unique skill sets.</p>
              <p>By analyzing performance metrics such as <strong>speed, accuracy, positioning, and decision-making</strong>, the system builds a dynamic profile for each athlete.</p>
              <Link href="/contact" className="btn btn-success fw-bold"><i className="bi bi-robot me-1"></i>Get Matched</Link>
            </div>
          </div>
        </div>
      </section>

      {/* Sustainability */}
      <section className="py-5" style={{ background:'#f0f4ff' }}>
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-md-6">
              <h2 className="fw-bold mb-3" style={{ color:'#10316B' }}>🌱 Sustainability &amp; CSR</h2>
              <p>At Olufunke Football Academy, football is more than a sport — it&apos;s a platform for positive change.</p>
              <ul className="list-unstyled mt-3">
                {[['bi-tree-fill text-success','Tree-planting campaigns to offset carbon footprints'],['bi-people-fill text-primary','Community outreach — free clinics & mentorship'],['bi-mortarboard-fill text-warning','Scholarships for talented players from underserved backgrounds'],['bi-building-fill text-danger','Partnerships with schools, NGOs, and local leaders'],['bi-globe text-info','Inclusive spaces where football drives education & unity']].map(([ic,txt])=>(
                  <li key={txt} className="mb-2"><i className={`bi ${ic} me-2`}></i>{txt}</li>
                ))}
              </ul>
            </div>
            <div className="col-md-6 text-center">
              <img src="/images/OFA 1.jpg" alt="OFA Community" className="img-fluid rounded-3 shadow"
                style={{ maxHeight:340, objectFit:'cover', width:'100%' }}
                onError={e => e.target.src='/images/OFA New Logo.jpg'} />
            </div>
          </div>
        </div>
      </section>

      {/* FIFA */}
      <section className="bg-light py-5">
        <div className="container text-center">
          <h2 className="fw-bold">🌍 FIFA Training Centre</h2>
          <p className="text-muted">Access global football education resources inspired by FIFA standards.</p>
          <a href="https://www.fifatrainingcentre.com" target="_blank" rel="noopener" className="btn btn-outline-primary px-4">Visit FIFA Training Centre</a>
        </div>
      </section>

      <div className="py-3 text-center bg-white">
        <a href="#top" className="btn btn-outline-dark btn-sm"><i className="bi bi-arrow-up-circle"></i> Back to Top</a>
      </div>
      <Footer />
    </>
  );
}
