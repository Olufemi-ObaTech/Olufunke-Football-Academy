/**
 * /guardian/learn — 5 Exclusive Guardian Courses
 * STRICTLY BLOCKED for players and coaches.
 * Shows lock/redirect for any non-guardian who attempts to access this page.
 */
import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';

const GUARDIAN_COURSES = [
  {
    id: 'gc-001',
    emoji: '🏃',
    title: 'Youth Football Development Pathway',
    description: 'Understand LTAD models, age-phase expectations, school-training balance, and how to set realistic milestones for your child.',
    level: 'Foundation',
    color: '#10316B',
    lessons: [
      'Understanding LTAD: The 7 Stages of Player Development',
      'Age-Phase Expectations: What Should My Child Be Learning?',
      'Balancing School, Training, and Family Life',
      'Setting Realistic Milestones Without Adding Pressure',
    ],
  },
  {
    id: 'gc-002',
    emoji: '🥗',
    title: 'Match-Day & Training Nutrition for Young Athletes',
    description: 'Evidence-based nutritional guidance: pre-training meals, half-time snacks, post-recovery windows, and hydration science for the Lagos climate.',
    level: 'Foundation',
    color: '#4CAF50',
    lessons: [
      'Pre-Training and Pre-Match Meals: Fuelling Right',
      'Half-Time Snacks and In-Match Refuelling',
      'Post-Match Recovery Nutrition: The 30-Minute Window',
      'Hydration Science: Heat, Lagos Climate, and Performance',
    ],
  },
  {
    id: 'gc-003',
    emoji: '🧠',
    title: 'Mental Resilience & Sideline Etiquette',
    description: 'Foster a growth mindset, manage pre-match anxiety, maintain positive sideline behaviour, and help your child navigate rejection and benching.',
    level: 'Intermediate',
    color: '#7c3aed',
    lessons: [
      'The Growth Mindset: Rewiring How Your Child Processes Failure',
      'Managing Pre-Match Anxiety: What Parents Can Do',
      'Silent Sideline Rules: The Evidence for Coaching Your Voice',
      'Dealing with Rejection, Benching, and Selection Disappointment',
    ],
  },
  {
    id: 'gc-004',
    emoji: '🩺',
    title: 'Injury Prevention, Recovery & Safeguarding',
    description: 'Warm-up protocols, ACL/ankle awareness, sleep hygiene, recognising burnout, and safeguarding your child from abuse in sport.',
    level: 'Intermediate',
    color: '#dc2626',
    lessons: [
      'Warm-Up and Cool-Down: What Every Parent Should Understand',
      'ACL, Ankle, and Growth Plate Awareness',
      'Sleep Hygiene and Recognising Burnout',
      'Safeguarding: Recognising and Reporting Abuse in Sport',
    ],
  },
  {
    id: 'gc-005',
    emoji: '🏅',
    title: 'Navigating Trials, Scouts & Football Scholarships',
    description: 'How scouts evaluate players, creating a highlight reel, NCAA/UK pathways, and understanding academy contracts — essential advanced knowledge for guardians.',
    level: 'Advanced',
    color: '#f59e0b',
    lessons: [
      'How Scouts Actually Evaluate Youth Players',
      'Creating a Professional Highlight Reel',
      'NCAA, UK Pathways and International Scholarship Options',
      'Understanding Academy Contracts and Protecting Your Child',
    ],
  },
];

