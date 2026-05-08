<?php
/**
 * SEO local landing template for Spanish commercial pages.
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : 'es';
$route = isset($current_route) ? $current_route : '';
$translations = load_translations($lang);

$landing_map = [
    'reformas-barcelona' => ['service' => 'Reformas integrales', 'city' => 'Barcelona', 'rate' => '450-900 €/m²', 'intent' => 'reformar pisos, locales y viviendas con control de gremios y presupuesto por partidas'],
    'reformas-girona' => ['service' => 'Reformas integrales', 'city' => 'Girona', 'rate' => '420-850 €/m²', 'intent' => 'reformar viviendas y espacios comerciales con planificación técnica'],
    'reformas-tarragona' => ['service' => 'Reformas integrales', 'city' => 'Tarragona', 'rate' => '420-850 €/m²', 'intent' => 'coordinar reformas con alcance claro y seguimiento directo'],
    'obra-nueva-barcelona' => ['service' => 'Obra nueva', 'city' => 'Barcelona', 'rate' => 'según proyecto y mediciones', 'intent' => 'ejecutar viviendas y edificaciones desde la planificación hasta la entrega'],
    'obra-nueva-girona' => ['service' => 'Obra nueva', 'city' => 'Girona', 'rate' => 'según proyecto y mediciones', 'intent' => 'construir obra nueva con coordinación técnica y control de fases'],
    'reformas-integrales-barcelona' => ['service' => 'Reformas integrales', 'city' => 'Barcelona', 'rate' => '450-900 €/m²', 'intent' => 'transformar viviendas completas sin improvisar plazos ni costes'],
    'reformas-integrales-girona' => ['service' => 'Reformas integrales', 'city' => 'Girona', 'rate' => '420-850 €/m²', 'intent' => 'renovar espacios completos con gremios coordinados'],
    'pladur-barcelona' => ['service' => 'Pladur y acabados', 'city' => 'Barcelona', 'rate' => '35-75 €/m²', 'intent' => 'resolver techos, tabiques, aislamiento y acabados interiores'],
    'pladur-girona' => ['service' => 'Pladur y acabados', 'city' => 'Girona', 'rate' => '35-75 €/m²', 'intent' => 'ejecutar sistemas de pladur con acabado limpio y criterio técnico'],
];

$data = $landing_map[$route] ?? $landing_map['reformas-barcelona'];
$h1 = $data['service'] . ' en ' . $data['city'] . ' | Santa Fe Construcciones';
$breadcrumb_items = [
    ['name' => 'Inicio', 'url' => '/es/'],
    ['name' => $h1, 'url' => '/es/' . $route . '/'],
];
$faqs = [
    ['q' => '¿Hacéis visita técnica en ' . $data['city'] . '?', 'a' => 'Sí. La visita permite revisar alcance, estado actual, mediciones y condicionantes antes de cerrar una propuesta.'],
    ['q' => '¿El precio es cerrado?', 'a' => 'Trabajamos con presupuesto por partidas. Los cambios se documentan y validan antes de ejecutarse.'],
    ['q' => '¿Cuándo recibo una primera orientación?', 'a' => 'Tras recibir datos básicos se orienta el siguiente paso. La cifra fiable requiere revisión técnica.'],
    ['q' => '¿Trabajáis con comunidades o empresas?', 'a' => 'Sí, además de particulares, damos servicio a empresas, locales, comunidades y proyectos técnicos.'],
];

$page_data = [
    'lang' => 'es',
    'title' => $h1,
    'description' => $data['service'] . ' en ' . $data['city'] . ' con presupuesto claro, visita técnica y seguimiento directo. Santa Fe Construcciones.',
    'canonical' => COMPANY_DOMAIN . '/es/' . $route . '/',
    'schemas' => [
        function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); },
        function() use ($faqs) { return get_schema_faq($faqs); },
    ],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-20 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-4xl">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">SEO local</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-6xl text-white tracking-tight mb-6"><?php echo esc_html($h1); ?></h1>
            <p class="text-slate-300 text-lg md:text-xl leading-relaxed max-w-3xl">Ayudamos a clientes en <?php echo esc_html($data['city']); ?> a <?php echo esc_html($data['intent']); ?>, con planificación previa, presupuesto claro y comunicación directa durante la obra.</p>
            <div class="flex flex-wrap gap-4 mt-10">
                <a href="/es/contacto/" class="inline-flex items-center bg-brand-600 hover:bg-brand-500 text-slate-950 font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">Solicitar presupuesto</a>
                <a href="tel:<?php echo COMPANY_PHONE; ?>" class="inline-flex items-center border border-slate-600 hover:border-brand-500 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase" data-track-event="phone_click">Llamar: <?php echo COMPANY_PHONE_DISPLAY; ?></a>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-900 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-6">
        <article class="bg-slate-950 border border-slate-800 p-7 rounded-sm">
            <h2 class="font-display font-bold text-2xl text-white mb-3">Precio orientativo</h2>
            <p class="text-slate-400">Referencia inicial: <?php echo esc_html($data['rate']); ?>. La cifra final depende de mediciones, calidades, licencias y estado inicial.</p>
        </article>
        <article class="bg-slate-950 border border-slate-800 p-7 rounded-sm">
            <h2 class="font-display font-bold text-2xl text-white mb-3">Proceso claro</h2>
            <p class="text-slate-400">Primero visita y alcance. Después partidas, calendario y fases. Durante la obra, decisiones documentadas.</p>
        </article>
        <article class="bg-slate-950 border border-slate-800 p-7 rounded-sm">
            <h2 class="font-display font-bold text-2xl text-white mb-3">Zona cubierta</h2>
            <p class="text-slate-400">Trabajamos en <?php echo esc_html($data['city']); ?> y alrededores, además de Barcelona, Girona, Tarragona y otras zonas de Cataluña.</p>
        </article>
    </div>
</section>

<section class="py-24 bg-slate-950">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-10">Preguntas frecuentes</h2>
        <div class="space-y-4">
            <?php foreach ($faqs as $faq): ?>
            <details class="bg-slate-900 border border-slate-800 rounded-sm p-6">
                <summary class="cursor-pointer font-semibold text-white"><?php echo esc_html($faq['q']); ?></summary>
                <p class="text-slate-400 mt-4 leading-relaxed"><?php echo esc_html($faq['a']); ?></p>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
