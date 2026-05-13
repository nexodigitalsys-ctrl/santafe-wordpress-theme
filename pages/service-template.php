<?php
/**
 * Template reutilizável para páginas de serviço individuais
 * Usado por: obra-nueva, reformas-integrales, pladur-acabados, obra-publica, obra-civil
 * Variável obrigatória antes do include: $service_slug
 */

declare(strict_types=1);

if (!isset($service_slug)) {
    $service_slug = 'obra-nueva';
}

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$isCa = $lang === 'ca';
$translations = load_translations($lang);

// ── Carrega dados do serviço ──────────────────────────────────────
$services_data = require __DIR__ . '/../config/services-data.php';
$data = $services_data[$service_slug][$lang] ?? $services_data['obra-nueva']['es'];

$service_name = $data['h1'] ?? ($isCa ? 'Servei' : 'Servicio');
$service_name_short = $isCa
    ? (['obra-nueva'=>'Obra nova','reformas-integrales'=>'Reformes','pladur-acabados'=>'Pladur','obra-publica'=>'Obra pública','obra-civil'=>'Obra civil'][$service_slug] ?? 'Servei')
    : (['obra-nueva'=>'Obra nueva','reformas-integrales'=>'Reformas','pladur-acabados'=>'Pladur','obra-publica'=>'Obra pública','obra-civil'=>'Obra civil'][$service_slug] ?? 'Servicio');

// ── Page metadata ─────────────────────────────────────────────────
$page_data = [
    'lang' => $lang,
    'title' => $data['title'] ?? $service_name,
    'description' => $data['description'] ?? '',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . $service_slug . '/',
    'schemas' => [
        function() use ($service_slug, $lang) {
            return get_schema_service($service_slug, $lang);
        },
        function() use ($lang, $service_name, $service_slug) {
            return get_schema_breadcrumb([
                ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
                ['name' => $lang === 'ca' ? 'Serveis' : 'Servicios', 'url' => '/' . $lang . '/' . ($lang === 'ca' ? 'serveis' : 'servicios') . '/'],
                ['name' => $service_name, 'url' => '/' . $lang . '/' . $service_slug . '/'],
            ]);
        },
    ],
];

$theme_uri = get_template_directory_uri();

