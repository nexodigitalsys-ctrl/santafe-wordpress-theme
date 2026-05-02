<?php
/**
 * WordPress bootstrap for the preserved Santa Fe PHP/Tailwind template.
 * Minimal layer: registers theme support, multilingual rewrite routes and theme template routing.
 */

defined('ABSPATH') || exit;

function santafe_tailwind_theme_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Menú principal', 'santafe-tailwind'),
    ]);
}
add_action('after_setup_theme', 'santafe_tailwind_theme_setup');

function santafe_tailwind_register_rewrites(): void {
    add_rewrite_tag('%santafe_lang%', '(es|ca)');
    add_rewrite_tag('%santafe_route%', '([^&]+)');

    add_rewrite_rule('^(es|ca)/?$', 'index.php?santafe_lang=$matches[1]&santafe_route=', 'top');
    add_rewrite_rule('^(es|ca)/(.+?)/?$', 'index.php?santafe_lang=$matches[1]&santafe_route=$matches[2]', 'top');
}
add_action('init', 'santafe_tailwind_register_rewrites');

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
