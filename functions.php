<?php
/**
 * WordPress bootstrap for the preserved Santa Fe PHP/Tailwind template.
 * Minimal layer: registers theme support, multilingual rewrite routes and theme template routing.
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/i18n.php';

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
    $version = '1.2.2';

    // Core utilities must load first (dependency for slider)
    wp_enqueue_script('santafe-utils', $theme_uri . '/assets/js/utils.js', [], $version, true);
    wp_script_add_data('santafe-utils', 'defer', true);

    // Slider depends on utils (onReady helper)
    wp_enqueue_script('santafe-slider', $theme_uri . '/assets/js/slider.js', ['santafe-utils'], $version, true);
    wp_script_add_data('santafe-slider', 'defer', true);

    wp_enqueue_script('santafe-navigation', $theme_uri . '/assets/js/navigation.js', [], $version, true);
    wp_enqueue_script('santafe-cookies', $theme_uri . '/assets/js/cookies.js', [], $version, true);
    wp_enqueue_script('santafe-forms', $theme_uri . '/assets/js/forms.js', ['santafe-utils'], $version, true);
    wp_enqueue_script('santafe-main', $theme_uri . '/assets/js/main.js', [], $version, true);
    wp_enqueue_script('santafe-premium', $theme_uri . '/assets/js/premium-interactions.js', [], $version, true);

    foreach (['santafe-utils', 'santafe-slider', 'santafe-navigation', 'santafe-cookies', 'santafe-forms', 'santafe-main', 'santafe-premium'] as $handle) {
        wp_script_add_data($handle, 'defer', true);
    }

    $recaptcha_key = defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : '';
    $current_lang = function_exists('get_query_var') ? get_query_var('santafe_lang') : '';
    if (!in_array($current_lang, ['es', 'ca'], true)) {
        $current_lang = DEFAULT_LANG;
    }
    wp_localize_script('santafe-forms', 'santafeConfig', [
        'ajaxUrl' => admin_url('admin-post.php'),
        'csrfToken' => wp_create_nonce('santafe_contact_form'),
        'ga4Id' => GA4_ID,
        'gtmId' => GTM_ID,
        'analyticsEnabled' => SANTAFE_ENABLE_ANALYTICS,
        'whatsappNumber' => WHATSAPP_NUMBER,
        'recaptchaSiteKey' => $recaptcha_key,
        'lang' => $current_lang,
    ]);

    wp_localize_script('santafe-main', 'santafeMainConfig', [
        'ajaxUrl' => admin_url('admin-post.php'),
        'csrfToken' => wp_create_nonce('santafe_contact_form'),
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

function santafe_send_contact_email(array $data, array $attachments = []): bool {
    $logo_url = esc_url(get_template_directory_uri() . '/assets/img/logo-casa-cut.png');
    $subject = 'Nuevo contacto — Santa Fe Construcciones';

    $files_html = '';
    if (!empty($data['archivos'])) {
        $files_html = '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Archivos</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['archivos']) . '</td></tr>';
    }

    $body = '<html><body style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px;">'
        . '<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #e5e5e5;">'
        . '<div style="padding: 24px; text-align: center; border-bottom: 1px solid #eee;">'
        . '<img src="' . $logo_url . '" alt="Santa Fe Construcciones" style="max-height: 40px; width: auto;">'
        . '<p style="margin: 8px 0 0; font-size: 16px; font-weight: bold; color: #000;">Santa Fe Construcciones</p>'
        . '</div>'
        . '<div style="background: #ae232a; padding: 20px; text-align: center;">'
        . '<h1 style="color: #fff; margin: 0; font-size: 18px;">Nuevo contacto</h1>'
        . '</div>'
        . '<div style="padding: 24px;">'
        . '<table style="width: 100%; border-collapse: collapse;">'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Nombre</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['nombre']) . '</td></tr>'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Teléfono</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['telefono']) . '</td></tr>'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Email</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['email']) . '</td></tr>'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Tipo de obra</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['tipo_obra']) . '</td></tr>'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">m²</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['m2']) . '</td></tr>'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Ciudad</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['ciudad']) . '</td></tr>'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Fecha</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['fecha']) . '</td></tr>'
        . '<tr><td style="padding: 8px 12px; font-weight: bold; color: #333; border-bottom: 1px solid #eee;">Origen</td><td style="padding: 8px 12px; color: #555; border-bottom: 1px solid #eee;">' . esc_html($data['origen']) . '</td></tr>'
        . $files_html
        . '</table>'
        . '<div style="margin-top: 16px; padding: 12px; background: #f9f9f9; border-radius: 4px;"><strong style="color: #333;">Mensaje:</strong><p style="color: #555; margin: 8px 0 0;">' . nl2br(esc_html($data['mensaje'])) . '</p></div>'
        . '<div style="padding: 24px; text-align: center; background: #f9f9f9;">'
        . '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/construcciones-santa-fe-girona.png') . '" alt="Santa Fe Construcciones — Girona" style="max-width: 100%; height: auto; border-radius: 8px;">'
        . '</div>'
        . '</div></div></body></html>';

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $data['nombre'] . ' <' . $data['email'] . '>',
    ];

    $to = [SANTAFE_CONTACT_EMAIL, 'admsantafeconstruciones@gmail.com', 'constrsantafe@gmail.com'];
    return (bool) wp_mail($to, $subject, $body, $headers, $attachments);
}

function santafe_send_autoreply(array $data): bool {
    $logo_url = esc_url(get_template_directory_uri() . '/assets/img/logo-casa-cut.png');
    $company = defined('COMPANY_NAME') ? COMPANY_NAME : 'Construcciones Santa Fe Siglo XXI SLU';
    $phone = defined('COMPANY_PHONE_DISPLAY') ? COMPANY_PHONE_DISPLAY : '665 737 547';
    $whatsapp = defined('WHATSAPP_NUMBER') ? WHATSAPP_NUMBER : '34665737547';

    $subject = 'Hemos recibido tu solicitud — Santa Fe Construcciones';
    $body = '<html><body style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px;">'
        . '<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #e5e5e5;">'
        . '<div style="padding: 24px; text-align: center; border-bottom: 1px solid #eee;">'
        . '<img src="' . $logo_url . '" alt="Santa Fe Construcciones" style="max-height: 40px; width: auto;">'
        . '<p style="margin: 8px 0 0; font-size: 16px; font-weight: bold; color: #000;">Santa Fe Construcciones</p>'
        . '</div>'
        . '<div style="background: #ae232a; padding: 24px; text-align: center;">'
        . '<h1 style="color: #fff; margin: 0 0 4px; font-size: 20px;">Gracias por contactarnos</h1>'
        . '<p style="color: rgba(255,255,255,0.85); margin: 0; font-size: 14px;">' . esc_html($data['nombre']) . ', hemos recibido tu mensaje</p>'
        . '</div>'
        . '<div style="padding: 32px 24px;">'
        . '<p style="color: #333; font-size: 16px; line-height: 1.6;">Hola <strong>' . esc_html($data['nombre']) . '</strong>,</p>'
        . '<p style="color: #555; font-size: 15px; line-height: 1.6;">Gracias por escribirnos. Hemos recibido tu solicitud y <strong>Paulo la revisará personalmente en las próximas 24-48 horas</strong> para prepararte un presupuesto cerrado y sin compromiso.</p>'
        . '<p style="color: #555; font-size: 15px; line-height: 1.6;">Mientras tanto, si necesitas hablar con nosotros antes, puedes contactarnos directamente por los siguientes canales:</p>'
        . '<table style="width: 100%; margin: 20px 0;">'
        . '<tr><td style="padding: 10px 0;"><a href="tel:' . COMPANY_PHONE . '" style="display: inline-block; background: #ae232a; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold;">Llamar al ' . $phone . '</a></td></tr>'
        . '<tr><td style="padding: 10px 0;"><a href="https://wa.me/' . $whatsapp . '" style="display: inline-block; background: #25d366; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold;">Escribir por WhatsApp</a></td></tr>'
        . '</table>'
        . '<div style="background: #f9f9f9; border-left: 4px solid #ae232a; padding: 16px; margin: 20px 0; border-radius: 4px;">'
        . '<p style="color: #333; margin: 0 0 8px; font-weight: bold;">Resumen de tu solicitud:</p>'
        . '<p style="color: #555; margin: 0; font-size: 14px;">'
        . 'Tipo de obra: ' . esc_html($data['tipo_obra'] ?: 'Sin especificar') . '<br>'
        . 'Ciudad: ' . esc_html($data['ciudad'] ?: 'Sin especificar') . '<br>'
        . 'Mensaje: ' . esc_html(mb_substr($data['mensaje'] ?: 'Sin mensaje', 0, 200)) . (mb_strlen($data['mensaje'] ?? '') > 200 ? '...' : '')
        . '</p></div>'
        . '<div style="padding: 24px; text-align: center; background: #f9f9f9;">'
        . '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/construcciones-santa-fe-girona.png') . '" alt="Santa Fe Construcciones — Girona" style="max-width: 100%; height: auto; border-radius: 8px;">'
        . '</div>'
        . '<hr style="border: none; border-top: 1px solid #eee; margin: 24px 0;">'
        . '<p style="color: #999; font-size: 12px; line-height: 1.5;">' . esc_html($company) . '<br>'
        . 'Tel: ' . $phone . ' | WhatsApp: ' . $phone . '<br>'
        . 'Barcelona · Girona · Tarragona</p>'
        . '</div></div></body></html>';

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: Paulo — Santa Fe Construcciones <' . SANTAFE_CONTACT_EMAIL . '>',
    ];

    return (bool) wp_mail($data['email'], $subject, $body, $headers);
}

function santafe_verify_recaptcha(string $token): array {
    $secret = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '';

    if ($secret === '') {
        error_log('Santa Fe reCAPTCHA: secret key not configured.');
        return ['success' => false, 'error' => 'secret_not_configured'];
    }

    if ($token === '') {
        return ['success' => false, 'error' => 'token_vacio'];
    }

    $response = wp_remote_post(
        'https://www.google.com/recaptcha/api/siteverify',
        [
            'timeout' => 10,
            'body' => [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'] ?? '')),
            ],
        ]
    );

    if (is_wp_error($response)) {
        error_log('Santa Fe reCAPTCHA: ' . $response->get_error_message());
        return ['success' => false, 'error' => 'http_error'];
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (!is_array($body)) {
        return ['success' => false, 'error' => 'respuesta_invalida'];
    }

    if (isset($_SERVER['HTTP_HOST'])) {
        $body['_site_host'] = sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST']));
    }
    error_log('Santa Fe reCAPTCHA: ' . wp_json_encode($body));

    return [
        'success' => !empty($body['success']),
        'error' => empty($body['success']) ? ($body['error-codes'][0] ?? 'desconocido') : '',
    ];
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
        return;
    }

    if (!empty($payload['website'] ?? '')) {
        santafe_tailwind_contact_response(true, 'Solicitud recibida.', $is_ajax);
        return;
    }

    $recaptcha_token = sanitize_text_field($payload['g-recaptcha-response'] ?? '');
    $recaptcha_result = santafe_verify_recaptcha($recaptcha_token);
    if (!$recaptcha_result['success']) {
        $lang = sanitize_text_field($payload['lang'] ?? '');
        if (!in_array($lang, ['es', 'ca'], true)) {
            $referer = wp_get_referer() ?: '';
            if (strpos($referer, '/ca/') !== false) {
                $lang = 'ca';
            } else {
                $lang = 'es';
            }
        }
        $translations = load_translations($lang);
        $error_code = $recaptcha_result['error'] ?? 'desconocido';
        if ($error_code === 'http_error') {
            $msg = $lang === 'ca'
                ? 'Error de connexió amb el servei de verificació. Torna-ho a provar més tard.'
                : 'Error de conexión con el servicio de verificación. Inténtalo más tarde.';
        } elseif ($error_code === 'token_vacio') {
            $msg = $lang === 'ca'
                ? 'El token de seguretat està buit. Recarrega la pàgina i torna-ho a provar. (codi: token_vacio)'
                : 'El token de seguridad está vacío. Recarga la página e inténtalo de nuevo. (código: token_vacio)';
        } elseif ($error_code === 'timeout-or-duplicate') {
            $msg = $lang === 'ca'
                ? 'El token de seguretat ha caducat o ja s\'ha utilitzat. Recarrega la pàgina i torna-ho a provar. (codi: timeout)'
                : 'El token de seguridad ha expirado o ya fue usado. Recarga la página e inténtalo de nuevo. (código: timeout)';
        } elseif ($error_code === 'secret_not_configured') {
            $msg = $lang === 'ca'
                ? 'Error de configuració de seguretat. Contacta amb l\'administrador.'
                : 'Error de configuración de seguridad. Contacta con el administrador.';
        } else {
            $translated = t($translations, 'contact.recaptcha_invalid');
            $msg = $translated !== 'contact.recaptcha_invalid' ? $translated : 'El reCAPTCHA no es válido. Inténtalo de nuevo.';
        }
        santafe_tailwind_contact_response(false, $msg, $is_ajax);
        return;
    }

    $lead = santafe_normalize_contact_payload($payload);

    if ($lead['nombre'] === '' || $lead['mensaje'] === '' || !is_email($lead['email'])) {
        santafe_tailwind_contact_response(false, 'Revisa nombre, email y mensaje antes de enviar.', $is_ajax);
        return;
    }

    $attachments = [];
    $file_names = [];
    if (!empty($_FILES['project_photos']['name'][0])) {
        $upload_dir = wp_upload_dir();
        $max_files = 5;
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
        foreach ($_FILES['project_photos']['name'] as $i => $name) {
            if ($i >= $max_files) break;
            if ($_FILES['project_photos']['error'][$i] !== UPLOAD_ERR_OK) continue;
            if (!in_array($_FILES['project_photos']['type'][$i], $allowed_types, true)) continue;
            $safe_name = sanitize_file_name(time() . '-' . sanitize_file_name($name));
            $dest = $upload_dir['path'] . '/' . $safe_name;
            if (move_uploaded_file($_FILES['project_photos']['tmp_name'][$i], $dest)) {
                $attachments[] = $dest;
                $file_names[] = $name;
            }
        }
    }
    if (!empty($file_names)) {
        $lead['archivos'] = implode(', ', $file_names);
    }

    $email_sent = santafe_send_contact_email($lead, $attachments);

    if (!$email_sent) {
        error_log('Santa Fe lead delivery failed. Email: failed');
        santafe_tailwind_contact_response(false, 'No hemos podido enviar el mensaje. Llámanos o escríbenos por WhatsApp.', $is_ajax);
        return;
    }

    if ($email_sent && is_email($lead['email'])) {
        santafe_send_autoreply($lead);
    }

    $msg = 'Mensaje enviado correctamente. Pablo revisará tu solicitud y te contactará pronto, gracias por tu mensaje.';
    santafe_tailwind_contact_response(true, $msg, $is_ajax);
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
    add_rewrite_rule('^(servicios|reformas-integrales|obra-nueva|pladur-acabados|obra-publica|obra-civil|reformas-barcelona|reformas-girona|reformas-tarragona|contacto|sobre-nosotros|proyectos|blog|garantias)/?$', 'index.php?santafe_lang=es&santafe_route=$matches[1]', 'top');
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
        '/parquet-pavimentos/', '/reformas-banos/', '/rehabilitacion-fachadas/', '/reformas-comerciales/',
        '/es/obra-nueva/', '/es/reformas-integrales/', '/es/pladur-acabados/', '/es/obra-publica/', '/es/obra-civil/',
        '/es/parquet-pavimentos/', '/es/reformas-banos/', '/es/rehabilitacion-fachadas/', '/es/reformas-comerciales/',
        '/reformas-barcelona/', '/reformas-girona/', '/reformas-tarragona/',
        '/es/reformas-barcelona/', '/es/reformas-girona/', '/es/reformas-tarragona/',
        '/es/obra-nueva-barcelona/', '/es/obra-nueva-girona/',
        '/es/reformas-integrales-barcelona/', '/es/reformas-integrales-girona/',
        '/es/pladur-barcelona/', '/es/pladur-girona/', '/es/pladur-tarragona/',
        '/es/obra-nueva-tarragona/', '/es/reformas-integrales-tarragona/',
        '/ca/obra-nova/', '/ca/reformes-integrals/', '/ca/pladur-acabats/',
        '/ca/obra-publica/', '/ca/obra-civil/',
        '/ca/parquet-paviments/', '/ca/reformes-banys/', '/ca/rehabilitacio-facanes/', '/ca/reformes-comercials/',
        '/ca/obra-nova-barcelona/', '/ca/obra-nova-girona/', '/ca/obra-nova-tarragona/',
        '/ca/reformes-integrals-barcelona/', '/ca/reformes-integrals-girona/', '/ca/reformes-integrals-tarragona/',
        '/ca/pladur-barcelona/', '/ca/pladur-girona/', '/ca/pladur-tarragona/',
        '/ca/reformes-barcelona/', '/ca/reformes-girona/', '/ca/reformes-tarragona/',
        '/garantias/', '/es/garantias/', '/ca/garanties/',
        '/aviso-legal/', '/es/aviso-legal/', '/ca/avis-legal/',
        '/politica-privacidad/', '/es/politica-privacidad/', '/ca/politica-privacitat/',
        '/politica-cookies/', '/es/politica-cookies/', '/ca/politica-cookies/',
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
