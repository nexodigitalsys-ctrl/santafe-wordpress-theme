<?php
/**
 * Homepage — Reconstruida conforme manual
 * Hero + Dores→Soluções + Serviços + Paulo + Proceso + Portfolio + Testimonios + Calculadora + Contato
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
require_once __DIR__ . '/../includes/i18n.php';
$translations = load_translations($lang);

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Empresa de reformes i obra nova a Barcelona, Girona i Tarragona | Santa Fe' : 'Empresa de reformas y obra nueva en Barcelona, Girona y Tarragona | Santa Fe',
    'description' => $lang === 'ca' ? 'Construccions Santa Fe: obra nova, reformes integrals i obra publica a Barcelona, Girona i Tarragona amb pressupost clar, criteri tecnic i seguiment d obra.' : 'Construcciones Santa Fe: obra nueva, reformas integrales y obra publica en Barcelona, Girona y Tarragona con presupuesto claro, criterio tecnico y seguimiento de obra.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/',
    'schemas' => [
        function() use ($lang) {
            require_once __DIR__ . '/../includes/schema-faq.php';
            return get_schema_faq_page($lang);
        },
        function() use ($lang) {
            require_once __DIR__ . '/../includes/schema-reviews.php';
            return get_schema_reviews($lang);
        },
    ],
];

include __DIR__ . '/../includes/header.php';
?>

<?php include __DIR__ . '/partials/section-hero.php'; ?>
<?php include __DIR__ . '/partials/section-dores-solucoes.php'; ?>
<?php include __DIR__ . '/partials/section-servicos.php'; ?>
<?php include __DIR__ . '/partials/section-paulo.php'; ?>
<?php include __DIR__ . '/partials/section-proceso.php'; ?>
<?php include __DIR__ . '/partials/section-portfolio.php'; ?>
<?php include __DIR__ . '/partials/section-before-after.php'; ?>
<?php include __DIR__ . '/partials/section-testimonios.php'; ?>
<?php include __DIR__ . '/partials/section-garantias.php'; ?>
<?php include __DIR__ . '/partials/section-faq.php'; ?>
<?php include __DIR__ . '/partials/section-calculadora.php'; ?>
<?php include __DIR__ . '/partials/section-contacto.php'; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
