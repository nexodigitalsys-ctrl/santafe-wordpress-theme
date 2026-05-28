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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?php echo $page_title; ?></title>
<meta name="description" content="<?php echo $page_desc; ?>">
<meta name="robots" content="index, follow">
<meta name="author" content="Construcciones Santa Fe Siglo XXI SLU">
<meta name="geo.region" content="ES-CT">
<meta name="geo.placename" content="Barcelona, Girona">

<link rel="canonical" href="<?php echo $canonical; ?>">
<link rel="alternate" hreflang="<?php echo $locale; ?>" href="<?php echo $canonical; ?>">
<link rel="alternate" hreflang="<?php echo $alt_locale; ?>" href="<?php echo $domain . $alt_url; ?>">
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
  }

  /* Base styles */
  body { font-family: 'Inter', system-ui, sans-serif; }
  ::-webkit-scrollbar { width: 8px; }
  ::-webkit-scrollbar-track { background: #121315; }
  ::-webkit-scrollbar-thumb { background: #3a3c42; border-radius: 4px; }
  ::-webkit-scrollbar-thumb:hover { background: #63676e; }

  /* Component utilities */
  .font-display { font-family: 'Space Grotesk', 'Inter', sans-serif; }
  .industrial-line { height: 2px; background: linear-gradient(90deg, #AE232A 0%, transparent 100%); }
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

  /* Header — Light mode (default): white, Dark mode: slate */
   * Scroll only adds shadow, colors are theme-driven
   */
  #site-nav {
    background-color: #ffffff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  }
  html.dark #site-nav {
    background-color: #0f172a;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  }
  #site-nav.header-scrolled {
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
  }
  html.dark #site-nav.header-scrolled {
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
  }

  /* Light mode text colors */
  [data-nav-link] { color: #44403c; transition: color 0.3s; }
  [data-nav-link]:hover { color: #1c1917; }
  [data-lang-btn] { color: #78716c; border-color: rgba(0,0,0,0.15); transition: all 0.3s; }
  [data-lang-btn]:hover { color: #1c1917; border-color: rgba(0,0,0,0.3); }
  [data-menu-btn] { color: #44403c; }
  [data-brand-text] { color: #1c1917; }
  [data-brand-sub] { color: #78716c; }

  /* Theme toggle button */
  [data-theme-btn] { color: #44403c; }
  [data-theme-btn]:hover { color: #dc2626; }

  /* Dark mode text colors */
  html.dark [data-nav-link] { color: rgba(255,255,255,0.85); }
  html.dark [data-nav-link]:hover { color: #fff; }
  html.dark [data-lang-btn] { color: rgba(255,255,255,0.6); border-color: rgba(255,255,255,0.2); }
  html.dark [data-lang-btn]:hover { color: #fff; border-color: rgba(255,255,255,0.4); }
  html.dark [data-menu-btn] { color: #fff; }
  html.dark [data-brand-text] { color: #fff; }
  html.dark [data-brand-sub] { color: rgba(255,255,255,0.6); }
  html.dark [data-theme-btn] { color: rgba(255,255,255,0.85); }
  html.dark [data-theme-btn]:hover { color: #f87171; }

  /* Logo: light mode shows dark logo, dark mode shows light logo */
  [data-logo-dark] { opacity: 0 !important; }
  [data-logo-light] { opacity: 1 !important; }
  html.dark [data-logo-dark] { opacity: 1 !important; }
  html.dark [data-logo-light] { opacity: 0 !important; }

  /* Phone link adjusts per theme */
  html.dark [data-track-event="phone_click"] { color: #f87171 !important; }
  html.dark [data-track-event="phone_click"]:hover { color: #fca5a5 !important; }

  /* Industrial line reversed */
  .industrial-line-reverse { background: linear-gradient(270deg, #AE232A 0%, transparent 100%) !important; }

  /* CTA background pattern */
  .cta-bg-pattern { background-image: repeating-linear-gradient(90deg, #AE232A 0px, #AE232A 1px, transparent 1px, transparent 80px); }

  /* Logo aspect ratio */
  .logo-aspect { aspect-ratio: 1656/551; }

  /* Mobile menu */
  .mobile-menu {
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .mobile-menu.open {
    transform: translateX(0);
  }

  /* Scroll lock when mobile menu is open — prevents flash/reflow */
  html.menu-open,
  html.menu-open body {
    overflow: hidden;
    touch-action: none;
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
  html.dark .mobile-menu { background-color: #0f172a; }
  html.dark #menu-close { color: #e2e8f0; }
  html.dark .mobile-submenu-toggle { color: #94a3b8; }
  html.dark .mobile-submenu-toggle:hover { color: #f87171; }
  html.dark .mobile-submenu-panel a { color: #cbd5e1; }
  html.dark .mobile-submenu-panel a:hover { color: #f87171; background-color: #1e293b; }
  html.dark .mobile-nav-link { color: #e2e8f0 !important; }
  html.dark .mobile-nav-link[data-track-event="phone_click"] { color: #f87171 !important; }
  html.dark #menu-close { color: #e2e8f0; }
  html.dark .header-scrolled { background-color: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(12px); }
  html.dark .header-scrolled [data-nav-link] { color: rgba(226, 232, 240, 0.85); }
  html.dark .header-scrolled [data-nav-link]:hover { color: #fff; }
  html.dark .header-scrolled [data-lang-btn] { color: rgba(226, 232, 240, 0.6); border-color: rgba(226, 232, 240, 0.2); }
  html.dark .header-scrolled [data-lang-btn]:hover { color: #fff; border-color: rgba(226, 232, 240, 0.4); }
  html.dark .header-scrolled [data-menu-btn] { color: #e2e8f0; }
  html.dark .header-scrolled [data-brand-text] { color: #e2e8f0; }
  html.dark .header-scrolled [data-brand-sub] { color: rgba(226, 232, 240, 0.6); }
  html.dark .header-scrolled [data-nav-cta] { background-color: #dc2626; }
  html.dark .header-scrolled [data-nav-cta]:hover { background-color: #b91c1c; }
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
  html.dark [class*="text-warm-700"] { color: #94a3b8 !important; }
  html.dark .text-warm-600,
  html.dark [class*="text-warm-600"] { color: #94a3b8 !important; }
  html.dark .text-warm-500,
  html.dark [class*="text-warm-500"] { color: #94a3b8 !important; }
  html.dark .border-warm-200,
  html.dark .border-warm-100,
  html.dark [class*="border-warm-200"],
  html.dark [class*="border-warm-100"] { border-color: #334155 !important; }
  html.dark footer { background-color: #0c0a09; }
  html.dark #scroll-progress { box-shadow: 0 0 10px rgba(248, 113, 113, 0.5); }

  /* Catch-all for gray/slate text colors in dark mode */
  html.dark .text-gray-500,
  html.dark .text-gray-600,
  html.dark .text-slate-500,
  html.dark .text-slate-600,
  html.dark .text-slate-700,
  html.dark .text-slate-800 { color: #94a3b8 !important; }

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
    background: linear-gradient(90deg, #AE232A, #f87171);
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
</head>
<body class="bg-white text-warm-900 antialiased selection:bg-brand-500 selection:text-white pb-20 lg:pb-0">

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


  <!-- Mobile Menu -->
  <div id="mobile-menu" class="mobile-menu fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center gap-6 lg:hidden overflow-y-auto py-20">
    <button type="button" id="menu-close" class="absolute top-6 right-6 text-warm-900 p-2" aria-label="<?php echo t($translations, 'nav.menu_close'); ?>">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>

    <!-- Services with accordion submenu -->
    <div class="w-full max-w-xs px-6">
      <div class="flex items-center justify-between">
        <a href="/<?php echo $lang; ?>/<?php echo $nav_services_path; ?>/" class="text-2xl font-display font-bold text-warm-900 mobile-nav-link"><?php echo t($translations, 'nav.services'); ?></a>
        <button type="button" class="mobile-submenu-toggle p-2 text-warm-500 hover:text-brand-600 transition-colors" aria-expanded="false" aria-controls="mobile-submenu-services" aria-label="<?php echo t($translations, 'nav.toggle_services'); ?>">
          <svg class="submenu-chevron w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
        </button>
      </div>
      <div id="mobile-submenu-services" class="mobile-submenu-panel mt-2 space-y-1">
        <a href="/<?php echo $lang; ?>/<?php echo $nav_services_path; ?>/" class="block px-4 py-2 text-sm font-medium text-warm-600 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link"><?php echo t($translations, 'nav.all_services'); ?></a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'obra-nova' : 'obra-nueva'; ?>/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Obra nueva</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-integrals' : 'reformas-integrales'; ?>/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Reformas integrales</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'pladur-acabats' : 'pladur-acabados'; ?>/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Pladur y acabados</a>
        <a href="/<?php echo $lang; ?>/obra-publica/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Obra pública</a>
        <a href="/<?php echo $lang; ?>/obra-civil/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Obra civil</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'parquet-paviments' : 'parquet-pavimentos'; ?>/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Parquet y pavimentos</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-banys' : 'reformas-banos'; ?>/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Reforma de baños</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'rehabilitacio-facanes' : 'rehabilitacion-fachadas'; ?>/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Rehabilitación de fachadas</a>
        <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-comercials' : 'reformas-comerciales'; ?>/" class="block px-4 py-2 text-sm text-warm-500 hover:text-brand-600 hover:bg-warm-50 rounded-sm mobile-nav-link">Reformas comerciales</a>
      </div>
    </div>

    <a href="/<?php echo $lang; ?>/<?php echo $nav_projects_path; ?>/" class="text-2xl font-display font-bold text-warm-900 mobile-nav-link"><?php echo t($translations, 'nav.projects'); ?></a>
    <a href="/<?php echo $lang; ?>/<?php echo $nav_about_path; ?>/" class="text-2xl font-display font-bold text-warm-900 mobile-nav-link"><?php echo t($translations, 'nav.about'); ?></a>
    <a href="/<?php echo $lang; ?>/blog/" class="text-2xl font-display font-bold text-warm-900 mobile-nav-link">Blog</a>
    <a href="tel:<?php echo COMPANY_PHONE; ?>" class="text-xl font-display font-bold text-brand-600 mobile-nav-link" data-track-event="phone_click"><?php echo COMPANY_PHONE_DISPLAY; ?></a>
    <a href="/<?php echo $lang; ?>/<?php echo $nav_contact_path; ?>/" class="text-2xl font-display font-bold text-brand-600 mobile-nav-link"><?php echo t($translations, 'nav.contact'); ?></a>
    <div class="flex items-center gap-4 mt-4">
      <a href="<?php echo get_alt_url($current_route ?? '', 'es'); ?>" hreflang="es_ES" class="text-lg font-medium border-2 px-4 py-2 rounded-sm transition-colors <?php echo $lang === 'es' ? 'text-brand-500 border-brand-500' : 'text-warm-500 border-warm-300 hover:text-brand-500 hover:border-brand-500'; ?>">ES</a>
      <a href="<?php echo get_alt_url($current_route ?? '', 'ca'); ?>" hreflang="ca_ES" class="text-lg font-medium border-2 px-4 py-2 rounded-sm transition-colors <?php echo $lang === 'ca' ? 'text-brand-500 border-brand-500' : 'text-warm-500 border-warm-300 hover:text-brand-500 hover:border-brand-500'; ?>">CA</a>
      <button type="button" id="theme-toggle-mobile" class="p-2 rounded-sm transition-colors" data-theme-btn aria-label="<?php echo t($translations, 'nav.toggle_theme'); ?>">
        <svg class="theme-icon-sun w-6 h-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
        <svg class="theme-icon-moon w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/></svg>
      </button>
    </div>
  </div>
</header>

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
