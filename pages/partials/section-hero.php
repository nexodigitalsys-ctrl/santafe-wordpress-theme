<?php
/**
 * Hero Section — Foto real de obra + gradiente pesado
 * Sem vídeo. O foco é a mensagem, não o background.
 * Foto: hero-fachada-piedra.webp (qualidade construtiva visível)
 */

declare(strict_types=1);

$hero_title = $lang === 'ca' ? 'Construïm el que imagines.<br><span class="text-brand-400">Reformem el que ja tens.</span>' : 'Construimos lo que imaginas.<br><span class="text-brand-400">Reformamos lo que ya tienes.</span>';
$hero_subtitle = $lang === 'ca'
    ? 'Obra nova, reforma integral, pladur, obra pública i obra civil. Presupost tancat en 48h. Sense sorpreses, sense costos ocults.'
    : 'Obra nueva, reforma integral, pladur, obra pública y obra civil. Presupuesto cerrado en 48h. Sin sorpresas, sin costos ocultos.';
$badge = $lang === 'ca' ? '17 anys · 500+ obres · Barcelona, Girona, Tarragona' : '17 años · 500+ obras · Barcelona, Girona, Tarragona';
$cta_primary = $lang === 'ca' ? 'Presupost gratuït en 48h' : 'Presupuesto gratuito en 48h';
$cta_secondary = $lang === 'ca' ? 'Veure obres realitzades' : 'Ver obras realizadas';
$stat_years_label = $lang === 'ca' ? 'Anys d\'experiència' : 'Años de experiencia';
$stat_projects_label = $lang === 'ca' ? 'Obres lliurades' : 'Obras entregadas';
$stat_provinces_label = $lang === 'ca' ? 'Províncies' : 'Provincias';
?>

<section class="relative min-h-[92vh] flex items-center overflow-hidden" id="inicio">
    <!-- Background: foto real de fachada en piedra -->
    <div class="absolute inset-0">
        <img 
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero/hero-fachada-piedra.webp'); ?>"
            alt="Fachada en piedra natural — Santa Fe Construcciones"
            class="absolute inset-0 w-full h-full object-cover"
            style="object-position: center 30%;"
            fetchpriority="high"
        >
        <!-- Gradientes pesados para legibilidade absoluta -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/92 to-slate-950/65"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/60"></div>
        <div class="absolute inset-0 bg-slate-950/25"></div>
    </div>

    <!-- Conteúdo -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-20">
        <div class="max-w-4xl mx-auto text-center lg:text-left lg:mx-0">
            <div class="flex items-center justify-center lg:justify-start gap-4 mb-8 animate-fade-in">
                <div class="industrial-line w-16"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $badge; ?></span>
            </div>

            <h1 class="font-display font-bold text-5xl sm:text-6xl md:text-7xl lg:text-8xl text-white leading-[0.95] tracking-tight mb-8 animate-slide-up">
                <?php echo $hero_title; ?>
            </h1>

            <p class="text-slate-300 text-lg md:text-xl max-w-2xl mx-auto lg:mx-0 mb-10 leading-relaxed animate-slide-up delay-200">
                <?php echo $hero_subtitle; ?>
            </p>

            <div class="flex flex-wrap justify-center lg:justify-start gap-4 mb-16 animate-slide-up delay-300">
                <a href="#contacto" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-slate-950 font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                    <?php echo $cta_primary; ?>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#portfolio" class="inline-flex items-center gap-2 border border-slate-500 hover:border-white text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                    <?php echo $cta_secondary; ?>
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto lg:mx-0 animate-slide-up delay-400">
                <div class="text-center lg:text-left" data-reveal data-reveal-delay="400">
                    <span class="font-display font-bold text-4xl md:text-5xl text-brand-500 block" data-counter="17" data-counter-duration="2000">0</span>
                    <span class="text-slate-400 text-sm mt-1 block"><?php echo $stat_years_label; ?></span>
                </div>
                <div class="text-center lg:text-left" data-reveal data-reveal-delay="500">
                    <span class="font-display font-bold text-4xl md:text-5xl text-brand-500 block" data-counter="500" data-counter-suffix="+" data-counter-duration="2500">0</span>
                    <span class="text-slate-400 text-sm mt-1 block"><?php echo $stat_projects_label; ?></span>
                </div>
                <div class="text-center lg:text-left" data-reveal data-reveal-delay="600">
                    <span class="font-display font-bold text-4xl md:text-5xl text-brand-500 block" data-counter="3" data-counter-duration="1500">0</span>
                    <span class="text-slate-400 text-sm mt-1 block"><?php echo $stat_provinces_label; ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce hidden md:block">
        <a href="#servicios" class="flex flex-col items-center gap-2 text-slate-500 hover:text-brand-400 transition-colors">
            <span class="text-xs uppercase tracking-widest"><?php echo $lang === 'ca' ? 'Descobreix' : 'Descubre'; ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75"/></svg>
        </a>
    </div>
</section>
