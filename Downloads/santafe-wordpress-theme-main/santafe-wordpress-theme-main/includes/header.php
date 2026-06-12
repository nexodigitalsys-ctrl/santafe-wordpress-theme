<?php
/**
 * Header semántico con Tailwind CSS
 * Incluir al inicio de cada página con $page_data configurado
 */

declare(strict_types=1);

require_once __DIR__ . '/i18n.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/seo.php';
require_once __DIR__ . '/schema-localbusiness.php';
require_once __DIR__ . '/schema-faq.php';
require_once __DIR__ . '/schema-reviews.php';

// Iniciar sesión segura
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(['lifetime' => 3600, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Strict']);
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = wp_create_nonce('santafe_contact_form');
}

$lang = isset($page_data['lang']) && in_array($page_data['lang'], ['es','ca'], true) ? $page_data['lang'] : 'es';
$page_data = santafe_normalize_seo_data($page_data ?? [], $current_route ?? '', $lang);
$translations = load_translations($lang);
$locale = $lang === 'ca' ? 'ca_ES' : 'es_ES';
$alt_lang = $lang === 'ca' ? 'es' : 'ca';
$alt_locale = $alt_lang === 'ca' ? 'ca_ES' : 'es_ES';

$domain = COMPANY_DOMAIN;
$page_title = htmlspecialchars($page_data['title'], ENT_QUOTES, 'UTF-8');
$page_desc = htmlspecialchars($page_data['description'], ENT_QUOTES, 'UTF-8');
$canonical = htmlspecialchars($page_data['canonical'] ?? ($domain . '/' . $lang . '/'), ENT_QUOTES, 'UTF-8');
$alt_canonical = str_replace('/' . $lang . '/', '/' . $alt_lang . '/', $canonical);

$schema_localbusiness = get_schema_localbusiness($domain);
$schema_blocks = [];
if (!empty($page_data['schemas'])) {
    foreach ($page_data['schemas'] as $schema_fn) {
        $json = '';
        if (is_callable($schema_fn)) $json = $schema_fn();
        elseif (is_string($schema_fn)) $json = $schema_fn;
        if ($json && trim($json)) $schema_blocks[] = trim($json);
    }
}

$og_image = get_og_image($current_route ?? '', $lang);

// Helper para links de idioma alternativo
function get_alt_url($current_route, $target_lang) {
    $es_map = [
        '' => '',
        'servicios' => 'serveis',
        'servicios/obra-nueva' => 'serveis/obra-nova',
        'servicios/reformas-integrales' => 'serveis/reformes-integrals',
        'servicios/pladur-acabados' => 'serveis/pladur-acabats',
        'servicios/obra-publica' => 'serveis/obra-publica',
        'servicios/obra-civil' => 'serveis/obra-civil',
        'servicios/parquet-pavimentos' => 'serveis/parquet-paviments',
        'servicios/reformas-banos' => 'serveis/reformes-banys',
        'servicios/rehabilitacion-fachadas' => 'serveis/rehabilitacio-facanes',
        'servicios/reformas-comerciales' => 'serveis/reformes-comercials',
        'obra-nueva' => 'obra-nova',
        'reformas-integrales' => 'reformes-integrals',
        'pladur-acabados' => 'pladur-acabats',
        'obra-publica' => 'obra-publica',
        'obra-civil' => 'obra-civil',
        'proyectos' => 'projectes',
        'sobre-nosotros' => 'sobre-nosaltres',
        'contacto' => 'contacte',
        'aviso-legal' => 'avis-legal',
        'politica-privacidad' => 'politica-privacitat',
        'politica-cookies' => 'politica-cookies',
    ];
    $ca_map = array_flip($es_map);
    $route = trim($current_route, '/');
    if ($target_lang === 'ca') {
        $target_route = isset($es_map[$route]) ? $es_map[$route] : $route;
    } else {
        $target_route = isset($ca_map[$route]) ? $ca_map[$route] : $route;
    }
    return '/' . $target_lang . '/' . ($target_route ? $target_route . '/' : '');
}

$alt_url = get_alt_url($current_route ?? '', $alt_lang);
$nav_services_path = $lang === 'ca' ? 'serveis' : 'servicios';
$nav_projects_path = $lang === 'ca' ? 'projectes' : 'proyectos';
$nav_about_path = $lang === 'ca' ? 'sobre-nosaltres' : 'sobre-nosotros';
$nav_contact_path = $lang === 'ca' ? 'contacte' : 'contacto';
?>
<!DOCTYPE html>
<html lang="<?php echo $locale; ?>" class="scroll-smooth no-js">
<head>
<script>(function(d){d.classList.remove('no-js');d.classList.add('js');})(document.documentElement);</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?php echo $page_title; ?></title>
<meta name="description" content="<?php echo $page_desc; ?>">
<meta name="robots" content="<?php echo isset($page_data['robots']) ? htmlspecialchars($page_data['robots'], ENT_QUOTES, 'UTF-8') : 'index, follow'; ?>">
<meta name="author" content="Construcciones Santa Fe Siglo XXI SLU">
<meta name="geo.region" content="ES-CT">
<meta name="geo.placename" content="Barcelona, Girona">

<?php if ($canonical): ?>
<link rel="canonical" href="<?php echo $canonical; ?>">
<link rel="alternate" hreflang="<?php echo $locale; ?>" href="<?php echo $canonical; ?>">
<link rel="alternate" hreflang="<?php echo $alt_locale; ?>" href="<?php echo $domain . $alt_url; ?>">
<?php endif; ?>
<link rel="alternate" hreflang="x-default" href="<?php echo $domain . '/es/'; ?>">

<meta property="og:title" content="<?php echo $page_title; ?>">
<meta property="og:description" content="<?php echo $page_desc; ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo $canonical; ?>">
<meta property="og:image" content="<?php echo $og_image; ?>">
<meta property="og:locale" content="<?php echo $locale; ?>">
<meta property="og:site_name" content="Construcciones Santa Fe Siglo XXI SLU">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $page_title; ?>">
<meta name="twitter:description" content="<?php echo $page_desc; ?>">
<meta name="twitter:image" content="<?php echo $og_image; ?>">

<link rel="icon" href="/assets/images/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.svg">

<!-- Performance: preconnect critical origins -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">

<!-- Fonts with display=swap for fast text rendering -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Tailwind CSS v4 — Built locally, 49KB minified vs 3MB CDN -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/tailwind-built.css">

<style>
  /* CSS Custom Properties for z-index layers — Centralized management
   * @see https://css-tricks.com/z-index-and-stacking-context/
   */
  :root {
    /* Z-index layers */
    --z-dropdown: 10;
    --z-sticky-cta: 40;
    --z-mobile-menu: 40;
    --z-section-dots: 40;
    --z-header: 50;
    --z-whatsapp-float: 100;
    --z-cookie-banner: 200;
    --z-cookie-settings: 210;
    --z-skip-link: 1000;
    --z-scroll-progress: 9999;

    /* Brand colors */
    --color-brand: #AE232A;
    --color-brand-light: #dc2626;
    --color-brand-hover: #b91c1c;
    --color-brand-dark: #991b1b;

    /* Button primary (red bg, white text) */
    --btn-primary-bg: var(--color-brand-light);
    --btn-primary-bg-hover: var(--color-brand-hover);
    --btn-primary-text: #ffffff;

    /* Button secondary (transparent/outline, white text) */
    --btn-secondary-bg: transparent;
    --btn-secondary-border: rgba(255,255,255,0.3);
    --btn-secondary-border-hover: rgba(255,255,255,0.6);
    --btn-secondary-text: #ffffff;

    /* Scroll progress */
    --scroll-progress-start: var(--color-brand);
    --scroll-progress-end: #f87171;
    --color-accent-hover: #f87171;
    --color-accent-hover-light: #fca5a5;

    /* Industrial line */
    --industrial-line-color: var(--color-brand);

    /* ========== SECTION: HERO ========== */
    --hero-bg-overlay-start: #020617;
    --hero-bg-overlay-mid: rgba(2, 6, 23, 0.92);
    --hero-bg-overlay-end: rgba(2, 6, 23, 0.65);
    --hero-bg-overlay-top: rgba(2, 6, 23, 0.60);
    --hero-bg-overlay-vignette: rgba(255, 255, 255, 0.25);
    --hero-text-primary: #ffffff;
    --hero-text-secondary: #d4d4d4;
    --hero-text-tertiary: #a3a3a3;
    --hero-accent: #f87171;
    --hero-badge-text: #f87171;
    --hero-btn-primary-bg: var(--color-brand);
    --hero-btn-primary-hover: var(--color-brand-hover);
    --hero-btn-primary-text: #ffffff;
    --hero-btn-secondary-border: rgba(255,255,255,0.3);
    --hero-btn-secondary-border-hover: rgba(255,255,255,0.6);
    --hero-btn-secondary-text: #ffffff;
    --hero-scroll-indicator: rgba(255,255,255,0.7);

    /* ========== SECTION: TESTIMONIOS ========== */
    --testimonios-bg: #ffffff;
    --testimonios-text-title: #1a1a1a;
    --testimonios-text-body: #6b6b6b;
    --testimonios-text-secondary: #525252;
    --testimonios-border-top: rgba(245, 158, 11, 0.4);
    --testimonios-badge-bg: rgba(245, 158, 11, 0.1);
    --testimonios-badge-text: #d97706;
    --testimonios-badge-border: rgba(245, 158, 11, 0.2);
    --testimonios-card-bg: rgba(255, 255, 255, 0.8);
    --testimonios-card-border: #e5e5e5;
    --testimonios-card-shadow: 0 4px 20px rgba(0,0,0,0.08);
    --testimonios-card-shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
    --testimonios-arrow-bg: rgba(245, 245, 244, 0.9);
    --testimonios-arrow-border: #d4d4d4;
    --testimonios-arrow-text: #737373;
    --testimonios-arrow-hover-text: var(--color-brand);
    --testimonios-arrow-hover-border: var(--color-brand);
    --testimonios-dot-active: var(--color-brand);
    --testimonios-dot-inactive: #e5e5e5;
    --testimonios-avatar-bg-start: var(--color-brand);
    --testimonios-avatar-bg-end: #7f1d1d;
    --testimonios-imperfection-bg: #fffbeb;
    --testimonios-imperfection-border: #fde68a;
    --testimonios-imperfection-text: #d97706;
    --testimonios-link-text: #737373;
    --testimonios-link-hover: #d97706;

    /* ========== SECTION: CTA FINAL ========== */
    --cta-bg-start: var(--color-brand);
    --cta-bg-end: #7f1d1d;
    --cta-text-primary: #ffffff;
    --cta-text-secondary: rgba(255,255,255,0.8);
    --cta-pattern-opacity: 0.05;
    --cta-btn-bg: #ffffff;
    --cta-btn-text: var(--color-brand);
    --cta-btn-hover-bg: #fef2f2;
    --cta-btn-outline-border: rgba(255,255,255,0.3);
    --cta-btn-outline-border-hover: rgba(255,255,255,0.6);
    --cta-btn-outline-text: #ffffff;

    /* ========== SECTION: SERVICIOS ========== */
    --servicios-bg: #ffffff;
    --servicios-text-title: #1a1a1a;
    --servicios-text-body: #6b6b6b;
    --servicios-badge-text: #f87171;
    --servicios-card-bg: #ffffff;
    --servicios-card-border: #e5e5e5;
    --servicios-card-hover-border: rgba(174, 35, 42, 0.3);
    --servicios-card-icon-bg: rgba(174, 35, 42, 0.9);
    --servicios-card-icon-text: #ffffff;
    --servicios-link-text: #ef4444;
    --servicios-link-hover: #f87171;
    --servicios-cta-card-bg: rgba(69, 10, 10, 0.3);
    --servicios-cta-card-border: rgba(69, 10, 10, 0.5);
    --servicios-cta-card-text: #f87171;
    --servicios-cta-card-title: #ffffff;

    /* ========== SECTION: PORTFOLIO ========== */
    --portfolio-bg: #faf9f7;
    --portfolio-text-title: #1a1a1a;
    --portfolio-text-body: #6b6b6b;
    --portfolio-badge-text: #f87171;
    --portfolio-border: #e5e5e5;
    --portfolio-filter-active-bg: var(--color-brand);
    --portfolio-filter-active-border: var(--color-brand);
    --portfolio-filter-active-text: #ffffff;
    --portfolio-filter-inactive-border: #d4d4d4;
    --portfolio-filter-inactive-text: #525252;
    --portfolio-card-bg: #ffffff;
    --portfolio-card-border: #e5e5e5;
    --portfolio-card-tag-bg: var(--color-brand);
    --portfolio-card-tag-text: #ffffff;
    --portfolio-card-meta-text: #737373;
    --portfolio-card-link-text: #ef4444;
    --portfolio-card-link-hover: #f87171;

    /* ========== SECTION: PROCESO ========== */
    --proceso-bg: #ffffff;
    --proceso-text-title: #1a1a1a;
    --proceso-text-body: #6b6b6b;
    --proceso-badge-text: #f87171;
    --proceso-card-bg: #ffffff;
    --proceso-card-border: #e5e5e5;
    --proceso-card-hover-border: rgba(174, 35, 42, 0.3);
    --proceso-step-num: #404040;
    --proceso-step-num-hover: rgba(69, 10, 10, 0.4);
    --proceso-icon-bg: rgba(69, 10, 10, 0.4);
    --proceso-icon-text: #fbbf24;
    --proceso-connector: #e5e5e5;
    --proceso-connector-hover: rgba(69, 10, 10, 0.5);
    --proceso-guarantee-bg: #ffffff;
    --proceso-guarantee-border: #e5e5e5;

    /* ========== SECTION: FAQ ========== */
    --faq-bg: #ffffff;
    --faq-text-title: #1a1a1a;
    --faq-text-body: #737373;
    --faq-badge-text: #f87171;
    --faq-card-bg: #ffffff;
    --faq-card-border: #e5e5e5;
    --faq-card-hover-border: #d4d4d4;
    --faq-question-text: #1a1a1a;
    --faq-question-hover: var(--color-brand);
    --faq-icon-bg: #f5f5f4;
    --faq-icon-text: #737373;
    --faq-icon-hover-bg: var(--color-brand);
    --faq-icon-hover-text: #ffffff;
    --faq-answer-text: #525252;
    --faq-cta-bg: var(--color-brand);
    --faq-cta-hover: var(--color-brand-hover);
    --faq-cta-text: #ffffff;

    /* ========== SECTION: GARANTIAS ========== */
    --garantias-bg: #faf9f7;
    --garantias-text-title: #1a1a1a;
    --garantias-text-body: #737373;
    --garantias-badge-text: #f87171;
    --garantias-card-bg: #ffffff;
    --garantias-card-border: #e5e5e5;
    --garantias-card-hover-border: rgba(174, 35, 42, 0.3);
    --garantias-icon-bg: #fef2f2;
    --garantias-icon-text: var(--color-brand);
    --garantias-icon-hover-bg: #fee2e2;

    /* ========== SECTION: CONTACTO ========== */
    --contacto-bg: #ffffff;
    --contacto-text-title: #1a1a1a;
    --contacto-text-body: #525252;
    --contacto-badge-text: #f87171;
    --contacto-form-bg: #faf9f7;
    --contacto-form-border: #e5e5e5;
    --contacto-label-text: #737373;
    --contacto-input-bg: #ffffff;
    --contacto-input-border: #d4d4d4;
    --contacto-input-text: #1a1a1a;
    --contacto-info-title: #1a1a1a;
    --contacto-info-icon-bg: #f5f5f4;
    --contacto-info-icon-text: #ef4444;
    --contacto-info-icon-hover: #fef2f2;
    --contacto-info-text: #1a1a1a;
    --contacto-info-label: #737373;
    --contacto-financing-bg-start: var(--color-brand);
    --contacto-financing-bg-end: #b91c1c;
    --contacto-financing-text: #ffffff;
    --contacto-map-border: #e5e5e5;
    --contacto-submit-bg: var(--color-brand);
    --contacto-submit-hover: var(--color-brand-hover);
    --contacto-submit-text: #ffffff;

    /* ========== SECTION: CALCULADORA ========== */
    --calculadora-bg: #ffffff;
    --calculadora-text-title: #1a1a1a;
    --calculadora-text-body: #6b6b6b;
    --calculadora-badge-text: #f87171;
    --calculadora-form-bg: #faf9f7;
    --calculadora-form-border: #e5e5e5;
    --calculadora-label-text: #737373;
    --calculadora-input-bg: #ffffff;
    --calculadora-input-border: #d4d4d4;
    --calculadora-input-text: #404040;
    --calculadora-result-bg: #ffffff;
    --calculadora-result-border: #e5e5e5;
    --calculadora-result-label: #737373;
    --calculadora-result-value: #1a1a1a;
    --calculadora-cta-bg: var(--color-brand);
    --calculadora-cta-hover: var(--color-brand-hover);
    --calculadora-cta-text: #ffffff;
    --calculadora-whatsapp-border: #d4d4d4;
    --calculadora-whatsapp-hover: var(--color-brand);
    --calculadora-whatsapp-text: #404040;

    /* ========== SECTION: DORES/SOLUCOES ========== */
    --dores-bg: #ffffff;
    --dores-text-title: #1a1a1a;
    --dores-text-body: #6b6b6b;
    --dores-badge-text: #f87171;
    --dores-item-bg: #ffffff;
    --dores-item-border: #e5e5e5;
    --dores-item-icon-bg: rgba(69, 10, 10, 0.5);
    --dores-item-icon-stroke: #AE232A;
    --dores-item-text: #404040;
    --dores-link-text: #ef4444;
    --dores-link-hover: #f87171;

    /* ========== SECTION: SOBRE NOSOTROS (PAULO) ========== */
    --sobre-bg: #faf9f7;
    --sobre-text-title: #1a1a1a;
    --sobre-text-subtitle: #f87171;
    --sobre-text-body: #525252;
    --sobre-badge-text: #f87171;
    --sobre-stat-bg: rgba(15, 23, 42, 0.7);
    --sobre-stat-border: rgba(251, 191, 36, 0.25);
    --sobre-stat-value: #ffffff;
    --sobre-stat-label: #cbd5e1;
    --sobre-eeat-bg: #ffffff;
    --sobre-eeat-border: #e5e5e5;
    --sobre-eeat-title: #1a1a1a;
    --sobre-eeat-body: #737373;
    --sobre-values-bg: #faf9f7;
    --sobre-values-border: #e5e5e5;
    --sobre-values-title: #1a1a1a;
    --sobre-values-body: #737373;
    --sobre-value-dot: var(--color-brand);
    --sobre-value-name: #1a1a1a;
    --sobre-value-desc: #737373;
    --sobre-cta-text: #fbbf24;
    --sobre-cta-hover: #f87171;
    --sobre-float-bg: var(--color-brand);
    --sobre-float-text: #ffffff;
    --sobre-image-bg: #f5f5f4;

    /* ========== SECTION: BEFORE/AFTER ========== */
    --beforeafter-bg: #ffffff;
    --beforeafter-text-title: #1a1a1a;
    --beforeafter-text-body: #737373;
    --beforeafter-badge-bg: rgba(174, 35, 42, 0.1);
    --beforeafter-badge-text: #f87171;
    --beforeafter-badge-border: rgba(174, 35, 42, 0.2);
    --beforeafter-border-top: rgba(174, 35, 42, 0.4);
    --beforeafter-handle-bg: #ffffff;
    --beforeafter-handle-text: #1a1a1a;
    --beforeafter-after-label-bg: var(--color-brand);
    --beforeafter-after-label-text: #ffffff;
    --beforeafter-before-label-bg: #f5f5f4;
    --beforeafter-before-label-text: #1a1a1a;
    --beforeafter-caption-text: #737373;

    /* ========== SECTION: GOOGLE REVIEWS ========== */
    --reviews-bg: #faf9f7;
    --reviews-text-title: #1a1a1a;
    --reviews-badge-bg: rgba(59, 130, 246, 0.1);
    --reviews-badge-text: #60a5fa;
    --reviews-badge-border: rgba(59, 130, 246, 0.2);
    --reviews-rating-text: #1a1a1a;
    --reviews-card-bg: #ffffff;
    --reviews-card-avatar-start: #3b82f6;
    --reviews-card-avatar-end: #1d4ed8;
    --reviews-card-avatar-text: #ffffff;
    --reviews-card-author: #1a1a1a;
    --reviews-card-text: #737373;
    --reviews-verified-icon: #22c55e;
    --reviews-verified-text: #737373;
    --reviews-link-text: #60a5fa;
    --reviews-link-hover: #93c5fd;
  }

  /* Dark mode overrides for section tokens */
  html.dark {
    --testimonios-bg: #1e293b;
    --testimonios-text-title: #e2e8f0;
    --testimonios-text-body: #94a3b8;
    --testimonios-text-secondary: #94a3b8;
    --testimonios-card-bg: rgba(30, 41, 59, 0.9);
    --testimonios-card-border: #334155;
    --testimonios-arrow-bg: rgba(30, 41, 59, 0.9);
    --testimonios-arrow-border: #334155;
    --testimonios-arrow-text: #94a3b8;
    --testimonios-dot-inactive: #334155;
    --testimonios-imperfection-bg: rgba(245, 158, 11, 0.1);
    --testimonios-imperfection-border: rgba(245, 158, 11, 0.3);
    --testimonios-link-text: #94a3b8;
    /* Dark mode: remaining sections */
    --servicios-bg: #1e293b;
    --servicios-text-title: #e2e8f0;
    --servicios-text-body: #94a3b8;
    --servicios-card-bg: rgba(30, 41, 59, 0.9);
    --servicios-card-border: #334155;
    --servicios-cta-card-bg: rgba(15, 23, 42, 0.5);
    --servicios-cta-card-border: #334155;
    --portfolio-bg: #0f172a;
    --portfolio-text-title: #e2e8f0;
    --portfolio-text-body: #94a3b8;
    --portfolio-card-bg: #1e293b;
    --portfolio-card-border: #334155;
    --portfolio-filter-inactive-border: #334155;
    --portfolio-filter-inactive-text: #94a3b8;
    --proceso-bg: #1e293b;
    --proceso-text-title: #e2e8f0;
    --proceso-text-body: #94a3b8;
    --proceso-card-bg: rgba(30, 41, 59, 0.9);
    --proceso-card-border: #334155;
    --proceso-step-num: #94a3b8;
    --proceso-guarantee-bg: rgba(30, 41, 59, 0.9);
    --proceso-guarantee-border: #334155;
    --faq-bg: #1e293b;
    --faq-text-title: #e2e8f0;
    --faq-text-body: #94a3b8;
    --faq-card-bg: rgba(30, 41, 59, 0.9);
    --faq-card-border: #334155;
    --faq-icon-bg: #334155;
    --faq-icon-text: #94a3b8;
    --faq-answer-text: #94a3b8;
    --garantias-bg: #0f172a;
    --garantias-text-title: #e2e8f0;
    --garantias-text-body: #94a3b8;
    --garantias-card-bg: #1e293b;
    --garantias-card-border: #334155;
    --garantias-icon-bg: rgba(174, 35, 42, 0.2);
    --contacto-bg: #1e293b;
    --contacto-text-title: #e2e8f0;
    --contacto-text-body: #94a3b8;
    --contacto-form-bg: rgba(30, 41, 59, 0.9);
    --contacto-form-border: #475569;
    --contacto-label-text: #94a3b8;
    --contacto-input-bg: #334155;
    --contacto-input-border: #94a3b8;
    --contacto-input-text: #f1f5f9;
    --contacto-info-title: #e2e8f0;
    --contacto-info-icon-bg: #334155;
    --contacto-info-text: #e2e8f0;
    --contacto-info-label: #94a3b8;
    --contacto-map-border: #334155;
    --calculadora-bg: #1e293b;
    --calculadora-text-title: #e2e8f0;
    --calculadora-text-body: #94a3b8;
    --calculadora-form-bg: rgba(30, 41, 59, 0.9);
    --calculadora-form-border: #334155;
    --calculadora-label-text: #94a3b8;
    --calculadora-input-bg: #1e293b;
    --calculadora-input-border: #334155;
    --calculadora-input-text: #e2e8f0;
    --calculadora-result-bg: #1e293b;
    --calculadora-result-border: #334155;
    --calculadora-result-label: #94a3b8;
    --calculadora-result-value: #e2e8f0;
    --calculadora-whatsapp-border: #334155;
    --calculadora-whatsapp-text: #94a3b8;
    --dores-bg: #1e293b;
    --dores-text-title: #e2e8f0;
    --dores-text-body: #94a3b8;
    --dores-item-bg: rgba(30, 41, 59, 0.9);
    --dores-item-border: #334155;
    --dores-item-text: #94a3b8;
    --sobre-bg: #0f172a;
    --sobre-text-title: #e2e8f0;
    --sobre-text-body: #94a3b8;
    --sobre-stat-bg: rgba(15, 23, 42, 0.85);
    --sobre-stat-border: rgba(251, 191, 36, 0.3);
    --sobre-stat-label: #94a3b8;
    --sobre-value-name: #e2e8f0;
    --sobre-value-desc: #94a3b8;
    --sobre-eeat-bg: rgba(30, 41, 59, 0.8);
    --sobre-eeat-border: #334155;
    --sobre-eeat-title: #e2e8f0;
    --sobre-eeat-body: #94a3b8;
    --sobre-values-bg: rgba(30, 41, 59, 0.6);
    --sobre-values-border: #334155;
    --sobre-values-title: #e2e8f0;
    --sobre-values-body: #94a3b8;
    --sobre-image-bg: #334155;
    --beforeafter-bg: #1e293b;
    --beforeafter-text-title: #e2e8f0;
    --beforeafter-text-body: #94a3b8;
    --beforeafter-before-label-bg: #334155;
    --beforeafter-before-label-text: #e2e8f0;
    --beforeafter-caption-text: #94a3b8;
    --reviews-bg: #0f172a;
    --reviews-text-title: #e2e8f0;
    --reviews-card-bg: #1e293b;
    --reviews-card-text: #94a3b8;
    --reviews-verified-text: #94a3b8;
  }

  /* Base styles */
  body { font-family: 'Inter', system-ui, sans-serif; }
  ::-webkit-scrollbar { width: 8px; }
  ::-webkit-scrollbar-track { background: #121315; }
  ::-webkit-scrollbar-thumb { background: #3a3c42; border-radius: 4px; }
  ::-webkit-scrollbar-thumb:hover { background: #63676e; }

  /* Component utilities */
  .font-display { font-family: 'Space Grotesk', 'Inter', sans-serif; }
  .industrial-line { height: 2px; background: linear-gradient(90deg, var(--industrial-line-color) 0%, transparent 100%); }
  .card-lift { transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease; }
  .card-lift:hover { transform: translateY(-8px); box-shadow: 0 24px 48px -12px rgba(0,0,0,0.4); }
  .img-zoom { transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
  .img-zoom:hover { transform: scale(1.08); }
  .big-number { font-variant-numeric: tabular-nums; letter-spacing: -0.04em; }

  /* Animation utilities */
  .animate-slide-up { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
  .animate-fade-in { animation: fadeIn 1s ease forwards; opacity: 0; }
  .delay-100 { animation-delay: 0.1s; }
  .delay-200 { animation-delay: 0.2s; }
  .delay-300 { animation-delay: 0.3s; }
  .delay-400 { animation-delay: 0.4s; }
  .delay-500 { animation-delay: 0.5s; }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(60px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  /* Header — Transparent over dark hero by default, solid on scroll */
  #site-nav {
    background-color: transparent;
    border-bottom: 1px solid transparent;
  }
  html.dark #site-nav {
    background-color: transparent;
    border-bottom: 1px solid transparent;
  }
  #site-nav.header-scrolled {
    background-color: #ffffff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
  }
  html.dark #site-nav.header-scrolled {
    background-color: #0f172a;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
  }

  /* Light mode text colors — WHITE over dark hero, dark when scrolled */
  [data-nav-link] { color: rgba(255,255,255,0.9); transition: color 0.3s; }
  [data-nav-link]:hover { color: #ffffff; }
  [data-lang-btn] { color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.25); transition: all 0.3s; }
  [data-lang-btn]:hover { color: #ffffff; border-color: rgba(255,255,255,0.5); }
  [data-menu-btn] { color: #ffffff; }
  [data-brand-text] { color: #ffffff; }
  [data-brand-sub] { color: rgba(255,255,255,0.7); }

  /* Theme toggle button */
  [data-theme-btn] { color: rgba(255,255,255,0.9); }
  [data-theme-btn]:hover { color: var(--color-accent-hover); }

  /* Scrolled light mode — dark text on white bg */
  #site-nav.header-scrolled [data-nav-link] { color: #44403c; }
  #site-nav.header-scrolled [data-nav-link]:hover { color: #1c1917; }
  #site-nav.header-scrolled [data-lang-btn] { color: #78716c; border-color: rgba(0,0,0,0.15); }
  #site-nav.header-scrolled [data-lang-btn]:hover { color: #1c1917; border-color: rgba(0,0,0,0.3); }
  #site-nav.header-scrolled [data-menu-btn] { color: #44403c; }
  #site-nav.header-scrolled [data-brand-text] { color: #1c1917; }
  #site-nav.header-scrolled [data-brand-sub] { color: #78716c; }
  #site-nav.header-scrolled [data-theme-btn] { color: #44403c; }
  #site-nav.header-scrolled [data-theme-btn]:hover { color: var(--color-brand-light); }

  /* Dark mode text colors */
  html.dark [data-nav-link] { color: rgba(255,255,255,0.85); }
  html.dark [data-nav-link]:hover { color: #fff; }
  html.dark [data-lang-btn] { color: rgba(255,255,255,0.6); border-color: rgba(255,255,255,0.2); }
  html.dark [data-lang-btn]:hover { color: #fff; border-color: rgba(255,255,255,0.4); }
  html.dark [data-menu-btn] { color: #fff; }
  html.dark [data-brand-text] { color: #fff; }
  html.dark [data-brand-sub] { color: rgba(255,255,255,0.6); }
  html.dark [data-theme-btn] { color: rgba(255,255,255,0.85); }
  html.dark [data-theme-btn]:hover { color: var(--color-accent-hover); }

  /* Logo: light mode shows dark logo, dark mode shows light logo */
  [data-logo-dark] { opacity: 0 !important; }
  [data-logo-light] { opacity: 1 !important; }
  html.dark [data-logo-dark] { opacity: 1 !important; }
  html.dark [data-logo-light] { opacity: 0 !important; }

  /* Phone link adjusts per theme */
  html.dark [data-track-event="phone_click"] { color: var(--color-accent-hover) !important; }
  html.dark [data-track-event="phone_click"]:hover { color: var(--color-accent-hover-light) !important; }

  /* Industrial line reversed */
  .industrial-line-reverse { background: linear-gradient(270deg, var(--industrial-line-color) 0%, transparent 100%) !important; }

  /* CTA background pattern */
  .cta-bg-pattern { background-image: repeating-linear-gradient(90deg, var(--industrial-line-color) 0px, var(--industrial-line-color) 1px, transparent 1px, transparent 80px); }

  /* Logo aspect ratio */
  .logo-aspect { aspect-ratio: 1656/551; }

  /* ═══════════════════════════════════════════════════════════
     RESPONSIVE HEADER — Mobile-first adaptive sizing
     From smallest phone (320px) up to tablet (768px)
     ═══════════════════════════════════════════════════════════ */

  /* Base mobile: 320px+ */
  [data-header-inner] {
    padding-left: clamp(0.75rem, 3vw, 1.5rem) !important;
    padding-right: clamp(0.75rem, 3vw, 1.5rem) !important;
    padding-top: clamp(0.75rem, 2vw, 1.25rem) !important;
    padding-bottom: clamp(0.75rem, 2vw, 1.25rem) !important;
    max-width: 100vw !important;
    width: 100% !important;
  }
  [data-brand-text] {
    font-size: clamp(1.1rem, 5vw, 1.65rem) !important;
  }
  [data-brand-sub] {
    font-size: clamp(0.55rem, 2vw, 0.7rem) !important;
    letter-spacing: clamp(0.15em, 1vw, 0.3em) !important;
    margin-top: clamp(0.25rem, 1vw, 0.625rem) !important;
  }
  .logo-aspect {
    height: clamp(2.25rem, 8vw, 3.25rem) !important;
  }

  /* Tiny phones: 320px–360px */
  @media (max-width: 360px) {
    [data-header-inner] { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
    [data-brand-text] { font-size: 1rem !important; }
    [data-brand-sub] { font-size: 0.5rem !important; letter-spacing: 0.12em !important; }
    .logo-aspect { height: 2rem !important; }
    #menu-toggle { padding: 0.25rem !important; }
    #menu-toggle svg { width: 20px !important; height: 20px !important; }
  }

  /* Small phones: 361px–480px */
  @media (min-width: 361px) and (max-width: 480px) {
    [data-brand-text] { font-size: 1.2rem !important; }
    [data-brand-sub] { font-size: 0.58rem !important; }
    .logo-aspect { height: 2.5rem !important; }
  }

  /* Medium phones: 481px–640px */
  @media (min-width: 481px) and (max-width: 640px) {
    [data-brand-text] { font-size: 1.4rem !important; }
    [data-brand-sub] { font-size: 0.62rem !important; }
    .logo-aspect { height: 2.75rem !important; }
  }

  /* Large phones / small tablets: 641px–768px */
  @media (min-width: 641px) and (max-width: 768px) {
    [data-brand-text] { font-size: 1.55rem !important; }
    .logo-aspect { height: 3rem !important; }
  }

  /* Ensure menu toggle is ALWAYS visible on mobile */
  @media (max-width: 1023px) {
    #menu-toggle {
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      flex-shrink: 0 !important;
      margin-left: auto !important;
      z-index: 51 !important;
    }
    [data-header-inner] > a:first-child {
      flex-shrink: 1 !important;
      min-width: 0 !important;
      overflow: hidden !important;
    }
  }

  /* ================================================================
     SECTION DESIGN TOKENS — Custom utility classes
     These map CSS custom properties to section-specific styles.
     Changing the --* variables above updates ALL pages automatically.
     ================================================================ */

  /* ----- HERO ----- */
  .section-hero-overlay-1 {
    background: linear-gradient(90deg, var(--hero-bg-overlay-start) 0%, var(--hero-bg-overlay-mid) 55%, var(--hero-bg-overlay-end) 100%);
  }
  .section-hero-overlay-2 {
    background: linear-gradient(to top, var(--hero-bg-overlay-start) 0%, transparent 50%, var(--hero-bg-overlay-top) 100%);
  }
  .section-hero-overlay-vignette {
    background: var(--hero-bg-overlay-vignette);
  }
  .section-hero-text { color: var(--hero-text-primary); }
  .section-hero-text-secondary { color: var(--hero-text-secondary); }
  .section-hero-text-tertiary { color: var(--hero-text-tertiary); }
  .section-hero-accent { color: var(--hero-accent); }
  .section-hero-badge { color: var(--hero-badge-text); }
  .section-hero-btn-primary {
    background-color: var(--hero-btn-primary-bg);
    color: var(--hero-btn-primary-text);
  }
  .section-hero-btn-primary:hover {
    background-color: var(--hero-btn-primary-hover);
  }
  .section-hero-btn-secondary {
    border-color: var(--hero-btn-secondary-border);
    color: var(--hero-btn-secondary-text);
  }
  .section-hero-btn-secondary:hover {
    border-color: var(--hero-btn-secondary-border-hover);
  }
  .section-hero-scroll { color: var(--hero-scroll-indicator); }
  .section-hero-scroll:hover { color: var(--hero-accent); }

  /* ----- TESTIMONIOS ----- */
  .section-testimonios { background-color: var(--testimonios-bg); }
  .section-testimonios-border-top {
    background: linear-gradient(90deg, transparent 0%, var(--testimonios-border-top) 50%, transparent 100%);
  }
  .section-testimonios-badge {
    background-color: var(--testimonios-badge-bg);
    color: var(--testimonios-badge-text);
    border-color: var(--testimonios-badge-border);
  }
  .section-testimonios-title { color: var(--testimonios-text-title); }
  .section-testimonios-body { color: var(--testimonios-text-body); }
  .section-testimonios-secondary { color: var(--testimonios-text-secondary); }
  .section-testimonios-card {
    background-color: var(--testimonios-card-bg);
    border-color: var(--testimonios-card-border);
    box-shadow: var(--testimonios-card-shadow);
  }
  .section-testimonios-card-hover:hover {
    box-shadow: var(--testimonios-card-shadow-hover);
  }
  .section-testimonios-arrow {
    background-color: var(--testimonios-arrow-bg);
    border-color: var(--testimonios-arrow-border);
    color: var(--testimonios-arrow-text);
  }
  .section-testimonios-arrow:hover {
    color: var(--testimonios-arrow-hover-text);
    border-color: var(--testimonios-arrow-hover-border);
  }
  .section-testimonios-dot-active {
    background-color: var(--testimonios-dot-active);
  }
  .section-testimonios-dot-inactive {
    background-color: var(--testimonios-dot-inactive);
  }
  .section-testimonios-avatar {
    background: linear-gradient(to bottom right, var(--testimonios-avatar-bg-start), var(--testimonios-avatar-bg-end));
    color: #ffffff;
  }
  .section-testimonios-imperfection {
    background-color: var(--testimonios-imperfection-bg);
    border-color: var(--testimonios-imperfection-border);
    color: var(--testimonios-imperfection-text);
  }
  .section-testimonios-link {
    color: var(--testimonios-link-text);
  }
  .section-testimonios-link:hover {
    color: var(--testimonios-link-hover);
  }

  /* ----- CTA FINAL ----- */
  .section-cta {
    background: linear-gradient(135deg, var(--cta-bg-start), var(--cta-bg-end));
  }
  .section-cta-pattern {
    opacity: var(--cta-pattern-opacity);
  }
  .section-cta-text { color: var(--cta-text-primary); }
  .section-cta-text-secondary { color: var(--cta-text-secondary); }
  .section-cta-btn {
    background-color: var(--cta-btn-bg);
    color: var(--cta-btn-text);
  }
  .section-cta-btn:hover {
    background-color: var(--cta-btn-hover-bg);
  }
  .section-cta-btn-outline {
    border-color: var(--cta-btn-outline-border);
    color: var(--cta-btn-outline-text);
  }
  .section-cta-btn-outline:hover {
    border-color: var(--cta-btn-outline-border-hover);
  }

  /* ----- SERVICIOS ----- */
  .section-servicios { background-color: var(--servicios-bg); }
  .section-servicios-title { color: var(--servicios-text-title); }
  .section-servicios-body { color: var(--servicios-text-body); }
  .section-servicios-badge { color: var(--servicios-badge-text); }
  .section-servicios-card { background-color: var(--servicios-card-bg); border-color: var(--servicios-card-border); }
  .section-servicios-card:hover { border-color: var(--servicios-card-hover-border); }
  .section-servicios-card-icon { background-color: var(--servicios-card-icon-bg); color: var(--servicios-card-icon-text); }
  .section-servicios-link { color: var(--servicios-link-text); }
  .section-servicios-link:hover { color: var(--servicios-link-hover); }
  .section-servicios-cta-card { background-color: var(--servicios-cta-card-bg); border-color: var(--servicios-cta-card-border); }
  .section-servicios-cta-text { color: var(--servicios-cta-card-text); }
  .section-servicios-cta-title { color: var(--servicios-cta-card-title); }

  /* ----- PORTFOLIO ----- */
  .section-portfolio { background-color: var(--portfolio-bg); border-color: var(--portfolio-border); }
  .section-portfolio-title { color: var(--portfolio-text-title); }
  .section-portfolio-body { color: var(--portfolio-text-body); }
  .section-portfolio-badge { color: var(--portfolio-badge-text); }
  .section-portfolio-filter-active { background-color: var(--portfolio-filter-active-bg); border-color: var(--portfolio-filter-active-border); color: var(--portfolio-filter-active-text); }
  .section-portfolio-filter-inactive { border-color: var(--portfolio-filter-inactive-border); color: var(--portfolio-filter-inactive-text); }
  .section-portfolio-card { background-color: var(--portfolio-card-bg); border-color: var(--portfolio-card-border); }
  .section-portfolio-tag { background-color: var(--portfolio-card-tag-bg); color: var(--portfolio-card-tag-text); }
  .section-portfolio-meta { color: var(--portfolio-card-meta-text); }
  .section-portfolio-link { color: var(--portfolio-card-link-text); }
  .section-portfolio-link:hover { color: var(--portfolio-card-link-hover); }

  /* ----- PROCESO ----- */
  .section-proceso { background-color: var(--proceso-bg); }
  .section-proceso-title { color: var(--proceso-text-title); }
  .section-proceso-body { color: var(--proceso-text-body); }
  .section-proceso-badge { color: var(--proceso-badge-text); }
  .section-proceso-card { background-color: var(--proceso-card-bg); border-color: var(--proceso-card-border); }
  .section-proceso-card:hover { border-color: var(--proceso-card-hover-border); }
  .section-proceso-step-num { color: var(--proceso-step-num); }
  .section-proceso-card:hover .section-proceso-step-num { color: var(--proceso-step-num-hover); }
  .section-proceso-icon { background-color: var(--proceso-icon-bg); color: var(--proceso-icon-text); }
  .section-proceso-connector { background-color: var(--proceso-connector); }
  .section-proceso-card:hover .section-proceso-connector { background-color: var(--proceso-connector-hover); }
  .section-proceso-guarantee { background-color: var(--proceso-guarantee-bg); border-color: var(--proceso-guarantee-border); }

  /* ----- FAQ ----- */
  .section-faq { background-color: var(--faq-bg); }
  .section-faq-title { color: var(--faq-text-title); }
  .section-faq-body { color: var(--faq-text-body); }
  .section-faq-badge { color: var(--faq-badge-text); }
  .section-faq-card { background-color: var(--faq-card-bg); border-color: var(--faq-card-border); }
  .section-faq-card:hover { border-color: var(--faq-card-hover-border); }
  .section-faq-question { color: var(--faq-question-text); }
  .section-faq-question:hover { color: var(--faq-question-hover); }
  .section-faq-icon { background-color: var(--faq-icon-bg); color: var(--faq-icon-text); }
  .section-faq-trigger:hover .section-faq-icon { background-color: var(--faq-icon-hover-bg); color: var(--faq-icon-hover-text); }
  .section-faq-answer { color: var(--faq-answer-text); }
  .section-faq-cta { background-color: var(--faq-cta-bg); color: var(--faq-cta-text); }
  .section-faq-cta:hover { background-color: var(--faq-cta-hover); }

  /* ----- GARANTIAS ----- */
  .section-garantias { background-color: var(--garantias-bg); }
  .section-garantias-title { color: var(--garantias-text-title); }
  .section-garantias-body { color: var(--garantias-text-body); }
  .section-garantias-badge { color: var(--garantias-badge-text); }
  .section-garantias-card { background-color: var(--garantias-card-bg); border-color: var(--garantias-card-border); }
  .section-garantias-card:hover { border-color: var(--garantias-card-hover-border); }
  .section-garantias-icon { background-color: var(--garantias-icon-bg); color: var(--garantias-icon-text); }
  .section-garantias-card:hover .section-garantias-icon { background-color: var(--garantias-icon-hover-bg); }

  /* ----- CONTACTO ----- */
  .section-contacto { background-color: var(--contacto-bg); }
  .section-contacto-title { color: var(--contacto-text-title); }
  .section-contacto-body { color: var(--contacto-text-body); }
  .section-contacto-badge { color: var(--contacto-badge-text); }
  .section-contacto-form { background-color: var(--contacto-form-bg); border-color: var(--contacto-form-border); }
  .section-contacto-label { color: var(--contacto-label-text); }
  .section-contacto-input { background-color: var(--contacto-input-bg); border-color: var(--contacto-input-border); color: var(--contacto-input-text); }
  .section-contacto-input:focus { border-color: var(--color-brand); outline: none; }
  .section-contacto-input::placeholder { color: #64748b; opacity: 1; }
  select.section-contacto-input { color-scheme: dark; }
  .section-contacto-info-title { color: var(--contacto-info-title); }
  .section-contacto-info-icon { background-color: var(--contacto-info-icon-bg); color: var(--contacto-info-icon-text); }
  .section-contacto-info-row:hover .section-contacto-info-icon { background-color: var(--contacto-info-icon-hover); }
  .section-contacto-info-text { color: var(--contacto-info-text); }
  .section-contacto-info-label { color: var(--contacto-info-label); }
  .section-contacto-financing { background: linear-gradient(135deg, var(--contacto-financing-bg-start), var(--contacto-financing-bg-end)); }
  .section-contacto-financing-text { color: var(--contacto-financing-text); }
  .section-contacto-map { border-color: var(--contacto-map-border); }
  .section-contacto-submit { background-color: var(--contacto-submit-bg); color: var(--contacto-submit-text); }
  .section-contacto-submit:hover { background-color: var(--contacto-submit-hover); }

  /* ----- CALCULADORA ----- */
  .section-calculadora { background-color: var(--calculadora-bg); }
  .section-calculadora-title { color: var(--calculadora-text-title); }
  .section-calculadora-body { color: var(--calculadora-text-body); }
  .section-calculadora-badge { color: var(--calculadora-badge-text); }
  .section-calculadora-form { background-color: var(--calculadora-form-bg); border-color: var(--calculadora-form-border); }
  .section-calculadora-label { color: var(--calculadora-label-text); }
  .section-calculadora-input { background-color: var(--calculadora-input-bg); border-color: var(--calculadora-input-border); color: var(--calculadora-input-text); }
  .section-calculadora-input:focus { border-color: var(--color-brand); outline: none; }
  .section-calculadora-result { background-color: var(--calculadora-result-bg); border-color: var(--calculadora-result-border); }
  .section-calculadora-result-label { color: var(--calculadora-result-label); }
  .section-calculadora-result-value { color: var(--calculadora-result-value); }
  .section-calculadora-cta { background-color: var(--calculadora-cta-bg); color: var(--calculadora-cta-text); }
  .section-calculadora-cta:hover { background-color: var(--calculadora-cta-hover); }
  .section-calculadora-whatsapp { border-color: var(--calculadora-whatsapp-border); color: var(--calculadora-whatsapp-text); }
  .section-calculadora-whatsapp:hover { border-color: var(--calculadora-whatsapp-hover); }

  /* ----- DORES/SOLUCOES ----- */
  .section-dores { background-color: var(--dores-bg); }
  .section-dores-title { color: var(--dores-text-title); }
  .section-dores-body { color: var(--dores-text-body); }
  .section-dores-badge { color: var(--dores-badge-text); }
  .section-dores-item { background-color: var(--dores-item-bg); border-color: var(--dores-item-border); }
  .section-dores-item-icon { background-color: var(--dores-item-icon-bg); }
  .section-dores-item-icon svg { stroke: var(--dores-item-icon-stroke); }
  .section-dores-item-text { color: var(--dores-item-text); }
  .section-dores-link { color: var(--dores-link-text); }
  .section-dores-link:hover { color: var(--dores-link-hover); }

  /* ----- SOBRE NOSOTROS (PAULO) ----- */
  .section-sobre { background-color: var(--sobre-bg); }
  .section-sobre-title { color: var(--sobre-text-title); }
  .section-sobre-subtitle { color: var(--sobre-text-subtitle); }
  .section-sobre-body { color: var(--sobre-text-body); }
  .section-sobre-badge { color: var(--sobre-badge-text); }
  .section-sobre-stat { background-color: var(--sobre-stat-bg); border-color: var(--sobre-stat-border); }
  .section-sobre-stat-value { color: var(--sobre-stat-value); }
  .section-sobre-stat-label { color: var(--sobre-stat-label); }
  .section-sobre-eeat { background-color: var(--sobre-eeat-bg); border-color: var(--sobre-eeat-border); }
  .section-sobre-eeat-title { color: var(--sobre-eeat-title); }
  .section-sobre-eeat-body { color: var(--sobre-eeat-body); }
  .section-sobre-values { background-color: var(--sobre-values-bg); border-color: var(--sobre-values-border); }
  .section-sobre-values-title { color: var(--sobre-values-title); }
  .section-sobre-values-body { color: var(--sobre-values-body); }
  .section-sobre-value-dot { background-color: var(--sobre-value-dot); }
  .section-sobre-value-name { color: var(--sobre-value-name); }
  .section-sobre-value-desc { color: var(--sobre-value-desc); }
  .section-sobre-cta { color: var(--sobre-cta-text); }
  .section-sobre-cta:hover { color: var(--sobre-cta-hover); }
  .section-sobre-float { background-color: var(--sobre-float-bg); color: var(--sobre-float-text); }
  .section-sobre-image { background-color: var(--sobre-image-bg); }

  /* ----- BEFORE/AFTER ----- */
  .section-beforeafter { background-color: var(--beforeafter-bg); }
  .section-beforeafter-title { color: var(--beforeafter-text-title); }
  .section-beforeafter-body { color: var(--beforeafter-text-body); }
  .section-beforeafter-badge { background-color: var(--beforeafter-badge-bg); color: var(--beforeafter-badge-text); border-color: var(--beforeafter-badge-border); }
  .section-beforeafter-border-top { background: linear-gradient(90deg, transparent 0%, var(--beforeafter-border-top) 50%, transparent 100%); }
  .section-beforeafter-handle { background-color: var(--beforeafter-handle-bg); color: var(--beforeafter-handle-text); }
  .section-beforeafter-after-label { background-color: var(--beforeafter-after-label-bg); color: var(--beforeafter-after-label-text); }
  .section-beforeafter-before-label { background-color: var(--beforeafter-before-label-bg); color: var(--beforeafter-before-label-text); }
  .section-beforeafter-caption { color: var(--beforeafter-caption-text); }

  /* ----- GOOGLE REVIEWS ----- */
  .section-reviews { background-color: var(--reviews-bg); }
  .section-reviews-title { color: var(--reviews-text-title); }
  .section-reviews-badge { background-color: var(--reviews-badge-bg); color: var(--reviews-badge-text); border-color: var(--reviews-badge-border); }
  .section-reviews-rating { color: var(--reviews-rating-text); }
  .section-reviews-card { background-color: var(--reviews-card-bg); }
  .section-reviews-avatar { background: linear-gradient(to bottom right, var(--reviews-card-avatar-start), var(--reviews-card-avatar-end)); color: var(--reviews-card-avatar-text); }
  .section-reviews-author { color: var(--reviews-card-author); }
  .section-reviews-text { color: var(--reviews-card-text); }
  .section-reviews-verified-icon { color: var(--reviews-verified-icon); }
  .section-reviews-verified-text { color: var(--reviews-verified-text); }
  .section-reviews-link { color: var(--reviews-link-text); }
  .section-reviews-link:hover { color: var(--reviews-link-hover); }

  /* Mobile menu */
  .mobile-menu {
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .mobile-menu.open {
    transform: translateX(0);
  }
  /* Mobile menu must be above everything (scroll-progress has z-index 9999) */
  #mobile-menu {
    z-index: 99999;
  }

  /* Mobile submenu accordion */
  .mobile-submenu-panel {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;
  }
  .mobile-submenu-panel.open {
    max-height: 400px;
    opacity: 1;
  }
  .mobile-submenu-toggle[aria-expanded="true"] .submenu-chevron {
    transform: rotate(180deg);
  }
  .submenu-chevron {
    transition: transform 0.3s ease;
  }

  /* Dark mode */
  html.dark { color-scheme: dark; }
  html.dark body { background-color: #0f172a; color: #e2e8f0; }

  /* Mobile menu dark mode — refined background with subtle gradient */
  html.dark .mobile-menu {
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
  }
  html.dark .mobile-menu::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at top, rgba(30,58,138,0.15) 0%, transparent 70%);
    pointer-events: none;
  }
  html.dark .mobile-menu .sticky.top-0 { background-color: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(12px); border-color: #334155 !important; }
  html.dark #menu-close { color: #e2e8f0; background-color: #1e293b !important; }
  html.dark #menu-close:hover { background-color: var(--color-accent) !important; color: #fff !important; }
  html.dark .mobile-submenu-toggle { color: #94a3b8; background-color: #1e293b !important; }
  html.dark .mobile-submenu-toggle:hover { color: #fff; background-color: var(--color-accent) !important; }
  html.dark .mobile-submenu-panel a { color: #cbd5e1; }
  html.dark .mobile-submenu-panel a:hover { color: #fff; background-color: rgba(30,41,59,0.8); }
  html.dark .mobile-nav-link { color: #f1f5f9 !important; }
  html.dark .mobile-nav-link[data-track-event="phone_click"] { color: var(--color-accent-hover) !important; }
  html.dark .mobile-nav-group { border-color: #334155 !important; }
  html.dark .mobile-nav-item { border-color: #334155 !important; }
  html.dark .mobile-nav-group .mobile-nav-link,
  html.dark .mobile-nav-item.mobile-nav-link { color: #ffffff !important; }
  html.dark .mobile-menu .border-warm-100 { border-color: #334155 !important; }
  html.dark .mobile-menu .border-warm-200 { border-color: #334155 !important; }
  html.dark .mobile-menu .border-warm-300 { border-color: #475569 !important; }
  html.dark .mobile-menu .bg-warm-50 { background-color: #1e293b !important; }
  html.dark .mobile-menu .text-warm-500 { color: #94a3b8 !important; }
  html.dark .mobile-menu .text-warm-600 { color: #cbd5e1 !important; }
  html.dark .mobile-menu .text-warm-700 { color: #e2e8f0 !important; }
  html.dark .mobile-menu .text-warm-900 { color: #ffffff !important; }
  html.dark .mobile-menu a[hreflang] { color: #e2e8f0 !important; border-color: #64748b !important; }
  html.dark .mobile-menu a[hreflang].text-brand-500 { color: var(--color-accent) !important; border-color: var(--color-accent) !important; }
  html.dark .mobile-menu a[hreflang]:hover { color: #ffffff !important; border-color: var(--color-accent) !important; }
  html.dark #menu-close { color: #f1f5f9; }
  html.dark #theme-toggle-mobile { color: #e2e8f0 !important; border-color: #64748b !important; }
  html.dark #theme-toggle-mobile:hover { color: var(--color-accent) !important; border-color: var(--color-accent) !important; }
  html.dark .header-scrolled { background-color: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(12px); }
  html.dark .header-scrolled [data-nav-link] { color: rgba(226, 232, 240, 0.85); }
  html.dark .header-scrolled [data-nav-link]:hover { color: #fff; }
  html.dark .header-scrolled [data-lang-btn] { color: rgba(226, 232, 240, 0.6); border-color: rgba(226, 232, 240, 0.2); }
  html.dark .header-scrolled [data-lang-btn]:hover { color: #fff; border-color: rgba(226, 232, 240, 0.4); }
  html.dark .header-scrolled [data-menu-btn] { color: #f1f5f9; }
  html.dark .header-scrolled [data-brand-text] { color: #ffffff !important; }
  html.dark .header-scrolled [data-brand-sub] { color: rgba(226, 232, 240, 0.6); }
  html.dark .header-scrolled [data-nav-cta] { background-color: var(--btn-primary-bg); }
  html.dark .header-scrolled [data-nav-cta]:hover { background-color: var(--btn-primary-bg-hover); }

  /* ── FORCE white header text in ALL dark mode states ── */
  html.dark [data-brand-text] { color: #ffffff !important; }
  html.dark [data-brand-sub] { color: rgba(255,255,255,0.7) !important; }
  html.dark body.header-solid [data-brand-text] { color: #ffffff !important; }
  html.dark body.header-solid [data-brand-sub] { color: rgba(255,255,255,0.7) !important; }
  html.dark body.header-solid [data-menu-btn] { color: #f1f5f9 !important; }

  /* Pages without dark hero — force solid header from start */
  body.header-solid #site-nav {
    background-color: #ffffff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  }
  body.header-solid [data-nav-link] { color: #44403c; }
  body.header-solid [data-nav-link]:hover { color: #1c1917; }
  body.header-solid [data-lang-btn] { color: #78716c; border-color: rgba(0,0,0,0.15); }
  body.header-solid [data-lang-btn]:hover { color: #1c1917; border-color: rgba(0,0,0,0.3); }
  body.header-solid [data-menu-btn] { color: #44403c; }
  body.header-solid [data-brand-text] { color: #1c1917; }
  body.header-solid [data-brand-sub] { color: #78716c; }
  body.header-solid [data-theme-btn] { color: #44403c; }
  html.dark body.header-solid #site-nav {
    background-color: #0f172a;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  }
  html.dark body.header-solid [data-nav-link] { color: rgba(255,255,255,0.85); }
  html.dark body.header-solid [data-nav-link]:hover { color: #fff; }
  html.dark body.header-solid [data-lang-btn] { color: rgba(255,255,255,0.6); border-color: rgba(255,255,255,0.2); }
  html.dark body.header-solid [data-lang-btn]:hover { color: #fff; border-color: rgba(255,255,255,0.4); }
  html.dark body.header-solid [data-menu-btn] { color: #fff; }
  html.dark body.header-solid [data-brand-text] { color: #fff; }
  html.dark body.header-solid [data-brand-sub] { color: rgba(255,255,255,0.6); }
  html.dark body.header-solid [data-theme-btn] { color: rgba(255,255,255,0.85); }
  html.dark section.bg-white,
  html.dark .bg-white,
  html.dark [class*="bg-white"] { background-color: #1e293b !important; }
  html.dark .bg-warm-50,
  html.dark .bg-warm-100,
  html.dark [class*="bg-warm-50"],
  html.dark [class*="bg-warm-100"] { background-color: #1e293b !important; }
  html.dark .text-warm-900,
  html.dark [class*="text-warm-900"] { color: #e2e8f0 !important; }
  html.dark .text-warm-800,
  html.dark [class*="text-warm-800"] { color: #cbd5e1 !important; }
  html.dark .text-warm-700,
  html.dark [class*="text-warm-700"] { color: #cbd5e1 !important; }
  html.dark .text-warm-600,
  html.dark [class*="text-warm-600"] { color: #cbd5e1 !important; }
  html.dark .text-warm-500,
  html.dark [class*="text-warm-500"] { color: #94a3b8 !important; }
  html.dark .border-warm-200,
  html.dark .border-warm-100,
  html.dark [class*="border-warm-200"],
  html.dark [class*="border-warm-100"] { border-color: #334155 !important; }
  html.dark footer { background-color: #0c0a09; }
  html.dark #scroll-progress { box-shadow: 0 0 10px rgba(248, 113, 113, 0.5); }

  /* Catch-all for gray/slate text colors in dark mode — LIGHTER for visibility */
  html.dark .text-gray-500,
  html.dark .text-gray-600,
  html.dark .text-slate-500,
  html.dark .text-slate-600,
  html.dark .text-slate-700,
  html.dark .text-slate-800 { color: #cbd5e1 !important; }

  /* ALL card/section text in dark mode — ensure white */
  html.dark section p,
  html.dark section li,
  html.dark section span:not(.sr-only):not([class*="icon"]),
  html.dark .card p,
  html.dark .card span,
  html.dark [class*="card"] p,
  html.dark [class*="card"] span,
  html.dark .bg-white p,
  html.dark .bg-white span,
  html.dark .bg-warm-50 p,
  html.dark .bg-warm-50 span,
  html.dark [class*="bg-white"] p,
  html.dark [class*="bg-warm-50"] p { color: #f1f5f9 !important; }

  /* Card titles in dark mode — pure white */
  html.dark section h1,
  html.dark section h2,
  html.dark section h3,
  html.dark section h4,
  html.dark section h5,
  html.dark .card h1,
  html.dark .card h2,
  html.dark .card h3,
  html.dark .card h4,
  html.dark .card h5,
  html.dark [class*="card"] h1,
  html.dark [class*="card"] h2,
  html.dark [class*="card"] h3,
  html.dark [class*="card"] h4,
  html.dark [class*="card"] h5,
  html.dark .bg-white h1,
  html.dark .bg-white h2,
  html.dark .bg-white h3,
  html.dark .bg-white h4,
  html.dark .bg-white h5,
  html.dark .bg-warm-50 h1,
  html.dark .bg-warm-50 h2,
  html.dark .bg-warm-50 h3,
  html.dark .bg-warm-50 h4,
  html.dark .bg-warm-50 h5 { color: #ffffff !important; }

  /* Labels, captions, small text — lighter gray */
  html.dark section label,
  html.dark section small,
  html.dark section .text-xs,
  html.dark section .text-sm.text-warm-500,
  html.dark .card label,
  html.dark .card small,
  html.dark [class*="card"] label,
  html.dark [class*="card"] small { color: #94a3b8 !important; }

  /* Dark mode section tokens — brighter text */
  html.dark {
    --testimonios-text-body: #cbd5e1;
    --testimonios-text-secondary: #cbd5e1;
    --servicios-text-body: #cbd5e1;
    --portfolio-text-body: #cbd5e1;
    --proceso-text-body: #cbd5e1;
    --proceso-step-num: #cbd5e1;
    --faq-text-body: #cbd5e1;
    --faq-answer-text: #cbd5e1;
    --garantias-text-body: #cbd5e1;
    --contacto-text-body: #cbd5e1;
    --contacto-label-text: #94a3b8;
    --contacto-info-label: #94a3b8;
    --calculadora-text-body: #cbd5e1;
    --calculadora-label-text: #94a3b8;
    --calculadora-whatsapp-text: #94a3b8;
    --dores-text-body: #cbd5e1;
    --dores-item-text: #cbd5e1;
    --sobre-text-body: #cbd5e1;
    --sobre-stat-label: #94a3b8;
    --sobre-value-desc: #cbd5e1;
    --beforeafter-text-body: #cbd5e1;
    --beforeafter-caption-text: #94a3b8;
    --reviews-card-text: #cbd5e1;
    --reviews-verified-text: #94a3b8;
  }

  /* Inputs and selects in dark mode */
  html.dark input,
  html.dark select,
  html.dark textarea {
    background-color: #1e293b !important;
    color: #e2e8f0 !important;
    border-color: #334155 !important;
  }
  html.dark input::placeholder,
  html.dark textarea::placeholder { color: #64748b !important; }

  /* Smooth theme transitions — dark/light toggle */
  body, #site-nav, footer, .mobile-menu, section, .bg-white, .bg-warm-50, .bg-warm-100,
  [data-nav-link], [data-lang-btn], [data-menu-btn], [data-brand-text], [data-brand-sub],
  [data-theme-btn], [data-logo-dark], [data-logo-light],
  .mobile-nav-link, .mobile-submenu-panel a, .mobile-submenu-toggle, #menu-close {
    transition: background-color 0.35s ease, color 0.35s ease, border-color 0.35s ease, opacity 0.35s ease, box-shadow 0.35s ease;
  }

  /* Scroll progress bar */
  #scroll-progress {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--scroll-progress-start), var(--scroll-progress-end));
    z-index: var(--z-scroll-progress);
    width: 0%;
    transition: width 0.1s linear;
    box-shadow: 0 0 10px rgba(174, 35, 42, 0.5);
  }

  /* Sticky CTA mobile */
  #sticky-cta-mobile {
    transform: translateY(100%);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }
  #sticky-cta-mobile.visible {
    transform: translateY(0);
  }

  /* 3D Tilt Cards */
  .tilt-card {
    transform-style: preserve-3d;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .tilt-card-inner {
    transform: translateZ(20px);
  }

  /* Before/After Slider */
  .before-after { touch-action: pan-y; }
  .before-after__handle {
    box-shadow: 0 0 20px rgba(0,0,0,0.5), 0 0 0 4px rgba(255,255,255,0.1);
    transition: box-shadow 0.3s;
  }
  .before-after__handle:hover {
    box-shadow: 0 0 30px rgba(0,0,0,0.7), 0 0 0 6px rgba(174,35,42,0.3);
  }
  .before-after__handle:active {
    cursor: grabbing;
  }

  /* Section Dots Navigation */
  .section-dot {
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
  }
  .section-dot::after {
    content: attr(aria-label);
    position: absolute;
    right: calc(100% + 12px);
    top: 50%;
    transform: translateY(-50%) scale(0.8);
    background: rgba(12,12,14,0.9);
    color: #fff;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s;
    border: 1px solid rgba(174,35,42,0.3);
  }
  .section-dot:hover::after {
    opacity: 1;
    transform: translateY(-50%) scale(1);
  }
  .section-dot.active {
    box-shadow: 0 0 12px rgba(174,35,42,0.5);
  }

  /* Skeleton Loading */
  .skeleton {
    background: linear-gradient(90deg, #1c1917 25%, #292524 50%, #1c1917 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
  }
  @keyframes skeleton-loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
  }

  /* Reduced motion */
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
    }
    .animate-slide-up, .animate-fade-in {
      opacity: 1;
      animation: none;
    }
  }

  /* Fallback CSS: garante que conteúdo data-reveal nunca fique invisível permanentemente */
  [data-reveal] {
    opacity: 1 !important;
    transform: none !important;
  }
  /* Quando JS está ativo e elemento ainda não foi revelado, aplica animação */
  .js [data-reveal]:not(.is-revealed) {
    opacity: 0 !important;
    transform: translateY(40px) !important;
  }
  .js [data-reveal].is-revealed {
    opacity: 1 !important;
    transform: translateY(0) !important;
  }
</style>

<!-- Core Utilities (must load first) -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/utils.js" defer></script>
<!-- Premium Interactions -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/premium-interactions.js" defer></script>
<?php if (!function_exists('wp_enqueue_scripts')): ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/slider.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/navigation.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/forms.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js" defer></script>
<?php endif; ?>

<!-- Schema JSON-LD -->
<script type="application/ld+json"><?php echo $schema_localbusiness; ?></script>
<?php foreach ($schema_blocks as $block): ?>
<script type="application/ld+json"><?php echo $block; ?></script>
<?php endforeach; ?>
<script>
window.santafeConfig = Object.assign(window.santafeConfig || {}, {
  ga4Id: <?php echo wp_json_encode(GA4_ID); ?>,
  gtmId: <?php echo wp_json_encode(GTM_ID); ?>,
  analyticsEnabled: <?php echo SANTAFE_ENABLE_ANALYTICS ? 'true' : 'false'; ?>,
  csrfToken: <?php echo wp_json_encode($_SESSION['csrf_token']); ?>,
  whatsappNumber: <?php echo wp_json_encode(WHATSAPP_NUMBER); ?>
});
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
  ad_storage: 'denied',
  analytics_storage: 'denied',
  ad_user_data: 'denied',
  ad_personalization: 'denied'
});
</script>
<?php wp_head(); ?>
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
</head>
<body class="bg-white text-warm-900 antialiased selection:bg-brand-500 selection:text-white pb-20 lg:pb-0 <?php echo isset($body_class) ? esc_attr($body_class) : ''; ?>">

<!-- Scroll Progress Bar -->
<div id="scroll-progress" aria-hidden="true"></div>

<!-- Sticky Section Dots (desktop only, homepage only) -->
<nav class="fixed right-6 top-1/2 -translate-y-1/2 z-40 hidden xl:flex-col xl:flex gap-3<?php echo isset($is_homepage) && $is_homepage ? '' : ' hidden'; ?>" id="section-dots" aria-label="Navegación de secciones">
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#inicio" aria-label="Inicio"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#dores-solucoes" aria-label="Problemas y soluciones"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#servicios" aria-label="Servicios"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#proceso" aria-label="Proceso"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#portfolio" aria-label="Portfolio"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#testimonios" aria-label="Testimonios"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#garantias" aria-label="Garantías"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#faq" aria-label="FAQ"></button>
    <button class="section-dot w-2.5 h-2.5 rounded-full bg-slate-600 hover:bg-slate-400 transition-all" data-target="#contacto" aria-label="Contacto"></button>
</nav>

<!-- Skip Link -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:bg-brand-600 focus:text-white focus:px-4 focus:py-2 focus:rounded-md focus:font-semibold">
  <?php echo t($translations, 'nav.skip_to_content'); ?>
</a>

<!-- Navigation -->
<header id="site-nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500" data-header>
  <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between transition-all duration-500" data-header-inner>
    <a href="/<?php echo $lang; ?>/" class="flex items-end gap-3.5 group" aria-label="Construcciones Santa Fe — Inicio">
      <!-- Logo house: aspect-ratio maintains proportions, only height is fixed -->
      <div class="relative flex-shrink-0 h-[3.25rem] logo-aspect">
        <img src="/assets/img/logo-casa-cut-darkmode.png" alt="Construcciones Santa Fe" class="h-full w-auto absolute inset-0 transition-opacity duration-500" data-logo-dark>
        <img src="/assets/img/logo-casa-cut.png" alt="Construcciones Santa Fe" class="h-full w-auto absolute inset-0 opacity-0 transition-opacity duration-500" data-logo-light>
      </div>
      <!-- Brand text: vertically centered with the house icon -->
      <div class="flex flex-col leading-[0.85]">
        <span class="font-display font-bold text-[1.65rem] tracking-[0.02em] block transition-colors duration-500" data-brand-text>SANTA FE</span>
        <span class="text-[0.7rem] uppercase tracking-[0.3em] transition-colors duration-500 mt-2.5" data-brand-sub><?php echo $lang === 'ca' ? 'Construccions' : 'Construcciones'; ?></span>
      </div>
    </a>

    <nav class="hidden lg:flex items-center gap-8" role="navigation" aria-label="Principal">
      <a href="/<?php echo $lang; ?>/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link><?php echo t($translations, 'nav.home'); ?></a>
      <div class="relative group">
        <a href="/<?php echo $lang; ?>/<?php echo $nav_services_path; ?>/" class="text-sm font-medium transition-colors tracking-wide inline-flex items-center gap-1" data-nav-link aria-haspopup="true" aria-expanded="false"><?php echo t($translations, 'nav.services'); ?><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 opacity-60" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg></a>
        <div class="absolute left-0 top-full pt-4 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto group-focus-within:opacity-100 group-focus-within:pointer-events-auto transition-all" role="menu" aria-label="Submenú de servicios">
          <div class="w-72 bg-white border border-warm-200 rounded-sm shadow-2xl p-3">
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'obra-nova' : 'obra-nueva'; ?>/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Obra nueva</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-integrals' : 'reformas-integrales'; ?>/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Reformas integrales</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'pladur-acabats' : 'pladur-acabados'; ?>/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Pladur y acabados</a>
            <a href="/<?php echo $lang; ?>/obra-publica/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Obra pública</a>
            <a href="/<?php echo $lang; ?>/obra-civil/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Obra civil</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'parquet-paviments' : 'parquet-pavimentos'; ?>/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Parquet y pavimentos</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-banys' : 'reformas-banos'; ?>/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Reforma de baños</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'rehabilitacio-facanes' : 'rehabilitacion-fachadas'; ?>/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Rehabilitación de fachadas</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-comercials' : 'reformas-comerciales'; ?>/" class="block px-4 py-3 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm">Reformas comerciales</a>
          </div>
        </div>
      </div>
      <a href="/<?php echo $lang; ?>/<?php echo $nav_projects_path; ?>/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link><?php echo t($translations, 'nav.projects'); ?></a>
      <a href="/<?php echo $lang; ?>/<?php echo $nav_about_path; ?>/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link><?php echo t($translations, 'nav.about'); ?></a>
      <a href="/<?php echo $lang; ?>/blog/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link>Blog</a>
      <a href="tel:<?php echo COMPANY_PHONE; ?>" class="text-sm font-semibold text-brand-400 hover:text-brand-300 transition-colors" data-track-event="phone_click">Llámanos: <?php echo COMPANY_PHONE_DISPLAY; ?></a>
      <a href="/<?php echo $lang; ?>/<?php echo $nav_contact_path; ?>/" class="text-sm font-semibold bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-sm transition-all tracking-wide" data-nav-cta>Presupuesto gratuito</a>
      <a href="<?php echo get_alt_url($current_route ?? '', 'es'); ?>" hreflang="es_ES" class="text-xs font-medium border px-2 py-1 rounded-sm transition-colors <?php echo $lang === 'es' ? 'opacity-100' : 'opacity-60'; ?>" data-lang-btn>ES</a>
      <a href="<?php echo get_alt_url($current_route ?? '', 'ca'); ?>" hreflang="ca_ES" class="text-xs font-medium border px-2 py-1 rounded-sm transition-colors <?php echo $lang === 'ca' ? 'opacity-100' : 'opacity-60'; ?>" data-lang-btn>CA</a>
      <button type="button" id="theme-toggle" class="p-2 rounded-sm transition-colors" data-theme-btn aria-label="<?php echo t($translations, 'nav.toggle_theme'); ?>">
        <svg id="theme-icon-sun" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
        <svg id="theme-icon-moon" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/></svg>
      </button>
    </nav>

    <button type="button" class="lg:hidden p-2 transition-colors duration-500" id="menu-toggle" aria-label="<?php echo t($translations, 'nav.menu_open'); ?>" aria-expanded="false" data-menu-btn>
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
  </div>
</header>

<!-- Mobile Menu — Fullscreen, Masterfully Designed -->
<div id="mobile-menu" class="mobile-menu fixed inset-0 bg-white flex flex-col lg:hidden">
  <!-- Fixed Header Bar with X -->
  <div class="sticky top-0 z-10 flex items-center justify-end px-6 py-4 bg-white/95 backdrop-blur-sm border-b border-warm-100">
    <button type="button" id="menu-close" class="flex items-center justify-center w-10 h-10 rounded-full bg-warm-100 text-warm-900 hover:bg-brand-600 hover:text-white transition-all duration-300" aria-label="<?php echo t($translations, 'nav.menu_close'); ?>">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>

  <!-- Scrollable Menu Content -->
  <div class="flex-1 flex flex-col overflow-y-auto px-6 py-6 gap-1">
    <!-- Services with accordion submenu -->
    <div class="mobile-nav-group border-b border-warm-100 pb-4 mb-2">
      <div class="flex items-center justify-between py-3">
        <a href="/<?php echo $lang; ?>/<?php echo $nav_services_path; ?>/" class="text-xl font-display font-bold text-warm-900 mobile-nav-link tracking-tight"><?php echo t($translations, 'nav.services'); ?></a>
        <button type="button" class="mobile-submenu-toggle flex items-center justify-center w-10 h-10 rounded-full bg-warm-50 text-warm-500 hover:bg-brand-600 hover:text-white transition-all duration-300" aria-expanded="false" aria-controls="mobile-submenu-services" aria-label="<?php echo t($translations, 'nav.toggle_services'); ?>">
          <svg class="submenu-chevron w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
        </button>
      </div>
      <div id="mobile-submenu-services" class="mobile-submenu-panel space-y-0.5 pl-2">
        <a href="/<?php echo $lang; ?>/<?php echo $nav_services_path; ?>/" class="block px-4 py-2.5 text-sm font-semibold text-warm-700 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors"><?php echo t($translations, 'nav.all_services'); ?></a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'obra-nova' : 'obra-nueva'; ?>/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Obra nueva</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-integrals' : 'reformas-integrales'; ?>/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Reformas integrales</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'pladur-acabats' : 'pladur-acabados'; ?>/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Pladur y acabados</a>
        <a href="/<?php echo $lang; ?>/obra-publica/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Obra pública</a>
        <a href="/<?php echo $lang; ?>/obra-civil/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Obra civil</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'parquet-paviments' : 'parquet-pavimentos'; ?>/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Parquet y pavimentos</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-banys' : 'reformas-banos'; ?>/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Reforma de baños</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'rehabilitacio-facanes' : 'rehabilitacion-fachadas'; ?>/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Rehabilitación de fachadas</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-comercials' : 'reformas-comerciales'; ?>/" class="block px-4 py-2.5 text-sm text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-lg mobile-nav-link transition-colors">Reformas comerciales</a>
      </div>
    </div>

    <!-- Main Nav Links -->
    <a href="/<?php echo $lang; ?>/<?php echo $nav_projects_path; ?>/" class="mobile-nav-item block py-3 text-xl font-display font-bold text-warm-900 mobile-nav-link border-b border-warm-100 tracking-tight"><?php echo t($translations, 'nav.projects'); ?></a>
    <a href="/<?php echo $lang; ?>/<?php echo $nav_about_path; ?>/" class="mobile-nav-item block py-3 text-xl font-display font-bold text-warm-900 mobile-nav-link border-b border-warm-100 tracking-tight"><?php echo t($translations, 'nav.about'); ?></a>
    <a href="/<?php echo $lang; ?>/blog/" class="mobile-nav-item block py-3 text-xl font-display font-bold text-warm-900 mobile-nav-link border-b border-warm-100 tracking-tight">Blog</a>

    <!-- CTA Section -->
    <div class="mt-auto pt-6 pb-8 flex flex-col gap-4">
      <a href="tel:<?php echo COMPANY_PHONE; ?>" class="flex items-center gap-3 text-lg font-semibold text-brand-600 mobile-nav-link" data-track-event="phone_click">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
        <?php echo COMPANY_PHONE_DISPLAY; ?>
      </a>
      <a href="/<?php echo $lang; ?>/<?php echo $nav_contact_path; ?>/" class="block w-full text-center py-3.5 bg-brand-600 hover:bg-brand-500 text-white font-semibold rounded-lg transition-all tracking-wide">
        <?php echo t($translations, 'nav.contact'); ?>
      </a>
      <div class="flex items-center justify-center gap-4 mt-2">
        <a href="<?php echo get_alt_url($current_route ?? '', 'es'); ?>" hreflang="es_ES" class="text-base font-medium border-2 px-4 py-2 rounded-lg transition-colors <?php echo $lang === 'es' ? 'text-brand-500 border-brand-500' : 'text-warm-500 border-warm-300 hover:text-brand-500 hover:border-brand-500'; ?>">ES</a>
        <a href="<?php echo get_alt_url($current_route ?? '', 'ca'); ?>" hreflang="ca_ES" class="text-base font-medium border-2 px-4 py-2 rounded-lg transition-colors <?php echo $lang === 'ca' ? 'text-brand-500 border-brand-500' : 'text-warm-500 border-warm-300 hover:text-brand-500 hover:border-brand-500'; ?>">CA</a>
        <button type="button" id="theme-toggle-mobile" class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-warm-200 text-warm-600 hover:border-brand-500 hover:text-brand-500 transition-all" data-theme-btn aria-label="<?php echo t($translations, 'nav.toggle_theme'); ?>">
          <svg class="theme-icon-sun w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
          <svg class="theme-icon-moon w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/></svg>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- WhatsApp Float -->
<a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20estoy%20interesado%20en%20una%20reforma" 
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-[#25d366] hover:bg-[#128c7e] text-white rounded-full flex items-center justify-center shadow-2xl transition-all hover:scale-110" 
   target="_blank" rel="noopener noreferrer"
   title="Hablar con Paulo por WhatsApp"
   data-track-event="whatsapp_click"
   aria-label="<?php echo t($translations, 'footer.whatsapp_label'); ?>">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<!-- Main content wrapper -->
<main id="main-content" role="main">
