import { useState, useEffect } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';

export default function Register() {
  const supabase = useSupabaseClient();
  const session  = useSession();
  const router   = useRouter();

  const [step,    setStep]    = useState(1); // 1=personal, 2=football, 3=account
  const [loading, setLoading] = useState(false);
  const [error,   setError]   = useState('');
  const [success, setSuccess] = useState(false);
  const [showPwd, setShowPwd] = useState(false);

  const [form, setForm] = useState({
    name:'', email:'', phone:'', nationality:'Nigerian',
    position:'', age:'', age_group:'',
    password:'', password_confirmation:'',
  });

  useEffect(() => {
    if (session) router.replace('/dashboard');
  }, [session]);

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
    setLoading(true); setError('');

    const { error: signUpError } = await supabase.auth.signUp({
      email:    form.email.trim(),
      password: form.password,
      options: {
        data: {
          full_name:   form.name.trim(),
          phone:       form.phone.trim(),
          nationality: form.nationality,
          position:    form.position,
          age:         parseInt(form.age),
          age_group:   form.age_group,
        },
        emailRedirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/confirm`,
      },
    });

    setLoading(false);
    if (signUpError) { setError(signUpError.message); return; }
    setSuccess(true);
  };

  const LOGO = '/images/OFA New Logo.jpg';
  const steps = ['Personal Info', 'Football Profile', 'Account Security'];

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

  return (
    <>
      <Head><title>Register | Olufunke Football Academy</title></Head>

      <section style={{
        minHeight: '100vh',
        background: 'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)',
        display: 'flex', alignItems: 'flex-start', padding: '32px 16px',
        fontFamily: "'Montserrat', Arial, sans-serif",
      }}>
        <div style={{width:'100%',maxWidth:560,margin:'0 auto'}}>

          {/* Header */}
          <div style={{textAlign:'center',marginBottom:24}}>
            <img src={LOGO} alt="OFA" style={{width:72,height:72,borderRadius:'50%',border:'3px solid #ffc107',objectFit:'cover',marginBottom:10}} />
            <h2 style={{color:'#fff',fontWeight:800,margin:'0 0 4px'}}>Join Olufunke Football Academy</h2>
            <p style={{color:'rgba(255,255,255,.7)',fontSize:'.85rem',margin:0}}>Register as a player — free to join</p>
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
              <span style={{color:'#fff',fontWeight:700}}>Step {step} of 3: {steps[step-1]}</span>
            </div>

            <div style={{padding:'24px 28px'}}>
              {error && <div style={{background:'#fee2e2',border:'1px solid #fca5a5',borderRadius:10,padding:'10px 14px',color:'#b91c1c',marginBottom:16,fontSize:'.83rem',display:'flex',alignItems:'center',gap:8}}><i className="bi bi-exclamation-circle-fill"></i>{error}</div>}

              <form onSubmit={step < 3 ? (e)=>{e.preventDefault();next();} : submit}>

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

                {/* STEP 3: Account Security */}
                {step === 3 && (
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
                    : step < 3 ? <>Next Step →</>
                    : <><i className="bi bi-person-check-fill"></i> Register as OFA Player</>}
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
        </div>
      </section>
    </>
  );
}

// Shared style objects
const lbl = { display:'block', fontWeight:600, fontSize:'.8rem', marginBottom:5, color:'#374151' };
const inp = { width:'100%', padding:'10px 12px', border:'1.5px solid #e5eaf0', borderRadius:9, fontSize:'.88rem', boxSizing:'border-box', outline:'none', fontFamily:'inherit' };
const sel = { ...inp };