// ── Galerias por serviço ──────────────────────────────────────────
$galleries = [
    'obra-nueva' => [
        ['img' => '/assets/images/portfolio/portfolio-obra-nueva-piscina.webp', 'title' => $isCa ? 'Casa amb piscina · Girona · 2024' : 'Casa con piscina · Girona · 2024', 'cat' => $isCa ? 'Obra nova' : 'Obra nueva'],
        ['img' => '/assets/images/portfolio/portfolio-obra-nueva-fachada-piedra.webp', 'title' => $isCa ? 'Façana en pedra · Girona · 2023' : 'Fachada en piedra · Girona · 2023', 'cat' => $isCa ? 'Obra nova' : 'Obra nueva'],
        ['img' => '/assets/images/portfolio/portfolio-obra-nueva-casa-moderna.webp', 'title' => $isCa ? 'Vivenda unifamiliar · Barcelona · 2024' : 'Vivienda unifamiliar · Barcelona · 2024', 'cat' => $isCa ? 'Obra nova' : 'Obra nueva'],
        ['img' => '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp', 'title' => $isCa ? 'Jardí i piscina · Girona' : 'Jardín y piscina · Girona', 'cat' => $isCa ? 'Obra nova' : 'Obra nueva'],
    ],
    'reformas-integrales' => [
        ['img' => '/assets/images/portfolio/portfolio-reforma-recepcion.webp', 'title' => $isCa ? 'Recepció reformada · Barcelona · 2024' : 'Recepción reformada · Barcelona · 2024', 'cat' => $isCa ? 'Reforma integral' : 'Reforma integral'],
        ['img' => '/assets/images/portfolio/portfolio-reforma-ducha.webp', 'title' => $isCa ? 'Bany complet · Barcelona · 2024' : 'Baño completo · Barcelona · 2024', 'cat' => $isCa ? 'Reforma parcial' : 'Reforma parcial'],
        ['img' => '/assets/images/portfolio/portfolio-reforma-suelo.webp', 'title' => $isCa ? 'Sòl porcelànic · Tarragona · 2023' : 'Suelo porcelánico · Tarragona · 2023', 'cat' => $isCa ? 'Acabados' : 'Acabados'],
        ['img' => '/assets/images/servicios/reformas/reforma-recepcion-acabada.webp', 'title' => $isCa ? 'Espai comercial · Barcelona' : 'Espacio comercial · Barcelona', 'cat' => $isCa ? 'Reforma integral' : 'Reforma integral'],
    ],
    'pladur-acabados' => [
        ['img' => '/assets/images/servicios/pladur/pladur-hall-acabado.webp', 'title' => $isCa ? 'Hall residencial · Gràcia · 2024' : 'Hall residencial · Gràcia · 2024', 'cat' => $isCa ? 'Pladur' : 'Pladur'],
        ['img' => '/assets/images/portfolio/portfolio-reforma-recepcion.webp', 'title' => $isCa ? 'Sostre registrable · Barcelona' : 'Techo registrable · Barcelona', 'cat' => $isCa ? 'Pladur' : 'Pladur'],
        ['img' => '/assets/images/portfolio/portfolio-reforma-ducha.webp', 'title' => $isCa ? 'Trasdosat bany · Barcelona' : 'Trasdosado baño · Barcelona', 'cat' => $isCa ? 'Pladur' : 'Pladur'],
        ['img' => '/assets/images/servicios/reformas/reforma-recepcion-acabada.webp', 'title' => $isCa ? 'Acabats interiors · Barcelona' : 'Acabados interiores · Barcelona', 'cat' => $isCa ? 'Pladur' : 'Pladur'],
    ],
    'obra-publica' => [
        ['img' => '/assets/images/portfolio/portfolio-obra-publica-calzada.webp', 'title' => $isCa ? 'Pavimentació urbana · Barcelona · 2024' : 'Pavimentación urbana · Barcelona · 2024', 'cat' => $isCa ? 'Obra pública' : 'Obra pública'],
        ['img' => '/assets/images/servicios/obra-publica/obra-publica-calzada-acabada.webp', 'title' => $isCa ? 'Calçada acabada · Barcelona' : 'Calzada acabada · Barcelona', 'cat' => $isCa ? 'Obra pública' : 'Obra pública'],
        ['img' => '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp', 'title' => $isCa ? 'Bordillos · Tarragona · 2023' : 'Bordillos · Tarragona · 2023', 'cat' => $isCa ? 'Obra pública' : 'Obra pública'],
        ['img' => '/assets/images/servicios/obra-publica/obra-civil-aceras-construccion.webp', 'title' => $isCa ? 'Aceres i mobiliari · Tarragona' : 'Aceras y mobiliario · Tarragona', 'cat' => $isCa ? 'Obra pública' : 'Obra pública'],
    ],
    'obra-civil' => [
        ['img' => '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp', 'title' => $isCa ? 'Bordillos corba · Tarragona · 2023' : 'Bordillos curva · Tarragona · 2023', 'cat' => $isCa ? 'Obra civil' : 'Obra civil'],
        ['img' => '/assets/images/servicios/obra-publica/obra-civil-aceras-construccion.webp', 'title' => $isCa ? 'Aceres construcció · Tarragona' : 'Aceras construcción · Tarragona', 'cat' => $isCa ? 'Obra civil' : 'Obra civil'],
        ['img' => '/assets/images/portfolio/portfolio-obra-publica-calzada.webp', 'title' => $isCa ? 'Pavimentació · Barcelona · 2024' : 'Pavimentación · Barcelona · 2024', 'cat' => $isCa ? 'Obra civil' : 'Obra civil'],
        ['img' => '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp', 'title' => $isCa ? 'Preparació terreny · Girona' : 'Preparación terreno · Girona', 'cat' => $isCa ? 'Obra civil' : 'Obra civil'],
    ],
];
$gallery = $galleries[$service_slug] ?? $galleries['obra-nueva'];

