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
    ['img' => '/assets/images/portfolio/portfolio-obra-nueva-piscina.webp', 'title' => 'Obra nueva con piscina · Girona · 2024', 'm2' => '320', 'duration' => '10 meses', 'city' => 'Girona', 'category' => 'obra-nueva'],
    ['img' => '/assets/images/portfolio/portfolio-reforma-recepcion.webp', 'title' => 'Reforma recepción · Barcelona · 2024', 'm2' => '180', 'duration' => '3 meses', 'city' => 'Barcelona', 'category' => 'reformas'],
    ['img' => '/assets/images/portfolio/portfolio-obra-publica-calzada.webp', 'title' => 'Pavimentación urbana · Barcelona · 2024', 'm2' => '850', 'duration' => '4 meses', 'city' => 'Barcelona', 'category' => 'obra-publica'],
    ['img' => '/assets/images/portfolio/portfolio-obra-nueva-fachada-piedra.webp', 'title' => 'Fachada en piedra natural · Girona · 2023', 'm2' => '240', 'duration' => '8 meses', 'city' => 'Girona', 'category' => 'obra-nueva'],
    ['img' => '/assets/images/portfolio/portfolio-reforma-ducha.webp', 'title' => 'Reforma baño completo · Barcelona · 2024', 'm2' => '12', 'duration' => '3 semanas', 'city' => 'Barcelona', 'category' => 'reformas'],
    ['img' => '/assets/images/portfolio/portfolio-reforma-suelo.webp', 'title' => 'Suelo porcelánico imitación madera · Tarragona · 2023', 'm2' => '95', 'duration' => '2 semanas', 'city' => 'Tarragona', 'category' => 'reformas'],
    ['img' => '/assets/images/portfolio/portfolio-obra-nueva-casa-moderna.webp', 'title' => 'Vivienda unifamiliar moderna · Barcelona · 2024', 'm2' => '280', 'duration' => '12 meses', 'city' => 'Barcelona', 'category' => 'obra-nueva'],
    ['img' => '/assets/images/servicios/pladur/pladur-hall-acabado.webp', 'title' => 'Pladur y acabados · Gràcia · 2024', 'm2' => '120', 'duration' => '1 mes', 'city' => 'Barcelona', 'category' => 'pladur'],
    ['img' => '/assets/images/servicios/obra-publica/obra-civil-aceras-construccion.webp', 'title' => 'Aceras y mobiliario urbano · Tarragona · 2023', 'm2' => '450', 'duration' => '5 meses', 'city' => 'Tarragona', 'category' => 'obra-civil'],
];

$ver_proyecto = $lang === 'ca' ? 'Veure projecte →' : 'Ver proyecto →';
?>

<section class="py-24 md:py-32 bg-slate-900 border-b border-slate-800" id="portfolio">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12 gap-6">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Portfolio</span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight"><?php echo $title; ?></h2>
                <p class="text-slate-400 mt-4 max-w-lg"><?php echo $subtitle; ?></p>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap gap-2 mb-10">
            <?php foreach ($filters as $key => $label): ?>
            <button type="button"
                    class="portfolio-filter__btn px-4 py-2 text-sm font-medium rounded-sm border transition-all <?php echo $key === 'all' ? 'bg-brand-600 border-brand-600 text-slate-950' : 'border-slate-700 text-slate-300 hover:border-brand-500 hover:text-white'; ?>"
                    data-filter="<?php echo $key; ?>">
                <?php echo $label; ?>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="portfolio-grid">
            <?php foreach ($projects as $proy): ?>
            <article class="portfolio-card group relative overflow-hidden rounded-sm bg-slate-950 border border-slate-800 transition-all duration-300"
                     data-category="<?php echo $proy['category']; ?>">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="<?php echo esc_url(get_template_directory_uri() . $proy['img']); ?>"
                         alt="<?php echo esc_attr($proy['title']); ?>"
                         class="w-full h-full object-cover img-zoom"
                         loading="lazy"
                         onerror="this.parentElement.style.display='none'">
                    <span class="absolute top-4 left-4 px-3 py-1 bg-brand-600 text-white text-xs font-semibold uppercase tracking-wider rounded-sm">
                        <?php echo $filters[$proy['category']] ?? $proy['category']; ?>
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="font-display font-bold text-lg text-white mb-2"><?php echo htmlspecialchars($proy['title']); ?></h3>
                    <div class="flex flex-wrap gap-3 text-slate-400 text-sm">
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
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
