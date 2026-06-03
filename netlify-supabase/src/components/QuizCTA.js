import Link from 'next/link';

export default function QuizCTA() {
  return (
    <section className="py-5" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
      <div className="container">
        <div className="row align-items-center g-4">
          <div className="col-md-8 text-white">
            <div className="d-flex align-items-center gap-3 mb-3">
              <span style={{fontSize:'3rem'}}>🧠⚽</span>
              <div>
                <h2 className="fw-bold mb-1">Weekly Football IQ Quiz</h2>
                <p className="opacity-75 mb-0">Think you know football? Prove it! Open to everyone — no login required.</p>
              </div>
            </div>
            <div className="d-flex gap-3 flex-wrap">
              <span className="badge bg-warning text-dark fs-6 px-3 py-2"><i className="bi bi-lightning-fill me-1"></i>New Quiz Every Week</span>
              <span className="badge bg-white text-dark fs-6 px-3 py-2"><i className="bi bi-trophy-fill me-1 text-warning"></i>Live Leaderboard</span>
              <span className="badge bg-success fs-6 px-3 py-2"><i className="bi bi-people-fill me-1"></i>Free for Everyone</span>
            </div>
          </div>
          <div className="col-md-4 text-center text-md-end">
            <Link href="/quiz" className="btn btn-warning btn-lg fw-bold px-5 shadow">
              <i className="bi bi-play-fill me-2"></i>Take the Quiz
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
}
