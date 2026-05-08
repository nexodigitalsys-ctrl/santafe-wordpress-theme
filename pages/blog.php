<?php
/**
 * Static blog hub for the first SEO content phase.
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : 'es';
$translations = load_translations($lang);

$posts = [
    ['title' => 'Cuánto cuesta reformar un piso en Barcelona', 'desc' => 'Factores que cambian el presupuesto: m², instalaciones, calidades, licencias y estado inicial.', 'tag' => 'Precios'],
    ['title' => 'Licencias para reformas integrales en Cataluña', 'desc' => 'Cuándo hace falta permiso, qué documentación conviene preparar y cómo evitar retrasos.', 'tag' => 'Licencias'],
    ['title' => 'Pladur: cuándo conviene y cuánto cuesta', 'desc' => 'Usos habituales en techos, tabiques, aislamiento acústico y acabados interiores.', 'tag' => 'Pladur'],
    ['title' => 'Errores que encarecen una reforma', 'desc' => 'Decisiones improvisadas, cambios sin documentar y gremios sin coordinación.', 'tag' => 'Reformas'],
];

$page_data = [
    'lang' => $lang,
    'title' => 'Blog de reformas y construcción | Santa Fe Construcciones',
    'description' => 'Guías sobre reformas, obra nueva, pladur, licencias y presupuestos en Cataluña.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/blog/',
    'schemas' => [],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-3xl mb-14">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Blog</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-6xl text-white tracking-tight mb-6">Guías para decidir mejor antes de empezar una obra</h1>
            <p class="text-slate-400 text-lg leading-relaxed">Contenido práctico sobre costes, licencias, plazos y decisiones que conviene cerrar antes de abrir una reforma.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($posts as $post): ?>
            <article class="bg-slate-900 border border-slate-800 rounded-sm p-8">
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.25em]"><?php echo esc_html($post['tag']); ?></span>
                <h2 class="font-display font-bold text-2xl text-white mt-4 mb-3"><?php echo esc_html($post['title']); ?></h2>
                <p class="text-slate-400 leading-relaxed"><?php echo esc_html($post['desc']); ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
