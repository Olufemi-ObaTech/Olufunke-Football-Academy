/**
 * /guardian/dashboard — Guardian Portal Hub
 * Access: Guardian + Admin only. Players redirected to /dashboard.
 */
import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';

export default function GuardianDashboard() {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [loading,       setLoading]       = useState(true);
  const [profile,       setProfile]       = useState(null);
  const [children,      setChildren]      = useState([]);
  const [invoices,      setInvoices]      = useState([]);
  const [announcements, setAnnouncements] = useState([]);
  const [consent,       setConsent]       = useState(null);
  const [fixtures,      setFixtures]      = useState([]);

  useEffect(() => {
    if (!session) { router.replace('/login'); return; }

    supabase.from('profiles').select('role,status,full_name').eq('id', session.user.id).single()
      .then(({ data }) => {
        if (!data || (data.role !== 'guardian' && data.role !== 'admin')) {
          router.replace('/dashboard');
          return;
        }
        setProfile(data);
        loadData();
      });

    async function loadData() {
      const [
        { data: ch },
        { data: inv },
        { data: ann },
        { data: con },
        { data: fix },
      ] = await Promise.all([
        supabase.from('guardian_children').select('*').eq('guardian_id', session.user.id),
        supabase.from('guardian_invoices').select('*').eq('guardian_id', session.user.id).order('due_date').limit(5),
        supabase.from('announcements').select('*').order('created_at', { ascending: false }).limit(3),
        supabase.from('consent_history').select('*').eq('guardian_id', session.user.id).eq('is_current', true).single(),
        supabase.from('next_fixtures').select('*').eq('is_active', true).order('fixture_date').limit(3),
      ]);
      setChildren(ch || []);
      setInvoices(inv || []);
      setAnnouncements(ann || []);
      setConsent(con || null);
      setFixtures(fix || []);
      setLoading(false);
    }
  }, [session]);

  const outstanding = invoices.filter(i => i.status !== 'paid').reduce((s, i) => s + Number(i.amount), 0);
  const fmt = (d) => d ? new Date(d).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', timeZone: 'Africa/Lagos' }) : '—';

  const consentBadge = () => {
    if (!consent) return { label: 'Not Signed', color: 'danger' };
    if (consent.expires_at && new Date(consent.expires_at) < new Date()) return { label: 'Expired', color: 'warning' };
    return { label: 'Signed & Valid', color: 'success' };
  };
  const cb = consentBadge();

  if (loading) return (
    <>
      <NavBar active="guardian-portal" />
      <div className="d-flex align-items-center justify-content-center" style={{ minHeight: '60vh' }}>
        <div className="text-center">
          <div className="spinner-border text-primary mb-3"></div>
          <p className="text-muted">Loading Guardian Portal…</p>
        </div>
      </div>
    </>
  );

  return (
    <>
      <Head><title>Guardian Portal | Olufunke Football Academy</title></Head>
      <NavBar active="guardian-portal" />

      {/* Hero */}
      <section style={{ background: 'linear-gradient(135deg,#10316B 0%,#1a5c2a 100%)', color: '#fff', padding: '36px 0' }}>
        <div className="container">
          <div className="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
              <div className="badge bg-warning text-dark mb-2" style={{ fontSize: '.75rem' }}>GUARDIAN PORTAL</div>
              <h1 className="fw-bold mb-1" style={{ fontSize: '1.6rem' }}>
                Welcome, {profile?.full_name?.split(' ')[0] || 'Guardian'}
              </h1>
              <p className="opacity-75 mb-0">Manage your child's academy journey from one place.</p>
            </div>
            <div className="d-flex gap-2 flex-wrap">
              <Link href="/guardian/schedule"  className="btn btn-warning btn-sm fw-bold"><i className="bi bi-calendar3 me-1"></i>Schedule</Link>
              <Link href="/guardian/finances"  className="btn btn-outline-light btn-sm"><i className="bi bi-wallet2 me-1"></i>Finances</Link>
              <Link href="/guardian/learn"     className="btn btn-success btn-sm fw-bold"><i className="bi bi-mortarboard-fill me-1"></i>My Courses</Link>
            </div>
          </div>
        </div>
      </section>

      <main className="container py-4">

        {/* Summary Cards */}
        <div className="row g-3 mb-4">
          {[
            { icon: 'bi-people-fill', label: 'Children Linked', value: children.length, color: '#10316B', link: null },
            { icon: 'bi-wallet2', label: 'Outstanding Balance', value: `₦${outstanding.toLocaleString()}`, color: outstanding > 0 ? '#dc2626' : '#15803d', link: '/guardian/finances' },
            { icon: 'bi-file-earmark-check-fill', label: 'Consent Status', value: cb.label, color: cb.color === 'success' ? '#15803d' : '#dc2626', link: '/consent-form' },
            { icon: 'bi-calendar-event-fill', label: 'Next Fixtures', value: fixtures.length, color: '#1d4ed8', link: '/guardian/schedule' },
          ].map(c => (
            <div className="col-6 col-md-3" key={c.label}>
              <div className="card border-0 shadow-sm h-100" style={{ borderTop: `3px solid ${c.color}` }}>
                <div className="card-body text-center py-3">
                  <i className={`bi ${c.icon} fs-2 mb-2`} style={{ color: c.color }}></i>
                  <div className="fw-bold fs-5" style={{ color: c.color }}>{c.value}</div>
                  <div className="text-muted small">{c.label}</div>
                  {c.link && <Link href={c.link} className="stretched-link"></Link>}
                </div>
              </div>
            </div>
          ))}
        </div>

        <div className="row g-4">

          {/* Linked Children */}
          <div className="col-md-6">
            <div className="card border-0 shadow-sm h-100">
              <div className="card-header bg-white border-0 fw-bold d-flex justify-content-between align-items-center">
                <span><i className="bi bi-person-badge-fill text-primary me-2"></i>Your Children</span>
              </div>
              <div className="card-body">
                {children.length === 0 ? (
                  <div className="text-center text-muted py-3">
                    <i className="bi bi-person-plus fs-1 opacity-25 d-block mb-2"></i>
                    No children linked yet.
                  </div>
                ) : children.map(c => (
                  <div key={c.id} className="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-2">
                    <div style={{ width: 44, height: 44, borderRadius: '50%', background: 'linear-gradient(135deg,#10316B,#4CAF50)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#fff', fontWeight: 700, flexShrink: 0 }}>
                      {(c.player_name || '').charAt(0).toUpperCase()}
                    </div>
                    <div>
                      <div className="fw-bold">{c.player_name}</div>
                      <div className="text-muted small">{c.player_position} · {c.player_age_group} · Age {c.player_age}</div>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Upcoming Fixtures */}
          <div className="col-md-6">
            <div className="card border-0 shadow-sm h-100">
              <div className="card-header bg-white border-0 fw-bold d-flex justify-content-between align-items-center">
                <span><i className="bi bi-calendar3 text-warning me-2"></i>Upcoming Fixtures</span>
                <Link href="/guardian/schedule" className="btn btn-sm btn-outline-primary">View All</Link>
              </div>
              <div className="card-body">
                {fixtures.length === 0 ? (
                  <p className="text-muted text-center py-3">No upcoming fixtures scheduled.</p>
                ) : fixtures.map(f => (
                  <div key={f.id} className="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                      <div className="fw-semibold small">{f.home_team} vs {f.away_team}</div>
                      <div className="text-muted" style={{ fontSize: '.78rem' }}>{f.competition} · {f.venue}</div>
                    </div>
                    <span className="badge bg-warning text-dark">{fmt(f.fixture_date)}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Financial Snapshot */}
          <div className="col-md-6">
            <div className="card border-0 shadow-sm h-100">
              <div className="card-header bg-white border-0 fw-bold d-flex justify-content-between align-items-center">
                <span><i className="bi bi-wallet2 text-success me-2"></i>Financial Snapshot</span>
                <Link href="/guardian/finances" className="btn btn-sm btn-outline-success">View Invoices</Link>
              </div>
              <div className="card-body">
                {invoices.length === 0 ? (
                  <p className="text-muted text-center py-3">No invoices on file.</p>
                ) : invoices.map(inv => (
                  <div key={inv.id} className="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                      <div className="fw-semibold small">{inv.description}</div>
                      <div className="text-muted" style={{ fontSize: '.78rem' }}>Due: {fmt(inv.due_date)}</div>
                    </div>
                    <div className="text-end">
                      <div className="fw-bold">₦{Number(inv.amount).toLocaleString()}</div>
                      <span className={`badge bg-${inv.status === 'paid' ? 'success' : inv.status === 'overdue' ? 'danger' : 'warning'} text-${inv.status === 'paid' ? 'white' : 'dark'}`}>
                        {inv.status}
                      </span>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Announcements */}
          <div className="col-md-6">
            <div className="card border-0 shadow-sm h-100">
              <div className="card-header bg-white border-0 fw-bold">
                <i className="bi bi-megaphone-fill text-danger me-2"></i>Academy Announcements
              </div>
              <div className="card-body">
                {announcements.length === 0 ? (
                  <p className="text-muted text-center py-3">No announcements yet.</p>
                ) : announcements.map(a => (
                  <div key={a.id} className="mb-3 p-3 bg-light rounded-3">
                    <div className="fw-bold small mb-1">{a.title}</div>
                    <p className="text-muted mb-0" style={{ fontSize: '.82rem', lineHeight: 1.6 }}>{a.body.slice(0, 180)}{a.body.length > 180 ? '…' : ''}</p>
                    <div className="text-muted mt-1" style={{ fontSize: '.72rem' }}>{fmt(a.created_at)}</div>
                  </div>
                ))}
              </div>
            </div>
          </div>

        </div>

        {/* Quick Actions */}
        <div className="row g-3 mt-2">
          <div className="col-12">
            <div className="card border-0 shadow-sm">
              <div className="card-header bg-white border-0 fw-bold">
                <i className="bi bi-lightning-fill text-warning me-2"></i>Quick Actions
              </div>
              <div className="card-body">
                <div className="row g-3">
                  {[
                    { icon: 'bi-file-earmark-pdf-fill', label: 'Download Consent Form', href: '/consent-form', color: '#10316B' },
                    { icon: 'bi-mortarboard-fill', label: 'Guardian Courses', href: '/guardian/learn', color: '#4CAF50' },
                    { icon: 'bi-calendar3', label: 'View Schedule', href: '/guardian/schedule', color: '#f59e0b' },
                    { icon: 'bi-wallet2', label: 'View Invoices', href: '/guardian/finances', color: '#dc2626' },
                    { icon: 'bi-book-fill', label: 'Education Hub', href: '/football-education', color: '#1d4ed8' },
                    { icon: 'bi-trophy-fill', label: 'Football IQ Quiz', href: '/quiz', color: '#7c3aed' },
                  ].map(a => (
                    <div className="col-6 col-md-4 col-lg-2" key={a.label}>
                      <Link href={a.href} className="text-decoration-none">
                        <div className="text-center p-3 rounded-3 h-100" style={{ border: `2px solid ${a.color}20`, background: `${a.color}08`, transition: 'transform .15s' }}
                          onMouseEnter={e => e.currentTarget.style.transform = 'translateY(-2px)'}
                          onMouseLeave={e => e.currentTarget.style.transform = ''}>
                          <i className={`bi ${a.icon} fs-3 d-block mb-2`} style={{ color: a.color }}></i>
                          <span style={{ fontSize: '.78rem', fontWeight: 600, color: '#374151' }}>{a.label}</span>
                        </div>
                      </Link>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>

      </main>
      <Footer />
    </>
  );
}
