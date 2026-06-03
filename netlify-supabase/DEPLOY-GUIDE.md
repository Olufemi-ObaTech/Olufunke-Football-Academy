# Complete Deployment Guide — OFA Academy
# Netlify + Supabase Integration

---

## THE SITUATION (What exists, what you need to do)

Your project has TWO parts that work together:

| Part | Technology | Where it runs |
|------|-----------|--------------|
| **Main website** (Laravel) | PHP + Blade views | Needs a PHP server (NOT Netlify static) |
| **Netlify-Supabase layer** | Next.js + Node.js | Deploys to Netlify |

> **Important:** Laravel cannot run on Netlify (Netlify does not support PHP).
> Your main site deploys to a PHP host. The `netlify-supabase/` folder is a 
> separate frontend that talks to the same database via Supabase.

---

## PART 1 — SUPABASE SETUP (Do this first, takes ~15 min)

### Step 1 — Create a Supabase project

1. Go to https://supabase.com and sign up/login
2. Click **New Project**
3. Name it: `ofa-academy`
4. Choose a strong database password — **save it somewhere safe**
5. Region: choose closest to you (Europe West for Nigeria)
6. Click **Create new project** — wait ~2 minutes

### Step 2 — Run the database schema

1. In Supabase, click **SQL Editor** in the left sidebar
2. Click **New query**
3. Open the file: `netlify-supabase/supabase/schema.sql`
4. Copy ALL the content and paste it into the SQL editor
5. Click **Run** (green button)
6. You should see "Success. No rows returned"

### Step 3 — Run Row Level Security policies

1. Click **New query** again
2. Open the file: `netlify-supabase/supabase/policies.sql`
3. Copy ALL content, paste and **Run**

### Step 4 — Run seed data (optional but recommended)

1. **New query** again
2. Open `netlify-supabase/supabase/seed.sql`
3. Copy, paste, **Run**

### Step 5 — Get your API keys

1. In Supabase left sidebar → **Settings** (gear icon) → **API**
2. Copy these three values — you need them soon:

```
Project URL:        https://xxxxxxxxxxxx.supabase.co
anon public key:    eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
service_role key:   eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...  ← KEEP SECRET
```

### Step 6 — Enable Auth providers (optional)

For Google/GitHub login:
1. Supabase → **Authentication** → **Providers**
2. Enable **Google** — you need a Google OAuth app (console.cloud.google.com)
3. Enable **Email** (Magic Link) — already on by default

For Magic Link to work:
1. Supabase → **Authentication** → **URL Configuration**
2. Set **Site URL** to your Netlify URL (e.g. `https://ofa-academy.netlify.app`)
3. Add to **Redirect URLs**: `https://ofa-academy.netlify.app/auth/callback`

---

## PART 2 — NETLIFY SETUP (Takes ~10 min)

### Step 1 — Create Netlify account

1. Go to https://netlify.com → Sign up with GitHub
2. You MUST have your code on GitHub first (see Part 4 below)

### Step 2 — Connect your GitHub repo to Netlify

1. Netlify Dashboard → **Add new site** → **Import an existing project**
2. Choose **GitHub** → Authorize Netlify
3. Select your repository: `olufunke-fa`
4. Configure build settings:

```
Base directory:    netlify-supabase
Build command:     npm run build
Publish directory: netlify-supabase/out
Functions directory: netlify-supabase/netlify/functions
```

5. Click **Deploy site**

### Step 3 — Add environment variables in Netlify

1. Netlify → Your site → **Site configuration** → **Environment variables**
2. Click **Add a variable** for each of these:

| Variable name | Value |
|--------------|-------|
| `NEXT_PUBLIC_SUPABASE_URL` | Your Supabase Project URL |
| `NEXT_PUBLIC_SUPABASE_ANON_KEY` | Your anon public key |
| `SUPABASE_SERVICE_ROLE_KEY` | Your service_role key (SECRET) |
| `NEXT_PUBLIC_SITE_URL` | `https://your-site-name.netlify.app` |

3. After adding all variables → **Trigger deploy** → **Deploy site**

### Step 4 — Connect Netlify + Supabase integration (official)

This auto-syncs environment variables between the two platforms:

1. Netlify → Your site → **Integrations** tab
2. Search for **Supabase**
3. Click **Enable** → **Connect to Supabase**
4. Authorize the connection
5. Select your `ofa-academy` project
6. Netlify will auto-inject `SUPABASE_URL` and `SUPABASE_ANON_KEY`

---

## PART 3 — LARAVEL (Main site) DEPLOYMENT OPTIONS

Your Laravel app needs a **PHP hosting provider**. Options:

