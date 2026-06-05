import Link from 'next/link';
import { useEffect, useState } from 'react';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';
import { useRouter } from 'next/router';

/**
 * NavBar - Public: Home, About, IQ Quiz, Contact
 * Members only: Our Program, Football Education
 * Store: hidden from nav (code kept for future)
 */
export default function NavBar({ active }) {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [isAdmin,  setIsAdmin]  = useState(false);
  const [isMember, setIsMember] = useState(false);
  const [loaded,   setLoaded]   = useState(false);

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
          setIsMember(
            data.role === 'admin' ||
            (data.role === 'player' && data.status === 'approved')
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
    { href: '/',        label: 'Home',             key: 'home'    },
    { href: '/about',   label: 'About Us',          key: 'about'   },
    { href: '/quiz',    label: 'Football IQ Quiz',  key: 'quiz'    },
    { href: '/contact', label: 'Contact Us',        key: 'contact' },
  ];

  const memberNav = [
    { href: '/program',            label: 'Our Program',        key: 'program'   },
    { href: '/football-education', label: 'Football Education',  key: 'education' },
  ];

  return (
    <nav className="navbar navbar-expand-lg navbar-dark bg-dark py-3 sticky-top shadow">
      <div className="container">
        <Link className="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
          <img
            src="/images/OFA New Logo.jpg"
            alt="OFA Logo"
            width="48"
            height="48"
            className="rounded-circle border border-warning border-2"
            style={{ objectFit: 'cover' }}
          />
          <span className="text-warning">OLUFUNKE FOOTBALL ACADEMY</span>
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
          <ul className="navbar-nav ms-auto align-items-lg-center">

            {/* Public links - always visible */}
            {publicNav.map((n) => (
              <li className="nav-item" key={n.key}>
                <Link
                  className={`nav-link${active === n.key ? ' active' : ''}`}
                  href={n.href}
                >
                  {n.label}
                </Link>
              </li>
            ))}

            {/* Members-only links - approved players and admin only */}
            {loaded && isMember && memberNav.map((n) => (
              <li className="nav-item" key={n.key}>
                <Link
                  className={`nav-link${active === n.key ? ' active' : ''}`}
                  href={n.href}
                >
                  {n.label}
                </Link>
              </li>
            ))}

            {/* Admin link */}
            {loaded && isAdmin && (
              <li className="nav-item">
                <Link
                  className={`nav-link${active === 'admin' ? ' active' : ''} text-warning`}
                  href="/admin"
                >
                  Admin Panel
                </Link>
              </li>
            )}

            {/* Auth area */}
            {session ? (
              <>
                <li className="nav-item ms-lg-2">
                  <Link
                    className={`nav-link${active === 'dashboard' ? ' active' : ''}`}
                    href="/dashboard"
                  >
                    Dashboard
                  </Link>
                </li>
                <li className="nav-item ms-lg-1">
                  <button className="btn btn-outline-light btn-sm" onClick={signOut}>
                    Log Out
                  </button>
                </li>
              </>
            ) : (
              <>
                <li className="nav-item ms-lg-2">
                  <Link className="nav-link" href="/login">
                    Login
                  </Link>
                </li>
                <li className="nav-item ms-lg-1">
                  <Link className="btn btn-warning btn-sm fw-bold px-3 py-2" href="/register">
                    Register
                  </Link>
                </li>
              </>
            )}
          </ul>
        </div>
      </div>
    </nav>
  );
}