// ── Traduções do template ─────────────────────────────────────────
$t = [
    'hero_cta_whatsapp' => $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h',
    'hero_cta_budget' => $isCa ? 'Solicitar pressupost tancat' : 'Solicitar presupuesto cerrado',
    'hero_cta_call' => $isCa ? 'Trucar ara' : 'Llamar ahora',

    'pas_label' => $isCa ? 'El problema' : 'El problema',
    'pas_promise_label' => $isCa ? 'La nostra promesa' : 'Nuestra promesa',

    'includes_label' => $isCa ? 'Què inclou' : 'Qué incluye',
    'includes_h2_prefix' => $isCa ? 'De principi a fi. Tu tries el nivell; nosaltres ho coordinem tot.' : 'De principio a fin. Tú eliges el nivel; nosotros coordinamos todo.',

    'prices_label' => $isCa ? 'Preus orientatius' : 'Precios orientativos',
    'prices_h2' => $isCa ? 'Horquilla realista per m²' : 'Horquilla realista por m²',
    'prices_p1' => $isCa
        ? 'El preu final depèn de l\'estat inicial, els metres quadrats, els materials i el nivell d\'acabat. Aquestes horquilles són orientatives per planificar. Per un pressupost realista, necessitem visitar l\'obra.'
        : 'El precio final depende del estado inicial, los metros cuadrados, los materiales y el nivel de acabado. Estas horquillas son orientativas para planificar. Para un presupuesto realista, necesitamos visitar la obra.',
    'prices_note' => $isCa
        ? 'El pressupost tancat que firmem és el que pagues. Cap extra ocult.'
        : 'El presupuesto cerrado que firmamos es el que pagas. Ningún extra oculto.',
    'prices_card_basic' => $isCa ? 'Acabat bàsic' : 'Acabado básico',
    'prices_card_standard' => $isCa ? 'Acabat estàndard' : 'Acabado estándar',
    'prices_card_premium' => $isCa ? 'Acabat premium' : 'Acabado premium',
    'prices_most_requested' => $isCa ? 'Més sol·licitat' : 'Más solicitado',
    'prices_cta' => $isCa ? 'Solicitar pressupost' : 'Solicitar presupuesto',

    'process_label' => $isCa ? 'Com treballem' : 'Cómo trabajamos',
    'process_h2' => $isCa ? 'De la visita a l\'entrega en 5 passos clars' : 'De la visita a la entrega en 5 pasos claros',

    'gallery_label' => $isCa ? 'Resultats reals' : 'Resultados reales',
    'gallery_h2' => $isCa ? 'Obres que hem transformat' : 'Obras que hemos transformado',

    'faq_label' => $isCa ? 'Preguntes freqüents' : 'Preguntas frecuentes',
    'faq_h2' => $isCa ? 'El que ens pregunten abans de començar' : 'Lo que nos preguntan antes de empezar',

    'final_h2' => $isCa
        ? 'Vols saber quant costaria el teu projecte?'
        : '¿Quieres saber cuánto costaría tu proyecto?',
    'final_p' => $isCa
        ? 'La primera visita és gratuïta i sense compromís. Paulo revisarà l\'obra, et dirà el següent pas i prepararà un pressupost tancat en 48 hores.'
        : 'La primera visita es gratuita y sin compromiso. Paulo revisará la obra, te dirá el siguiente paso y preparará un presupuesto cerrado en 48 horas.',
    'final_cta_form' => $isCa ? 'Omplir formulari' : 'Rellenar formulario',
    'final_cta_wa' => $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h',
];

// ── Preços por serviço ────────────────────────────────────────────
$price_tiers = [
    'obra-nueva' => [
        ['title' => $t['prices_card_basic'], 'desc' => $isCa ? 'Funcionalitat prioritària, materials estàndard.' : 'Funcionalidad prioritaria, materiales estándar.', 'price' => $isCa ? 'Des de 800 €/m²' : 'Desde 800 €/m²'],
        ['title' => $t['prices_card_standard'], 'desc' => $isCa ? 'Qualitat equilibrada, acabats cuidats.' : 'Calidad equilibrada, acabados cuidados.', 'price' => $isCa ? 'Des de 1.100 €/m²' : 'Desde 1.100 €/m²'],
        ['title' => $t['prices_card_premium'], 'desc' => $isCa ? 'Alta gamma, disseny personalitzat.' : 'Alta gama, diseño personalizado.', 'price' => $isCa ? 'Des de 1.600 €/m²' : 'Desde 1.600 €/m²'],
    ],
    'reformas-integrales' => [
        ['title' => $t['prices_card_basic'], 'desc' => $isCa ? 'Materials estàndard, funcionalitat prioritària.' : 'Materiales estándar, funcionalidad prioritaria.', 'price' => $isCa ? 'Des de 450 €/m²' : 'Desde 450 €/m²'],
        ['title' => $t['prices_card_standard'], 'desc' => $isCa ? 'Materials de qualitat, acabats duradors.' : 'Materiales de calidad, acabados duraderos.', 'price' => $isCa ? 'Des de 650 €/m²' : 'Desde 650 €/m²'],
        ['title' => $t['prices_card_premium'], 'desc' => $isCa ? 'Alta gamma, detalls d\'obra selecta.' : 'Alta gama, detalles de obra selecta.', 'price' => $isCa ? 'Des de 900 €/m²' : 'Desde 900 €/m²'],
    ],
    'pladur-acabados' => [
        ['title' => $t['prices_card_basic'], 'desc' => $isCa ? 'Placa estàndard, sense aïllament.' : 'Placa estándar, sin aislamiento.', 'price' => $isCa ? 'Des de 35 €/m²' : 'Desde 35 €/m²'],
        ['title' => $t['prices_card_standard'], 'desc' => $isCa ? 'Aïllament tèrmic i acústic.' : 'Aislamiento térmico y acústico.', 'price' => $isCa ? 'Des de 55 €/m²' : 'Desde 55 €/m²'],
        ['title' => $t['prices_card_premium'], 'desc' => $isCa ? 'Placa especial, il·luminació integrada.' : 'Placa especial, iluminación integrada.', 'price' => $isCa ? 'Des de 75 €/m²' : 'Desde 75 €/m²'],
    ],
    'obra-publica' => [
        ['title' => $t['prices_card_basic'], 'desc' => $isCa ? 'Obra menor, manteniment.' : 'Obra menor, mantenimiento.', 'price' => $isCa ? 'A convenir' : 'A convenir'],
        ['title' => $t['prices_card_standard'], 'desc' => $isCa ? 'Pavimentació, aceres, mobiliari.' : 'Pavimentación, aceras, mobiliario.', 'price' => $isCa ? 'A convenir' : 'A convenir'],
        ['title' => $t['prices_card_premium'], 'desc' => $isCa ? 'Projecte integral amb gestió documental.' : 'Proyecto integral con gestión documental.', 'price' => $isCa ? 'A convenir' : 'A convenir'],
    ],
    'obra-civil' => [
        ['title' => $t['prices_card_basic'], 'desc' => $isCa ? 'Preparació de terreny, moviments de terres.' : 'Preparación de terreno, movimientos de tierra.', 'price' => $isCa ? 'A convenir' : 'A convenir'],
        ['title' => $t['prices_card_standard'], 'desc' => $isCa ? 'Cimentacions, murs, canalitzacions.' : 'Cimentaciones, muros, canalizaciones.', 'price' => $isCa ? 'A convenir' : 'A convenir'],
        ['title' => $t['prices_card_premium'], 'desc' => $isCa ? 'Estructura completa amb coordinació tècnica.' : 'Estructura completa con coordinación técnica.', 'price' => $isCa ? 'A convenir' : 'A convenir'],
    ],
];
$prices = $price_tiers[$service_slug] ?? $price_tiers['obra-nueva'];

