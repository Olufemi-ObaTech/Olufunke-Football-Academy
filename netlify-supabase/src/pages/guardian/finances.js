/**
 * /guardian/finances — Guardian Financial Hub
 * Invoices, payment status, ticket submission.
 */
import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';
import NavBar from '../../components/NavBar';
import Footer from '../../components/Footer';
import { checkRateLimit, sanitizeForm } from '../../lib/security';

export default function GuardianFinances() {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [loading,  setLoading]  = useState(true);
  const [invoices, setInvoices] = useState([]);
  const [showTicket, setShowTicket] = useState(false);
  const [ticketForm, setTicketForm] = useState({ type: 'billing', subject: '', message: '' });
  const [ticketStatus, setTicketStatus] = useState('');
  const [submitting, setSubmitting] = useState(false);

  useEffect(() => {
    if (!session) { router.replace('/login'); return; }
    supabase.from('profiles').select('role').eq('id', session.user.id).single()
      .then(({ data }) => {
        if (!data || (data.role !== 'guardian' && data.role !== 'admin')) {
          router.replace('/dashboard'); return;
        }
        loadInvoices();
      });

    async function loadInvoices() {
      const { data } = await supabase.from('guardian_invoices').select('*').eq('guardian_id', session.user.id).order('created_at', { ascending: false });
      setInvoices(data || []);
      setLoading(false);
    }
  }, [session]);

  const outstanding = invoices.filter(i => i.status !== 'paid').reduce((s, i) => s + Number(i.amount), 0);
  const paid        = invoices.filter(i => i.status === 'paid').reduce((s, i) => s + Number(i.amount), 0);
  const fmt = (d) => d ? new Date(d).toLocaleDateString('en-GB', { timeZone: 'Africa/Lagos', day: '2-digit', month: 'short', year: 'numeric' }) : '—';

  const submitTicket = async (e) => {
    e.preventDefault();
    if (!checkRateLimit('guardian-ticket', 3, 300000)) {
      setTicketStatus('error:Too many submissions. Please wait before trying again.');
      return;
    }
    setSubmitting(true); setTicketStatus('');
    const clean = sanitizeForm(ticketForm);
    const { error } = await supabase.from('guardian_tickets').insert({
      guardian_id: session.user.id,
      type: clean.type,
      subject: clean.subject.slice(0, 200),
      message: clean.message.slice(0, 2000),
    });
    setSubmitting(false);
    if (error) { setTicketStatus('error:Failed to submit ticket. Please try again.'); return; }
    setTicketStatus('success:Your ticket has been submitted. The admin team will respond within 48 hours.');
    setTicketForm({ type: 'billing', subject: '', message: '' });
    setShowTicket(false);
  };

  const statusColor = (s) => ({ paid: 'success', unpaid: 'warning', overdue: 'danger', waived: 'secondary' }[s] || 'secondary');

  return (
    <>
      <Head><title>Finances | Guardian Portal — OFA</title></Head>
      <NavBar active="guardian-portal" />

      <section style={{ background: 'linear-gradient(135deg,#10316B,#1a5c2a)', color: '#fff', padding: '28px 0' }}>
        <div className="container d-flex align-items-center justify-content-between flex-wrap gap-3">
          <div>
            <Link href="/guardian/dashboard" className="text-warning text-decoration-none small"><i className="bi bi-arrow-left me-1"></i>Guardian Portal</Link>
            <h1 className="fw-bold mb-0 mt-1" style={{ fontSize: '1.4rem' }}><i className="bi bi-wallet2 me-2"></i>Financial Overview</h1>
          </div>
          <button className="btn btn-warning fw-bold btn-sm" onClick={() => setShowTicket(!showTicket)}>
            <i className="bi bi-headset me-1"></i>Submit Billing Query
          </button>
        </div>
      </section>

      <main className="container py-4">

        {ticketStatus && (
          <div className={`alert alert-${ticketStatus.startsWith('success') ? 'success' : 'danger'} mb-4`}>
            {ticketStatus.split(':')[1]}
          </div>
        )}

        {/* Summary */}
        <div className="row g-3 mb-4">
          {[
            { label: 'Total Outstanding', value: `₦${outstanding.toLocaleString()}`, color: outstanding > 0 ? '#dc2626' : '#15803d', icon: 'bi-exclamation-circle-fill' },
            { label: 'Total Paid', value: `₦${paid.toLocaleString()}`, color: '#15803d', icon: 'bi-check-circle-fill' },
            { label: 'Total Invoices', value: invoices.length, color: '#10316B', icon: 'bi-receipt' },
          ].map(s => (
            <div className="col-md-4" key={s.label}>
              <div className="card border-0 shadow-sm text-center py-4">
                <i className={`bi ${s.icon} fs-2 mb-2`} style={{ color: s.color }}></i>
                <div className="fw-bold fs-4" style={{ color: s.color }}>{s.value}</div>
                <div className="text-muted small">{s.label}</div>
              </div>
            </div>
          ))}
        </div>

        {/* Ticket Form */}
        {showTicket && (
          <div className="card border-0 shadow-sm mb-4">
            <div className="card-header bg-warning text-dark fw-bold">
              <i className="bi bi-headset me-2"></i>Submit Billing Query or Support Ticket
            </div>
            <div className="card-body">
              <form onSubmit={submitTicket}>
                <div className="row g-3">
                  <div className="col-md-4">
                    <label className="form-label fw-semibold small">Ticket Type</label>
                    <select className="form-select form-select-sm" value={ticketForm.type} onChange={e => setTicketForm(p => ({ ...p, type: e.target.value }))}>
                      <option value="billing">Billing / Invoice Query</option>
                      <option value="absence">Absence Notice</option>
                      <option value="general">General Enquiry</option>
                      <option value="safeguarding">Safeguarding Concern</option>
                    </select>
                  </div>
                  <div className="col-md-8">
                    <label className="form-label fw-semibold small">Subject</label>
                    <input type="text" className="form-control form-control-sm" placeholder="e.g. Invoice OFA-2026-001 query" value={ticketForm.subject} onChange={e => setTicketForm(p => ({ ...p, subject: e.target.value }))} required maxLength={200} />
                  </div>
                  <div className="col-12">
                    <label className="form-label fw-semibold small">Message</label>
                    <textarea className="form-control form-control-sm" rows={4} placeholder="Describe your query in detail…" value={ticketForm.message} onChange={e => setTicketForm(p => ({ ...p, message: e.target.value }))} required maxLength={2000}></textarea>
                  </div>
                  <div className="col-12 d-flex gap-2">
                    <button type="submit" disabled={submitting} className="btn btn-primary btn-sm fw-bold">
                      {submitting ? <><span className="spinner-border spinner-border-sm me-1"></span>Submitting…</> : <><i className="bi bi-send-fill me-1"></i>Submit Ticket</>}
                    </button>
                    <button type="button" className="btn btn-outline-secondary btn-sm" onClick={() => setShowTicket(false)}>Cancel</button>
                  </div>
                </div>
              </form>
              <div className="alert alert-info mt-3 small mb-0">
                <i className="bi bi-info-circle me-1"></i>Billing tickets are routed <strong>only to Academy Admin</strong>. Coaches cannot see financial tickets.
              </div>
            </div>
          </div>
        )}

        {/* Invoice List */}
        {loading ? <div className="text-center py-5"><div className="spinner-border text-primary"></div></div> : (
          <div className="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div className="card-header bg-white fw-bold border-0">
              <i className="bi bi-receipt me-2 text-primary"></i>Invoice History
            </div>
            <div className="table-responsive">
              <table className="table table-hover align-middle mb-0">
                <thead style={{ background: '#10316B', color: '#fff' }}>
                  <tr><th>Description</th><th>Player</th><th>Amount</th><th>Due Date</th><th>Status</th><th>PDF</th></tr>
                </thead>
                <tbody>
                  {invoices.length === 0 ? (
                    <tr><td colSpan="6" className="text-center text-muted py-4">No invoices on file.</td></tr>
                  ) : invoices.map(inv => (
                    <tr key={inv.id}>
                      <td className="fw-semibold small">{inv.description}</td>
                      <td className="small text-muted">{inv.player_name || '—'}</td>
                      <td className="fw-bold">₦{Number(inv.amount).toLocaleString()}</td>
                      <td className="small">{fmt(inv.due_date)}</td>
                      <td><span className={`badge bg-${statusColor(inv.status)}`}>{inv.status}</span></td>
                      <td>
                        {inv.pdf_url ? (
                          <a href={inv.pdf_url} target="_blank" rel="noopener" className="btn btn-sm btn-outline-primary"><i className="bi bi-download me-1"></i>PDF</a>
                        ) : <span className="text-muted small">—</span>}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )}
      </main>
      <Footer />
    </>
  );
}
