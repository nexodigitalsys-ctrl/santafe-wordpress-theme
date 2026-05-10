<?php
/**
 * SEO local landing template
 * Barcelona, Girona, Tarragona
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : 'es';
$route = isset($current_route) ? $current_route : '';
$translations = load_translations($lang);

$is_ca = $lang === 'ca';

$landing_map = [
    'reformas-barcelona' => ['service' => $is_ca ? 'Reformes integrals' : 'Reformas integrales', 'city' => 'Barcelona', 'rate' => '450-900 €/m²', 'intent' => $is_ca ? 'reformar pisos, locals i habitatges amb control de gremis i pressupost per partides' : 'reformar pisos, locales y viviendas con control de gremios y presupuesto por partidas'],
    'reformas-girona' => ['service' => $is_ca ? 'Reformes integrals' : 'Reformas integrales', 'city' => 'Girona', 'rate' => '420-850 €/m²', 'intent' => $is_ca ? 'reformar habitatges i espais comercials amb planificació tècnica' : 'reformar viviendas y espacios comerciales con planificación técnica'],
    'reformas-tarragona' => ['service' => $is_ca ? 'Reformes integrals' : 'Reformas integrales', 'city' => 'Tarragona', 'rate' => '420-850 €/m²', 'intent' => $is_ca ? 'coordinar reformes amb abast clar i seguiment directe' : 'coordinar reformas con alcance claro y seguimiento directo'],
    'obra-nueva-barcelona' => ['service' => $is_ca ? 'Obra nova' : 'Obra nueva', 'city' => 'Barcelona', 'rate' => $is_ca ? 'segons projecte i mesuraments' : 'según proyecto y mediciones', 'intent' => $is_ca ? 'executar habitatges i edificacions des de la planificació fins al lliurament' : 'ejecutar viviendas y edificaciones desde la planificación hasta la entrega'],
    'obra-nueva-girona' => ['service' => $is_ca ? 'Obra nova' : 'Obra nueva', 'city' => 'Girona', 'rate' => $is_ca ? 'segons projecte i mesuraments' : 'según proyecto y mediciones', 'intent' => $is_ca ? 'construir obra nova amb coordinació tècnica i control de fases' : 'construir obra nueva con coordinación técnica y control de fases'],
    'obra-nueva-tarragona' => ['service' => $is_ca ? 'Obra nova' : 'Obra nueva', 'city' => 'Tarragona', 'rate' => $is_ca ? 'segons projecte i mesuraments' : 'según proyecto y mediciones', 'intent' => $is_ca ? 'construir obra nova amb coordinació tècnica i control de fases' : 'construir obra nueva con coordinación técnica y control de fases'],
    'reformas-integrales-barcelona' => ['service' => $is_ca ? 'Reformes integrals' : 'Reformas integrales', 'city' => 'Barcelona', 'rate' => '450-900 €/m²', 'intent' => $is_ca ? 'transformar habitatges completes sense improvisar terminis ni costos' : 'transformar viviendas completas sin improvisar plazos ni costes'],
    'reformas-integrales-girona' => ['service' => $is_ca ? 'Reformes integrals' : 'Reformas integrales', 'city' => 'Girona', 'rate' => '420-850 €/m²', 'intent' => $is_ca ? 'renovar espais complets amb gremis coordinats' : 'renovar espacios completos con gremios coordinados'],
    'reformas-integrales-tarragona' => ['service' => $is_ca ? 'Reformes integrals' : 'Reformas integrales', 'city' => 'Tarragona', 'rate' => '420-850 €/m²', 'intent' => $is_ca ? 'renovar espais complets amb gremis coordinats' : 'renovar espacios completos con gremios coordinados'],
    'pladur-barcelona' => ['service' => $is_ca ? 'Pladur i acabats' : 'Pladur y acabados', 'city' => 'Barcelona', 'rate' => '35-75 €/m²', 'intent' => $is_ca ? 'resoldre sostres, tàbiques, aïllament i acabats interiors' : 'resolver techos, tabiques, aislamiento y acabados interiores'],
    'pladur-girona' => ['service' => $is_ca ? 'Pladur i acabats' : 'Pladur y acabados', 'city' => 'Girona', 'rate' => '35-75 €/m²', 'intent' => $is_ca ? 'executar sistemes de pladur amb acabat net i criteri tècnic' : 'ejecutar sistemas de pladur con acabado limpio y criterio técnico'],
    'pladur-tarragona' => ['service' => $is_ca ? 'Pladur i acabats' : 'Pladur y acabados', 'city' => 'Tarragona', 'rate' => '35-75 €/m²', 'intent' => $is_ca ? 'executar sistemes de pladur amb acabat net i criteri tècnic' : 'ejecutar sistemas de pladur con acabado limpio y criterio técnico'],
];

$data = $landing_map[$route] ?? $landing_map['reformas-barcelona'];
$h1 = $data['service'] . ' en ' . $data['city'] . ' | Santa Fe Construcciones';
$breadcrumb_items = [
    ['name' => $is_ca ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $h1, 'url' => '/' . $lang . '/' . $route . '/'],
];

$faq_visit = $is_ca ? 'Feu visita tècnica a ' . $data['city'] . '?' : '¿Hacéis visita técnica en ' . $data['city'] . '?';
$faq_price = $is_ca ? 'El preu és tancat?' : '¿El precio es cerrado?';
$faq_when = $is_ca ? 'Quan rebo una primera orientació?' : '¿Cuándo recibo una primera orientación?';
$faq_who = $is_ca ? 'Traballeu amb comunitats o empreses?' : '¿Trabajáis con comunidades o empresas?';

$faqs = [
    ['q' => $faq_visit, 'a' => $is_ca ? 'Sí. La visita permet revisar abast, estat actual, mesuraments i condicionants abans de tancar una proposta.' : 'Sí. La visita permite revisar alcance, estado actual, mediciones y condicionantes antes de cerrar una propuesta.'],
    ['q' => $faq_price, 'a' => $is_ca ? 'Traballem amb pressupost per partides. Els canvis es documenten i validen abans d\'executar-se.' : 'Trabajamos con presupuesto por partidas. Los cambios se documentan y validan antes de ejecutarse.'],
    ['q' => $faq_when, 'a' => $is_ca ? 'Després de rebre dades bàsiques s\'orienta el següent pas. La xifra fiable requereix revisió tècnica.' : 'Tras recibir datos básicos se orienta el siguiente paso. La cifra fiable requiere revisión técnica.'],
    ['q' => $faq_who, 'a' => $is_ca ? 'Sí, a més de particulars, donem servei a empreses, locals, comunitats i projectes tècnics.' : 'Sí, además de particulares, damos servicio a empresas, locales, comunidades y proyectos técnicos.'],
];

$page_data = [
    'lang' => $lang,
    'title' => $h1,
    'description' => $data['service'] . ' en ' . $data['city'] . ($is_ca ? ' amb pressupost clar, visita tècnica i seguiment directe. Santa Fe Construcciones.' : ' con presupuesto claro, visita técnica y seguimiento directo. Santa Fe Construcciones.'),
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . $route . '/',
    'schemas' => [
        function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); },
        function() use ($faqs) { return get_schema_faq($faqs); },
    ],
];

include __DIR__ . '/../includes/header.php';

$cta_budget = $is_ca ? 'Sol·licitar pressupost' : 'Solicitar presupuesto';
$cta_call = $is_ca ? 'Trucar: ' : 'Llamar: ';
$price_title = $is_ca ? 'Preu orientatiu' : 'Precio orientativo';
$process_title = $is_ca ? 'Procés clar' : 'Proceso claro';
$zone_title = $is_ca ? 'Zona coberta' : 'Zona cubierta';
$faq_title = $is_ca ? 'Preguntes freqüents' : 'Preguntas frecuentes';
?>

<section class="pt-40 pb-20 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-4xl">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">SEO local</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-6xl text-white tracking-tight mb-6"><?php echo esc_html($h1); ?></h1>
            <p class="text-slate-300 text-lg md:text-xl leading-relaxed max-w-3xl"><?php echo $is_ca ? 'Ajudem clients a ' : 'Ayudamos a clientes en '; ?><?php echo esc_html($data['city']); ?><?php echo $is_ca ? ' a ' : ' a '; ?><?php echo esc_html($data['intent']); ?>, <?php echo $is_ca ? 'amb planificació prèvia, pressupost clar i comunicació directa durant l\'obra.' : 'con planificación previa, presupuesto claro y comunicación directa durante la obra.'; ?></p>
            <div class="flex flex-wrap gap-4 mt-10">
                <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase"><?php echo $cta_budget; ?></a>
                <a href="tel:<?php echo COMPANY_PHONE; ?>" class="inline-flex items-center border border-slate-600 hover:border-brand-500 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase" data-track-event="phone_click"><?php echo $cta_call . COMPANY_PHONE_DISPLAY; ?></a>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-900 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-6">
        <article class="bg-slate-950 border border-slate-800 p-7 rounded-sm">
            <h2 class="font-display font-bold text-2xl text-white mb-3"><?php echo $price_title; ?></h2>
            <p class="text-slate-400"><?php echo $is_ca ? 'Referència inicial: ' : 'Referencia inicial: '; ?><?php echo esc_html($data['rate']); ?>. <?php echo $is_ca ? 'La xifra final depèn de mesuraments, qualitats, llicències i estat inicial.' : 'La cifra final depende de mediciones, calidades, licencias y estado inicial.'; ?></p>
        </article>
        <article class="bg-slate-950 border border-slate-800 p-7 rounded-sm">
            <h2 class="font-display font-bold text-2xl text-white mb-3"><?php echo $process_title; ?></h2>
            <p class="text-slate-400"><?php echo $is_ca ? 'Primer visita i abast. Després partides, calendari i fases. Durant l\'obra, decisions documentades.' : 'Primero visita y alcance. Después partidas, calendario y fases. Durante la obra, decisiones documentadas.'; ?></p>
        </article>
        <article class="bg-slate-950 border border-slate-800 p-7 rounded-sm">
            <h2 class="font-display font-bold text-2xl text-white mb-3"><?php echo $zone_title; ?></h2>
            <p class="text-slate-400"><?php echo $is_ca ? 'Traballem a ' : 'Trabajamos en '; ?><?php echo esc_html($data['city']); ?><?php echo $is_ca ? ' i voltants, a més de Barcelona, Girona, Tarragona i altres zones de Catalunya.' : ' y alrededores, además de Barcelona, Girona, Tarragona y otras zonas de Cataluña.'; ?></p>
        </article>
    </div>
</section>

<section class="py-24 bg-slate-950">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-10"><?php echo $faq_title; ?></h2>
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