// ── Features por serviço ──────────────────────────────────────────
$feature_lists = [
    'obra-nueva' => $isCa ? [
        'Estudi tècnic inicial i visat',
        'Planificació d\'obra per fases',
        'Coordinació de gremis i subministraments',
        'Seguiment directe amb Paulo',
        'Llicències i documentació',
        'Entrega neta amb certificats',
    ] : [
        'Estudio técnico inicial y visado',
        'Planificación de obra por fases',
        'Coordinación de gremios y suministros',
        'Seguimiento directo con Paulo',
        'Licencias y documentación',
        'Entrega limpia con certificados',
    ],
    'reformas-integrales' => $isCa ? [
        'Visita tècnica i diagnòstic gratuït',
        'Desmuntatge i retirada de runa',
        'Albañileria, instal·lacions i acabats',
        'Fusteria interior i exterior',
        'Cocina i bany complet',
        'Neteja final i lliurament',
    ] : [
        'Visita técnica y diagnóstico gratuito',
        'Desmontaje y retirada de escombros',
        'Albañilería, instalaciones y acabados',
        'Carpintería interior y exterior',
        'Cocina y baño completo',
        'Limpieza final y entrega',
    ],
    'pladur-acabados' => $isCa ? [
        'Tabiques i trasdosats',
        'Sostres continus i registrables',
        'Aïllament acústic i tèrmic',
        'Il·luminació integrada',
        'Acabats llestos per pintar',
        'Solucions per a humitats',
    ] : [
        'Tabiques y trasdosados',
        'Techos continuos y registrables',
        'Aislamiento acústico y térmico',
        'Iluminación integrada',
        'Acabados listos para pintar',
        'Soluciones para humedades',
    ],
    'obra-publica' => $isCa ? [
        'Coordinació tècnica amb l\'administració',
        'Cumpliment documental',
        'Plan de treball per fases',
        'Control d\'execució i qualitat',
        'Entrega traçable',
        'Garantia de reparació',
    ] : [
        'Coordinación técnica con la administración',
        'Cumplimiento documental',
        'Plan de trabajo por fases',
        'Control de ejecución y calidad',
        'Entrega trazable',
        'Garantía de reparación',
    ],
    'obra-civil' => $isCa ? [
        'Cimentacions i estructures',
        'Murs i contencions',
        'Canalitzacions i drenatges',
        'Preparació de terreny',
        'Coordinació tècnica',
        'Control de seguretat',
    ] : [
        'Cimentaciones y estructuras',
        'Muros y contenciones',
        'Canalizaciones y drenajes',
        'Preparación de terreno',
        'Coordinación técnica',
        'Control de seguridad',
    ],
];
$features = $feature_lists[$service_slug] ?? $feature_lists['obra-nueva'];

