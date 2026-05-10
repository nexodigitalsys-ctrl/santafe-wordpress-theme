<?php
/**
 * Sección Contato / CTA Final
 * "Tu proyecto empieza con una conversación"
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'El teu projecte comença amb una conversa' : 'Tu proyecto empieza con una conversación';
$subtitle = $lang === 'ca'
    ? 'Explica\'ns el tipus d\'obra, ubicació i fase actual. Et direm el següent pas amb criteri tècnic.'
    : 'Cuéntanos el tipo de obra, ubicación y fase actual. Te diremos el siguiente paso con criterio técnico.';

$label_nombre = $lang === 'ca' ? 'Nom' : 'Nombre';
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

$alt_phone = $lang === 'ca' ? 'Truca ara' : 'Llamar ahora';
$alt_whatsapp = $lang === 'ca' ? 'WhatsApp' : 'WhatsApp';
$alt_oficina = $lang === 'ca' ? 'Oficina' : 'Oficina';
?>

<section class="py-24 md:py-32 bg-slate-950 relative overflow-hidden" id="contacto">
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo t($translations, 'nav.contact'); ?></span>
                <div class="industrial-line industrial-line-reverse w-12"></div>
            </div>
            <h2 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight mb-6"><?php echo $title; ?></h2>
            <p class="text-slate-300 text-lg leading-relaxed mb-10 max-w-2xl mx-auto"><?php echo $subtitle; ?></p>
        </div>

        <div class="grid lg:grid-cols-[1fr_0.9fr] gap-16">
            <!-- Form -->
            <div class="bg-slate-900 border border-slate-800 rounded-sm p-8 md:p-10">
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
                                <p class="text-slate-500 text-xs uppercase tracking-wider"><?php echo $alt_phone; ?></p>
                                <p class="text-white font-semibold text-lg"><?php echo COMPANY_PHONE_DISPLAY; ?></p>
                            </div>
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#AE232A" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider"><?php echo $alt_whatsapp; ?></p>
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
