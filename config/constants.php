<?php
/**
 * Central public configuration for the Santa Fe theme.
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

if (!defined('COMPANY_NAME')) {
    define('COMPANY_NAME', 'Construcciones Santa Fe Siglo XXI SLU');
}

if (!defined('COMPANY_BRAND')) {
    define('COMPANY_BRAND', 'Santa Fe Construcciones');
}

if (!defined('COMPANY_DOMAIN')) {
    define('COMPANY_DOMAIN', getenv('SANTAFE_DOMAIN') ?: 'https://santafe.nexo-digital.app');
}

if (!defined('COMPANY_PHONE')) {
    define('COMPANY_PHONE', '+34665737547');
}

if (!defined('COMPANY_PHONE_DISPLAY')) {
    define('COMPANY_PHONE_DISPLAY', '665 737 547');
}

if (!defined('WHATSAPP_NUMBER')) {
    define('WHATSAPP_NUMBER', '34665737547');
}

if (!defined('COMPANY_EMAIL')) {
    define('COMPANY_EMAIL', 'info@santafe-construcciones.com');
}

if (!defined('SANTAFE_CONTACT_EMAIL')) {
    define('SANTAFE_CONTACT_EMAIL', 'info@santafe-construcciones.com');
}

if (!defined('SANTAFE_TELEGRAM_BOT_TOKEN')) {
    define('SANTAFE_TELEGRAM_BOT_TOKEN', trim((string) (getenv('SANTAFE_TELEGRAM_BOT_TOKEN') ?: '')));
}

if (!defined('SANTAFE_TELEGRAM_CHAT_ID')) {
    define('SANTAFE_TELEGRAM_CHAT_ID', trim((string) (getenv('SANTAFE_TELEGRAM_CHAT_ID') ?: '')));
}

if (!defined('DEFAULT_LANG')) {
    define('DEFAULT_LANG', 'es');
}

if (!defined('SUPPORTED_LANGS')) {
    define('SUPPORTED_LANGS', ['es', 'ca']);
}

if (!defined('GA4_ID')) {
    define('GA4_ID', getenv('GA4_ID') ?: '');
}

if (!defined('GTM_ID')) {
    define('GTM_ID', getenv('GTM_ID') ?: '');
}

if (!defined('SANTAFE_ENABLE_ANALYTICS')) {
    define('SANTAFE_ENABLE_ANALYTICS', GA4_ID !== '' || GTM_ID !== '');
}

if (!defined('RECAPTCHA_SITE_KEY')) {
    define('RECAPTCHA_SITE_KEY', '6LdH7R4tAAAAAISuZE-EMqbyZhwLwaSBUU26jjK0');
}

if (!defined('RECAPTCHA_SECRET_KEY')) {
    define('RECAPTCHA_SECRET_KEY', '6LdH7R4tAAAAAGiIpB1k0HCfAwgx_juSvwOJ6tSA');
}

// ── Redes sociais ───────────────────────────────────────────────────
if (!defined('SOCIAL_INSTAGRAM')) {
    define('SOCIAL_INSTAGRAM', 'https://www.instagram.com/construcciones_santafe_?igsh=MW81Ym9odGNkdmlydg%3D%3D');
}
if (!defined('SOCIAL_TIKTOK')) {
    define('SOCIAL_TIKTOK', 'https://www.tiktok.com/@santafe_construcciones');
}
if (!defined('SOCIAL_X')) {
    define('SOCIAL_X', 'https://x.com/Santafe_constru');
}
if (!defined('SOCIAL_FACEBOOK')) {
    define('SOCIAL_FACEBOOK', '');
}
if (!defined('SOCIAL_LINKEDIN')) {
    define('SOCIAL_LINKEDIN', '');
}
