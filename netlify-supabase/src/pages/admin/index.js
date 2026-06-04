/**
 * Admin Dashboard — /admin
 * Mirrors Laravel admin.blade.php exactly.
 * Reads ALL data from Supabase. Protected: admin role only.
 */
import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';

const STYLE = `
*{box-sizing:border-box;}
.dash-wrap{display:flex;min-height:calc(100vh - 0px);background:#0d1117;}
.dsb{width:256px;min-width:256px;background:linear-gradient(180deg,#0f1f3d 0%,#0a1628 100%);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto;overflow-x:hidden;box-shadow:4px 0 32px rgba(0,0,0,.5);scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.1) transparent;}
.dsb::-webkit-scrollbar{width:4px;}.dsb::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:4px;}
.dsb-brand{padding:20px 18px 16px;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;gap:12px;}
.dsb-brand img{width:40px;height:40px;border-radius:10px;border:2px solid #fbbf24;object-fit:cover;}
.dsb-brand .bn{font-size:.72rem;font-weight:800;color:#fbbf24;letter-spacing:.08em;text-transform:uppercase;}
.dsb-brand .bs{font-size:.65rem;color:rgba(255,255,255,.35);margin-top:2px;}
.dsb-sec{padding:16px 16px 4px;font-size:.6rem;font-weight:800;color:rgba(255,255,255,.25);letter-spacing:.12em;text-transform:uppercase;}
.dsb-lnk{display:flex;align-items:center;gap:10px;padding:9px 18px;color:rgba(255,255,255,.55);text-decoration:none;font-size:.82rem;font-weight:500;border-left:3px solid transparent;transition:all .15s;}
.dsb-lnk:hover,.dsb-lnk.on{background:rgba(255,255,255,.06);color:#fff;border-left-color:#fbbf24;}
.dsb-lnk .si{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;}
.dsb-foot{margin-top:auto;padding:14px 12px;border-top:1px solid rgba(255,255,255,.06);}
.dmain{flex:1;background:#f0f4f8;overflow-x:hidden;min-width:0;}
.dtop{background:#fff;padding:13px 24px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e5eaf0;position:sticky;top:0;z-index:99;box-shadow:0 1px 6px rgba(0,0,0,.05);}
.dbody{padding:22px 24px;}
.gcard{border-radius:18px;padding:20px 18px;display:flex;align-items:center;gap:14px;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,.18);backdrop-filter:blur(12px);box-shadow:0 8px 32px rgba(0,0,0,.12);transition:transform .18s;}
.gcard:hover{transform:translateY(-4px);}
.gcard .gi{width:50px;height:50px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;background:rgba(255,255,255,.18);}
.gcard .gv{font-size:2.2rem;font-weight:900;line-height:1;color:#fff;}
.gcard .gl{font-size:.72rem;font-weight:600;opacity:.8;margin-top:3px;color:#fff;}
.qnt{display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:14px;border:1.5px solid #e5eaf0;background:#fff;text-decoration:none;transition:all .18s;}
.qnt:hover{border-color:#10316B;box-shadow:0 6px 20px rgba(16,49,107,.13);transform:translateY(-2px);}
.qnt .qi{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;}
.pnl{background:#fff;border-radius:16px;box-shadow:0 2px 16px rgba(0,0,0,.06);overflow:hidden;margin-bottom:22px;border:1px solid #f0f4f8;}
.pnl-h{padding:13px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #f0f4f8;}
.pnl-h .ph{font-size:.88rem;font-weight:700;color:#0d1117;display:flex;align-items:center;gap:8px;}
.pnl-h .phi{width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.85rem;}
.mtbl thead th{background:#f8fafc;font-size:.7rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#64748b;border-bottom:2px solid #e5eaf0;padding:10px 12px;}
.mtbl tbody tr{transition:background .1s;}.mtbl tbody tr:hover{background:#f8fafc;}
.mtbl td{vertical-align:middle;font-size:.83rem;border-color:#f0f4f8;padding:10px 12px;}
.av{width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #e5eaf0;}
.avi{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;color:#fff;flex-shrink:0;}
.pl{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:700;}
.pl-g{background:#dcfce7;color:#15803d;}.pl-y{background:#fef9c3;color:#a16207;}.pl-r{background:#fee2e2;color:#b91c1c;}.pl-b{background:#dbeafe;color:#1d4ed8;}.pl-s{background:#f1f5f9;color:#475569;}
.mrow{cursor:pointer;transition:background .1s;border-bottom:1px solid #f0f4f8;}
.mrow:hover{background:#f8fafc;}.mrow.unread{background:#fffbeb;}
@media(max-width:991px){.dsb{display:none;}.dmain{width:100%;}}
`;

