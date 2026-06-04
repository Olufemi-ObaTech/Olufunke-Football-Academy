import { useState } from 'react';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useSupabaseClient } from '@supabase/auth-helpers-react';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';

export default function Register() {
  const supabase = useSupabaseClient();
  const router   = useRouter();

  const [form, setForm] = useState({
    name:'', email:'', phone:'', nationality:'Nigerian',
    position:'', age:'', age_group:'', password:'', password_confirmation:'',
  });
  const [loading, setLoading] = useState(false);
  const [error,   setError]   = useState('');

  const handle = e => setForm(p => ({...p, [e.target.name]: e.target.value}));

  const submit = async (e) => {
    e.preventDefault();
    setError('');
    if (form.password !== form.password_confirmation) {
      setError('Passwords do not match.'); return;
    }
    if (form.password.length < 8) {
      setError('Password must be at least 8 characters.'); return;
    }
    setLoading(true);

    const { error: signUpError } = await supabase.auth.signUp({
      email:    form.email,
      password: form.password,
      options: {
        data: {
          full_name:   form.name,
          phone:       form.phone,
          nationality: form.nationality,
          position:    form.position,
          age:         form.age,
          age_group:   form.age_group,
        },
        emailRedirectTo: `${process.env.NEXT_PUBLIC_SITE_URL}/auth/callback`,
      },
    });

    setLoading(false);
    if (signUpError) { setError(signUpError.message); return; }

    router.push('/login?registered=1');
  };

  const LOGO = '/images/OFA New Logo.jpg';

  return (
    <>
      <Head><title>Olufunke FA | Player Registration</title></Head>
      <NavBar />

      <section className="py-5" style={{background:'linear-gradient(135deg,#10316B 60%,#4CAF50 100%)',minHeight:'100vh'}}>
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-lg-8 col-md-10">

              <div className="text-center text-white mb-4">
                <img src={LOGO} alt="OFA Logo" style={{width:80,height:80,borderRadius:'50%',border:'3px solid #ffc107',objectFit:'cover'}} className="mb-3 shadow" />
                <h2 className="fw-bold">Join Olufunke Football Academy</h2>
                <p className="opacity-75">Register as a player to access training programs and football education.</p>
              </div>

              <div className="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div className="card-header text-white fw-bold py-3 text-center fs-5" style={{background:'#10316B'}}>
                  <i className="bi bi-person-plus-fill me-2"></i>Player Registration Form
                </div>
                <div className="card-body p-4 p-md-5">
                  {error && <div className="alert alert-danger"><i className="bi bi-exclamation-triangle-fill me-2"></i>{error}</div>}

                  <form onSubmit={submit} noValidate>
                    {/* Personal Info */}
                    <h6 className="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                      <i className="bi bi-person-fill me-1"></i> Personal Information
                    </h6>
                    <div className="row g-3 mb-4">
                      <div className="col-md-6">
                        <label className="form-label fw-semibold">Full Name <span className="text-danger">*</span></label>
                        <input type="text" name="name" className="form-control form-control-lg" value={form.name} onChange={handle} placeholder="e.g. Chukwuemeka Obi" required />
                      </div>
                      <div className="col-md-6">
                        <label className="form-label fw-semibold">Email Address <span className="text-danger">*</span></label>
                        <input type="email" name="email" className="form-control form-control-lg" value={form.email} onChange={handle} placeholder="your@email.com" required />
                      </div>
                      <div className="col-md-6">
                        <label className="form-label fw-semibold">Phone Number <span className="text-danger">*</span></label>
                        <input type="tel" name="phone" className="form-control form-control-lg" value={form.phone} onChange={handle} placeholder="e.g. 09079917993" required />
                      </div>
                      <div className="col-md-6">
                        <label className="form-label fw-semibold">Nationality <span className="text-danger">*</span></label>
                        <input type="text" name="nationality" className="form-control form-control-lg" value={form.nationality} onChange={handle} placeholder="e.g. Nigerian" required />
                      </div>
                    </div>

                    {/* Football Profile */}
                    <h6 className="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                      <i className="bi bi-dribbble me-1"></i> Football Profile
                    </h6>
                    <div className="row g-3 mb-4">
                      <div className="col-md-4">
                        <label className="form-label fw-semibold">Playing Position <span className="text-danger">*</span></label>
                        <select name="position" className="form-select form-select-lg" value={form.position} onChange={handle} required>
                          <option value="">Select position</option>
                          {['Goalkeeper','Defender','Midfielder','Forward','Winger'].map(p=>(
                            <option key={p} value={p}>{p}</option>
                          ))}
                        </select>
                      </div>
                      <div className="col-md-4">
                        <label className="form-label fw-semibold">Age <span className="text-danger">*</span></label>
                        <input type="number" name="age" className="form-control form-control-lg" value={form.age} onChange={handle} placeholder="e.g. 16" min="8" max="40" required />
                      </div>
                      <div className="col-md-4">
                        <label className="form-label fw-semibold">Age Group <span className="text-danger">*</span></label>
                        <select name="age_group" className="form-select form-select-lg" value={form.age_group} onChange={handle} required>
                          <option value="">Select group</option>
                          {['U13','U15','U17','U19','Senior'].map(g=>(
                            <option key={g} value={g}>{g}</option>
                          ))}
                        </select>
                      </div>
                    </div>

                    {/* Password */}
                    <h6 className="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                      <i className="bi bi-lock-fill me-1"></i> Account Security
                    </h6>
                    <div className="row g-3 mb-4">
                      <div className="col-md-6">
                        <label className="form-label fw-semibold">Password <span className="text-danger">*</span></label>
                        <input type="password" name="password" className="form-control form-control-lg" value={form.password} onChange={handle} placeholder="Minimum 8 characters" required />
                      </div>
                      <div className="col-md-6">
                        <label className="form-label fw-semibold">Confirm Password <span className="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" className="form-control form-control-lg" value={form.password_confirmation} onChange={handle} placeholder="Repeat your password" required />
                      </div>
                    </div>

                    <div className="d-grid mt-2">
                      <button type="submit" className="btn btn-success btn-lg fw-bold py-3" disabled={loading}>
                        {loading
                          ? <><span className="spinner-border spinner-border-sm me-2"></span>Registering…</>
                          : <><i className="bi bi-person-check-fill me-2"></i>Register as OFA Player</>
                        }
                      </button>
                    </div>
                  </form>

                  <hr className="my-4" />
                  <p className="text-center text-muted mb-0">
                    Already have an account? <Link href="/login" className="fw-bold text-decoration-none" style={{color:'#10316B'}}>Log In Here</Link>
                  </p>
                </div>
              </div>

              <p className="text-center text-white opacity-75 small mt-3">
                <i className="bi bi-info-circle me-1"></i>
                Only registered &amp; approved players and admins can access Our Program and Football Education pages.
              </p>
            </div>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
}