### Option A — Railway (Recommended, free tier available)
1. Go to https://railway.app → Sign up with GitHub
2. **New Project** → **Deploy from GitHub repo**
3. Select `olufunke-fa` repository
4. Railway auto-detects PHP/Laravel
5. Add environment variables (same as your `.env` but with production values)
6. Add a MySQL database: **New** → **Database** → **MySQL**
7. Railway gives you a `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### Option B — Render.com (Free tier)
1. https://render.com → New → Web Service
2. Connect GitHub → select `olufunke-fa`
3. Build command: `composer install --no-dev && php artisan migrate --force`
4. Start command: `php artisan serve --host=0.0.0.0 --port=$PORT`

### Option C — cPanel shared hosting (e.g. Hostinger, Namecheap)
1. Upload files via FTP or Git deploy
2. Point document root to `/public`
3. Create MySQL database in cPanel
4. Upload `.env` with production values

---

## PART 4 — PUSH CODE TO GITHUB

Run these commands in your project folder:

```bash
# If not already a git repo (it is, so skip this)
# git init

# Stage all files
git add .

# Commit
git commit -m "Add Netlify-Supabase integration"

# If you haven't set up GitHub remote yet:
git remote add origin https://github.com/YOUR_USERNAME/olufunke-fa.git

# Push to main branch
git push -u origin main
```

> Note: The `.env` file is in `.gitignore` so your secrets are NOT pushed to GitHub.
> You set environment variables directly in Netlify and Railway/Render dashboards.

---

## PART 5 — n8n AUTOMATION (Optional, set up last)

n8n is a workflow automation tool. Three workflows are ready in `n8n/workflows.json`:

1. **Contact form → Email** — when someone submits the contact form, you get an email
2. **New user → Welcome email** — auto-welcome email when player registers
3. **Weekly quiz reminder** — every Monday 9am, reminds all players to take the quiz

### To use n8n:
**Free option:** https://cloud.n8n.io (free trial, then ~$20/month)
**Self-hosted:** https://docs.n8n.io/hosting/

1. Sign up at https://cloud.n8n.io
2. Go to **Workflows** → **Import** → upload `n8n/workflows.json`
3. Edit each workflow and set the webhook URL from your n8n instance
4. Copy the webhook URL and add to Netlify env vars:
   - `N8N_CONTACT_WEBHOOK` = `https://your-n8n.cloud/webhook/ofa-contact`
5. Activate the workflows (toggle on)

---

## CHECKLIST — Do these in order

- [ ] 1. Create Supabase project
- [ ] 2. Run schema.sql in Supabase SQL editor
- [ ] 3. Run policies.sql in Supabase SQL editor
- [ ] 4. Run seed.sql in Supabase SQL editor
- [ ] 5. Copy Supabase API keys
- [ ] 6. Push code to GitHub
- [ ] 7. Create Netlify account
- [ ] 8. Connect GitHub repo to Netlify
- [ ] 9. Add environment variables to Netlify
- [ ] 10. Enable Netlify-Supabase integration
- [ ] 11. Deploy Laravel to Railway/Render/cPanel
- [ ] 12. Set up n8n workflows (optional)
- [ ] 13. Update Supabase Auth redirect URLs with live domain

---

## WHAT I (KIRO) BUILT — Summary of files created

### Netlify (JavaScript/Node.js)
| File | What it does |
|------|-------------|
| `netlify/netlify.toml` | Build config, redirects, security headers |
| `netlify/functions/auth-handler.js` | Handles login/OAuth callbacks from Supabase |
| `netlify/functions/players.js` | REST API — get/create/update/delete players |
| `netlify/functions/quiz.js` | REST API — quiz questions, submit answers, leaderboard |
| `netlify/functions/contact.js` | Saves contact messages + triggers n8n webhook |

### Supabase (SQL)
| File | What it does |
|------|-------------|
| `supabase/schema.sql` | Creates all database tables (players, quiz, lessons, etc.) |
| `supabase/policies.sql` | Security rules — who can read/write what |
| `supabase/seed.sql` | Sample data to test with |
| `supabase/supabase-client.js` | Server-side database connection factory |

### Next.js Frontend (JavaScript/React)
| File | What it does |
|------|-------------|
| `src/pages/index.js` | Home page — shows players, fixtures, results |
| `src/pages/login.js` | Login with magic link or Google/GitHub |
| `src/pages/dashboard.js` | Player dashboard — progress, quiz scores |
| `src/pages/quiz.js` | Weekly quiz with leaderboard |
| `src/lib/supabaseClient.js` | Browser database connection |
| `src/lib/api.js` | Helper functions to call Netlify serverless functions |

### n8n (JSON config)
| File | What it does |
|------|-------------|
| `n8n/workflows.json` | 3 automation workflows — contact, welcome email, quiz reminder |
