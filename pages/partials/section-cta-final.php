<?php
/**
 * Sección CTA Final (simplificada)
 * Usada como cierre antes del footer en páginas internas
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Parlem del teu projecte' : 'Hablemos de tu proyecto';
$subtitle = $lang === 'ca'
    ? 'Sense compromís. Et direm el següent pas amb criteri tècnic.'
    : 'Sin compromiso. Te diremos el siguiente paso con criterio técnico.';
$cta = $lang === 'ca' ? 'Sol·licitar visita tècnica' : 'Solicitar visita técnica';
$cta_phone = $lang === 'ca' ? 'Trucar ara' : 'Llamar ahora';
?>

<section class="py-24 md:py-32 bg-slate-950 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-6"><?php echo $title; ?></h2>
        <p class="text-slate-300 text-lg leading-relaxed mb-10 max-w-2xl mx-auto"><?php echo $subtitle; ?></p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo $cta; ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="tel:<?php echo COMPANY_PHONE; ?>" class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo $cta_phone; ?>
            </a>
        </div>
    </div>
</section>
