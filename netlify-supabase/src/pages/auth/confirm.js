/**
 * pages/auth/confirm.js
 * ─────────────────────
 * Handles the Supabase PKCE callback after magic link or OAuth sign-in.
 * The Netlify auth-handler function redirects here with ?code=...
 * This page uses the Supabase JS client to exchange the code for a session
 * (the only correct way — server-side exchange discards browser cookies).
 */

import { useEffect, useState } from 'react';
import { useRouter } from 'next/router';
import { useSupabaseClient } from '@supabase/auth-helpers-react';
import Head from 'next/head';

export default function AuthConfirm() {
  const router   = useRouter();
  const supabase = useSupabaseClient();
  const [status, setStatus] = useState('Verifying your login…');

  useEffect(() => {
    // Wait for router to be ready (query params available)
    if (!router.isReady) return;

    async function exchange() {
      const { code, token_hash, type, error } = router.query;

      if (error) {
        setStatus('Login failed: ' + error);
        setTimeout(() => router.replace('/login?error=' + encodeURIComponent(error)), 2000);
        return;
      }

      try {
        if (code) {
          // PKCE code exchange (OAuth + magic link)
          const { error: exchError } = await supabase.auth.exchangeCodeForSession(String(code));
          if (exchError) throw exchError;
        } else if (token_hash && type) {
          // OTP token verification (email confirmation)
          const { error: otpError } = await supabase.auth.verifyOtp({
            token_hash: String(token_hash),
            type: String(type),
          });
          if (otpError) throw otpError;
        } else {
          throw new Error('No auth code or token found in URL.');
        }

        setStatus('Login successful! Redirecting…');
        router.replace('/dashboard');
      } catch (err) {
        console.error('[auth/confirm]', err.message);
        setStatus('Login failed. Redirecting to login…');
        setTimeout(() => router.replace('/login?error=auth_failed'), 2000);
      }
    }

    exchange();
  }, [router.isReady, router.query]);

  return (
    <>
      <Head><title>Confirming Login | OFA</title></Head>
      <div style={{
        display: 'flex', flexDirection: 'column', alignItems: 'center',
        justifyContent: 'center', minHeight: '60vh',
        fontFamily: 'Montserrat, sans-serif', color: '#10316B',
      }}>
        <div style={{ fontSize: 48, marginBottom: 16 }}>⚽</div>
        <h2 style={{ fontWeight: 700, marginBottom: 8 }}>Olufunke Football Academy</h2>
        <p style={{ color: '#666' }}>{status}</p>
        <div style={{
          width: 40, height: 40, border: '4px solid #e2e8f0',
          borderTopColor: '#10316B', borderRadius: '50%',
          animation: 'spin 0.8s linear infinite', marginTop: 16,
        }} />
        <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
      </div>
    </>
  );
}
