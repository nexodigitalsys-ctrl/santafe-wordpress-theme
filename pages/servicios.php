<?php
/**
 * Servicios (Landing general) — Tailwind CSS
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $lang === 'ca' ? 'Serveis' : 'Servicios', 'url' => '/' . $lang . '/' . ($lang === 'ca' ? 'serveis' : 'servicios') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Serveis de construcció a Barcelona i Girona | Santa Fe' : 'Servicios de construcción en Barcelona y Girona | Santa Fe',
    'description' => $lang === 'ca' ? 'Obra nova, reformes, pladur, obra pública i civil. Pressupost tancat.' : 'Obra nueva, reformas, pladur, obra pública y civil. Presupuesto cerrado.',
    'canonical' => 'https://www.dominio.com/' . $lang . '/' . ($lang === 'ca' ? 'serveis' : 'servicios') . '/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }]
];

$services = [
    ['slug' => 'obra-nueva', 'title_key' => 'services.new_build', 'desc_key' => 'services.new_build_desc', 'img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&q=80'],
    ['slug' => 'reformas-integrales', 'title_key' => 'services.renovation', 'desc_key' => 'services.renovation_desc', 'img' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&q=80'],
    ['slug' => 'pladur-acabados', 'title_key' => 'services.plaster', 'desc_key' => 'services.plaster_desc', 'img' => 'https://images.unsplash.com/photo-1621905252507-b35492c3f7e1?w=800&q=80'],
    ['slug' => 'obra-publica', 'title_key' => 'services.public', 'desc_key' => 'services.public_desc', 'img' => 'https://images.unsplash.com/photo-1590644365607-1c5a86e9a95b?w=800&q=80'],
    ['slug' => 'obra-civil', 'title_key' => 'services.civil', 'desc_key' => 'services.civil_desc', 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80'],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.services'); ?></span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight">
                <?php echo $lang === 'ca' ? 'Serveis de construcció<br>integral' : 'Servicios de construcción<br>integral'; ?>
            </h1>
            <p class="text-slate-400 mt-6 max-w-xl text-lg">
                <?php echo $lang === 'ca' ? 'Cinc àrees d\'actuació per cobrir totes les teves necessitats.' : 'Cinco áreas de actuación para cubrir todas tus necesidades.'; ?>
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $svc): ?>
            <article class="group relative overflow-hidden rounded-sm bg-slate-900 border border-slate-800 card-lift">
                <div class="aspect-[16/9] overflow-hidden bg-slate-800">
                    <img src="<?php echo $svc['img']; ?>" alt="" class="w-full h-full object-cover img-zoom opacity-80 group-hover:opacity-100 transition-opacity" loading="lazy" onerror="this.src='/assets/images/placeholder-construction.svg'">
                </div>
                <div class="p-6">
                    <h2 class="font-display font-bold text-xl text-white mb-2"><?php echo t($translations, $svc['title_key']); ?></h2>
                    <p class="text-slate-400 text-sm mb-4"><?php echo t($translations, $svc['desc_key']); ?></p>
                    <a href="/<?php echo $lang; ?>/servicios/<?php echo $svc['slug']; ?>/" class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold group/link">
                        <?php echo t($translations, 'services.learn_more'); ?> <span class="transition-transform group-hover/link:translate-x-1">→</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-6">
            <?php echo $lang === 'ca' ? 'No saps quin servei necessites?' : '¿No sabes qué servicio necesitas?'; ?>
        </h2>
        <p class="text-slate-400 mb-10">
            <?php echo $lang === 'ca' ? 'Parla amb en Paulo. T\'assessorarem sense compromís.' : 'Habla con Paulo. Te asesoraremos sin compromiso.'; ?>
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo t($translations, 'cta_section.primary'); ?>
            </a>
            <a href="tel:+34665737547" class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo t($translations, 'cta_section.secondary'); ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
