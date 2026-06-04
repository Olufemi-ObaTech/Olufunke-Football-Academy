-- ============================================================
-- OFA Academy — 3 Additional Courses
-- Run AFTER seed.sql
-- ============================================================

INSERT INTO public.courses (title, description, image_path, category, target_audience, cta_label, is_published)
VALUES
  ('Goalkeeping Masterclass',
   'Dedicated training for goalkeepers covering shot-stopping, distribution, positioning, and commanding the penalty area. From basics to advanced GK techniques.',
   'images/OFA 1.jpg', 'technical', 'player', 'Start GK Training', TRUE),

  ('Coaching and Refereeing Fundamentals',
   'For aspiring coaches and referees. Covers session planning, player communication, laws of the game application, and how to manage a team effectively.',
   'images/Technical Training.jpg', 'education', 'coach', 'Start Coaching', TRUE),

  ('Fitness and Conditioning',
   'Sport-specific fitness for footballers. Sprint training, agility, endurance, strength, and recovery. Build the physical foundation to compete at any level.',
   'images/OFA 1.jpg', 'health', 'both', 'Start Training', TRUE);
