<?php
/**
 * Sección Portfólio
 * "Obras que hemos construido"
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Obres que hem construït' : 'Obras que hemos construido';
$subtitle = $lang === 'ca'
    ? 'Projectes reals a Barcelona, Girona i Tarragona.'
    : 'Proyectos reales en Barcelona, Girona y Tarragona.';

$filters = $lang === 'ca' ? [
    'all' => 'Totes',
    'obra-nueva' => 'Obra nova',
    'reformas' => 'Reformes',
    'pladur' => 'Pladur',
    'obra-publica' => 'Obra pública',
    'obra-civil' => 'Obra civil',
] : [
    'all' => 'Todos',
    'obra-nueva' => 'Obra nueva',
    'reformas' => 'Reformas',
    'pladur' => 'Pladur',
    'obra-publica' => 'Obra pública',
    'obra-civil' => 'Obra civil',
];

// Proyectos reales con fotos propias
$projects = [
    ['img' => '/assets/images/real/obra-nueva-desde-cero.webp', 'title' => 'Construcción desde cero · Barcelona · 2024', 'm2' => '320', 'duration' => '10 meses', 'city' => 'Barcelona', 'category' => 'obra-nueva'],
    ['img' => '/assets/images/real/reforma-completa-casa-barcelona.webp', 'title' => 'Reforma completa casa · Barcelona · 2024', 'm2' => '180', 'duration' => '3 meses', 'city' => 'Barcelona', 'category' => 'reformas'],
    ['img' => '/assets/images/real/obra-publica-calzada-reformada.webp', 'title' => 'Calzada reformada · Barcelona · 2024', 'm2' => '850', 'duration' => '4 meses', 'city' => 'Barcelona', 'category' => 'obra-publica'],
    ['img' => '/assets/images/real/obra-nueva-construcciones-girona.webp', 'title' => 'Construcción residencial · Girona · 2023', 'm2' => '240', 'duration' => '8 meses', 'city' => 'Girona', 'category' => 'obra-nueva'],
    ['img' => '/assets/images/real/reforma-gerona.webp', 'title' => 'Reforma piso · Girona · 2024', 'm2' => '85', 'duration' => '6 semanas', 'city' => 'Girona', 'category' => 'reformas'],
    ['img' => '/assets/images/real/reforma-interiores-vivienda.webp', 'title' => 'Interiores de vivienda · Barcelona · 2023', 'm2' => '95', 'duration' => '2 semanas', 'city' => 'Barcelona', 'category' => 'reformas'],
    ['img' => '/assets/images/real/obra-nueva-construcciones-santafe.webp', 'title' => 'Obra nueva Santa Fe · Barcelona · 2024', 'm2' => '280', 'duration' => '12 meses', 'city' => 'Barcelona', 'category' => 'obra-nueva'],
    ['img' => '/assets/images/real/pladur-instalacion.webp', 'title' => 'Instalación pladur · Barcelona · 2024', 'm2' => '120', 'duration' => '1 mes', 'city' => 'Barcelona', 'category' => 'pladur'],
    ['img' => '/assets/images/real/obra-civil-muros.webp', 'title' => 'Construcción de muros · Barcelona · 2024', 'm2' => '450', 'duration' => '5 meses', 'city' => 'Barcelona', 'category' => 'obra-civil'],
];

$ver_proyecto = $lang === 'ca' ? 'Veure projecte →' : 'Ver proyecto →';

$category_to_service = [
    'obra-nueva' => 'obra-nueva',
    'reformas' => 'reformas-integrales',
    'pladur' => 'pladur-acabados',
    'obra-publica' => 'obra-publica',
    'obra-civil' => 'obra-civil',
];
$ca_category_to_service = [
    'obra-nueva' => 'obra-nova',
    'reformas' => 'reformes-integrals',
    'pladur' => 'pladur-acabats',
    'obra-publica' => 'obra-publica',
    'obra-civil' => 'obra-civil',
];
?>

<section data-reveal class="py-24 md:py-32 section-portfolio border-b" id="portfolio">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12 gap-6">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="section-portfolio-badge text-xs font-semibold uppercase tracking-[0.3em]">Portfolio</span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl section-portfolio-title tracking-tight"><?php echo $title; ?></h2>
                <p class="section-portfolio-body mt-4 max-w-lg"><?php echo $subtitle; ?></p>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap gap-2 mb-10">
            <?php foreach ($filters as $key => $label): ?>
            <button type="button"
                    class="portfolio-filter__btn px-4 py-2 text-sm font-medium rounded-sm border transition-all <?php echo $key === 'all' ? 'section-portfolio-filter-active' : 'section-portfolio-filter-inactive hover:border-brand-500 hover:text-brand-600'; ?>"
                    data-filter="<?php echo $key; ?>">
                <?php echo $label; ?>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="portfolio-grid">
            <?php foreach ($projects as $proy): ?>
            <article class="tilt-card portfolio-card group relative overflow-hidden rounded-sm section-portfolio-card border rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300"
                     data-category="<?php echo $proy['category']; ?>">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="<?php echo esc_url(get_template_directory_uri() . $proy['img']); ?>"
                         alt="<?php echo esc_attr($proy['title']); ?>"
                         class="w-full h-full object-cover img-zoom"
                         loading="lazy"
                         onerror="this.parentElement.style.display='none'">
                    <span class="absolute top-4 left-4 px-3 py-1 section-portfolio-tag text-xs font-semibold uppercase tracking-wider rounded-sm">
                        <?php echo $filters[$proy['category']] ?? $proy['category']; ?>
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="font-display font-bold text-lg section-portfolio-title mb-2"><?php echo htmlspecialchars($proy['title']); ?></h3>
                    <div class="flex flex-wrap gap-3 section-portfolio-meta text-sm mb-4">
                        <span class="flex items-center gap-1">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            <?php echo $proy['m2']; ?> m²
                        </span>
                        <span class="flex items-center gap-1">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <?php echo $proy['duration']; ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo $proy['city']; ?>
                        </span>
                    </div>
                    <?php
                    $svc_slug = $lang === 'ca'
                        ? ($ca_category_to_service[$proy['category']] ?? $proy['category'])
                        : ($category_to_service[$proy['category']] ?? $proy['category']);
                    ?>
                    <a href="/<?php echo $lang; ?>/<?php echo $svc_slug; ?>/" class="inline-flex items-center gap-1 section-portfolio-link text-sm font-semibold transition-colors group/link">
                        <?php echo $ver_proyecto; ?>
                        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Portfolio Lightbox -->
<div id="portfolio-lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-white/95 backdrop-blur-sm" role="dialog" aria-modal="true">
    <button id="portfolio-lightbox-close" class="absolute top-6 right-6 text-warm-900 hover:text-brand-600 transition-colors z-10" aria-label="Cerrar">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="max-w-5xl max-h-[90vh] px-6">
        <img id="portfolio-lightbox-img" src="" alt="" class="max-w-full max-h-[85vh] object-contain rounded-sm shadow-2xl">
        <p id="portfolio-lightbox-title" class="text-warm-900 text-center mt-4 font-display text-lg"></p>
    </div>
</div>
