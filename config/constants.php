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
    define('COMPANY_PHONE_DISPLAY', '+34 665 737 547');
}

if (!defined('WHATSAPP_NUMBER')) {
    define('WHATSAPP_NUMBER', '34665737547');
}

if (!defined('COMPANY_EMAIL')) {
    define('COMPANY_EMAIL', 'Constrsantafe@gmail.com');
}

if (!defined('SANTAFE_CONTACT_EMAIL')) {
    define('SANTAFE_CONTACT_EMAIL', 'nexodigital.sys@gmail.com');
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
