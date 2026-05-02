<?php
/**
 * Sobre Nosotros — Tailwind CSS
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $lang === 'ca' ? 'Sobre nosaltres' : 'Sobre nosotros', 'url' => '/' . $lang . '/' . ($lang === 'ca' ? 'sobre-nosaltres' : 'sobre-nosotros') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Sobre Construccions Santa Fe | Paulo des de 2008' : 'Sobre Construcciones Santa Fe | Paulo desde 2008',
    'description' => $lang === 'ca' ? 'Coneix en Paulo. Més de 15 anys construint confiança a Barcelona i Girona.' : 'Conoce a Paulo. Más de 15 años construyendo confianza en Barcelona y Girona.',
    'canonical' => 'https://www.dominio.com/' . $lang . '/' . ($lang === 'ca' ? 'sobre-nosaltres' : 'sobre-nosotros') . '/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }]
];

$values = [
    ['title' => $lang === 'ca' ? 'Compromís' : 'Compromiso', 'desc' => $lang === 'ca' ? 'Cada projecte és personal. Paulo està a cada obra.' : 'Cada proyecto es personal. Paulo está en cada obra.'],
    ['title' => $lang === 'ca' ? 'Transparència' : 'Transparencia', 'desc' => $lang === 'ca' ? 'Pressupost tancat, cronograma visible i informes setmanals.' : 'Presupuesto cerrado, cronograma visible e informes semanales.'],
    ['title' => $lang === 'ca' ? 'Qualitat' : 'Calidad', 'desc' => $lang === 'ca' ? 'Materials de primera, acabats impecables i garantia per escrit.' : 'Materiales de primera, acabados impecables y garantía por escrito.'],
    ['title' => $lang === 'ca' ? 'Puntualitat' : 'Puntualidad', 'desc' => $lang === 'ca' ? 'El termini que signem és el termini que complem.' : 'El plazo que firmamos es el plazo que cumplimos.'],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.about'); ?></span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight">
                <?php echo $lang === 'ca' ? 'Construccions Santa Fe:<br>15 anys de confiança' : 'Construcciones Santa Fe:<br>15 años de confianza'; ?>
            </h1>
        </div>

        <div class="grid lg:grid-cols-2 gap-16 items-center mb-24">
            <div class="relative">
                <div class="aspect-[4/5] rounded-sm overflow-hidden bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="Paulo en obra" class="w-full h-full object-cover opacity-90" loading="lazy" onerror="this.src='/assets/images/placeholder-construction.svg'">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-brand-600 text-white px-6 py-4 rounded-sm shadow-2xl">
                    <p class="font-display font-bold text-3xl">17</p>
                    <p class="text-xs uppercase tracking-wider opacity-90"><?php echo $lang === 'ca' ? 'Anys de trajectòria' : 'Años de trayectoria'; ?></p>
                </div>
            </div>
            <div>
                <h2 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight mb-6">
                    <?php echo $lang === 'ca' ? 'Paulo està a cada obra.<br>No a cada reunió.' : 'Paulo está en cada obra.<br>No en cada reunión.'; ?>
                </h2>
                <p class="text-slate-300 text-lg leading-relaxed mb-4"><?php echo t($translations, 'story.text1'); ?></p>
                <p class="text-slate-400 leading-relaxed mb-8"><?php echo t($translations, 'story.text2'); ?></p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="border-l-2 border-brand-600 pl-4">
                        <p class="font-display font-bold text-2xl text-white">100%</p>
                        <p class="text-slate-400 text-sm"><?php echo $lang === 'ca' ? 'Terminis complerts' : 'Plazos cumplidos'; ?></p>
                    </div>
                    <div class="border-l-2 border-brand-600 pl-4">
                        <p class="font-display font-bold text-2xl text-white">200+</p>
                        <p class="text-slate-400 text-sm"><?php echo $lang === 'ca' ? 'Projectes acabats' : 'Proyectos terminados'; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values -->
        <div class="mb-16">
            <div class="flex items-center gap-4 mb-10">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'Els nostres valors' : 'Nuestros valores'; ?></span>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($values as $value): ?>
                <div class="bg-slate-900 border border-slate-800 rounded-sm p-6">
                    <h3 class="font-display font-bold text-xl text-white mb-3"><?php echo htmlspecialchars($value['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="text-slate-400 text-sm"><?php echo htmlspecialchars($value['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