export default function GuardianLearn() {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [roleCheck,    setRoleCheck]    = useState(null); // 'guardian' | 'admin' | 'blocked' | 'loading'
  const [activeCourse, setActiveCourse] = useState(null);
  const [activeLesson, setActiveLesson] = useState(null);
  const [lessonData,   setLessonData]   = useState(null);
  const [lessonLoading, setLessonLoading] = useState(false);

  useEffect(() => {
    if (!session) { router.replace('/login'); return; }
    supabase.from('profiles').select('role').eq('id', session.user.id).single()
      .then(({ data }) => {
        if (!data) { router.replace('/login'); return; }
        if (data.role === 'guardian' || data.role === 'admin') {
          setRoleCheck(data.role);
        } else {
          setRoleCheck('blocked');
        }
      });
  }, [session]);

  const openLesson = async (courseId, lessonIndex) => {
    setLessonLoading(true);
    setActiveLesson(lessonIndex);

    // Load from Supabase
    const { data } = await supabase
      .from('lessons')
      .select('*')
      .eq('course_id', courseId)
      .eq('order_index', lessonIndex + 1)
      .single();

    setLessonData(data || null);
    setLessonLoading(false);
  };

  // ── BLOCKED VIEW (Player/Coach) ─────────────────────────────────
  if (roleCheck === 'blocked') return (
    <>
      <Head><title>Access Denied | OFA</title></Head>
      <NavBar />
      <section style={{ minHeight: '70vh', display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#f0f4f8' }}>
        <div className="text-center p-5">
          <div style={{ fontSize: '5rem', marginBottom: 16 }}>🔒</div>
          <h2 className="fw-bold mb-3" style={{ color: '#dc2626' }}>Guardian-Exclusive Content</h2>
          <p className="text-muted mb-4" style={{ maxWidth: 440, margin: '0 auto 24px' }}>
            These 5 courses are exclusively for Academy Guardians (parents and legal representatives).<br />
            Players and coaches cannot access this section.
          </p>
          <div className="d-flex gap-3 justify-content-center flex-wrap">
            <Link href="/football-education" className="btn btn-primary fw-bold">Go to Player Education Hub</Link>
            <Link href="/quiz" className="btn btn-outline-primary">Take the Quiz Instead</Link>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );

  if (roleCheck === null) return (
    <>
      <NavBar />
      <div className="d-flex align-items-center justify-content-center" style={{ minHeight: '60vh' }}>
        <div className="spinner-border text-primary"></div>
      </div>
    </>
  );

  // ── LESSON VIEW ─────────────────────────────────────────────────
  if (activeCourse !== null && activeLesson !== null) {
    const course = GUARDIAN_COURSES[activeCourse];
    return (
      <>
        <Head><title>{lessonData?.title || 'Lesson'} | Guardian Courses — OFA</title></Head>
        <NavBar active="guardian-portal" />
        <section style={{ background: `linear-gradient(135deg,${course.color},#1a1a2e)`, color: '#fff', padding: '24px 0' }}>
          <div className="container">
            <button onClick={() => { setActiveLesson(null); setLessonData(null); }} className="btn btn-sm btn-outline-light mb-2">
              <i className="bi bi-arrow-left me-1"></i>Back to Courses
            </button>
            <div className="badge bg-warning text-dark mb-2">{course.emoji} {course.title}</div>
            <h2 className="fw-bold mb-0" style={{ fontSize: '1.3rem' }}>{lessonData?.title || course.lessons[activeLesson]}</h2>
          </div>
        </section>
        <main className="container py-4" style={{ maxWidth: 820 }}>
          {lessonLoading ? (
            <div className="text-center py-5"><div className="spinner-border" style={{ color: course.color }}></div><p className="mt-3 text-muted">Loading lesson…</p></div>
          ) : lessonData ? (
            <div className="card border-0 shadow-sm rounded-4">
              <div className="card-body p-4 p-md-5">
                <div className="mb-4 p-3 rounded-3" style={{ background: `${course.color}10`, borderLeft: `4px solid ${course.color}` }}>
                  <span className="fw-bold small" style={{ color: course.color }}>Lesson {activeLesson + 1} of 4 — {course.title}</span>
                </div>
                <div style={{ lineHeight: 1.85, fontSize: '.92rem', whiteSpace: 'pre-line' }}>
                  {lessonData.content}
                </div>
                <div className="d-flex gap-3 mt-5 flex-wrap">
                  {activeLesson > 0 && (
                    <button className="btn btn-outline-secondary" onClick={() => openLesson(course.id, activeLesson - 1)}>
                      <i className="bi bi-arrow-left me-1"></i>Previous Lesson
                    </button>
                  )}
                  {activeLesson < 3 && (
                    <button className="btn fw-bold" style={{ background: course.color, color: '#fff' }} onClick={() => openLesson(course.id, activeLesson + 1)}>
                      Next Lesson <i className="bi bi-arrow-right ms-1"></i>
                    </button>
                  )}
                  {activeLesson === 3 && (
                    <button className="btn btn-success fw-bold" onClick={() => { setActiveLesson(null); setLessonData(null); }}>
                      <i className="bi bi-check-circle-fill me-1"></i>Course Complete!
                    </button>
                  )}
                </div>
              </div>
            </div>
          ) : (
            <div className="card border-0 shadow-sm rounded-4 p-4 p-md-5">
              <div className="mb-4 p-3 rounded-3" style={{ background: `${course.color}10`, borderLeft: `4px solid ${course.color}` }}>
                <span className="fw-bold small" style={{ color: course.color }}>Lesson {activeLesson + 1} of 4 — {course.title}</span>
              </div>
              <h4 className="fw-bold mb-3">{course.lessons[activeLesson]}</h4>
              <p className="text-muted">Full lesson content is stored in the database. Please ensure the <code>guardian_courses_seed.sql</code> has been run in your Supabase project to populate lesson content.</p>
              <div className="d-flex gap-3 mt-4 flex-wrap">
                {activeLesson > 0 && (
                  <button className="btn btn-outline-secondary" onClick={() => openLesson(course.id, activeLesson - 1)}>
                    <i className="bi bi-arrow-left me-1"></i>Previous
                  </button>
                )}
                {activeLesson < 3 && (
                  <button className="btn fw-bold" style={{ background: course.color, color: '#fff' }} onClick={() => openLesson(course.id, activeLesson + 1)}>
                    Next Lesson <i className="bi bi-arrow-right ms-1"></i>
                  </button>
                )}
              </div>
            </div>
          )}
        </main>
        <Footer />
      </>
    );
  }

  // ── COURSE LIST VIEW ────────────────────────────────────────────
  return (
    <>
      <Head><title>Guardian Courses | Olufunke Football Academy</title></Head>
      <NavBar active="guardian-portal" />

      <section style={{ background: 'linear-gradient(135deg,#1a5c2a 0%,#10316B 100%)', color: '#fff', padding: '36px 0' }}>
        <div className="container">
          <Link href="/guardian/dashboard" className="text-warning text-decoration-none small d-block mb-3">
            <i className="bi bi-arrow-left me-1"></i>Guardian Portal
          </Link>
          <div className="badge bg-warning text-dark mb-2" style={{ fontSize: '.75rem' }}>
            <i className="bi bi-lock-fill me-1"></i>GUARDIAN EXCLUSIVE — Players cannot access this section
          </div>
          <h1 className="fw-bold mb-2" style={{ fontSize: '1.7rem' }}>
            <i className="bi bi-mortarboard-fill me-2"></i>Your Guardian Courses
          </h1>
          <p className="opacity-75 mb-0">5 courses · 20 lessons · Exclusively for OFA Guardians</p>
          <div className="mt-3 d-flex gap-2 flex-wrap">
            <span className="badge bg-white text-dark"><i className="bi bi-book-fill text-success me-1"></i>5 Exclusive Courses</span>
            <span className="badge bg-white text-dark"><i className="bi bi-list-check text-primary me-1"></i>20 Lessons</span>
            <span className="badge bg-white text-dark"><i className="bi bi-shield-fill-check text-warning me-1"></i>Guardians Only</span>
          </div>
        </div>
      </section>

      <main className="container py-5">
        <div className="row g-4">
          {GUARDIAN_COURSES.map((course, idx) => (
            <div className="col-md-6 col-lg-4" key={course.id}>
              <div className="card border-0 shadow-sm rounded-4 h-100 overflow-hidden" style={{ borderTop: `4px solid ${course.color}` }}>
                <div className="card-body p-4">
                  <div className="d-flex align-items-center gap-3 mb-3">
                    <span style={{ fontSize: '2rem' }}>{course.emoji}</span>
                    <div>
                      <span className="badge" style={{ background: `${course.color}15`, color: course.color, fontSize: '.7rem', fontWeight: 700 }}>
                        {course.level}
                      </span>
                      <div className="badge bg-danger ms-1" style={{ fontSize: '.65rem' }}>GUARDIAN ONLY</div>
                    </div>
                  </div>
                  <h5 className="fw-bold mb-2" style={{ color: course.color, fontSize: '1rem' }}>{course.title}</h5>
                  <p className="text-muted mb-3" style={{ fontSize: '.84rem', lineHeight: 1.6 }}>{course.description}</p>

                  <div className="mb-4">
                    {course.lessons.map((lesson, li) => (
                      <div key={li} className="d-flex align-items-start gap-2 mb-2">
                        <i className="bi bi-play-circle-fill mt-1 flex-shrink-0" style={{ color: course.color, fontSize: '.9rem' }}></i>
                        <span style={{ fontSize: '.8rem', color: '#374151' }}>{lesson}</span>
                      </div>
                    ))}
                  </div>

                  <button
                    className="btn w-100 fw-bold"
                    style={{ background: course.color, color: '#fff', borderRadius: 10 }}
                    onClick={() => { setActiveCourse(idx); openLesson(course.id, 0); }}
                  >
                    <i className="bi bi-play-fill me-1"></i>Start Course
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Also access player education hub */}
        <div className="mt-5 p-4 rounded-4 text-center" style={{ background: 'linear-gradient(135deg,#eff6ff,#f0fdf4)' }}>
          <h5 className="fw-bold mb-2" style={{ color: '#10316B' }}>
            <i className="bi bi-book-fill me-2"></i>You Also Have Read-Only Access to the Player Education Hub
          </h5>
          <p className="text-muted mb-3" style={{ fontSize: '.88rem' }}>Browse all player and coach lessons. You cannot submit assignments or earn points — <strong>Parent Viewing Mode</strong> only.</p>
          <Link href="/football-education" className="btn btn-outline-primary fw-bold">
            <i className="bi bi-eye-fill me-2"></i>Browse Player Education Hub
          </Link>
        </div>
      </main>
      <Footer />
    </>
  );
}
