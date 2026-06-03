/**
 * pages/dashboard.js — Player Dashboard
 * Shows the logged-in player's profile, lesson progress, and quiz scores.
 * Protected — redirects to /login if no session.
 */

import { useEffect, useState } from 'react';
import { useRouter } from 'next/router';
import { useSession, useSupabaseClient } from '@supabase/auth-helpers-react';

export default function Dashboard() {
  const session  = useSession();
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [profile,  setProfile]  = useState(null);
  const [progress, setProgress] = useState([]);
  const [attempts, setAttempts] = useState([]);
  const [loading,  setLoading]  = useState(true);

  // ── Redirect if not logged in ────────────────────────────────
  useEffect(() => {
    if (session === null) router.replace('/login');
  }, [session, router]);

  // ── Load dashboard data ──────────────────────────────────────
  useEffect(() => {
    if (!session) return;

    async function loadDashboard() {
      const userId = session.user.id;

      const [{ data: prof }, { data: prog }, { data: quiz }] = await Promise.all([
        // Profile
        supabase
          .from('profiles')
          .select('full_name, avatar_url, role')
          .eq('id', userId)
          .single(),

        // Lesson progress with lesson title
        supabase
          .from('lesson_progress')
          .select('completed, completed_at, lessons(title, courses(title))')
          .eq('user_id', userId)
          .order('completed_at', { ascending: false })
          .limit(10),

        // Quiz attempts
        supabase
          .from('quiz_attempts')
          .select('score, total_questions, completed_at, quiz_weeks(title, week_number)')
          .eq('user_id', userId)
          .order('completed_at', { ascending: false }),
      ]);

      setProfile(prof);
      setProgress(prog  || []);
      setAttempts(quiz  || []);
      setLoading(false);
    }

    loadDashboard();
  }, [session, supabase]);

  // ── Sign out ─────────────────────────────────────────────────
  const handleSignOut = async () => {
    await supabase.auth.signOut();
    router.push('/login');
  };

  if (!session || loading) {
    return <p style={{ fontFamily: 'sans-serif', padding: 24 }}>Loading dashboard...</p>;
  }

  const completedLessons = progress.filter((p) => p.completed).length;

  return (
    <main style={{ fontFamily: 'sans-serif', maxWidth: 900, margin: '0 auto', padding: 24 }}>
      {/* ── Header ──────────────────────────────────────────── */}
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 32 }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: 16 }}>
          {profile?.avatar_url && (
            <img src={profile.avatar_url} alt="Avatar"
              style={{ width: 48, height: 48, borderRadius: '50%' }} />
          )}
          <div>
            <h1 style={{ margin: 0 }}>
              Welcome, {profile?.full_name || session.user.email}
            </h1>
            <span style={{ color: '#666', fontSize: 14, textTransform: 'capitalize' }}>
              {profile?.role || 'player'}
            </span>
          </div>
        </div>
        <button
          onClick={handleSignOut}
          style={{ padding: '8px 16px', background: '#e53e3e', color: '#fff', border: 'none', borderRadius: 6, cursor: 'pointer' }}
        >
          Sign Out
        </button>
      </div>

      {/* ── Stats row ────────────────────────────────────────── */}
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 16, marginBottom: 32 }}>
        <StatCard label="Lessons Completed" value={completedLessons} color="#0070f3" />
        <StatCard label="Quizzes Taken"      value={attempts.length}  color="#38a169" />
        <StatCard
          label="Best Quiz Score"
          value={attempts.length > 0
            ? `${Math.max(...attempts.map((a) => a.score))}/${attempts[0]?.total_questions}`
            : '–'}
          color="#d69e2e"
        />
      </div>

      {/* ── Recent lesson progress ───────────────────────────── */}
      <section style={{ marginBottom: 32 }}>
        <h2>Recent Lessons</h2>
        {progress.length === 0 ? (
          <p style={{ color: '#666' }}>No lessons started yet.</p>
        ) : (
          <ul style={{ listStyle: 'none', padding: 0 }}>
            {progress.map((p, i) => (
              <li key={i} style={{ display: 'flex', justifyContent: 'space-between', padding: '8px 0', borderBottom: '1px solid #eee' }}>
                <span>{p.lessons?.courses?.title} — {p.lessons?.title}</span>
                <span style={{ color: p.completed ? 'green' : '#999' }}>
                  {p.completed ? '✓ Complete' : 'In Progress'}
                </span>
              </li>
            ))}
          </ul>
        )}
      </section>

      {/* ── Quiz history ─────────────────────────────────────── */}
      <section>
        <h2>Quiz History</h2>
        {attempts.length === 0 ? (
          <p style={{ color: '#666' }}>No quizzes attempted yet. <a href="/quiz">Take the quiz →</a></p>
        ) : (
          <ul style={{ listStyle: 'none', padding: 0 }}>
            {attempts.map((a, i) => (
              <li key={i} style={{ display: 'flex', justifyContent: 'space-between', padding: '8px 0', borderBottom: '1px solid #eee' }}>
                <span>{a.quiz_weeks?.title} (Week {a.quiz_weeks?.week_number})</span>
                <span style={{ fontWeight: 'bold' }}>
                  {a.score} / {a.total_questions}
                </span>
              </li>
            ))}
          </ul>
        )}
      </section>
    </main>
  );
}

function StatCard({ label, value, color }) {
  return (
    <div style={{ border: `2px solid ${color}`, borderRadius: 8, padding: '16px 20px', textAlign: 'center' }}>
      <div style={{ fontSize: 32, fontWeight: 'bold', color }}>{value}</div>
      <div style={{ fontSize: 14, color: '#666', marginTop: 4 }}>{label}</div>
    </div>
  );
}
