<?php
/**
 * Home con Tailwind CSS Ã¢â‚¬â€ DiseÃƒÂ±o industrial premium
 * Hero + Stats + Servicios + Historia + Proyectos + Testimonios + CTA
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
require_once __DIR__ . '/../includes/i18n.php';
$translations = load_translations($lang);

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Empresa de reformes i obra nova a Barcelona i Girona | Santa Fe' : 'Empresa de reformas y obra nueva en Barcelona y Girona | Santa Fe',
    'description' => $lang === 'ca' ? 'Construccions Santa Fe: obra nova, reformes integrals i obra publica a Barcelona i Girona amb pressupost clar, criteri tecnic i seguiment d obra.' : 'Construcciones Santa Fe: obra nueva, reformas integrales y obra publica en Barcelona y Girona con presupuesto claro, criterio tecnico y seguimiento de obra.',
    'canonical' => 'https://www.dominio.com/' . $lang . '/',
    'schemas' => []
];

// Datos
$services = [
    ['slug' => 'obra-nueva', 'icon' => '<path d="M3 21h18M5 21V7l8-4 8 4v14M9 21v-8h6v8"/>', 'title_key' => 'services.new_build', 'desc_key' => 'services.new_build_desc', 'img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=600&q=80'],
    ['slug' => 'reformas-integrales', 'icon' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>', 'title_key' => 'services.renovation', 'desc_key' => 'services.renovation_desc', 'img' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80'],
    ['slug' => 'pladur-acabados', 'icon' => '<rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/>', 'title_key' => 'services.plaster', 'desc_key' => 'services.plaster_desc', 'img' => 'https://images.unsplash.com/photo-1621905252507-b35492c3f7e1?w=600&q=80'],
    ['slug' => 'obra-publica', 'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>', 'title_key' => 'services.public', 'desc_key' => 'services.public_desc', 'img' => 'https://images.unsplash.com/photo-1590644365607-1c5a86e9a95b?w=600&q=80'],
    ['slug' => 'obra-civil', 'icon' => '<path d="M2 20h20M2 16h20M2 12h20M2 8h20M2 4h20"/>', 'title_key' => 'services.civil', 'desc_key' => 'services.civil_desc', 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=600&q=80'],
];

$projects = [
    ['img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=1200&q=80', 'title' => $lang === 'ca' ? 'Casa unifamiliar Ã‚Â· Girona' : 'Casa unifamiliar Ã‚Â· Girona', 'desc' => $lang === 'ca' ? 'Obra nova completa amb jardÃƒÂ­ de 200mÃ‚Â² Ã‚Â· 2024' : 'Obra nueva completa con jardÃƒÂ­n de 200mÃ‚Â² Ã‚Â· 2024', 'cat' => $lang === 'ca' ? 'Obra nova' : 'Obra nueva', 'span' => 'md:col-span-2 lg:col-span-2'],
    ['img' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80', 'title' => $lang === 'ca' ? 'Reforma integral Ã‚Â· Eixample' : 'Reforma integral Ã‚Â· Eixample', 'desc' => $lang === 'ca' ? 'Pis de 120mÃ‚Â² Ã‚Â· 2024' : 'Piso de 120mÃ‚Â² Ã‚Â· 2024', 'cat' => $lang === 'ca' ? 'Reforma' : 'Reforma', 'span' => ''],
    ['img' => 'https://images.unsplash.com/photo-1590644365607-1c5a86e9a95b?w=600&q=80', 'title' => $lang === 'ca' ? 'Infraestructura municipal' : 'Infraestructura municipal', 'desc' => 'Barcelona Ã‚Â· 2023', 'cat' => $lang === 'ca' ? 'Obra pÃƒÂºblica' : 'Obra pÃƒÂºblica', 'span' => ''],
    ['img' => 'https://images.unsplash.com/photo-1621905252507-b35492c3f7e1?w=800&q=80', 'title' => $lang === 'ca' ? 'Sostres decoratius Ã‚Â· Barcelona' : 'Techos decorativos Ã‚Â· Barcelona', 'desc' => $lang === 'ca' ? 'Pladur i ilÃ‚Â·luminaciÃƒÂ³ LED Ã‚Â· 2024' : 'Pladur e iluminaciÃƒÂ³n LED Ã‚Â· 2024', 'cat' => $lang === 'ca' ? 'Acabats' : 'Acabados', 'span' => 'md:col-span-2'],
];

include __DIR__ . '/../includes/header.php';
?>

<?php include __DIR__ . '/partials/home-phase1-enterprise-hero.php'; ?>
<!-- Legacy hero/stats removed in Phase 1. Checkpoint available before this change. -->
<!-- SERVICES -->
<section id="servicios" class="py-24 md:py-32 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16 gap-6">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.services'); ?></span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight"><?php echo $lang === 'ca' ? 'El que construÃƒÂ¯m' : 'Lo que construimos'; ?></h2>
            </div>
            <p class="text-slate-400 max-w-md text-lg leading-relaxed"><?php echo t($translations, 'services.subtitle'); ?></p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $svc): ?>
            <article class="group relative overflow-hidden rounded-sm bg-slate-900 border border-slate-800 card-lift">
                <div class="aspect-[16/10] overflow-hidden bg-slate-800">
                    <img src="<?php echo $svc['img']; ?>" alt="" class="w-full h-full object-cover img-zoom opacity-80 group-hover:opacity-100 transition-opacity" loading="lazy" onerror="this.src='/assets/images/placeholder-construction.svg'">
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-brand-900/50 rounded-sm flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b2343b" stroke-width="2"><?php echo $svc['icon']; ?></svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-white"><?php echo t($translations, $svc['title_key']); ?></h3>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4"><?php echo t($translations, $svc['desc_key']); ?></p>
                    <a href="/<?php echo $lang; ?>/servicios/<?php echo $svc['slug']; ?>/" class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold group/link">
                        <?php echo t($translations, 'services.learn_more'); ?> <span class="transition-transform group-hover/link:translate-x-1">Ã¢â€ â€™</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>

            <!-- CTA Card -->
            <div class="flex flex-col justify-center items-center p-8 bg-brand-950/30 border border-brand-900/50 rounded-sm text-center">
                <p class="text-brand-400 text-sm uppercase tracking-widest mb-3"><?php echo $lang === 'ca' ? 'No saps per on comenÃƒÂ§ar?' : 'Ã‚Â¿No sabes por dÃƒÂ³nde empezar?'; ?></p>
                <p class="font-display font-bold text-2xl text-white mb-6"><?php echo $lang === 'ca' ? 'Parla amb en Paulo' : 'Habla con Paulo'; ?></p>
                <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-6 py-3 rounded-sm transition-all text-sm uppercase tracking-wide">
                    <?php echo $lang === 'ca' ? 'Contactar ara' : 'Contactar ahora'; ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- STORY -->
<section id="historia" class="py-24 md:py-32 bg-slate-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="aspect-[4/5] rounded-sm overflow-hidden bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="Paulo en obra" class="w-full h-full object-cover opacity-90" loading="lazy" onerror="this.src='/assets/images/placeholder-construction.svg'">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-brand-600 text-white px-6 py-4 rounded-sm shadow-2xl">
                    <p class="font-display font-bold text-3xl">17</p>
                    <p class="text-xs uppercase tracking-wider opacity-90"><?php echo $lang === 'ca' ? 'Anys de trajectÃƒÂ²ria' : 'AÃƒÂ±os de trayectoria'; ?></p>
                </div>
            </div>
            
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.about'); ?></span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-6">
                    <?php echo $lang === 'ca' ? 'Paulo estÃƒÂ  a cada obra.<br>No a cada reuniÃƒÂ³.' : 'Paulo estÃƒÂ¡ en cada obra.<br>No en cada reuniÃƒÂ³n.'; ?>
                </h2>
                <p class="text-slate-300 text-lg leading-relaxed mb-4"><?php echo t($translations, 'story.text1'); ?></p>
                <p class="text-slate-400 leading-relaxed mb-8"><?php echo t($translations, 'story.text2'); ?></p>
                
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="border-l-2 border-brand-600 pl-4">
                        <p class="font-display font-bold text-2xl text-white"><?php echo $lang === 'ca' ? 'Visita' : 'Visita'; ?></p>
                        <p class="text-slate-400 text-sm"><?php echo $lang === 'ca' ? 'Criteri tecnic abans de pressupostar' : 'Criterio tecnico antes de presupuestar'; ?></p>
                    </div>
                    <div class="border-l-2 border-brand-600 pl-4">
                        <p class="font-display font-bold text-2xl text-white"><?php echo $lang === 'ca' ? 'Pla' : 'Plan'; ?></p>
                        <p class="text-slate-400 text-sm"><?php echo $lang === 'ca' ? 'Fases i decisions documentades' : 'Fases y decisiones documentadas'; ?></p>
                    </div>
                </div>

                <a href="/<?php echo $lang; ?>/sobre-nosotros/" class="inline-flex items-center gap-3 text-brand-500 font-semibold hover:text-brand-400 transition-colors">
                    <?php echo t($translations, 'story.cta'); ?> <span class="text-xl">Ã¢â€ â€™</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- PROJECTS -->
<section id="proyectos" class="py-24 md:py-32 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16 gap-6">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Portfolio</span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight">
                    <?php echo $lang === 'ca' ? 'Obres que<br>resisteixen el temps' : 'Obras que<br>resisten el tiempo'; ?>
                </h2>
            </div>
            <a href="/<?php echo $lang; ?>/proyectos/" class="inline-flex items-center gap-2 text-brand-500 font-semibold hover:text-brand-400 transition-colors">
                <?php echo $lang === 'ca' ? 'Veure tots els projectes' : 'Ver todos los proyectos'; ?> <span>Ã¢â€ â€™</span>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($projects as $proy): ?>
            <article class="group relative overflow-hidden rounded-sm aspect-[4/3] <?php echo $proy['span']; ?> cursor-pointer">
                <img src="<?php echo $proy['img']; ?>" alt="<?php echo htmlspecialchars($proy['title'], ENT_QUOTES, 'UTF-8'); ?>" class="w-full h-full object-cover img-zoom" loading="lazy" onerror="this.src='/assets/images/placeholder-construction.svg'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-widest mb-2 block"><?php echo htmlspecialchars($proy['cat'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <h3 class="font-display font-bold text-xl md:text-2xl text-white mb-1"><?php echo htmlspecialchars($proy['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="text-slate-300 text-sm"><?php echo htmlspecialchars($proy['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/home-phase1-proof-placeholders.php'; ?>
<div class="hidden">
<!-- TESTIMONIALS -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'testimonials.title'); ?></span>
                <div class="industrial-line industrial-line-reverse w-12"></div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php for ($i = 1; $i <= 3; $i++): ?>
            <blockquote class="bg-slate-950 border-l-2 border-brand-600 p-8 rounded-r-sm">
                <svg class="text-brand-700 mb-4" width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/></svg>
                <p class="text-slate-200 text-lg leading-relaxed mb-6 font-light">"<?php echo t($translations, "testimonials.quote{$i}"); ?>"</p>
                <footer>
                    <cite class="not-italic">
                        <span class="text-white font-semibold block"><?php echo t($translations, "testimonials.author{$i}"); ?></span>
                    </cite>
                </footer>
            </blockquote>
            <?php endfor; ?>
        </div>
    </div>
</section>
</div>

<!-- CTA -->
<section id="contacto" class="py-24 md:py-32 bg-slate-950 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <div class="flex items-center justify-center gap-4 mb-6">
            <div class="industrial-line w-12"></div>
            <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.contact'); ?></span>
            <div class="industrial-line industrial-line-reverse w-12"></div>
        </div>
        <h2 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight mb-6"><?php echo t($translations, 'cta_section.title'); ?></h2>
        <p class="text-slate-300 text-lg leading-relaxed mb-10 max-w-2xl mx-auto"><?php echo t($translations, 'cta_section.subtitle'); ?></p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/<?php echo $lang; ?>/contacto/" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo t($translations, 'cta_section.primary'); ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="tel:+34665737547" class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo t($translations, 'cta_section.secondary'); ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
