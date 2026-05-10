<?php
declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$file = __DIR__ . $path;

if ($path !== '/' && is_file($file)) {
    return false;
}

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

if (!function_exists('wp_create_nonce')) {
    function wp_create_nonce(string $action = ''): string { return hash('sha256', $action . 'local-preview'); }
}
if (!function_exists('wp_json_encode')) {
    function wp_json_encode($value): string { return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); }
}
if (!function_exists('wp_head')) {
    function wp_head(): void {}
}
if (!function_exists('wp_footer')) {
    function wp_footer(): void {}
}
if (!function_exists('esc_url')) {
    function esc_url($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('esc_html')) {
    function esc_html($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('esc_attr')) {
    function esc_attr($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('home_url')) {
    function home_url(string $path = ''): string {
        $host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1:8000';
        return 'http://' . $host . $path;
    }
}
if (!function_exists('admin_url')) {
    function admin_url(string $path = ''): string { return home_url('/wp-admin/' . ltrim($path, '/')); }
}
if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri(): string { return home_url(); }
}
if (!function_exists('get_template_directory')) {
    function get_template_directory(): string { return __DIR__; }
}
if (!function_exists('status_header')) {
    function status_header(int $code): void { http_response_code($code); }
}

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/i18n.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/schema-services.php';
require_once __DIR__ . '/includes/schema-faq.php';
require_once __DIR__ . '/includes/schema-reviews.php';

// Special files: sitemap.xml and robots.txt
if ($path === '/sitemap.xml') {
    header('Content-Type: application/xml; charset=UTF-8');
    $today = date('Y-m-d');
    $domain = defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url();
    $urls = ['/', '/es/', '/ca/', '/servicios/', '/es/servicios/', '/ca/serveis/', '/proyectos/', '/es/proyectos/', '/ca/projectes/', '/sobre-nosotros/', '/es/sobre-nosotros/', '/ca/sobre-nosaltres/', '/contacto/', '/es/contacto/', '/ca/contacte/', '/obra-nueva/', '/es/obra-nueva/', '/ca/obra-nova/', '/reformas-integrales/', '/es/reformas-integrales/', '/ca/reformes-integrals/', '/pladur-acabados/', '/es/pladur-acabados/', '/ca/pladur-acabats/', '/obra-publica/', '/es/obra-publica/', '/ca/obra-publica/', '/obra-civil/', '/es/obra-civil/', '/ca/obra-civil/', '/reformas-barcelona/', '/es/reformas-barcelona/', '/reformas-girona/', '/es/reformas-girona/', '/reformas-tarragona/', '/es/reformas-tarragona/', '/obra-nueva-barcelona/', '/es/obra-nueva-barcelona/', '/obra-nueva-girona/', '/es/obra-nueva-girona/', '/obra-nueva-tarragona/', '/es/obra-nueva-tarragona/', '/blog/', '/es/blog/'];
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $url) {
        $priority = $url === '/es/' ? '1.0' : (strpos($url, 'contact') !== false || strpos($url, 'contacte') !== false ? '0.9' : '0.7');
        echo '<url><loc>' . esc_url($domain . $url) . '</loc><lastmod>' . esc_html($today) . '</lastmod><priority>' . esc_html($priority) . "</priority></url>\n";
    }
    echo '</urlset>';
    exit;
}
if ($path === '/robots.txt') {
    header('Content-Type: text/plain; charset=UTF-8');
    $domain = defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url();
    echo "User-agent: *\nAllow: /\nSitemap: " . $domain . "/sitemap.xml\n";
    exit;
}

$parts = array_values(array_filter(explode('/', trim($path, '/'))));
$current_lang = in_array($parts[0] ?? '', ['es', 'ca'], true) ? $parts[0] : 'es';
$offset = ($parts[0] ?? '') === $current_lang ? 1 : 0;
$current_route = implode('/', array_slice($parts, $offset));

$routes = [
    '' => 'home.php',
    'servicios' => 'servicios.php',
    'servicios/obra-nueva' => 'obra-nueva.php',
    'servicios/reformas-integrales' => 'reformas-integrales.php',
    'servicios/pladur-acabados' => 'pladur-acabados.php',
    'servicios/obra-publica' => 'obra-publica.php',
    'servicios/obra-civil' => 'obra-civil.php',
    'obra-nueva' => 'obra-nueva.php',
    'reformas-integrales' => 'reformas-integrales.php',
    'pladur-acabados' => 'pladur-acabados.php',
    'obra-publica' => 'obra-publica.php',
    'obra-civil' => 'obra-civil.php',
    'reformas-barcelona' => 'seo-local.php',
    'reformas-girona' => 'seo-local.php',
    'reformas-tarragona' => 'seo-local.php',
    'obra-nueva-barcelona' => 'seo-local.php',
    'obra-nueva-girona' => 'seo-local.php',
    'obra-nueva-tarragona' => 'seo-local.php',
    'reformas-integrales-barcelona' => 'seo-local.php',
    'reformas-integrales-girona' => 'seo-local.php',
    'reformas-integrales-tarragona' => 'seo-local.php',
    'pladur-barcelona' => 'seo-local.php',
    'pladur-girona' => 'seo-local.php',
    'pladur-tarragona' => 'seo-local.php',
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
    'serveis/obra-nova' => 'obra-nueva.php',
    'serveis/reformes-integrals' => 'reformas-integrales.php',
    'serveis/pladur-acabats' => 'pladur-acabados.php',
    'serveis/obra-publica' => 'obra-publica.php',
    'serveis/obra-civil' => 'obra-civil.php',
    'obra-nova' => 'obra-nueva.php',
    'reformes-integrals' => 'reformas-integrales.php',
    'pladur-acabats' => 'pladur-acabados.php',
    'obra-publica' => 'obra-publica.php',
    'obra-civil' => 'obra-civil.php',
    'reformes-barcelona' => 'seo-local.php',
    'reformes-girona' => 'seo-local.php',
    'reformes-tarragona' => 'seo-local.php',
    'obra-nova-barcelona' => 'seo-local.php',
    'obra-nova-girona' => 'seo-local.php',
    'obra-nova-tarragona' => 'seo-local.php',
    'reformes-integrals-barcelona' => 'seo-local.php',
    'reformes-integrals-girona' => 'seo-local.php',
    'reformes-integrals-tarragona' => 'seo-local.php',
    'pladur-barcelona' => 'seo-local.php',
    'pladur-girona' => 'seo-local.php',
    'pladur-tarragona' => 'seo-local.php',
    'blog' => 'blog.php',
    'projectes' => 'proyectos.php',
    'sobre-nosaltres' => 'sobre-nosotros.php',
    'contacte' => 'contacto.php',
    'avis-legal' => 'legal.php',
    'politica-privacitat' => 'legal.php',
    'politica-cookies' => 'legal.php',
];

$page_file = $current_lang === 'ca'
    ? ($ca_routes[$current_route] ?? null)
    : ($routes[$current_route] ?? null);

if (!$page_file || !is_file(__DIR__ . '/pages/' . $page_file)) {
    status_header(404);
    $page_file = '404.php';
}

require __DIR__ . '/pages/' . $page_file;
