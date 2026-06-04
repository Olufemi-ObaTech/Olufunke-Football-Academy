/**
 * pages/index.js — OFA Academy Home
 * Mirrors the Laravel home.blade.php design exactly.
 * Data sourced from Supabase (same tables as Laravel MySQL).
 */
import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { supabase } from '../lib/supabaseClient';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';
import QuizCTA from '../components/QuizCTA';

export default function Home() {
  const [latestNews,      setLatestNews]      = useState([]);
  const [matchReports,    setMatchReports]    = useState([]);
  const [mediaHighlights, setMediaHighlights] = useState([]);
  const [matchResults,    setMatchResults]    = useState([]);
  const [standings,       setStandings]       = useState([]);
  const [players,         setPlayers]         = useState([]);
  const [lastResult,      setLastResult]      = useState(null);
  const [nextFixture,     setNextFixture]     = useState(null);
  const [loading,         setLoading]         = useState(true);
  const [activeTab,       setActiveTab]       = useState('latest');
  const [openCollapse,    setOpenCollapse]    = useState({});

  useEffect(() => {
    async function load() {
      const [
        { data: ln }, { data: mr }, { data: mh },
        { data: res }, { data: st }, { data: pl },
        { data: nf },
      ] = await Promise.all([
        supabase.from('posts').select('*').eq('type','latest').order('created_at',{ascending:false}),
        supabase.from('posts').select('*').eq('type','report').order('created_at',{ascending:false}),
        supabase.from('posts').select('*').eq('type','media').order('created_at',{ascending:false}),
        supabase.from('match_results').select('*').order('match_date',{ascending:false}),
        supabase.from('standings').select('*').order('rank'),
        supabase.from('players').select('*'),
        supabase.from('next_fixtures').select('*').eq('is_active',true).order('fixture_date').limit(1),
      ]);
      setLatestNews(ln||[]);
      setMatchReports(mr||[]);
      setMediaHighlights(mh||[]);
      setMatchResults(res||[]);
      setStandings(st||[]);
      setPlayers(pl||[]);
      setLastResult((res||[])[0]||null);
      setNextFixture((nf||[])[0]||null);
      setLoading(false);
    }
    load();
  }, []);

  const toggle = (id) => setOpenCollapse(p => ({...p,[id]:!p[id]}));
  const fmt = (d,opts) => d ? new Date(d).toLocaleDateString('en-GB',opts) : '';
  const fmtTime = (t) => { if(!t) return ''; const d=new Date(`1970-01-01T${t}`); return d.toLocaleTimeString('en-GB',{hour:'numeric',minute:'2-digit',hour12:true}); };
  const limit = (s,n) => s && s.length>n ? s.slice(0,n)+'…' : s;


  const LOGO = '/images/OFA New Logo.jpg';

  return (
    <>
      <Head>
        <title>Olufunke Football Academy | Official Website</title>
        <style>{`
          body{font-family:'Montserrat',Arial,sans-serif;background:#f9f9f9;color:#222831;}
          .hero-section{background:linear-gradient(rgba(16,49,107,.8),rgba(16,49,107,.7)),url('/images/OFA 1.jpg') center/cover no-repeat;color:#fff;min-height:450px;display:flex;align-items:center;}
          .hero-overlay{background:rgba(16,49,107,.66);padding:50px 0;border-radius:0 0 40px 40px;}
          .scoreboard-table{background:#fff;border-radius:14px;box-shadow:0 4px 16px rgba(16,49,107,.09);overflow:hidden;}
          .player-card{background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(16,49,107,.06);transition:transform .18s;}
          .player-card:hover{transform:translateY(-4px) scale(1.02);}
          .cta-banner{background:linear-gradient(90deg,#4CAF50 42%,#10316B 100%);color:#fff;border-radius:14px;box-shadow:0 6px 24px rgba(16,49,107,.11);padding:36px;text-align:center;}
          .profile-img-fallback{width:110px;height:110px;border-radius:50%;background:linear-gradient(135deg,#10316B,#4CAF50);display:flex;align-items:center;justify-content:center;color:#fff;font-size:2.5rem;border:3px solid #4CAF50;}
          .news-card .card-img-top{background:#e9ecef;min-height:200px;}
          .news-tabs .nav-link{color:#444;}
          .news-tabs .nav-link.active{font-weight:700;}
        `}</style>
      </Head>

      {/* ── NAVBAR ── */}
      <NavBar active="home" />

      {/* ── HERO ── */}
      <section className="hero-section" id="top">
        <div className="container hero-overlay">
          <div className="row align-items-center">
            <div className="col-md-8">
              <span className="badge bg-warning text-dark fw-bold mb-2 px-3 py-2 fs-6">⚽ 2026/2027 LSFA State League — Atlantic Conference</span>
              <h1 className="display-4 fw-bold mb-3">Chasing Excellence, Inspiring Futures</h1>
              <p className="lead mb-4">Welcome to <b>Olufunke Football Academy</b>, Nigeria&apos;s Next Footballing Powerhouse. Committed to Nurturing Tomorrow&apos;s Talent with World-class Coaching Education, and Unwavering Values.</p>
              <div className="d-flex flex-wrap gap-2">
                <Link href="/about" className="btn btn-warning btn-lg shadow fw-bold">Explore Our Vision</Link>
                <Link href="/contact" className="btn btn-outline-light btn-lg">Book a Trial</Link>
              </div>
            </div>
            <div className="col-md-4 text-center d-none d-md-block">
              <img src={LOGO} alt="OFA Emblem" className="img-fluid shadow" style={{width:200,borderRadius:'50%',border:'4px solid #ffc107',objectFit:'cover'}} />
            </div>
          </div>
        </div>
      </section>

      {/* ── SEASON BANNER ── */}
      <div style={{background:'linear-gradient(90deg,#10316B,#1a4a9e,#10316B)',color:'#fff',padding:'10px 0'}}>
        <div className="container">
          <div className="d-flex flex-wrap justify-content-center align-items-center gap-4 text-center">
            <div><span className="fw-bold text-warning">🏆 2024/25 Achievement</span><span className="ms-2 small">Lagos State U17 Champions · League Finalists</span></div>
            <div className="vr d-none d-md-block" style={{borderColor:'rgba(255,255,255,.3)'}}></div>
            <div><span className="fw-bold text-warning">⚽ 2026/27 LSFA State League</span><span className="ms-2 small">Atlantic Conference · WK4 Complete · P3 W1 L2</span></div>
            <div className="vr d-none d-md-block" style={{borderColor:'rgba(255,255,255,.3)'}}></div>
            <div><span className="fw-bold text-warning">📍 Home Ground</span><span className="ms-2 small">Nathaniel Idowu Football Field, Oregie, Ajegunle</span></div>
          </div>
        </div>
      </div>

      {/* ── NEWS SECTION ── */}
      <main className="container py-5" id="news-main-content">
        <h2 className="fw-bold text-center mb-4">Latest from OFA</h2>
        <ul className="nav nav-tabs news-tabs mb-4 justify-content-center" role="tablist">
          {[['latest','bi-lightning-charge-fill text-warning','Latest News'],['reports','bi-clipboard-data-fill text-success','Match Reports'],['media','bi-camera-video-fill text-danger','Media Highlights']].map(([id,icon,label])=>(
            <li className="nav-item" key={id} role="presentation">
              <button className={`nav-link${activeTab===id?' active':''}`} onClick={()=>setActiveTab(id)} type="button">
                <i className={`bi ${icon}`}></i> {label}
              </button>
            </li>
          ))}
        </ul>

        {loading ? <p className="text-center py-5">Loading…</p> : (
        <div>
          {/* Latest News */}
          {activeTab==='latest' && (
            <div className="row g-4">
              {latestNews.length===0 ? <div className="col-12 text-center py-4"><i className="bi bi-newspaper fs-1 text-muted"></i><p className="mt-2 text-muted">No current news posts found.</p></div>
              : latestNews.map(n=>(
                <div className="col-md-4" key={n.id}>
                  <div className="card h-100 border-0 shadow-sm rounded-3 overflow-hidden news-card">
                    <img src={n.image_path||LOGO} className="card-img-top" alt={n.title} style={{height:200,objectFit:'cover'}} onError={e=>{e.target.src=LOGO}} />
                    <div className="card-body d-flex flex-column">
                      <span className="badge bg-primary mb-2 align-self-start"><i className="bi bi-newspaper"></i> News</span>
                      <h5 className="card-title fw-bold">{n.title}</h5>
                      <p className="card-text text-muted" style={{fontSize:'.92rem'}}>{limit(n.content,120)}</p>
                      <div className="mt-auto">
                        <button className="btn btn-sm btn-outline-primary w-100" onClick={()=>toggle(`ln-${n.id}`)}>
                          <i className={`bi bi-chevron-${openCollapse[`ln-${n.id}`]?'up':'down'} me-1`}></i>
                          {openCollapse[`ln-${n.id}`]?'Show Less':'Read More'}
                        </button>
                        {openCollapse[`ln-${n.id}`] && <div className="p-3 bg-light rounded-3 small text-muted mt-2" style={{lineHeight:1.7}}>{n.content}</div>}
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}

          {/* Match Reports */}
          {activeTab==='reports' && (
            <div className="row g-4">
              {matchReports.length===0 ? <div className="col-12 text-center py-4"><i className="bi bi-clipboard-x fs-1 text-muted"></i><p className="mt-2 text-muted">No recent match reports found.</p></div>
              : matchReports.map(r=>(
                <div className="col-md-6" key={r.id}>
                  <div className="card h-100 border-0 shadow-sm rounded-3 overflow-hidden news-card">
                    <img src={r.image_path||LOGO} className="card-img-top" alt={r.title} style={{height:200,objectFit:'cover'}} onError={e=>{e.target.src=LOGO}} />
                    <div className="card-body d-flex flex-column">
                      <span className="badge bg-success mb-2 align-self-start"><i className="bi bi-trophy-fill"></i> Full-Time</span>
                      <h5 className="card-title fw-bold">{r.title}</h5>
                      <p className="card-text text-muted" style={{fontSize:'.92rem'}}>{limit(r.content,140)}</p>
                      <div className="mt-auto">
                        <button className="btn btn-sm btn-outline-success w-100" onClick={()=>toggle(`rp-${r.id}`)}>
                          <i className={`bi bi-chevron-${openCollapse[`rp-${r.id}`]?'up':'down'} me-1`}></i>
                          {openCollapse[`rp-${r.id}`]?'Show Less':'Read Full Report'}
                        </button>
                        {openCollapse[`rp-${r.id}`] && <div className="p-3 bg-light rounded-3 small text-muted mt-2" style={{lineHeight:1.7}}>{r.content}</div>}
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}

          {/* Media Highlights */}
          {activeTab==='media' && (
            <div className="row g-4">
              {mediaHighlights.length===0 ? <div className="col-12 text-center py-4"><i className="bi bi-camera-video-off fs-1 text-muted"></i><p className="mt-2 text-muted">No highlight videos found.</p></div>
              : mediaHighlights.map(m=>(
                <div className="col-12 col-md-6" key={m.id}>
                  <div className="card h-100 border-0 shadow-sm rounded-3 overflow-hidden news-card">
                    <div className="position-relative">
                      <img src={m.image_path||LOGO} className="card-img-top" alt={m.title} style={{height:200,objectFit:'cover'}} onError={e=>{e.target.src=LOGO}} />
                      <span className="position-absolute top-50 start-50 translate-middle"><i className="bi bi-play-circle-fill text-white" style={{fontSize:'3rem',opacity:.85}}></i></span>
                    </div>
                    <div className="card-body d-flex flex-column">
                      <span className="badge bg-danger mb-2 align-self-start"><i className="bi bi-youtube"></i> Video</span>
                      <h5 className="card-title fw-bold">{m.title}</h5>
                      <p className="card-text text-muted" style={{fontSize:'.92rem'}}>{limit(m.content,120)}</p>
                      <div className="mt-auto">
                        <button className="btn btn-sm btn-outline-danger w-100 mb-2" onClick={()=>toggle(`md-${m.id}`)}>
                          <i className={`bi bi-chevron-${openCollapse[`md-${m.id}`]?'up':'down'} me-1`}></i>
                          {openCollapse[`md-${m.id}`]?'Show Less':'Read More'}
                        </button>
                        {openCollapse[`md-${m.id}`] && <div className="p-3 bg-light rounded-3 small text-muted mb-2" style={{lineHeight:1.7}}>{m.content}</div>}
                        {m.meta_link && <a href={m.meta_link} target="_blank" rel="noopener" className="btn btn-sm btn-danger w-100"><i className="bi bi-youtube me-1"></i>Watch on YouTube</a>}
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
        )}
      </main>

      {/* ── MATCH RESULTS SCOREBOARD ── */}
      <section className="py-4 bg-light">
        <div className="container">
          <div className="d-flex justify-content-between align-items-center mb-3">
            <h3 className="fw-bold"><i className="bi bi-calendar2-check text-primary"></i> 2026/27 LSFA League Results — Atlantic Conference</h3>
            <a href="#next-match" className="btn btn-outline-primary btn-sm">Next Fixture</a>
          </div>
          <div className="scoreboard-table table-responsive">
            <table className="table mb-0 align-middle text-center">
              <thead style={{background:'#10316B',color:'#fff'}}>
                <tr><th>Week</th><th>Date</th><th>Opponent</th><th>Result</th></tr>
              </thead>
              <tbody>
                {matchResults.length===0
                  ? <tr><td colSpan="4" className="text-muted py-3">No match results yet.</td></tr>
                  : matchResults.map(m=>(
                    <tr key={m.id}>
                      <td>{m.week_label ? <span className="badge bg-secondary">{m.week_label}</span> : '—'}</td>
                      <td>{fmt(m.match_date,{day:'2-digit',month:'short',year:'numeric'})}</td>
                      <td className="fw-semibold">{m.opponent}</td>
                      <td><span className={`badge bg-${m.status_color} fs-6 px-3 py-2`}>{m.result_badge}</span></td>
                    </tr>
                  ))
                }
              </tbody>
            </table>
          </div>
        </div>
      </section>

      {/* ── LEAGUE STANDINGS ── */}
      <section className="py-3">
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-12 col-lg-9">
              <div className="p-3 bg-white rounded-3 shadow-sm">
                <h6 className="fw-bold mb-3"><i className="bi bi-bar-chart-line-fill text-primary"></i> LSFA State League 2026/27 — Atlantic Conference</h6>
                {standings.length===0
                  ? <p className="text-muted text-center py-3 mb-0"><i className="bi bi-bar-chart-line-fill d-block fs-2 mb-2 opacity-25"></i>Standings not yet available.</p>
                  : <div className="table-responsive">
                    <table className="table table-sm table-hover table-bordered align-middle mb-0" style={{fontSize:'.85rem'}}>
                      <thead style={{background:'#10316B',color:'#fff'}}>
                        <tr>
                          <th className="text-center" style={{width:36}}>POS</th><th>CLUB</th>
                          <th className="text-center" style={{width:36}}>PL</th>
                          <th className="text-center d-none d-sm-table-cell" style={{width:36}}>W</th>
                          <th className="text-center d-none d-sm-table-cell" style={{width:36}}>D</th>
                          <th className="text-center d-none d-sm-table-cell" style={{width:36}}>L</th>
                          <th className="text-center d-none d-md-table-cell" style={{width:36}}>GF</th>
                          <th className="text-center d-none d-md-table-cell" style={{width:36}}>GA</th>
                          <th className="text-center d-none d-md-table-cell" style={{width:40}}>GD</th>
                          <th className="text-center" style={{width:40}}>PTS</th>
                        </tr>
                      </thead>
                      <tbody>
                        {standings.map(t=>{
                          const gd = (t.goals_for||0)-(t.goals_against||0);
                          return (
                            <tr key={t.id} style={t.is_featured_club?{background:'#e8f5e9',fontWeight:600}:{}}>
                              <td className="text-center fw-bold" style={{color:'#10316B'}}>{t.rank}</td>
                              <td>{t.is_featured_club ? <strong className="text-success"><i className="bi bi-shield-fill-check"></i> {t.club_name}</strong> : t.club_name}</td>
                              <td className="text-center">{t.played}</td>
                              <td className="text-center d-none d-sm-table-cell text-success fw-semibold">{t.won}</td>
                              <td className="text-center d-none d-sm-table-cell">{t.drawn}</td>
                              <td className="text-center d-none d-sm-table-cell text-danger fw-semibold">{t.lost}</td>
                              <td className="text-center d-none d-md-table-cell">{t.goals_for}</td>
                              <td className="text-center d-none d-md-table-cell">{t.goals_against}</td>
                              <td className="text-center d-none d-md-table-cell"><span className={gd>0?'text-success':gd<0?'text-danger':'text-muted'}>{gd>0?'+':''}{gd}</span></td>
                              <td className="text-center fw-bold" style={{color:'#10316B'}}>{t.points}</td>
                            </tr>
                          );
                        })}
                      </tbody>
                    </table>
                    <div className="small text-muted mt-2">
                      <i className="bi bi-info-circle me-1"></i>
                      {matchResults.length>0 ? `Updated after ${matchResults[0].week_label||fmt(matchResults[0].match_date,{day:'2-digit',month:'short',year:'numeric'})}.` : 'Current league standings.'}
                      {nextFixture && ` Next: ${nextFixture.week_label} — ${fmt(nextFixture.fixture_date,{day:'2-digit',month:'short',year:'numeric'})}.`}
                    </div>
                  </div>
                }
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── LAST RESULT / NEXT FIXTURE ── */}
      <section className="py-4" id="next-match">
        <div className="container">
          <div className="row g-4">
            {/* Last Result */}
            <div className="col-md-6">
              {lastResult ? (()=>{
                const isWin  = lastResult.status_color==='success';
                const isLoss = lastResult.status_color==='danger';
                const bg = isWin?'linear-gradient(135deg,#1a5c2a 60%,#145222 100%)':isLoss?'linear-gradient(135deg,#c0392b 60%,#922b21 100%)':'linear-gradient(135deg,#374151 60%,#1f2937 100%)';
                const badgeColor = isWin?'#15803d':isLoss?'#dc2626':'#374151';
                return (
                  <div className="p-4 rounded-4 shadow h-100" style={{background:bg,color:'#fff'}}>
                    <span className="badge bg-white fw-bold mb-2 px-3 py-2" style={{color:badgeColor}}>
                      {isWin?'✅':isLoss?'❌':'⏸'} Last Result{lastResult.week_label?` — ${lastResult.week_label}`:''}
                    </span>
                    <h4 className="fw-bold mb-2 text-uppercase"><i className="bi bi-flag-fill text-warning"></i> {lastResult.result_badge}</h4>
                    {lastResult.notes && <p className="mb-1 opacity-90"><i className="bi bi-info-circle"></i> {lastResult.notes}</p>}
                    <p className="mb-1 opacity-90">{lastResult.competition}</p>
                    <small className="opacity-75 d-block mt-2">
                      <i className="bi bi-calendar3"></i> {fmt(lastResult.match_date,{weekday:'long',day:'numeric',month:'long',year:'numeric'})}
                      {lastResult.kick_off_time && <> &nbsp;|&nbsp; <i className="bi bi-clock"></i> {fmtTime(lastResult.kick_off_time)}</>}
                      {lastResult.venue && <><br/><i className="bi bi-geo-alt-fill"></i> {lastResult.venue}</>}
                    </small>
                  </div>
                );
              })() : (
                <div className="p-4 rounded-4 shadow h-100 d-flex align-items-center justify-content-center" style={{background:'linear-gradient(135deg,#374151,#1f2937)',color:'#fff',minHeight:180}}>
                  <div className="text-center opacity-60"><i className="bi bi-calendar-x fs-1 d-block mb-2"></i><p className="mb-0">No match results yet.</p></div>
                </div>
              )}
            </div>
            {/* Next Fixture */}
            <div className="col-md-6">
              {nextFixture ? (
                <div className="p-4 rounded-4 shadow h-100" style={{background:'linear-gradient(135deg,#ffc107 0%,#ff9800 100%)',color:'#222'}}>
                  <span className="badge bg-dark fw-bold mb-2 px-3 py-2">📅 Next Fixture — {nextFixture.week_label}</span>
                  <h4 className="fw-bold mb-2 text-uppercase"><i className="bi bi-calendar2-event"></i> {nextFixture.home_team} vs {nextFixture.away_team}</h4>
                  <p className="mb-1 fw-semibold">{nextFixture.competition}</p>
                  <small className="d-block mt-2">
                    <i className="bi bi-calendar3"></i> {fmt(nextFixture.fixture_date,{weekday:'long',day:'numeric',month:'long',year:'numeric'})}
                    {nextFixture.kick_off_time && <> &nbsp;|&nbsp; <i className="bi bi-clock"></i> {fmtTime(nextFixture.kick_off_time)}</>}
                    <br/><i className="bi bi-geo-alt-fill"></i> {nextFixture.venue}
                  </small>
                  <Link href="/contact" className="btn btn-dark btn-sm fw-bold mt-3"><i className="bi bi-person-plus-fill me-1"></i>Book a Trial</Link>
                </div>
              ) : (
                <div className="p-4 rounded-4 shadow h-100 d-flex align-items-center justify-content-center" style={{background:'linear-gradient(135deg,#ffc107,#ff9800)',color:'#222',minHeight:180}}>
                  <div className="text-center opacity-60"><i className="bi bi-calendar-event fs-1 d-block mb-2"></i><p className="mb-0 fw-semibold">No upcoming fixture scheduled.</p></div>
                </div>
              )}
            </div>
            {/* Season bar */}
            {matchResults.length>0 && (
              <div className="col-12">
                <div className="p-3 rounded-3 bg-white border d-flex flex-wrap align-items-center gap-2">
                  {[...matchResults].sort((a,b)=>new Date(a.match_date)-new Date(b.match_date)).map(mr=>{
                    const emoji=mr.status_color==='success'?'✅':mr.status_color==='danger'?'❌':'⏸';
                    const bg=mr.status_color==='success'?'bg-success':mr.status_color==='danger'?'bg-danger':'bg-secondary';
                    return <span key={mr.id} className={`badge ${bg} px-3 py-2 fw-bold`}>{emoji}{mr.week_label?` ${mr.week_label} — `:' '}{mr.result_badge}</span>;
                  })}
                  {nextFixture && <span className="badge bg-warning text-dark px-3 py-2 fw-bold">📅 {nextFixture.week_label} — {fmt(nextFixture.fixture_date,{day:'2-digit',month:'short',year:'numeric'})}</span>}
                </div>
              </div>
            )}
          </div>
        </div>
      </section>

      {/* ── PLAYER SPOTLIGHT ── */}
      <section className="py-5" style={{background:'linear-gradient(180deg,#f0f4ff 0%,#fff 100%)'}}>
        <div className="container">
          <div className="text-center mb-5">
            <h2 className="fw-bold" style={{color:'#10316B'}}><i className="bi bi-person-badge-fill text-warning"></i> Player Spotlight</h2>
            <p className="text-muted">Meet the rising stars of Olufunke Football Academy</p>
          </div>
          <div className="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
            {players.length===0
              ? <div className="col-12 text-center py-4"><i className="bi bi-people fs-1 text-muted"></i><p className="mt-2 text-muted">No player profiles available yet.</p></div>
              : players.map(p=>(
                <div className="col" key={p.id}>
                  <div className="player-card p-4 text-center h-100 d-flex flex-column align-items-center" style={{borderTop:'4px solid #10316B'}}>
                    <div className="mb-3">
                      <img src={p.photo_url||LOGO} alt={p.full_name} className="shadow"
                        style={{width:110,height:110,borderRadius:'50%',objectFit:'cover',border:'3px solid #4CAF50',display:'block'}}
                        onError={e=>{e.target.style.display='none';e.target.nextSibling.style.display='flex';}} />
                      <div className="profile-img-fallback shadow" style={{display:'none'}}>{(p.full_name||'').charAt(0).toUpperCase()}</div>
                    </div>
                    <h5 className="fw-bold mb-0" style={{color:'#10316B'}}>{p.full_name}</h5>
                    <span className="badge mt-1 mb-2" style={{background:'#4CAF50',fontSize:'.85rem'}}>{p.position} &nbsp;|&nbsp; Age {p.age}</span>
                    <div className="d-flex gap-3 justify-content-center mb-3">
                      <div className="text-center"><div className="fw-bold fs-5" style={{color:'#10316B'}}>{p.goals}</div><small className="text-muted">Goals</small></div>
                      <div className="vr"></div>
                      <div className="text-center"><div className="fw-bold fs-5" style={{color:'#10316B'}}>{p.assists}</div><small className="text-muted">Assists</small></div>
                      <div className="vr"></div>
                      <div className="text-center"><div className="fw-bold fs-5" style={{color:'#10316B'}}>{p.matches}</div><small className="text-muted">Matches</small></div>
                    </div>
                    <blockquote className="blockquote mt-auto mb-0 fst-italic text-muted" style={{fontSize:'.88rem',borderLeft:'3px solid #ffc107',paddingLeft:10,textAlign:'left'}}>
                      &ldquo;{p.quote}&rdquo;
                    </blockquote>
                  </div>
                </div>
              ))
            }
          </div>
        </div>
      </section>

      {/* ── CTA BANNER ── */}
      <section className="my-5">
        <div className="container">
          <div className="cta-banner shadow-lg">
            <h2 className="fw-bold mb-2">Ready to Join the Olufunke FA Family?</h2>
            <p className="lead mb-4">Unlock your footballing dreams — enroll today and become part of a winning tradition. Let&apos;s shape the future, together.</p>
            <Link href="/contact" className="btn btn-warning btn-lg px-5 fw-bold">Contact Us Now</Link>
          </div>
        </div>
      </section>

      {/* ── FIFA SECTION ── */}
      <section className="bg-light py-5">
        <div className="container text-center">
          <h2 className="fw-bold">🌍 FIFA Talent Development</h2>
          <p className="text-muted">We align with global standards through FIFA&apos;s Training Centre and international partnerships.</p>
          <a href="https://www.fifatrainingcentre.com" target="_blank" rel="noopener" className="btn btn-outline-primary px-4">Visit FIFA Training Centre</a>
        </div>
      </section>

      {/* ── QUIZ CTA ── */}
      <section className="py-5" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <div className="row align-items-center g-4">
            <div className="col-md-8 text-white">
              <div className="d-flex align-items-center gap-3 mb-3">
                <span style={{fontSize:'3rem'}}>🧠⚽</span>
                <div>
                  <h2 className="fw-bold mb-1">Weekly Football IQ Quiz</h2>
                  <p className="opacity-75 mb-0">Think you know football? Prove it! Open to everyone — no login required.</p>
                </div>
              </div>
              <div className="d-flex gap-3 flex-wrap">
                <span className="badge bg-warning text-dark fs-6 px-3 py-2"><i className="bi bi-lightning-fill me-1"></i>New Quiz Every Week</span>
                <span className="badge bg-white text-dark fs-6 px-3 py-2"><i className="bi bi-trophy-fill me-1 text-warning"></i>Live Leaderboard</span>
                <span className="badge bg-success fs-6 px-3 py-2"><i className="bi bi-people-fill me-1"></i>Free for Everyone</span>
              </div>
            </div>
            <div className="col-md-4 text-center text-md-end">
              <Link href="/quiz" className="btn btn-warning btn-lg fw-bold px-5 shadow"><i className="bi bi-play-fill me-2"></i>Take the Quiz</Link>
            </div>
          </div>
        </div>
      </section>

      <hr className="mb-0" />
      <div className="py-3 text-center bg-white">
        <a href="#top" className="btn btn-outline-dark btn-sm"><i className="bi bi-arrow-up-circle"></i> Back to Top</a>
      </div>

      {/* ── FOOTER ── */}
      <footer className="bg-dark text-light pt-4 pb-2 mt-0">
        <div className="container">
          <div className="row align-items-center">
            <div className="col-sm-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
              <a href="/" className="d-inline-flex align-items-center link-light text-decoration-none">
                <img src={LOGO} alt="OFA Logo" width="48" height="48" className="me-2" loading="lazy" />
                <span className="fs-5 fw-bold">Olufunke Football Academy</span>
              </a>
              <p className="small mt-2 mb-0">Nurturing football talent for the future.</p>
              <p className="small mt-1 mb-0">Proud member of Lagos State Football Association, and Nigeria Football Federation.</p>
            </div>
            <div className="col-md-4 d-none d-md-block">
              <ul className="nav justify-content-center">
                <li className="nav-item"><Link href="/" className="nav-link px-2 text-light">Home</Link></li>
                <li className="nav-item"><Link href="/about" className="nav-link px-2 text-light">About Us</Link></li>
                <li className="nav-item"><Link href="/contact" className="nav-link px-2 text-light">Contact Us</Link></li>
              </ul>
            </div>
            <div className="col-sm-12 col-md-4 text-center text-md-end">
              <ul className="list-unstyled d-flex justify-content-center justify-content-md-end mb-0">
                <li className="ms-3"><a className="text-light" href="https://www.youtube.com/@olufunkefootballacademy" target="_blank" rel="noopener noreferrer"><i className="bi bi-youtube fs-3"></i></a></li>
                <li className="ms-3"><a className="text-light" href="https://web.facebook.com/people/Olufunke-Football-Academy/61554694136830/" target="_blank" rel="noopener noreferrer"><i className="bi bi-facebook fs-3"></i></a></li>
                <li className="ms-3"><a className="text-light" href="https://www.instagram.com/olufunkefootballacademy" target="_blank" rel="noopener noreferrer"><i className="bi bi-instagram fs-3"></i></a></li>
              </ul>
            </div>
          </div>
          <div className="row"><div className="col-12 text-center mt-3"><small>&copy; {new Date().getFullYear()} Olufunke Football Academy. All rights reserved.</small></div></div>
        </div>
      </footer>

    </>
  );
}
