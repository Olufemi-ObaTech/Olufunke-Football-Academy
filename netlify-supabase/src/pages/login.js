import { useState, useEffect } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';

export default function Login() {
  const supabase = useSupabaseClient();
  const session  = useSession();
  const router   = useRouter();

  const [tab,      setTab]      = useState('password'); // 'password' | 'magic'
  const [email,    setEmail]    = useState('');
  const [password, setPassword] = useState('');
  const [showPwd,  setShowPwd]  = useState(false);
  const [loading,  setLoading]  = useState(false);
  const [message,  setMessage]  = useState('');
  const [error,    setError]    = useState('');

  useEffect(() => {
    if (session) {
      const redirect = router.query.redirect || '/dashboard';
      router.replace(redirect);
    }
  }, [session, router]);

  useEffect(() => {
    if (router.query.error)      setError(decodeURIComponent(String(router.query.error)));
    if (router.query.registered) setMessage('Registration successful! Check your email to confirm your account, then login.');
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

  const LOGO = '/images/OFA New Logo.jpg';

  return (
    <>
      <Head>
        <title>Login | Olufunke Football Academy</title>
      </Head>

      <section style={{
        minHeight: '100vh',
        background: 'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)',
        display: 'flex', alignItems: 'center', padding: '32px 16px',
        fontFamily: "'Montserrat', Arial, sans-serif",
      }}>
        <div style={{width:'100%',maxWidth:460,margin:'0 auto'}}>

          {/* Logo + Title */}
          <div style={{textAlign:'center',marginBottom:28}}>
            <img src={LOGO} alt="OFA Logo"
              style={{width:80,height:80,borderRadius:'50%',border:'3px solid #ffc107',objectFit:'cover',marginBottom:12}}
              onError={e=>e.target.src='/images/OFA New Logo.jpg'} />
            <h2 style={{color:'#fff',fontWeight:800,margin:'0 0 4px'}}>Welcome Back</h2>
            <p style={{color:'rgba(255,255,255,.7)',fontSize:'.9rem',margin:0}}>
              Log in to your OFA Player Portal
            </p>
          </div>

          {/* Card */}
          <div style={{background:'#fff',borderRadius:20,overflow:'hidden',boxShadow:'0 20px 60px rgba(0,0,0,.25)'}}>

            {/* Card header */}
            <div style={{background:'#10316B',padding:'16px 24px',display:'flex',alignItems:'center',gap:10}}>
              <i className="bi bi-shield-lock-fill" style={{color:'#fbbf24',fontSize:'1.2rem'}}></i>
              <span style={{color:'#fff',fontWeight:700}}>Player / Admin Login</span>
            </div>

            <div style={{padding:'28px 28px 24px'}}>
              {/* Alerts */}
              {error   && <div style={{background:'#fee2e2',border:'1px solid #fca5a5',borderRadius:10,padding:'10px 14px',color:'#b91c1c',marginBottom:16,fontSize:'.85rem',display:'flex',alignItems:'center',gap:8}}><i className="bi bi-exclamation-circle-fill"></i>{error}</div>}
              {message && <div style={{background:'#dcfce7',border:'1px solid #86efac',borderRadius:10,padding:'10px 14px',color:'#15803d',marginBottom:16,fontSize:'.85rem',display:'flex',alignItems:'center',gap:8}}><i className="bi bi-check-circle-fill"></i>{message}</div>}

              {/* Tab switch */}
              <div style={{display:'flex',background:'#f0f4f8',borderRadius:10,padding:4,marginBottom:20}}>
                {[['password','🔑 Password'],['magic','✉ Magic Link']].map(([t,l])=>(
                  <button key={t} onClick={()=>setTab(t)} style={{flex:1,padding:'8px 0',borderRadius:8,border:'none',cursor:'pointer',fontWeight:600,fontSize:'.82rem',
                    background:tab===t?'#10316B':'transparent',color:tab===t?'#fff':'#64748b',transition:'all .2s'}}>
                    {l}
                  </button>
                ))}
              </div>

              {/* Password Login */}
              {tab === 'password' && (
                <form onSubmit={handlePassword}>
                  <div style={{marginBottom:16}}>
                    <label style={{display:'block',fontWeight:600,fontSize:'.83rem',marginBottom:6,color:'#374151'}}>
                      Email Address
                    </label>
                    <div style={{position:'relative'}}>
                      <i className="bi bi-envelope-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                      <input type="email" value={email} onChange={e=>setEmail(e.target.value)}
                        placeholder="your@email.com" required autoFocus
                        style={{width:'100%',padding:'10px 12px 10px 36px',border:'1.5px solid #e5eaf0',borderRadius:10,fontSize:'.92rem',boxSizing:'border-box',outline:'none'}}
                        onFocus={e=>e.target.style.borderColor='#10316B'}
                        onBlur={e=>e.target.style.borderColor='#e5eaf0'} />
                    </div>
                  </div>
                  <div style={{marginBottom:20}}>
                    <label style={{display:'block',fontWeight:600,fontSize:'.83rem',marginBottom:6,color:'#374151'}}>
                      Password
                    </label>
                    <div style={{position:'relative'}}>
                      <i className="bi bi-lock-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                      <input type={showPwd?'text':'password'} value={password} onChange={e=>setPassword(e.target.value)}
                        placeholder="Your password" required
                        style={{width:'100%',padding:'10px 40px 10px 36px',border:'1.5px solid #e5eaf0',borderRadius:10,fontSize:'.92rem',boxSizing:'border-box',outline:'none'}}
                        onFocus={e=>e.target.style.borderColor='#10316B'}
                        onBlur={e=>e.target.style.borderColor='#e5eaf0'} />
                      <button type="button" onClick={()=>setShowPwd(!showPwd)}
                        style={{position:'absolute',right:12,top:'50%',transform:'translateY(-50%)',background:'none',border:'none',cursor:'pointer',color:'#9ca3af',padding:0}}>
                        <i className={`bi bi-eye${showPwd?'-slash':''}-fill`}></i>
                      </button>
                    </div>
                  </div>
                  <button type="submit" disabled={loading}
                    style={{width:'100%',padding:'12px 0',background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',border:'none',borderRadius:10,fontWeight:700,fontSize:'1rem',cursor:loading?'not-allowed':'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8}}>
                    {loading ? <><span className="spinner-border spinner-border-sm"></span> Logging in…</> : <><i className="bi bi-box-arrow-in-right"></i> Log In</>}
                  </button>
                </form>
              )}

              {/* Magic Link */}
              {tab === 'magic' && (
                <form onSubmit={handleMagicLink}>
                  <div style={{marginBottom:20}}>
                    <label style={{display:'block',fontWeight:600,fontSize:'.83rem',marginBottom:6,color:'#374151'}}>
                      Email Address
                    </label>
                    <div style={{position:'relative'}}>
                      <i className="bi bi-envelope-fill" style={{position:'absolute',left:12,top:'50%',transform:'translateY(-50%)',color:'#9ca3af'}}></i>
                      <input type="email" value={email} onChange={e=>setEmail(e.target.value)}
                        placeholder="your@email.com" required autoFocus
                        style={{width:'100%',padding:'10px 12px 10px 36px',border:'1.5px solid #e5eaf0',borderRadius:10,fontSize:'.92rem',boxSizing:'border-box',outline:'none'}}
                        onFocus={e=>e.target.style.borderColor='#10316B'}
                        onBlur={e=>e.target.style.borderColor='#e5eaf0'} />
                    </div>
                  </div>
                  <button type="submit" disabled={loading}
                    style={{width:'100%',padding:'12px 0',background:'linear-gradient(135deg,#4CAF50,#15803d)',color:'#fff',border:'none',borderRadius:10,fontWeight:700,fontSize:'1rem',cursor:loading?'not-allowed':'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8}}>
                    {loading ? <><span className="spinner-border spinner-border-sm"></span> Sending…</> : <><i className="bi bi-send-fill"></i> Send Magic Link</>}
                  </button>
                </form>
              )}

              {/* Divider */}
              <div style={{display:'flex',alignItems:'center',gap:12,margin:'20px 0'}}>
                <div style={{flex:1,height:1,background:'#e5eaf0'}}></div>
                <span style={{color:'#9ca3af',fontSize:'.78rem',fontWeight:600}}>OR CONTINUE WITH</span>
                <div style={{flex:1,height:1,background:'#e5eaf0'}}></div>
              </div>

              {/* OAuth */}
              <div style={{display:'flex',gap:10}}>
                <button onClick={()=>handleOAuth('google')}
                  style={{flex:1,padding:'10px 0',background:'#fff',border:'1.5px solid #e5eaf0',borderRadius:10,cursor:'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8,fontWeight:600,fontSize:'.83rem',color:'#374151'}}>
                  <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                  Google
                </button>
                <button onClick={()=>handleOAuth('github')}
                  style={{flex:1,padding:'10px 0',background:'#24292e',border:'1.5px solid #24292e',borderRadius:10,cursor:'pointer',display:'flex',alignItems:'center',justifyContent:'center',gap:8,fontWeight:600,fontSize:'.83rem',color:'#fff'}}>
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

          <p style={{color:'rgba(255,255,255,.5)',fontSize:'.75rem',textAlign:'center',marginTop:16}}>
            <i className="bi bi-info-circle me-1"></i>
            Only registered &amp; approved players and admins can access member-only content.
          </p>
        </div>
      </section>
    </>
  );
}
