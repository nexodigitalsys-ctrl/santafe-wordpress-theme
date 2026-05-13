<?php
/**
 * Sección Contato / CTA Final
 * "Tu proyecto empieza con una conversación"
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Presupost en 48 hores. Sense compromís.' : 'Presupuesto en 48 horas. Sin compromiso.';
$subtitle = $lang === 'ca'
    ? 'Explica\'ns el que necessites. Pablo respon personalment — sense call centers, sense intermediaris.'
    : 'Cuéntanos lo que necesitas. Pablo responde personalmente — sin call centers, sin intermediarios.';

$label_nombre = $lang === 'ca' ? 'Nom' : 'Nombre';
$label_email = $lang === 'ca' ? 'Correu electrònic' : 'Correo electrónico';
$label_telefono = $lang === 'ca' ? 'Telèfon' : 'Teléfono';
$label_tipo = $lang === 'ca' ? 'Tipus d\'obra' : 'Tipo de obra';
$label_ciudad = $lang === 'ca' ? 'Ciutat' : 'Ciudad';
$label_mensaje = $lang === 'ca' ? 'Missatge' : 'Mensaje';
$placeholder_mensaje = $lang === 'ca' ? 'Ex.: Reforma integral d\'un pis de 80m² a Barcelona. Volem canviar cuina, 2 banys i terra. Pressupost màxim 40.000€. Disponibilitat: setembre.' : 'Ej.: Reforma integral de un piso de 80m² en Barcelona. Queremos cambiar cocina, 2 baños y suelo. Presupuesto máximo 40.000€. Disponibilidad: septiembre.';
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

<section data-reveal class="py-24 md:py-32 bg-slate-950 relative overflow-hidden" id="contacto">
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
                    <div class="mb-5">
                        <label class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $lang === 'ca' ? 'Fotos del projecte (opcional)' : 'Fotos del proyecto (opcional)'; ?></label>
                        <input type="file" name="project_photos[]" accept="image/*,.pdf" multiple class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-slate-300 focus:border-brand-500 focus:outline-none transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-sm file:font-semibold file:bg-brand-600 file:text-white hover:file:bg-brand-500">
                        <p class="text-slate-500 text-xs mt-2"><?php echo $lang === 'ca' ? 'Màx. 5 arxius (JPG, PNG, PDF)' : 'Máx. 5 archivos (JPG, PNG, PDF)'; ?></p>
                    </div>
                    <div class="mb-6">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="privacy" required class="mt-1 accent-brand-600">
                            <span class="text-slate-400 text-sm"><?php echo $label_privacy; ?></span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white font-semibold py-4 rounded-sm transition-all tracking-wide uppercase text-sm relative overflow-hidden group">
                        <span class="relative z-10"><?php echo $cta; ?></span>
                        <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform"></div>
                    </button>
                    <p class="text-center text-slate-500 text-xs mt-4">
                        <?php echo $lang === 'ca' ? 'Pablo respon personalment. Habitualment en menys de 2 hores en dies feiners.' : 'Pablo responde personalmente. Habitualmente en menos de 2 horas en días laborables.'; ?>
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-500"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider"><?php echo $alt_phone; ?></p>
                                <p class="text-white font-semibold text-lg"><?php echo COMPANY_PHONE_DISPLAY; ?></p>
                            </div>
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-500"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider"><?php echo $alt_whatsapp; ?></p>
                                <p class="text-white font-semibold text-lg"><?php echo COMPANY_PHONE_DISPLAY; ?></p>
                            </div>
                        </a>
                        <a href="mailto:<?php echo COMPANY_EMAIL; ?>" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-sm flex items-center justify-center group-hover:bg-brand-900/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-500"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
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
                <div class="bg-brand-950/20 border border-brand-900/30 rounded-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-500"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        <h3 class="font-semibold text-white text-sm"><?php echo $lang === 'ca' ? 'Finançament disponible' : 'Financiación disponible'; ?></h3>
                    </div>
                    <p class="text-slate-400 text-sm"><?php echo $lang === 'ca' ? 'Pagament fraccionat vinculat a fites de l\'obra. Consulta\'ns les opcions.' : 'Pago fraccionado vinculado a hitos de la obra. Consúltanos las opciones.'; ?></p>
                </div>
                <div class="rounded-sm overflow-hidden border border-slate-800">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d95777.33906372695!2d2.0785565!3d41.3947685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a49816718e30e5%3A0x44b0e3f5d9f60f1!2sBarcelona!5e0!3m2!1ses!2ses!4v1700000000000!5m2!1ses!2ses"
                        width="100%"
                        height="200"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?php echo $lang === 'ca' ? 'Mapa - Santa Fe Construcciones' : 'Mapa - Santa Fe Construcciones'; ?>">
                    </iframe>
                </div>
            </aside>
        </div>
    </div>
</section>
