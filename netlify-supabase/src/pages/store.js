import { useEffect, useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';
import { supabase } from '../lib/supabaseClient';

export default function Store() {
  const [products, setProducts] = useState([]);
  const [packages, setPackages] = useState([]);
  const [loading,  setLoading]  = useState(true);

  useEffect(() => {
    async function load() {
      const [{ data: prods }, { data: pkgs }] = await Promise.all([
        supabase.from('products').select('*').eq('available', true).eq('category', 'merchandise'),
        supabase.from('booking_packages').select('*').eq('is_active', true),
      ]);
      setProducts(prods || []);
      setPackages(pkgs  || []);
      setLoading(false);
    }
    load();
  }, []);

  const fmt = (n) => Number(n).toLocaleString('en-NG', { minimumFractionDigits: 0 });

  return (
    <>
      <Head><title>Olufunke FA | Our Store</title></Head>
      <NavBar active="store" />

      {/* Hero */}
      <section className="py-5 text-white text-center" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)'}}>
        <div className="container">
          <h1 className="fw-bold display-5"><i className="bi bi-shop-window me-2"></i>OFA Store &amp; Booking</h1>
          <p className="lead opacity-75">Shop official gear and book training packages securely.</p>
          <span className="badge bg-warning text-dark fs-6 px-3 py-2">🚀 Coming Soon — Full Online Checkout</span>
        </div>
      </section>

      {/* Merchandise */}
      <section className="py-5">
        <div className="container">
          <h2 className="fw-bold mb-4" style={{color:'#10316B'}}>
            <i className="bi bi-bag-heart-fill text-warning me-2"></i>Official Merchandise
          </h2>
          {loading ? <p>Loading…</p> : products.length === 0 ? (
            <div className="text-center py-5 text-muted">
              <i className="bi bi-bag-x fs-1 d-block mb-2 opacity-25"></i>
              <p>No merchandise available yet. Check back soon!</p>
            </div>
          ) : (
            <div className="row g-4">
              {products.map(p => (
                <div className="col-6 col-md-4 col-lg-3" key={p.id}>
                  <div className="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                    <div style={{height:200,overflow:'hidden'}}>
                      <img src={p.image_path || '/images/OFA New Logo.jpg'} alt={p.name}
                        className="w-100 h-100" style={{objectFit:'cover',transition:'transform .3s'}}
                        onMouseOver={e=>e.target.style.transform='scale(1.05)'}
                        onMouseOut={e=>e.target.style.transform='scale(1)'}
                        onError={e=>e.target.src='/images/OFA New Logo.jpg'} />
                    </div>
                    <div className="card-body d-flex flex-column">
                      <h6 className="fw-bold mb-1" style={{color:'#10316B'}}>{p.name}</h6>
                      <p className="text-muted small flex-grow-1">{p.description}</p>
                      <div className="d-flex justify-content-between align-items-center mt-2">
                        <span className="fw-bold text-success fs-5">₦{fmt(p.price)}</span>
                        <button className="btn btn-sm btn-outline-primary" disabled title="Coming Soon">
                          <i className="bi bi-cart-plus"></i> Add
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </section>

      {/* Booking Packages */}
      <section className="py-5" style={{background:'#f0f4ff'}}>
        <div className="container">
          <h2 className="fw-bold mb-2" style={{color:'#10316B'}}>
            <i className="bi bi-calendar-check-fill text-success me-2"></i>Booking Packages
          </h2>
          <p className="text-muted mb-4">Choose a training package and secure your spot at Olufunke Football Academy.</p>
          {loading ? <p>Loading…</p> : packages.length === 0 ? (
            <div className="text-center py-5 text-muted">
              <i className="bi bi-calendar-x fs-1 d-block mb-2 opacity-25"></i>
              <p>No packages available yet.</p>
            </div>
          ) : (
            <div className="row g-4">
              {packages.map(pkg => {
                const features = Array.isArray(pkg.features)
                  ? pkg.features
                  : typeof pkg.features === 'string'
                    ? JSON.parse(pkg.features)
                    : [];
                return (
                  <div className="col-md-4" key={pkg.id}>
                    <div className="card h-100 border-0 shadow rounded-3 overflow-hidden">
                      <div className="card-header text-white fw-bold text-center py-3" style={{background:'#10316B'}}>
                        {pkg.name}
                      </div>
                      <div className="card-body text-center d-flex flex-column">
                        <div className="display-6 fw-bold text-success my-3">₦{fmt(pkg.price)}</div>
                        <p className="text-muted flex-grow-1">{pkg.description}</p>
                        {pkg.duration && <p className="small"><i className="bi bi-clock text-primary"></i> Duration: <strong>{pkg.duration}</strong></p>}
                        {features.length > 0 && (
                          <ul className="list-unstyled text-start small mb-3">
                            {features.map((f,i) => <li key={i} className="mb-1"><i className="bi bi-check-circle-fill text-success me-2"></i>{f}</li>)}
                          </ul>
                        )}
                        <Link href="/contact" className="btn btn-success mt-2 fw-bold">
                          <i className="bi bi-calendar2-check me-1"></i>Book &amp; Pay
                        </Link>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          )}
        </div>
      </section>

      {/* Payment note */}
      <section className="py-4 bg-white">
        <div className="container text-center">
          <p className="text-muted mb-2">Secure payments powered by</p>
          <div className="d-flex justify-content-center gap-4 align-items-center flex-wrap">
            <span className="badge bg-success fs-6 px-4 py-2">Paystack</span>
            <span className="badge bg-primary fs-6 px-4 py-2">Flutterwave</span>
          </div>
          <p className="text-muted small mt-3">
            For orders and inquiries: <a href="mailto:Olufunkefootballacademy@gmail.com">Olufunkefootballacademy@gmail.com</a> | 📞 09079917993
          </p>
        </div>
      </section>

      <div className="py-3 text-center">
        <a href="#top" className="btn btn-outline-dark btn-sm"><i className="bi bi-arrow-up-circle"></i> Back to Top</a>
      </div>
      <Footer />
    </>
  );
}
