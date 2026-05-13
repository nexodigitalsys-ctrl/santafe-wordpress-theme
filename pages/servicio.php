<?php
declare(strict_types=1);
/**
 * Template de Landing de Servicio Individual — Tailwind CSS
 */

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$route = isset($current_route) ? $current_route : (isset($_GET['route']) ? preg_replace('/[^a-z0-9\-\/]/', '', $_GET['route']) : '');

require_once __DIR__ . '/../includes/i18n.php';
require_once __DIR__ . '/../includes/schema-services.php';

$translations = load_translations($lang);

$service_map = [
    'es' => ['servicios/obra-nueva'=>'obra-nueva','servicios/reformas-integrales'=>'reformas-integrales','servicios/pladur-acabados'=>'pladur-acabados','servicios/obra-publica'=>'obra-publica','servicios/obra-civil'=>'obra-civil','obra-nueva'=>'obra-nueva','reformas-integrales'=>'reformas-integrales','pladur-acabados'=>'pladur-acabados','obra-publica'=>'obra-publica','obra-civil'=>'obra-civil'],
    'ca' => ['serveis/obra-nova'=>'obra-nueva','serveis/reformes-integrals'=>'reformas-integrales','serveis/pladur-acabats'=>'pladur-acabados','serveis/obra-publica'=>'obra-publica','serveis/obra-civil'=>'obra-civil','obra-nova'=>'obra-nueva','reformes-integrals'=>'reformas-integrales','pladur-acabats'=>'pladur-acabados','obra-publica'=>'obra-publica','obra-civil'=>'obra-civil']
];

$service_slug = $service_map[$lang][$route] ?? 'obra-nueva';

// Datos PAS del servicio
$services_data = require __DIR__ . '/../config/services-data.php';
$data = $services_data[$service_slug][$lang] ?? $services_data['obra-nueva']['es'];

$breadcrumb_items = [
    ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $lang === 'ca' ? 'Serveis' : 'Servicios', 'url' => '/' . $lang . '/' . ($lang === 'ca' ? 'serveis' : 'servicios') . '/'],
    ['name' => $data['h1'], 'url' => '/' . $lang . '/' . $route . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $data['title'],
    'description' => $data['description'],
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . $route . '/',
    'schemas' => [
        function() use ($service_slug, $lang) { return get_schema_service($service_slug, $lang); },
        function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); },
        function() use ($data) { return get_schema_faq($data['faq'] ?? []); }
    ]
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-16 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <nav class="text-slate-500 text-sm mb-8" aria-label="Breadcrumb">
            <ol class="flex gap-2">
                <?php foreach ($breadcrumb_items as $i => $item): ?>
                <li>
                    <?php if ($i < count($breadcrumb_items) - 1): ?>
                    <a href="<?php echo $item['url']; ?>" class="hover:text-brand-400 transition-colors"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                    <span class="mx-2">/</span>
                    <?php else: ?>
                    <span aria-current="page" class="text-slate-300"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        
        <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight mb-6"><?php echo htmlspecialchars($data['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="text-slate-400 text-lg max-w-2xl"><?php echo htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</section>

<!-- Price Guidance -->
<section class="py-20 bg-slate-950 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-[0.75fr_1.25fr] gap-10 items-start">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Precios orientativos</span>
                </div>
                <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight">Referencia antes de pedir presupuesto</h2>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-sm p-8">
                <p class="text-slate-300 text-lg leading-relaxed"><?php echo htmlspecialchars($data['prices'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="text-slate-500 text-sm mt-4">La cifra final depende de visita técnica, mediciones, estado actual, calidades, licencias y calendario.</p>
            </div>
        </div>
    </div>
</section>

<!-- PAS Section -->
<section class="py-24 bg-slate-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-4xl mx-auto space-y-16">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'El problema' : 'El problema'; ?></span>
                </div>
                <h2 class="font-display font-bold text-2xl md:text-3xl text-white mb-4"><?php echo $lang === 'ca' ? 'El que molts no et diuen' : 'Lo que muchos no te dicen'; ?></h2>
                <p class="text-slate-300 text-lg leading-relaxed"><?php echo $data['problem']; ?></p>
            </div>
            <div class="bg-slate-950 border border-slate-800 rounded-sm p-8 md:p-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'I si no ho fas bé?' : '¿Y si no lo haces bien?'; ?></span>
                </div>
                <p class="text-slate-400 leading-relaxed"><?php echo $data['agitate']; ?></p>
            </div>
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'La nostra solució' : 'Nuestra solución'; ?></span>
                </div>
                <h2 class="font-display font-bold text-2xl md:text-3xl text-white mb-4"><?php echo $lang === 'ca' ? 'Com ho fem a Santa Fe' : 'Cómo lo hacemos en Santa Fe'; ?></h2>
                <p class="text-slate-300 text-lg leading-relaxed"><?php echo $data['solution']; ?></p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-24 bg-slate-950">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-10">Preguntas frecuentes</h2>
        <div class="space-y-4">
            <?php foreach ($data['faq'] as $item): ?>
            <details class="bg-slate-900 border border-slate-800 rounded-sm p-6">
                <summary class="cursor-pointer font-semibold text-white"><?php echo htmlspecialchars($item['q'], ENT_QUOTES, 'UTF-8'); ?></summary>
                <p class="text-slate-400 mt-4 leading-relaxed"><?php echo htmlspecialchars($item['a'], ENT_QUOTES, 'UTF-8'); ?></p>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-24 bg-slate-950 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-12">
            <?php echo $lang === 'ca' ? 'Què inclou el nostre servei?' : '¿Qué incluye nuestro servicio?'; ?>
        </h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($data['features'] as $feature): ?>
            <div class="flex items-start gap-4 bg-slate-900 border border-slate-800 rounded-sm p-6">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#AE232A" stroke-width="2.5" class="flex-shrink-0 mt-0.5"><polyline points="20 6 9 17 4 12"/></svg>
                <span class="text-slate-200 text-sm"><?php echo htmlspecialchars($feature, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Phases -->
<section class="py-24 bg-slate-900">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-12">
            <?php echo $lang === 'ca' ? 'Procés pas a pas' : 'Proceso paso a paso'; ?>
        </h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($data['phases'] as $i => $phase): ?>
            <div class="relative">
                <span class="font-display font-bold text-6xl text-slate-800 absolute -top-4 -left-2 select-none"><?php echo $i + 1; ?></span>
                <div class="relative bg-slate-950 border border-slate-800 rounded-sm p-6 pt-10">
                    <h3 class="font-display font-bold text-lg text-white mb-2"><?php echo htmlspecialchars($phase['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="text-slate-400 text-sm leading-relaxed"><?php echo htmlspecialchars($phase['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 bg-slate-950 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-6">
            <?php echo $lang === 'ca' ? 'Comencem el teu projecte?' : '¿Empezamos tu proyecto?'; ?>
        </h2>
        <p class="text-slate-400 mb-10 max-w-xl mx-auto">
            <?php echo $lang === 'ca' ? 'Els terminis d\'obra es reserven amb 3 setmanes d\'antelació. Consulta disponibilitat.' : 'Los plazos de obra se reservan con 3 semanas de antelación. Consulta disponibilidad.'; ?>
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo htmlspecialchars($data['cta_primary'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <a href="tel:+34665737547" class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo htmlspecialchars($data['cta_secondary'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
