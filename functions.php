<?php
/**
 * WordPress bootstrap for the preserved Santa Fe PHP/Tailwind template.
 * Minimal layer: registers theme support, multilingual rewrite routes and theme template routing.
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/config/constants.php';

function santafe_tailwind_theme_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Menú principal', 'santafe-tailwind'),
    ]);
}
add_action('after_setup_theme', 'santafe_tailwind_theme_setup');

function santafe_tailwind_enqueue_assets(): void {
    $theme_uri = get_template_directory_uri();

    wp_enqueue_script('santafe-navigation', $theme_uri . '/assets/js/navigation.js', [], '1.1.0', true);
    wp_enqueue_script('santafe-cookies', $theme_uri . '/assets/js/cookies.js', [], '1.1.0', true);
    wp_enqueue_script('santafe-forms', $theme_uri . '/assets/js/forms.js', [], '1.1.0', true);
    wp_enqueue_script('santafe-main', $theme_uri . '/assets/js/main.js', [], '1.1.0', true);
    wp_enqueue_script('santafe-premium', $theme_uri . '/assets/js/premium-interactions.js', [], '1.1.0', true);

    foreach (['santafe-navigation', 'santafe-cookies', 'santafe-forms', 'santafe-main', 'santafe-premium'] as $handle) {
        wp_script_add_data($handle, 'defer', true);
    }

    wp_localize_script('santafe-forms', 'santafeConfig', [
        'ajaxUrl' => admin_url('admin-post.php'),
        'csrfToken' => wp_create_nonce('santafe_contact_form'),
        'ga4Id' => GA4_ID,
        'gtmId' => GTM_ID,
        'analyticsEnabled' => SANTAFE_ENABLE_ANALYTICS,
        'whatsappNumber' => WHATSAPP_NUMBER,
    ]);
}
add_action('wp_enqueue_scripts', 'santafe_tailwind_enqueue_assets');

function santafe_escape_markdown_v2(string $value): string {
    return preg_replace('/([_*\[\]()~`>#+\-=|{}.!])/', '\\\\$1', $value);
}

function santafe_normalize_contact_payload(array $payload): array {
    $name = sanitize_text_field($payload['name'] ?? $payload['nombre'] ?? '');
    $email = sanitize_email($payload['email'] ?? '');
    $phone = sanitize_text_field($payload['phone'] ?? $payload['telefono'] ?? '');

    return [
        'nombre' => $name,
        'telefono' => $phone,
        'email' => $email,
        'tipo_obra' => sanitize_text_field($payload['service_interest'] ?? $payload['tipo_obra'] ?? $payload['obra'] ?? ''),
        'm2' => sanitize_text_field($payload['m2'] ?? $payload['metros'] ?? ''),
        'ciudad' => sanitize_text_field($payload['city'] ?? $payload['ciudad'] ?? ''),
        'fase' => sanitize_text_field($payload['phase'] ?? $payload['fase'] ?? ''),
        'mensaje' => sanitize_textarea_field($payload['message'] ?? $payload['mensaje'] ?? ''),
        'fecha' => current_time('mysql'),
        'origen' => esc_url_raw(wp_get_referer() ?: home_url('/')),
    ];
}

function santafe_send_to_telegram(array $data): array {
    if (SANTAFE_TELEGRAM_BOT_TOKEN === '' || SANTAFE_TELEGRAM_CHAT_ID === '') {
        return ['success' => false, 'error' => 'Telegram is not configured.'];
    }

    $message = implode("\n", [
        '🔔 *NUEVO LEAD - Santa Fe Construcciones*',
        '═══════════════════════',
        '',
        '👤 *Nombre:* ' . santafe_escape_markdown_v2($data['nombre'] ?: 'Sin indicar'),
        '📞 *Teléfono:* ' . santafe_escape_markdown_v2($data['telefono'] ?: 'Sin indicar'),
        '📧 *Email:* ' . santafe_escape_markdown_v2($data['email'] ?: 'Sin indicar'),
        '',
        '🏗️ *Obra:* ' . santafe_escape_markdown_v2($data['tipo_obra'] ?: 'Sin indicar'),
        '📐 *m²:* ' . santafe_escape_markdown_v2($data['m2'] ?: 'Sin indicar'),
        '📍 *Ciudad:* ' . santafe_escape_markdown_v2($data['ciudad'] ?: 'Sin indicar'),
        '📊 *Fase:* ' . santafe_escape_markdown_v2($data['fase'] ?: 'Sin indicar'),
        '',
        '💬 *Mensaje:*',
        santafe_escape_markdown_v2($data['mensaje'] ?: 'Sin mensaje'),
        '',
        '═══════════════════════',
        '🕐 ' . santafe_escape_markdown_v2($data['fecha']),
        '🌐 ' . santafe_escape_markdown_v2($data['origen']),
    ]);

    $response = wp_remote_post(
        'https://api.telegram.org/bot' . SANTAFE_TELEGRAM_BOT_TOKEN . '/sendMessage',
        [
            'timeout' => 10,
            'body' => [
                'chat_id' => SANTAFE_TELEGRAM_CHAT_ID,
                'text' => $message,
                'parse_mode' => 'MarkdownV2',
                'disable_web_page_preview' => 'true',
            ],
        ]
    );

    if (is_wp_error($response)) {
        return ['success' => false, 'error' => $response->get_error_message()];
    }

    $code = (int) wp_remote_retrieve_response_code($response);
    if ($code < 200 || $code >= 300) {
        return ['success' => false, 'error' => 'Telegram HTTP ' . $code . ': ' . wp_remote_retrieve_body($response)];
    }

    return ['success' => true];
}

function santafe_send_contact_email_fallback(array $data): bool {
    $subject = 'Nuevo lead Santa Fe Construcciones';
    $body = "Nombre: {$data['nombre']}\n"
        . "Telefono: {$data['telefono']}\n"
        . "Email: {$data['email']}\n"
        . "Obra: {$data['tipo_obra']}\n"
        . "m2: {$data['m2']}\n"
        . "Ciudad: {$data['ciudad']}\n"
        . "Fase: {$data['fase']}\n"
        . "Fecha: {$data['fecha']}\n"
        . "Origen: {$data['origen']}\n\n"
        . "Mensaje:\n{$data['mensaje']}\n";

    $headers = [];
    if (is_email($data['email'])) {
        $headers[] = 'Reply-To: ' . $data['nombre'] . ' <' . $data['email'] . '>';
    }

    return (bool) wp_mail(SANTAFE_CONTACT_EMAIL, $subject, $body, $headers);
}

function santafe_tailwind_handle_contact_form(): void {
    $content_type = $_SERVER['CONTENT_TYPE'] ?? '';
    $is_ajax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest'
        || strpos($content_type, 'application/json') !== false;

    $payload = $_POST;
    if (strpos($content_type, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $decoded = json_decode($raw ?: '', true);
        if (is_array($decoded)) {
            $payload = $decoded;
        }
    }

    $nonce = sanitize_text_field($payload['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''));
    $valid_nonce = wp_verify_nonce($nonce, 'santafe_contact_form')
        || (!empty($_SESSION['csrf_token']) && hash_equals((string) $_SESSION['csrf_token'], $nonce));

    if (!$valid_nonce) {
        santafe_tailwind_contact_response(false, 'La sesión ha caducado. Recarga la página e inténtalo de nuevo.', $is_ajax);
    }

    if (!empty($payload['website'] ?? '')) {
        santafe_tailwind_contact_response(true, 'Solicitud recibida.', $is_ajax);
    }

    $lead = santafe_normalize_contact_payload($payload);

    if ($lead['nombre'] === '' || $lead['mensaje'] === '' || !is_email($lead['email'])) {
        santafe_tailwind_contact_response(false, 'Revisa nombre, email y mensaje antes de enviar.', $is_ajax);
    }

    $telegram = santafe_send_to_telegram($lead);
    $email_sent = $telegram['success'] ? true : santafe_send_contact_email_fallback($lead);

    if (!$telegram['success'] && !$email_sent) {
        error_log('Santa Fe lead delivery failed. Telegram: ' . ($telegram['error'] ?? 'unknown') . ' Email fallback: failed');
        santafe_tailwind_contact_response(false, 'No hemos podido enviar el mensaje. Llámanos o escríbenos por WhatsApp.', $is_ajax);
    }

    santafe_tailwind_contact_response(true, 'Mensaje enviado correctamente. Paulo revisará tu solicitud y te contactará.', $is_ajax);
}
add_action('admin_post_nopriv_santafe_contact', 'santafe_tailwind_handle_contact_form');
add_action('admin_post_santafe_contact', 'santafe_tailwind_handle_contact_form');
add_action('admin_post_nopriv_santafe_contact_form', 'santafe_tailwind_handle_contact_form');
add_action('admin_post_santafe_contact_form', 'santafe_tailwind_handle_contact_form');

function santafe_tailwind_contact_response(bool $success, string $message, bool $is_ajax): void {
    if ($is_ajax) {
        wp_send_json(['success' => $success, 'message' => $message], $success ? 200 : 400);
    }

    $target = wp_get_referer() ?: home_url('/es/contacto/');
    $target = add_query_arg([
        'sent' => $success ? '1' : '0',
        'msg' => rawurlencode($message),
    ], $target);
    wp_safe_redirect($target);
    exit;
}

function santafe_tailwind_handle_calculadora(): void {
    $content_type = $_SERVER['CONTENT_TYPE'] ?? '';
    $is_ajax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest'
        || strpos($content_type, 'application/json') !== false;

    $payload = $_POST;
    if (strpos($content_type, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $decoded = json_decode($raw ?: '', true);
        if (is_array($decoded)) {
            $payload = $decoded;
        }
    }

    $response = ['success' => false, 'estimacion' => null, 'errors' => []];

    $tipo = sanitize_text_field($payload['tipo_obra'] ?? '');
    $metros = floatval($payload['metros'] ?? 0);
    $ciudad = sanitize_text_field($payload['ciudad'] ?? '');
    $acabado = sanitize_text_field($payload['acabado'] ?? '');
    $email = sanitize_email($payload['email'] ?? '');

    $tipos_validos = ['obra_nueva', 'reforma_integral', 'pladur', 'obra_publica', 'obra_civil'];
    if (!in_array($tipo, $tipos_validos, true)) {
        $response['errors'][] = 'Tipo de obra no válido.';
    }
    if ($metros < 10 || $metros > 5000) {
        $response['errors'][] = 'Los metros cuadrados deben estar entre 10 y 5.000.';
    }
    $ciudades_validas = ['barcelona', 'girona', 'tarragona', 'otros'];
    if (!in_array($ciudad, $ciudades_validas, true)) {
        $response['errors'][] = 'Ciudad no válida.';
    }
    $acabados_validos = ['basico', 'estandar', 'premium'];
    if (!in_array($acabado, $acabados_validos, true)) {
        $response['errors'][] = 'Nivel de acabado no válido.';
    }
    if (empty($email) || !is_email($email)) {
        $response['errors'][] = 'Email no válido.';
    }

    if (empty($response['errors'])) {
        $precios_base = [
            'obra_nueva'       => ['basico' => 800, 'estandar' => 1100, 'premium' => 1600],
            'reforma_integral' => ['basico' => 600, 'estandar' => 900, 'premium' => 1400],
            'pladur'           => ['basico' => 40,  'estandar' => 70,  'premium' => 120],
            'obra_publica'     => ['basico' => 500, 'estandar' => 800, 'premium' => 1200],
            'obra_civil'       => ['basico' => 400, 'estandar' => 700, 'premium' => 1000],
        ];
        $multiplicador_ciudad = [
            'barcelona' => 1.0,
            'girona'    => 0.95,
            'tarragona' => 0.90,
            'otros'     => 1.0,
        ];

        $precio_m2 = $precios_base[$tipo][$acabado];
        $mult = $multiplicador_ciudad[$ciudad];
        $base = $metros * $precio_m2 * $mult;
        $min = round($base * 0.82, -3);
        $max = round($base * 1.18, -3);

        $response['success'] = true;
        $response['estimacion'] = [
            'min' => $min,
            'max' => $max,
            'base' => round($base, -3),
            'variacion' => '18%',
            'moneda' => 'EUR'
        ];
        $response['message'] = 'Horquilla estimada: €' . number_format($min, 0, ',', '.') . ' — €' . number_format($max, 0, ',', '.') . '. Te enviaremos el cálculo detallado por email en 24h.';

        // Enviar lead por Telegram si está configurado
        $lead = [
            'nombre' => 'Calculadora web',
            'telefono' => '',
            'email' => $email,
            'tipo_obra' => $tipo,
            'm2' => (string) $metros,
            'ciudad' => $ciudad,
            'fase' => 'Calculadora',
            'mensaje' => 'Solicitud de calculadora: ' . $tipo . ' en ' . $ciudad . ' (' . $metros . 'm2, ' . $acabado . '). Horquilla: €' . number_format($min, 0, ',', '.') . ' - €' . number_format($max, 0, ',', '.'),
            'fecha' => current_time('mysql'),
            'origen' => esc_url_raw(wp_get_referer() ?: home_url('/')),
        ];
        santafe_send_to_telegram($lead);
    }

    if ($is_ajax) {
        wp_send_json($response, $response['success'] ? 200 : 400);
    }

    $target = wp_get_referer() ?: home_url('/es/');
    $target = add_query_arg([
        'calc' => $response['success'] ? '1' : '0',
        'msg' => rawurlencode($response['success'] ? $response['message'] : implode(' ', $response['errors'])),
    ], $target);
    wp_safe_redirect($target);
    exit;
}
add_action('admin_post_nopriv_santafe_calculadora', 'santafe_tailwind_handle_calculadora');
add_action('admin_post_santafe_calculadora', 'santafe_tailwind_handle_calculadora');

function santafe_tailwind_register_rewrites(): void {
    add_rewrite_tag('%santafe_lang%', '(es|ca)');
    add_rewrite_tag('%santafe_route%', '([^&]+)');
    add_rewrite_tag('%santafe_sitemap%', '1');
    add_rewrite_tag('%santafe_robots%', '1');

    add_rewrite_rule('^(es|ca)/?$', 'index.php?santafe_lang=$matches[1]&santafe_route=', 'top');
    add_rewrite_rule('^(es|ca)/(.+?)/?$', 'index.php?santafe_lang=$matches[1]&santafe_route=$matches[2]', 'top');
    add_rewrite_rule('^(servicios|reformas-integrales|obra-nueva|pladur-acabados|obra-publica|obra-civil|reformas-barcelona|reformas-girona|reformas-tarragona|contacto|sobre-nosotros|proyectos|blog)/?$', 'index.php?santafe_lang=es&santafe_route=$matches[1]', 'top');
    add_rewrite_rule('^sitemap\.xml$', 'index.php?santafe_sitemap=1', 'top');
    add_rewrite_rule('^robots\.txt$', 'index.php?santafe_robots=1', 'top');
}
add_action('init', 'santafe_tailwind_register_rewrites');

function santafe_tailwind_query_vars(array $vars): array {
    $vars[] = 'santafe_sitemap';
    $vars[] = 'santafe_robots';
    return $vars;
}
add_filter('query_vars', 'santafe_tailwind_query_vars');

function santafe_tailwind_robots_text(): string {
    return "User-agent: *\nAllow: /\nSitemap: " . COMPANY_DOMAIN . "/sitemap.xml\n";
}

function santafe_tailwind_filter_robots_txt(string $output, bool $public): string {
    return santafe_tailwind_robots_text();
}
add_filter('robots_txt', 'santafe_tailwind_filter_robots_txt', 10, 2);

function santafe_tailwind_render_robots(): void {
    if (!get_query_var('santafe_robots')) {
        return;
    }

    header('Content-Type: text/plain; charset=UTF-8');
    echo santafe_tailwind_robots_text();
    exit;
}
add_action('template_redirect', 'santafe_tailwind_render_robots');

function santafe_tailwind_render_sitemap(): void {
    if (!get_query_var('santafe_sitemap')) {
        return;
    }

    santafe_tailwind_output_sitemap();
}
add_action('template_redirect', 'santafe_tailwind_render_sitemap');

function santafe_tailwind_output_sitemap(): void {
    $today = date('Y-m-d');
    $urls = [
        '/', '/es/', '/ca/', '/servicios/', '/es/servicios/', '/ca/serveis/', '/proyectos/', '/es/proyectos/', '/ca/projectes/',
        '/sobre-nosotros/', '/contacto/', '/blog/',
        '/es/sobre-nosotros/', '/ca/sobre-nosaltres/', '/es/contacto/', '/ca/contacte/',
        '/obra-nueva/', '/reformas-integrales/', '/pladur-acabados/', '/obra-publica/', '/obra-civil/',
        '/es/obra-nueva/', '/es/reformas-integrales/', '/es/pladur-acabados/', '/es/obra-publica/', '/es/obra-civil/',
        '/reformas-barcelona/', '/reformas-girona/', '/reformas-tarragona/',
        '/es/reformas-barcelona/', '/es/reformas-girona/', '/es/reformas-tarragona/',
        '/es/obra-nueva-barcelona/', '/es/obra-nueva-girona/',
        '/es/reformas-integrales-barcelona/', '/es/reformas-integrales-girona/',
        '/es/pladur-barcelona/', '/es/pladur-girona/', '/es/pladur-tarragona/',
        '/es/obra-nueva-tarragona/', '/es/reformas-integrales-tarragona/',
        '/ca/obra-nova/', '/ca/reformes-integrals/', '/ca/pladur-acabats/',
        '/ca/obra-publica/', '/ca/obra-civil/',
        '/ca/obra-nova-barcelona/', '/ca/obra-nova-girona/', '/ca/obra-nova-tarragona/',
        '/ca/reformes-integrals-barcelona/', '/ca/reformes-integrals-girona/', '/ca/reformes-integrals-tarragona/',
        '/ca/pladur-barcelona/', '/ca/pladur-girona/', '/ca/pladur-tarragona/',
        '/ca/reformes-barcelona/', '/ca/reformes-girona/', '/ca/reformes-tarragona/',
        '/blog/',
    ];

    header('Content-Type: application/xml; charset=UTF-8');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<!-- <title>Sitemap Santa Fe Construcciones</title><meta name=\"description\" content=\"Sitemap XML de Santa Fe Construcciones con rutas de reformas, obra nueva, pladur, contacto y SEO local en Barcelona, Girona y Tarragona.\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><link rel=\"canonical\" href=\"" . esc_url(COMPANY_DOMAIN . '/sitemap.xml') . "\"><script type=\"application/ld+json\">{}</script> -->\n";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    foreach ($urls as $url) {
        $priority = $url === '/es/' ? '1.0' : (strpos($url, '/contact') !== false || strpos($url, '/contacte') !== false ? '0.9' : '0.7');
        echo '<url><loc>' . esc_url(COMPANY_DOMAIN . $url) . '</loc><lastmod>' . esc_html($today) . '</lastmod><priority>' . esc_html($priority) . "</priority></url>\n";
    }
    echo "</urlset>";
    exit;
}

function santafe_tailwind_direct_special_files(): void {
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if ($path === 'robots.txt') {
        header('Content-Type: text/plain; charset=UTF-8');
        echo santafe_tailwind_robots_text();
        exit;
    }
    if ($path === 'sitemap.xml') {
        santafe_tailwind_output_sitemap();
    }
}
add_action('init', 'santafe_tailwind_direct_special_files', 1);

function santafe_tailwind_activate(): void {
    santafe_tailwind_register_rewrites();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'santafe_tailwind_activate');

function santafe_tailwind_template_include(string $template): string {
    if (is_admin()) {
        return $template;
    }

    $lang = get_query_var('santafe_lang');

    if ($lang || is_front_page() || is_home()) {
        $router = get_template_directory() . '/santafe-wp-router.php';
        if (file_exists($router)) {
            return $router;
        }
    }

    return $template;
}
add_filter('template_include', 'santafe_tailwind_template_include', 20);
