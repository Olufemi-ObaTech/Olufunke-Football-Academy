/**
 * run_updates.js — Run only the updates.sql file on Supabase
 * node run_updates.js
 */
const fs   = require('fs');
const path = require('path');

const DB_HOST     = 'aws-0-eu-west-1.pooler.supabase.com';
const DB_PORT     = 6543;
const DB_USER     = 'postgres.fpqkewuoymyodveqbfjc';
const DB_PASSWORD = 'Olufunke@2026';
const DB_NAME     = 'postgres';

async function main() {
  const { Client } = require('pg');
  const client = new Client({
    host: DB_HOST, port: DB_PORT, user: DB_USER,
    password: DB_PASSWORD, database: DB_NAME,
    ssl: { rejectUnauthorized: false },
  });

  await client.connect();
  console.log('✅ Connected to Supabase\n');

  const files = ['updates.sql'];

  for (const file of files) {
    const sql = fs.readFileSync(path.join(__dirname, 'supabase', file), 'utf8');
    process.stdout.write(`▶  Running ${file} ... `);
    try {
      await client.query(sql);
      console.log('✅ OK');
    } catch(e) {
      if (e.message.includes('already exists') || e.message.includes('duplicate')) {
        console.log('⚠  Already exists (OK)');
      } else {
        console.log(`❌ ${e.message.slice(0,200)}`);
      }
    }
  }

  await client.end();
  console.log('\nDone.');
}

main().catch(console.error);
