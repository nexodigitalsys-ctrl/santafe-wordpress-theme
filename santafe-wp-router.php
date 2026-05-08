<?php
declare(strict_types=1);
/**
 * WordPress-compatible router for the preserved Santa Fe PHP/Tailwind template.
 * It keeps the original page files and Tailwind CDN approach, only adapting routing and asset URLs.
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/includes/i18n.php';
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/schema-services.php';

$lang = get_query_var('santafe_lang');
$lang = in_array($lang, ['es', 'ca'], true) ? $lang : 'es';

$route = get_query_var('santafe_route');
$route = is_string($route) ? trim($route, '/') : '';
$route = preg_replace('/[^a-z0-9\-\/]/', '', $route);

$routes = [
    '' => 'home.php',
    'servicios' => 'servicios.php',
    'servicios/obra-nueva' => 'servicio.php',
    'servicios/reformas-integrales' => 'servicio.php',
    'servicios/pladur-acabados' => 'servicio.php',
    'servicios/obra-publica' => 'servicio.php',
    'servicios/obra-civil' => 'servicio.php',
    'obra-nueva' => 'servicio.php',
    'reformas-integrales' => 'servicio.php',
    'pladur-acabados' => 'servicio.php',
    'obra-publica' => 'servicio.php',
    'obra-civil' => 'servicio.php',
    'reformas-barcelona' => 'seo-local.php',
    'reformas-girona' => 'seo-local.php',
    'reformas-tarragona' => 'seo-local.php',
    'obra-nueva-barcelona' => 'seo-local.php',
    'obra-nueva-girona' => 'seo-local.php',
    'reformas-integrales-barcelona' => 'seo-local.php',
    'reformas-integrales-girona' => 'seo-local.php',
    'pladur-barcelona' => 'seo-local.php',
    'pladur-girona' => 'seo-local.php',
    'blog' => 'blog.php',
    'proyectos' => 'proyectos.php',
    'sobre-nosotros' => 'sobre-nosotros.php',
    'contacto' => 'contacto.php',
    'aviso-legal' => 'legal.php',
    'politica-privacidad' => 'legal.php',
    'politica-cookies' => 'legal.php',
];

$ca_routes = [
    '' => 'home.php',
    'serveis' => 'servicios.php',
    'serveis/obra-nova' => 'servicio.php',
    'serveis/reformes-integrals' => 'servicio.php',
    'serveis/pladur-acabats' => 'servicio.php',
    'serveis/obra-publica' => 'servicio.php',
    'serveis/obra-civil' => 'servicio.php',
    'obra-nova' => 'servicio.php',
    'reformes-integrals' => 'servicio.php',
    'pladur-acabats' => 'servicio.php',
    'obra-publica' => 'servicio.php',
    'obra-civil' => 'servicio.php',
    'blog' => 'blog.php',
    'projectes' => 'proyectos.php',
    'sobre-nosaltres' => 'sobre-nosotros.php',
    'contacte' => 'contacto.php',
    'avis-legal' => 'legal.php',
    'politica-privacitat' => 'legal.php',
    'politica-cookies' => 'legal.php',
];

$page_file = null;
if ($lang === 'ca' && isset($ca_routes[$route])) {
    $page_file = $ca_routes[$route];
} elseif (isset($routes[$route])) {
    $page_file = $routes[$route];
}

if (!$page_file || !file_exists(__DIR__ . '/pages/' . $page_file)) {
    status_header(404);
    $page_file = file_exists(__DIR__ . '/pages/404.php') ? '404.php' : 'home.php';
}

$current_route = $route;
$current_lang = $lang;

ob_start();
require __DIR__ . '/pages/' . $page_file;
$html = ob_get_clean();

$theme_uri = get_template_directory_uri();
$site_url = home_url();

$replacements = [
    'href="/assets/' => 'href="' . esc_url($theme_uri) . '/assets/',
    "href='/assets/" => "href='" . esc_url($theme_uri) . "/assets/",
    'src="/assets/' => 'src="' . esc_url($theme_uri) . '/assets/',
    "src='/assets/" => "src='" . esc_url($theme_uri) . "/assets/",
    "this.src='/assets/" => "this.src='" . esc_url($theme_uri) . "/assets/",
    'url(/assets/' => 'url(' . esc_url($theme_uri) . '/assets/',
    'action="/legacy-contact-endpoint"' => 'action="' . esc_url(admin_url('admin-post.php')) . '"',
];

$html = strtr($html, $replacements);

echo $html;
