import { useState, useEffect } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';
import { checkRateLimit, sanitizeForm, validateEmail, validatePassword } from '../lib/security';

export default function Register() {
  const supabase = useSupabaseClient();
  const session  = useSession();
  const router   = useRouter();

  // step 0 = role selector; 1–4 = player registration steps
  const [roleType,    setRoleType]    = useState(null);  // 'player' | 'guardian' | 'coach'
  const [step,        setStep]        = useState(1); // 1=personal, 2=football, 3=consent&photo, 4=account
  const [loading,     setLoading]     = useState(false);
  const [error,       setError]       = useState('');
  const [success,     setSuccess]     = useState(false);
  const [showPwd,     setShowPwd]     = useState(false);
  const [consentFile, setConsentFile] = useState(null);
  const [photoFile,   setPhotoFile]   = useState(null);

  const [form, setForm] = useState({
    name:'', email:'', phone:'', nationality:'Nigerian',
    position:'', age:'', age_group:'',
    password:'', password_confirmation:'',
  });

  useEffect(() => {
    if (session) router.replace('/dashboard');
  }, [session]);

  const chooseRole = (role) => {
    if (role === 'guardian') { router.push('/guardian-register'); return; }
    if (role === 'coach')    { router.push('/coach-register');    return; }
    setRoleType('player');
  };

  const handle = e => setForm(p => ({...p, [e.target.name]: e.target.value}));

  const validateStep = () => {
    if (step === 1) {
      if (!form.name.trim())  return 'Full name is required.';
      if (!form.email.trim()) return 'Email is required.';
      if (!form.phone.trim()) return 'Phone number is required.';
    }
    if (step === 2) {
      if (!form.position)  return 'Playing position is required.';
      if (!form.age)       return 'Age is required.';
      if (!form.age_group) return 'Age group is required.';
    }
    if (step === 3) {
      if (!consentFile) return 'You must upload a signed consent form (PDF).';
      if (consentFile.type !== 'application/pdf') return 'Consent form must be a PDF file.';
      if (consentFile.size > 5 * 1024 * 1024) return 'Consent PDF must be under 5MB.';
      if (!photoFile) return 'You must upload your passport photograph.';
      const allowed = ['image/jpeg','image/jpg','image/png','image/webp'];
      if (!allowed.includes(photoFile.type)) return 'Passport photo must be JPG or PNG.';
      if (photoFile.size > 3 * 1024 * 1024) return 'Passport photo must be under 3MB.';
    }
    if (step === 4) {
      if (form.password.length < 8) return 'Password must be at least 8 characters.';
      if (form.password !== form.password_confirmation) return 'Passwords do not match.';
    }
    return null;
  };

  const next = () => {
    const err = validateStep();
    if (err) { setError(err); return; }
    setError('');
    setStep(s => s + 1);
  };

  const submit = async (e) => {
    e.preventDefault();
    const err = validateStep();
    if (err) { setError(err); return; }

    if (!checkRateLimit('register', 3, 300000)) {
      setError('Too many registration attempts. Please wait a few minutes.');
      return;
    }

    if (!validateEmail(form.email.trim())) {
      setError('Please enter a valid email address.');
      return;
    }

    const pwdCheck = validatePassword(form.password);
    if (!pwdCheck.valid) {
      setError(pwdCheck.errors[0]);
      return;
    }

    setLoading(true); setError('');

    const clean = sanitizeForm(form);

    const { data: signUpData, error: signUpError } = await supabase.auth.signUp({
      email:    clean.email.trim(),
      password: form.password,
      options: {
        data: {
          full_name:   clean.name.trim(),
          phone:       clean.phone.trim(),
          nationality: clean.nationality,
          position:    clean.position,
          age:         parseInt(clean.age),
          age_group:   clean.age_group,
        },
        emailRedirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/confirm`,
      },
    });

    if (signUpError) { setLoading(false); setError(signUpError.message); return; }

    // Upload consent PDF
    if (consentFile && signUpData?.user?.id) {
      const consentName = `consent_player_${signUpData.user.id}_${Date.now()}.pdf`;
      await supabase.storage.from('consent-forms').upload(consentName, consentFile, { contentType: 'application/pdf', upsert: true });
    }

    // Upload passport photo
    if (photoFile && signUpData?.user?.id) {
      const ext = photoFile.name.split('.').pop();
      const photoName = `passport_player_${signUpData.user.id}_${Date.now()}.${ext}`;
      await supabase.storage.from('player-photos').upload(photoName, photoFile, { contentType: photoFile.type, upsert: true });
    }

    setLoading(false);
    setSuccess(true);
  };

  const LOGO = '/images/OFA New Logo.jpg';
  const steps = ['Personal Info', 'Football Profile', 'Documents', 'Account Security'];

  if (success) return (
    <>
      <Head><title>Registration Successful | OFA</title></Head>
      <section style={{minHeight:'100vh',background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)',display:'flex',alignItems:'center',padding:24,fontFamily:"'Montserrat',sans-serif"}}>
        <div style={{maxWidth:480,margin:'0 auto',textAlign:'center'}}>
          <div style={{background:'#fff',borderRadius:20,padding:40,boxShadow:'0 20px 60px rgba(0,0,0,.25)'}}>
            <div style={{fontSize:64,marginBottom:16}}>🎉</div>
            <h2 style={{color:'#10316B',fontWeight:800,marginBottom:8}}>Registration Submitted!</h2>
            <p style={{color:'#64748b',lineHeight:1.7,marginBottom:4}}>
              <strong>Welcome to Olufunke Football Academy, {form.name.split(' ')[0]}!</strong>
            </p>
            <p style={{color:'#64748b',lineHeight:1.7,marginBottom:24}}>
              We&apos;ve sent a confirmation email to <strong>{form.email}</strong>. Please confirm your email first.
              Then your account will be reviewed by our coaching staff — you&apos;ll receive access once approved.
            </p>
            <div style={{background:'#fef3c7',borderRadius:10,padding:'12px 16px',marginBottom:24,fontSize:'.83rem',color:'#92400e'}}>
              <i className="bi bi-clock-fill me-2"></i>
              Approval usually takes 24–48 hours. Questions? Call <strong>09079917993</strong>
            </div>
            <Link href="/login" style={{display:'block',padding:'12px 0',background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',borderRadius:10,fontWeight:700,textDecoration:'none',textAlign:'center'}}>
              <i className="bi bi-box-arrow-in-right me-2"></i>Go to Login
            </Link>
          </div>
        </div>
      </section>
    </>
  );

  /* ── ROLE SELECTOR (step 0) ───────────────────────────────────────── */
  if (!roleType) return (
    <>
      <Head><title>Register | Olufunke Football Academy</title></Head>
      <section style={{ minHeight:'100vh', background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)', display:'flex', alignItems:'center', padding:'32px 16px', fontFamily:"'Montserrat',Arial,sans-serif" }}>
        <div style={{ width:'100%', maxWidth:640, margin:'0 auto' }}>
          <div style={{ textAlign:'center', marginBottom:32 }}>
            <img src={LOGO} alt="OFA" style={{ width:80, height:80, borderRadius:'50%', border:'3px solid #ffc107', objectFit:'cover', marginBottom:12 }} />
            <h2 style={{ color:'#fff', fontWeight:800, margin:'0 0 6px', fontSize:'1.6rem' }}>Join Olufunke Football Academy</h2>
            <p style={{ color:'rgba(255,255,255,.75)', fontSize:'.9rem', margin:0 }}>Select how you are registering below</p>
          </div>

          <div style={{ display:'grid', gridTemplateColumns:'repeat(auto-fit,minmax(170px,1fr))', gap:16 }}>
            {[
              {
                role: 'player', icon: 'bi-person-circle', emoji: '⚽',
                title: 'Player',
                desc: 'I am a footballer joining the academy',
                color: '#10316B', accent: '#1e4db7',
                badge: 'Ages 8–26',
              },
              {
                role: 'guardian', icon: 'bi-person-heart', emoji: '👨‍👩‍👦',
                title: 'Parent / Guardian',
                desc: "I am registering on behalf of my child",
                color: '#1a5c2a', accent: '#15803d',
                badge: 'Parent / Guardian',
              },
              {
                role: 'coach', icon: 'bi-person-video2', emoji: '🎓',
                title: 'Coach / Staff',
                desc: 'I am applying to join as a coach',
                color: '#7c3aed', accent: '#6d28d9',
                badge: 'Professional',
              },
            ].map(card => (
              <button
                key={card.role}
                onClick={() => chooseRole(card.role)}
                style={{
                  background:'#fff', border:`2px solid transparent`,
                  borderRadius:18, padding:'28px 20px', textAlign:'center',
                  cursor:'pointer', transition:'all .2s', boxShadow:'0 8px 32px rgba(0,0,0,.2)',
                  display:'flex', flexDirection:'column', alignItems:'center', gap:10,
                }}
                onMouseEnter={e => { e.currentTarget.style.border=`2px solid ${card.color}`; e.currentTarget.style.transform='translateY(-4px)'; }}
                onMouseLeave={e => { e.currentTarget.style.border='2px solid transparent'; e.currentTarget.style.transform=''; }}
              >
                <div style={{ width:64, height:64, borderRadius:'50%', background:`linear-gradient(135deg,${card.color},${card.accent})`, display:'flex', alignItems:'center', justifyContent:'center', fontSize:'1.7rem', flexShrink:0 }}>
                  {card.emoji}
                </div>
                <div>
                  <div style={{ fontWeight:800, fontSize:'1.05rem', color:card.color, marginBottom:4 }}>{card.title}</div>
                  <div style={{ fontSize:'.8rem', color:'#64748b', lineHeight:1.5, marginBottom:8 }}>{card.desc}</div>
                  <span style={{ display:'inline-block', padding:'3px 10px', borderRadius:20, background:`${card.color}15`, color:card.color, fontWeight:700, fontSize:'.7rem' }}>{card.badge}</span>
                </div>
                <div style={{ marginTop:4, color:card.color, fontWeight:700, fontSize:'.85rem' }}>
                  Register →
                </div>
              </button>
            ))}
          </div>

          <div style={{ textAlign:'center', marginTop:24 }}>
            <span style={{ color:'rgba(255,255,255,.7)', fontSize:'.83rem' }}>
              Already have an account?{' '}
              <Link href="/login" style={{ color:'#fbbf24', fontWeight:700, textDecoration:'none' }}>Log In →</Link>
            </span>
          </div>
        </div>
      </section>
    </>
  );

  /* ── PLAYER REGISTRATION FORM (steps 1–4) ────────────────────────── */
  return (
    <>
      <Head><title>Player Registration | Olufunke Football Academy</title></Head>

      <section style={{
        minHeight: '100vh',
        background: 'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)',
        display: 'flex', alignItems: 'flex-start', padding: '32px 16px',
        fontFamily: "'Montserrat', Arial, sans-serif",
      }}>
        <div style={{width:'100%',maxWidth:560,margin:'0 auto'}}>

          {/* Back to role selector */}
          <button onClick={() => setRoleType(null)} style={{ background:'transparent', border:'none', color:'rgba(255,255,255,.75)', cursor:'pointer', fontSize:'.83rem', marginBottom:16, padding:0, display:'flex', alignItems:'center', gap:6 }}>
            <i className="bi bi-arrow-left"></i> Choose a different role
          </button>

          {/* Header */}
          <div style={{textAlign:'center',marginBottom:24}}>
            <img src={LOGO} alt="OFA" style={{width:72,height:72,borderRadius:'50%',border:'3px solid #ffc107',objectFit:'cover',marginBottom:10}} />
            <h2 style={{color:'#fff',fontWeight:800,margin:'0 0 4px'}}>Player Registration</h2>
            <p style={{color:'rgba(255,255,255,.7)',fontSize:'.85rem',margin:0}}>Join Olufunke Football Academy as a player</p>
          </div>

          {/* Step indicator */}
          <div style={{display:'flex',gap:4,marginBottom:20,padding:'0 4px'}}>
            {steps.map((s,i)=>(
              <div key={i} style={{flex:1,textAlign:'center'}}>
                <div style={{height:4,borderRadius:4,background:step>i+1?'#4CAF50':step===i+1?'#fbbf24':'rgba(255,255,255,.2)',marginBottom:4,transition:'background .3s'}}></div>
                <span style={{fontSize:'.65rem',color:step===i+1?'#fbbf24':'rgba(255,255,255,.5)',fontWeight:step===i+1?700:400}}>{s}</span>
              </div>
            ))}
          </div>

          {/* Card */}
          <div style={{background:'#fff',borderRadius:20,overflow:'hidden',boxShadow:'0 20px 60px rgba(0,0,0,.25)'}}>
            <div style={{background:'#10316B',padding:'14px 24px',display:'flex',alignItems:'center',gap:10}}>
              <i className="bi bi-person-plus-fill" style={{color:'#fbbf24',fontSize:'1.1rem'}}></i>
              <span style={{color:'#fff',fontWeight:700}}>Step {step} of 4: {steps[step-1]}</span>
            </div>

            <div style={{padding:'24px 28px'}}>
              {error && <div style={{background:'#fee2e2',border:'1px solid #fca5a5',borderRadius:10,padding:'10px 14px',color:'#b91c1c',marginBottom:16,fontSize:'.83rem',display:'flex',alignItems:'center',gap:8}}><i className="bi bi-exclamation-circle-fill"></i>{error}</div>}

              <form onSubmit={step < 4 ? (e)=>{e.preventDefault();next();} : submit}>

                {/* STEP 1: Personal Info */}
                {step === 1 && (
                  <div style={{display:'grid',gridTemplateColumns:'1fr 1fr',gap:14}}>
                    <div style={{gridColumn:'1/-1'}}>
                      <label style={lbl}>Full Name <span style={{color:'#ef4444'}}>*</span></label>
                      <input name="name" type="text" value={form.name} onChange={handle} placeholder="e.g. Chukwuemeka Obi" required style={inp} />
                    </div>
                    <div>
                      <label style={lbl}>Email Address <span style={{color:'#ef4444'}}>*</span></label>
                      <input name="email" type="email" value={form.email} onChange={handle} placeholder="your@email.com" required style={inp} />
                    </div>
                    <div>
                      <label style={lbl}>Phone Number <span style={{color:'#ef4444'}}>*</span></label>
                      <input name="phone" type="tel" value={form.phone} onChange={handle} placeholder="09079917993" required style={inp} />
                    </div>
                    <div style={{gridColumn:'1/-1'}}>
                      <label style={lbl}>Nationality</label>
                      <input name="nationality" type="text" value={form.nationality} onChange={handle} placeholder="Nigerian" style={inp} />
                    </div>
                  </div>
                )}

                {/* STEP 2: Football Profile */}
                {step === 2 && (
                  <div style={{display:'grid',gridTemplateColumns:'1fr 1fr',gap:14}}>
                    <div style={{gridColumn:'1/-1'}}>
                      <label style={lbl}>Playing Position <span style={{color:'#ef4444'}}>*</span></label>
                      <select name="position" value={form.position} onChange={handle} required style={sel}>
                        <option value="">Select your position</option>
                        {['Goalkeeper','Defender','Midfielder','Forward','Winger'].map(p=><option key={p}>{p}</option>)}
                      </select>
                    </div>
                    <div>
                      <label style={lbl}>Age <span style={{color:'#ef4444'}}>*</span></label>
                      <input name="age" type="number" value={form.age} onChange={handle} placeholder="e.g. 16" min="8" max="40" required style={inp} />
                    </div>
                    <div>
                      <label style={lbl}>Age Group <span style={{color:'#ef4444'}}>*</span></label>
                      <select name="age_group" value={form.age_group} onChange={handle} required style={sel}>
                        <option value="">Select group</option>
                        {['U13','U15','U17','U19','Senior'].map(g=><option key={g}>{g}</option>)}
                      </select>
                    </div>
                    <div style={{gridColumn:'1/-1',background:'#f0fdf4',borderRadius:10,padding:12,fontSize:'.8rem',color:'#15803d',display:'flex',alignItems:'flex-start',gap:8}}>
                      <i className="bi bi-info-circle-fill mt-1"></i>
                      <span>Your profile will be reviewed by our coaching staff. You&apos;ll get full access once approved.</span>
                    </div>
                  </div>
                )}

                {/* STEP 3: Documents — Consent PDF + Passport Photo */}
                {step === 3 && (
                  <div style={{display:'grid',gap:16}}>
                    <div style={{background:'#fef3c7',borderRadius:12,padding:'12px 16px',fontSize:'.82rem',color:'#92400e',display:'flex',alignItems:'flex-start',gap:8}}>
                      <i className="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
                      <span><strong>Required Documents:</strong> You must upload a signed Consent Form (PDF) and your passport photograph to complete registration.</span>
                    </div>

                    {/* Consent form download */}
                    <a href="/consent-form" target="_blank" rel="noopener" style={{display:'flex',alignItems:'center',gap:12,padding:'14px',background:'linear-gradient(135deg,#10316B,#1e4db7)',borderRadius:12,textDecoration:'none',color:'#fff'}}>
                      <div style={{width:44,height:44,borderRadius:10,background:'rgba(255,255,255,.15)',display:'flex',alignItems:'center',justifyContent:'center',flexShrink:0}}>
                        <i className="bi bi-file-earmark-pdf-fill" style={{fontSize:'1.3rem',color:'#fbbf24'}}></i>
                      </div>
                      <div>
                        <div style={{fontWeight:700,fontSize:'.88rem'}}>Download Consent Form</div>
                        <div style={{fontSize:'.73rem',opacity:.8}}>Print → Fill & Sign → Save as PDF → Upload below</div>
                      </div>
                      <i className="bi bi-box-arrow-up-right ms-auto" style={{opacity:.7}}></i>
                    </a>

                    {/* Consent PDF upload */}
                    <div>
                      <label style={lbl}>Signed Consent Form (PDF) <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{border:'2px dashed '+(consentFile?'#4CAF50':'#d1d5db'),borderRadius:12,padding:'20px 16px',textAlign:'center',background:consentFile?'#f0fdf4':'#fafafa',cursor:'pointer',position:'relative'}}>
                        <input type="file" accept="application/pdf,.pdf" onChange={e=>{if(e.target.files[0])setConsentFile(e.target.files[0]);}} style={{position:'absolute',inset:0,opacity:0,cursor:'pointer'}} />
                        {consentFile ? (
                          <div>
                            <i className="bi bi-file-earmark-check-fill" style={{fontSize:'1.8rem',color:'#4CAF50'}}></i>
                            <div style={{fontWeight:700,fontSize:'.83rem',color:'#15803d',marginTop:6}}>{consentFile.name}</div>
                            <div style={{fontSize:'.73rem',color:'#64748b'}}>{(consentFile.size/1024).toFixed(1)} KB — Click to change</div>
                          </div>
                        ) : (
                          <div>
                            <i className="bi bi-cloud-arrow-up-fill" style={{fontSize:'1.8rem',color:'#9ca3af'}}></i>
                            <div style={{fontWeight:600,fontSize:'.83rem',color:'#64748b',marginTop:6}}>Click to upload PDF (max 5MB)</div>
                          </div>
                        )}
                      </div>
                    </div>

                    {/* Passport photo upload */}
                    <div>
                      <label style={lbl}>Passport Photograph <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{border:'2px dashed '+(photoFile?'#10316B':'#d1d5db'),borderRadius:12,padding:'20px 16px',textAlign:'center',background:photoFile?'#eff6ff':'#fafafa',cursor:'pointer',position:'relative'}}>
                        <input type="file" accept="image/jpeg,image/jpg,image/png,image/webp" onChange={e=>{if(e.target.files[0])setPhotoFile(e.target.files[0]);}} style={{position:'absolute',inset:0,opacity:0,cursor:'pointer'}} />
                        {photoFile ? (
                          <div style={{display:'flex',alignItems:'center',gap:12,justifyContent:'center'}}>
                            <img src={URL.createObjectURL(photoFile)} alt="Preview" style={{width:60,height:60,borderRadius:'50%',objectFit:'cover',border:'2px solid #10316B'}} />
                            <div style={{textAlign:'left'}}>
                              <div style={{fontWeight:700,fontSize:'.83rem',color:'#10316B'}}>{photoFile.name}</div>
                              <div style={{fontSize:'.73rem',color:'#64748b'}}>{(photoFile.size/1024).toFixed(1)} KB — Click to change</div>
                            </div>
                          </div>
                        ) : (
                          <div>
                            <i className="bi bi-person-circle" style={{fontSize:'1.8rem',color:'#9ca3af'}}></i>
                            <div style={{fontWeight:600,fontSize:'.83rem',color:'#64748b',marginTop:6}}>Click to upload passport photo (JPG/PNG, max 3MB)</div>
                          </div>
                        )}
                      </div>
                    </div>
                  </div>
                )}

                {/* STEP 4: Account Security */}
                {step === 4 && (
                  <div style={{display:'grid',gap:14}}>
                    <div>
                      <label style={lbl}>Password <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{position:'relative'}}>
                        <input name="password" type={showPwd?'text':'password'} value={form.password} onChange={handle} placeholder="Minimum 8 characters" required style={{...inp,paddingRight:40}} />
                        <button type="button" onClick={()=>setShowPwd(!showPwd)} style={{position:'absolute',right:10,top:'50%',transform:'translateY(-50%)',background:'none',border:'none',cursor:'pointer',color:'#9ca3af'}}>
                          <i className={`bi bi-eye${showPwd?'-slash':''}-fill`}></i>
                        </button>
                      </div>
                      <div style={{display:'flex',gap:8,marginTop:6}}>
                        {['8+ chars','Uppercase','Number'].map((r,i)=>{
                          const ok = i===0?form.password.length>=8 : i===1?/[A-Z]/.test(form.password) : /\d/.test(form.password);
                          return <span key={r} style={{fontSize:'.68rem',padding:'2px 8px',borderRadius:20,background:ok?'#dcfce7':'#f1f5f9',color:ok?'#15803d':'#94a3b8',fontWeight:600}}>{ok?'✓':''} {r}</span>;
                        })}
                      </div>
                    </div>
                    <div>
                      <label style={lbl}>Confirm Password <span style={{color:'#ef4444'}}>*</span></label>
                      <input name="password_confirmation" type="password" value={form.password_confirmation} onChange={handle} placeholder="Repeat your password" required style={inp} />
                      {form.password_confirmation && (
                        <div style={{marginTop:4,fontSize:'.75rem',color:form.password===form.password_confirmation?'#15803d':'#ef4444',fontWeight:600}}>
                          {form.password===form.password_confirmation?'✓ Passwords match':'✗ Passwords do not match'}
                        </div>
                      )}
                    </div>
                    <div style={{background:'#eff6ff',borderRadius:10,padding:12,fontSize:'.8rem',color:'#1d4ed8'}}>
                      <i className="bi bi-shield-check me-2"></i>
                      Your data is encrypted and protected. We never share your information.
                    </div>
                  </div>
                )}

                {/* Navigation buttons */}
                <div style={{display:'flex',gap:10,marginTop:20}}>
                  {step > 1 && (
                    <button type="button" onClick={()=>{setError('');setStep(s=>s-1);}}
                      style={{flex:1,padding:'11px 0',background:'#f1f5f9',color:'#374151',border:'none',borderRadius:10,fontWeight:600,cursor:'pointer',fontSize:'.9rem'}}>
                      ← Back
                    </button>
                  )}
                  <button type="submit" disabled={loading}
                    style={{flex:step>1?2:1,padding:'11px 0',background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',border:'none',borderRadius:10,fontWeight:700,cursor:loading?'not-allowed':'pointer',fontSize:'.9rem',display:'flex',alignItems:'center',justifyContent:'center',gap:8}}>
                    {loading ? <><span className="spinner-border spinner-border-sm"></span> Registering…</>
                    : step < 4 ? <>Next Step →</>
                    : <><i className="bi bi-person-check-fill"></i> Register as OFA Player</>}
                  </button>
                </div>
              </form>
            </div>

            <div style={{background:'#f8fafc',padding:'14px 28px',textAlign:'center',borderTop:'1px solid #e5eaf0'}}>
              <span style={{color:'#64748b',fontSize:'.83rem'}}>
                Already have an account? <Link href="/login" style={{color:'#10316B',fontWeight:700,textDecoration:'none'}}>Log In Here →</Link>
              </span>
              <div style={{marginTop:8,display:'flex',gap:16,justifyContent:'center',flexWrap:'wrap'}}>
                <span style={{color:'#64748b',fontSize:'.78rem'}}>
                  Registering your child? <Link href="/guardian-register" style={{color:'#15803d',fontWeight:700,textDecoration:'none'}}>Guardian Registration →</Link>
                </span>
                <span style={{color:'#64748b',fontSize:'.78rem'}}>
                  Joining as a coach? <Link href="/coach-register" style={{color:'#7c3aed',fontWeight:700,textDecoration:'none'}}>Coach Registration →</Link>
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}

// Shared style objects
const lbl = { display:'block', fontWeight:600, fontSize:'.8rem', marginBottom:5, color:'#374151' };
const inp = { width:'100%', padding:'10px 12px', border:'1.5px solid #e5eaf0', borderRadius:9, fontSize:'.88rem', boxSizing:'border-box', outline:'none', fontFamily:'inherit' };
const sel = { ...inp };
