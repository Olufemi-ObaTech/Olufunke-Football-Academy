# ⚽ Olufunke Football Academy — Official Website

<p align="center">
  <img src="netlify-supabase/public/images/OFA New Logo.jpg" width="120" alt="OFA Logo" style="border-radius:50%;" />
</p>

<p align="center">
  <strong>Chasing Excellence, Inspiring Futures</strong><br/>
  <a href="https://olufunkefootballacademy.com">olufunkefootballacademy.com</a>
</p>

---

## About

**Olufunke Football Academy (OFA)** is a FIFA TMS-registered, LSFA-affiliated football academy based in Lagos, Nigeria. Founded in September 2023 under RC-7147523, OFA discovers and nurtures young footballers into better athletes and better people.

This repository contains the official OFA website — a **Next.js 14** application deployed on **Netlify** with **Supabase** as the backend.

## Features

- 🏠 **Public Pages** — Home, About Us, Contact, Our Store
- 🧠 **Football IQ Quiz** — Weekly quizzes with live leaderboards (open to all, no login required)
- 🔐 **Player Portal** — Registration, login (email/password, magic link, Google, GitHub)
- 📊 **Player Dashboard** — Progress tracking, course completion, quiz history
- 🎓 **Football Education** — E-learning platform with modular courses and lessons
- ⚽ **Our Program** — Training details, team formation, tournament info
- 👨‍💼 **Admin Panel** — Player management, quiz creation, news/spotlight management, league results
- 📰 **News & Media** — Latest news, match reports, highlight videos
- 📊 **League Standings** — 2026/27 LSFA State League scoreboard

## Tech Stack

| Layer | Technology |
|-------|------------|
| Frontend | Next.js 14, React 18, Bootstrap 5 |
| Backend | Supabase (PostgreSQL + Auth + Storage) |
| Serverless | Netlify Functions (Node.js) |
| Hosting | Netlify |
| CI/CD | GitHub Actions |
| Domain | olufunkefootballacademy.com |

## Project Structure

```
olufunke-fa/
├── netlify-supabase/          ← Next.js app (deployed to Netlify)
│   ├── netlify/functions/     ← Serverless API functions
│   │   ├── _shared/           ← Shared security utilities
│   │   ├── auth-handler.js    ← OAuth/magic link callback
│   │   ├── contact.js         ← Contact form submissions
│   │   ├── players.js         ← Player CRUD API
│   │   └── quiz.js            ← Quiz engine + leaderboard
│   ├── public/images/         ← Static images
│   ├── src/
│   │   ├── components/        ← NavBar, Footer, QuizCTA
│   │   ├── lib/               ← Supabase client, API helpers, security
│   │   ├── pages/             ← All pages (Next.js file-based routing)
│   │   └── styles/            ← Global CSS
│   ├── supabase/              ← SQL schemas, seed data, RLS policies
│   ├── netlify.toml           ← Build config, redirects, security headers
│   └── package.json
├── app/                       ← Laravel backend (PHP)
├── routes/                    ← Laravel routes
└── resources/                 ← Laravel views
```

## Security

- 🔒 **HTTPS** — Enforced via HSTS headers
- 🛡️ **CSP** — Content Security Policy restricting script/style sources
- 🚫 **XSS Protection** — Input sanitization on all user inputs (client + server)
- 📛 **CORS** — Origin-validated headers on all API functions
- ⏱️ **Rate Limiting** — IP-based rate limiting on all serverless functions
- 🔐 **Auth** — Supabase Auth with email/password, magic link, Google, GitHub
- 🛑 **Open Redirect Prevention** — Auth handler validates redirect destinations
- 📋 **RLS** — Row Level Security policies on all Supabase tables

## Deployment

### Prerequisites
- Node.js 20+
- Netlify account with site connected
- Supabase project with schema deployed

### Environment Variables (set in Netlify Dashboard)

| Variable | Description |
|----------|-------------|
| `NEXT_PUBLIC_SUPABASE_URL` | Supabase project URL |
| `NEXT_PUBLIC_SUPABASE_ANON_KEY` | Supabase public anon key |
| `SUPABASE_SERVICE_ROLE_KEY` | Supabase service role key (secret) |
| `NEXT_PUBLIC_SITE_URL` | `https://olufunkefootballacademy.com` |

### GitHub Secrets (for CI/CD)

| Secret | Description |
|--------|-------------|
| `NETLIFY_AUTH_TOKEN` | Netlify personal access token |
| `NETLIFY_SITE_ID` | Netlify site ID |
| `NEXT_PUBLIC_SUPABASE_URL` | Supabase project URL |
| `NEXT_PUBLIC_SUPABASE_ANON_KEY` | Supabase public anon key |
| `SUPABASE_SERVICE_ROLE_KEY` | Supabase service role key |

### Custom Domain

1. In Netlify → **Domain Management** → Add `olufunkefootballacademy.com`
2. Update DNS records as directed by Netlify
3. Netlify auto-provisions free SSL/HTTPS
4. In Supabase → **Authentication** → **URL Configuration**:
   - Site URL: `https://olufunkefootballacademy.com`
   - Redirect URLs: `https://olufunkefootballacademy.com/auth/callback`

## Contact

- **Email:** Olufunkefootballacademy@gmail.com
- **Phone:** 09079917993
- **YouTube:** [@olufunkefootballacademy](https://www.youtube.com/@olufunkefootballacademy)
- **Facebook:** [Olufunke Football Academy](https://web.facebook.com/people/Olufunke-Football-Academy/61554694136830/)
- **Instagram:** [@olufunkefootballacademy](https://www.instagram.com/olufunkefootballacademy)

## License

© 2026 Olufunke Football Academy. All rights reserved.
