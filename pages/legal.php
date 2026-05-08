<?php
/**
 * Legal.php — Aviso Legal, Privacidad, Cookies con Tailwind CSS
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : (isset($_GET['lang']) && in_array($_GET['lang'], ['es','ca'], true) ? $_GET['lang'] : 'es');
$route = isset($current_route) ? $current_route : (isset($_GET['route']) ? preg_replace('/[^a-z0-9\-\/]/', '', $_GET['route']) : '');

$legal_types = [
    'es' => ['aviso-legal'=>'legal','politica-privacidad'=>'privacy','politica-cookies'=>'cookies'],
    'ca' => ['avis-legal'=>'legal','politica-privacitat'=>'privacy','politica-cookies'=>'cookies']
];

$type = $legal_types[$lang][$route] ?? 'legal';

$titles = [
    'legal' => ['es'=>'Aviso Legal','ca'=>'Avís Legal'],
    'privacy' => ['es'=>'Política de Privacidad','ca'=>'Política de Privacitat'],
    'cookies' => ['es'=>'Política de Cookies','ca'=>'Política de Cookies']
];

$page_data = [
    'lang' => $lang,
    'title' => $titles[$type][$lang] . ' | Construcciones Santa Fe',
    'description' => $lang === 'ca' ? 'Informació legal i de protecció de dades.' : 'Información legal y de protección de datos.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/' . $route . '/',
    'schemas' => []
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 bg-slate-950">
    <div class="max-w-3xl mx-auto px-6">
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Legal</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight"><?php echo htmlspecialchars($titles[$type][$lang], ENT_QUOTES, 'UTF-8'); ?></h1>
        </div>

        <div class="space-y-10 text-slate-300 leading-relaxed">
            <?php if ($type === 'legal'): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-sm p-8">
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Dades del titular' : 'Datos del titular'; ?></h2>
                <p class="space-y-1 text-sm">
                    <strong class="text-white"><?php echo $lang === 'ca' ? 'Titular' : 'Titular'; ?>:</strong> Construcciones Santa Fe Siglo XXI SLU<br>
                    <strong class="text-white">NIF/CIF:</strong> [Insertar CIF]<br>
                    <strong class="text-white"><?php echo $lang === 'ca' ? 'Domicili' : 'Domicilio'; ?>:</strong> [Insertar dirección]<br>
                    <strong class="text-white">Email:</strong> <?php echo COMPANY_EMAIL; ?><br>
                    <strong class="text-white"><?php echo $lang === 'ca' ? 'Telèfon' : 'Teléfono'; ?>:</strong> <?php echo COMPANY_PHONE_DISPLAY; ?><br>
                    <strong class="text-white"><?php echo $lang === 'ca' ? 'Responsable privacitat' : 'Responsable privacidad'; ?>:</strong> Paulo
                </p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Condicions d\'ús' : 'Condiciones de uso'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'L\'accés i ús d\'aquest lloc web atribueix la condició d\'usuari i implica l\'acceptació íntegra de les presents condicions.' : 'El acceso y uso de este sitio web atribuye la condición de usuario e implica la aceptación íntegra de las presentes condiciones.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Propietat intel·lectual' : 'Propiedad intelectual'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Tots els continguts són propietat de Construccions Santa Fe Siglo XXI SLU. Queda prohibida la reproducció total o parcial sense autorització.' : 'Todos los contenidos son propiedad de Construcciones Santa Fe Siglo XXI SLU. Queda prohibida la reproducción total o parcial sin autorización.'; ?></p>
            </div>

            <?php elseif ($type === 'privacy'): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-sm p-8">
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Responsable del tractament' : 'Responsable del tratamiento'; ?></h2>
                <p class="text-sm">Paulo / Construcciones Santa Fe Siglo XXI SLU<br>Email: <?php echo COMPANY_EMAIL; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Dades que recollim' : 'Datos que recogemos'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Nom, correu, telèfon, missatge, IP i dades tècniques del navegador.' : 'Nombre, correo, teléfono, mensaje, IP y datos técnicos del navegador.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Els teus drets' : 'Tus derechos'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Accés, rectificació, supressió, oposició, limitació i portabilitat. Per exercir-los, envia un correu a ' . COMPANY_EMAIL . ' amb còpia del DNI.' : 'Acceso, rectificación, supresión, oposición, limitación y portabilidad. Para ejercerlos, envía un correo a ' . COMPANY_EMAIL . ' con copia de tu DNI.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Mesures de seguretat' : 'Medidas de seguridad'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Encriptació SSL (HTTPS), accés restringit al panell, validació CSRF i no s\'emmagatzemen dades bancàries.' : 'Encriptación SSL (HTTPS), acceso restringido al panel, validación CSRF y no se almacenan datos bancarios.'; ?></p>
            </div>

            <?php elseif ($type === 'cookies'): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-sm p-8">
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Què són les cookies?' : '¿Qué son las cookies?'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Petits fitxers de text que els llocs web emmagatzemen al teu dispositiu.' : 'Pequeños archivos de texto que los sitios web almacenan en tu dispositivo.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Tipus que utilitzem' : 'Tipos que utilizamos'; ?></h2>
                <ul class="space-y-3 text-sm">
                    <li><strong class="text-white"><?php echo $lang === 'ca' ? 'Estrictament necessàries' : 'Estrictamente necesarias'; ?>:</strong> <?php echo $lang === 'ca' ? 'Sessió, seguretat i idioma.' : 'Sesión, seguridad e idioma.'; ?></li>
                    <li><strong class="text-white"><?php echo $lang === 'ca' ? 'Analítiques' : 'Analíticas'; ?>:</strong> <?php echo $lang === 'ca' ? 'Google Analytics 4 (només amb consentiment).' : 'Google Analytics 4 (solo con consentimiento).'; ?></li>
                    <li><strong class="text-white"><?php echo $lang === 'ca' ? 'Funcionals' : 'Funcionales'; ?>:</strong> <?php echo $lang === 'ca' ? 'WhatsApp i mapes embebuts.' : 'WhatsApp y mapas embebidos.'; ?></li>
                </ul>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-white mb-4"><?php echo $lang === 'ca' ? 'Com gestionar-les?' : '¿Cómo gestionarlas?'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Pots modificar les teves preferències fent clic a "Configurar cookies" al peu de pàgina.' : 'Puedes modificar tus preferencias haciendo clic en "Configurar cookies" en el pie de página.'; ?></p>
            </div>
            <p><button type="button" onclick="cookieConsent.showSettings()" class="text-brand-400 hover:text-brand-300 underline"><?php echo $lang === 'ca' ? 'Configurar cookies' : 'Configurar cookies'; ?></button></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
