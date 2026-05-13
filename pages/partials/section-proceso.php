<?php
/**
 * Sección Proceso (4 Pasos) — com ícones Heroicons premium
 * "Tu proyecto, paso a paso"
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Saps exactament on estàs en tot moment' : 'Sabes exactamente dónde estás en cada momento';
$subtitle = $lang === 'ca'
    ? 'Sense sorpreses, sense costos ocults. Cada fase documentada per escrit.'
    : 'Sin sorpresas, sin costos ocultos. Cada fase documentada por escrito.';

// Heroicons outline 24px
$icon_visita = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>';

$icon_presupuesto = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>';

$icon_ejecucion = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm2.25-2.25h.008v.008h-.008V10.5Z"/></svg>';

$icon_entrega = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/></svg>';

$steps = $lang === 'ca' ? [
    [
        'num' => '01',
        'title' => 'Visita tècnica gratuïta',
        'desc' => 'Avaluem l\'estat actual, prenem mesures i detectem problemes estructurals abans de pressupostar. Sense compromís.',
        'icon' => $icon_visita,
    ],
    [
        'num' => '02',
        'title' => 'Pressupost tancat per escrit',
        'desc' => 'Abast detallat, fases, materials, terminis i condicions de pagament. Tot per escrit. Sense sorpreses.',
        'icon' => $icon_presupuesto,
    ],
    [
        'num' => '03',
        'title' => 'Execució amb seguiment',
        'desc' => 'Fotos setmanals de l\'obra, informes d\'avanç i Paulo al front de cada detall. Sempre informat.',
        'icon' => $icon_ejecucion,
    ],
    [
        'num' => '04',
        'title' => 'Lliurament i garantia',
        'desc' => 'Revisió final conjunta, documentació completa i 2 anys de garantia d\'execució. Si alguna cosa no està bé, ho arreglem.',
        'icon' => $icon_entrega,
    ],
] : [
    [
        'num' => '01',
        'title' => 'Visita técnica gratuita',
        'desc' => 'Evaluamos el estado actual, tomamos medidas y detectamos problemas estructurales antes de presupuestar. Sin compromiso.',
        'icon' => $icon_visita,
    ],
    [
        'num' => '02',
        'title' => 'Presupuesto cerrado por escrito',
        'desc' => 'Alcance detallado, fases, materiales, plazos y condiciones de pago. Todo por escrito. Sin sorpresas.',
        'icon' => $icon_presupuesto,
    ],
    [
        'num' => '03',
        'title' => 'Ejecución con seguimiento',
        'desc' => 'Fotos semanales de la obra, reportes de avance y Paulo al frente de cada detalle. Siempre informado.',
        'icon' => $icon_ejecucion,
    ],
    [
        'num' => '04',
        'title' => 'Entrega y garantía',
        'desc' => 'Revisión final conjunta, documentación completa y 2 años de garantía de ejecución. Si algo no está bien, lo arreglamos.',
        'icon' => $icon_entrega,
    ],
];
?>

<section data-reveal class="py-24 md:py-32 bg-slate-950 border-b border-slate-800" id="proceso">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'Procés' : 'Proceso'; ?></span>
                <div class="industrial-line industrial-line-reverse w-12"></div>
            </div>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-4"><?php echo $title; ?></h2>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto"><?php echo $subtitle; ?></p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($steps as $i => $step): ?>
            <div class="relative bg-slate-900 border border-slate-800 p-8 rounded-sm group hover:border-brand-700/50 transition-all duration-300 hover:-translate-y-1">
                <!-- Linha conectora (desktop) -->
                <?php if ($i < count($steps) - 1): ?>
                <div class="hidden lg:block absolute top-12 -right-3 w-6 h-px bg-slate-700 group-hover:bg-brand-900/50 transition-colors"></div>
                <?php endif; ?>
                
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-brand-900/40 rounded-sm flex items-center justify-center text-brand-500">
                        <?php echo $step['icon']; ?>
                    </div>
                    <span class="font-display font-bold text-3xl text-slate-700 group-hover:text-brand-900/40 transition-colors"><?php echo $step['num']; ?></span>
                </div>
                <h3 class="font-display font-bold text-xl text-white mb-3"><?php echo $step['title']; ?></h3>
                <p class="text-slate-400 text-sm leading-relaxed"><?php echo $step['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Garantía destacada -->
        <div class="mt-12 text-center">
            <div class="inline-flex items-center gap-3 bg-slate-900 border border-slate-800 rounded-sm px-6 py-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-500"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                <span class="text-slate-300 text-sm"><?php echo $lang === 'ca' ? 'Segur de responsabilitat civil · Llicències incloses · Garantia de 2 anys' : 'Seguro de responsabilidad civil · Licencias incluidas · Garantía de 2 años'; ?></span>
            </div>
        </div>
    </div>
</section>
