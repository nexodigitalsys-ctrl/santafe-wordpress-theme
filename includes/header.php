<?php
/**
 * Header semántico con Tailwind CSS
 * Incluir al inicio de cada página con $page_data configurado
 */

declare(strict_types=1);

require_once __DIR__ . '/i18n.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/seo.php';
require_once __DIR__ . '/schema-localbusiness.php';

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

$og_image = $domain . '/assets/images/og-default.jpg';

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
?>
<!DOCTYPE html>
<html lang="<?php echo $locale; ?>" class="scroll-smooth">
<head>
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

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Tailwind CSS v4 CDN with custom config -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['Space Grotesk', 'Inter', 'sans-serif'],
      },
      colors: {
                brand: { 50:'#fff8e8',100:'#ffedc0',200:'#f7d887',300:'#e8c878',400:'#d4a853',500:'#d4a853',600:'#b98a33',700:'#8b6426',800:'#5f421b',900:'#362410',950:'#1e1408' },
        slate: { 50:'#f4f4f5',100:'#e3e4e6',200:'#c8cace',300:'#a5a9ae',400:'#7e838a',500:'#63676e',600:'#4e5157',700:'#3a3c42',800:'#2a2c31',900:'#212225',950:'#121315' },
      }
    }
  }
}
</script>
<style type="text/tailwindcss">
@layer base {
  body { font-family: 'Inter', system-ui, sans-serif; }
  ::-webkit-scrollbar { width: 8px; }
  ::-webkit-scrollbar-track { background: #121315; }
  ::-webkit-scrollbar-thumb { background: #3a3c42; border-radius: 4px; }
  ::-webkit-scrollbar-thumb:hover { background: #63676e; }
}
@layer components {
  .font-display { font-family: 'Space Grotesk', 'Inter', sans-serif; }
  .industrial-line { height: 2px; background: linear-gradient(90deg, #D4A853 0%, transparent 100%); }
  .card-lift { transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease; }
  .card-lift:hover { transform: translateY(-8px); box-shadow: 0 24px 48px -12px rgba(0,0,0,0.4); }
  .img-zoom { transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
  .img-zoom:hover { transform: scale(1.08); }
  .big-number { font-variant-numeric: tabular-nums; letter-spacing: -0.04em; }
}
@layer utilities {
  .animate-slide-up { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
  .animate-fade-in { animation: fadeIn 1s ease forwards; opacity: 0; }
  .delay-100 { animation-delay: 0.1s; }
  .delay-200 { animation-delay: 0.2s; }
  .delay-300 { animation-delay: 0.3s; }
  .delay-400 { animation-delay: 0.4s; }
  .delay-500 { animation-delay: 0.5s; }
}
@keyframes slideUp {
  from { opacity: 0; transform: translateY(60px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
<style>
  /* Header scroll-reveal — Architect's Bar */
  .header-scrolled {
    background-color: rgba(12, 12, 14, 0.96) !important;
    backdrop-filter: blur(24px) saturate(1.4);
    -webkit-backdrop-filter: blur(24px) saturate(1.4);
    border-bottom: 2px solid #D4A853;
    box-shadow: 
      0 0 40px rgba(212, 168, 83, 0.22),
      0 4px 20px rgba(212, 168, 83, 0.14),
      0 8px 40px rgba(0, 0, 0, 0.5);
  }
  .header-scrolled [data-brand-text] { color: #D4A853; text-shadow: 0 0 12px rgba(212,168,83,0.35); }
  .header-scrolled [data-brand-sub] { color: rgba(212,168,83,0.85); text-shadow: 0 0 8px rgba(212,168,83,0.25); }
  .header-scrolled [data-nav-link] { color: rgba(255,255,255,0.85); }
  .header-scrolled [data-nav-link]:hover { color: #ffffff; }
  .header-scrolled [data-lang-btn] { color: rgba(255,255,255,0.6); border-color: rgba(255,255,255,0.2); }
  .header-scrolled [data-lang-btn]:hover { color: #ffffff; border-color: rgba(255,255,255,0.5); }
  .header-scrolled [data-menu-btn] { color: #ffffff; }
  .header-scrolled [data-logo-dark] { opacity: 1 !important; }
  .header-scrolled [data-logo-light] { opacity: 0 !important; }
  /* Default top state */
  [data-nav-link] { color: #c8cace; transition: color 0.3s; }
  [data-nav-link]:hover { color: #ffffff; }
  [data-lang-btn] { color: #a5a9ae; border-color: #3a3c42; transition: all 0.3s; }
  [data-lang-btn]:hover { color: #ffffff; border-color: #a5a9ae; }
  [data-menu-btn] { color: #ffffff; }
  [data-logo-dark] { opacity: 1; }
  [data-logo-light] { opacity: 0 !important; }
  [data-brand-text] { color: #ffffff; }
  [data-brand-sub] { color: rgba(255,255,255,0.65); }

  /* Hero background (moved from inline style) */
  .hero-bg { background-image: url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1920&q=80'); }
  
  /* Industrial line reversed */
  .industrial-line-reverse { background: linear-gradient(270deg, #D4A853 0%, transparent 100%) !important; }
  
  /* CTA background pattern (moved from inline style) */
  .cta-bg-pattern { background-image: repeating-linear-gradient(90deg, #D4A853 0px, #D4A853 1px, transparent 1px, transparent 80px); }
  
  /* Logo aspect ratio (moved from inline style) */
  .logo-aspect { aspect-ratio: 1656/551; }

  /* Mobile menu */
  .mobile-menu {
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .mobile-menu.open {
    transform: translateX(0);
  }
</style>

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
<body class="bg-slate-950 text-slate-50 antialiased selection:bg-brand-500 selection:text-white">

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
        <span class="font-display font-bold text-[400px] tracking-[0.02em] block transition-colors duration-500" data-brand-text>SANTA FE</span>
        <span class="text-[0.7rem] uppercase tracking-[0.3em] transition-colors duration-500 mt-1.5" data-brand-sub><?php echo $lang === 'ca' ? 'Construccions · 2008' : 'Construcciones · 2008'; ?></span>
      </div>
    </a>

    <nav class="hidden lg:flex items-center gap-8" role="navigation" aria-label="Principal">
      <a href="/<?php echo $lang; ?>/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link><?php echo t($translations, 'nav.home'); ?></a>
      <div class="relative group">
        <a href="/<?php echo $lang; ?>/servicios/" class="text-sm font-medium transition-colors tracking-wide inline-flex items-center gap-1" data-nav-link><?php echo t($translations, 'nav.services'); ?><span aria-hidden="true">v</span></a>
        <div class="absolute left-0 top-full pt-4 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all">
          <div class="w-72 bg-slate-950 border border-slate-800 rounded-sm shadow-2xl p-3">
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'obra-nova' : 'obra-nueva'; ?>/" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-900 rounded-sm">Obra nueva</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'reformes-integrals' : 'reformas-integrales'; ?>/" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-900 rounded-sm">Reformas integrales</a>
            <a href="/<?php echo $lang; ?>/<?php echo $lang === 'ca' ? 'pladur-acabats' : 'pladur-acabados'; ?>/" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-900 rounded-sm">Pladur y acabados</a>
            <a href="/<?php echo $lang; ?>/obra-publica/" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-900 rounded-sm">Obra pública</a>
            <a href="/<?php echo $lang; ?>/obra-civil/" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-900 rounded-sm">Obra civil</a>
          </div>
        </div>
      </div>
      <a href="/<?php echo $lang; ?>/proyectos/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link><?php echo t($translations, 'nav.projects'); ?></a>
      <a href="/<?php echo $lang; ?>/sobre-nosotros/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link><?php echo t($translations, 'nav.about'); ?></a>
      <a href="/<?php echo $lang; ?>/blog/" class="text-sm font-medium transition-colors tracking-wide" data-nav-link>Blog</a>
      <a href="tel:<?php echo COMPANY_PHONE; ?>" class="text-sm font-semibold text-brand-400 hover:text-brand-300 transition-colors" data-track-event="phone_click">Llámanos: <?php echo COMPANY_PHONE_DISPLAY; ?></a>
      <a href="/<?php echo $lang; ?>/contacto/" class="text-sm font-semibold bg-brand-600 hover:bg-brand-500 text-slate-950 px-5 py-2.5 rounded-sm transition-all tracking-wide" data-nav-cta>Presupuesto gratuito</a>
      <a href="<?php echo $alt_url; ?>" hreflang="<?php echo $alt_locale; ?>" class="text-xs font-medium border px-2 py-1 rounded-sm transition-colors <?php echo $lang === 'es' ? 'opacity-100' : 'opacity-60'; ?>" data-lang-btn>ES</a>
      <a href="<?php echo $alt_url; ?>" hreflang="<?php echo $alt_locale; ?>" class="text-xs font-medium border px-2 py-1 rounded-sm transition-colors <?php echo $lang === 'ca' ? 'opacity-100' : 'opacity-60'; ?>" data-lang-btn>CA</a>
    </nav>

    <button type="button" class="lg:hidden p-2 transition-colors duration-500" id="menu-toggle" aria-label="<?php echo t($translations, 'nav.menu_open'); ?>" aria-expanded="false" data-menu-btn>
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="mobile-menu fixed inset-0 bg-slate-950/98 backdrop-blur-xl z-40 flex flex-col items-center justify-center gap-8 lg:hidden">
    <button type="button" id="menu-close" class="absolute top-6 right-6 text-white p-2" aria-label="<?php echo t($translations, 'nav.menu_close'); ?>">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <a href="/<?php echo $lang; ?>/servicios/" class="text-2xl font-display font-bold text-white mobile-nav-link"><?php echo t($translations, 'nav.services'); ?></a>
    <a href="/<?php echo $lang; ?>/proyectos/" class="text-2xl font-display font-bold text-white mobile-nav-link"><?php echo t($translations, 'nav.projects'); ?></a>
    <a href="/<?php echo $lang; ?>/sobre-nosotros/" class="text-2xl font-display font-bold text-white mobile-nav-link"><?php echo t($translations, 'nav.about'); ?></a>
    <a href="/<?php echo $lang; ?>/blog/" class="text-2xl font-display font-bold text-white mobile-nav-link">Blog</a>
    <a href="tel:<?php echo COMPANY_PHONE; ?>" class="text-xl font-display font-bold text-brand-400 mobile-nav-link" data-track-event="phone_click"><?php echo COMPANY_PHONE_DISPLAY; ?></a>
    <a href="/<?php echo $lang; ?>/contacto/" class="text-2xl font-display font-bold text-brand-500 mobile-nav-link"><?php echo t($translations, 'nav.contact'); ?></a>
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
