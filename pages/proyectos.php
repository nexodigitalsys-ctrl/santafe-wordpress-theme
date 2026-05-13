<?php
/**
 * Proyectos — Portfolio extraordinário com case studies
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$isCa = $lang === 'ca';
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $isCa ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $isCa ? 'Projectes' : 'Proyectos', 'url' => '/' . $lang . '/' . ($isCa ? 'projectes' : 'proyectos') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $isCa ? 'Projectes de construcció | Santa Fe — Barcelona i Girona' : 'Proyectos de construcción | Santa Fe — Barcelona y Girona',
    'description' => $isCa ? 'Obres reals: reformes integrals, obra nova, pladur, obra pública i civil. Veure resultats i especificacions tècniques.' : 'Obras reales: reformas integrales, obra nueva, pladur, obra pública y civil. Ver resultados y especificaciones técnicas.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . ($isCa ? 'projectes' : 'proyectos') . '/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }],
];

$theme_uri = get_template_directory_uri();

// ── Textos ────────────────────────────────────────────────────────
$t = [
    'hero_h1' => $isCa ? 'Obres que parlen<br>per si soles' : 'Obras que hablan<br>por sí solas',
    'hero_p' => $isCa
        ? 'Més de 500 projectes lliurats a Barcelona, Girona i Tarragona. Cada obra té un desafiament, una solució i un resultat que avala la nostra feina.'
        : 'Más de 500 proyectos entregados en Barcelona, Girona y Tarragona. Cada obra tiene un desafío, una solución y un resultado que avala nuestro trabajo.',
    'hero_cta_whatsapp' => $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h',
    'hero_cta_budget' => $isCa ? 'Solicitar pressupost' : 'Solicitar presupuesto',
    'hero_cta_call' => $isCa ? 'Trucar ara' : 'Llamar ahora',

    'cases_label' => $isCa ? 'PROJECTES DESTACATS' : 'PROYECTOS DESTACADOS',
    'cases_h2' => $isCa ? 'Resultats reals, clients reals' : 'Resultados reales, clientes reales',
    'cases_challenge' => $isCa ? 'Desafiament' : 'Desafío',
    'cases_solution' => $isCa ? 'Solució' : 'Solución',
    'cases_result' => $isCa ? 'Resultat' : 'Resultado',
    'cases_specs' => $isCa ? 'Especificacions' : 'Especificaciones',
    'cases_cta' => $isCa ? 'Veure servei' : 'Ver servicio',

    'gallery_label' => $isCa ? 'MÉS OBRES' : 'MÁS OBRAS',
    'gallery_h2' => $isCa ? 'Galeria de projectes' : 'Galería de proyectos',

    'process_label' => $isCa ? 'EL NOSTRE MÈTODE' : 'NUESTRO MÉTODO',
    'process_h2' => $isCa ? 'Com abordem cada projecte' : 'Cómo abordamos cada proyecto',

    'final_h2' => $isCa ? 'Tens un projecte en ment?' : '¿Tienes un proyecto en mente?',
    'final_p' => $isCa
        ? 'La primera visita és gratuïta. Analitzarem l\'obra, valorarem el desafiament i prepararem un pressupost tancat sense compromís.'
        : 'La primera visita es gratuita. Analizaremos la obra, valoraremos el desafío y prepararemos un presupuesto cerrado sin compromiso.',
    'final_cta_form' => $isCa ? 'Omplir formulari' : 'Rellenar formulario',
    'final_cta_wa' => $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h',
];

// ── Case studies detalhados ───────────────────────────────────────
$case_studies = [
    [
        'img' => $theme_uri . '/assets/images/portfolio/portfolio-obra-nueva-piscina.webp',
        'cat' => $isCa ? 'Obra nova' : 'Obra nueva',
        'cat_slug' => 'obra-nueva',
        'title' => $isCa ? 'Casa amb piscina · Girona · 2024' : 'Casa con piscina · Girona · 2024',
        'challenge' => $isCa ? 'Construcció d\'una vivenda unifamiliar de 220 m² amb piscina i jardí en terreny amb desnivell i accés restringit per camí rural.' : 'Construcción de una vivienda unifamiliar de 220 m² con piscina y jardín en terreno con desnivel y acceso restringido por camino rural.',
        'solution' => $isCa ? 'Planificació per fases: moviment de terres, fonaments, estructura, instal·lacions, piscina i acabats exteriors. Coordinació de 6 gremis diferents sota direcció única.' : 'Planificación por fases: movimiento de tierras, cimentaciones, estructura, instalaciones, piscina y acabados exteriores. Coordinación de 6 gremios diferentes bajo dirección única.',
        'result' => $isCa ? 'Lliurament en 8 mesos. Client satisfet amb acabats i funcionament de la piscina. Garantia de 2 anys en execució i instal·lacions.' : 'Entrega en 8 meses. Cliente satisfecho con acabados y funcionamiento de la piscina. Garantía de 2 años en ejecución e instalaciones.',
        'specs' => [
            $isCa ? '220 m² construïts' : '220 m² construidos',
            $isCa ? '8 mesos de termini' : '8 meses de plazo',
            $isCa ? 'Piscina de 8x4 m' : 'Piscina de 8x4 m',
            $isCa ? '6 gremis coordinats' : '6 gremios coordinados',
        ],
    ],
    [
        'img' => $theme_uri . '/assets/images/portfolio/portfolio-reforma-recepcion.webp',
        'cat' => 'Reforma',
        'cat_slug' => 'reformas-integrales',
        'title' => $isCa ? 'Recepció d\'hotel · Barcelona · 2024' : 'Recepción de hotel · Barcelona · 2024',
        'challenge' => $isCa ? 'Reforma integral d\'espai comercial de 120 m² en edifici històric del centre de Barcelona amb limitacions estructurals i de soroll.' : 'Reforma integral de espacio comercial de 120 m² en edificio histórico del centro de Barcelona con limitaciones estructurales y de ruido.',
        'solution' => $isCa ? 'Desmuntatge controlat, reforç estructural, instal·lacions noves, pladur amb aïllament acústic, i acabats premium amb materials de baix manteniment.' : 'Desmontaje controlado, refuerzo estructural, instalaciones nuevas, pladur con aislamiento acústico, y acabados premium con materiales de bajo mantenimiento.',
        'result' => $isCa ? 'Obra lliurada en 5 setmanes, 2 dies abans del termini. L\'hotel va obrir sense incidències. Acabats impecables i duradors.' : 'Obra entregada en 5 semanas, 2 días antes del plazo. El hotel abrió sin incidencias. Acabados impecables y duraderos.',
        'specs' => [
            $isCa ? '120 m² reformats' : '120 m² reformados',
            $isCa ? '5 setmanes' : '5 semanas',
            $isCa ? 'Aïllament acústic' : 'Aislamiento acústico',
            $isCa ? 'Acabats premium' : 'Acabados premium',
        ],
    ],
    [
        'img' => $theme_uri . '/assets/images/portfolio/portfolio-obra-publica-calzada.webp',
        'cat' => $isCa ? 'Obra pública' : 'Obra pública',
        'cat_slug' => 'obra-publica',
        'title' => $isCa ? 'Pavimentació urbana · Barcelona · 2024' : 'Pavimentación urbana · Barcelona · 2024',
        'challenge' => $isCa ? 'Rehabilitació de 800 m² de calçada urbana amb tràfic rodat constant, aceres deteriorades i mobiliari urbà a reposar.' : 'Rehabilitación de 800 m² de calzada urbana con tráfico rodado constante, aceras deterioradas y mobiliario urbano a reponer.',
        'solution' => $isCa ? 'Execució per fases amb senyalització viària. Pavimentació amb formigó d\'alta resistència, aceres noves amb accessibilitat i mobiliari urbà integrat.' : 'Ejecución por fases con señalización vial. Pavimentación con hormigón de alta resistencia, aceras nuevas con accesibilidad y mobiliario urbano integrado.',
        'result' => $isCa ? 'Entrega dins del termini i pressupost. Certificació de qualitat aprovada per l\'administració. Garantia de reparació de 2 anys.' : 'Entrega dentro del plazo y presupuesto. Certificación de calidad aprobada por la administración. Garantía de reparación de 2 años.',
        'specs' => [
            $isCa ? '800 m² de calçada' : '800 m² de calzada',
            $isCa ? '3 mesos d\'execució' : '3 meses de ejecución',
            $isCa ? 'Documentació completa' : 'Documentación completa',
            $isCa ? 'Certificació aprovada' : 'Certificación aprobada',
        ],
    ],
];

// ── Galeria adicional ─────────────────────────────────────────────
$gallery = [
    ['img' => $theme_uri . '/assets/images/servicios/pladur/pladur-hall-acabado.webp', 'title' => $isCa ? 'Hall residencial · Gràcia · 2024' : 'Hall residencial · Gràcia · 2024', 'cat' => $isCa ? 'Pladur' : 'Pladur'],
    ['img' => $theme_uri . '/assets/images/servicios/obra-publica/obra-civil-bordillo-curva.webp', 'title' => $isCa ? 'Bordillos · Tarragona · 2023' : 'Bordillos · Tarragona · 2023', 'cat' => $isCa ? 'Obra civil' : 'Obra civil'],
    ['img' => $theme_uri . '/assets/images/portfolio/portfolio-reforma-suelo.webp', 'title' => $isCa ? 'Sòl porcelànic · Tarragona · 2023' : 'Suelo porcelánico · Tarragona · 2023', 'cat' => 'Reforma'],
    ['img' => $theme_uri . '/assets/images/portfolio/portfolio-reforma-ducha.webp', 'title' => $isCa ? 'Bany complet · Barcelona · 2024' : 'Baño completo · Barcelona · 2024', 'cat' => 'Reforma'],
    ['img' => $theme_uri . '/assets/images/servicios/obra-publica/obra-publica-calzada-acabada.webp', 'title' => $isCa ? 'Calçada acabada · Barcelona' : 'Calzada acabada · Barcelona', 'cat' => $isCa ? 'Obra pública' : 'Obra pública'],
    ['img' => $theme_uri . '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp', 'title' => $isCa ? 'Jardí i piscina · Girona' : 'Jardín y piscina · Girona', 'cat' => $isCa ? 'Obra nova' : 'Obra nueva'],
];

// ── Proceso em cada projeto ──────────────────────────────────────
$process = [
    ['num' => '01', 'title' => $isCa ? 'Diagnòstic' : 'Diagnóstico', 'desc' => $isCa ? 'Analitzem l\'estat actual, les necessitats i les restriccions tècniques del projecte.' : 'Analizamos el estado actual, las necesidades y las restricciones técnicas del proyecto.'],
    ['num' => '02', 'title' => $isCa ? 'Planificació' : 'Planificación', 'desc' => $isCa ? 'Definim fases, gremis, materials i calendari realista amb marge per imprevistos.' : 'Definimos fases, gremios, materiales y calendario realista con margen para imprevistos.'],
    ['num' => '03', 'title' => $isCa ? 'Execució' : 'Ejecución', 'desc' => $isCa ? 'Coordinació diària, control de qualitat i comunicació constant amb el client.' : 'Coordinación diaria, control de calidad y comunicación constante con el cliente.'],
    ['num' => '04', 'title' => $isCa ? 'Entrega' : 'Entrega', 'desc' => $isCa ? 'Revisió final, neteja, documentació tècnica i garantia per escrit.' : 'Revisión final, limpieza, documentación técnica y garantía por escrito.'],
];

// ── Slugs por idioma ──────────────────────────────────────────────
$slugs = [
    'obra-nueva' => $isCa ? 'obra-nova' : 'obra-nueva',
    'reformas-integrales' => $isCa ? 'reformes-integrals' : 'reformas-integrales',
    'obra-publica' => 'obra-publica',
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
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Portfolio</span>
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
     2. CASE STUDIES
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['cases_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['cases_h2']; ?>
            </h2>
        </div>

        <?php foreach ($case_studies as $i => $case): ?>
        <article class="mb-16 last:mb-0">
            <div class="grid lg:grid-cols-2 gap-8 items-start">
                <!-- Imagem -->
                <div class="relative rounded-sm overflow-hidden bg-slate-800 aspect-[4/3]">
                    <img src="<?php echo $case['img']; ?>"
                         alt="<?php echo htmlspecialchars($case['title'], ENT_QUOTES, 'UTF-8'); ?>"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="absolute top-4 left-4 bg-brand-600 text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-sm">
                        <?php echo $case['cat']; ?>
                    </div>
                </div>
                <!-- Conteúdo -->
                <div class="flex flex-col h-full">
                    <h3 class="font-display font-bold text-2xl md:text-3xl text-white mb-6"><?php echo $case['title']; ?></h3>

                    <div class="space-y-5 flex-1">
                        <div>
                            <p class="text-brand-400 text-xs font-semibold uppercase tracking-wider mb-1"><?php echo $t['cases_challenge']; ?></p>
                            <p class="text-slate-300 leading-relaxed"><?php echo $case['challenge']; ?></p>
                        </div>
                        <div>
                            <p class="text-brand-400 text-xs font-semibold uppercase tracking-wider mb-1"><?php echo $t['cases_solution']; ?></p>
                            <p class="text-slate-300 leading-relaxed"><?php echo $case['solution']; ?></p>
                        </div>
                        <div>
                            <p class="text-brand-400 text-xs font-semibold uppercase tracking-wider mb-1"><?php echo $t['cases_result']; ?></p>
                            <p class="text-slate-300 leading-relaxed"><?php echo $case['result']; ?></p>
                        </div>
                    </div>

                    <!-- Especificações -->
                    <div class="mt-6 pt-6 border-t border-slate-800">
                        <p class="text-brand-400 text-xs font-semibold uppercase tracking-wider mb-3"><?php echo $t['cases_specs']; ?></p>
                        <div class="flex flex-wrap gap-3">
                            <?php foreach ($case['specs'] as $spec): ?>
                            <span class="text-sm bg-slate-800 text-slate-300 px-3 py-1.5 rounded-sm"><?php echo $spec; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Link para serviço -->
                    <div class="mt-6">
                        <a href="/<?php echo $lang; ?>/<?php echo $slugs[$case['cat_slug']] ?? $case['cat_slug']; ?>/"
                           class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold group/link">
                            <?php echo $t['cases_cta']; ?> <span class="transition-transform group-hover/link:translate-x-1">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     3. GALERIA ADICIONAL
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" data-reveal>
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
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($gallery as $g): ?>
            <article class="group relative overflow-hidden rounded-sm aspect-[4/3]">
                <img src="<?php echo $g['img']; ?>"
                     alt="<?php echo htmlspecialchars($g['title'], ENT_QUOTES, 'UTF-8'); ?>"
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
     4. PROCESO EN CADA PROYECTO
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
        <div class="grid md:grid-cols-4 gap-6">
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
     5. CTA FINAL
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
