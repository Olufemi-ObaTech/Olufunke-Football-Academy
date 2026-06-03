# Netlify + Supabase Integration — OFA Academy

This folder contains the complete Netlify frontend (Next.js) + Supabase backend integration.

## Folder Structure

```
netlify-supabase/
├── netlify/                   # Netlify-specific config & serverless functions
│   ├── functions/             # Netlify serverless functions (Node.js)
│   │   ├── auth-handler.js
│   │   ├── players.js
│   │   ├── quiz.js
│   │   └── contact.js
│   └── netlify.toml           # Netlify build & redirect config
│
├── supabase/                  # Supabase-specific config & SQL
│   ├── schema.sql             # Full database schema
│   ├── seed.sql               # Seed data
│   ├── policies.sql           # Row Level Security (RLS) policies
│   └── supabase-client.js     # Supabase JS client (shared)
│
├── src/                       # Next.js frontend source
│   ├── pages/
│   │   ├── index.js           # Home
│   │   ├── login.js           # Auth login page
│   │   ├── dashboard.js       # Player dashboard
│   │   ├── quiz.js            # Quiz page
│   │   └── api/               # Next.js API routes (alternative to Netlify functions)
│   ├── components/
│   │   ├── Auth/
│   │   ├── Dashboard/
│   │   └── Quiz/
│   └── lib/
│       ├── supabaseClient.js  # Supabase browser client
│       └── api.js             # API helpers
│
├── n8n/                       # n8n workflow automation configs
│   └── workflows.json         # Exported n8n workflows
│
├── .env.example               # Environment variables template
├── package.json
└── next.config.js
```

## Quick Start

1. Copy `.env.example` to `.env.local` and fill in your keys
2. `npm install`
3. Push Supabase schema: run `supabase/schema.sql` in your Supabase SQL editor
4. `npm run dev` for local, or deploy to Netlify

## Environment Variables

| Variable | Where to get it |
|---|---|
| NEXT_PUBLIC_SUPABASE_URL | Supabase Dashboard → Settings → API |
| NEXT_PUBLIC_SUPABASE_ANON_KEY | Supabase Dashboard → Settings → API |
| SUPABASE_SERVICE_ROLE_KEY | Supabase Dashboard → Settings → API (secret) |
| NETLIFY_SITE_ID | Netlify Dashboard → Site Settings |
