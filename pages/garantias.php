<?php
/**
 * Página de Garantías — Detalle completo de coberturas, seguros y certificaciones
 * Inspiração: modelo Koncepto (transparencia legal como diferenciador)
 */

declare(strict_types=1);

$lang = $_GET['lang'] ?? 'es';
$isCa = $lang === 'ca';

// Traducciones
$t = [
    'page_title' => $isCa
        ? 'Garanties i Assegurances | Santa Fe Construcciones'
        : 'Garantías y Seguros | Santa Fe Construcciones',
    'page_desc' => $isCa
        ? 'Garantia decenal opcional, assegurança de responsabilitat civil, pressupost tancat per contracte i 2 anys de garantia. Transparència total.'
        : 'Garantía decenal opcional, seguro de responsabilidad civil, presupuesto cerrado por contrato y 2 años de garantía. Transparencia total.',
    'hero_title' => $isCa ? 'Garanties que avalen cada obra' : 'Garantías que avalan cada obra',
    'hero_subtitle' => $isCa
        ? 'No només construïm. Garantim. Contracte per escrit, assegurances actives i responsabilitat directa.'
        : 'No solo construimos. Garantizamos. Contrato por escrito, seguros activos y responsabilidad directa.',
    'hero_cta' => $isCa ? 'Solicitar pressupost amb garanties' : 'Solicitar presupuesto con garantías',

    'section_legal' => $isCa ? 'Cobertura legal' : 'Cobertura legal',
    'section_legal_desc' => $isCa
        ? 'Totes les nostres obres inclouen la protecció jurídica necessària perquè estiguis tranquil des del primer dia.'
        : 'Todas nuestras obras incluyen la protección jurídica necesaria para que estés tranquilo desde el primer día.',

    'section_garantias' => $isCa ? 'Garanties incloses' : 'Garantías incluidas',
    'section_garantias_desc' => $isCa
        ? 'Garantim la qualitat dels acabats i la solidesa estructural amb cobertures reals, no promeses genèriques.'
        : 'Garantizamos la calidad de los acabados y la solidez estructural con coberturas reales, no promesas genéricas.',

    'section_insurance' => $isCa ? 'Assegurances actives' : 'Seguros activos',
    'section_insurance_desc' => $isCa
        ? 'Comptem amb pòlisses de responsabilitat civil i accidents per protegir tant els clients com l\'equip de treball.'
        : 'Contamos con pólizas de responsabilidad civil y accidentes para proteger tanto a los clientes como al equipo de trabajo.',

    'section_contract' => $isCa ? 'El contracte' : 'El contrato',
    'contract_intro' => $isCa
        ? 'Cada obra comença amb un contracte per escrit on es detalla:'
        : 'Cada obra comienza con un contrato por escrito donde se detalla:',
    'contract_items' => $isCa ? [
        'Abast exacte de l\'obra (què es fa i què no)',
        'Materials específics i marques',
        'Calendari d\'execució amb fases',
        'Condicions de pagament vinculades a fites',
        'Garanties i temps de resposta',
        'Responsable directe de l\'obra',
    ] : [
        'Alcance exacto de la obra (qué se hace y qué no)',
        'Materiales específicos y marcas',
        'Calendario de ejecución con fases',
        'Condiciones de pago vinculadas a hitos',
        'Garantías y tiempos de respuesta',
        'Responsable directo de la obra',
    ],
    'contract_price' => $isCa
        ? 'El preu acordat és el preu final. Si sorgeix algun imprevist que no estigués previst, ho parlem abans de fer res.'
        : 'El precio acordado es el precio final. Si surge algún imprevisto que no estuviera previsto, lo hablamos antes de hacer nada.',

    'final_cta' => $isCa ? 'Solicitar pressupost tancat' : 'Solicitar presupuesto cerrado',
    'final_cta_sub' => $isCa
        ? 'Sense compromís. Visita tècnica gratuïta a Barcelona, Girona o Tarragona.'
        : 'Sin compromiso. Visita técnica gratuita en Barcelona, Girona o Tarragona.',
];

$garantias_detalle = $isCa ? [
    [
        'title' => '2 anys de garantia d\'execució',
        'desc' => 'Cobertura completa de defectes d\'execució: acabats, instal·lacions, impermeabilització i elements constructius.',
        'icon' => 'M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z',
    ],
    [
        'title' => 'Garantia decenal (opcional)',
        'desc' => 'Per a obres noves o rehabilitació integral, oferim la pòlissa decenal que cobreix la solidesa estructural durant 10 anys.',
        'icon' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 5h18',
    ],
    [
        'title' => 'Pressupost tancat per contracte',
        'desc' => 'El preu acordat per escrit és el preu final. Cap sorpresa ni cost ocult durant l\'execució.',
        'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
    ],
    [
        'title' => 'Resposta en 48h a incidències',
        'desc' => 'Si detectes qualsevol problema durant la garantia, respondem en menys de 48 hores i programem la reparació.',
        'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
    ],
] : [
    [
        'title' => '2 años de garantía de ejecución',
        'desc' => 'Cobertura completa de defectos de ejecución: acabados, instalaciones, impermeabilización y elementos constructivos.',
        'icon' => 'M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z',
    ],
    [
        'title' => 'Garantía decenal (opcional)',
        'desc' => 'Para obras nuevas o rehabilitación integral, ofrecemos la póliza decenal que cubre la solidez estructural durante 10 años.',
        'icon' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 5h18',
    ],
    [
        'title' => 'Presupuesto cerrado por contrato',
        'desc' => 'El precio acordado por escrito es el precio final. Ninguna sorpresa ni costo oculto durante la ejecución.',
        'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
    ],
    [
        'title' => 'Respuesta en 48h a incidencias',
        'desc' => 'Si detectas cualquier problema durante la garantía, respondemos en menos de 48 horas y programamos la reparación.',
        'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
    ],
];

