import { useState, useEffect } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';
import { checkRateLimit, sanitizeForm, validateEmail, validatePassword } from '../lib/security';

export default function GuardianRegister() {
  const supabase = useSupabaseClient();
  const session  = useSession();
  const router   = useRouter();

  const [step,    setStep]    = useState(1); // 1=guardian info, 2=player info, 3=consent, 4=account
  const [loading, setLoading] = useState(false);
  const [error,   setError]   = useState('');
  const [success, setSuccess] = useState(false);
  const [showPwd,     setShowPwd]     = useState(false);
  const [consentFile, setConsentFile] = useState(null);
  const [photoFile,   setPhotoFile]   = useState(null);

  const [form, setForm] = useState({
    guardian_name: '', guardian_email: '', guardian_phone: '',
    relationship: '',
    player_name: '', player_age: '', player_position: '',
    player_age_group: '', player_nationality: 'Nigerian',
    password: '', password_confirmation: '',
  });

  useEffect(() => {
    if (session) router.replace('/dashboard');
  }, [session]);

  const handle = e => setForm(p => ({...p, [e.target.name]: e.target.value}));

  const validateStep = () => {
    if (step === 1) {
      if (!form.guardian_name.trim())  return 'Guardian full name is required.';
      if (!form.guardian_email.trim()) return 'Guardian email is required.';
      if (!form.guardian_phone.trim()) return 'Guardian phone number is required.';
      if (!form.relationship)          return 'Relationship to player is required.';
    }
    if (step === 2) {
      if (!form.player_name.trim()) return "Player's full name is required.";
      if (!form.player_age)         return "Player's age is required.";
      if (!form.player_position)    return 'Playing position is required.';
      if (!form.player_age_group)   return 'Age group is required.';
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

    if (!checkRateLimit('guardian-register', 3, 300000)) {
      setError('Too many registration attempts. Please wait a few minutes.');
      return;
    }

    if (!validateEmail(form.guardian_email.trim())) {
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
      email:    clean.guardian_email.trim(),
      password: form.password,
      options: {
        data: {
          full_name:    clean.guardian_name.trim(),
          phone:        clean.guardian_phone.trim(),
          role:         'guardian',
          relationship: clean.relationship,
          player_name:       clean.player_name.trim(),
          player_age:        parseInt(clean.player_age),
          player_position:   clean.player_position,
          player_age_group:  clean.player_age_group,
          player_nationality: clean.player_nationality,
        },
        emailRedirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/confirm`,
      },
    });

    if (signUpError) { setLoading(false); setError(signUpError.message); return; }

    // Upload consent PDF to Supabase Storage
    if (consentFile && signUpData?.user?.id) {
      const fileName = `consent_guardian_${signUpData.user.id}_${Date.now()}.pdf`;
      const { error: uploadErr } = await supabase.storage
        .from('consent-forms')
        .upload(fileName, consentFile, { contentType: 'application/pdf', upsert: true });
      if (uploadErr) console.warn('Consent upload warning:', uploadErr.message);
    }

    // Upload guardian passport photo to Supabase Storage
    if (photoFile && signUpData?.user?.id) {
      const ext = photoFile.name.split('.').pop();
      const photoName = `passport_guardian_${signUpData.user.id}_${Date.now()}.${ext}`;
      const { error: photoErr } = await supabase.storage
        .from('player-photos')
        .upload(photoName, photoFile, { contentType: photoFile.type, upsert: true });
      if (photoErr) console.warn('Photo upload warning:', photoErr.message);
    }

    setLoading(false);
    setSuccess(true);
  };

  const LOGO = '/images/OFA New Logo.jpg';
  const steps = ['Guardian Info', 'Player Details', 'Consent Form', 'Account Security'];

  /* ── Success screen ── */
  if (success) return (
    <>
      <Head><title>Registration Successful | OFA Guardian</title></Head>
      <section style={{minHeight:'100vh',background:'linear-gradient(135deg,#10316B 40%,#1a5c2a 100%)',display:'flex',alignItems:'center',padding:24,fontFamily:"'Montserrat',sans-serif"}}>
        <div style={{maxWidth:520,margin:'0 auto',textAlign:'center'}}>
          <div style={{background:'#fff',borderRadius:24,padding:44,boxShadow:'0 24px 64px rgba(0,0,0,.3)'}}>
            <div style={{width:80,height:80,borderRadius:'50%',background:'linear-gradient(135deg,#4CAF50,#15803d)',display:'inline-flex',alignItems:'center',justifyContent:'center',marginBottom:20}}>
              <span style={{fontSize:40,color:'#fff'}}>✓</span>
            </div>
            <h2 style={{color:'#10316B',fontWeight:800,marginBottom:8}}>Guardian Registration Submitted!</h2>
            <p style={{color:'#64748b',lineHeight:1.7,marginBottom:4}}>
              <strong>Thank you, {form.guardian_name.split(' ')[0]}!</strong>
            </p>
            <p style={{color:'#64748b',lineHeight:1.7,marginBottom:8}}>
              You&apos;ve successfully registered <strong>{form.player_name}</strong> for Olufunke Football Academy.
            </p>
            <p style={{color:'#64748b',lineHeight:1.7,marginBottom:24,fontSize:'.88rem'}}>
              We&apos;ve sent a confirmation email to <strong>{form.guardian_email}</strong>.
              Please confirm your email first. Your child&apos;s registration will then be reviewed by our coaching staff.
            </p>
            <div style={{background:'#fef3c7',borderRadius:12,padding:'14px 18px',marginBottom:24,fontSize:'.83rem',color:'#92400e',textAlign:'left'}}>
              <i className="bi bi-clock-fill me-2"></i>
              <strong>What happens next?</strong>
              <ul style={{margin:'8px 0 0',paddingLeft:20,lineHeight:1.8}}>
                <li>Confirm your email address</li>
                <li>Coaching staff will review the registration (24–48 hours)</li>
                <li>You&apos;ll receive approval notification</li>
                <li>Log in to view your child&apos;s progress</li>
              </ul>
              Questions? Call <strong>09079917993</strong>
            </div>
            <Link href="/login" style={{display:'block',padding:'13px 0',background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',borderRadius:12,fontWeight:700,textDecoration:'none',textAlign:'center',fontSize:'.95rem'}}>
              <i className="bi bi-box-arrow-in-right me-2"></i>Go to Login
            </Link>
          </div>
        </div>
      </section>
    </>
  );

  /* ── Main form ── */
  return (
    <>
      <Head>
        <title>Guardian Registration | Olufunke Football Academy</title>
        <meta name="description" content="Register your child at Olufunke Football Academy. Guardians can enrol players through our secure online registration portal." />
      </Head>

      <section style={{
        minHeight: '100vh',
        background: 'linear-gradient(135deg,#10316B 40%,#1a5c2a 100%)',
        display: 'flex', alignItems: 'flex-start', padding: '32px 16px',
        fontFamily: "'Montserrat', Arial, sans-serif",
        position: 'relative', overflow: 'hidden',
      }}>
        {/* Background decoration */}
        <div style={{position:'absolute',top:-80,right:-80,width:350,height:350,borderRadius:'50%',background:'rgba(255,193,7,.05)'}}></div>
        <div style={{position:'absolute',bottom:-100,left:-100,width:400,height:400,borderRadius:'50%',background:'rgba(76,175,80,.05)'}}></div>

        <div style={{width:'100%',maxWidth:580,margin:'0 auto',position:'relative',zIndex:1}}>

          {/* Header */}
          <div style={{textAlign:'center',marginBottom:24}}>
            <img src={LOGO} alt="OFA" style={{width:76,height:76,borderRadius:'50%',border:'4px solid #ffc107',objectFit:'cover',marginBottom:12,boxShadow:'0 8px 32px rgba(0,0,0,.3)'}} />
            <h2 style={{color:'#fff',fontWeight:800,margin:'0 0 4px',fontSize:'1.4rem'}}>Guardian Registration</h2>
            <p style={{color:'rgba(255,255,255,.7)',fontSize:'.85rem',margin:'0 0 4px'}}>Register your child at Olufunke Football Academy</p>
            <span style={{background:'rgba(76,175,80,.25)',color:'#86efac',borderRadius:20,padding:'4px 14px',fontSize:'.72rem',fontWeight:700}}>
              <i className="bi bi-shield-check me-1"></i>GUARDIAN PORTAL
            </span>
          </div>

          {/* Step indicator */}
          <div style={{display:'flex',gap:4,marginBottom:20,padding:'0 4px'}}>
            {steps.map((s,i)=>(
              <div key={i} style={{flex:1,textAlign:'center'}}>
                <div style={{height:5,borderRadius:4,background:step>i+1?'#4CAF50':step===i+1?'#fbbf24':'rgba(255,255,255,.15)',marginBottom:4,transition:'all .4s ease'}}></div>
                <span style={{fontSize:'.65rem',color:step===i+1?'#fbbf24':'rgba(255,255,255,.5)',fontWeight:step===i+1?700:400,transition:'color .3s'}}>{s}</span>
              </div>
            ))}
          </div>

          {/* Card */}
          <div style={{background:'#fff',borderRadius:24,overflow:'hidden',boxShadow:'0 24px 64px rgba(0,0,0,.3)'}}>
            <div style={{background:'linear-gradient(135deg,#10316B,#1e4db7)',padding:'16px 24px',display:'flex',alignItems:'center',justifyContent:'space-between'}}>
              <div style={{display:'flex',alignItems:'center',gap:10}}>
                <i className="bi bi-people-fill" style={{color:'#fbbf24',fontSize:'1.1rem'}}></i>
                <span style={{color:'#fff',fontWeight:700,fontSize:'.92rem'}}>Step {step} of 4: {steps[step-1]}</span>
              </div>
              <span style={{background:'rgba(255,255,255,.15)',color:'#fff',borderRadius:20,padding:'3px 10px',fontSize:'.68rem',fontWeight:600}}>
                GUARDIAN
              </span>
            </div>

            <div style={{padding:'24px 28px'}}>
              {error && <div style={{background:'#fee2e2',border:'1px solid #fca5a5',borderRadius:12,padding:'10px 14px',color:'#b91c1c',marginBottom:16,fontSize:'.83rem',display:'flex',alignItems:'center',gap:8}}><i className="bi bi-exclamation-circle-fill"></i>{error}</div>}

              <form onSubmit={step < 4 ? (e)=>{e.preventDefault();next();} : submit}>

                {/* STEP 1: Guardian Info */}
                {step === 1 && (
                  <div style={{display:'grid',gridTemplateColumns:'1fr 1fr',gap:14}}>
                    <div style={{gridColumn:'1/-1'}}>
                      <label style={lbl}>Guardian Full Name <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{position:'relative'}}>
                        <i className="bi bi-person-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                        <input name="guardian_name" type="text" value={form.guardian_name} onChange={handle} placeholder="e.g. Mrs. Adebayo Funke" required style={{...inp,paddingLeft:36}} />
                      </div>
                    </div>
                    <div>
                      <label style={lbl}>Email Address <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{position:'relative'}}>
                        <i className="bi bi-envelope-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                        <input name="guardian_email" type="email" value={form.guardian_email} onChange={handle} placeholder="guardian@email.com" required style={{...inp,paddingLeft:36}} />
                      </div>
                    </div>
                    <div>
                      <label style={lbl}>Phone Number <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{position:'relative'}}>
                        <i className="bi bi-telephone-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                        <input name="guardian_phone" type="tel" value={form.guardian_phone} onChange={handle} placeholder="09079917993" required style={{...inp,paddingLeft:36}} />
                      </div>
                    </div>
                    <div style={{gridColumn:'1/-1'}}>
                      <label style={lbl}>Relationship to Player <span style={{color:'#ef4444'}}>*</span></label>
                      <select name="relationship" value={form.relationship} onChange={handle} required style={sel}>
                        <option value="">Select relationship</option>
                        {['Parent (Father)','Parent (Mother)','Legal Guardian','Uncle/Aunt','Older Sibling','Other'].map(r=><option key={r}>{r}</option>)}
                      </select>
                    </div>
                    <div style={{gridColumn:'1/-1',background:'#eff6ff',borderRadius:12,padding:'12px 16px',fontSize:'.8rem',color:'#1d4ed8',display:'flex',alignItems:'flex-start',gap:8}}>
                      <i className="bi bi-info-circle-fill mt-1 flex-shrink-0"></i>
                      <span>As a guardian, you&apos;ll be able to monitor your child&apos;s training progress, view schedules, and access educational resources.</span>
                    </div>
                  </div>
                )}

                {/* STEP 2: Player Details */}
                {step === 2 && (
                  <div style={{display:'grid',gridTemplateColumns:'1fr 1fr',gap:14}}>
                    <div style={{gridColumn:'1/-1'}}>
                      <label style={lbl}>Player&apos;s Full Name <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{position:'relative'}}>
                        <i className="bi bi-person-badge-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                        <input name="player_name" type="text" value={form.player_name} onChange={handle} placeholder="e.g. Adebayo Tunde" required style={{...inp,paddingLeft:36}} />
                      </div>
                    </div>
                    <div>
                      <label style={lbl}>Player&apos;s Age <span style={{color:'#ef4444'}}>*</span></label>
                      <input name="player_age" type="number" value={form.player_age} onChange={handle} placeholder="e.g. 14" min="5" max="25" required style={inp} />
                    </div>
                    <div>
                      <label style={lbl}>Playing Position <span style={{color:'#ef4444'}}>*</span></label>
                      <select name="player_position" value={form.player_position} onChange={handle} required style={sel}>
                        <option value="">Select position</option>
                        {['Goalkeeper','Defender','Midfielder','Forward','Winger'].map(p=><option key={p}>{p}</option>)}
                      </select>
                    </div>
                    <div>
                      <label style={lbl}>Age Group <span style={{color:'#ef4444'}}>*</span></label>
                      <select name="player_age_group" value={form.player_age_group} onChange={handle} required style={sel}>
                        <option value="">Select group</option>
                        {['U13','U15','U17','U19','Senior'].map(g=><option key={g}>{g}</option>)}
                      </select>
                    </div>
                    <div>
                      <label style={lbl}>Nationality</label>
                      <input name="player_nationality" type="text" value={form.player_nationality} onChange={handle} placeholder="Nigerian" style={inp} />
                    </div>
                    <div style={{gridColumn:'1/-1',background:'#f0fdf4',borderRadius:12,padding:'12px 16px',fontSize:'.8rem',color:'#15803d',display:'flex',alignItems:'flex-start',gap:8}}>
                      <i className="bi bi-shield-check mt-1 flex-shrink-0"></i>
                      <span>Your child&apos;s profile will be reviewed by our coaching staff. You&apos;ll receive notification once they&apos;re approved to join training sessions.</span>
                    </div>
                  </div>
                )}

                {/* STEP 3: Consent Form Upload */}
                {step === 3 && (
                  <div style={{display:'grid',gap:14}}>
                    <div style={{background:'#fef3c7',borderRadius:12,padding:'14px 16px',fontSize:'.82rem',color:'#92400e',display:'flex',alignItems:'flex-start',gap:8}}>
                      <i className="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
                      <span><strong>Required:</strong> You must download, complete, sign, and upload the official Guardian Consent Form as a PDF. Registration cannot proceed without this document.</span>
                    </div>

                    <a href="/consent-form" target="_blank" rel="noopener" style={{display:'flex',alignItems:'center',gap:12,padding:'16px',background:'linear-gradient(135deg,#10316B,#1e4db7)',borderRadius:14,textDecoration:'none',color:'#fff',transition:'transform .2s'}}>
                      <div style={{width:48,height:48,borderRadius:12,background:'rgba(255,255,255,.15)',display:'flex',alignItems:'center',justifyContent:'center',flexShrink:0}}>
                        <i className="bi bi-file-earmark-pdf-fill" style={{fontSize:'1.4rem',color:'#fbbf24'}}></i>
                      </div>
                      <div>
                        <div style={{fontWeight:700,fontSize:'.9rem'}}>Download Consent Form</div>
                        <div style={{fontSize:'.75rem',opacity:.8}}>Open form → Print/Save as PDF → Fill & Sign → Upload below</div>
                      </div>
                      <i className="bi bi-box-arrow-up-right ms-auto" style={{fontSize:'1rem',opacity:.7}}></i>
                    </a>

                    <div>
                      <label style={lbl}>Upload Signed Consent Form (PDF) <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{border:'2px dashed '+(consentFile?'#4CAF50':'#d1d5db'),borderRadius:14,padding:'24px 16px',textAlign:'center',background:consentFile?'#f0fdf4':'#fafafa',transition:'all .3s',cursor:'pointer',position:'relative'}}>
                        <input type="file" accept="application/pdf,.pdf" onChange={(e)=>{if(e.target.files[0])setConsentFile(e.target.files[0]);}} style={{position:'absolute',inset:0,opacity:0,cursor:'pointer'}} />
                        {consentFile ? (
                          <div>
                            <i className="bi bi-file-earmark-check-fill" style={{fontSize:'2rem',color:'#4CAF50'}}></i>
                            <div style={{fontWeight:700,fontSize:'.85rem',color:'#15803d',marginTop:6}}>{consentFile.name}</div>
                            <div style={{fontSize:'.75rem',color:'#64748b',marginTop:2}}>{(consentFile.size/1024).toFixed(1)} KB — Click to change</div>
                          </div>
                        ) : (
                          <div>
                            <i className="bi bi-cloud-arrow-up-fill" style={{fontSize:'2rem',color:'#9ca3af'}}></i>
                            <div style={{fontWeight:600,fontSize:'.85rem',color:'#64748b',marginTop:6}}>Click or drag to upload PDF</div>
                            <div style={{fontSize:'.75rem',color:'#94a3b8',marginTop:2}}>Maximum file size: 5MB</div>
                          </div>
                        )}
                      </div>
                    </div>

                    {/* Guardian passport photo upload */}
                    <div>
                      <label style={lbl}>Guardian Passport Photograph <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{border:'2px dashed '+(photoFile?'#10316B':'#d1d5db'),borderRadius:14,padding:'22px 16px',textAlign:'center',background:photoFile?'#eff6ff':'#fafafa',transition:'all .3s',cursor:'pointer',position:'relative'}}>
                        <input type="file" accept="image/jpeg,image/jpg,image/png,image/webp" onChange={e=>{if(e.target.files[0])setPhotoFile(e.target.files[0]);}} style={{position:'absolute',inset:0,opacity:0,cursor:'pointer'}} />
                        {photoFile ? (
                          <div style={{display:'flex',alignItems:'center',gap:12,justifyContent:'center'}}>
                            <img src={URL.createObjectURL(photoFile)} alt="Preview" style={{width:64,height:64,borderRadius:'50%',objectFit:'cover',border:'3px solid #10316B'}} />
                            <div style={{textAlign:'left'}}>
                              <div style={{fontWeight:700,fontSize:'.83rem',color:'#10316B'}}>{photoFile.name}</div>
                              <div style={{fontSize:'.73rem',color:'#64748b'}}>{(photoFile.size/1024).toFixed(1)} KB — Click to change</div>
                            </div>
                          </div>
                        ) : (
                          <div>
                            <i className="bi bi-person-circle" style={{fontSize:'2rem',color:'#9ca3af'}}></i>
                            <div style={{fontWeight:600,fontSize:'.83rem',color:'#64748b',marginTop:6}}>Upload your passport photograph (JPG/PNG, max 3MB)</div>
                          </div>
                        )}
                      </div>
                    </div>

                    <div style={{background:'#eff6ff',borderRadius:12,padding:'12px 16px',fontSize:'.8rem',color:'#1d4ed8'}}>
                      <i className="bi bi-info-circle-fill me-2"></i>
                      The consent form covers: participation consent, medical authorization, photography permission, code of conduct, data protection, and liability acknowledgement.
                    </div>
                  </div>
                )}

                {/* STEP 4: Account Security */}
                {step === 4 && (
                  <div style={{display:'grid',gap:14}}>
                    <div style={{background:'#f0fdf4',borderRadius:12,padding:'14px 16px',display:'flex',gap:12,alignItems:'center'}}>
                      <div style={{width:44,height:44,borderRadius:12,background:'linear-gradient(135deg,#4CAF50,#15803d)',display:'flex',alignItems:'center',justifyContent:'center',flexShrink:0}}>
                        <i className="bi bi-people-fill" style={{color:'#fff',fontSize:'1.1rem'}}></i>
                      </div>
                      <div>
                        <div style={{fontWeight:700,fontSize:'.82rem',color:'#15803d'}}>Registering as Guardian</div>
                        <div style={{fontSize:'.75rem',color:'#64748b'}}>
                          {form.guardian_name} → {form.player_name} ({form.player_position}, {form.player_age_group})
                        </div>
                      </div>
                    </div>
                    <div>
                      <label style={lbl}>Password <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{position:'relative'}}>
                        <i className="bi bi-lock-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                        <input name="password" type={showPwd?'text':'password'} value={form.password} onChange={handle} placeholder="Minimum 8 characters" required style={{...inp,paddingLeft:36,paddingRight:40}} />
                        <button type="button" onClick={()=>setShowPwd(!showPwd)} style={{position:'absolute',right:10,top:'50%',transform:'translateY(-50%)',background:'none',border:'none',cursor:'pointer',color:'#9ca3af'}}>
                          <i className={`bi bi-eye${showPwd?'-slash':''}-fill`}></i>
                        </button>
                      </div>
                      <div style={{display:'flex',gap:8,marginTop:6,flexWrap:'wrap'}}>
                        {['8+ chars','Uppercase','Number'].map((r,i)=>{
                          const ok = i===0?form.password.length>=8 : i===1?/[A-Z]/.test(form.password) : /\d/.test(form.password);
                          return <span key={r} style={{fontSize:'.68rem',padding:'2px 8px',borderRadius:20,background:ok?'#dcfce7':'#f1f5f9',color:ok?'#15803d':'#94a3b8',fontWeight:600}}>{ok?'✓':''} {r}</span>;
                        })}
                      </div>
                    </div>
                    <div>
                      <label style={lbl}>Confirm Password <span style={{color:'#ef4444'}}>*</span></label>
                      <div style={{position:'relative'}}>
                        <i className="bi bi-lock-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                        <input name="password_confirmation" type="password" value={form.password_confirmation} onChange={handle} placeholder="Repeat your password" required style={{...inp,paddingLeft:36}} />
                      </div>
                      {form.password_confirmation && (
                        <div style={{marginTop:4,fontSize:'.75rem',color:form.password===form.password_confirmation?'#15803d':'#ef4444',fontWeight:600}}>
                          {form.password===form.password_confirmation?'✓ Passwords match':'✗ Passwords do not match'}
                        </div>
                      )}
                    </div>
                    <div style={{background:'#eff6ff',borderRadius:12,padding:'12px 16px',fontSize:'.8rem',color:'#1d4ed8'}}>
                      <i className="bi bi-shield-check me-2"></i>
                      Your data is encrypted and protected. We never share your information.
                    </div>
                  </div>
                )}

                {/* Navigation buttons */}
                <div style={{display:'flex',gap:10,marginTop:22}}>
                  {step > 1 && (
                    <button type="button" onClick={()=>{setError('');setStep(s=>s-1);}}
                      style={{flex:1,padding:'12px 0',background:'#f1f5f9',color:'#374151',border:'none',borderRadius:12,fontWeight:600,cursor:'pointer',fontSize:'.9rem',transition:'all .2s'}}>
                      ← Back
                    </button>
                  )}
                  <button type="submit" disabled={loading}
                    style={{flex:step>1?2:1,padding:'12px 0',background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',border:'none',borderRadius:12,fontWeight:700,cursor:loading?'not-allowed':'pointer',fontSize:'.9rem',display:'flex',alignItems:'center',justifyContent:'center',gap:8,boxShadow:'0 4px 16px rgba(16,49,107,.3)',transition:'all .2s'}}>
                    {loading ? <><span className="spinner-border spinner-border-sm"></span> Registering…</>
                    : step < 4 ? <>Next Step →</>
                    : <><i className="bi bi-people-fill"></i> Register as Guardian</>}
                  </button>
                </div>
              </form>
            </div>

            <div style={{background:'#f8fafc',padding:'14px 28px',textAlign:'center',borderTop:'1px solid #e5eaf0'}}>
              <span style={{color:'#64748b',fontSize:'.83rem'}}>
                Already have an account? <Link href="/login" style={{color:'#10316B',fontWeight:700,textDecoration:'none'}}>Log In Here →</Link>
              </span>
            </div>
          </div>

          {/* Bottom links */}
          <div style={{marginTop:16,textAlign:'center'}}>
            <p style={{color:'rgba(255,255,255,.6)',fontSize:'.78rem',margin:0}}>
              <i className="bi bi-person-plus me-1"></i>
              Are you a player? <Link href="/register" style={{color:'#fbbf24',fontWeight:700,textDecoration:'none'}}>Register as Player →</Link>
            </p>
          </div>
        </div>
      </section>
    </>
  );
}

// Shared style objects
const lbl = { display:'block', fontWeight:600, fontSize:'.8rem', marginBottom:5, color:'#374151' };
const inp = { width:'100%', padding:'10px 12px', border:'1.5px solid #e5eaf0', borderRadius:10, fontSize:'.88rem', boxSizing:'border-box', outline:'none', fontFamily:'inherit', transition:'border-color .2s' };
const sel = { ...inp, appearance:'auto' };
