<?php
/**
 * 404 page for unknown Santa Fe routes.
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : 'es';
$translations = load_translations($lang);
$page_data = [
    'lang' => $lang,
    'title' => 'Página no encontrada | Santa Fe Construcciones',
    'description' => 'La página solicitada no existe.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/',
    'schemas' => [],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 min-h-[70vh] bg-slate-950">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <p class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em] mb-4">404</p>
        <h1 class="font-display font-bold text-4xl md:text-6xl text-white tracking-tight mb-6">Página no encontrada</h1>
        <p class="text-slate-400 text-lg mb-10">La ruta que buscas no está disponible o ha cambiado.</p>
        <a href="/<?php echo $lang; ?>/" class="inline-flex items-center bg-brand-600 hover:bg-brand-500 text-slate-950 font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">Volver al inicio</a>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
