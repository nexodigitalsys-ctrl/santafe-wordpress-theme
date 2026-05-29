<?php
$lang = $_GET['lang'] ?? 'es';
$isCa = $lang === 'ca';
$title = $isCa ? 'El abans i el després' : 'El antes y el después';
$subtitle = $isCa ? 'Arrossega per veure la transformació' : 'Arrastra para ver la transformación';
$label_antes = $isCa ? 'Abans' : 'Antes';
$label_despues = $isCa ? 'Després' : 'Después';
?>
<section class="py-24 md:py-32 section-beforeafter relative overflow-hidden" id="antes-despues" data-reveal>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-px section-beforeafter-border-top"></div>
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="inline-block px-3 py-1 section-beforeafter-badge text-xs font-bold tracking-widest uppercase rounded-full border mb-4"><?php echo $isCa ? 'Transformació real' : 'Transformación real'; ?></span>
            <h2 class="font-display font-bold text-4xl md:text-5xl section-beforeafter-title tracking-tight mb-4"><?php echo $title; ?></h2>
            <p class="section-beforeafter-body text-lg"><?php echo $subtitle; ?></p>
        </div>

        <div class="before-after relative rounded-sm overflow-hidden cursor-ew-resize select-none" style="aspect-ratio: 16/9;">
            <!-- After (full image) -->
            <div class="before-after__after absolute inset-0">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/servicios/reformas/reforma-pared-madera-acabada.webp"
                     alt="Después - Reforma acabada"
                     class="w-full h-full object-cover"
                     loading="lazy">
                <span class="absolute bottom-4 right-4 section-beforeafter-after-label text-xs font-bold px-3 py-1 rounded-sm uppercase tracking-wider"><?php echo $label_despues; ?></span>
            </div>
            <!-- Before (clipped) -->
            <div class="before-after__before absolute inset-0" style="clip-path: inset(0 50% 0 0);">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/servicios/reformas/reforma-trabajadores-azulejos-pared.webp"
                     alt="Antes - Obra en progreso"
                     class="w-full h-full object-cover"
                     loading="lazy">
                <span class="absolute bottom-4 left-4 section-beforeafter-before-label text-xs font-bold px-3 py-1 rounded-sm uppercase tracking-wider"><?php echo $label_antes; ?></span>
            </div>
            <!-- Handle -->
            <div class="before-after__handle absolute top-0 bottom-0 w-1 bg-white shadow-lg cursor-ew-resize flex items-center justify-center" style="left: 50%; transform: translateX(-50%);">
                <div class="w-10 h-10 section-beforeafter-handle rounded-full shadow-xl flex items-center justify-center">
                    <svg class="w-5 h-5 section-beforeafter-handle-text" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>
                </div>
            </div>
        </div>

        <p class="text-center section-beforeafter-caption text-sm mt-6"><?php echo $isCa ? 'Reforma integral d\'habitatge a Barcelona. 3 setmanes d\'obra.' : 'Reforma integral de vivienda en Barcelona. 3 semanas de obra.'; ?></p>
    </div>
</section>
