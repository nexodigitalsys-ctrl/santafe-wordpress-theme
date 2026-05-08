# Santa Fe Pre-Deploy Checklist

Validate these URLs before publishing:

- `/es/`
- `/es/contacto/`
- `/es/servicios/`
- `/es/proyectos/`
- `/es/sobre-nosotros/`
- `/es/obra-nueva/`
- `/es/reformas-integrales/`
- `/es/pladur-acabados/`
- `/es/reformas-barcelona/`
- `/es/blog/`
- `/sitemap.xml`
- `/robots.txt`

Checks:

- No mojibake characters are visible.
- Header phone and WhatsApp links work on mobile.
- Contact form works with JavaScript enabled and disabled.
- Unknown routes return the 404 template with HTTP 404.
- Cookie banner appears for new visitors and loads GA4/GTM only after consent.
- Canonical URLs use `COMPANY_DOMAIN`.
- JSON-LD validates for LocalBusiness, Service, FAQPage and BreadcrumbList.
- `nexodigital.sys@gmail.com` is configured as the email fallback.
- Telegram env vars are configured outside Git: `SANTAFE_TELEGRAM_BOT_TOKEN` and `SANTAFE_TELEGRAM_CHAT_ID`.
- `/robots.txt` returns `Allow: /` and references `/sitemap.xml`.
- `/sitemap.xml` returns HTTP 200 with `loc`, `lastmod` and `priority`.
