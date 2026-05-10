<?php
/**
 * Proyectos / Galería — Tailwind CSS
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $lang === 'ca' ? 'Projectes' : 'Proyectos', 'url' => '/' . $lang . '/' . ($lang === 'ca' ? 'projectes' : 'proyectos') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Ejemplos visuales de construcción | Santa Fe' : 'Ejemplos visuales de construcción | Santa Fe',
    'description' => $lang === 'ca' ? 'Referencias visuales provisionales de servicios hasta publicar obras reales autorizadas.' : 'Referencias visuales provisionales de servicios hasta publicar obras reales autorizadas.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . ($lang === 'ca' ? 'projectes' : 'proyectos') . '/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }]
];

$theme_uri = get_template_directory_uri();
$projects = [
    ['img' => $theme_uri . '/assets/images/portfolio/portfolio-obra-nueva-piscina.webp', 'title' => 'Obra nueva con piscina · Girona · 2024', 'desc' => 'Construcción de vivienda unifamiliar con piscina y jardín. Llave en mano.', 'cat' => $lang === 'ca' ? 'Obra nova' : 'Obra nueva', 'span' => 'md:col-span-2 lg:col-span-2'],
    ['img' => $theme_uri . '/assets/images/portfolio/portfolio-reforma-recepcion.webp', 'title' => 'Reforma recepción · Barcelona · 2024', 'desc' => 'Reforma integral de espacio comercial con acabados premium.', 'cat' => 'Reforma', 'span' => ''],
    ['img' => $theme_uri . '/assets/images/portfolio/portfolio-obra-publica-calzada.webp', 'title' => 'Pavimentación urbana · Barcelona · 2024', 'desc' => 'Obra pública de pavimentación y aceras en zona urbana.', 'cat' => $lang === 'ca' ? 'Obra pública' : 'Obra pública', 'span' => ''],
    ['img' => $theme_uri . '/assets/images/servicios/pladur/pladur-hall-acabado.webp', 'title' => 'Pladur y acabados · Gràcia · 2024', 'desc' => 'Instalación de pladur y acabados de interior en hall residencial.', 'cat' => $lang === 'ca' ? 'Acabats' : 'Acabados', 'span' => 'md:col-span-2'],
    ['img' => $theme_uri . '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp', 'title' => 'Obra civil · Tarragona · 2023', 'desc' => 'Colocación de bordillos y pavimentación de aceras.', 'cat' => 'Obra civil', 'span' => ''],
    ['img' => $theme_uri . '/assets/images/portfolio/portfolio-reforma-suelo.webp', 'title' => 'Suelo porcelánico · Tarragona · 2023', 'desc' => 'Colocación de suelo porcelánico imitación madera en vivienda.', 'cat' => 'Reforma', 'span' => ''],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Portfolio</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight">
                <?php echo $lang === 'ca' ? 'Referències visuals<br>per tipus de servei' : 'Referencias visuales<br>por tipo de servicio'; ?>
            </h1>
            <p class="text-slate-400 mt-6 max-w-xl text-lg">
                <?php echo $lang === 'ca' ? 'Publicarem obres reals quan tinguem autorització documental i fotos pròpies.' : 'Publicaremos obras reales cuando tengamos autorización documental y fotos propias.'; ?>
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($projects as $proy): ?>
            <article class="group relative overflow-hidden rounded-sm aspect-[4/3] <?php echo $proy['span']; ?> cursor-pointer">
                <img src="<?php echo $proy['img']; ?>" alt="<?php echo htmlspecialchars($proy['title'], ENT_QUOTES, 'UTF-8'); ?>" class="w-full h-full object-cover img-zoom" loading="lazy" onerror="this.src='/assets/images/fallback-construction.svg'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-widest mb-2 block"><?php echo htmlspecialchars($proy['cat'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <h3 class="font-display font-bold text-xl text-white mb-1"><?php echo htmlspecialchars($proy['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="text-slate-300 text-sm"><?php echo htmlspecialchars($proy['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-6"><?php echo t($translations, 'cta_section.title'); ?></h2>
        <p class="text-slate-400 mb-10"><?php echo t($translations, 'cta_section.subtitle'); ?></p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo t($translations, 'cta_section.primary'); ?>
            </a>
            <a href="tel:+34665737547" class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo t($translations, 'cta_section.secondary'); ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
