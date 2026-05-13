<?php
/**
 * Sección Sobre Nosotros — Empresa Santa Fe
 * Foto: obra-nueva-piscina-acabada-jardin.webp (serviço top)
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Santa Fe Construcciones' : 'Santa Fe Construcciones';
$subtitle = $lang === 'ca' ? 'Construïm amb rigor des de 2008.' : 'Construimos con rigor desde 2008.';

$bio = $lang === 'ca'
    ? 'Som una empresa de construcció amb seu a Barcelona i més de 17 anys d\'experiència. Realitzem obres noves, reformes integrals, pladur, obra pública i obra civil a Barcelona, Girona i Tarragona.

El que ens diferencia és que no subcontractem la direcció: el capatàs està a cada obra des del primer dia. Pressupost tancat, calendari realista i fotos setmanals. Els nostres clients saben sempre on estem.

La qualitat dels acabats és el nostre aval. Murs, fonaments, cuines, banys, piscines — tot amb els mateixos estàndards. Si alguna cosa no està bé, ho arreglem. Sense excuses.'
    : 'Somos una empresa de construcción con sede en Barcelona y más de 17 años de experiencia. Realizamos obras nuevas, reformas integrales, pladur, obra pública y obra civil en Barcelona, Girona y Tarragona.

Lo que nos diferencia es que no subcontratamos la dirección: el capataz está en cada obra desde el primer día. Presupuesto cerrado, calendario realista y fotos semanales. Nuestros clientes saben siempre dónde estamos.

La calidad de los acabados es nuestro aval. Muros, cimientos, cocinas, baños, piscinas — todo con los mismos estándares. Si algo no está bien, lo arreglamos. Sin excusas.';

$stats = [
    ['number' => '500+', 'label' => $lang === 'ca' ? 'Obres lliurades' : 'Obras entregadas'],
    ['number' => '17', 'label' => $lang === 'ca' ? 'Anys d\'experiència' : 'Años de experiencia'],
    ['number' => '50+', 'label' => $lang === 'ca' ? 'Col·laboradors' : 'Colaboradores'],
    ['number' => '3', 'label' => $lang === 'ca' ? 'Províncies' : 'Provincias'],
];

$values_title = $lang === 'ca' ? 'Els nostres valors' : 'Nuestros valores';
$values = $lang === 'ca' ? [
    ['name' => 'Qualitat', 'desc' => 'Acabats que aguanten el pas del temps.'],
    ['name' => 'Termini', 'desc' => 'Complim les dates que prometem.'],
    ['name' => 'Transparència', 'desc' => 'Pressupost tancat, sense sorpreses.'],
    ['name' => 'Seguretat', 'desc' => 'Equip protegit i obra assegurada.'],
] : [
    ['name' => 'Calidad', 'desc' => 'Acabados que aguantan el paso del tiempo.'],
    ['name' => 'Plazo', 'desc' => 'Cumplimos las fechas que prometemos.'],
    ['name' => 'Transparencia', 'desc' => 'Presupuesto cerrado, sin sorpresas.'],
    ['name' => 'Seguridad', 'desc' => 'Equipo protegido y obra asegurada.'],
];

$cta = $lang === 'ca' ? 'Saber-ne més →' : 'Saber más →';
?>

<section data-reveal class="py-24 md:py-32 bg-slate-900 border-b border-slate-800" id="sobre-nosotros">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Foto TOP: piscina con jardín acabada -->
            <div class="relative order-2 lg:order-1">
                <div class="aspect-[4/5] rounded-sm overflow-hidden bg-slate-800">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/servicios/obra-nueva/obra-nueva-piscina-acabada-jardin.webp'); ?>"
                         alt="<?php echo $lang === 'ca' ? 'Obra nova amb piscina i jardí — Santa Fe Construcciones' : 'Obra nueva con piscina y jardín — Santa Fe Construcciones'; ?>"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.src='<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero/hero-piscina-jardin.webp'); ?>'">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-brand-600 text-white px-6 py-4 rounded-sm shadow-2xl">
                    <p class="font-display font-bold text-3xl">500+</p>
                    <p class="text-xs uppercase tracking-wider opacity-90"><?php echo $lang === 'ca' ? 'Obres lliurades' : 'Obras entregadas'; ?></p>
                </div>
            </div>

            <!-- Contenido -->
            <div class="order-1 lg:order-2">
                <div class="flex items-center gap-4 mb-6">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.about'); ?></span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-2"><?php echo $title; ?></h2>
                <h3 class="font-display font-semibold text-xl text-brand-400 mb-6"><?php echo $subtitle; ?></h3>

                <?php foreach (explode("\n\n", $bio) as $paragraph): ?>
                <p class="text-slate-300 text-lg leading-relaxed mb-5"><?php echo nl2br(htmlspecialchars($paragraph)); ?></p>
                <?php endforeach; ?>

                <!-- Stats -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8 mt-8">
                    <?php foreach ($stats as $stat): ?>
                    <div class="border-l-2 border-brand-600 pl-4 py-2">
                        <p class="font-display font-bold text-2xl md:text-3xl text-brand-500"><?php echo $stat['number']; ?></p>
                        <p class="text-slate-400 text-sm"><?php echo $stat['label']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Valores -->
                <div class="mb-8">
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider"><?php echo $values_title; ?></h4>
                    <div class="grid grid-cols-2 gap-3">
                        <?php foreach ($values as $value): ?>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-brand-500 mt-2 shrink-0"></div>
                            <div>
                                <p class="text-white font-medium text-sm"><?php echo $value['name']; ?></p>
                                <p class="text-slate-500 text-xs"><?php echo $value['desc']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <a href="/<?php echo $lang; ?>/sobre-nosotros/" class="inline-flex items-center gap-3 text-brand-500 font-semibold hover:text-brand-400 transition-colors">
                    <?php echo $cta; ?> <span class="text-xl">→</span>
                </a>
            </div>
        </div>
    </div>
</section>
