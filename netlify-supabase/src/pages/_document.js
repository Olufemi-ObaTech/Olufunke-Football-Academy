import { Html, Head, Main, NextScript } from 'next/document';

/**
 * Custom _document — loads Bootstrap CSS/JS globally so NavBar works on all pages
 * and doesn't inject <link>/<script> tags inside component bodies (invalid HTML).
 */
export default function Document() {
  return (
    <Html lang="en">
      <Head>
        {/* Bootstrap Icons */}
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        />
        {/* Bootstrap CSS */}
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        />
        {/* Google Fonts */}
        <link
          href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap"
          rel="stylesheet"
        />
      </Head>
      <body>
        <Main />
        <NextScript />
        {/* Bootstrap JS Bundle — loaded after content, enables navbar toggler etc. */}
        <script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          defer
        />
      </body>
    </Html>
  );
}
