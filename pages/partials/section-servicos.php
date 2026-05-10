<?php
/**
 * Sección Servicios (5 Pilares)
 * "¿Qué necesitas construir?"
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Què necessites construir?' : '¿Qué necesitas construir?';

$services = $lang === 'ca' ? [
    [
        'slug' => 'obra-nova',
        'title' => 'Obra nova',
        'desc' => 'Casa, local o edifici des de zero. Llicències incloses. Clau en mà.',
        'cta' => 'Veure obres noves →',
        'img' => '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp',
    ],
    [
        'slug' => 'reformes-integrals',
        'title' => 'Reforma integral',
        'desc' => 'Transformem espais amb pla d\'obra clar i acabats d\'alta qualitat.',
        'cta' => 'Veure reformes →',
        'img' => '/assets/images/servicios/reformas/reforma-recepcion-acabada.webp',
    ],
    [
        'slug' => 'pladur-acabats',
        'title' => 'Pladur i acabats',
        'desc' => 'Especialistes en pladur, escaiola i acabats interiors premium.',
        'cta' => 'Veure acabats →',
        'img' => '/assets/images/servicios/pladur/pladur-hall-acabado.webp',
    ],
    [
        'slug' => 'obra-publica',
        'title' => 'Obra pública',
        'desc' => 'Infraestructures i urbanització amb certificació i compliment normatiu.',
        'cta' => 'Veure obra pública →',
        'img' => '/assets/images/servicios/obra-publica/obra-publica-calzada-acabada.webp',
    ],
    [
        'slug' => 'obra-civil',
        'title' => 'Obra civil',
        'desc' => 'Formigó, fonamentacions, murs. Alta resistència i durabilitat.',
        'cta' => 'Veure obra civil →',
        'img' => '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp',
    ],
] : [
    [
        'slug' => 'obra-nueva',
        'title' => 'Obra nueva',
        'desc' => 'Casa, local o edificio desde cero. Licencias incluidas. Llave en mano.',
        'cta' => 'Ver obras nuevas →',
        'img' => '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp',
    ],
    [
        'slug' => 'reformas-integrales',
        'title' => 'Reforma integral',
        'desc' => 'Transformamos espacios con plan de obra claro y acabados de alta calidad.',
        'cta' => 'Ver reformas →',
        'img' => '/assets/images/servicios/reformas/reforma-recepcion-acabada.webp',
    ],
    [
        'slug' => 'pladur-acabados',
        'title' => 'Pladur y acabados',
        'desc' => 'Especialistas en pladur, escayola y acabados interiores premium.',
        'cta' => 'Ver acabados →',
        'img' => '/assets/images/servicios/pladur/pladur-hall-acabado.webp',
    ],
    [
        'slug' => 'obra-publica',
        'title' => 'Obra pública',
        'desc' => 'Infraestructuras y urbanización con certificación y cumplimiento normativo.',
        'cta' => 'Ver obra pública →',
        'img' => '/assets/images/servicios/obra-publica/obra-publica-calzada-acabada.webp',
    ],
    [
        'slug' => 'obra-civil',
        'title' => 'Obra civil',
        'desc' => 'Hormigón, cimentaciones, muros. Alta resistencia y durabilidad.',
        'cta' => 'Ver obra civil →',
        'img' => '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp',
    ],
];

$cta_card_title = $lang === 'ca' ? 'No saps per on començar?' : '¿No sabes por dónde empezar?';
$cta_card_subtitle = $lang === 'ca' ? 'Parla amb en Paulo' : 'Habla con Paulo';
$cta_card_btn = $lang === 'ca' ? 'Contactar ara' : 'Contactar ahora';
?>

<section class="py-24 md:py-32 bg-slate-950" id="servicios">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16 gap-6">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.services'); ?></span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight"><?php echo $title; ?></h2>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $svc): ?>
            <article class="group relative overflow-hidden rounded-sm bg-slate-900 border border-slate-800 card-lift">
                <div class="aspect-[16/10] overflow-hidden bg-slate-800">
                    <img src="<?php echo esc_url(get_template_directory_uri() . $svc['img']); ?>"
                         alt="<?php echo esc_attr($svc['title']); ?>"
                         class="w-full h-full object-cover img-zoom opacity-80 group-hover:opacity-100 transition-opacity"
                         loading="lazy"
                         onerror="this.src='<?php echo esc_url(get_template_directory_uri() . '/assets/images/fallback-construction.svg'); ?>'">
                </div>
                <div class="p-6">
                    <h3 class="font-display font-bold text-xl text-white mb-2"><?php echo $svc['title']; ?></h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4"><?php echo $svc['desc']; ?></p>
                    <a href="/<?php echo $lang; ?>/<?php echo $svc['slug']; ?>/" class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold group/link">
                        <?php echo $svc['cta']; ?>
                        <span class="transition-transform group-hover/link:translate-x-1">→</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>

            <!-- CTA Card -->
            <div class="flex flex-col justify-center items-center p-8 bg-brand-950/30 border border-brand-900/50 rounded-sm text-center">
                <p class="text-brand-400 text-sm uppercase tracking-widest mb-3"><?php echo $cta_card_title; ?></p>
                <p class="font-display font-bold text-2xl text-white mb-6"><?php echo $cta_card_subtitle; ?></p>
                <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-6 py-3 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $cta_card_btn; ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
