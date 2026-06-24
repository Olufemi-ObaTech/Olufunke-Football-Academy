import Link from 'next/link';
import { useEffect, useState } from 'react';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';
import { useRouter } from 'next/router';

export default function NavBar({ active }) {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [isAdmin,    setIsAdmin]    = useState(false);
  const [isGuardian, setIsGuardian] = useState(false);
  const [isMember,   setIsMember]   = useState(false);
  const [loaded,     setLoaded]     = useState(false);
  const [liveTime,   setLiveTime]   = useState('');
  const [liveDate,   setLiveDate]   = useState('');

  // Live Lagos time clock (WAT = Africa/Lagos = UTC+1)
  useEffect(() => {
    const tick = () => {
      const now = new Date();
      setLiveTime(now.toLocaleTimeString('en-GB', { timeZone: 'Africa/Lagos', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true }));
      setLiveDate(now.toLocaleDateString('en-GB', { timeZone: 'Africa/Lagos', weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' }));
    };
    tick();
    const timer = setInterval(tick, 1000);
    return () => clearInterval(timer);
  }, []);

  useEffect(() => {
    if (!session) { setLoaded(true); return; }
    supabase
      .from('profiles')
      .select('role,status')
      .eq('id', session.user.id)
      .single()
      .then(({ data }) => {
        if (data) {
          setIsAdmin(data.role === 'admin');
          setIsGuardian(data.role === 'guardian');
          setIsMember(
            data.role === 'admin' ||
            data.role === 'coach' ||
            (data.role === 'player'   && data.status === 'approved') ||
            (data.role === 'guardian' && data.status === 'approved')
          );
        }
        setLoaded(true);
      });
  }, [session]);

  const signOut = async () => {
    await supabase.auth.signOut();
    router.push('/');
  };

  const publicNav = [
    { href: '/',        label: 'Home',            key: 'home'    },
    { href: '/about',   label: 'About Us',         key: 'about'   },
    { href: '/quiz',    label: 'Football IQ Quiz', key: 'quiz'    },
    { href: '/contact', label: 'Contact Us',       key: 'contact' },
  ];

  const memberNav = [
    { href: '/program',            label: 'Our Program',       key: 'program'   },
    { href: '/football-education', label: 'Football Education', key: 'education' },
  ];

  return (
    <>
      {/* ── Lagos Time Bar ── */}
      <div style={{ background: '#10316B', borderBottom: '1px solid rgba(255,193,7,.25)', padding: '4px 0', fontSize: '.75rem', color: 'rgba(255,255,255,.85)' }}>
        <div className="container d-flex flex-wrap justify-content-between align-items-center gap-2">
          <span>
            <span className="text-warning fw-bold me-1">OFA</span>
            Olufunke Football Academy — Lagos, Nigeria
          </span>
          {liveDate && (
            <span className="d-flex align-items-center gap-2">
              <i className="bi bi-geo-alt-fill text-warning"></i>
              <span><strong className="text-warning">Lagos, Nigeria</strong></span>
              <span className="d-none d-sm-inline">|</span>
              <span className="d-none d-sm-inline"><i className="bi bi-calendar3 me-1"></i>{liveDate}</span>
              <span>|</span>
              <span><i className="bi bi-clock-fill me-1"></i><strong>{liveTime}</strong> <span style={{ opacity: .7 }}>WAT</span></span>
            </span>
          )}
        </div>
      </div>

      {/* ── Main Navbar ── */}
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark py-2 sticky-top shadow">
        <div className="container">
          <Link className="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
            <img
              src="/images/OFA New Logo.jpg"
              alt="OFA Logo"
              width="42"
              height="42"
              className="rounded-circle border border-warning border-2"
              style={{ objectFit: 'cover' }}
            />
            <span className="text-warning" style={{ fontSize: '.9rem' }}>OLUFUNKE FA</span>
          </Link>

          <button
            className="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navMain"
            aria-controls="navMain"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span className="navbar-toggler-icon"></span>
          </button>

          <div className="collapse navbar-collapse" id="navMain">
            <ul className="navbar-nav ms-auto align-items-lg-center gap-lg-1">

              {/* Public links */}
              {publicNav.map((n) => (
                <li className="nav-item" key={n.key}>
                  <Link className={`nav-link px-2${active === n.key ? ' active fw-bold' : ''}`} href={n.href}>
                    {n.label}
                  </Link>
                </li>
              ))}

              {/* Member-only links */}
              {loaded && isMember && !isGuardian && memberNav.map((n) => (
                <li className="nav-item" key={n.key}>
                  <Link className={`nav-link px-2${active === n.key ? ' active fw-bold' : ''}`} href={n.href}>
                    {n.label}
                  </Link>
                </li>
              ))}

              {/* Guardian Education link (read-only) */}
              {loaded && isGuardian && (
                <li className="nav-item">
                  <Link className={`nav-link px-2${active === 'education' ? ' active fw-bold' : ''}`} href="/football-education">
                    Education Hub
                  </Link>
                </li>
              )}

              {/* Guardian Portal link */}
              {loaded && (isGuardian || isAdmin) && (
                <li className="nav-item">
                  <Link className={`nav-link px-2${active === 'guardian-portal' ? ' active fw-bold' : ''} text-info`} href="/guardian/dashboard">
                    <i className="bi bi-people-fill me-1"></i>Guardian Portal
                  </Link>
                </li>
              )}

              {/* Admin link */}
              {loaded && isAdmin && (
                <li className="nav-item">
                  <Link className={`nav-link px-2${active === 'admin' ? ' active fw-bold' : ''} text-warning`} href="/admin">
                    <i className="bi bi-shield-fill-check me-1"></i>Admin
                  </Link>
                </li>
              )}

              {/* Auth area */}
              {session ? (
                <>
                  <li className="nav-item ms-lg-1">
                    <Link
                      className={`nav-link px-2${active === 'dashboard' ? ' active fw-bold' : ''}`}
                      href={isGuardian ? '/guardian/dashboard' : '/dashboard'}
                    >
                      <i className="bi bi-speedometer2 me-1"></i>Dashboard
                    </Link>
                  </li>
                  <li className="nav-item ms-lg-1">
                    <button className="btn btn-outline-light btn-sm px-3" onClick={signOut}>
                      <i className="bi bi-box-arrow-right me-1"></i>Log Out
                    </button>
                  </li>
                </>
              ) : (
                <>
                  <li className="nav-item ms-lg-1">
                    <Link className="nav-link px-2" href="/login">Login</Link>
                  </li>
                  <li className="nav-item ms-lg-1">
                    <Link className="btn btn-warning btn-sm fw-bold px-3" href="/register">Register</Link>
                  </li>
                  <li className="nav-item ms-lg-1">
                    <Link className="btn btn-outline-info btn-sm fw-bold px-3" href="/guardian-register">Guardian</Link>
                  </li>
                </>
              )}
            </ul>
          </div>
        </div>
      </nav>
    </>
  );
}