// ── FAQ específico por serviço ────────────────────────────────────
$faq_lists = [
    'obra-nueva' => $isCa ? [
        ['q' => '¿Treballau amb arquitecte?', 'a' => 'Sí, és viable coordinar-nos amb la direcció facultativa del client o recomanar tècnics col·laboradors segons el projecte.'],
        ['q' => '¿El pressupost és tancat?', 'a' => 'S\'entrega per partides i abast definit. Qualsevol canvi es valida abans d\'executar-se.'],
        ['q' => '¿Gestioneu les llicències?', 'a' => 'Acompanyem la tramitació i coordinació documental quan l\'abast ho requereix.'],
        ['q' => '¿Quin termini té una obra nova?', 'a' => 'Depèn de m², estructura i complexitat. Després de la visita tècnica podem estimar un calendari realista.'],
        ['q' => '¿Puc visitar obres en curs?', 'a' => 'Sí, amb cita prèvia i coordinant amb el capataç de l\'obra.'],
        ['q' => '¿Doneu garantia?', 'a' => 'Sí. Oferim 2 anys de garantia per escrit en execució i acabats.'],
    ] : [
        ['q' => '¿Trabajáis con arquitecto?', 'a' => 'Sí, es viable coordinarse con la dirección facultativa del cliente o recomendar técnicos colaboradores según el proyecto.'],
        ['q' => '¿El presupuesto es cerrado?', 'a' => 'Se entrega por partidas y alcance definido. Cualquier cambio se valida antes de ejecutarse.'],
        ['q' => '¿Gestionáis las licencias?', 'a' => 'Acompañamos la tramitación y coordinación documental cuando el alcance lo requiere.'],
        ['q' => '¿Qué plazo tiene una obra nueva?', 'a' => 'Depende de m², estructura y complejidad. Tras la visita técnica podemos estimar un calendario realista.'],
        ['q' => '¿Puedo visitar obras en curso?', 'a' => 'Sí, con cita previa y coordinando con el capataz de la obra.'],
        ['q' => '¿Daís garantía?', 'a' => 'Sí. Ofrecemos 2 años de garantía por escrito en ejecución y acabados.'],
    ],
    'reformas-integrales' => $isCa ? [
        ['q' => '¿Quant tarda una reforma integral?', 'a' => 'Depèn dels m² i la complexitat. Un pis de 80 m² amb reforma completa sol trigar entre 6 i 10 setmanes. Després de la visita tècnica et donem un calendari realista.'],
        ['q' => '¿Puc viure a casa durant la reforma?', 'a' => 'En reformes parcials de vegades sí; en integrals completes normalment no és recomanable per soroll, pols i seguretat. Et podem assessorar segons l\'abast.'],
        ['q' => '¿Incloeu materials?', 'a' => 'Sí, es poden incloure materials i coordinar compres segons el nivell d\'acabat acordat. Preparem una memòria de qualitats amb marques i models exactes.'],
        ['q' => '¿Què passa si apareixen humitats?', 'a' => 'Durant la visita tècnica detectem signes d\'humitat. Si apareixen durant l\'obra, t\'informem abans de continuar i valorem la solució sense pressió.'],
        ['q' => '¿Gestioneu la llicència d\'obra?', 'a' => 'Sí. Tramitem llicència d\'obra menor o major segons l\'abast. També gestionem permís d\'ocupació de via pública per contenidors si cal.'],
        ['q' => '¿El pressupost és tancat?', 'a' => 'Sí. El preu que firmem és el preu final. Qualsevol canvi que afecti el pressupost es valida per escrit abans d\'executar-se.'],
        ['q' => '¿Doneu garantia?', 'a' => 'Sí. Oferim 2 anys de garantia per escrit en execució i acabats. També comptem amb assegurança de responsabilitat civil.'],
        ['q' => '¿En quines zones treballeu?', 'a' => 'Principalment a Barcelona ciutat i àrea metropolitana, Girona i Tarragona. Per a obres de certa envergadura també ens desplacem a la resta de Catalunya.'],
    ] : [
        ['q' => '¿Cuánto tarda una reforma integral?', 'a' => 'Depende de los m² y la complejidad. Un piso de 80 m² con reforma completa suele tardar entre 6 y 10 semanas. Tras la visita técnica te damos un calendario realista.'],
        ['q' => '¿Puedo vivir en casa durante la reforma?', 'a' => 'En reformas parciales a veces sí; en integrales completas normalmente no es recomendable por ruido, polvo y seguridad. Te podemos asesorar según el alcance.'],
        ['q' => '¿Incluís materiales?', 'a' => 'Sí, se pueden incluir materiales y coordinar compras según el nivel de acabado acordado. Preparamos una memoria de calidades con marcas y modelos exactos.'],
        ['q' => '¿Qué pasa si aparecen humedades?', 'a' => 'Durante la visita técnica detectamos signos de humedad. Si aparecen durante la obra, te informamos antes de continuar y valoramos la solución sin presión.'],
        ['q' => '¿Gestionáis la licencia de obra?', 'a' => 'Sí. Tramitamos licencia de obra menor o mayor según el alcance. También gestionamos permiso de ocupación de vía pública para contenedores si es necesario.'],
        ['q' => '¿El presupuesto es cerrado?', 'a' => 'Sí. El precio que firmamos es el precio final. Cualquier cambio que afecte el presupuesto se valida por escrito antes de ejecutarse.'],
        ['q' => '¿Daís garantía?', 'a' => 'Sí. Ofrecemos 2 años de garantía por escrito en ejecución y acabados. También contamos con seguro de responsabilidad civil.'],
        ['q' => '¿En qué zonas trabajáis?', 'a' => 'Principalmente en Barcelona ciudad y área metropolitana, Girona y Tarragona. Para obras de cierta envergadura también nos desplazamos al resto de Cataluña.'],
    ],
    'pladur-acabados' => $isCa ? [
        ['q' => '¿El pladur serveix per aïllar soroll?', 'a' => 'Sí, si es dissenya amb placa, llana mineral i sistema adequats.'],
        ['q' => '¿Es poden penjar mobles?', 'a' => 'Sí, preveient reforts i anclatges adequats segons càrrega.'],
        ['q' => '¿Treballau sostres amb il·luminació?', 'a' => 'Sí, coordinem forats, passos i acabats per a il·luminació integrada.'],
        ['q' => '¿Quant costa el pladur per m²?', 'a' => 'Des de 35 €/m² per a placa estàndard sense aïllament. Amb aïllament acústic i tèrmic, des de 55 €/m².'],
        ['q' => '¿El pladur aguanta la humitat?', 'a' => 'Hi ha plaques específiques per a zones humides (bany, cuina). Les avaluem durant la visita.'],
        ['q' => '¿Quin termini té una obra de pladur?', 'a' => 'Un apartament de 80 m² amb pladur a tota la vivenda sol trigar 1-2 setmanes.'],
    ] : [
        ['q' => '¿El pladur sirve para aislar ruido?', 'a' => 'Sí, si se diseña con placa, lana mineral y sistema adecuados.'],
        ['q' => '¿Se pueden colgar muebles?', 'a' => 'Sí, previendo refuerzos y anclajes adecuados según carga.'],
        ['q' => '¿Trabajáis techos con iluminación?', 'a' => 'Sí, coordinamos huecos, pasos y acabados para iluminación integrada.'],
        ['q' => '¿Cuánto cuesta el pladur por m²?', 'a' => 'Desde 35 €/m² para placa estándar sin aislamiento. Con aislamiento acústico y térmico, desde 55 €/m².'],
        ['q' => '¿El pladur aguanta la humedad?', 'a' => 'Hay placas específicas para zonas húmedas (baño, cocina). Las evaluamos durante la visita.'],
        ['q' => '¿Qué plazo tiene una obra de pladur?', 'a' => 'Un apartamento de 80 m² con pladur en toda la vivienda suele tardar 1-2 semanas.'],
    ],
    'obra-publica' => $isCa ? [
        ['q' => '¿Treballau per a administracions?', 'a' => 'Sí, en projectes on l\'abast i la documentació estiguin definits.'],
        ['q' => '¿Podeu coordinar documentació?', 'a' => 'Sí, dins de l\'abast acordat amb la direcció tècnica.'],
        ['q' => '¿En quines zones treballeu?', 'a' => 'Principalment Barcelona, Girona, Tarragona i Catalunya.'],
        ['q' => '¿Quin tipus d\'obra pública feu?', 'a' => 'Pavimentació urbana, aceres, mobiliari urbà, rehabilitació de façanes i espais públics.'],
        ['q' => '¿Com es factura l\'obra pública?', 'a' => 'Segons certificacions d\'obra, medicions i pliego de condicions.'],
        ['q' => '¿Doneu garantia en obra pública?', 'a' => 'Sí, complim el període de garantia exigit per l\'administració contractant.'],
    ] : [
        ['q' => '¿Trabajáis para administraciones?', 'a' => 'Sí, en proyectos donde el alcance y la documentación estén definidos.'],
        ['q' => '¿Podéis coordinar documentación?', 'a' => 'Sí, dentro del alcance acordado con la dirección técnica.'],
        ['q' => '¿En qué zonas trabajáis?', 'a' => 'Principalmente Barcelona, Girona, Tarragona y Cataluña.'],
        ['q' => '¿Qué tipo de obra pública hacéis?', 'a' => 'Pavimentación urbana, aceras, mobiliario urbano, rehabilitación de fachadas y espacios públicos.'],
        ['q' => '¿Cómo se factura la obra pública?', 'a' => 'Según certificaciones de obra, mediciones y pliego de condiciones.'],
        ['q' => '¿Daís garantía en obra pública?', 'a' => 'Sí, cumplimos el período de garantía exigido por la administración contratante.'],
    ],
    'obra-civil' => $isCa ? [
        ['q' => '¿Feu cimentacions?', 'a' => 'Sí, segons projecte tècnic, medicions i direcció facultativa.'],
        ['q' => '¿Treballau amb empreses?', 'a' => 'Sí, per a empreses, comunitats i clients amb necessitats tècniques.'],
        ['q' => '¿Visiteu l\'obra abans de pressupostar?', 'a' => 'Sí, la visita tècnica ajuda a evitar pressupostos irreals.'],
        ['q' => '¿Què inclou l\'obra civil?', 'a' => 'Cimentacions, murs, canalitzacions, preparació de terreny i coordinació tècnica.'],
        ['q' => '¿Gestionau permisos d\'obra civil?', 'a' => 'Acompanyem la tramitació segons l\'abast tècnic del projecte.'],
        ['q' => '¿Quin termini té una obra civil?', 'a' => 'Depèn de les medicions, accés, maquinària i complexitat tècnica. Visitem l\'obra per estimar-ho.'],
    ] : [
        ['q' => '¿Hacéis cimentaciones?', 'a' => 'Sí, según proyecto técnico, mediciones y dirección facultativa.'],
        ['q' => '¿Trabajáis con empresas?', 'a' => 'Sí, para empresas, comunidades y clientes con necesidades técnicas.'],
        ['q' => '¿Visitáis la obra antes de presupuestar?', 'a' => 'Sí, la visita técnica ayuda a evitar presupuestos irreales.'],
        ['q' => '¿Qué incluye la obra civil?', 'a' => 'Cimentaciones, muros, canalizaciones, preparación de terreno y coordinación técnica.'],
        ['q' => '¿Gestionáis permisos de obra civil?', 'a' => 'Acompañamos la tramitación según el alcance técnico del proyecto.'],
        ['q' => '¿Qué plazo tiene una obra civil?', 'a' => 'Depende de las mediciones, acceso, maquinaria y complejidad técnica. Visitamos la obra para estimarlo.'],
    ],
];
$faq_items = $faq_lists[$service_slug] ?? $faq_lists['obra-nueva'];