$seguros = $isCa ? [
    ['name' => 'Responsabilitat Civil', 'desc' => 'Cobertura per danys a tercers durant l\'execució de l\'obra.', 'policy' => 'Pòlissa RC activa'],
    ['name' => 'Accidents laborals', 'desc' => 'Protecció de l\'equip de treball davant qualsevol accident.', 'policy' => 'Assegurança d\'accidents'],
    ['name' => 'Danys materials', 'desc' => 'Cobertura de materials i equipament durant el trasllat i execució.', 'policy' => 'Inclosa en RC'],
] : [
    ['name' => 'Responsabilidad Civil', 'desc' => 'Cobertura por daños a terceros durante la ejecución de la obra.', 'policy' => 'Póliza RC activa'],
    ['name' => 'Accidentes laborales', 'desc' => 'Protección del equipo de trabajo ante cualquier accidente.', 'policy' => 'Seguro de accidentes'],
    ['name' => 'Daños materiales', 'desc' => 'Cobertura de materiales y equipamiento durante el traslado y ejecución.', 'policy' => 'Incluida en RC'],
];

// SEO
$page_data = [
    'lang' => $lang,
    'title' => $t['page_title'],
    'description' => $t['page_desc'],
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/garantias/',
    'schemas' => [
        function() use ($lang) {
            $items = [
                ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
                ['name' => $lang === 'ca' ? 'Garanties' : 'Garantías', 'url' => '/' . $lang . '/garantias/'],
            ];
            return get_schema_breadcrumb($items);
        },
    ],
];

include __DIR__ . '/../includes/header.php';
?>

<!-- Breadcrumbs -->
<div class="max-w-7xl mx-auto px-6 pt-24">
    <?php echo renderBreadcrumb([
        ['name' => $isCa ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
        ['name' => $isCa ? 'Garanties' : 'Garantías', 'url' => '/' . $lang . '/garantias/'],
    ], $lang); ?>
</div>

<!-- Hero -->
<section class="relative py-20 md:py-28 bg-white border-b border-gray-200">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-px bg-brand-500/40"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <div class="flex items-center justify-center gap-4 mb-6">
            <div class="industrial-line w-12"></div>
            <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $isCa ? 'Garanties' : 'Garantías'; ?></span>
            <div class="industrial-line industrial-line-reverse w-12"></div>
        </div>
        <h1 class="font-display font-bold text-4xl md:text-6xl text-white tracking-tight mb-6"><?php echo $t['hero_title']; ?></h1>
        <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed"><?php echo $t['hero_subtitle']; ?></p>
        <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
            <?php echo $t['hero_cta']; ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>

<!-- Cobertura legal -->
<section class="py-24 md:py-32 bg-gray-50 border-b border-gray-200" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="font-display font-bold text-3xl md:text-4xl text-gray-900 tracking-tight mb-4"><?php echo $t['section_legal']; ?></h2>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto"><?php echo $t['section_legal_desc']; ?></p>
        </div>

        <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-sm p-8 md:p-12">
            <h3 class="text-gray-900 font-semibold mb-6 text-lg"><?php echo $t['contract_intro']; ?></h3>
            <ul class="space-y-4 mb-8">
                <?php foreach ($t['contract_items'] as $item): ?>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-brand-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-gray-600"><?php echo $item; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="border-t border-gray-200 pt-6">
                <p class="text-brand-400 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                    <?php echo $t['contract_price']; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Garantías detalladas -->
<section class="py-24 md:py-32 bg-white border-b border-gray-200" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="font-display font-bold text-3xl md:text-4xl text-gray-900 tracking-tight mb-4"><?php echo $t['section_garantias']; ?></h2>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto"><?php echo $t['section_garantias_desc']; ?></p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($garantias_detalle as $g): ?>
            <div class="bg-gray-50 border border-gray-200 p-8 rounded-sm flex gap-5">
                <div class="w-12 h-12 bg-brand-900/30 rounded-sm flex items-center justify-center text-brand-500 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="<?php echo $g['icon']; ?>"/></svg>
                </div>
                <div>
                    <h3 class="font-display font-bold text-lg text-gray-900 mb-2"><?php echo $g['title']; ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo $g['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Seguros -->
<section class="py-24 md:py-32 bg-gray-50 border-b border-gray-200" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="font-display font-bold text-3xl md:text-4xl text-gray-900 tracking-tight mb-4"><?php echo $t['section_insurance']; ?></h2>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto"><?php echo $t['section_insurance_desc']; ?></p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($seguros as $s): ?>
            <div class="bg-white border border-gray-200 p-8 rounded-sm text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold tracking-wider uppercase rounded-full border border-emerald-500/20 mb-4">
                    <?php echo $s['policy']; ?>
                </div>
                <h3 class="font-display font-bold text-xl text-gray-900 mb-3"><?php echo $s['name']; ?></h3>
                <p class="text-gray-500 text-sm"><?php echo $s['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/section-google-reviews.php'; ?>

<!-- CTA Final -->
<section class="py-24 md:py-32 bg-white" data-reveal>
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="font-display font-bold text-3xl md:text-5xl text-gray-900 tracking-tight mb-6"><?php echo $t['final_cta']; ?></h2>
        <p class="text-gray-500 text-lg mb-10"><?php echo $t['final_cta_sub']; ?></p>
        <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-10 py-5 rounded-sm transition-all tracking-wide text-base uppercase shadow-lg">
            <?php echo $t['hero_cta']; ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
