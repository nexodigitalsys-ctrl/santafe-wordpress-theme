<?php
/**
 * Sección Servicios (5 Pilares)
 * Ícones: Heroicons premium (MIT License)
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'De la idea a la clau en mà' : 'De la idea a la llave en mano';

// Heroicons Premium — outline 24px
$icon_obra_nueva = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>';

$icon_reforma = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z"/></svg>';

$icon_pladur = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 0 0 5.304 0l6.401-6.402M6.75 21A3.75 3.75 0 0 1 3 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 0 0 3.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008Z"/></svg>';

$icon_publica = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z"/></svg>';

$icon_civil = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/></svg>';

$services = $lang === 'ca' ? [
    [
        'slug' => 'obra-nova',
        'title' => 'Obra nova',
        'desc' => 'Casa, local o edifici des de zero. Llicències incloses. Clau en mà.',
        'cta' => 'Veure obres noves →',
        'img' => '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp',
        'icon' => $icon_obra_nueva,
    ],
    [
        'slug' => 'reformes-integrals',
        'title' => 'Reforma integral',
        'desc' => 'Transformem espais amb pla d\'obra clar i acabats d\'alta qualitat.',
        'cta' => 'Veure reformes →',
        'img' => '/assets/images/servicios/reformas/reforma-recepcion-acabada.webp',
        'icon' => $icon_reforma,
    ],
    [
        'slug' => 'pladur-acabats',
        'title' => 'Pladur i acabats',
        'desc' => 'Especialistes en pladur, escaiola i acabats interiors premium.',
        'cta' => 'Veure acabats →',
        'img' => '/assets/images/servicios/pladur/pladur-hall-acabado.webp',
        'icon' => $icon_pladur,
    ],
    [
        'slug' => 'obra-publica',
        'title' => 'Obra pública',
        'desc' => 'Infraestructures i urbanització amb certificació i compliment normatiu.',
        'cta' => 'Veure obra pública →',
        'img' => '/assets/images/servicios/obra-publica/obra-publica-calzada-acabada.webp',
        'icon' => $icon_publica,
    ],
    [
        'slug' => 'obra-civil',
        'title' => 'Obra civil',
        'desc' => 'Formigó, fonamentacions, murs. Alta resistència i durabilitat.',
        'cta' => 'Veure obra civil →',
        'img' => '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp',
        'icon' => $icon_civil,
    ],
] : [
    [
        'slug' => 'obra-nueva',
        'title' => 'Obra nueva',
        'desc' => 'Casa, local o edificio desde cero. Licencias incluidas. Llave en mano.',
        'cta' => 'Ver obras nuevas →',
        'img' => '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp',
        'icon' => $icon_obra_nueva,
    ],
    [
        'slug' => 'reformas-integrales',
        'title' => 'Reforma integral',
        'desc' => 'Transformamos espacios con plan de obra claro y acabados de alta calidad.',
        'cta' => 'Ver reformas →',
        'img' => '/assets/images/servicios/reformas/reforma-recepcion-acabada.webp',
        'icon' => $icon_reforma,
    ],
    [
        'slug' => 'pladur-acabados',
        'title' => 'Pladur y acabados',
        'desc' => 'Especialistas en pladur, escayola y acabados interiores premium.',
        'cta' => 'Ver acabados →',
        'img' => '/assets/images/servicios/pladur/pladur-hall-acabado.webp',
        'icon' => $icon_pladur,
    ],
    [
        'slug' => 'obra-publica',
        'title' => 'Obra pública',
        'desc' => 'Infraestructuras y urbanización con certificación y cumplimiento normativo.',
        'cta' => 'Ver obra pública →',
        'img' => '/assets/images/servicios/obra-publica/obra-publica-calzada-acabada.webp',
        'icon' => $icon_publica,
    ],
    [
        'slug' => 'obra-civil',
        'title' => 'Obra civil',
        'desc' => 'Hormigón, cimentaciones, muros. Alta resistencia y durabilidad.',
        'cta' => 'Ver obra civil →',
        'img' => '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp',
        'icon' => $icon_civil,
    ],
];

$cta_card_title = $lang === 'ca' ? 'No saps què necessites exactament?' : '¿No sabes qué necesitas exactamente?';
$cta_card_subtitle = $lang === 'ca' ? 'Pablo t\'ajuda a decidir-ho' : 'Pablo te ayuda a decidirlo';
$cta_card_btn = $lang === 'ca' ? 'Trucar ara — Respon en 2 hores' : 'Llamar ahora — Responde en 2 horas';
?>

<section data-reveal class="py-24 md:py-32 bg-slate-950" id="servicios">
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

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="servicios-grid">
            <?php foreach ($services as $svc): ?>
            <article class="service-card tilt-card group relative overflow-hidden rounded-sm bg-slate-900 border border-slate-800 hover:border-brand-600/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-brand-900/20">
                <div class="aspect-[16/10] overflow-hidden bg-slate-800 relative">
                    <img src="<?php echo esc_url(get_template_directory_uri() . $svc['img']); ?>"
                         alt="<?php echo esc_attr($svc['title']); ?>"
                         class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500"
                         loading="lazy"
                         onerror="this.src='<?php echo esc_url(get_template_directory_uri() . '/assets/images/fallback-construction.svg'); ?>'">
                    <div class="absolute top-4 left-4 w-12 h-12 bg-brand-600/90 backdrop-blur-sm rounded-sm flex items-center justify-center text-slate-950 shadow-lg">
                        <?php echo $svc['icon']; ?>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-display font-bold text-xl text-white mb-2"><?php echo $svc['title']; ?></h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4"><?php echo $svc['desc']; ?></p>
                    <a href="/<?php echo $lang; ?>/<?php echo $svc['slug']; ?>/" class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold group/link hover:text-brand-400 transition-colors">
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
