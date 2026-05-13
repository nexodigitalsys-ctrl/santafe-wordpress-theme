<?php
/**
 * Sección Dores → Soluciones
 * "¿Cuánto cuesta una obra mal dirigida?"
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Quant costa una obra mal dirigida?' : '¿Cuánto cuesta una obra mal dirigida?';
$subtitle = $lang === 'ca'
    ? 'Més que diners. Costa temps, nervis i confiança.'
    : 'Más que dinero. Cuesta tiempo, nervios y confianza.';

$soluciones = $lang === 'ca' ? [
    'Pressupost tancat amb abast per escrit',
    'Paulo a cada obra, no delegat a tercers',
    'Gremis coordinats amb pla d\'obra documentat',
    'Llicències gestionades des del dia u',
    'Seguiment setmanal amb fotos i informes',
] : [
    'Presupuesto cerrado con alcance por escrito',
    'Paulo en cada obra, no delegado a terceros',
    'Gremios coordinados con plan de obra documentado',
    'Licencias gestionadas desde el día uno',
    'Seguimiento semanal con fotos y reportes',
];

$cta = $lang === 'ca' ? 'Evitar aquests problemes →' : 'Evitar estos problemas →';
?>

<section data-reveal class="py-24 md:py-32 bg-slate-950 border-b border-slate-800" id="dores-solucoes">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-[0.8fr_1.2fr] gap-12 items-start">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'Control de risc' : 'Control de riesgo'; ?></span>
                </div>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-white tracking-tight mb-5"><?php echo $title; ?></h2>
                <p class="text-slate-400 leading-relaxed"><?php echo $subtitle; ?></p>
            </div>

            <div class="space-y-4">
                <?php foreach ($soluciones as $sol): ?>
                <div class="flex items-center gap-4 bg-slate-900 border border-slate-800 p-5 rounded-sm">
                    <div class="w-8 h-8 bg-brand-900/50 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#AE232A" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <span class="text-slate-200 font-medium"><?php echo $sol; ?></span>
                </div>
                <?php endforeach; ?>

                <a href="#contacto" class="inline-flex items-center gap-2 text-brand-500 font-semibold hover:text-brand-400 transition-colors mt-4">
                    <?php echo $cta; ?>
                </a>
            </div>
        </div>
    </div>
</section>
