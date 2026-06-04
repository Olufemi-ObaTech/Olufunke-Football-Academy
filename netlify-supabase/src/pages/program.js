import Head from 'next/head';
import Link from 'next/link';
import { useEffect, useState } from 'react';
import { useRouter } from 'next/router';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';
import QuizCTA from '../components/QuizCTA';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';

export default function Program() {
  const session    = useSession();
  const supabaseCl = useSupabaseClient();
  const router     = useRouter();
  const [access, setAccess] = useState(null);

  useEffect(() => {
    if (session === null) { router.replace('/login?redirect=/program'); return; }
    if (!session) return;
    supabaseCl.from('profiles').select('role,status').eq('id', session.user.id).single()
      .then(({ data }) => {
        setAccess(data && (data.role === 'admin' || (data.role === 'player' && data.status === 'approved')));
      });
  }, [session]);

  if (access === null) return <><NavBar /><div style={{display:'flex',alignItems:'center',justifyContent:'center',minHeight:'60vh'}}><div className="spinner-border text-primary"></div></div><Footer /></>;

  if (access === false) return (
    <>
      <Head><title>OFA | Members Only</title></Head>
      <NavBar />
      <section className="py-5 text-white text-center" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)',minHeight:'60vh',display:'flex',alignItems:'center'}}>
        <div className="container">
          <div style={{fontSize:'4rem'}}>🔒</div>
          <h1 className="fw-bold mt-3 mb-3">Members Only</h1>
          <p className="lead opacity-75 mb-4">Our Program is exclusively available to approved OFA players.</p>
          <Link href="/register" className="btn btn-warning btn-lg fw-bold px-5 me-3"><i className="bi bi-person-plus-fill me-2"></i>Register</Link>
          <Link href="/contact" className="btn btn-outline-light btn-lg px-5"><i className="bi bi-telephone-fill me-2"></i>Contact Us</Link>
        </div>
      </section>
      <Footer />
    </>
  );
  const achievements = [
    { icon:'🏆', label:'Lagos State U17 Champions' },
    { icon:'⚽', label:'Lagos State League Finalists' },
    { icon:'🥇', label:'Unbeaten Tournament Run' },
    { icon:'🌍', label:'FIFA TMS Registered' },
  ];
  const beyond = [
    { icon:'🏥', title:'Health Education',       desc:'Nutrition, mental health, and injury prevention counseling led by certified professionals. We ensure every player is physically and mentally equipped.' },
    { icon:'🌱', title:'Environmental Initiatives', desc:'"Green Goal" campaigns teaching sustainability and stewardship of local playing fields and environments.' },
    { icon:'🤲', title:'Community Engagement',   desc:'Volunteering, mentorship and outreach programs foster inclusivity and a sense of giving back. OFA graduates lead in their communities.' },
  ];

  return (
    <>
      <Head><title>Olufunke FA | Our Program</title></Head>
      <NavBar active="program" />

      {/* Hero */}
      <section className="py-5 text-white" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <div className="row align-items-center g-4">
            <div className="col-md-7">
              <h1 className="fw-bold display-5">Our Program</h1>
              <p className="lead opacity-75">A holistic football development pathway — from grassroots to elite competition — built on technical excellence, education, and character.</p>
              <Link href="/contact" className="btn btn-warning btn-lg fw-bold shadow">Book a Trial</Link>
            </div>
            <div className="col-md-5 text-center d-none d-md-block">
              <img src="/images/OFA.jpg" alt="OFA Training" className="img-fluid rounded-3 shadow"
                style={{maxHeight:300,objectFit:'cover',width:'100%'}} onError={e=>e.target.src='/images/OFA New Logo.jpg'} />
            </div>
          </div>
        </div>
      </section>

      {/* Technical Training */}
      <section className="py-5">
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-md-6">
              <img src="/images/training ground.jpg" alt="Technical Training" className="img-fluid rounded-3 shadow"
                style={{maxHeight:340,objectFit:'cover',width:'100%'}} onError={e=>e.target.src='/images/OFA New Logo.jpg'} />
            </div>
            <div className="col-md-6">
              <h2 className="fw-bold mb-3" style={{color:'#10316B'}}>
                <i className="bi bi-lightning-charge-fill text-warning me-2"></i>Technical Training
              </h2>
              <p>Individual and group sessions focusing on <strong>ball mastery, tactical awareness, game intelligence, and physical fitness</strong>. Our licensed coaches deliver structured drills that mirror elite-level training environments.</p>
              <ul className="list-unstyled mt-3">
                {['Ball control & dribbling mastery','Passing, shooting & set-piece training','Tactical positioning & game intelligence','Physical conditioning & fitness','Video analysis & performance review'].map(t=>(
                  <li className="mb-2" key={t}><i className="bi bi-check-circle-fill text-success me-2"></i>{t}</li>
                ))}
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* Team Formation */}
      <section className="py-5" style={{background:'#f0f4ff'}}>
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-md-6 order-md-2">
              <img src="/images/studium.jpg" alt="Team Formation" className="img-fluid rounded-3 shadow"
                style={{maxHeight:340,objectFit:'cover',width:'100%'}} onError={e=>e.target.src='/images/OFA New Logo.jpg'} />
            </div>
            <div className="col-md-6 order-md-1">
              <h2 className="fw-bold mb-3" style={{color:'#10316B'}}>
                <i className="bi bi-people-fill text-primary me-2"></i>Team Formation
              </h2>
              <p>Structured teams by age and skill level, with regular intra-academy matches and participation in tournaments and leagues.</p>
              <ul className="list-unstyled mt-3">
                {['Age-group squads: U13, U15, U17, U19','Regular intra-academy matches','Lagos State League participation','National tournament exposure'].map(t=>(
                  <li className="mb-2" key={t}><i className="bi bi-check-circle-fill text-success me-2"></i>{t}</li>
                ))}
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* Tournaments */}
      <section className="py-5">
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-md-6">
              <img src="/images/cele1.jpg" alt="Tournaments" className="img-fluid rounded-3 shadow"
                style={{maxHeight:340,objectFit:'cover',width:'100%'}} onError={e=>e.target.src='/images/OFA New Logo.jpg'} />
            </div>
            <div className="col-md-6">
              <h2 className="fw-bold mb-3" style={{color:'#10316B'}}>
                <i className="bi bi-trophy-fill text-warning me-2"></i>Tournaments &amp; Competitions
              </h2>
              <p>Active involvement in local, regional, and national competitions, driving exposure and experience for our players.</p>
              <div className="row g-3 mt-2">
                {achievements.map(a=>(
                  <div className="col-6" key={a.label}>
                    <div className="p-3 bg-white rounded-3 shadow-sm text-center">
                      <div className="fw-bold fs-4">{a.icon}</div>
                      <small className="fw-semibold">{a.label}</small>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Beyond the Pitch */}
      <section className="py-5" style={{background:'#f0f4ff'}}>
        <div className="container">
          <h2 className="fw-bold text-center mb-5" style={{color:'#10316B'}}>Beyond the Pitch</h2>
          <div className="row g-4">
            {beyond.map(b=>(
              <div className="col-md-4" key={b.title}>
                <div className="p-4 bg-white rounded-3 shadow-sm h-100 text-center">
                  <div className="fs-1 mb-3">{b.icon}</div>
                  <h5 className="fw-bold" style={{color:'#10316B'}}>{b.title}</h5>
                  <p className="text-muted">{b.desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-5">
        <div className="container">
          <div className="p-5 rounded-3 text-white text-center shadow" style={{background:'linear-gradient(90deg,#4CAF50 40%,#10316B 100%)'}}>
            <h2 className="fw-bold mb-3">Ready to Join OFA?</h2>
            <p className="lead mb-4">OFA graduates are not only ready for elite competitions, but are also prepared for leadership in their communities and beyond.</p>
            <Link href="/contact" className="btn btn-warning btn-lg fw-bold px-5">Contact Us Now</Link>
          </div>
        </div>
      </section>

      <div className="py-3 text-center bg-white">
        <a href="#top" className="btn btn-outline-dark btn-sm"><i className="bi bi-arrow-up-circle"></i> Back to Top</a>
      </div>
      <QuizCTA />
      <Footer />
    </>
  );
}
