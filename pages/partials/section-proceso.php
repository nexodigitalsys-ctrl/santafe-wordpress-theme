<?php
/**
 * Sección Proceso (4 Pasos)
 * "Tu proyecto, paso a paso"
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'El teu projecte, pas a pas' : 'Tu proyecto, paso a paso';

$steps = $lang === 'ca' ? [
    [
        'num' => '01',
        'title' => 'Visita tècnica',
        'desc' => 'Avaluem l\'estat actual, mesurem i detectem problemes abans de pressupostar.',
    ],
    [
        'num' => '02',
        'title' => 'Pressupost tancat',
        'desc' => 'Abast, fases, materials i terminis per escrit. Sense sorpreses.',
    ],
    [
        'num' => '03',
        'title' => 'Execució amb seguiment',
        'desc' => 'Fotos setmanals, informes d\'avanç i Paulo a cada obra.',
    ],
    [
        'num' => '04',
        'title' => 'Lliurament i garantia',
        'desc' => 'Revisió final conjunta, documentació completa i garantia d\'execució.',
    ],
] : [
    [
        'num' => '01',
        'title' => 'Visita técnica',
        'desc' => 'Evaluamos el estado actual, medimos y detectamos problemas antes de presupuestar.',
    ],
    [
        'num' => '02',
        'title' => 'Presupuesto cerrado',
        'desc' => 'Alcance, fases, materiales y plazos por escrito. Sin sorpresas.',
    ],
    [
        'num' => '03',
        'title' => 'Ejecución con seguimiento',
        'desc' => 'Fotos semanales, reportes de avance y Paulo en cada obra.',
    ],
    [
        'num' => '04',
        'title' => 'Entrega y garantía',
        'desc' => 'Revisión final conjunta, documentación completa y garantía de ejecución.',
    ],
];
?>

<section class="py-24 md:py-32 bg-slate-950 border-b border-slate-800" id="proceso">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'Procés' : 'Proceso'; ?></span>
                <div class="industrial-line industrial-line-reverse w-12"></div>
            </div>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight"><?php echo $title; ?></h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($steps as $step): ?>
            <div class="relative bg-slate-900 border border-slate-800 p-8 rounded-sm group hover:border-brand-700/50 transition-colors">
                <span class="font-display font-bold text-5xl text-slate-800 absolute top-4 right-4 group-hover:text-brand-900/30 transition-colors"><?php echo $step['num']; ?></span>
                <div class="relative z-10">
                    <h3 class="font-display font-bold text-xl text-white mb-3"><?php echo $step['title']; ?></h3>
                    <p class="text-slate-400 text-sm leading-relaxed"><?php echo $step['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
