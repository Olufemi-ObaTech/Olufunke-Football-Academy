import Head from 'next/head';
import Link from 'next/link';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';

export default function ConsentForm() {
  const today = new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'long', year: 'numeric' });

  return (
    <>
      <Head>
        <title>Guardian Consent Form | Olufunke Football Academy</title>
        <meta name="description" content="Download and complete the official Guardian Consent Form to register your child at Olufunke Football Academy." />
        <style>{`
          @media print {
            .no-print, nav, footer { display: none !important; }
            .consent-page { padding: 0 !important; background: #fff !important; }
            .consent-card { box-shadow: none !important; border: 1px solid #ccc !important; }
          }
          .consent-page { min-height: 100vh; background: #f0f4f8; padding: 32px 16px; font-family: 'Montserrat', Arial, sans-serif; }
          .consent-card { max-width: 800px; margin: 0 auto; background: #fff; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,.08); overflow: hidden; }
          .consent-header { background: linear-gradient(135deg, #10316B, #1e4db7); color: #fff; padding: 28px 32px; text-align: center; }
          .consent-body { padding: 32px; line-height: 1.8; color: #1a1a2e; font-size: .92rem; }
          .consent-body h3 { color: #10316B; font-weight: 700; margin: 24px 0 12px; font-size: 1.05rem; border-bottom: 2px solid #e5eaf0; padding-bottom: 6px; }
          .field-line { border-bottom: 1.5px solid #222; display: inline-block; min-width: 220px; margin: 0 4px; }
          .field-line-long { border-bottom: 1.5px solid #222; display: inline-block; min-width: 360px; margin: 0 4px; }
          .sig-box { border: 1.5px solid #222; border-radius: 8px; height: 60px; margin: 8px 0; }
          .consent-table { width: 100%; border-collapse: collapse; margin: 12px 0; }
          .consent-table td, .consent-table th { border: 1px solid #d1d5db; padding: 8px 12px; text-align: left; font-size: .85rem; }
          .consent-table th { background: #f0f4f8; font-weight: 700; color: #10316B; }
          .checkbox-line { display: flex; align-items: flex-start; gap: 10px; margin: 8px 0; }
          .checkbox-box { width: 18px; height: 18px; border: 1.5px solid #222; border-radius: 3px; flex-shrink: 0; margin-top: 3px; }
        `}</style>
      </Head>

      <div className="no-print"><NavBar /></div>

      <div className="consent-page">
        {/* Action bar */}
        <div className="no-print" style={{maxWidth:800,margin:'0 auto 20px',display:'flex',flexWrap:'wrap',gap:10,justifyContent:'space-between',alignItems:'center'}}>
          <Link href="/guardian-register" style={{display:'inline-flex',alignItems:'center',gap:6,color:'#10316B',fontWeight:600,textDecoration:'none',fontSize:'.88rem'}}>
            <i className="bi bi-arrow-left"></i> Back to Registration
          </Link>
          <div style={{display:'flex',gap:10}}>
            <button onClick={() => window.print()} style={{padding:'10px 24px',background:'linear-gradient(135deg,#10316B,#1e4db7)',color:'#fff',border:'none',borderRadius:10,fontWeight:700,cursor:'pointer',fontSize:'.88rem',display:'flex',alignItems:'center',gap:8}}>
              <i className="bi bi-printer-fill"></i> Print / Save as PDF
            </button>
          </div>
        </div>

        <div className="consent-card">
          {/* Header */}
          <div className="consent-header">
            <img src="/images/OFA New Logo.jpg" alt="OFA" style={{width:72,height:72,borderRadius:'50%',border:'3px solid #ffc107',objectFit:'cover',marginBottom:12}} />
            <h1 style={{fontSize:'1.4rem',fontWeight:800,margin:'0 0 4px'}}>OLUFUNKE FOOTBALL ACADEMY</h1>
            <p style={{margin:'0 0 2px',opacity:.85,fontSize:'.88rem'}}>Official Guardian / Parent / Legal Representative Consent Form</p>
            <p style={{margin:0,opacity:.65,fontSize:'.78rem'}}>Nathaniel Idowu Football Field, Oregie, Ajegunle, Lagos State, Nigeria</p>
          </div>

          {/* Body */}
          <div className="consent-body">
            <p style={{textAlign:'center',fontWeight:700,color:'#b91c1c',fontSize:'.85rem',background:'#fee2e2',padding:'8px 16px',borderRadius:8,marginBottom:20}}>
              ⚠️ This form MUST be completed, signed, and uploaded as a PDF during Guardian Registration. Registration will not be processed without a valid consent form.
            </p>

            <h3>Section A — Guardian / Parent / Legal Representative Information</h3>
            <table className="consent-table">
              <tbody>
                <tr><th style={{width:'35%'}}>Full Name</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Email Address</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Phone Number</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Home Address</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Relationship to Player</th><td>
                  <div className="checkbox-line"><div className="checkbox-box"></div> Parent (Father)</div>
                  <div className="checkbox-line"><div className="checkbox-box"></div> Parent (Mother)</div>
                  <div className="checkbox-line"><div className="checkbox-box"></div> Legal Guardian</div>
                  <div className="checkbox-line"><div className="checkbox-box"></div> Legal Representative</div>
                  <div className="checkbox-line"><div className="checkbox-box"></div> Other: <span className="field-line">&nbsp;</span></div>
                </td></tr>
                <tr><th>ID Type &amp; Number</th><td>Type: <span className="field-line">&nbsp;</span> Number: <span className="field-line">&nbsp;</span></td></tr>
              </tbody>
            </table>

            <h3>Section B — Player Information</h3>
            <table className="consent-table">
              <tbody>
                <tr><th style={{width:'35%'}}>Player&apos;s Full Name</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Date of Birth</th><td><span className="field-line">&nbsp;</span> Age: <span className="field-line">&nbsp;</span></td></tr>
                <tr><th>Playing Position</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Age Group</th><td>
                  <div style={{display:'flex',gap:16,flexWrap:'wrap'}}>
                    {['U13','U15','U17','U19','Senior'].map(g => (
                      <div className="checkbox-line" key={g}><div className="checkbox-box"></div> {g}</div>
                    ))}
                  </div>
                </td></tr>
                <tr><th>Nationality</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Medical Conditions</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Emergency Contact</th><td>Name: <span className="field-line">&nbsp;</span> Phone: <span className="field-line">&nbsp;</span></td></tr>
              </tbody>
            </table>

            <h3>Section C — Consent Declarations</h3>
            <p>I, the undersigned, hereby declare and consent to the following:</p>

            <div className="checkbox-line"><div className="checkbox-box"></div><span><strong>1. Participation Consent:</strong> I give my full consent for the player named above to participate in all training sessions, matches, tournaments, and academy activities organised by Olufunke Football Academy.</span></div>

            <div className="checkbox-line"><div className="checkbox-box"></div><span><strong>2. Medical Consent:</strong> I authorise the academy coaching and medical staff to provide or arrange first-aid treatment and emergency medical care for the player in the event of illness or injury during academy activities.</span></div>

            <div className="checkbox-line"><div className="checkbox-box"></div><span><strong>3. Photography &amp; Media:</strong> I consent to photographs and videos of the player being taken during academy activities and used for promotional purposes, including on the academy website, social media, and printed materials.</span></div>

            <div className="checkbox-line"><div className="checkbox-box"></div><span><strong>4. Code of Conduct:</strong> I have read and understand the academy&apos;s Code of Conduct and agree that the player will abide by all rules, policies, and instructions given by coaching staff.</span></div>

            <div className="checkbox-line"><div className="checkbox-box"></div><span><strong>5. Data Protection:</strong> I consent to the academy collecting and storing the personal data provided in this form for the purpose of player registration, communication, and academy administration, in accordance with applicable data protection laws.</span></div>

            <div className="checkbox-line"><div className="checkbox-box"></div><span><strong>6. Liability Acknowledgement:</strong> I understand that football is a physical activity and involves inherent risks. I acknowledge that the academy and its staff shall not be held liable for any injury sustained during normal training or match activities, except in cases of proven negligence.</span></div>

            <div className="checkbox-line"><div className="checkbox-box"></div><span><strong>7. Financial Obligations:</strong> I understand and agree to fulfil any financial obligations (registration fees, equipment costs, etc.) as communicated by the academy.</span></div>

            <h3>Section D — Declaration &amp; Signature</h3>
            <p>I confirm that all information provided in this form is true and accurate to the best of my knowledge. I understand that providing false information may result in the player&apos;s registration being revoked.</p>

            <table className="consent-table">
              <tbody>
                <tr><th style={{width:'35%'}}>Guardian&apos;s Full Name</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Signature</th><td><div className="sig-box"></div></td></tr>
                <tr><th>Date</th><td><span className="field-line">&nbsp;</span></td></tr>
                <tr><th>Place / City</th><td><span className="field-line-long">&nbsp;</span></td></tr>
              </tbody>
            </table>

            <h3>Section E — Witness (Optional)</h3>
            <table className="consent-table">
              <tbody>
                <tr><th style={{width:'35%'}}>Witness Name</th><td><span className="field-line-long">&nbsp;</span></td></tr>
                <tr><th>Witness Signature</th><td><div className="sig-box"></div></td></tr>
                <tr><th>Date</th><td><span className="field-line">&nbsp;</span></td></tr>
              </tbody>
            </table>

            <div style={{background:'#eff6ff',borderRadius:12,padding:'16px 20px',marginTop:24,fontSize:'.82rem',color:'#1d4ed8'}}>
              <strong><i className="bi bi-info-circle-fill me-2"></i>Instructions:</strong>
              <ol style={{margin:'8px 0 0',paddingLeft:20,lineHeight:1.9}}>
                <li>Print this form or save it as PDF using your browser&apos;s print function (Ctrl+P / Cmd+P).</li>
                <li>Fill in all required sections (A, B, C, D) completely.</li>
                <li>Sign the form in Section D.</li>
                <li>Scan or photograph the completed form and save as PDF.</li>
                <li>Upload the signed PDF during the Guardian Registration process on our website.</li>
              </ol>
            </div>

            <div style={{textAlign:'center',marginTop:24,padding:'16px',borderTop:'2px solid #e5eaf0'}}>
              <p style={{fontSize:'.78rem',color:'#94a3b8',margin:0}}>
                Olufunke Football Academy — Nathaniel Idowu Football Field, Oregie, Ajegunle, Lagos State<br/>
                Phone: 09079917993 | Website: olufunkefootballacademy.com<br/>
                © {new Date().getFullYear()} Olufunke Football Academy. All Rights Reserved.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div className="no-print"><Footer /></div>
    </>
  );
}
