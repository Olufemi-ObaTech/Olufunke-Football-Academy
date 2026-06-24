/**
 * /guardian/schedule — Guardian Schedule & Attendance View
 * View-only. NEVER shows coach tactical notes.
 */
import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';

export default function GuardianSchedule() {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();
  const [loading,  setLoading]  = useState(true);
  const [fixtures, setFixtures] = useState([]);
  const [results,  setResults]  = useState([]);

  useEffect(() => {
    if (!session) { router.replace('/login'); return; }
    supabase.from('profiles').select('role').eq('id', session.user.id).single()
      .then(({ data }) => {
        if (!data || (data.role !== 'guardian' && data.role !== 'admin')) {
          router.replace('/dashboard'); return;
        }
        loadSchedule();
      });

    async function loadSchedule() {
      const [{ data: fix }, { data: res }] = await Promise.all([
        supabase.from('next_fixtures').select('id,week_label,fixture_date,home_team,away_team,competition,venue,kick_off_time,is_active').eq('is_active', true).order('fixture_date'),
        supabase.from('match_results').select('id,week_label,match_date,opponent,result_badge,status_color,competition,venue').order('match_date', { ascending: false }).limit(10),
      ]);
      setFixtures(fix || []);
      setResults(res || []);
      setLoading(false);
    }
  }, [session]);

  const fmt = (d, opts = {}) => d ? new Date(d).toLocaleDateString('en-GB', { timeZone: 'Africa/Lagos', day: '2-digit', month: 'short', year: 'numeric', ...opts }) : '—';
  const fmtTime = (t) => { if (!t) return ''; const d = new Date(`1970-01-01T${t}`); return d.toLocaleTimeString('en-GB', { hour: 'numeric', minute: '2-digit', hour12: true }); };

  return (
    <>
      <Head><title>Schedule | Guardian Portal — OFA</title></Head>
      <NavBar active="guardian-portal" />

      <section style={{ background: 'linear-gradient(135deg,#10316B,#1a5c2a)', color: '#fff', padding: '28px 0' }}>
        <div className="container d-flex align-items-center justify-content-between flex-wrap gap-3">
          <div>
            <Link href="/guardian/dashboard" className="text-warning text-decoration-none small"><i className="bi bi-arrow-left me-1"></i>Guardian Portal</Link>
            <h1 className="fw-bold mb-0 mt-1" style={{ fontSize: '1.4rem' }}><i className="bi bi-calendar3 me-2"></i>Schedule & Fixtures</h1>
            <p className="opacity-75 mb-0 small">View-only — Academy schedule for your child</p>
          </div>
        </div>
      </section>

      <main className="container py-4">
        {loading ? <div className="text-center py-5"><div className="spinner-border text-primary"></div></div> : (
          <>
            {/* Upcoming Fixtures */}
            <h5 className="fw-bold mb-3" style={{ color: '#10316B' }}><i className="bi bi-calendar-event-fill text-warning me-2"></i>Upcoming Fixtures</h5>
            {fixtures.length === 0 ? (
              <div className="alert alert-info"><i className="bi bi-info-circle me-2"></i>No upcoming fixtures scheduled at this time.</div>
            ) : (
              <div className="row g-3 mb-5">
                {fixtures.map(f => (
                  <div className="col-md-6 col-lg-4" key={f.id}>
                    <div className="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                      <div style={{ background: 'linear-gradient(135deg,#f59e0b,#d97706)', padding: '14px 20px' }}>
                        <span className="badge bg-dark fw-bold">{f.week_label || 'Upcoming'}</span>
                        <div className="fw-bold text-white mt-1" style={{ fontSize: '1.05rem' }}>{f.home_team} vs {f.away_team}</div>
                      </div>
                      <div className="card-body">
                        <div className="d-flex flex-column gap-2">
                          <div className="d-flex align-items-center gap-2 text-muted small">
                            <i className="bi bi-calendar3"></i>
                            <span>{fmt(f.fixture_date, { weekday: 'long' })}</span>
                          </div>
                          {f.kick_off_time && (
                            <div className="d-flex align-items-center gap-2 text-muted small">
                              <i className="bi bi-clock-fill"></i><span>Kick-off: {fmtTime(f.kick_off_time)}</span>
                            </div>
                          )}
                          <div className="d-flex align-items-center gap-2 text-muted small">
                            <i className="bi bi-geo-alt-fill"></i><span>{f.venue}</span>
                          </div>
                          <div className="d-flex align-items-center gap-2 text-muted small">
                            <i className="bi bi-trophy-fill text-warning"></i><span>{f.competition}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            )}

            {/* Past Results */}
            <h5 className="fw-bold mb-3" style={{ color: '#10316B' }}><i className="bi bi-clock-history me-2"></i>Recent Results</h5>
            <div className="card border-0 shadow-sm rounded-4 overflow-hidden">
              <div className="table-responsive">
                <table className="table table-hover align-middle mb-0">
                  <thead style={{ background: '#10316B', color: '#fff' }}>
                    <tr>
                      <th>Week</th><th>Date</th><th>Opponent</th><th>Competition</th><th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    {results.length === 0 ? (
                      <tr><td colSpan="5" className="text-center text-muted py-4">No match results yet.</td></tr>
                    ) : results.map(r => (
                      <tr key={r.id}>
                        <td><span className="badge bg-secondary">{r.week_label || '—'}</span></td>
                        <td className="text-muted small">{fmt(r.match_date)}</td>
                        <td className="fw-semibold">{r.opponent}</td>
                        <td className="text-muted small">{r.competition}</td>
                        <td><span className={`badge bg-${r.status_color} px-3`}>{r.result_badge}</span></td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>

            <div className="alert alert-secondary mt-4 small">
              <i className="bi bi-info-circle me-2"></i>
              Schedule is view-only for guardians. Coaching notes and tactical plans are not displayed. For attendance queries, please submit a support ticket via the dashboard.
            </div>
          </>
        )}
      </main>
      <Footer />
    </>
  );
}
