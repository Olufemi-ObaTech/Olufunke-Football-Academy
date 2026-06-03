/** @type {import('next').NextConfig} */
const nextConfig = {
  // Do NOT use 'export' — Netlify needs SSR mode for functions + auth
  // @netlify/plugin-nextjs handles the deployment automatically

  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: '*.supabase.co',
        pathname: '/storage/v1/object/public/**',
      },
    ],
  },
};

module.exports = nextConfig;
