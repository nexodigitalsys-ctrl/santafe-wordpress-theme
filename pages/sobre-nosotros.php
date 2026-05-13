<?php
/**
 * Sobre Nosotros — Extraordinária
 * EEAT: Experience, Expertise, Authoritativeness, Trustworthiness
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$isCa = $lang === 'ca';
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $isCa ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $isCa ? 'Sobre nosaltres' : 'Sobre nosotros', 'url' => '/' . $lang . '/' . ($isCa ? 'sobre-nosaltres' : 'sobre-nosotros') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $isCa ? 'Sobre Construccions Santa Fe | Paulo des de 2008' : 'Sobre Construcciones Santa Fe | Paulo desde 2008',
    'description' => $isCa ? 'Paulo construeix des de 2008. Més de 500 obres lliurades a Barcelona, Girona i Tarragona. Pressupost tancat i seguiment directe.' : 'Paulo construye desde 2008. Más de 500 obras entregadas en Barcelona, Girona y Tarragona. Presupuesto cerrado y seguimiento directo.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . ($isCa ? 'sobre-nosaltres' : 'sobre-nosotros') . '/',
    'schemas' => [
        function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); },
        function() use ($isCa) {
            return json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'Construcciones Santa Fe Siglo XXI S.L.U.',
                'url' => COMPANY_DOMAIN,
                'logo' => COMPANY_DOMAIN . '/assets/images/logo-santa-fe.webp',
                'founder' => [
                    '@type' => 'Person',
                    'name' => 'Paulo',
                    'jobTitle' => $isCa ? 'Cap de construcció' : 'Jefe de construcción',
                ],
                'foundingDate' => '2008',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Barcelona',
                    'addressRegion' => 'Cataluña',
                    'addressCountry' => 'ES',
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => COMPANY_PHONE,
                    'contactType' => 'sales',
                    'areaServed' => 'ES',
                    'availableLanguage' => ['Spanish', 'Catalan'],
                ],
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        },
    ],
];

$theme_uri = get_template_directory_uri();

// ── Textos ────────────────────────────────────────────────────────
$t = [
    'hero_h1' => $isCa ? 'Construïm confiança<br>des de 2008' : 'Construimos confianza<br>desde 2008',
    'hero_p' => $isCa
        ? 'Paulo no està a cada reunió. Està a cada obra. Més de 500 projectes lliurats amb pressupost tancat i seguiment directe.'
        : 'Paulo no está en cada reunión. Está en cada obra. Más de 500 proyectos entregados con presupuesto cerrado y seguimiento directo.',

    'stats_years' => $isCa ? 'Anys d\'experiència' : 'Años de experiencia',
    'stats_works' => $isCa ? 'Obres lliurades' : 'Obras entregadas',
    'stats_clients' => $isCa ? 'Clients satisfets' : 'Clientes satisfechos',
    'stats_guarantee' => $isCa ? 'Anys de garantia' : 'Años de garantía',

    'who_label' => $isCa ? 'QUI SÓM' : 'QUIÉNES SOMOS',
    'who_h2' => $isCa ? 'Paulo està a cada obra.<br>No a cada reunió.' : 'Paulo está en cada obra.<br>No en cada reunión.',
    'who_p1' => $isCa
        ? 'Santa Fe Construcciones va néixer el 2008 amb una idea clara: fer les coses bé des del primer dia. No venem projectes que després subcontractem. Coordinem directament cada fase de l\'obra, des del primer cop de pic fins a l\'últim detall d\'acabat.'
        : 'Santa Fe Construcciones nació en 2008 con una idea clara: hacer las cosas bien desde el primer día. No vendemos proyectos que luego subcontratamos. Coordinamos directamente cada fase de la obra, desde el primer golpe de pico hasta el último detalle de acabado.',
    'who_p2' => $isCa
        ? 'La nostra diferència és simple: Paulo revisa personalment cada obra. Coneix els gremis, els materials i els imprevistos que poden sorgir. Això evita sorpreses, retards i costos ocults que acaben pagant els clients.'
        : 'Nuestra diferencia es simple: Paulo revisa personalmente cada obra. Conoce los gremios, los materiales y los imprevistos que pueden surgir. Esto evita sorpresas, retrasos y costos ocultos que acaban pagando los clientes.',
    'who_p3' => $isCa
        ? 'Treballem amb pressupost tancat. El preu que firmem és el que pagues. I si apareix alguna cosa no prevista, t\'ho diem abans de fer-ho, no després de facturar-ho.'
        : 'Trabajamos con presupuesto cerrado. El precio que firmamos es el que pagas. Y si aparece algo no previsto, te lo decimos antes de hacerlo, no después de facturarlo.',

    'timeline_label' => $isCa ? 'LA NOSTRA TRAJECTÒRIA' : 'NUESTRA TRAYECTORIA',
    'timeline_h2' => $isCa ? 'De les primeres obres als projectes d\'avui' : 'De las primeras obras a los proyectos de hoy',

    'eeat_label' => $isCa ? 'PER QUÈ CONFIA EN NOSALTRES' : 'POR QUÉ CONFIAR EN NOSOTROS',
    'eeat_h2' => $isCa ? 'El que ens avala' : 'Lo que nos avala',

    'values_label' => $isCa ? 'ELS NOSTRES VALORS' : 'NUESTROS VALORES',
    'values_h2' => $isCa ? 'Com treballem cada dia' : 'Cómo trabajamos cada día',

    'final_h2' => $isCa ? 'Vols conèixer-nos?' : '¿Quieres conocernos?',
    'final_p' => $isCa
        ? 'La primera visita és gratuïta i sense compromís. Parlarem del teu projecte i et direm si som l\'equip adequat.'
        : 'La primera visita es gratuita y sin compromiso. Hablaremos de tu proyecto y te diremos si somos el equipo adecuado.',
    'final_cta_form' => $isCa ? 'Omplir formulari' : 'Rellenar formulario',
    'final_cta_wa' => $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h',
];

// ── Timeline ──────────────────────────────────────────────────────
$timeline = [
    ['year' => '2008', 'title' => $isCa ? 'Inicis' : 'Inicios', 'desc' => $isCa ? 'Paulo comença amb obres petites a Barcelona. Aprenentatge de gremis, materials i gestió de clients.' : 'Paulo comienza con obras pequeñas en Barcelona. Aprendizaje de gremios, materiales y gestión de clientes.'],
    ['year' => '2012', 'title' => $isCa ? 'Primera obra integral' : 'Primera obra integral', 'desc' => $isCa ? 'Primera reforma integral completa: desmuntatge, instal·lacions, acabats i entrega clau en mà.' : 'Primera reforma integral completa: desmontaje, instalaciones, acabados y entrega llave en mano.'],
    ['year' => '2015', 'title' => $isCa ? 'Ampliació a Girona' : 'Ampliación a Girona', 'desc' => $isCa ? 'Els clients recomanen. Ampliem radi d\'actuació a Girona i Costa Brava amb equip propi.' : 'Los clientes recomiendan. Ampliamos radio de acción a Girona y Costa Brava con equipo propio.'],
    ['year' => '2018', 'title' => $isCa ? 'Obra pública i civil' : 'Obra pública y civil', 'desc' => $isCa ? 'Incorporem obra pública i civil: pavimentació, aceres, cimentacions i infraestructures.' : 'Incorporamos obra pública y civil: pavimentación, aceras, cimentaciones e infraestructuras.'],
    ['year' => '2021', 'title' => $isCa ? '500 obres lliurades' : '500 obras entregadas', 'desc' => $isCa ? 'Superem les 500 obres acabades. Més de 100 reformes integrals, 50 obres noves i desenes d\'obres públiques.' : 'Superamos las 500 obras terminadas. Más de 100 reformas integrales, 50 obras nuevas y decenas de obras públicas.'],
    ['year' => '2024', 'title' => $isCa ? 'Santa Fe avui' : 'Santa Fe hoy', 'desc' => $isCa ? 'Equip consolidat, processos optimitzats i mateixa filosofia: obra ben feta, preu tancat i client informat.' : 'Equipo consolidado, procesos optimizados y misma filosofía: obra bien hecha, precio cerrado y cliente informado.'],
];

// ── EEAT signals ─────────────────────────────────────────────────
$eeat = [
    ['icon' => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5', 'title' => $isCa ? 'Experiència real' : 'Experiencia real', 'desc' => $isCa ? '17 anys i més de 500 obres. No som novells que aprenen amb el teu projecte.' : '17 años y más de 500 obras. No somos novatos que aprenden con tu proyecto.'],
    ['icon' => 'M22 11.08V12a10 10 0 1 1-5.93-9.14', 'title' => $isCa ? 'Seguiment directe' : 'Seguimiento directo', 'desc' => $isCa ? 'Paulo coordina personalment. No hi ha comercials ni intermediaris entre tu i l\'obra.' : 'Paulo coordina personalmente. No hay comerciales ni intermediarios entre tú y la obra.'],
    ['icon' => 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z', 'title' => $isCa ? 'Pressupost per escrit' : 'Presupuesto por escrito', 'desc' => $isCa ? 'Cada partida detallada, cada material especificat. El que firmem és el que pagues.' : 'Cada partida detallada, cada material especificado. Lo que firmamos es lo que pagas.'],
    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => $isCa ? 'Garantia de 2 anys' : 'Garantía de 2 años', 'desc' => $isCa ? 'Tota la nostra execució té garantia per escrit. Segur de responsabilitat civil inclosa.' : 'Toda nuestra ejecución tiene garantía por escrito. Seguro de responsabilidad civil incluido.'],
];

// ── Valores ───────────────────────────────────────────────────────
$values = [
    ['title' => $isCa ? 'Compromís' : 'Compromiso', 'desc' => $isCa ? 'Cada projecte és personal. Paulo està a cada obra, no només al despatx.' : 'Cada proyecto es personal. Paulo está en cada obra, no solo en la oficina.'],
    ['title' => $isCa ? 'Transparència' : 'Transparencia', 'desc' => $isCa ? 'Pressupost tancat, cronograma visible i informes setmanals. Res a amagar.' : 'Presupuesto cerrado, cronograma visible e informes semanales. Nada que esconder.'],
    ['title' => $isCa ? 'Qualitat' : 'Calidad', 'desc' => $isCa ? 'Materials de primera, acabats impecables i atenció als detalls que altres ignoren.' : 'Materiales de primera, acabados impecables y atención a los detalles que otros ignoran.'],
    ['title' => $isCa ? 'Puntualitat' : 'Puntualidad', 'desc' => $isCa ? 'El termini que signem és el termini que complem. Si hi ha imprevistos, t\'ho comuniquem.' : 'El plazo que firmamos es el plazo que cumplimos. Si hay imprevistos, te lo comunicamos.'],
];

include __DIR__ . '/../includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════════════
     1. HERO + STATS
     ═══════════════════════════════════════════════════════════════ -->
<section class="pt-32 pb-20 md:pb-28 bg-slate-950 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-px bg-brand-500/40"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="max-w-4xl mb-16">
            <div class="flex items-center gap-4 mb-6">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $isCa ? 'SOBRE NOSALTRES' : 'SOBRE NOSOTROS'; ?></span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight mb-6 leading-[1.1]">
                <?php echo $t['hero_h1']; ?>
            </h1>
            <p class="text-slate-300 text-lg md:text-xl leading-relaxed max-w-2xl mb-10">
                <?php echo $t['hero_p']; ?>
            </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-slate-900/50 border border-slate-800 rounded-sm p-6 text-center">
                <p class="font-display font-bold text-3xl md:text-4xl text-brand-500">17+</p>
                <p class="text-slate-400 text-sm mt-1"><?php echo $t['stats_years']; ?></p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800 rounded-sm p-6 text-center">
                <p class="font-display font-bold text-3xl md:text-4xl text-brand-500">500+</p>
                <p class="text-slate-400 text-sm mt-1"><?php echo $t['stats_works']; ?></p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800 rounded-sm p-6 text-center">
                <p class="font-display font-bold text-3xl md:text-4xl text-brand-500">350+</p>
                <p class="text-slate-400 text-sm mt-1"><?php echo $t['stats_clients']; ?></p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800 rounded-sm p-6 text-center">
                <p class="font-display font-bold text-3xl md:text-4xl text-brand-500">2</p>
                <p class="text-slate-400 text-sm mt-1"><?php echo $t['stats_guarantee']; ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     2. QUIÉN ES SANTA FE
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div class="relative">
                <div class="aspect-[4/3] rounded-sm overflow-hidden bg-slate-800">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/proceso/proceso-instalacion-azulejos.webp'); ?>"
                         alt="<?php echo $isCa ? 'Equip Santa Fe treballant en obra' : 'Equipo Santa Fe trabajando en obra'; ?>"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.style.display='none'">
                </div>
                <div class="absolute -bottom-4 -right-4 bg-brand-600 text-white px-5 py-3 rounded-sm shadow-xl">
                    <p class="font-display font-bold text-2xl">2008</p>
                    <p class="text-xs uppercase tracking-wider opacity-90"><?php echo $isCa ? 'Any de fundació' : 'Año de fundación'; ?></p>
                </div>
            </div>
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['who_label']; ?></span>
                </div>
                <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-8">
                    <?php echo $t['who_h2']; ?>
                </h2>
                <div class="space-y-5 text-slate-300 leading-relaxed text-lg">
                    <p><?php echo $t['who_p1']; ?></p>
                    <p><?php echo $t['who_p2']; ?></p>
                    <div class="bg-brand-600/10 border-l-4 border-brand-600 p-6 rounded-r-sm">
                        <p class="text-white font-semibold italic"><?php echo $t['who_p3']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     3. TIMELINE
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" data-reveal>
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['timeline_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['timeline_h2']; ?>
            </h2>
        </div>
        <div class="relative">
            <!-- Linha vertical -->
            <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-px bg-slate-800 md:-translate-x-px"></div>
            <?php foreach ($timeline as $i => $event): ?>
            <?php $isEven = $i % 2 === 0; ?>
            <div class="relative mb-12 last:mb-0">
                <!-- Ponto -->
                <div class="absolute left-4 md:left-1/2 w-3 h-3 bg-brand-500 rounded-full border-2 border-slate-950 -translate-x-1.5 mt-1.5 z-10"></div>

                <!-- Mobile: sempre direita -->
                <div class="pl-10 md:hidden">
                    <p class="font-display font-bold text-2xl text-brand-500 mb-1"><?php echo $event['year']; ?></p>
                    <h3 class="font-display font-bold text-lg text-white mb-1"><?php echo $event['title']; ?></h3>
                    <p class="text-slate-400 text-sm leading-relaxed"><?php echo $event['desc']; ?></p>
                </div>

                <!-- Desktop: alternância -->
                <div class="hidden md:flex items-start">
                    <?php if ($isEven): ?>
                    <!-- Esquerda -->
                    <div class="w-1/2 pr-12 text-right">
                        <p class="font-display font-bold text-3xl text-brand-500 mb-1"><?php echo $event['year']; ?></p>
                        <h3 class="font-display font-bold text-xl text-white mb-2"><?php echo $event['title']; ?></h3>
                        <p class="text-slate-400 text-sm leading-relaxed"><?php echo $event['desc']; ?></p>
                    </div>
                    <div class="w-1/2 pl-12"></div>
                    <?php else: ?>
                    <!-- Direita -->
                    <div class="w-1/2 pr-12"></div>
                    <div class="w-1/2 pl-12">
                        <p class="font-display font-bold text-3xl text-brand-500 mb-1"><?php echo $event['year']; ?></p>
                        <h3 class="font-display font-bold text-xl text-white mb-2"><?php echo $event['title']; ?></h3>
                        <p class="text-slate-400 text-sm leading-relaxed"><?php echo $event['desc']; ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     4. EEAT SIGNALS
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['eeat_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['eeat_h2']; ?>
            </h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($eeat as $item): ?>
            <div class="bg-slate-950 border border-slate-800 rounded-sm p-6 text-center">
                <svg class="w-10 h-10 text-brand-500 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo $item['icon']; ?>"/></svg>
                <h3 class="font-display font-bold text-lg text-white mb-2"><?php echo $item['title']; ?></h3>
                <p class="text-slate-400 text-sm leading-relaxed"><?php echo $item['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     5. VALORES
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-24 md:py-32 bg-slate-950" data-reveal>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $t['values_label']; ?></span>
                <div class="industrial-line w-12"></div>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight">
                <?php echo $t['values_h2']; ?>
            </h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($values as $value): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-sm p-6">
                <h3 class="font-display font-bold text-xl text-white mb-3"><?php echo $value['title']; ?></h3>
                <p class="text-slate-400 text-sm leading-relaxed"><?php echo $value['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     6. CTA FINAL
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
            <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20estoy%20interesado%20en%20conocer%20más%20sobre%20Santa%20Fe"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <?php echo $t['final_cta_wa']; ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
