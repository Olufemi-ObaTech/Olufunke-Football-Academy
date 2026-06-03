import Head from 'next/head';
import Link from 'next/link';
import { useEffect, useState } from 'react';
import { supabase } from '../lib/supabaseClient';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';
import QuizCTA from '../components/QuizCTA';

export default function About() {
  const [team, setTeam] = useState([]);

  useEffect(() => {
    supabase.from('management_team').select('*').order('sort_order').then(({ data }) => setTeam(data || []));
  }, []);

  const LOGO = '/images/OFA New Logo.jpg';

  return (
    <>
      <Head><title>Olufunke Football Academy | About Us</title></Head>
      <NavBar active="about" />

      {/* Hero */}
      <section className="py-5 text-white" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container text-center">
          <img src={LOGO} alt="OFA Logo" style={{width:100,height:100,borderRadius:'50%',border:'3px solid #ffc107',objectFit:'cover'}} className="mb-3 shadow" />
          <h1 className="fw-bold display-5">About Olufunke Football Academy</h1>
          <p className="lead opacity-75">Reshaping Nigerian football — blending elite sports development with academic, health, and character education.</p>
        </div>
      </section>

      {/* History */}
      <section className="py-5">
        <div className="container">
          <div className="row align-items-center g-5">
            <div className="col-md-6">
              <h2 className="fw-bold mb-3" style={{color:'#10316B'}}>History of Olufunke Football Academy</h2>
              <p>Olufunke Football Academy <strong>(OFA)</strong> is duly Registered and Affiliated with <strong>FIFA TMS</strong>, <strong>Lagos State Football Association</strong>, and the <strong>Nigeria Football Federation</strong>.</p>
              <p>Incorporated in <strong>September 2023</strong>, OFA is focused on discovering young, talented footballers and making them better people in society. Based in the vibrant city of Lagos, OFA is registered under <strong>RC-7147523</strong>.</p>
              <p>The academy emerged from the conviction that Nigeria&apos;s footballing future depends not only on athletic prowess but also on strong ethical foundations, academic achievement, and community engagement.</p>
              <div className="d-flex flex-wrap gap-2 mt-3">
                <span className="badge fs-6 px-3 py-2" style={{background:'#10316B'}}>FIFA TMS Registered</span>
                <span className="badge fs-6 px-3 py-2 bg-success">LSFA Affiliated</span>
                <span className="badge fs-6 px-3 py-2 bg-warning text-dark">NFF Member</span>
                <span className="badge fs-6 px-3 py-2 bg-secondary">RC-7147523</span>
              </div>
            </div>
            <div className="col-md-6 text-center">
              <img src="/images/OFA2.jpg" alt="OFA Team" className="img-fluid rounded-3 shadow" style={{maxHeight:380,objectFit:'cover',width:'100%'}} onError={e=>e.target.src=LOGO} />
            </div>
          </div>
        </div>
      </section>

      {/* Vision & Mission */}
      <section className="py-5" style={{background:'#f0f4ff'}}>
        <div className="container">
          <div className="row g-4">
            <div className="col-md-6">
              <div className="p-4 rounded-3 shadow-sm h-100 bg-white border-start border-4 border-primary">
                <h3 className="fw-bold mb-3" style={{color:'#10316B'}}><i className="bi bi-eye-fill text-warning me-2"></i>Our Vision</h3>
                <p className="mb-0">To become <strong>Africa&apos;s most prestigious football academy</strong>, setting benchmarks in player development, education, and responsible citizenship — inspiring hope across the continent and beyond.</p>
              </div>
            </div>
            <div className="col-md-6">
              <div className="p-4 rounded-3 shadow-sm h-100 bg-white border-start border-4 border-success">
                <h3 className="fw-bold mb-3" style={{color:'#10316B'}}><i className="bi bi-bullseye text-success me-2"></i>Our Mission</h3>
                <ul className="mb-0 ps-3">
                  <li className="mb-2">Nurture young footballers into champions and role models, equipped for success on and off the field.</li>
                  <li className="mb-2">Blend technical mastery with holistic education, health awareness, and social responsibility.</li>
                  <li className="mb-2">Foster a culture of integrity, teamwork, resilience, and lifelong learning.</li>
                  <li>Promote diversity, gender equality, and inclusivity in Nigerian sport.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Core Values */}
      <section className="py-5">
        <div className="container">
          <h2 className="fw-bold text-center mb-5" style={{color:'#10316B'}}>Our Core Values</h2>
          <div className="row g-4 text-center">
            {[['🏆','Excellence','Continuous pursuit of high standards.'],['⚖️','Integrity','Doing what\'s right, even when unseen.'],['🤝','Teamwork','Wins are built on unity and collaboration.'],['🎯','Discipline','Dedication and respect at every stage.']].map(([icon,title,desc])=>(
              <div className="col-6 col-md-3" key={title}>
                <div className="p-4 rounded-3 shadow-sm bg-white h-100">
                  <div className="fs-1 mb-2">{icon}</div>
                  <h5 className="fw-bold" style={{color:'#10316B'}}>{title}</h5>
                  <p className="text-muted small mb-0">{desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Leadership */}
      <section className="py-5" style={{background:'#f0f4ff'}}>
        <div className="container">
          <h2 className="fw-bold text-center mb-5" style={{color:'#10316B'}}>Leadership &amp; Commitment</h2>
          <div className="row align-items-center g-5 mb-5">
            <div className="col-md-5 text-center">
              <img src="/images/Olufunke Football Academy president.jpg" alt="OFA President" className="img-fluid rounded-3 shadow" style={{maxHeight:360,objectFit:'cover',width:'100%'}} onError={e=>e.target.src=LOGO} />
            </div>
            <div className="col-md-7">
              <h4 className="fw-bold" style={{color:'#10316B'}}>Adeshina Akintayo Peter</h4>
              <p className="text-success fw-semibold mb-3">Founder &amp; President</p>
              <p>Under the stewardship of <strong>Adeshina Akintayo Peter</strong>, OFA cultivates the next generation of leaders — not just athletes. Every program is guided by a dedicated team of licensed coaches, health educators, and community mentors.</p>
            </div>
          </div>

          <h3 className="fw-bold text-center mb-4" style={{color:'#10316B'}}>Our Management Team</h3>
          <div className="row g-4 justify-content-center">
            {team.map(m=>(
              <div className="col-6 col-md-3" key={m.id}>
                <div className="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                  <div className="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style={{width:64,height:64}}>
                    <i className="bi bi-person-fill text-white fs-3"></i>
                  </div>
                  <h6 className="fw-bold mb-1" style={{color:'#10316B'}}>{m.name}</h6>
                  <p className="text-success small mb-2">{m.role}</p>
                  {m.email && <a href={`mailto:${m.email}`} className="btn btn-sm btn-outline-primary"><i className="bi bi-envelope"></i> Email</a>}
                </div>
              </div>
            ))}
          </div>
          <div className="text-center mt-4">
            <a href="mailto:Olufunkefootballacademy@gmail.com" className="btn btn-outline-dark"><i className="bi bi-envelope-fill"></i> Contact Full Management Team</a>
          </div>
        </div>
      </section>

      {/* Programs */}
      <section className="py-5">
        <div className="container">
          <h2 className="fw-bold text-center mb-5" style={{color:'#10316B'}}>Our Unique Programs</h2>
          <div className="row g-4">
            {[
              ['🎓','Football Education','Modular video courses on technical skills, tactical theory, and sports psychology.','/login','Explore E-Learning','btn-primary'],
              ['⚽','Technical Training','Individual and group sessions focusing on ball mastery, tactical awareness, and physical fitness.','/contact','Book a Session','btn-success'],
              ['🏥','Health Education','Nutrition, mental health, and injury prevention counseling led by certified professionals.',null,null,null],
              ['🌱','Environmental Initiatives','"Green Goal" campaigns teaching sustainability and stewardship of local playing fields.',null,null,null],
              ['🤲','Community Engagement','Volunteering, mentorship and outreach programs foster inclusivity and giving back.',null,null,null],
            ].map(([icon,title,desc,href,btnLabel,btnClass])=>(
              <div className="col-md-4" key={title}>
                <div className="p-4 rounded-3 shadow-sm bg-white h-100 text-center">
                  <div className="fs-1 mb-3">{icon}</div>
                  <h5 className="fw-bold" style={{color:'#10316B'}}>{title}</h5>
                  <p className="text-muted">{desc}</p>
                  {href && <Link href={href} className={`btn btn-sm ${btnClass}`}>{btnLabel}</Link>}
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* FIFA */}
      <section className="bg-light py-5">
        <div className="container text-center">
          <h2 className="fw-bold">🌍 FIFA Talent Development</h2>
          <p className="text-muted">We align with global standards through FIFA&apos;s Training Centre and international partnerships.</p>
          <a href="https://www.fifatrainingcentre.com" target="_blank" rel="noopener" className="btn btn-outline-primary px-4">Visit FIFA Training Centre</a>
        </div>
      </section>

      <QuizCTA />
      <div className="py-3 text-center bg-white"><a href="#top" className="btn btn-outline-dark btn-sm"><i className="bi bi-arrow-up-circle"></i> Back to Top</a></div>
      <Footer />
    </>
  );
}
