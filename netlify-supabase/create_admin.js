/**
 * create_admin.js — Create admin account in Supabase Auth
 * Uses the service role key to create the user via the Admin API
 * node create_admin.js
 */
const https = require('https');

const SUPABASE_URL      = 'https://fpqkewuoymyodveqbfjc.supabase.co';
const SERVICE_ROLE_KEY  = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZwcWtld3VveW15b2R2ZXFiZmpjIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc4MDQ5ODM5NCwiZXhwIjoyMDk2MDc0Mzk0fQ.aQK7N_s_wIwysC-gdUgYiq-l1mV8PX9JZlEP9U5zFoQ';

const ADMIN_EMAIL    = 'Olufunkefootballacademy@gmail.com';
const ADMIN_PASSWORD = 'OFA@Admin2026!';

function apiRequest(method, path, body) {
  return new Promise((resolve, reject) => {
    const data = JSON.stringify(body);
    const options = {
      hostname: 'fpqkewuoymyodveqbfjc.supabase.co',
      path,
      method,
      headers: {
        'Content-Type':  'application/json',
        'Authorization': `Bearer ${SERVICE_ROLE_KEY}`,
        'apikey':        SERVICE_ROLE_KEY,
        'Content-Length': Buffer.byteLength(data),
      },
    };

    const req = https.request(options, (res) => {
      let d = '';
      res.on('data', c => d += c);
      res.on('end', () => resolve({ status: res.statusCode, body: JSON.parse(d || '{}') }));
    });
    req.on('error', reject);
    req.write(data);
    req.end();
  });
}

async function main() {
  console.log('=== Creating Admin Account in Supabase ===\n');
  console.log(`Email:    ${ADMIN_EMAIL}`);
  console.log(`Password: ${ADMIN_PASSWORD}\n`);

  // Step 1: Create user via Admin API
  console.log('Step 1: Creating user in Supabase Auth...');
  const createRes = await apiRequest('POST', '/auth/v1/admin/users', {
    email:          ADMIN_EMAIL,
    password:       ADMIN_PASSWORD,
    email_confirm:  true,
    user_metadata:  { full_name: 'OFA Admin' },
  });

  if (createRes.status === 200 || createRes.status === 201) {
    const userId = createRes.body.id;
    console.log(`✅ User created! ID: ${userId}\n`);

    // Step 2: Set role to admin in profiles table via pg
    const { Client } = require('pg');
    const client = new Client({
      host: 'aws-0-eu-west-1.pooler.supabase.com',
      port: 6543,
      user: 'postgres.fpqkewuoymyodveqbfjc',
      password: 'Olufunke@2026',
      database: 'postgres',
      ssl: { rejectUnauthorized: false },
    });

    await client.connect();
    console.log('Step 2: Setting admin role in profiles...');

    await client.query(`
      INSERT INTO public.profiles (id, full_name, role, status, current_level)
      VALUES ($1, 'OFA Admin', 'admin', 'approved', 7)
      ON CONFLICT (id) DO UPDATE
        SET role = 'admin', status = 'approved', current_level = 7, updated_at = NOW()
    `, [userId]);

    await client.end();
    console.log('✅ Admin role set!\n');

    console.log('=== ADMIN ACCOUNT CREATED ===');
    console.log(`Email:    ${ADMIN_EMAIL}`);
    console.log(`Password: ${ADMIN_PASSWORD}`);
    console.log(`Role:     Admin (Level 7)`);
    console.log(`URL:      https://olufunkefootballacademy.netlify.app/login`);

  } else if (createRes.body.msg?.includes('already registered') || createRes.body.code === 'email_exists') {
    console.log('⚠  User already exists. Updating role to admin...');

    // Get existing user
    const listRes = await apiRequest('GET', `/auth/v1/admin/users?email=${encodeURIComponent(ADMIN_EMAIL)}`, {});
    const user = listRes.body.users?.[0];

    if (user) {
      // Update password
      await apiRequest('PUT', `/auth/v1/admin/users/${user.id}`, {
        password:      ADMIN_PASSWORD,
        email_confirm: true,
      });

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
          SET role = 'admin', status = 'approved', current_level = 7, updated_at = NOW()
      `, [user.id]);

      await client.end();

      console.log('✅ Existing user updated to admin!\n');
      console.log('=== ADMIN LOGIN DETAILS ===');
      console.log(`Email:    ${ADMIN_EMAIL}`);
      console.log(`Password: ${ADMIN_PASSWORD}`);
      console.log(`URL:      https://olufunkefootballacademy.netlify.app/login`);
    }
  } else {
    console.log('❌ Error:', createRes.status, JSON.stringify(createRes.body));
  }
}

main().catch(console.error);
