<?php
/**
 * Proyectos / Galería — Tailwind CSS
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $lang === 'ca' ? 'Projectes' : 'Proyectos', 'url' => '/' . $lang . '/' . ($lang === 'ca' ? 'projectes' : 'proyectos') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Projectes de construcció a Barcelona i Girona | Santa Fe' : 'Proyectos de construcción en Barcelona y Girona | Santa Fe',
    'description' => $lang === 'ca' ? 'Galeria de projectes realitzats: obra nova, reformes, obra pública i civil.' : 'Galería de proyectos realizados: obra nueva, reformas, obra pública y civil.',
    'canonical' => 'https://www.dominio.com/' . $lang . '/' . ($lang === 'ca' ? 'projectes' : 'proyectos') . '/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }]
];

$projects = [
    ['img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=1200&q=80', 'title' => $lang === 'ca' ? 'Casa unifamiliar · Girona' : 'Casa unifamiliar · Girona', 'desc' => $lang === 'ca' ? 'Obra nova completa amb jardí de 200m² · 2024' : 'Obra nueva completa con jardín de 200m² · 2024', 'cat' => $lang === 'ca' ? 'Obra nova' : 'Obra nueva', 'span' => 'md:col-span-2 lg:col-span-2'],
    ['img' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80', 'title' => 'Reforma integral · Eixample', 'desc' => $lang === 'ca' ? 'Pis de 120m² · 2024' : 'Piso de 120m² · 2024', 'cat' => $lang === 'ca' ? 'Reforma' : 'Reforma', 'span' => ''],
    ['img' => 'https://images.unsplash.com/photo-1590644365607-1c5a86e9a95b?w=600&q=80', 'title' => $lang === 'ca' ? 'Infraestructura municipal' : 'Infraestructura municipal', 'desc' => 'Barcelona · 2023', 'cat' => $lang === 'ca' ? 'Obra pública' : 'Obra pública', 'span' => ''],
    ['img' => 'https://images.unsplash.com/photo-1621905252507-b35492c3f7e1?w=800&q=80', 'title' => $lang === 'ca' ? 'Sostres decoratius · Barcelona' : 'Techos decorativos · Barcelona', 'desc' => $lang === 'ca' ? 'Pladur i il·luminació LED · 2024' : 'Pladur e iluminación LED · 2024', 'cat' => $lang === 'ca' ? 'Acabats' : 'Acabados', 'span' => 'md:col-span-2'],
    ['img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=600&q=80', 'title' => $lang === 'ca' ? 'Fonamentacions · Girona' : 'Cimentaciones · Girona', 'desc' => $lang === 'ca' ? 'Edifici plurifamiliar · 2023' : 'Edificio plurifamiliar · 2023', 'cat' => $lang === 'ca' ? 'Obra civil' : 'Obra civil', 'span' => ''],
    ['img' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80', 'title' => $lang === 'ca' ? 'Local comercial · Barcelona' : 'Local comercial · Barcelona', 'desc' => $lang === 'ca' ? 'Transformació en restaurant · 2024' : 'Transformación en restaurante · 2024', 'cat' => $lang === 'ca' ? 'Reforma' : 'Reforma', 'span' => ''],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Portfolio</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight">
                <?php echo $lang === 'ca' ? 'Obres que<br>resisteixen el temps' : 'Obras que<br>resisten el tiempo'; ?>
            </h1>
            <p class="text-slate-400 mt-6 max-w-xl text-lg">
                <?php echo $lang === 'ca' ? 'Resultats reals de la nostra trajectòria.' : 'Resultados reales de nuestra trayectoria.'; ?>
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($projects as $proy): ?>
            <article class="group relative overflow-hidden rounded-sm aspect-[4/3] <?php echo $proy['span']; ?> cursor-pointer">
                <img src="<?php echo $proy['img']; ?>" alt="<?php echo htmlspecialchars($proy['title'], ENT_QUOTES, 'UTF-8'); ?>" class="w-full h-full object-cover img-zoom" loading="lazy" onerror="this.src='/assets/images/placeholder-construction.svg'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-widest mb-2 block"><?php echo htmlspecialchars($proy['cat'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <h3 class="font-display font-bold text-xl text-white mb-1"><?php echo htmlspecialchars($proy['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="text-slate-300 text-sm"><?php echo htmlspecialchars($proy['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-6"><?php echo t($translations, 'cta_section.title'); ?></h2>
        <p class="text-slate-400 mb-10"><?php echo t($translations, 'cta_section.subtitle'); ?></p>
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
