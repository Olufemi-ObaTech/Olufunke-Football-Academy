import { useState, useEffect } from 'react';
import { useRouter } from 'next/router';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';

export default function Login() {
  const supabase = useSupabaseClient();
  const session  = useSession();
  const router   = useRouter();

  const [email,   setEmail]   = useState('');
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState('');
  const [error,   setError]   = useState('');

  // Already logged in → go to dashboard or redirect target
  useEffect(() => {
    if (session) {
      const redirect = router.query.redirect || '/dashboard';
      router.replace(redirect);
    }
  }, [session, router]);

  // Show error from URL query (e.g. ?error=auth_failed)
  useEffect(() => {
    if (router.query.error) setError(String(router.query.error));
  }, [router.query.error]);

  const handleMagicLink = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setMessage('');

    const { error } = await supabase.auth.signInWithOtp({
      email,
      options: {
        emailRedirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/callback`,
      },
    });

    setLoading(false);
    if (error) setError(error.message);
    else setMessage('Check your email for the login link!');
  };

  const handleOAuth = async (provider) => {
    await supabase.auth.signInWithOAuth({
      provider,
      options: {
        redirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/callback`,
      },
    });
  };

  return (
    <main style={{ fontFamily: 'sans-serif', maxWidth: 400, margin: '80px auto', padding: 24 }}>
      <h1>⚽ OFA Academy Login</h1>

      {error   && <p style={{ color: 'red'   }}>⚠ {error}</p>}
      {message && <p style={{ color: 'green' }}>✓ {message}</p>}

      <form onSubmit={handleMagicLink} style={{ marginBottom: 24 }}>
        <label htmlFor="email" style={{ display: 'block', marginBottom: 6 }}>
          Email Address
        </label>
        <input
          id="email"
          type="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          placeholder="you@example.com"
          required
          style={{
            width: '100%', padding: '8px 12px', fontSize: 16,
            marginBottom: 12, boxSizing: 'border-box', borderRadius: 6,
            border: '1px solid #ccc',
          }}
        />
        <button
          type="submit"
          disabled={loading}
          style={{
            width: '100%', padding: '10px 0', background: '#0070f3',
            color: '#fff', border: 'none', borderRadius: 6, fontSize: 16,
            cursor: loading ? 'not-allowed' : 'pointer',
          }}
        >
          {loading ? 'Sending...' : 'Send Magic Link'}
        </button>
      </form>

      <p style={{ textAlign: 'center', color: '#999' }}>— or sign in with —</p>

      <div style={{ display: 'flex', gap: 12, marginTop: 12 }}>
        <button
          onClick={() => handleOAuth('google')}
          style={{
            flex: 1, padding: '10px 0', background: '#ea4335',
            color: '#fff', border: 'none', borderRadius: 6, cursor: 'pointer',
          }}
        >
          Google
        </button>
        <button
          onClick={() => handleOAuth('github')}
          style={{
            flex: 1, padding: '10px 0', background: '#24292e',
            color: '#fff', border: 'none', borderRadius: 6, cursor: 'pointer',
          }}
        >
          GitHub
        </button>
      </div>
    </main>
  );
}