export default function AdminDashboard() {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [profile,   setProfile]   = useState(null);
  const [players,   setPlayers]   = useState([]);
  const [messages,  setMessages]  = useState([]);
  const [posts,     setPosts]     = useState([]);
  const [results,   setResults]   = useState([]);
  const [standings, setStandings] = useState([]);
  const [contacts,  setContacts]  = useState([]);
  const [quizWeeks, setQuizWeeks] = useState([]);
  const [attempts,  setAttempts]  = useState([]);
  const [courses,   setCourses]   = useState([]);
  const [counts,    setCounts]    = useState({ total:0, approved:0, pending:0, unread:0 });
  const [loading,   setLoading]   = useState(true);
  const [openMsg,   setOpenMsg]   = useState({});

  useEffect(() => {
    if (session === null) { router.replace('/login'); return; }
    if (!session) return;
    async function load() {
      // Verify admin role
      const { data: prof } = await supabase
        .from('profiles').select('*').eq('id', session.user.id).single();
      if (!prof || prof.role !== 'admin') { router.replace('/dashboard'); return; }
      setProfile(prof);

      // Load all data in parallel
      const [
        { data: pl }, { data: po }, { data: res }, { data: st },
        { data: cm }, { data: qw }, { data: qa }, { data: co },
      ] = await Promise.all([
        supabase.from('profiles').select('*').order('created_at', { ascending: false }),
        supabase.from('posts').select('*').order('created_at', { ascending: false }),
        supabase.from('match_results').select('*').order('match_date', { ascending: false }),
        supabase.from('standings').select('*').order('rank'),
        supabase.from('contact_messages').select('*').order('created_at', { ascending: false }),
        supabase.from('quiz_weeks').select('*').order('created_at', { ascending: false }),
        supabase.from('quiz_attempts').select('*, quiz_weeks(title)').order('created_at', { ascending: false }).limit(20),
        supabase.from('courses').select('*, lessons(count)').order('id'),
      ]);

      const allPlayers = (pl || []).filter(p => p.role === 'player');
      setPlayers(allPlayers);
      setPosts(po || []);
      setResults(res || []);
      setStandings(st || []);
      setContacts(cm || []);
      setQuizWeeks(qw || []);
      setAttempts(qa || []);
      setCourses(co || []);

      const unread = (cm || []).filter(m => !m.is_read).length;
      setCounts({
        total:    allPlayers.length,
        approved: allPlayers.filter(p => p.status === 'approved').length,
        pending:  allPlayers.filter(p => p.status === 'pending').length,
        unread,
      });
      setLoading(false);
    }
    load();
  }, [session]);

  const signOut = async () => { await supabase.auth.signOut(); router.push('/login'); };

  const markRead = async (id) => {
    await supabase.from('contact_messages').update({ is_read: true }).eq('id', id);
    setContacts(prev => prev.map(m => m.id === id ? {...m, is_read: true} : m));
    setCounts(c => ({...c, unread: Math.max(0, c.unread - 1)}));
  };

  const approvePlayer = async (id) => {
    await supabase.from('profiles').update({ status: 'approved' }).eq('id', id);
    setPlayers(prev => prev.map(p => p.id === id ? {...p, status: 'approved'} : p));
    setCounts(c => ({...c, approved: c.approved + 1, pending: Math.max(0, c.pending - 1)}));
  };

  const rejectPlayer = async (id) => {
    await supabase.from('profiles').update({ status: 'rejected' }).eq('id', id);
    setPlayers(prev => prev.map(p => p.id === id ? {...p, status: 'rejected'} : p));
    setCounts(c => ({...c, pending: Math.max(0, c.pending - 1)}));
  };

  if (!session || loading) return (
    <div style={{display:'flex',alignItems:'center',justifyContent:'center',minHeight:'100vh',fontFamily:'Montserrat,sans-serif',background:'#0d1117',color:'#fff'}}>
      <div style={{textAlign:'center'}}><div style={{fontSize:48}}>⚽</div><p style={{marginTop:16}}>Loading Admin Dashboard…</p></div>
    </div>
  );

  const initial = (profile?.full_name || session.user.email || 'A').charAt(0).toUpperCase();
  const fmt = (d) => d ? new Date(d).toLocaleDateString('en-GB', {day:'2-digit',month:'short',year:'numeric'}) : '—';

  return (
    <>
      <Head><title>OFA Admin Dashboard</title></Head>
      <style>{STYLE}</style>

      <div className="dash-wrap">
        {/* ── SIDEBAR ── */}
        <aside className="dsb">
          <div className="dsb-brand">
            <img src="/images/OFA New Logo.jpg" alt="OFA" />
            <div><div className="bn">OFA Admin</div><div className="bs">Management Panel</div></div>
          </div>

          <div className="dsb-sec">Overview</div>
          <Link href="/admin" className="dsb-lnk on">
            <span className="si" style={{background:'rgba(99,102,241,.2)',color:'#a5b4fc'}}><i className="bi bi-speedometer2"></i></span>Dashboard
          </Link>

          <div className="dsb-sec">Players</div>
          <Link href="/admin" className="dsb-lnk">
            <span className="si" style={{background:'rgba(16,185,129,.2)',color:'#6ee7b7'}}><i className="bi bi-people-fill"></i></span>
            Registered Players {counts.pending > 0 && <span style={{marginLeft:'auto',background:'#fbbf24',color:'#0d1117',borderRadius:20,fontSize:'.62rem',padding:'2px 7px',fontWeight:700}}>{counts.pending}</span>}
          </Link>

          <div className="dsb-sec">Content</div>
          <Link href="/admin/league" className="dsb-lnk">
            <span className="si" style={{background:'rgba(251,191,36,.2)',color:'#fde68a'}}><i className="bi bi-trophy-fill"></i></span>League Manager
          </Link>
          <Link href="/admin/posts" className="dsb-lnk">
            <span className="si" style={{background:'rgba(239,68,68,.2)',color:'#fca5a5'}}><i className="bi bi-newspaper"></i></span>News &amp; Posts
          </Link>
          <Link href="/admin/quiz" className="dsb-lnk">
            <span className="si" style={{background:'rgba(20,184,166,.2)',color:'#5eead4'}}><i className="bi bi-patch-question-fill"></i></span>Quiz Manager
          </Link>
          <Link href="/admin/courses" className="dsb-lnk">
            <span className="si" style={{background:'rgba(168,85,247,.2)',color:'#d8b4fe'}}><i className="bi bi-mortarboard-fill"></i></span>E-Learning
          </Link>

          <div className="dsb-sec">Communication</div>
          <Link href="/admin" className="dsb-lnk">
            <span className="si" style={{background:'rgba(249,115,22,.2)',color:'#fdba74'}}><i className="bi bi-chat-dots-fill"></i></span>
            Contact Messages {counts.unread > 0 && <span style={{marginLeft:'auto',background:'#dc2626',color:'#fff',borderRadius:20,fontSize:'.62rem',padding:'2px 7px',fontWeight:700}}>{counts.unread}</span>}
          </Link>

          <div className="dsb-foot">
            <button className="dsb-lnk border-0 bg-transparent w-100 text-start" style={{color:'rgba(255,255,255,.4)'}} onClick={signOut}>
              <span className="si" style={{background:'rgba(239,68,68,.15)',color:'#f87171'}}><i className="bi bi-box-arrow-right"></i></span>Log Out
            </button>
          </div>
        </aside>

        {/* ── MAIN ── */}
        <div className="dmain">
          <div className="dtop">
            <div>
              <div style={{fontSize:'1.05rem',fontWeight:800,color:'#0d1117'}}>Admin Dashboard</div>
              <div style={{fontSize:'.72rem',color:'#64748b'}}>{new Date().toLocaleDateString('en-GB',{weekday:'long',day:'numeric',month:'long',year:'numeric'})}</div>
            </div>
            <div style={{display:'flex',alignItems:'center',gap:12}}>
              <div style={{width:36,height:36,borderRadius:'50%',background:'linear-gradient(135deg,#10316B,#4CAF50)',display:'flex',alignItems:'center',justifyContent:'center',color:'#fff',fontWeight:800,fontSize:'.8rem'}}>{initial}</div>
              <div className="d-none d-md-block">
                <div style={{fontSize:'.8rem',fontWeight:700,color:'#0d1117'}}>{profile?.full_name || session.user.email}</div>
                <div style={{fontSize:'.68rem',color:'#64748b'}}>Administrator</div>
              </div>
            </div>
          </div>

          <div className="dbody">
            {/* ── Stat Cards ── */}
            <div className="row g-3 mb-4">
              {[
                ['linear-gradient(135deg,rgba(16,49,107,.9),rgba(30,77,183,.85))','bi-people-fill',  counts.total,    'Total Players'],
                ['linear-gradient(135deg,rgba(5,150,105,.9),rgba(16,185,129,.85))','bi-check-circle-fill',counts.approved,'Approved'],
                ['linear-gradient(135deg,rgba(217,119,6,.9),rgba(245,158,11,.85))','bi-hourglass-split',counts.pending,'Pending Approval'],
                ['linear-gradient(135deg,rgba(220,38,38,.9),rgba(239,68,68,.85))','bi-envelope-fill',counts.unread,'Unread Messages'],
              ].map(([bg,icon,val,label]) => (
                <div className="col-6 col-xl-3" key={label}>
                  <div className="gcard" style={{background:bg}}>
                    <div className="gi"><i className={`bi ${icon}`}></i></div>
                    <div><div className="gv">{val}</div><div className="gl">{label}</div></div>
                  </div>
                </div>
              ))}
            </div>

            {/* ── Quick nav ── */}
            <div className="row g-3 mb-4">
              {[
                ['/admin/league',  '#fef3c7','#d97706','bi-trophy-fill',      'League',   'Results & fixtures'],
                ['/admin/posts',   '#fee2e2','#dc2626','bi-newspaper',         'News',     'Posts & reports'],
                ['/admin/quiz',    '#ccfbf1','#0d9488','bi-patch-question-fill','Quizzes', 'IQ manager'],
                ['/admin/courses', '#f3e8ff','#9333ea','bi-mortarboard-fill',  'E-Learning','Courses'],
                ['/admin',         '#dbeafe','#2563eb','bi-chat-dots-fill',    'Messages', counts.unread > 0 ? `${counts.unread} unread` : 'Contact inbox'],
              ].map(([href,bg,color,icon,label,sub]) => (
                <div className="col-6 col-sm-4 col-md-3 col-xl-auto" key={label} style={{minWidth:140}}>
                  <Link href={href} className="qnt">
                    <div className="qi" style={{background:bg}}><i className={`bi ${icon}`} style={{color}}></i></div>
                    <div>
                      <div style={{fontSize:'.84rem',fontWeight:700,color:'#0d1117'}}>{label}</div>
                      <div style={{fontSize:'.7rem',color:counts.unread > 0 && label==='Messages' ? '#dc2626' : '#64748b',fontWeight:counts.unread > 0 && label==='Messages' ? 700 : 400}}>{sub}</div>
                    </div>
                  </Link>
                </div>
              ))}
            </div>

            <div className="row g-4 mb-4">
              {/* ── Database Summary ── */}
              <div className="col-lg-4">
                <div className="pnl">
                  <div className="pnl-h">
                    <div className="ph"><div className="phi" style={{background:'#dbeafe'}}><i className="bi bi-database-fill" style={{color:'#2563eb'}}></i></div>Database Summary</div>
                  </div>
                  <div className="p-3">
                    {[
                      ['Players',       counts.total,        '#10316B'],
                      ['Posts/News',    posts.length,        '#dc2626'],
                      ['Match Results', results.length,      '#d97706'],
                      ['Standings',     standings.length,    '#15803d'],
                      ['Quiz Weeks',    quizWeeks.length,    '#9333ea'],
                      ['Quiz Attempts', attempts.length,     '#0d9488'],
                      ['Courses',       courses.length,      '#2563eb'],
                      ['Contact Msgs',  contacts.length,     '#ea580c'],
                    ].map(([label,val,color]) => (
                      <div key={label} style={{display:'flex',justifyContent:'space-between',alignItems:'center',padding:'8px 0',borderBottom:'1px solid #f0f4f8'}}>
                        <span style={{fontSize:'.82rem',color:'#64748b'}}>{label}</span>
                        <span style={{fontWeight:800,color,fontSize:'.88rem'}}>{val}</span>
                      </div>
                    ))}
                  </div>
                </div>
              </div>

              {/* ── Recent Contact Messages ── */}
              <div className="col-lg-8">
                <div className="pnl">
                  <div className="pnl-h">
                    <div className="ph"><div className="phi" style={{background:'#dcfce7'}}><i className="bi bi-envelope-fill" style={{color:'#16a34a'}}></i></div>Recent Contact Messages</div>
                    {counts.unread > 0 && <span className="pl pl-r">{counts.unread} new</span>}
                  </div>
                  <div style={{maxHeight:340,overflowY:'auto'}}>
                    {contacts.length === 0 ? (
                      <div className="text-center py-5 text-muted"><i className="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i><p style={{fontSize:'.83rem'}}>No contact messages yet.</p></div>
                    ) : contacts.map(msg => (
                      <div key={msg.id} className={`mrow${!msg.is_read?' unread':''}`} onClick={() => { setOpenMsg(p=>({...p,[msg.id]:!p[msg.id]})); if(!msg.is_read) markRead(msg.id); }}>
                        <div style={{display:'flex',alignItems:'flex-start',gap:12,padding:12}}>
                          <div className="avi" style={{background:'linear-gradient(135deg,#10316B,#4CAF50)',width:34,height:34,fontSize:'.72rem'}}>
                            {(msg.name||'?').charAt(0).toUpperCase()}
                          </div>
                          <div style={{flexGrow:1,minWidth:0}}>
                            <div style={{display:'flex',justifyContent:'space-between',gap:8}}>
                              <span style={{fontSize:'.83rem',fontWeight:600,color:'#0d1117'}}>
                                {msg.name} {!msg.is_read && <span className="pl pl-r ms-1">New</span>}
                              </span>
                              <small style={{color:'#94a3b8',fontSize:'.7rem',flexShrink:0}}>{fmt(msg.created_at)}</small>
                            </div>
                            <div style={{fontSize:'.76rem',color:'#64748b',marginTop:2}}>
                              <strong>{msg.subject || 'No subject'}</strong> — {(msg.message||'').slice(0,75)}{msg.message?.length>75?'…':''}
                            </div>
                            {openMsg[msg.id] && (
                              <div style={{marginTop:8,padding:12,background:'#f8fafc',borderRadius:8,borderLeft:'4px solid #4CAF50'}}>
                                <div style={{display:'flex',gap:16,marginBottom:8,flexWrap:'wrap'}}>
                                  <div><small style={{color:'#94a3b8',fontSize:'.68rem',fontWeight:800,textTransform:'uppercase'}}>From</small><div style={{fontSize:'.83rem'}}>{msg.name}</div></div>
                                  <div><small style={{color:'#94a3b8',fontSize:'.68rem',fontWeight:800,textTransform:'uppercase'}}>Email</small><a href={`mailto:${msg.email}`} style={{fontSize:'.83rem',display:'block'}}>{msg.email}</a></div>
                                  {msg.phone && <div><small style={{color:'#94a3b8',fontSize:'.68rem',fontWeight:800,textTransform:'uppercase'}}>Phone</small><a href={`tel:${msg.phone}`} style={{fontSize:'.83rem',display:'block'}}>{msg.phone}</a></div>}
                                </div>
                                <p style={{fontSize:'.83rem',lineHeight:1.8,whiteSpace:'pre-wrap',marginBottom:8}}>{msg.message}</p>
                                <div style={{display:'flex',gap:8}}>
                                  <a href={`mailto:${msg.email}?subject=Re: ${encodeURIComponent(msg.subject||'Your enquiry')}`} className="btn btn-sm btn-success fw-bold"><i className="bi bi-reply-fill me-1"></i>Reply</a>
                                  {msg.phone && <a href={`tel:${msg.phone}`} className="btn btn-sm btn-outline-primary"><i className="bi bi-telephone-fill me-1"></i>Call</a>}
                                </div>
                              </div>
                            )}
                          </div>
                          <i className={`bi bi-chevron-${openMsg[msg.id]?'up':'down'} text-muted`} style={{fontSize:'.75rem',flexShrink:0}}></i>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            </div>

            {/* ── Players Table ── */}
            <div className="pnl">
              <div className="pnl-h">
                <div className="ph"><div className="phi" style={{background:'#dbeafe'}}><i className="bi bi-people-fill" style={{color:'#2563eb'}}></i></div>Registered Players</div>
                <span className="pl pl-y">{counts.total} total · {counts.pending} pending</span>
              </div>
              <div className="table-responsive">
                <table className="table mtbl mb-0">
                  <thead><tr>
                    <th className="ps-4">#</th><th>Player</th>
                    <th className="d-none d-md-table-cell">Position</th>
                    <th className="d-none d-md-table-cell">Age / Group</th>
                    <th className="d-none d-lg-table-cell">Joined</th>
                    <th>Status</th><th className="text-center pe-4">Actions</th>
                  </tr></thead>
                  <tbody>
                    {players.length === 0 ? (
                      <tr><td colSpan="7" style={{textAlign:'center',padding:40,color:'#94a3b8'}}>
                        <i className="bi bi-people d-block mb-2" style={{fontSize:'2rem',opacity:.25}}></i>No players registered yet.
                      </td></tr>
                    ) : players.map((p, i) => (
                      <tr key={p.id}>
                        <td className="ps-4" style={{color:'#94a3b8',fontSize:'.75rem'}}>{i+1}</td>
                        <td>
                          <div style={{display:'flex',alignItems:'center',gap:8}}>
                            <div className="avi" style={{background:'linear-gradient(135deg,#10316B,#4CAF50)',width:34,height:34,fontSize:'.72rem'}}>
                              {(p.full_name||p.id).charAt(0).toUpperCase()}
                            </div>
                            <div>
                              <div style={{fontWeight:600,fontSize:'.83rem',color:'#0d1117'}}>{p.full_name || '(no name)'}</div>
                              <div style={{color:'#94a3b8',fontSize:'.7rem'}}>{p.id.slice(0,8)}…</div>
                            </div>
                          </div>
                        </td>
                        <td className="d-none d-md-table-cell">
                          {p.position ? <span className="pl pl-s">{p.position}</span> : <span style={{color:'#cbd5e1'}}>—</span>}
                        </td>
                        <td className="d-none d-md-table-cell">
                          <span style={{fontWeight:600,fontSize:'.83rem'}}>{p.age||'—'}</span>
                          {p.age_group && <span className="pl pl-b ms-1">{p.age_group}</span>}
                        </td>
                        <td className="d-none d-lg-table-cell" style={{color:'#94a3b8',fontSize:'.75rem'}}>{fmt(p.created_at)}</td>
                        <td>
                          {p.status==='approved' ? <span className="pl pl-g"><i className="bi bi-check-circle-fill me-1"></i>Approved</span>
                          : p.status==='rejected' ? <span className="pl pl-r"><i className="bi bi-x-circle-fill me-1"></i>Rejected</span>
                          : <span className="pl pl-y"><i className="bi bi-hourglass-split me-1"></i>Pending</span>}
                        </td>
                        <td className="text-center pe-4">
                          <div style={{display:'flex',gap:4,justifyContent:'center'}}>
                            {p.status !== 'approved' && (
                              <button onClick={() => approvePlayer(p.id)} title="Approve"
                                style={{width:30,height:30,borderRadius:8,border:'none',cursor:'pointer',background:'#dcfce7',color:'#15803d',fontSize:'.82rem'}}>
                                <i className="bi bi-check-lg"></i>
                              </button>
                            )}
                            {p.status !== 'rejected' && (
                              <button onClick={() => { if(window.confirm(`Reject ${p.full_name}?`)) rejectPlayer(p.id); }} title="Reject"
                                style={{width:30,height:30,borderRadius:8,border:'none',cursor:'pointer',background:'#fee2e2',color:'#b91c1c',fontSize:'.82rem'}}>
                                <i className="bi bi-x-lg"></i>
                              </button>
                            )}
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>

            {/* ── Recent Quiz Attempts ── */}
            <div className="pnl">
              <div className="pnl-h">
                <div className="ph"><div className="phi" style={{background:'#f3e8ff'}}><i className="bi bi-patch-question-fill" style={{color:'#9333ea'}}></i></div>Recent Quiz Attempts</div>
                <span className="pl pl-b">{attempts.length} entries</span>
              </div>
              <div className="table-responsive">
                <table className="table mtbl mb-0">
                  <thead><tr><th className="ps-4">Player</th><th>Quiz</th><th>Score</th><th className="d-none d-md-table-cell">Date</th></tr></thead>
                  <tbody>
                    {attempts.length === 0 ? (
                      <tr><td colSpan="4" style={{textAlign:'center',padding:32,color:'#94a3b8'}}>No quiz attempts yet.</td></tr>
                    ) : attempts.map((a, i) => {
                      const pct = a.total_questions > 0 ? Math.round((a.score/a.total_questions)*100) : 0;
                      return (
                        <tr key={a.id || i}>
                          <td className="ps-4">
                            <div className="avi d-inline-flex me-2" style={{background:'linear-gradient(135deg,#10316B,#4CAF50)',width:28,height:28,fontSize:'.65rem'}}>
                              {(a.guest_name||'?').charAt(0).toUpperCase()}
                            </div>
                            <span style={{fontSize:'.83rem'}}>{a.guest_name || 'Registered User'}</span>
                          </td>
                          <td style={{fontSize:'.83rem'}}>{a.quiz_weeks?.title || '—'}</td>
                          <td>
                            <span style={{fontWeight:800,color:pct>=75?'#15803d':pct>=50?'#d97706':'#b91c1c',fontSize:'.83rem'}}>
                              {a.score}/{a.total_questions}
                            </span>
                            <span style={{color:'#94a3b8',fontSize:'.72rem',marginLeft:4}}>({pct}%)</span>
                          </td>
                          <td className="d-none d-md-table-cell" style={{color:'#94a3b8',fontSize:'.75rem'}}>{fmt(a.created_at)}</td>
                        </tr>
                      );
                    })}
                  </tbody>
                </table>
              </div>
            </div>

            {/* ── Posts Summary ── */}
            <div className="row g-4">
              <div className="col-md-6">
                <div className="pnl">
                  <div className="pnl-h">
                    <div className="ph"><div className="phi" style={{background:'#fee2e2'}}><i className="bi bi-newspaper" style={{color:'#dc2626'}}></i></div>Latest Posts</div>
                    <span className="pl pl-s">{posts.length} total</span>
                  </div>
                  <div style={{maxHeight:280,overflowY:'auto'}}>
                    {posts.slice(0,8).map(post => (
                      <div key={post.id} style={{display:'flex',alignItems:'center',gap:10,padding:'10px 16px',borderBottom:'1px solid #f0f4f8'}}>
                        {post.image_path && <img src={`/${post.image_path}`} alt={post.title} style={{width:40,height:40,borderRadius:8,objectFit:'cover',flexShrink:0}} onError={e=>e.target.style.display='none'} />}
                        <div style={{flexGrow:1,minWidth:0}}>
                          <div style={{fontSize:'.82rem',fontWeight:600,color:'#0d1117',whiteSpace:'nowrap',overflow:'hidden',textOverflow:'ellipsis'}}>{post.title}</div>
                          <span className={`pl ${post.type==='latest'?'pl-b':post.type==='report'?'pl-g':'pl-r'}`} style={{fontSize:'.65rem'}}>{post.type}</span>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              </div>

              <div className="col-md-6">
                <div className="pnl">
                  <div className="pnl-h">
                    <div className="ph"><div className="phi" style={{background:'#fef3c7'}}><i className="bi bi-trophy-fill" style={{color:'#d97706'}}></i></div>League Standings</div>
                    <span className="pl pl-s">{standings.length} clubs</span>
                  </div>
                  <div style={{maxHeight:280,overflowY:'auto'}}>
                    <table className="table mtbl mb-0">
                      <thead><tr><th className="ps-3">POS</th><th>Club</th><th className="text-center">PTS</th><th className="text-center">PL</th></tr></thead>
                      <tbody>
                        {standings.map(s => (
                          <tr key={s.id} style={s.is_featured_club?{background:'#e8f5e9',fontWeight:600}:{}}>
                            <td className="ps-3 fw-bold" style={{color:'#10316B'}}>{s.rank}</td>
                            <td style={{fontSize:'.82rem'}}>
                              {s.is_featured_club ? <><i className="bi bi-shield-fill-check text-success me-1"></i><strong>{s.club_name}</strong></> : s.club_name}
                            </td>
                            <td className="text-center fw-bold" style={{color:'#10316B'}}>{s.points}</td>
                            <td className="text-center text-muted" style={{fontSize:'.78rem'}}>{s.played}</td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </>
  );
}
