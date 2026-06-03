/**
 * pages/index.js — Home page
 * Fetches players and fixtures from Supabase via the browser client.
 */

import { useEffect, useState } from 'react';
import Link from 'next/link';
import { supabase } from '../lib/supabaseClient';

export default function Home() {
  const [players,  setPlayers]  = useState([]);
  const [fixtures, setFixtures] = useState([]);
  const [results,  setResults]  = useState([]);
  const [loading,  setLoading]  = useState(true);

  useEffect(() => {
    async function loadData() {
      const [{ data: playerData }, { data: fixtureData }, { data: resultData }] =
        await Promise.all([
          supabase
            .from('players')
            .select('id, full_name, position, photo_url')
            .eq('approved', true)
            .limit(6),
          supabase
            .from('next_fixtures')
            .select('*')
            .order('fixture_date')
            .limit(3),
          supabase
            .from('match_results')
            .select('*')
            .order('match_date', { ascending: false })
            .limit(3),
        ]);

      setPlayers(playerData  || []);
      setFixtures(fixtureData || []);
      setResults(resultData  || []);
      setLoading(false);
    }

    loadData();
  }, []);

  return (
    <main style={{ fontFamily: 'sans-serif', maxWidth: 900, margin: '0 auto', padding: 24 }}>
      <h1>⚽ OFA Academy</h1>
      <p>Olufunke Football Academy — Player Portal</p>

      <nav style={{ display: 'flex', gap: 16, marginBottom: 32 }}>
        <Link href="/login">Login</Link>
        <Link href="/dashboard">Dashboard</Link>
        <Link href="/quiz">Weekly Quiz</Link>
      </nav>

      {loading ? (
        <p>Loading...</p>
      ) : (
        <>
          {/* ── Featured Players ────────────────────────────── */}
          <section>
            <h2>Our Players</h2>
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 16 }}>
              {players.map((p) => (
                <div key={p.id} style={{ border: '1px solid #ddd', borderRadius: 8, padding: 16 }}>
                  {p.photo_url && (
                    <img src={p.photo_url} alt={p.full_name}
                      style={{ width: '100%', borderRadius: 4, marginBottom: 8 }} />
                  )}
                  <strong>{p.full_name}</strong>
                  <p style={{ color: '#666', fontSize: 14 }}>{p.position}</p>
                </div>
              ))}
            </div>
          </section>

          {/* ── Next Fixtures ─────────────────────────────────── */}
          <section style={{ marginTop: 32 }}>
            <h2>Next Fixtures</h2>
            {fixtures.length === 0 ? (
              <p>No upcoming fixtures.</p>
            ) : (
              <ul>
                {fixtures.map((f) => (
                  <li key={f.id}>
                    <strong>{f.home_team}</strong> vs <strong>{f.away_team}</strong>
                    {' — '}
                    {new Date(f.fixture_date).toLocaleDateString('en-GB', {
                      weekday: 'short', day: 'numeric', month: 'short', year: 'numeric',
                    })}
                    {f.venue && ` @ ${f.venue}`}
                  </li>
                ))}
              </ul>
            )}
          </section>

          {/* ── Recent Results ────────────────────────────────── */}
          <section style={{ marginTop: 32 }}>
            <h2>Recent Results</h2>
            {results.length === 0 ? (
              <p>No results yet.</p>
            ) : (
              <ul>
                {results.map((r) => (
                  <li key={r.id}>
                    {r.home_team} <strong>{r.home_score} – {r.away_score}</strong> {r.away_team}
                    {' — '}
                    {new Date(r.match_date).toLocaleDateString('en-GB')}
                  </li>
                ))}
              </ul>
            )}
          </section>
        </>
      )}
    </main>
  );
}
