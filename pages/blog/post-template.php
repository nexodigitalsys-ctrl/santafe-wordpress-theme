<?php
/**
 * Template para artigos do blog
 * Variáveis obrigatórias antes do include:
 *   $post_title, $post_description, $post_date, $post_tag, $post_content (HTML)
 */

declare(strict_types=1);

if (!isset($post_title)) $post_title = '';
if (!isset($post_description)) $post_description = '';
if (!isset($post_date)) $post_date = date('Y-m-d');
if (!isset($post_tag)) $post_tag = 'General';
if (!isset($post_content)) $post_content = '';

$lang = isset($current_lang) ? $current_lang : 'es';
$isCa = $lang === 'ca';

$breadcrumb_items = [
    ['name' => $isCa ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => 'Blog', 'url' => '/' . $lang . '/blog/'],
    ['name' => $post_title, 'url' => ''],
];

$page_data = [
    'lang' => $lang,
    'title' => $post_title . ' | Blog Santa Fe',
    'description' => $post_description,
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/blog/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }],
];

$back_url = '/' . $lang . '/blog/';

include __DIR__ . '/../../includes/header.php';
?>

<section class="pt-32 pb-16 bg-slate-950">
    <div class="max-w-4xl mx-auto px-6">
        <a href="<?php echo $back_url; ?>" class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold mb-8 group">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            <?php echo $isCa ? 'Tornar al blog' : 'Volver al blog'; ?>
        </a>
        <div class="flex items-center gap-4 mb-6">
            <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $post_tag; ?></span>
            <span class="text-slate-600">·</span>
            <span class="text-slate-500 text-sm"><?php echo $post_date; ?></span>
        </div>
        <h1 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight mb-8 leading-[1.1]">
            <?php echo $post_title; ?>
        </h1>
        <p class="text-slate-400 text-lg leading-relaxed mb-10">
            <?php echo $post_description; ?>
        </p>
    </div>
</section>

<section class="pb-24 bg-slate-950">
    <div class="max-w-4xl mx-auto px-6">
        <article class="blog-article max-w-none text-slate-300 leading-relaxed">
            <?php echo $post_content; ?>
        </article>
        <style>
        .blog-article h2 { font-family: var(--font-display); font-weight: 700; font-size: 1.5rem; color: #fff; margin-top: 2.5rem; margin-bottom: 1rem; letter-spacing: -0.02em; }
        .blog-article h3 { font-family: var(--font-display); font-weight: 700; font-size: 1.25rem; color: #e2e8f0; margin-top: 2rem; margin-bottom: 0.75rem; }
        .blog-article p { margin-bottom: 1rem; line-height: 1.75; }
        .blog-article ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .blog-article ol { list-style: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .blog-article li { margin-bottom: 0.5rem; }
        .blog-article strong { color: #fff; font-weight: 600; }
        .blog-article table { width: 100%; font-size: 0.875rem; border: 1px solid #1e293b; border-radius: 0.125rem; overflow: hidden; margin-top: 1rem; margin-bottom: 1.5rem; }
        .blog-article thead { background: #0f172a; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; }
        .blog-article th, .blog-article td { padding: 0.75rem 1rem; border-bottom: 1px solid #1e293b; }
        .blog-article tbody tr:last-child td { border-bottom: none; }
        </style>

        <div class="mt-16 pt-10 border-t border-slate-800">
            <h3 class="font-display font-bold text-2xl text-white mb-4">
                <?php echo $isCa ? '¿Necessites ajuda amb el teu projecte?' : '¿Necesitas ayuda con tu proyecto?'; ?>
            </h3>
            <p class="text-slate-400 mb-6">
                <?php echo $isCa ? 'Contacta amb Paulo per WhatsApp o sol·licita un pressupost tancat gratuït.' : 'Contacta con Paulo por WhatsApp o solicita un presupuesto cerrado gratuito.'; ?>
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20he%20leído%20tu%20artículo%20sobre%20<?php echo urlencode($post_title); ?>"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold px-6 py-3 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <?php echo $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h'; ?>
                </a>
                <a href="/<?php echo $lang; ?>/contacto/"
                   class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-6 py-3 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $isCa ? 'Solicitar pressupost' : 'Solicitar presupuesto'; ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
