<?php
/**
 * Sección Paulo / Equipe
 * "Paulo Pereira — Fundador. Capataz en cada obra."
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Paulo Pereira' : 'Paulo Pereira';
$subtitle = $lang === 'ca' ? 'Fundador. Capatàs a cada obra.' : 'Fundador. Capataz en cada obra.';
$bio = $lang === 'ca'
    ? 'No subcontracto la responsabilitat: l\'assumesc jo. Des de la primera visita fins a l\'entrega final, estic al front de cada detall.'
    : 'No subcontrato la responsabilidad: la asumo yo. Desde la primera visita hasta la entrega final, estoy al frente de cada detalle.';

$stats = [
    ['icon' => '📍', 'label' => 'Barcelona / Girona / Tarragona'],
    ['icon' => '📅', 'label' => $lang === 'ca' ? 'Des de 2008' : 'Desde 2008'],
    ['icon' => '🏗️', 'label' => $lang === 'ca' ? '+X projectes lliurats' : '+X proyectos entregados'],
    ['icon' => '⭐', 'label' => $lang === 'ca' ? 'X.X estrelles a Google Reviews' : 'X.X estrellas en Google Reviews'],
];

$cta = $lang === 'ca' ? 'Conèixer a Paulo →' : 'Conocer a Paulo →';
?>

<section class="py-24 md:py-32 bg-slate-900 border-b border-slate-800" id="paulo">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="aspect-[4/5] rounded-sm overflow-hidden bg-slate-800">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/proceso/proceso-colocacion-suelo.webp'); ?>"
                         alt="Equipo Santa Fe trabajando en obra"
                         class="w-full h-full object-cover opacity-90"
                         loading="lazy"
                         onerror="this.src='<?php echo esc_url(get_template_directory_uri() . '/assets/images/fallback-construction.svg'); ?>'">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-brand-600 text-white px-6 py-4 rounded-sm shadow-2xl">
                    <p class="font-display font-bold text-3xl">17</p>
                    <p class="text-xs uppercase tracking-wider opacity-90"><?php echo $lang === 'ca' ? 'Anys de trajectòria' : 'Años de trayectoria'; ?></p>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.about'); ?></span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-2"><?php echo $title; ?></h2>
                <h3 class="font-display font-semibold text-xl text-brand-400 mb-6"><?php echo $subtitle; ?></h3>
                <p class="text-slate-300 text-lg leading-relaxed mb-8"><?php echo $bio; ?></p>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <?php foreach ($stats as $stat): ?>
                    <div class="border-l-2 border-brand-600 pl-4 py-2">
                        <p class="text-2xl mb-1"><?php echo $stat['icon']; ?></p>
                        <p class="text-slate-300 text-sm"><?php echo $stat['label']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <a href="/<?php echo $lang; ?>/sobre-nosotros/" class="inline-flex items-center gap-3 text-brand-500 font-semibold hover:text-brand-400 transition-colors">
                    <?php echo $cta; ?> <span class="text-xl">→</span>
                </a>
            </div>
        </div>
    </div>
</section>
