-- ============================================================
-- Make a user an Admin in Supabase
-- Run in: Supabase → SQL Editor
-- Replace the email below with your actual admin email
-- ============================================================

-- Step 1: Find the user UUID from their email
SELECT id, email FROM auth.users WHERE email = 'Olufunkefootballacademy@gmail.com';

-- Step 2: Set them as admin (replace UUID from step 1)
UPDATE public.profiles
SET role   = 'admin',
    status = 'approved'
WHERE id = (
  SELECT id FROM auth.users
  WHERE email = 'Olufunkefootballacademy@gmail.com'
  LIMIT 1
);

-- Step 3: Verify
SELECT p.id, u.email, p.role, p.status
FROM public.profiles p
JOIN auth.users u ON p.id = u.id
WHERE p.role = 'admin';

-- ============================================================
-- To reset admin password via Supabase:
-- 1. Go to Supabase → Authentication → Users
-- 2. Find the email, click the 3-dot menu
-- 3. Click "Send password reset" to send a reset email
-- OR use the magic link to log in without a password
-- ============================================================
