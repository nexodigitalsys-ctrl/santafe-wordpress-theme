<?php
/**
 * Página dedicada: Pladur y acabados
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$translations = load_translations($lang);

$service_slug = 'pladur-acabados';
$service_name = $lang === 'ca' ? 'Pladur i acabats' : 'Pladur y acabados';
$service_desc = $lang === 'ca'
    ? 'Especialistes en pladur, escaiola i acabats interiors premium.'
    : 'Especialistas en pladur, escayola y acabados interiores premium.';

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Pladur i acabats a Barcelona, Girona i Tarragona | Santa Fe' : 'Pladur y acabados en Barcelona, Girona y Tarragona | Santa Fe',
    'description' => $service_desc,
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/pladur-acabados/',
    'schemas' => [
        function() use ($service_slug, $lang) {
            return get_schema_service($service_slug, $lang);
        },
        function() use ($lang, $service_name) {
            return get_schema_breadcrumb([
                ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
                ['name' => $service_name, 'url' => '/' . $lang . '/pladur-acabados/'],
            ]);
        },
    ],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-32 pb-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.services'); ?></span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight"><?php echo $service_name; ?></h1>
            <p class="text-slate-400 mt-4 max-w-2xl text-lg"><?php echo $service_desc; ?></p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            <div class="space-y-6">
                <h2 class="font-display font-bold text-2xl text-white"><?php echo $lang === 'ca' ? 'Què inclou' : 'Qué incluye'; ?></h2>
                <ul class="space-y-4">
                    <?php foreach (($lang === 'ca' ? [
                        'Instal·lació de pladur en parets i sostres',
                        'Escaiola decorativa',
                        'Aïllament tèrmic i acústic',
                        'Pintura premium i acabats',
                        'Moldures i rosetons',
                        'Reparació de juntes',
                    ] : [
                        'Instalación de pladur en paredes y techos',
                        'Escayola decorativa',
                        'Aislamiento térmico y acústico',
                        'Pintura premium y acabados',
                        'Molduras y rosetones',
                        'Reparación de juntas',
                    ]) as $item): ?>
                    <li class="flex items-center gap-3 text-slate-300">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#AE232A" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                        <?php echo $item; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="aspect-video bg-slate-900 rounded-sm overflow-hidden">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/servicios/pladur/pladur-hall-acabado.webp'); ?>"
                     alt="<?php echo esc_attr($service_name); ?>"
                     class="w-full h-full object-cover"
                     loading="lazy"
                     onerror="this.src='<?php echo esc_url(get_template_directory_uri() . '/assets/images/fallback-construction.svg'); ?>'">
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/section-cta-final.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>
