<?php
/**
 * Contacto con Tailwind CSS — Actualizado conforme manual
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
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . ($lang === 'ca' ? 'contacte' : 'contacto') . '/',
    'schemas' => [function() use ($breadcrumb_items) { return get_schema_breadcrumb($breadcrumb_items); }]
];

include __DIR__ . '/../includes/header.php';

$label_nombre = $lang === 'ca' ? 'Nom complet' : 'Nombre completo';
$label_email = $lang === 'ca' ? 'Correu electrònic' : 'Correo electrónico';
$label_telefono = $lang === 'ca' ? 'Telèfon' : 'Teléfono';
$label_tipo = $lang === 'ca' ? 'Tipus d\'obra' : 'Tipo de obra';
$label_ciudad = $lang === 'ca' ? 'Ciutat' : 'Ciudad';
$label_mensaje = $lang === 'ca' ? 'Missatge' : 'Mensaje';
$placeholder_mensaje = $lang === 'ca' ? 'Descriu el teu projecte...' : 'Describe tu proyecto...';
$label_privacy = $lang === 'ca' ? 'Accepto la política de privacitat' : 'Acepto la política de privacidad';
$cta = $lang === 'ca' ? 'Enviar missatge' : 'Enviar mensaje';

$tipos = $lang === 'ca' ? [
    '' => 'Selecciona un tipus',
    'obra-nueva' => 'Obra nova',
    'reformas-integrales' => 'Reforma integral',
    'pladur-acabados' => 'Pladur i acabats',
    'obra-publica' => 'Obra pública',
    'obra-civil' => 'Obra civil',
    'otro' => 'Altres',
] : [
    '' => 'Selecciona un tipo',
    'obra-nueva' => 'Obra nueva',
    'reformas-integrales' => 'Reforma integral',
    'pladur-acabados' => 'Pladur y acabados',
    'obra-publica' => 'Obra pública',
    'obra-civil' => 'Obra civil',
    'otro' => 'Otro',
];

$ciudades = $lang === 'ca' ? [
    '' => 'Selecciona una ciutat',
    'barcelona' => 'Barcelona',
    'girona' => 'Girona',
    'tarragona' => 'Tarragona',
    'otros' => 'Altres',
] : [
    '' => 'Selecciona una ciudad',
    'barcelona' => 'Barcelona',
    'girona' => 'Girona',
    'tarragona' => 'Tarragona',
    'otros' => 'Otros',
];
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
                <?php if (isset($_GET['sent'], $_GET['msg'])): ?>
                <div class="mb-6 border <?php echo $_GET['sent'] === '1' ? 'border-green-500' : 'border-red-500'; ?> bg-slate-950 p-4 rounded-sm text-white" role="alert">
                    <?php echo esc_html(rawurldecode((string) $_GET['msg'])); ?>
                </div>
                <?php endif; ?>
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" data-ajax="true" novalidate>
                    <input type="hidden" name="action" value="santafe_contact_form">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="sr-only" aria-hidden="true">
                        <label for="website"><?php echo t($translations, 'contact.honeypot_label'); ?></label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="grid md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_nombre; ?> *</label>
                            <input type="text" name="name" required class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white focus:border-brand-500 focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_telefono; ?> *</label>
                            <input type="tel" name="phone" required class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white focus:border-brand-500 focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_email; ?> *</label>
                        <input type="email" name="email" required class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white focus:border-brand-500 focus:outline-none transition-colors">
                    </div>
                    <div class="grid md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_tipo; ?> *</label>
                            <select name="service_interest" required class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-slate-300 focus:border-brand-500 focus:outline-none transition-colors">
                                <?php foreach ($tipos as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_ciudad; ?> *</label>
                            <select name="city" required class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-slate-300 focus:border-brand-500 focus:outline-none transition-colors">
                                <?php foreach ($ciudades as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_mensaje; ?> *</label>
                        <textarea name="message" rows="4" required placeholder="<?php echo $placeholder_mensaje; ?>" class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white focus:border-brand-500 focus:outline-none transition-colors resize-y"></textarea>
                    </div>
                    <div class="mb-6">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="privacy" required class="mt-1 accent-brand-600">
                            <span class="text-slate-400 text-sm"><?php echo $label_privacy; ?></span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white font-semibold py-4 rounded-sm transition-all tracking-wide uppercase text-sm">
                        <?php echo $cta; ?>
                    </button>
                    <p class="text-slate-600 text-xs text-center mt-4">
                        <?php echo str_replace('{privacy_link}', '<a href="/' . $lang . '/politica-privacidad/" class="text-brand-400 underline">' . t($translations, 'contact.privacy_link_text') . '</a>', t($translations, 'contact.privacy_note')); ?>
                    </p>
                </form>
            </div>

            <!-- Contact Info -->
            <aside class="space-y-8">
                <div>
                    <h3 class="font-display font-bold text-2xl text-white mb-6"><?php echo $lang === 'ca' ? 'Contacte directe' : 'Contacto directo'; ?></h3>
                    <div class="space-y-5">
                        <a href="tel:<?php echo COMPANY_PHONE; ?>" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#AE232A" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider"><?php echo $lang === 'ca' ? 'Truca ara' : 'Llamar ahora'; ?></p>
                                <p class="text-white font-semibold text-lg"><?php echo COMPANY_PHONE_DISPLAY; ?></p>
                            </div>
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#AE232A" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider">WhatsApp</p>
                                <p class="text-white font-semibold text-lg"><?php echo COMPANY_PHONE_DISPLAY; ?></p>
                            </div>
                        </a>
                        <a href="mailto:<?php echo COMPANY_EMAIL; ?>" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#AE232A" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 01-2.06 0L2 7"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider">Email</p>
                                <p class="text-white font-semibold text-lg"><?php echo COMPANY_EMAIL; ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-3"><?php echo $lang === 'ca' ? 'Horari' : 'Horario'; ?></h3>
                    <p class="text-slate-400"><?php echo t($translations, 'footer.hours'); ?></p>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-3"><?php echo $lang === 'ca' ? 'Zona d\'actuació' : 'Zona de actuación'; ?></h3>
                    <p class="text-slate-400">Barcelona, Girona, Tarragona</p>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
