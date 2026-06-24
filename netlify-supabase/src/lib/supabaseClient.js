import { createClient } from '@supabase/supabase-js';

const supabaseUrl  = process.env.NEXT_PUBLIC_SUPABASE_URL  || 'https://fpqkewuoymyodveqbfjc.supabase.co';
const supabaseAnon = process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY || '';

if (!supabaseAnon && typeof window !== 'undefined') {
  console.error(
    '[OFA] NEXT_PUBLIC_SUPABASE_ANON_KEY is not set.\n' +
    'Copy netlify-supabase/.env.local.example → .env.local and add your Supabase keys.\n' +
    'Supabase project: https://fpqkewuoymyodveqbfjc.supabase.co'
  );
}

export const supabase = createClient(supabaseUrl, supabaseAnon, {
  auth: {
    persistSession:     true,
    autoRefreshToken:   true,
    detectSessionInUrl: true,
  },
  global: {
    headers: { 'x-application-name': 'ofa-academy' },
  },
});

export default supabase;
