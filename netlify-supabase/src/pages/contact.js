import { useState } from 'react';
import Head from 'next/head';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';
import QuizCTA from '../components/QuizCTA';
import { sendContactMessage } from '../lib/api';

export default function Contact() {
  const [form,    setForm]    = useState({ name:'', email:'', phone:'', subject:'', message:'' });
  const [success, setSuccess] = useState('');
  const [error,   setError]   = useState('');
  const [loading, setLoading] = useState(false);

  const handle = e => setForm(p => ({...p, [e.target.name]: e.target.value}));

  const submit = async (e) => {
    e.preventDefault();
    setLoading(true); setError(''); setSuccess('');
    try {
      await sendContactMessage(form);
      setSuccess('Thank you! Your message has been received. We\'ll get back to you shortly.');
      setForm({ name:'', email:'', phone:'', subject:'', message:'' });
    } catch(err) {
      setError(err.message || 'Failed to send. Please try again.');
    } finally { setLoading(false); }
  };

  return (
    <>
      <Head><title>Olufunke Football Academy | Contact Us</title></Head>
      <NavBar active="contact" />

      {/* Hero */}
      <section className="py-5 text-white text-center" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <h1 className="fw-bold display-5"><i className="bi bi-envelope-heart-fill me-2"></i>Contact Us</h1>
          <p className="lead opacity-75">We&apos;d love to hear from you — reach out for trials, inquiries, or partnerships.</p>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row g-5">
            {/* Contact Info */}
            <div className="col-md-5">
              <h3 className="fw-bold mb-4" style={{color:'#10316B'}}>Get In Touch</h3>
              {[
                {bg:'#10316B', icon:'bi-telephone-fill', label:'Phone', content:<a href="tel:09079917993" className="text-decoration-none text-dark">09079917993</a>},
                {bg:'#4CAF50', icon:'bi-envelope-fill',  label:'Email', content:<a href="mailto:Olufunkefootballacademy@gmail.com" className="text-decoration-none text-dark">Olufunkefootballacademy@gmail.com</a>},
                {bg:'#ffc107', icon:'bi-geo-alt-fill',   label:'Location', iconColor:'text-dark', content:<><p className="mb-0 text-muted">Lagos State, Nigeria</p><small className="text-muted">Training: Nathaniel Football Stadium, Ajegunle</small></>},
                {bg:'#dc3545', icon:'bi-clock-fill',     label:'Training Hours', content:<><p className="mb-0 text-muted">Monday – Saturday</p><small className="text-muted">Morning &amp; Afternoon Sessions</small></>},
              ].map(({bg,icon,label,content,iconColor})=>(
                <div className="d-flex align-items-start mb-4" key={label}>
                  <div className="me-3 p-3 rounded-circle text-white" style={{background:bg,minWidth:50,textAlign:'center'}}>
                    <i className={`bi ${icon} fs-5 ${iconColor||''}`}></i>
                  </div>
                  <div><h6 className="fw-bold mb-1">{label}</h6>{content}</div>
                </div>
              ))}

              <h6 className="fw-bold mt-4 mb-3" style={{color:'#10316B'}}>Follow Us</h6>
              <div className="d-flex gap-3">
                <a href="https://www.youtube.com/@olufunkefootballacademy" target="_blank" rel="noopener" className="btn btn-danger btn-sm"><i className="bi bi-youtube fs-5"></i></a>
                <a href="https://web.facebook.com/people/Olufunke-Football-Academy/61554694136830/" target="_blank" rel="noopener" className="btn btn-primary btn-sm"><i className="bi bi-facebook fs-5"></i></a>
                <a href="https://www.instagram.com/olufunkefootballacademy" target="_blank" rel="noopener" className="btn btn-sm" style={{background:'#E1306C',color:'#fff'}}><i className="bi bi-instagram fs-5"></i></a>
              </div>

              <div className="mt-4 p-3 bg-light rounded-3">
                <h6 className="fw-bold mb-2" style={{color:'#10316B'}}>Affiliations</h6>
                <div className="d-flex flex-wrap gap-2">
                  <span className="badge bg-primary">FIFA TMS</span>
                  <span className="badge bg-success">Lagos State FA</span>
                  <span className="badge bg-warning text-dark">Nigeria Football Federation</span>
                  <span className="badge bg-secondary">RC-7147523</span>
                </div>
              </div>
            </div>

            {/* Contact Form */}
            <div className="col-md-7">
              <div className="p-4 bg-white rounded-3 shadow">
                <h3 className="fw-bold mb-4" style={{color:'#10316B'}}>Send Us a Message</h3>
                {success && <div className="alert alert-success"><i className="bi bi-check-circle-fill me-2"></i>{success}</div>}
                {error   && <div className="alert alert-danger"><i className="bi bi-exclamation-triangle me-2"></i>{error}</div>}
                <form onSubmit={submit} noValidate>
                  <div className="row g-3">
                    <div className="col-md-6">
                      <label className="form-label fw-semibold">Full Name <span className="text-danger">*</span></label>
                      <input type="text" name="name" className="form-control" value={form.name} onChange={handle} placeholder="Your full name" required />
                    </div>
                    <div className="col-md-6">
                      <label className="form-label fw-semibold">Email Address <span className="text-danger">*</span></label>
                      <input type="email" name="email" className="form-control" value={form.email} onChange={handle} placeholder="your@email.com" required />
                    </div>
                    <div className="col-md-6">
                      <label className="form-label fw-semibold">Phone Number</label>
                      <input type="tel" name="phone" className="form-control" value={form.phone} onChange={handle} placeholder="e.g. 09079917993" />
                    </div>
                    <div className="col-md-6">
                      <label className="form-label fw-semibold">Subject</label>
                      <select name="subject" className="form-select" value={form.subject} onChange={handle}>
                        <option value="">Select a subject</option>
                        {['Trial Registration','U19 Registration','Store / Merchandise','Partnership / Sponsorship','General Inquiry'].map(s=>(
                          <option key={s} value={s}>{s}</option>
                        ))}
                      </select>
                    </div>
                    <div className="col-12">
                      <label className="form-label fw-semibold">Message <span className="text-danger">*</span></label>
                      <textarea name="message" rows="5" className="form-control" value={form.message} onChange={handle} placeholder="Tell us about yourself or your inquiry..." required></textarea>
                    </div>
                    <div className="col-12">
                      <button type="submit" className="btn btn-success btn-lg w-100 fw-bold" disabled={loading}>
                        <i className="bi bi-send-fill me-2"></i>{loading ? 'Sending…' : 'Send Message'}
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Book Trial CTA */}
      <section className="py-5" style={{background:'#f0f4ff'}}>
        <div className="container text-center">
          <h2 className="fw-bold mb-3" style={{color:'#10316B'}}>Ready to Book a Trial?</h2>
          <p className="text-muted mb-4">Call or email us directly to schedule your trial session at Olufunke Football Academy.</p>
          <div className="d-flex justify-content-center gap-3 flex-wrap">
            <a href="tel:09079917993" className="btn btn-success btn-lg fw-bold px-4"><i className="bi bi-telephone-fill me-2"></i>Call: 09079917993</a>
            <a href="mailto:Olufunkefootballacademy@gmail.com" className="btn btn-outline-primary btn-lg fw-bold px-4"><i className="bi bi-envelope-fill me-2"></i>Send Email</a>
          </div>
        </div>
      </section>

      <QuizCTA />
      <div className="py-3 text-center bg-white"><a href="#top" className="btn btn-outline-dark btn-sm"><i className="bi bi-arrow-up-circle"></i> Back to Top</a></div>
      <Footer />
    </>
  );
}