// ── Phases por serviço (do data ou default) ───────────────────────
$phases = $data['phases'] ?? [
    ['title' => $isCa ? 'Visita' : 'Visita', 'desc' => $isCa ? 'Revisem l\'obra i necessitats.' : 'Revisamos la obra y necesidades.'],
    ['title' => $isCa ? 'Pressupost' : 'Presupuesto', 'desc' => $isCa ? 'Preparació detallada per escrit.' : 'Preparación detallada por escrito.'],
    ['title' => $isCa ? 'Execució' : 'Ejecución', 'desc' => $isCa ? 'Coordinació i seguiment.' : 'Coordinación y seguimiento.'],
    ['title' => $isCa ? 'Entrega' : 'Entrega', 'desc' => $isCa ? 'Revisió final i documentació.' : 'Revisión final y documentación.'],
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
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $service_name_short; ?></span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight mb-6 leading-[1.1]">
                <?php echo $isCa
                    ? str_replace(' | Santa Fe Construcciones', '', $data['h1'] ?? $service_name)
                    : str_replace(' | Santa Fe Construcciones', '', $data['h1'] ?? $service_name); ?>
            </h1>
            <p class="text-slate-300 text-lg md:text-xl leading-relaxed max-w-2xl mb-10">
                <?php echo $data['description'] ?? ''; ?>
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20estoy%20interesado%20en%20<?php echo urlencode($service_name_short); ?>"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold px-7 py-3.5 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <?php echo $t['hero_cta_whatsapp']; ?>
                </a>
                <a href="/<?php echo $lang; ?>/contacto/"
                   class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-7 py-3.5 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $data['cta_primary'] ?? $t['hero_cta_budget']; ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="tel:<?php echo COMPANY_PHONE; ?>"
                   class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-300 hover:text-white font-medium px-7 py-3.5 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $data['cta_secondary'] ?? $t['hero_cta_call']; ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     2. PAS (Problem → Agitate → Solution)
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['pas_label']; ?></span>
                </div>
                <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-8">
                    <?php echo $data['problem'] ?? ''; ?>
                </h2>
                <div class="space-y-6 text-slate-300 leading-relaxed text-lg">
                    <p><?php echo $data['agitate'] ?? ''; ?></p>
                    <div class="bg-brand-600/10 border-l-4 border-brand-600 p-6 rounded-r-sm">
                        <p class="text-white font-semibold mb-2"><?php echo $t['pas_promise_label']; ?></p>
                        <p class="text-slate-300"><?php echo $data['solution'] ?? ''; ?></p>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-[4/3] rounded-sm overflow-hidden bg-slate-800">
                    <img src="<?php echo esc_url($theme_uri . $gallery[0]['img']); ?>"
                         alt="<?php echo esc_attr($service_name); ?>"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.style.display='none'">
                </div>
                <div class="absolute -bottom-4 -right-4 bg-brand-600 text-white px-5 py-3 rounded-sm shadow-xl">
                    <p class="font-display font-bold text-2xl">500+</p>
                    <p class="text-xs uppercase tracking-wider opacity-90"><?php echo $isCa ? 'Obres lliurades' : 'Obras entregadas'; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     3. QUÉ INCLUYE
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['includes_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight max-w-3xl mx-auto">
                <?php echo $t['includes_h2_prefix']; ?>
            </h2>
        </div>
        <div class="grid md:grid-cols-2 gap-4 max-w-4xl mx-auto">
            <?php foreach ($features as $item): ?>
            <div class="flex items-start gap-4 bg-slate-900/60 border border-slate-800 rounded-sm p-5">
                <svg class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                <span class="text-slate-300"><?php echo $item; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     4. PRECIOS ORIENTATIVOS
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['prices_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight mb-6">
                <?php echo $t['prices_h2']; ?>
            </h2>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg"><?php echo $t['prices_p1']; ?></p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <?php foreach ($prices as $i => $price): ?>
            <div class="bg-slate-950 border <?php echo $i === 1 ? 'border-2 border-brand-600' : 'border-slate-800'; ?> rounded-sm p-8 relative">
                <?php if ($i === 1): ?>
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brand-600 text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-sm"><?php echo $t['prices_most_requested']; ?></span>
                <?php endif; ?>
                <h3 class="font-display font-bold text-xl text-white mb-2"><?php echo $price['title']; ?></h3>
                <p class="text-slate-400 text-sm mb-6"><?php echo $price['desc']; ?></p>
                <p class="font-display font-bold text-3xl text-brand-500 mb-6"><?php echo $price['price']; ?></p>
                <a href="/<?php echo $lang; ?>/contacto/" class="block w-full text-center <?php echo $i === 1 ? 'bg-brand-600 hover:bg-brand-500' : 'bg-slate-800 hover:bg-slate-700'; ?> text-white font-semibold py-3 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $t['prices_cta']; ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="text-center text-slate-500 text-sm mt-8"><?php echo $t['prices_note']; ?></p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     5. PROCESO
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" data-reveal>
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
            <?php foreach ($phases as $i => $step): ?>
            <div class="bg-slate-900/50 border border-slate-800 rounded-sm p-6 text-center">
                <span class="font-display font-bold text-3xl text-brand-600/40 block mb-4"><?php echo str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
                <h3 class="font-display font-bold text-lg text-white mb-3"><?php echo $step['title']; ?></h3>
                <p class="text-slate-400 text-sm leading-relaxed"><?php echo $step['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     6. GALERÍA
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['gallery_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['gallery_h2']; ?>
            </h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ($gallery as $g): ?>
            <article class="group relative overflow-hidden rounded-sm aspect-[4/3]">
                <img src="<?php echo esc_url($theme_uri . $g['img']); ?>"
                     alt="<?php echo esc_attr($g['title']); ?>"
                     class="w-full h-full object-cover img-zoom transition-transform duration-700 group-hover:scale-105"
                     loading="lazy"
                     onerror="this.style.display='none'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-widest"><?php echo $g['cat']; ?></span>
                    <h3 class="font-display font-bold text-white text-sm mt-1"><?php echo $g['title']; ?></h3>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     7. FAQ + Schema
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" id="faq-<?php echo $service_slug; ?>" data-reveal>
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
        <div class="space-y-4" id="faq-accordion-<?php echo $service_slug; ?>">
            <?php foreach ($faq_items as $i => $faq): ?>
            <div class="faq-item bg-slate-900/50 border border-slate-800 rounded-sm overflow-hidden">
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

    <!-- FAQ Accordion JS -->
    <script>
    (function() {
        var accordion = document.getElementById('faq-accordion-<?php echo $service_slug; ?>');
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

    <!-- Schema FAQPage -->
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
     8. CTA FINAL
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 relative overflow-hidden" data-reveal>
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
            <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20estoy%20interesado%20en%20<?php echo urlencode($service_name_short); ?>"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <?php echo $t['final_cta_wa']; ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
