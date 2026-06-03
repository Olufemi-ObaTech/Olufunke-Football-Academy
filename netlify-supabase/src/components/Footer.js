import Link from 'next/link';

export default function Footer() {
  return (
    <footer className="bg-dark text-light pt-4 pb-2 mt-0">
      <div className="container">
        <div className="row align-items-center">
          <div className="col-sm-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
            <a href="/" className="d-inline-flex align-items-center link-light text-decoration-none">
              <img src="/images/OFA New Logo.jpg" alt="OFA Logo" width="48" height="48" className="me-2" loading="lazy" />
              <span className="fs-5 fw-bold">Olufunke Football Academy</span>
            </a>
            <p className="small mt-2 mb-0">Nurturing football talent for the future.</p>
            <p className="small mt-1 mb-0">Proud member of Lagos State Football Association, and Nigeria Football Federation.</p>
          </div>
          <div className="col-md-4 d-none d-md-block">
            <ul className="nav justify-content-center">
              <li className="nav-item"><Link href="/" className="nav-link px-2 text-light">Home</Link></li>
              <li className="nav-item"><Link href="/about" className="nav-link px-2 text-light">About Us</Link></li>
              <li className="nav-item"><Link href="/contact" className="nav-link px-2 text-light">Contact Us</Link></li>
            </ul>
          </div>
          <div className="col-sm-12 col-md-4 text-center text-md-end">
            <ul className="list-unstyled d-flex justify-content-center justify-content-md-end mb-0">
              <li className="ms-3"><a className="text-light" href="https://www.youtube.com/@olufunkefootballacademy" target="_blank" rel="noopener noreferrer"><i className="bi bi-youtube fs-3"></i></a></li>
              <li className="ms-3"><a className="text-light" href="https://web.facebook.com/people/Olufunke-Football-Academy/61554694136830/" target="_blank" rel="noopener noreferrer"><i className="bi bi-facebook fs-3"></i></a></li>
              <li className="ms-3"><a className="text-light" href="https://www.instagram.com/olufunkefootballacademy" target="_blank" rel="noopener noreferrer"><i className="bi bi-instagram fs-3"></i></a></li>
            </ul>
          </div>
        </div>
        <div className="row">
          <div className="col-12 text-center mt-3">
            <small>&copy; {new Date().getFullYear()} Olufunke Football Academy. All rights reserved.</small>
          </div>
        </div>
      </div>
    </footer>
  );
}
