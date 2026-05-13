<?php
/**
 * Servicios (Landing general) — Extraordinária
 * Conecta 5 páginas de serviço individuais com guia, proceso y FAQ
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$isCa = $lang === 'ca';
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $isCa ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $isCa ? 'Serveis' : 'Servicios', 'url' => '/' . $lang . '/' . ($isCa ? 'serveis' : 'servicios') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $isCa ? 'Serveis de construcció a Barcelona i Girona | Santa Fe' : 'Servicios de construcción en Barcelona y Girona | Santa Fe',
    'description' => $isCa ? 'Obra nova, reformes, pladur, obra pública i civil. Pressupost tancat, coordinació de gremis i seguiment directe.' : 'Obra nueva, reformas, pladur, obra pública y civil. Presupuesto cerrado, coordinación de gremios y seguimiento directo.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . ($isCa ? 'serveis' : 'servicios') . '/',
    'schemas' => [
        function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }
    ],
];

$theme_uri = get_template_directory_uri();

// ── Slugs por idioma ──────────────────────────────────────────────
$slugs = [
    'obra-nueva' => $isCa ? 'obra-nova' : 'obra-nueva',
    'reformas-integrales' => $isCa ? 'reformes-integrals' : 'reformas-integrales',
    'pladur-acabados' => $isCa ? 'pladur-acabats' : 'pladur-acabados',
    'obra-publica' => 'obra-publica',
    'obra-civil' => 'obra-civil',
];

// ── Textos do template ────────────────────────────────────────────
$t = [
    'hero_h1' => $isCa ? 'Serveis de construcció<br>integral' : 'Servicios de construcción<br>integral',
    'hero_p' => $isCa ? 'Cinc àrees d\'actuació per cobrir totes les teves necessitats. Des de la primera pedra fins a l\'últim detall.' : 'Cinco áreas de actuación para cubrir todas tus necesidades. Desde la primera piedra hasta el último detalle.',
    'hero_cta_whatsapp' => $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h',
    'hero_cta_budget' => $isCa ? 'Solicitar pressupost' : 'Solicitar presupuesto',
    'hero_cta_call' => $isCa ? 'Trucar ara' : 'Llamar ahora',

    'services_label' => $isCa ? 'ELS NOSTRES SERVEIS' : 'NUESTROS SERVICIOS',
    'services_h2' => $isCa ? 'Què necessites?' : '¿Qué necesitas?',

    'guide_label' => $isCa ? 'GUIA RÀPIDA' : 'GUÍA RÁPIDA',
    'guide_h2' => $isCa ? 'Com triar el servei adequat' : 'Cómo elegir el servicio adecuado',
    'guide_col_need' => $isCa ? 'Si necessites...' : 'Si necesitas...',
    'guide_col_service' => $isCa ? 'El servei és...' : 'El servicio es...',
    'guide_col_price' => $isCa ? 'Preu orientatiu' : 'Precio orientativo',

    'process_label' => $isCa ? 'COM TREBALLEM' : 'CÓMO TRABAJAMOS',
    'process_h2' => $isCa ? 'De la visita a l\'entrega en 5 passos' : 'De la visita a la entrega en 5 pasos',

    'diff_label' => $isCa ? 'PER QUÈ SANTA FE' : 'POR QUÉ SANTA FE',
    'diff_h2' => $isCa ? 'El que ens diferencia' : 'Lo que nos diferencia',

    'faq_label' => $isCa ? 'PREGUNTES FREQÜENTS' : 'PREGUNTAS FRECUENTES',
    'faq_h2' => $isCa ? 'El que ens pregunten' : 'Lo que nos preguntan',

    'final_h2' => $isCa ? 'Vols saber quant costaria el teu projecte?' : '¿Quieres saber cuánto costaría tu proyecto?',
    'final_p' => $isCa
        ? 'La primera visita és gratuïta i sense compromís. Paulo revisarà l\'obra i prepararà un pressupost tancat en 48 hores.'
        : 'La primera visita es gratuita y sin compromiso. Paulo revisará la obra y preparará un presupuesto cerrado en 48 horas.',
    'final_cta_form' => $isCa ? 'Omplir formulari' : 'Rellenar formulario',
    'final_cta_wa' => $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h',
];

// ── Serviços com dados completos ──────────────────────────────────
$services = [
    [
        'slug' => 'obra-nueva',
        'title' => $isCa ? 'Obra nova' : 'Obra nueva',
        'desc' => $isCa ? 'Vivendes i edificacions des de zero amb planificació tècnica i control de costos.' : 'Viviendas y edificaciones desde cero con planificación técnica y control de costes.',
        'features' => $isCa ? ['Llicències', 'Estructura', 'Instal·lacions', 'Acabats'] : ['Licencias', 'Estructura', 'Instalaciones', 'Acabados'],
        'price' => $isCa ? 'Des de 800 €/m²' : 'Desde 800 €/m²',
        'img' => $theme_uri . '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp',
    ],
    [
        'slug' => 'reformas-integrales',
        'title' => $isCa ? 'Reformes integrals' : 'Reformas integrales',
        'desc' => $isCa ? 'Transformació completa de pisos, locals i oficines amb presupost tancat.' : 'Transformación completa de pisos, locales y oficinas con presupuesto cerrado.',
        'features' => $isCa ? ['Albañileria', 'Cuina i bany', 'Instal·lacions', 'Acabats'] : ['Albañilería', 'Cocina y baño', 'Instalaciones', 'Acabados'],
        'price' => $isCa ? 'Des de 450 €/m²' : 'Desde 450 €/m²',
        'img' => $theme_uri . '/assets/images/servicios/reformas/reforma-recepcion-acabada.webp',
    ],
    [
        'slug' => 'pladur-acabados',
        'title' => $isCa ? 'Pladur i acabats' : 'Pladur y acabados',
        'desc' => $isCa ? 'Tabiques, sostres, trasdosats i acabats interiors amb criteri tècnic.' : 'Tabiques, techos, trasdosados y acabados interiores con criterio técnico.',
        'features' => $isCa ? ['Acústic', 'Tèrmic', 'Registrable', 'Il·luminació'] : ['Acústico', 'Térmico', 'Registrable', 'Iluminación'],
        'price' => $isCa ? 'Des de 35 €/m²' : 'Desde 35 €/m²',
        'img' => $theme_uri . '/assets/images/servicios/pladur/pladur-hall-acabado.webp',
    ],
    [
        'slug' => 'obra-publica',
        'title' => $isCa ? 'Obra pública' : 'Obra pública',
        'desc' => $isCa ? 'Pavimentació, aceres, mobiliari urbà i rehabilitació amb documentació completa.' : 'Pavimentación, aceras, mobiliario urbano y rehabilitación con documentación completa.',
        'features' => $isCa ? ['Documentació', 'Certificacions', 'Garantia', 'Trazabilitat'] : ['Documentación', 'Certificaciones', 'Garantía', 'Trazabilidad'],
        'price' => 'A convenir',
        'img' => $theme_uri . '/assets/images/servicios/obra-publica/obra-publica-calzada-acabada.webp',
    ],
    [
        'slug' => 'obra-civil',
        'title' => $isCa ? 'Obra civil' : 'Obra civil',
        'desc' => $isCa ? 'Cimentacions, murs, canalitzacions i preparació de terreny amb seguretat.' : 'Cimentaciones, muros, canalizaciones y preparación de terreno con seguridad.',
        'features' => $isCa ? ['Cimentacions', 'Murs', 'Drenatges', 'Seguretat'] : ['Cimentaciones', 'Muros', 'Drenajes', 'Seguridad'],
        'price' => 'A convenir',
        'img' => $theme_uri . '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp',
    ],
];

// ── Guia de comparação ────────────────────────────────────────────
$guide = [
    [
        'need' => $isCa ? 'Construir una casa o edifici des de zero' : 'Construir una casa o edificio desde cero',
        'service' => $isCa ? '<strong>Obra nova</strong>' : '<strong>Obra nueva</strong>',
        'price' => $isCa ? 'Des de 800 €/m²' : 'Desde 800 €/m²',
    ],
    [
        'need' => $isCa ? 'Reformar un pis o local completament' : 'Reformar un piso o local completamente',
        'service' => $isCa ? '<strong>Reformes integrals</strong>' : '<strong>Reformas integrales</strong>',
        'price' => $isCa ? 'Des de 450 €/m²' : 'Desde 450 €/m²',
    ],
    [
        'need' => $isCa ? 'Divisions interiors, sostres o aïllament' : 'Divisiones interiores, techos o aislamiento',
        'service' => $isCa ? '<strong>Pladur i acabats</strong>' : '<strong>Pladur y acabados</strong>',
        'price' => $isCa ? 'Des de 35 €/m²' : 'Desde 35 €/m²',
    ],
    [
        'need' => $isCa ? 'Obra per a administració o espai públic' : 'Obra para administración o espacio público',
        'service' => $isCa ? '<strong>Obra pública</strong>' : '<strong>Obra pública</strong>',
        'price' => 'A convenir',
    ],
    [
        'need' => $isCa ? 'Cimentacions, murs o preparació de terreny' : 'Cimentaciones, muros o preparación de terreno',
        'service' => $isCa ? '<strong>Obra civil</strong>' : '<strong>Obra civil</strong>',
        'price' => 'A convenir',
    ],
];

// ── Proceso general (5 passos) ────────────────────────────────────
$process = [
    ['num' => '01', 'title' => $isCa ? 'Contacte' : 'Contacto', 'desc' => $isCa ? 'Ens expliques el teu projecte per telèfon, WhatsApp o formulari.' : 'Nos cuentas tu proyecto por teléfono, WhatsApp o formulario.'],
    ['num' => '02', 'title' => $isCa ? 'Visita tècnica' : 'Visita técnica', 'desc' => $isCa ? 'Analitzem l\'obra, necessitats i possibles dificultats in situ.' : 'Analizamos la obra, necesidades y posibles dificultades in situ.'],
    ['num' => '03', 'title' => $isCa ? 'Pressupost tancat' : 'Presupuesto cerrado', 'desc' => $isCa ? 'Rebem pressupost per escrit amb partides, materials i calendari.' : 'Recibes presupuesto por escrito con partidas, materiales y calendario.'],
    ['num' => '04', 'title' => $isCa ? 'Execució' : 'Ejecución', 'desc' => $isCa ? 'Coordinem gremis, compres i decisions amb seguiment directe.' : 'Coordinamos gremios, compras y decisiones con seguimiento directo.'],
    ['num' => '05', 'title' => $isCa ? 'Entrega' : 'Entrega', 'desc' => $isCa ? 'Revisió final, neteja, documentació i garantia per escrit.' : 'Revisión final, limpieza, documentación y garantía por escrito.'],
];

// ── Diferenciadores ───────────────────────────────────────────────
$diffs = [
    ['icon' => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5', 'title' => $isCa ? 'Pressupost tancat' : 'Presupuesto cerrado', 'desc' => $isCa ? 'El preu que firmem és el que pagues. Cap extra ocult ni sorpreses d\'última hora.' : 'El precio que firmamos es el que pagas. Ningún extra oculto ni sorpresas de última hora.'],
    ['icon' => 'M22 11.08V12a10 10 0 1 1-5.93-9.14', 'title' => $isCa ? 'Seguiment directe' : 'Seguimiento directo', 'desc' => $isCa ? 'Paulo coordina personalment cada obra. No hi ha intermediaris ni informació que es perdi.' : 'Paulo coordina personalmente cada obra. No hay intermediarios ni información que se pierda.'],
    ['icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2', 'title' => $isCa ? 'Gremis coordinats' : 'Gremios coordinados', 'desc' => $isCa ? 'Albañileria, instal·ladors, fusters... tot sota una mateixa direcció d\'obra.' : 'Albañilería, instaladores, carpinteros... todo bajo una misma dirección de obra.'],
    ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', 'title' => $isCa ? 'Garantia de 2 anys' : 'Garantía de 2 años', 'desc' => $isCa ? 'Tota la nostra execució i acabats tenen garantia per escrit.' : 'Toda nuestra ejecución y acabados tienen garantía por escrito.'],
    ['icon' => 'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z', 'title' => $isCa ? 'Termini realista' : 'Plazo realista', 'desc' => $isCa ? 'No prometem el impossible. El calendari es defineix a la vista de l\'obra, no per vendre.' : 'No prometemos lo imposible. El calendario se define a la vista de la obra, no para vender.'],
    ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z', 'title' => $isCa ? 'Pagament fraccionat' : 'Pago fraccionado', 'desc' => $isCa ? 'Vinculat a hitos d\'obra. No pagues tot per endavant.' : 'Vinculado a hitos de obra. No pagas todo por adelantado.'],
];

// ── FAQ geral ─────────────────────────────────────────────────────
$faq_items = [
    ['q' => $isCa ? '¿En quines zones treballeu?' : '¿En qué zonas trabajáis?', 'a' => $isCa ? 'Principalment a Barcelona ciutat i àrea metropolitana, Girona i Tarragona. Per a obres de certa envergadura també ens desplacem a la resta de Catalunya.' : 'Principalmente en Barcelona ciudad y área metropolitana, Girona y Tarragona. Para obras de cierta envergadura también nos desplazamos al resto de Cataluña.'],
    ['q' => $isCa ? '¿El pressupost és gratuït?' : '¿El presupuesto es gratuito?', 'a' => $isCa ? 'Sí. La primera visita i el pressupost són gratuïts i sense compromís. Només comencem quan tu ho decideixes.' : 'Sí. La primera visita y el presupuesto son gratuitos y sin compromiso. Solo empezamos cuando tú lo decides.'],
    ['q' => $isCa ? '¿Quant trigueu a preparar un pressupost?' : '¿Cuánto tardáis en preparar un presupuesto?', 'a' => $isCa ? 'Després de la visita tècnica, el pressupost tancat està llest en 24-48 hores. Per a obres complexes pot trigar una mica més, però sempre et diem el termini realista.' : 'Tras la visita técnica, el presupuesto cerrado está listo en 24-48 horas. Para obras complejas puede tardar un poco más, pero siempre te decimos el plazo realista.'],
    ['q' => $isCa ? '¿Gestionau llicències i permisos?' : '¿Gestionáis licencias y permisos?', 'a' => $isCa ? 'Sí. Gestionem llicències d\'obra, permisos d\'ocupació de via pública i tota la documentació necessària segons l\'abast del projecte.' : 'Sí. Gestionamos licencias de obra, permisos de ocupación de vía pública y toda la documentación necesaria según el alcance del proyecto.'],
    ['q' => $isCa ? '¿Doneu garantia?' : '¿Daís garantía?', 'a' => $isCa ? 'Sí. Oferim 2 anys de garantia per escrit en execució i acabats. També comptem amb assegurança de responsabilitat civil.' : 'Sí. Ofrecemos 2 años de garantía por escrito en ejecución y acabados. También contamos con seguro de responsabilidad civil.'],
    ['q' => $isCa ? '¿Puc pagar a terminis?' : '¿Puedo pagar a plazos?', 'a' => $isCa ? 'Sí. El pagament es vincula a hitos d\'obra acordats per escrit. No cal pagar tot per endavant.' : 'Sí. El pago se vincula a hitos de obra acordados por escrito. No hace falta pagar todo por adelantado.'],
];

include __DIR__ . '/../includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════════════
     1. HERO
     ═══════════════════════════════════════════════════════════════ -->
<section class="pt-32 pb-20 md:pb-28 bg-slate-950 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-px bg-brand-500/40"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="max-w-4xl">
            <div class="flex items-center gap-4 mb-6">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['services_label']; ?></span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight mb-6 leading-[1.1]">
                <?php echo $t['hero_h1']; ?>
            </h1>
            <p class="text-slate-300 text-lg md:text-xl leading-relaxed max-w-2xl mb-10">
                <?php echo $t['hero_p']; ?>
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20estoy%20interesado%20en%20un%20proyecto"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold px-7 py-3.5 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <?php echo $t['hero_cta_whatsapp']; ?>
                </a>
                <a href="/<?php echo $lang; ?>/contacto/"
                   class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-7 py-3.5 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $t['hero_cta_budget']; ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="tel:<?php echo COMPANY_PHONE; ?>"
                   class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-300 hover:text-white font-medium px-7 py-3.5 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $t['hero_cta_call']; ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     2. GRID DE SERVIÇOS
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['services_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['services_h2']; ?>
            </h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $svc): ?>
            <article class="group relative overflow-hidden rounded-sm bg-slate-950 border border-slate-800 card-lift flex flex-col">
                <div class="aspect-[16/9] overflow-hidden bg-slate-800 relative">
                    <img src="<?php echo $svc['img']; ?>"
                         alt="<?php echo htmlspecialchars($svc['title'], ENT_QUOTES, 'UTF-8'); ?>"
                         class="w-full h-full object-cover img-zoom opacity-80 group-hover:opacity-100 transition-opacity duration-500"
                         loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="absolute top-4 right-4 bg-brand-600 text-white text-xs font-bold px-3 py-1 rounded-sm">
                        <?php echo $svc['price']; ?>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="font-display font-bold text-xl text-white mb-2"><?php echo $svc['title']; ?></h3>
                    <p class="text-slate-400 text-sm mb-4 flex-1"><?php echo $svc['desc']; ?></p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach ($svc['features'] as $feat): ?>
                        <span class="text-xs bg-slate-800 text-slate-300 px-2 py-1 rounded-sm"><?php echo $feat; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <a href="/<?php echo $lang; ?>/<?php echo $slugs[$svc['slug']]; ?>/"
                       class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold group/link mt-auto">
                        <?php echo $isCa ? 'Veure més' : 'Ver más'; ?> <span class="transition-transform group-hover/link:translate-x-1">→</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     3. GUIA DE COMPARAÇÃO
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" data-reveal>
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['guide_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['guide_h2']; ?>
            </h2>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-sm overflow-hidden">
            <div class="grid grid-cols-3 gap-0 text-sm font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-800">
                <div class="p-4 md:p-6"><?php echo $t['guide_col_need']; ?></div>
                <div class="p-4 md:p-6"><?php echo $t['guide_col_service']; ?></div>
                <div class="p-4 md:p-6 text-right"><?php echo $t['guide_col_price']; ?></div>
            </div>
            <?php foreach ($guide as $i => $row): ?>
            <div class="grid grid-cols-3 gap-0 text-sm border-b border-slate-800/50 hover:bg-slate-800/30 transition-colors">
                <div class="p-4 md:p-6 text-slate-300"><?php echo $row['need']; ?></div>
                <div class="p-4 md:p-6 text-white"><?php echo $row['service']; ?></div>
                <div class="p-4 md:p-6 text-brand-500 font-display font-bold text-right"><?php echo $row['price']; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="text-center text-slate-500 text-sm mt-6">
            <?php echo $isCa ? 'Els preus són orientatius. El pressupost realista requereix visita tècnica.' : 'Los precios son orientativos. El presupuesto realista requiere visita técnica.'; ?>
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     4. PROCESO GENERAL
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['process_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['process_h2']; ?>
            </h2>
        </div>
        <div class="grid md:grid-cols-5 gap-6">
            <?php foreach ($process as $step): ?>
            <div class="bg-slate-950/50 border border-slate-800 rounded-sm p-6 text-center">
                <span class="font-display font-bold text-3xl text-brand-600/40 block mb-4"><?php echo $step['num']; ?></span>
                <h3 class="font-display font-bold text-lg text-white mb-3"><?php echo $step['title']; ?></h3>
                <p class="text-slate-400 text-sm leading-relaxed"><?php echo $step['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     5. DIFERENCIADORES
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['diff_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['diff_h2']; ?>
            </h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($diffs as $diff): ?>
            <div class="bg-slate-900/50 border border-slate-800 rounded-sm p-6">
                <svg class="w-8 h-8 text-brand-500 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo $diff['icon']; ?>"/></svg>
                <h3 class="font-display font-bold text-lg text-white mb-2"><?php echo $diff['title']; ?></h3>
                <p class="text-slate-400 text-sm leading-relaxed"><?php echo $diff['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     6. FAQ + Schema
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" id="faq-servicios" data-reveal>
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['faq_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['faq_h2']; ?>
            </h2>
        </div>
        <div class="space-y-4" id="faq-accordion-servicios">
            <?php foreach ($faq_items as $i => $faq): ?>
            <div class="faq-item bg-slate-950/50 border border-slate-800 rounded-sm overflow-hidden">
                <button type="button"
                        class="faq-trigger w-full flex items-center justify-between p-6 text-left group"
                        aria-expanded="false"
                        data-index="<?php echo $i; ?>">
                    <span class="font-display font-bold text-white text-lg pr-4"><?php echo $faq['q']; ?></span>
                    <span class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-600 transition-colors">
                        <svg class="faq-icon w-4 h-4 text-white transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6">
                    <p class="text-slate-300 leading-relaxed"><?php echo $faq['a']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    (function() {
        var accordion = document.getElementById('faq-accordion-servicios');
        if (!accordion) return;
        var items = accordion.querySelectorAll('.faq-item');
        items.forEach(function(item) {
            var trigger = item.querySelector('.faq-trigger');
            var content = item.querySelector('.faq-content');
            var icon = item.querySelector('.faq-icon');
            if (!trigger || !content) return;
            trigger.addEventListener('click', function() {
                var isOpen = !content.classList.contains('hidden');
                items.forEach(function(otherItem) {
                    otherItem.querySelector('.faq-content').classList.add('hidden');
                    otherItem.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
                    var otherIcon = otherItem.querySelector('.faq-icon');
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                });
                if (!isOpen) {
                    content.classList.remove('hidden');
                    trigger.setAttribute('aria-expanded', 'true');
                    if (icon) icon.style.transform = 'rotate(180deg)';
                }
            });
        });
    })();
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            <?php $totalFaq = count($faq_items); foreach ($faq_items as $i => $faq): ?>
            {
                "@type": "Question",
                "name": "<?php echo str_replace('"', '\\"', $faq['q']); ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "<?php echo str_replace('"', '\\"', strip_tags($faq['a'])); ?>"
                }
            }<?php echo $i < $totalFaq - 1 ? ',' : ''; ?>
            <?php endforeach; ?>
        ]
    }
    </script>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     7. CTA FINAL
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950 relative overflow-hidden" data-reveal>
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight mb-6">
            <?php echo $t['final_h2']; ?>
        </h2>
        <p class="text-slate-300 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
            <?php echo $t['final_p']; ?>
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/<?php echo $lang; ?>/contacto/"
               class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo $t['final_cta_form']; ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20estoy%20interesado%20en%20un%20proyecto"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <?php echo $t['final_cta_wa']; ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
