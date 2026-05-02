<?php
/**
 * Contacto con Tailwind CSS
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$translations = load_translations($lang);

$breadcrumb_items = [
    ['name' => $lang === 'ca' ? 'Inici' : 'Inicio', 'url' => '/' . $lang . '/'],
    ['name' => $lang === 'ca' ? 'Contacte' : 'Contacto', 'url' => '/' . $lang . '/' . ($lang === 'ca' ? 'contacte' : 'contacto') . '/']
];

$page_data = [
    'lang' => $lang,
    'title' => $lang === 'ca' ? 'Contactar amb Construccions Santa Fe | Pressupost en 24h' : 'Contactar con Construcciones Santa Fe | Presupuesto en 24h',
    'description' => $lang === 'ca' ? 'Contacta amb en Paulo. Pressupost en 24 hores.' : 'Contacta con Paulo. Presupuesto en 24 horas.',
    'canonical' => 'https://www.dominio.com/' . $lang . '/' . ($lang === 'ca' ? 'contacte' : 'contacto') . '/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }]
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-32 pb-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.contact'); ?></span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight"><?php echo t($translations, 'contact.form_title'); ?></h1>
            <p class="text-slate-400 mt-4 max-w-lg"><?php echo t($translations, 'contact.form_subtitle'); ?></p>
        </div>

        <div class="grid lg:grid-cols-2 gap-16">
            <!-- Form -->
            <div class="bg-slate-900 border border-slate-800 rounded-sm p-8 md:p-10">
                <form action="/api/contact-form.php" method="post" data-ajax="true" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="sr-only" aria-hidden="true">
                        <label for="website"><?php echo t($translations, 'contact.honeypot_label'); ?></label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="grid md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo t($translations, 'contact.name_label'); ?> *</label>
                            <input type="text" name="name" required placeholder="<?php echo t($translations, 'contact.name_placeholder'); ?>" class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white placeholder:text-slate-600 focus:border-brand-500 focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo t($translations, 'contact.phone_label'); ?></label>
                            <input type="tel" name="phone" placeholder="<?php echo t($translations, 'contact.phone_placeholder'); ?>" class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white placeholder:text-slate-600 focus:border-brand-500 focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo t($translations, 'contact.email_label'); ?> *</label>
                        <input type="email" name="email" required placeholder="<?php echo t($translations, 'contact.email_placeholder'); ?>" class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white placeholder:text-slate-600 focus:border-brand-500 focus:outline-none transition-colors">
                    </div>
                    <div class="mb-5">
                        <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo t($translations, 'contact.service_label'); ?></label>
                        <select name="service_interest" class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-slate-300 focus:border-brand-500 focus:outline-none transition-colors">
                            <option value=""><?php echo t($translations, 'contact.service_select'); ?></option>
                            <option value="obra-nueva"><?php echo t($translations, 'contact.service_new_build'); ?></option>
                            <option value="reformas-integrales"><?php echo t($translations, 'contact.service_renovation'); ?></option>
                            <option value="pladur-acabados"><?php echo t($translations, 'contact.service_plaster'); ?></option>
                            <option value="obra-publica"><?php echo t($translations, 'contact.service_public'); ?></option>
                            <option value="obra-civil"><?php echo t($translations, 'contact.service_civil'); ?></option>
                            <option value="otro"><?php echo t($translations, 'contact.service_other'); ?></option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo t($translations, 'contact.message_label'); ?> *</label>
                        <textarea name="message" rows="4" required placeholder="<?php echo t($translations, 'contact.message_placeholder'); ?>" class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white placeholder:text-slate-600 focus:border-brand-500 focus:outline-none transition-colors resize-y"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white font-semibold py-4 rounded-sm transition-all tracking-wide uppercase text-sm">
                        <?php echo t($translations, 'contact.submit'); ?>
                    </button>
                    <p class="text-slate-600 text-xs text-center mt-4">
                        <?php echo str_replace('{privacy_link}', '<a href="/' . $lang . '/politica-privacidad/" class="text-brand-400 underline">' . t($translations, 'contact.privacy_link_text') . '</a>', t($translations, 'contact.privacy_note')); ?>
                    </p>
                </form>
            </div>

            <!-- Contact Info -->
            <aside class="space-y-8">
                <div>
                    <h3 class="font-display font-bold text-2xl text-white mb-6"><?php echo t($translations, 'footer.contact_title'); ?></h3>
                    <div class="space-y-5">
                        <a href="https://wa.me/34665737547" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b2343b" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider">WhatsApp</p>
                                <p class="text-white font-semibold text-lg"><?php echo t($translations, 'footer.phone'); ?></p>
                            </div>
                        </a>
                        <a href="mailto:Constrsantafe@gmail.com" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b2343b" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 01-2.06 0L2 7"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider">Email</p>
                                <p class="text-white font-semibold text-lg"><?php echo t($translations, 'footer.email'); ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-3"><?php echo t($translations, 'footer.hours_title'); ?></h3>
                    <p class="text-slate-400"><?php echo t($translations, 'footer.hours'); ?></p>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-3"><?php echo $lang === 'ca' ? 'Zona d\'actuació' : 'Zona de actuación'; ?></h3>
                    <p class="text-slate-400">Barcelona, Girona y alrededores</p>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
