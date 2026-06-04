import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';
import { supabase } from '../../lib/supabaseClient';
import { useSession } from '@supabase/auth-helpers-react';

export default function CourseView() {
  const router  = useRouter();
  const { id }  = router.query;
  const session = useSession();

  const [course,   setCourse]   = useState(null);
  const [lessons,  setLessons]  = useState([]);
  const [progress, setProgress] = useState(null);
  const [done,     setDone]     = useState({});
  const [loading,  setLoading]  = useState(true);

  useEffect(() => {
    if (!id) return;
    async function load() {
      const { data: c } = await supabase.from('courses').select('*').eq('id', id).single();
      if (!c) { router.push('/football-education'); return; }
      setCourse(c);

      const { data: ls } = await supabase.from('lessons').select('*').eq('course_id', id).order('order_index');
      setLessons(ls || []);

      if (session) {
        const { data: prog } = await supabase
          .from('player_progress').select('*').eq('user_id', session.user.id).eq('course_id', id).single();
        setProgress(prog || null);

        const { data: lp } = await supabase
          .from('lesson_progress').select('lesson_id').eq('user_id', session.user.id).eq('completed', true);
        const doneMap = {};
        (lp || []).forEach(l => { doneMap[l.lesson_id] = true; });
        setDone(doneMap);
      }
      setLoading(false);
    }
    load();
  }, [id, session]);

  const catColor = { technical:'primary', psychology:'warning', health:'danger', environment:'success', community:'info', education:'secondary' };

  if (loading) return <><NavBar /><div className="container py-5 text-center"><p>Loading course…</p></div><Footer /></>;
  if (!course) return null;

  const cc = catColor[course.category] || 'success';

  return (
    <>
      <Head><title>OFA | {course.title}</title></Head>
      <NavBar active="education" />

      {/* Header */}
      <section className="py-4 text-white" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb mb-2">
              <li className="breadcrumb-item"><Link href="/football-education" className="text-warning">Football Education</Link></li>
              <li className="breadcrumb-item active text-white">{course.title}</li>
            </ol>
          </nav>
          <div className="d-flex align-items-center gap-3 flex-wrap">
            <div>
              <span className={`badge bg-${cc} fs-6 mb-2`}>{course.category}</span>
              <h1 className="fw-bold mb-1">{course.title}</h1>
              <p className="opacity-75 mb-0">{course.description}</p>
            </div>
            {progress && (
              <div className="ms-auto text-center">
                <div className="fw-bold fs-3">{progress.progress_percent}%</div>
                <small className="opacity-75">Complete</small>
              </div>
            )}
          </div>
          {progress && (
            <div className="progress mt-3" style={{height:8}}>
              <div className="progress-bar bg-warning" style={{width:`${progress.progress_percent}%`}}></div>
            </div>
          )}
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <h4 className="fw-bold mb-4" style={{color:'#10316B'}}>
            <i className="bi bi-list-ul me-2"></i>Course Lessons — {lessons.length} Modules
          </h4>
          <div className="row g-3">
            {lessons.length === 0 ? (
              <div className="col-12 text-center py-5 text-muted">
                <i className="bi bi-collection-play fs-1 d-block mb-2 opacity-25"></i>
                <p>No lessons in this course yet.</p>
              </div>
            ) : lessons.map((lesson, i) => {
              const isDone = !!done[lesson.id];
              return (
                <div className="col-md-6" key={lesson.id}>
                  <Link href={`/lessons/${lesson.id}`} className="text-decoration-none">
                    <div className="card border-0 shadow-sm rounded-3 h-100"
                      style={{borderLeft:`4px solid ${isDone ? '#4CAF50' : '#10316B'}`}}>
                      <div className="card-body d-flex align-items-start gap-3">
                        <div className="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                          style={{width:48,height:48,background:isDone?'#4CAF50':'#10316B'}}>
                          {isDone
                            ? <i className="bi bi-check-lg text-white fs-5"></i>
                            : <span className="text-white fw-bold">{i+1}</span>
                          }
                        </div>
                        <div className="flex-grow-1">
                          <div className="d-flex justify-content-between align-items-start">
                            <h6 className="fw-bold mb-1" style={{color:'#10316B'}}>{lesson.title}</h6>
                            {isDone && <span className="badge bg-success ms-2">Done</span>}
                          </div>
                          <div className="d-flex gap-2 flex-wrap">
                            {lesson.duration && <span className="badge bg-light text-dark border"><i className="bi bi-clock me-1"></i>{lesson.duration}</span>}
                            {lesson.difficulty && <span className="badge bg-light text-dark border"><i className="bi bi-bar-chart me-1"></i>{lesson.difficulty}</span>}
                          </div>
                        </div>
                        <i className="bi bi-chevron-right text-muted"></i>
                      </div>
                    </div>
                  </Link>
                </div>
              );
            })}
          </div>
          <div className="mt-4">
            <Link href="/football-education" className="btn btn-outline-secondary">
              <i className="bi bi-arrow-left me-1"></i>Back to All Courses
            </Link>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
}
