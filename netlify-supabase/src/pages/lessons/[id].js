import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';
import { supabase } from '../../lib/supabaseClient';
import { useSession } from '@supabase/auth-helpers-react';

export default function LessonView() {
  const router  = useRouter();
  const { id }  = router.query;
  const session = useSession();

  const [lesson,      setLesson]      = useState(null);
  const [course,      setCourse]      = useState(null);
  const [allLessons,  setAllLessons]  = useState([]);
  const [prevLesson,  setPrevLesson]  = useState(null);
  const [nextLesson,  setNextLesson]  = useState(null);
  const [isDone,      setIsDone]      = useState(false);
  const [doneLessons, setDoneLessons] = useState({});
  const [completing,  setCompleting]  = useState(false);
  const [loading,     setLoading]     = useState(true);

  useEffect(() => {
    if (!id) return;
    async function load() {
      const { data: l } = await supabase.from('lessons').select('*').eq('id', id).single();
      if (!l) { router.push('/football-education'); return; }
      setLesson(l);

      const { data: c } = await supabase.from('courses').select('*').eq('id', l.course_id).single();
      setCourse(c);

      const { data: ls } = await supabase.from('lessons').select('*').eq('course_id', l.course_id).order('order_index');
      setAllLessons(ls || []);

      const idx = (ls || []).findIndex(x => x.id === l.id);
      setPrevLesson(idx > 0 ? ls[idx - 1] : null);
      setNextLesson(idx < (ls || []).length - 1 ? ls[idx + 1] : null);

      if (session) {
        const { data: lp } = await supabase
          .from('lesson_progress').select('lesson_id').eq('user_id', session.user.id)
          .eq('completed', true).in('lesson_id', (ls||[]).map(x=>x.id));
        const doneMap = {};
        (lp || []).forEach(x => { doneMap[x.lesson_id] = true; });
        setDoneLessons(doneMap);
        setIsDone(!!doneMap[l.id]);
      }
      setLoading(false);
    }
    load();
  }, [id, session]);

  const markComplete = async () => {
    if (!session || isDone || completing) return;
    setCompleting(true);

    await supabase.from('lesson_progress').upsert({
      user_id:      session.user.id,
      lesson_id:    parseInt(id),
      completed:    true,
      completed_at: new Date().toISOString(),
    });

    // Update course progress
    if (course) {
      const total = allLessons.length;
      const newDone = { ...doneLessons, [parseInt(id)]: true };
      const doneCount = Object.keys(newDone).length;
      const pct = total > 0 ? Math.round((doneCount / total) * 100) : 0;
      const status = pct >= 100 ? 'completed' : 'in_progress';

      await supabase.from('player_progress').upsert({
        user_id:          session.user.id,
        course_id:        course.id,
        status,
        progress_percent: pct,
        started_at:       new Date().toISOString(),
        completed_at:     status === 'completed' ? new Date().toISOString() : null,
      });
    }

    setIsDone(true);
    setCompleting(false);

    if (nextLesson) {
      setTimeout(() => router.push(`/lessons/${nextLesson.id}`), 1200);
    }
  };

  if (loading) return <><NavBar active="education" /><div className="container py-5 text-center"><p>Loading lesson…</p></div><Footer /></>;
  if (!lesson) return null;

  return (
    <>
      <Head><title>OFA | {lesson.title}</title></Head>
      <NavBar active="education" />

      {/* Header */}
      <section className="py-4 text-white" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb mb-2">
              <li className="breadcrumb-item">
                <Link href="/football-education" className="text-warning">Football Education</Link>
              </li>
              {course && (
                <li className="breadcrumb-item">
                  <Link href={`/courses/${course.id}`} className="text-warning">{course.title}</Link>
                </li>
              )}
              <li className="breadcrumb-item active text-white">{lesson.title}</li>
            </ol>
          </nav>
          <div className="d-flex align-items-center gap-3 flex-wrap">
            <div className="rounded-circle bg-warning d-flex align-items-center justify-content-center"
              style={{width:56,height:56,minWidth:56}}>
              <i className={`bi ${lesson.icon || 'bi-book'} fs-3 text-dark`}></i>
            </div>
            <div>
              <h1 className="fw-bold mb-1 fs-3">{lesson.title}</h1>
              <div className="d-flex gap-2 flex-wrap">
                {lesson.duration   && <span className="badge bg-white text-dark"><i className="bi bi-clock me-1"></i>{lesson.duration}</span>}
                {lesson.difficulty && <span className="badge bg-white text-dark"><i className="bi bi-bar-chart me-1"></i>{lesson.difficulty}</span>}
                {isDone            && <span className="badge bg-success"><i className="bi bi-check-circle-fill me-1"></i>Completed</span>}
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row g-4">

            {/* Main content */}
            <div className="col-lg-8">
              <div className="card border-0 shadow-sm rounded-3">
                <div className="card-body p-4 p-md-5">
                  <div style={{lineHeight:1.9,fontSize:'1.05rem',color:'#333',whiteSpace:'pre-wrap'}}>
                    {lesson.content || 'Lesson content coming soon.'}
                  </div>

                  {/* Video */}
                  {lesson.video_url && (
                    <div className="mt-4 ratio ratio-16x9">
                      <iframe src={lesson.video_url} title={lesson.title} allowFullScreen></iframe>
                    </div>
                  )}

                  {/* Complete button */}
                  <div className="mt-5 pt-3 border-top">
                    {!session ? (
                      <div className="alert alert-warning">
                        <Link href="/login" className="fw-bold">Login</Link> to track your lesson progress.
                      </div>
                    ) : isDone ? (
                      <div className="alert alert-success d-flex align-items-center gap-2 mb-0">
                        <i className="bi bi-check-circle-fill fs-4"></i>
                        <div><strong>Lesson Completed!</strong> Great work. Move on to the next lesson.</div>
                      </div>
                    ) : (
                      <button className="btn btn-success btn-lg fw-bold px-5" onClick={markComplete} disabled={completing}>
                        {completing
                          ? <><span className="spinner-border spinner-border-sm me-2"></span>Saving…</>
                          : <><i className="bi bi-check-circle-fill me-2"></i>Mark as Complete</>
                        }
                      </button>
                    )}
                  </div>
                </div>
              </div>

              {/* Prev / Next navigation */}
              <div className="d-flex justify-content-between mt-4 gap-3">
                {prevLesson ? (
                  <Link href={`/lessons/${prevLesson.id}`} className="btn btn-outline-secondary flex-grow-1">
                    <i className="bi bi-arrow-left me-1"></i>{prevLesson.title.slice(0,30)}{prevLesson.title.length>30?'…':''}
                  </Link>
                ) : <div className="flex-grow-1"></div>}

                {nextLesson ? (
                  <Link href={`/lessons/${nextLesson.id}`} className="btn btn-primary flex-grow-1 text-end">
                    {nextLesson.title.slice(0,30)}{nextLesson.title.length>30?'…':''}<i className="bi bi-arrow-right ms-1"></i>
                  </Link>
                ) : course && (
                  <Link href={`/courses/${course.id}`} className="btn btn-success flex-grow-1">
                    <i className="bi bi-trophy-fill me-1"></i>Course Complete — View Summary
                  </Link>
                )}
              </div>
            </div>

            {/* Sidebar — all lessons */}
            <div className="col-lg-4">
              <div className="card border-0 shadow-sm rounded-3 sticky-top" style={{top:80}}>
                <div className="card-header fw-bold py-3" style={{background:'#10316B',color:'#fff'}}>
                  <i className="bi bi-list-ul me-2"></i>{course?.title || 'Lessons'}
                </div>
                <div className="card-body p-0">
                  {allLessons.map((l, i) => {
                    const lDone    = !!doneLessons[l.id];
                    const isCurrent = l.id === lesson.id;
                    return (
                      <Link key={l.id} href={`/lessons/${l.id}`}
                        className="d-flex align-items-center gap-3 p-3 text-decoration-none border-bottom"
                        style={{background: isCurrent ? 'rgba(16,49,107,.08)' : '#fff', transition:'background .2s'}}>
                        <div className="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                          style={{width:32,height:32,
                            background: isCurrent ? '#10316B' : lDone ? '#4CAF50' : '#e9ecef'}}>
                          {isCurrent
                            ? <i className="bi bi-play-fill text-white" style={{fontSize:'.7rem'}}></i>
                            : lDone
                              ? <i className="bi bi-check-lg text-white" style={{fontSize:'.7rem'}}></i>
                              : <span className="small fw-bold text-muted">{i+1}</span>
                          }
                        </div>
                        <div className="flex-grow-1 min-w-0">
                          <div className="small fw-semibold text-truncate" style={{color: isCurrent ? '#10316B' : '#333'}}>
                            {l.title}
                          </div>
                          {l.duration && <div className="text-muted" style={{fontSize:'.75rem'}}>{l.duration}</div>}
                        </div>
                      </Link>
                    );
                  })}
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>
      <Footer />
    </>
  );
}
