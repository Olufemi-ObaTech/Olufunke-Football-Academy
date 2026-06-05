/**
 * run_sql.js — Run all Supabase SQL files via pg (Node.js PostgreSQL client)
 * Uses direct TCP connection to Supabase Transaction Pooler
 * Run: node run_sql.js
 */

const fs   = require('fs');
const path = require('path');

// Supabase connection details
const DB_HOST     = 'aws-0-eu-west-1.pooler.supabase.com';
const DB_PORT     = 6543;
const DB_USER     = 'postgres.fpqkewuoymyodveqbfjc';
const DB_PASSWORD = 'Olufunke@2026';
const DB_NAME     = 'postgres';

const SQL_DIR = path.join(__dirname, 'supabase');

const FILES = [
  'drop_all.sql',
  'schema.sql',
  'policies.sql',
  'seed.sql',
  'lessons_seed.sql',
  'more_courses.sql',
  'more_lessons.sql',
  'quiz_questions.sql',
  'more_quiz_questions.sql',
  'levels_schema.sql',
  'assign_levels.sql',
  'make_admin.sql',
];

async function main() {
  // Check if pg is installed
  let Client;
  try {
    Client = require('pg').Client;
  } catch (e) {
    console.log('pg not installed. Installing...');
    const { execSync } = require('child_process');
    execSync('npm install pg', { stdio: 'inherit', cwd: __dirname });
    Client = require('pg').Client;
  }

  const client = new Client({
    host:     DB_HOST,
    port:     DB_PORT,
    user:     DB_USER,
    password: DB_PASSWORD,
    database: DB_NAME,
    ssl:      { rejectUnauthorized: false },
  });

  console.log('=== OFA Academy — Supabase SQL Runner ===\n');
  console.log(`Connecting to ${DB_HOST}:${DB_PORT}...`);

  try {
    await client.connect();
    console.log('✅ Connected to Supabase!\n');
  } catch (err) {
    console.error('❌ Connection failed:', err.message);
    process.exit(1);
  }

  let passed = 0;
  let failed = 0;

  for (const file of FILES) {
    const filePath = path.join(SQL_DIR, file);

    if (!fs.existsSync(filePath)) {
      console.log(`⚠  SKIP: ${file} (not found)`);
      continue;
    }

    const sql = fs.readFileSync(filePath, 'utf8').trim();
    if (!sql) {
      console.log(`⚠  SKIP: ${file} (empty)`);
      continue;
    }

    process.stdout.write(`▶  Running ${file} ... `);

    try {
      await client.query(sql);
      console.log('✅ OK');
      passed++;
    } catch (err) {
      // Some errors are acceptable (e.g. "already exists")
      const msg = err.message || '';
      if (msg.includes('already exists') || msg.includes('duplicate key')) {
        console.log(`⚠  Skipped (already exists)`);
        passed++;
      } else {
        console.log(`❌ ERROR: ${msg.slice(0, 150)}`);
        failed++;
      }
    }

    // Small delay between files
    await new Promise(r => setTimeout(r, 300));
  }

  await client.end();

  console.log(`\n=== Done: ${passed} passed, ${failed} failed ===`);
  if (failed > 0) {
    console.log('\nCheck the errors above and fix them if needed.');
  } else {
    console.log('\n🎉 All SQL files executed successfully!');
    console.log('Your Supabase database is now fully populated.');
    console.log('Visit: https://olufunkefootballacademy.netlify.app');
  }
}

main().catch(err => {
  console.error('Fatal error:', err);
  process.exit(1);
});
