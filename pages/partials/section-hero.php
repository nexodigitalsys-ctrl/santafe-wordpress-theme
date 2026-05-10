<?php
/**
 * Hero Section — Conforme manual
 * Copy aprobado: "Construimos desde 2008"
 */

declare(strict_types=1);

$hero_title = $lang === 'ca' ? 'Construïm des de 2008' : 'Construimos desde 2008';
$hero_subtitle = $lang === 'ca'
    ? 'Obres a Barcelona, Girona i Tarragona. Sense sobrecostos. Sense retards. Sense desaparèixer.'
    : 'Obras en Barcelona, Girona y Tarragona. Sin sobrecostes. Sin retrasos. Sin desaparecer.';
$badge = $lang === 'ca' ? 'Des de 2008 · Barcelona · Girona · Tarragona' : 'Desde 2008 · Barcelona · Girona · Tarragona';
$cta_primary = $lang === 'ca' ? 'Sol·licitar pressupost gratuït' : 'Solicitar presupuesto gratuito';
$cta_secondary = $lang === 'ca' ? 'Veure obres realitzades' : 'Ver obras realizadas';
$stat_years_label = $lang === 'ca' ? 'Anys d\'experiència' : 'Años de experiencia';
$stat_projects_label = $lang === 'ca' ? 'Projectes lliurats' : 'Proyectos entregados';
$stat_provinces_label = $lang === 'ca' ? 'Províncies' : 'Provincias';
?>

<section class="relative min-h-screen flex items-center overflow-hidden" id="inicio">
    <!-- Background -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero/hero-piscina-jardin.webp'); ?>');">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/85 to-slate-950/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/35"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pb-16 pt-40">
        <div class="max-w-4xl">
            <div class="flex items-center gap-4 mb-8 animate-fade-in">
                <div class="industrial-line w-16"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $badge; ?></span>
            </div>

            <h1 class="font-display font-bold text-5xl sm:text-6xl md:text-7xl lg:text-8xl text-white leading-[0.92] tracking-tight mb-8 animate-slide-up">
                <?php echo $hero_title; ?>
            </h1>

            <p class="text-slate-300 text-lg md:text-xl max-w-2xl mb-10 leading-relaxed animate-slide-up delay-200">
                <?php echo $hero_subtitle; ?>
            </p>

            <div class="flex flex-wrap gap-4 mb-16 animate-slide-up delay-300">
                <a href="#contacto" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-slate-950 font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                    <?php echo $cta_primary; ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#portfolio" class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                    <?php echo $cta_secondary; ?>
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 max-w-2xl animate-slide-up delay-400">
                <div>
                    <span class="font-display font-bold text-4xl md:text-5xl text-brand-500 block">17</span>
                    <span class="text-slate-400 text-sm mt-1 block"><?php echo $stat_years_label; ?></span>
                </div>
                <div>
                    <span class="font-display font-bold text-4xl md:text-5xl text-brand-500 block">+X</span>
                    <span class="text-slate-400 text-sm mt-1 block"><?php echo $stat_projects_label; ?></span>
                </div>
                <div>
                    <span class="font-display font-bold text-4xl md:text-5xl text-brand-500 block">3</span>
                    <span class="text-slate-400 text-sm mt-1 block"><?php echo $stat_provinces_label; ?></span>
                </div>
            </div>
        </div>
    </div>
</section>
