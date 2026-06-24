/**
 * /coach-register — Coach Registration Page (3-step)
 * Step 1: Personal Info | Step 2: Coaching Profile | Step 3: Account Security
 */
import { useState, useEffect } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';
import { checkRateLimit, sanitizeForm, validateEmail, validatePassword } from '../lib/security';

export default function CoachRegister() {
  const supabase = useSupabaseClient();
  const session  = useSession();
  const router   = useRouter();

  const [step,    setStep]    = useState(1);
  const [loading, setLoading] = useState(false);
  const [error,   setError]   = useState('');
  const [success, setSuccess] = useState(false);
  const [showPwd, setShowPwd] = useState(false);
  const [photoFile, setPhotoFile] = useState(null);

  const [form, setForm] = useState({
    name: '', email: '', phone: '', nationality: 'Nigerian',
    coaching_role: '', experience_years: '', qualifications: '', specialisation: '',
    password: '', password_confirmation: '',
  });

  useEffect(() => { if (session) router.replace('/dashboard'); }, [session]);
  const handle = e => setForm(p => ({ ...p, [e.target.name]: e.target.value }));

  const validateStep = () => {
    if (step === 1) {
      if (!form.name.trim())  return 'Full name is required.';
      if (!form.email.trim()) return 'Email is required.';
      if (!form.phone.trim()) return 'Phone number is required.';
    }
    if (step === 2) {
      if (!form.coaching_role)  return 'Coaching role is required.';
      if (!form.experience_years) return 'Years of experience is required.';
      if (!photoFile) return 'Passport photograph is required.';
      const allowed = ['image/jpeg','image/jpg','image/png','image/webp'];
      if (!allowed.includes(photoFile.type)) return 'Passport photo must be JPG or PNG.';
      if (photoFile.size > 3 * 1024 * 1024) return 'Photo must be under 3MB.';
    }
    if (step === 3) {
      if (form.password.length < 8) return 'Password must be at least 8 characters.';
      if (form.password !== form.password_confirmation) return 'Passwords do not match.';
    }
    return null;
  };

  const next = () => { const e = validateStep(); if (e) { setError(e); return; } setError(''); setStep(s => s + 1); };

  const submit = async (e) => {
    e.preventDefault();
    const err = validateStep();
    if (err) { setError(err); return; }

    if (!checkRateLimit('coach-register', 3, 300000)) {
      setError('Too many attempts. Please wait a few minutes.');
      return;
    }
    if (!validateEmail(form.email.trim())) { setError('Invalid email address.'); return; }
    const pwdCheck = validatePassword(form.password);
    if (!pwdCheck.valid) { setError(pwdCheck.errors[0]); return; }

    setLoading(true); setError('');
    const clean = sanitizeForm(form);

    const { data: signUpData, error: signUpError } = await supabase.auth.signUp({
      email: clean.email.trim(),
      password: form.password,
      options: {
        data: {
          full_name: clean.name.trim(),
          phone: clean.phone.trim(),
          nationality: clean.nationality,
          role: 'coach',
          coaching_role: clean.coaching_role,
          experience_years: parseInt(clean.experience_years),
          qualifications: clean.qualifications,
          specialisation: clean.specialisation,
        },
        emailRedirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/confirm`,
      },
    });

    if (signUpError) { setLoading(false); setError(signUpError.message); return; }

    if (photoFile && signUpData?.user?.id) {
      const ext = photoFile.name.split('.').pop();
      await supabase.storage.from('player-photos').upload(
        `passport_coach_${signUpData.user.id}_${Date.now()}.${ext}`,
        photoFile, { contentType: photoFile.type, upsert: true }
      );
    }

    setLoading(false);
    setSuccess(true);
  };

  const LOGO  = '/images/OFA New Logo.jpg';
  const steps = ['Personal Info', 'Coaching Profile', 'Account Security'];

  if (success) return (
    <>
      <Head><title>Coach Registration Submitted | OFA</title></Head>
      <section style={{ minHeight: '100vh', background: 'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)', display: 'flex', alignItems: 'center', padding: 24, fontFamily: "'Montserrat',sans-serif" }}>
        <div style={{ maxWidth: 480, margin: '0 auto', textAlign: 'center' }}>
          <div style={{ background: '#fff', borderRadius: 20, padding: 40, boxShadow: '0 20px 60px rgba(0,0,0,.25)' }}>
            <div style={{ fontSize: 64, marginBottom: 16 }}>🎓</div>
            <h2 style={{ color: '#10316B', fontWeight: 800, marginBottom: 8 }}>Coach Application Submitted!</h2>
            <p style={{ color: '#64748b', lineHeight: 1.7, marginBottom: 24 }}>
              Welcome to the OFA coaching team, <strong>{form.name.split(' ')[0]}</strong>!<br />
              We&apos;ve sent a confirmation email to <strong>{form.email}</strong>.<br />
              Your application will be reviewed by the Academy Director within 48 hours.
            </p>
            <Link href="/login" style={{ display: 'block', padding: '12px 0', background: 'linear-gradient(135deg,#10316B,#1e4db7)', color: '#fff', borderRadius: 10, fontWeight: 700, textDecoration: 'none', textAlign: 'center' }}>
              <i className="bi bi-box-arrow-in-right me-2"></i>Go to Login
            </Link>
          </div>
        </div>
      </section>
    </>
  );

  return (
    <>
      <Head><title>Coach Registration | Olufunke Football Academy</title></Head>
      <section style={{ minHeight: '100vh', background: 'linear-gradient(135deg,#10316B 60%,#1a5c2a 100%)', display: 'flex', alignItems: 'flex-start', padding: '32px 16px', fontFamily: "'Montserrat', Arial, sans-serif" }}>
        <div style={{ width: '100%', maxWidth: 560, margin: '0 auto' }}>

          <div style={{ textAlign: 'center', marginBottom: 24 }}>
            <img src={LOGO} alt="OFA" style={{ width: 72, height: 72, borderRadius: '50%', border: '3px solid #ffc107', objectFit: 'cover', marginBottom: 10 }} />
            <h2 style={{ color: '#fff', fontWeight: 800, margin: '0 0 4px' }}>Join OFA as a Coach</h2>
            <p style={{ color: 'rgba(255,255,255,.7)', fontSize: '.85rem', margin: 0 }}>Professional coaching application</p>
          </div>

          {/* Step indicator */}
          <div style={{ display: 'flex', gap: 4, marginBottom: 20 }}>
            {steps.map((s, i) => (
              <div key={i} style={{ flex: 1, textAlign: 'center' }}>
                <div style={{ height: 4, borderRadius: 4, background: step > i + 1 ? '#4CAF50' : step === i + 1 ? '#fbbf24' : 'rgba(255,255,255,.2)', marginBottom: 4 }}></div>
                <span style={{ fontSize: '.65rem', color: step === i + 1 ? '#fbbf24' : 'rgba(255,255,255,.5)', fontWeight: step === i + 1 ? 700 : 400 }}>{s}</span>
              </div>
            ))}
          </div>

          <div style={{ background: '#fff', borderRadius: 20, overflow: 'hidden', boxShadow: '0 20px 60px rgba(0,0,0,.25)' }}>
            <div style={{ background: '#1a5c2a', padding: '14px 24px', display: 'flex', alignItems: 'center', gap: 10 }}>
              <i className="bi bi-person-video2" style={{ color: '#fbbf24', fontSize: '1.1rem' }}></i>
              <span style={{ color: '#fff', fontWeight: 700 }}>Step {step} of 3: {steps[step - 1]}</span>
              <span style={{ marginLeft: 'auto', background: 'rgba(255,255,255,.15)', color: '#fff', borderRadius: 20, padding: '2px 10px', fontSize: '.68rem', fontWeight: 600 }}>COACH</span>
            </div>

            <div style={{ padding: '24px 28px' }}>
              {error && <div style={{ background: '#fee2e2', border: '1px solid #fca5a5', borderRadius: 10, padding: '10px 14px', color: '#b91c1c', marginBottom: 16, fontSize: '.83rem', display: 'flex', alignItems: 'center', gap: 8 }}><i className="bi bi-exclamation-circle-fill"></i>{error}</div>}

              <form onSubmit={step < 3 ? (e) => { e.preventDefault(); next(); } : submit}>

                {/* STEP 1 */}
                {step === 1 && (
                  <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 14 }}>
                    <div style={{ gridColumn: '1/-1' }}>
                      <label style={lbl}>Full Name <span style={{ color: '#ef4444' }}>*</span></label>
                      <input name="name" type="text" value={form.name} onChange={handle} placeholder="e.g. Coach Emeka Johnson" required style={inp} />
                    </div>
                    <div>
                      <label style={lbl}>Email Address <span style={{ color: '#ef4444' }}>*</span></label>
                      <input name="email" type="email" value={form.email} onChange={handle} placeholder="coach@email.com" required style={inp} />
                    </div>
                    <div>
                      <label style={lbl}>Phone Number <span style={{ color: '#ef4444' }}>*</span></label>
                      <input name="phone" type="tel" value={form.phone} onChange={handle} placeholder="09079917993" required style={inp} />
                    </div>
                    <div style={{ gridColumn: '1/-1' }}>
                      <label style={lbl}>Nationality</label>
                      <input name="nationality" type="text" value={form.nationality} onChange={handle} style={inp} />
                    </div>
                  </div>
                )}

                {/* STEP 2 */}
                {step === 2 && (
                  <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 14 }}>
                    <div style={{ gridColumn: '1/-1' }}>
                      <label style={lbl}>Coaching Role <span style={{ color: '#ef4444' }}>*</span></label>
                      <select name="coaching_role" value={form.coaching_role} onChange={handle} required style={sel}>
                        <option value="">Select your role</option>
                        {['Head Coach', 'Assistant Coach', 'Goalkeeper Coach', 'Fitness & Conditioning Coach', 'Youth Development Coach', 'Scout'].map(r => <option key={r}>{r}</option>)}
                      </select>
                    </div>
                    <div>
                      <label style={lbl}>Years of Experience <span style={{ color: '#ef4444' }}>*</span></label>
                      <input name="experience_years" type="number" value={form.experience_years} onChange={handle} placeholder="e.g. 5" min="0" max="50" required style={inp} />
                    </div>
                    <div>
                      <label style={lbl}>Specialisation</label>
                      <input name="specialisation" type="text" value={form.specialisation} onChange={handle} placeholder="e.g. U17 Tactical Development" style={inp} />
                    </div>
                    <div style={{ gridColumn: '1/-1' }}>
                      <label style={lbl}>Qualifications / Licences</label>
                      <input name="qualifications" type="text" value={form.qualifications} onChange={handle} placeholder="e.g. CAF C Licence, FIFA Coaching Certificate" style={inp} />
                    </div>
                    {/* Passport photo */}
                    <div style={{ gridColumn: '1/-1' }}>
                      <label style={lbl}>Passport Photograph <span style={{ color: '#ef4444' }}>*</span></label>
                      <div style={{ border: '2px dashed ' + (photoFile ? '#1a5c2a' : '#d1d5db'), borderRadius: 12, padding: '20px 16px', textAlign: 'center', background: photoFile ? '#f0fdf4' : '#fafafa', cursor: 'pointer', position: 'relative' }}>
                        <input type="file" accept="image/jpeg,image/jpg,image/png,image/webp" onChange={e => { if (e.target.files[0]) setPhotoFile(e.target.files[0]); }} style={{ position: 'absolute', inset: 0, opacity: 0, cursor: 'pointer' }} />
                        {photoFile ? (
                          <div style={{ display: 'flex', alignItems: 'center', gap: 12, justifyContent: 'center' }}>
                            <img src={URL.createObjectURL(photoFile)} alt="Preview" style={{ width: 60, height: 60, borderRadius: '50%', objectFit: 'cover', border: '2px solid #1a5c2a' }} />
                            <div style={{ textAlign: 'left' }}>
                              <div style={{ fontWeight: 700, fontSize: '.83rem', color: '#1a5c2a' }}>{photoFile.name}</div>
                              <div style={{ fontSize: '.73rem', color: '#64748b' }}>{(photoFile.size / 1024).toFixed(1)} KB — Click to change</div>
                            </div>
                          </div>
                        ) : (
                          <div>
                            <i className="bi bi-person-circle" style={{ fontSize: '1.8rem', color: '#9ca3af' }}></i>
                            <div style={{ fontWeight: 600, fontSize: '.83rem', color: '#64748b', marginTop: 6 }}>Upload passport photo (JPG/PNG, max 3MB)</div>
                          </div>
                        )}
                      </div>
                    </div>
                  </div>
                )}

                {/* STEP 3 */}
                {step === 3 && (
                  <div style={{ display: 'grid', gap: 14 }}>
                    <div>
                      <label style={lbl}>Password <span style={{ color: '#ef4444' }}>*</span></label>
                      <div style={{ position: 'relative' }}>
                        <input name="password" type={showPwd ? 'text' : 'password'} value={form.password} onChange={handle} placeholder="Minimum 8 characters" required style={{ ...inp, paddingRight: 40 }} />
                        <button type="button" onClick={() => setShowPwd(!showPwd)} style={{ position: 'absolute', right: 10, top: '50%', transform: 'translateY(-50%)', background: 'none', border: 'none', cursor: 'pointer', color: '#9ca3af' }}>
                          <i className={`bi bi-eye${showPwd ? '-slash' : ''}-fill`}></i>
                        </button>
                      </div>
                      <div style={{ display: 'flex', gap: 8, marginTop: 6 }}>
                        {['8+ chars', 'Uppercase', 'Number'].map((r, i) => {
                          const ok = i === 0 ? form.password.length >= 8 : i === 1 ? /[A-Z]/.test(form.password) : /\d/.test(form.password);
                          return <span key={r} style={{ fontSize: '.68rem', padding: '2px 8px', borderRadius: 20, background: ok ? '#dcfce7' : '#f1f5f9', color: ok ? '#15803d' : '#94a3b8', fontWeight: 600 }}>{ok ? '✓' : ''} {r}</span>;
                        })}
                      </div>
                    </div>
                    <div>
                      <label style={lbl}>Confirm Password <span style={{ color: '#ef4444' }}>*</span></label>
                      <input name="password_confirmation" type="password" value={form.password_confirmation} onChange={handle} placeholder="Repeat your password" required style={inp} />
                    </div>
                  </div>
                )}

                {/* Navigation */}
                <div style={{ display: 'flex', gap: 10, marginTop: 20 }}>
                  {step > 1 && (
                    <button type="button" onClick={() => { setError(''); setStep(s => s - 1); }} style={{ flex: 1, padding: '11px 0', background: '#f1f5f9', color: '#374151', border: 'none', borderRadius: 10, fontWeight: 600, cursor: 'pointer', fontSize: '.9rem' }}>
                      ← Back
                    </button>
                  )}
                  <button type="submit" disabled={loading} style={{ flex: step > 1 ? 2 : 1, padding: '11px 0', background: 'linear-gradient(135deg,#1a5c2a,#15803d)', color: '#fff', border: 'none', borderRadius: 10, fontWeight: 700, cursor: loading ? 'not-allowed' : 'pointer', fontSize: '.9rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 8 }}>
                    {loading ? <><span className="spinner-border spinner-border-sm"></span> Registering…</>
                      : step < 3 ? <>Next Step →</>
                        : <><i className="bi bi-person-video2"></i> Submit Coach Application</>}
                  </button>
                </div>
              </form>
            </div>

            <div style={{ background: '#f8fafc', padding: '14px 28px', textAlign: 'center', borderTop: '1px solid #e5eaf0' }}>
              <span style={{ color: '#64748b', fontSize: '.83rem' }}>
                Already have an account? <Link href="/login" style={{ color: '#10316B', fontWeight: 700, textDecoration: 'none' }}>Log In →</Link>
              </span>
              <div style={{ marginTop: 6 }}>
                <span style={{ color: '#64748b', fontSize: '.78rem' }}>
                  Registering as a player? <Link href="/register" style={{ color: '#10316B', fontWeight: 700, textDecoration: 'none' }}>Player Registration →</Link>
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}

const lbl = { display: 'block', fontWeight: 600, fontSize: '.8rem', marginBottom: 5, color: '#374151' };
const inp = { width: '100%', padding: '10px 12px', border: '1.5px solid #e5eaf0', borderRadius: 9, fontSize: '.88rem', boxSizing: 'border-box', outline: 'none', fontFamily: 'inherit' };
const sel = { ...inp };
