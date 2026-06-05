/**
 * fix_admin.js — Fix existing user to admin with new password
 */
const https = require('https');

const SERVICE_ROLE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZwcWtld3VveW15b2R2ZXFiZmpjIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc4MDQ5ODM5NCwiZXhwIjoyMDk2MDc0Mzk0fQ.aQK7N_s_wIwysC-gdUgYiq-l1mV8PX9JZlEP9U5zFoQ';
const ADMIN_EMAIL    = 'Olufunkefootballacademy@gmail.com';
const ADMIN_PASSWORD = 'OFA@Admin2026!';

function req(method, path, body) {
  return new Promise((resolve, reject) => {
    const data = JSON.stringify(body);
    const options = {
      hostname: 'fpqkewuoymyodveqbfjc.supabase.co',
      path, method,
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${SERVICE_ROLE_KEY}`,
        'apikey': SERVICE_ROLE_KEY,
        'Content-Length': Buffer.byteLength(data),
      },
    };
    const r = https.request(options, (res) => {
      let d = '';
      res.on('data', c => d += c);
      res.on('end', () => { try { resolve({ status: res.statusCode, body: JSON.parse(d) }); } catch { resolve({ status: res.statusCode, body: d }); }});
    });
    r.on('error', reject);
    r.write(data);
    r.end();
  });
}

async function main() {
  console.log('Finding user by email...');

  // List all users and find by email
  const listRes = await req('GET', '/auth/v1/admin/users?per_page=1000&page=1', {});
  const users = listRes.body.users || [];
  const user = users.find(u => u.email?.toLowerCase() === ADMIN_EMAIL.toLowerCase());

  if (!user) {
    console.log('User not found. Available users:');
    users.slice(0,5).forEach(u => console.log(' -', u.email));
    return;
  }

  console.log(`Found user: ${user.id} (${user.email})`);

  // Update password and confirm email
  console.log('Updating password...');
  const updateRes = await req('PUT', `/auth/v1/admin/users/${user.id}`, {
    password:      ADMIN_PASSWORD,
    email_confirm: true,
    user_metadata: { full_name: 'OFA Admin' },
  });
  console.log(`Password update: ${updateRes.status}`);

  // Set admin role in DB
  console.log('Setting admin role in database...');
  const { Client } = require('pg');
  const client = new Client({
    host: 'aws-0-eu-west-1.pooler.supabase.com', port: 6543,
    user: 'postgres.fpqkewuoymyodveqbfjc', password: 'Olufunke@2026',
    database: 'postgres', ssl: { rejectUnauthorized: false },
  });
  await client.connect();

  await client.query(`
    INSERT INTO public.profiles (id, full_name, role, status, current_level)
    VALUES ($1, 'OFA Admin', 'admin', 'approved', 7)
    ON CONFLICT (id) DO UPDATE
      SET role = 'admin', status = 'approved', current_level = 7,
          full_name = 'OFA Admin', updated_at = NOW()
  `, [user.id]);

  await client.end();

  console.log('\n✅ ADMIN ACCOUNT READY\n');
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  console.log(`  Email:    ${ADMIN_EMAIL}`);
  console.log(`  Password: ${ADMIN_PASSWORD}`);
  console.log(`  Role:     Admin (Level 7 — Elite)`);
  console.log(`  Login at: https://olufunkefootballacademy.netlify.app/login`);
  console.log(`  Admin:    https://olufunkefootballacademy.netlify.app/admin`);
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
}

main().catch(console.error);
