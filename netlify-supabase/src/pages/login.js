import { useState, useEffect } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';

export default function Login() {
  const supabase = useSupabaseClient();
  const session  = useSession();
  const router   = useRouter();

  const [email,    setEmail]    = useState('');
  const [password, setPassword] = useState('');
  const [showPwd,  setShowPwd]  = useState(false);
  const [loading,  setLoading]  = useState(false);
  const [message,  setMessage]  = useState('');
  const [error,    setError]    = useState('');
  const [tab,      setTab]      = useState('password'); // password | magic

  useEffect(() => {
    if (session) {
      const redirect = router.query.redirect || '/dashboard';
      router.replace(redirect);
    }
  }, [session]);

  useEffect(() => {
    if (router.query.error)      setError(decodeURIComponent(String(router.query.error)));
    if (router.query.registered) setMessage('Registration successful! Check your email to confirm, then log in.');
  }, [router.query]);

  const handlePassword = async (e) => {
    e.preventDefault();
    setLoading(true); setError(''); setMessage('');
    const { error } = await supabase.auth.signInWithPassword({ email, password });
    setLoading(false);
    if (error) setError(error.message);
  };

  const handleMagicLink = async (e) => {
    e.preventDefault();
    setLoading(true); setError(''); setMessage('');
    const { error } = await supabase.auth.signInWithOtp({
      email,
      options: { emailRedirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/confirm` },
    });
    setLoading(false);
    if (error) setError(error.message);
    else setMessage('✓ Magic link sent! Check your email inbox.');
  };

  const handleOAuth = async (provider) => {
    await supabase.auth.signInWithOAuth({
      provider,
      options: { redirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/confirm` },
    });
  };

  return (
    <>
      <Head><title>Login | Olufunke Football Academy</title></Head>

      <section style={{
        minHeight: '100vh',
        background: 'linear-gradient(135deg,#10316B 0%,#0a1f4e 50%,#1a5c2a 100%)',
        display: 'flex', alignItems: 'center',
        padding: '32px 16px',
        fontFamily: "'Montserrat', Arial, sans-serif",
        position: 'relative', overflow: 'hidden',
      }}>
        {/* Background decoration */}
        <div style={{position:'absolute',top:-60,right:-60,width:300,height:300,borderRadius:'50%',background:'rgba(255,193,7,.06)'}}></div>
        <div style={{position:'absolute',bottom:-80,left:-80,width:400,height:400,borderRadius:'50%',background:'rgba(76,175,80,.06)'}}></div>

        <div style={{width:'100%',maxWidth:460,margin:'0 auto',position:'relative',zIndex:1}}>

          {/* Logo + header */}
          <div style={{textAlign:'center',marginBottom:28}}>
            <div style={{position:'relative',display:'inline-block',marginBottom:12}}>
              <img src="/images/OFA New Logo.jpg" alt="OFA"
                style={{width:88,height:88,borderRadius:'50%',border:'4px solid #ffc107',objectFit:'cover',boxShadow:'0 8px 32px rgba(0,0,0,.3)'}}
                onError={e=>e.target.src='/images/OFA New Logo.jpg'} />
              <div style={{position:'absolute',bottom:0,right:0,width:24,height:24,background:'#4CAF50',borderRadius:'50%',border:'2px solid #fff',display:'flex',alignItems:'center',justifyContent:'center'}}>
                <span style={{color:'#fff',fontSize:12}}>⚽</span>
              </div>
            </div>
            <h2 style={{color:'#fff',fontWeight:800,margin:'0 0 4px',fontSize:'1.5rem'}}>Welcome Back</h2>
            <p style={{color:'rgba(255,255,255,.65)',fontSize:'.85rem',margin:0}}>
              Log in to your OFA Player Portal
            </p>
          </div>

          {/* Card */}
          <div style={{background:'#fff',borderRadius:24,overflow:'hidden',boxShadow:'0 24px 64px rgba(0,0,0,.3)'}}>

            {/* Card header */}
            <div style={{background:'linear-gradient(135deg,#10316B,#1e4db7)',padding:'18px 28px',display:'flex',alignItems:'center',justifyContent:'space-between'}}>
              <div style={{display:'flex',alignItems:'center',gap:10}}>
                <i className="bi bi-shield-lock-fill" style={{color:'#fbbf24',fontSize:'1.2rem'}}></i>
                <span style={{color:'#fff',fontWeight:700,fontSize:'.95rem'}}>Player / Admin Login</span>
              </div>
              <span style={{background:'rgba(255,255,255,.15)',color:'#fff',borderRadius:20,padding:'3px 10px',fontSize:'.7rem',fontWeight:600}}>
                SECURE
              </span>
            </div>

            <div style={{padding:'24px 28px'}}>

              {/* Alerts */}
              {error   && <div style={{background:'#fee2e2',border:'1px solid #fca5a5',borderRadius:12,padding:'10px 14px',color:'#b91c1c',marginBottom:16,fontSize:'.83rem',display:'flex',alignItems:'center',gap:8}}>
                <i className="bi bi-exclamation-circle-fill"></i>{error}
              </div>}
              {message && <div style={{background:'#dcfce7',border:'1px solid #86efac',borderRadius:12,padding:'10px 14px',color:'#15803d',marginBottom:16,fontSize:'.83rem',display:'flex',alignItems:'center',gap:8}}>
                <i className="bi bi-check-circle-fill"></i>{message}
              </div>}

              {/* Tab switcher */}
              <div style={{display:'flex',background:'#f0f4f8',borderRadius:12,padding:4,marginBottom:20}}>
                {[['password','🔑 Password'],['magic','✉ Magic Link']].map(([t,l])=>(
                  <button key={t} type="button" onClick={()=>setTab(t)}
                    style={{flex:1,padding:'9px 0',borderRadius:10,border:'none',cursor:'pointer',fontWeight:600,fontSize:'.82rem',transition:'all .2s',
                      background:tab===t?'#10316B':'transparent',color:tab===t?'#fff':'#64748b',
                      boxShadow:tab===t?'0 2px 8px rgba(16,49,107,.3)':'none'}}>
                    {l}
                  </button>
                ))}
              </div>

              {/* Password login */}
              {tab === 'password' && (
                <form onSubmit={handlePassword}>
                  <div style={{marginBottom:16}}>
                    <label style={{display:'block',fontWeight:600,fontSize:'.82rem',marginBottom:6,color:'#374151'}}>
                      Email Address
                    </label>
                    <div style={{position:'relative'}}>
                      <i className="bi bi-envelope-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                      <input type="email" value={email} onChange={e=>setEmail(e.target.value)}
                        placeholder="your@email.com" required autoFocus
                        style={{width:'100%',padding:'11px 12px 11px 36px',border:'1.5px solid #e5eaf0',borderRadius:10,fontSize:'.9rem',boxSizing:'border-box',outline:'none',fontFamily:'inherit'}}
                        onFocus={e=>e.target.style.borderColor='#10316B'}
                        onBlur={e=>e.target.style.borderColor='#e5eaf0'} />
                    </div>
                  </div>

                  <div style={{marginBottom:20}}>
                    <label style={{display:'block',fontWeight:600,fontSize:'.82rem',marginBottom:6,color:'#374151'}}>
                      Password
                    </label>
                    <div style={{position:'relative'}}>
                      <i className="bi bi-lock-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                      <input type={showPwd?'text':'password'} value={password} onChange={e=>setPassword(e.target.value)}
                        placeholder="Your password" required
                        style={{width:'100%',padding:'11px 40px 11px 36px',border:'1.5px solid #e5eaf0',borderRadius:10,fontSize:'.9rem',boxSizing:'border-box',outline:'none',fontFamily:'inherit'}}
                        onFocus={e=>e.target.style.borderColor='#10316B'}
                        onBlur={e=>e.target.style.borderColor='#e5eaf0'} />
                      <button type="button" onClick={()=>setShowPwd(!showPwd)}
                        style={{position:'absolute',right:10,top:'50%',transform:'translateY(-50%)',background:'none',border:'none',cursor:'pointer',color:'#9ca3af',padding:4}}>
                        <i className={`bi bi-eye${showPwd?'-slash':''}-fill`}></i>
                      </button>
                    </div>
                  </div>

                  <button type="submit" disabled={loading}
                    style={{width:'100%',padding:'12px 0',background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',border:'none',borderRadius:12,fontWeight:700,fontSize:'1rem',cursor:loading?'not-allowed':'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8,boxShadow:'0 4px 16px rgba(16,49,107,.3)'}}>
                    {loading ? <><span className="spinner-border spinner-border-sm"></span>Logging in…</> : <><i className="bi bi-box-arrow-in-right"></i>Log In</>}
                  </button>
                </form>
              )}

              {/* Magic link */}
              {tab === 'magic' && (
                <form onSubmit={handleMagicLink}>
                  <div style={{marginBottom:20}}>
                    <label style={{display:'block',fontWeight:600,fontSize:'.82rem',marginBottom:6,color:'#374151'}}>
                      Email Address
                    </label>
                    <div style={{position:'relative'}}>
                      <i className="bi bi-envelope-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                      <input type="email" value={email} onChange={e=>setEmail(e.target.value)}
                        placeholder="your@email.com" required autoFocus
                        style={{width:'100%',padding:'11px 12px 11px 36px',border:'1.5px solid #e5eaf0',borderRadius:10,fontSize:'.9rem',boxSizing:'border-box',outline:'none',fontFamily:'inherit'}}
                        onFocus={e=>e.target.style.borderColor='#4CAF50'}
                        onBlur={e=>e.target.style.borderColor='#e5eaf0'} />
                    </div>
                  </div>
                  <div style={{background:'#f0fdf4',borderRadius:10,padding:'10px 14px',marginBottom:16,fontSize:'.78rem',color:'#15803d',display:'flex',gap:8}}>
                    <i className="bi bi-info-circle-fill mt-1 flex-shrink-0"></i>
                    <span>We&apos;ll send a one-click login link to your email. No password needed.</span>
                  </div>
                  <button type="submit" disabled={loading}
                    style={{width:'100%',padding:'12px 0',background:'linear-gradient(135deg,#4CAF50,#15803d)',color:'#fff',border:'none',borderRadius:12,fontWeight:700,fontSize:'1rem',cursor:loading?'not-allowed':'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8}}>
                    {loading ? <><span className="spinner-border spinner-border-sm"></span>Sending…</> : <><i className="bi bi-send-fill"></i>Send Magic Link</>}
                  </button>
                </form>
              )}

              {/* Divider */}
              <div style={{display:'flex',alignItems:'center',gap:12,margin:'20px 0'}}>
                <div style={{flex:1,height:1,background:'#e5eaf0'}}></div>
                <span style={{color:'#9ca3af',fontSize:'.72rem',fontWeight:600}}>OR CONTINUE WITH</span>
                <div style={{flex:1,height:1,background:'#e5eaf0'}}></div>
              </div>

              {/* OAuth */}
              <div style={{display:'flex',gap:10}}>
                <button onClick={()=>handleOAuth('google')} type="button"
                  style={{flex:1,padding:'10px 0',background:'#fff',border:'1.5px solid #e5eaf0',borderRadius:10,cursor:'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8,fontWeight:600,fontSize:'.82rem',color:'#374151',transition:'all .2s'}}
                  onMouseOver={e=>e.currentTarget.style.borderColor='#ea4335'}
                  onMouseOut={e=>e.currentTarget.style.borderColor='#e5eaf0'}>
                  <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                  Google
                </button>
                <button onClick={()=>handleOAuth('github')} type="button"
                  style={{flex:1,padding:'10px 0',background:'#24292e',border:'1.5px solid #24292e',borderRadius:10,cursor:'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8,fontWeight:600,fontSize:'.82rem',color:'#fff'}}>
                  <i className="bi bi-github" style={{fontSize:'1rem'}}></i>GitHub
                </button>
              </div>
            </div>

            {/* Footer */}
            <div style={{background:'#f8fafc',padding:'14px 28px',textAlign:'center',borderTop:'1px solid #e5eaf0'}}>
              <span style={{color:'#64748b',fontSize:'.83rem'}}>
                New player? <Link href="/register" style={{color:'#10316B',fontWeight:700,textDecoration:'none'}}>Register Here →</Link>
              </span>
            </div>
          </div>

          {/* Admin credentials hint */}
          <div style={{marginTop:16,background:'rgba(255,255,255,.08)',borderRadius:12,padding:'12px 16px',textAlign:'center'}}>
            <p style={{color:'rgba(255,255,255,.6)',fontSize:'.75rem',margin:0}}>
              <i className="bi bi-info-circle me-1"></i>
              Admin: <strong style={{color:'rgba(255,255,255,.85)'}}>admin@olufunkefa.com</strong> | 
              Members: log in with your registered email
            </p>
          </div>
        </div>
      </section>
    </>
  );
}
