import { Html, Head, Main, NextScript } from 'next/document';

/**
 * Custom _document — loads Bootstrap CSS/JS globally, adds security
 * meta tags, and ensures proper SEO/accessibility settings.
 */
export default function Document() {
  return (
    <Html lang="en">
      <Head>
        {/* Security meta tags */}
        <meta httpEquiv="X-UA-Compatible" content="IE=edge" />
        <meta name="robots" content="index, follow" />
        <meta name="author" content="Olufunke Football Academy" />
        <meta name="description" content="Olufunke Football Academy — Nigeria's next footballing powerhouse. FIFA TMS registered, LSFA affiliated. Chasing Excellence, Inspiring Futures." />

        {/* Favicon */}
        <link rel="icon" href="/images/OFA New Logo.jpg" type="image/jpeg" />

        {/* Bootstrap Icons */}
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        />
        {/* Bootstrap CSS */}
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YcnS/1p7q6NILS90RAokGFnL9pVIGQlesYsp"
          crossOrigin="anonymous"
        />
        {/* Google Fonts — Montserrat */}
        <link
          href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap"
          rel="stylesheet"
        />
      </Head>
      <body>
        <Main />
        <NextScript />
        {/* Bootstrap JS Bundle — loaded after content */}
        <script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
          crossOrigin="anonymous"
          defer
        />
      </body>
    </Html>
  );
}
