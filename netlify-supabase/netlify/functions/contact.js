/**
 * Netlify Function: contact.js
 * ─────────────────────────────
 * Saves contact form submissions to Supabase contact_messages table.
 * Can also be wired to n8n for email notifications.
 *
 * POST body: { name, email, subject, message }
 */

const { createClient } = require('@supabase/supabase-js');

const supabase = createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

function json(statusCode, body) {
  return {
    statusCode,
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': process.env.NEXT_PUBLIC_SITE_URL || '*',
    },
    body: JSON.stringify(body),
  };
}

exports.handler = async (event) => {
  // Handle CORS preflight
  if (event.httpMethod === 'OPTIONS') {
    return { statusCode: 204, headers: { 'Access-Control-Allow-Origin': '*' }, body: '' };
  }

  if (event.httpMethod !== 'POST') {
    return json(405, { error: 'Method not allowed' });
  }

  try {
    const { name, email, subject, message } = JSON.parse(event.body || '{}');

    // ── Input validation ─────────────────────────────────────────
    if (!name || !email || !message) {
      return json(400, { error: 'name, email, and message are required' });
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      return json(400, { error: 'Invalid email address' });
    }

    // ── Save to Supabase ─────────────────────────────────────────
    const { data, error } = await supabase
      .from('contact_messages')
      .insert([{ name, email, subject: subject || 'General Enquiry', message }])
      .select()
      .single();

    if (error) throw error;

    // ── Trigger n8n webhook (optional) ──────────────────────────
    // Set N8N_CONTACT_WEBHOOK in Netlify env vars to enable
    if (process.env.N8N_CONTACT_WEBHOOK) {
      try {
        await fetch(process.env.N8N_CONTACT_WEBHOOK, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, email, subject, message, id: data.id }),
        });
      } catch (webhookErr) {
        // Non-fatal — log but don't fail the request
        console.warn('[contact] n8n webhook failed:', webhookErr.message);
      }
    }

    return json(201, {
      message: 'Your message has been received. We will get back to you soon.',
      id: data.id,
    });

  } catch (err) {
    console.error('[contact function]', err);
    return json(500, { error: 'Failed to save message. Please try again.' });
  }
};
