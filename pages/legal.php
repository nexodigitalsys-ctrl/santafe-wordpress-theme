<?php
/**
 * Legal.php — Aviso Legal, Privacidad, Cookies con Tailwind CSS
 */

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

$body_class = 'header-solid';
include __DIR__ . '/../includes/header.php';
?>

<section class="pt-40 pb-24 bg-white">
    <div class="max-w-3xl mx-auto px-6">
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Legal</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl text-warm-900 tracking-tight"><?php echo htmlspecialchars($titles[$type][$lang], ENT_QUOTES, 'UTF-8'); ?></h1>
        </div>

        <div class="space-y-10 text-warm-600 leading-relaxed">

            <?php if ($type === 'legal'): ?>

            <div class="bg-warm-50 border border-warm-200 rounded-sm p-8">
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">1. <?php echo $lang === 'ca' ? 'Dades Identificatives' : 'Datos Identificativos'; ?></h2>
                <p class="space-y-1 text-sm">
                    <strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Titular' : 'Titular'; ?>:</strong> CONSTRUCCIONS SANTA FE SIGLO XXI SL.<br>
                    <strong class="text-warm-900">NIF:</strong> B01843911<br>
                    <strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Domicili Social' : 'Domicilio Social'; ?>:</strong> CALLE CAMPCARDOS, 49 - PISO 4 PTA 3 - 17006 GIRONA (Girona)<br>
                    <strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Correu electrònic' : 'Correo electrónico'; ?>:</strong> <?php echo COMPANY_EMAIL; ?>
                </p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">2. <?php echo $lang === 'ca' ? 'Propietat Intel·lectual' : 'Propiedad Intelectual'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'El codi font, els dissenys gràfics, les imatges, les fotografies, els sons, les animacions i els textos d\'aquest lloc web estan protegits per la legislació espanyola sobre els drets de propietat intel·lectual i industrial a favor de CONSTRUCCIONS SANTA FE SIGLO XXI SL.' : 'El código fuente, los diseños gráficos, las imágenes, las fotografías, los sonidos, las animaciones y los textos de este sitio web están protegidos por la legislación española sobre los derechos de propiedad intelectual e industrial a favor de CONSTRUCCIONS SANTA FE SIGLO XXI SL.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">3. <?php echo $lang === 'ca' ? 'Condicions d\'Ús' : 'Condiciones de Uso'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'L\'accés a aquest portal atribueix la condició d\'USUARI, que accepta les condicions aquí reflectides. El lloc web proporciona accés a informació i serveis de construcció i reformes. L\'usuari es compromet a fer un ús adequat dels continguts.' : 'El acceso a este portal atribuye la condición de USUARIO, que acepta las condiciones aquí reflejadas. El sitio web proporciona acceso a información y servicios de construcción y reformas. El usuario se compromete a hacer un uso adecuado de los contenidos.'; ?></p>
            </div>

            <?php elseif ($type === 'privacy'): ?>

            <p class="text-xs text-warm-400"><?php echo $lang === 'ca' ? 'Última actualització: Maig 2026' : 'Última actualización: Mayo 2026'; ?></p>

            <p class="text-sm"><?php echo $lang === 'ca' ? 'A CONSTRUCCIONS SANTA FE SIGLO XXI SL, valorem la privacitat dels nostres usuaris. Aquesta política descriu com gestionem les dades al nostre lloc oficial https://santafe-construcciones.com/ i el subdomini de desenvolupament.' : 'En CONSTRUCCIONS SANTA FE SIGLO XXI SL, valoramos la privacidad de nuestros usuarios. Esta política describe cómo gestionamos los datos en nuestro sitio oficial https://santafe-construcciones.com/ y el subdominio de desarrollo.'; ?></p>

            <div class="bg-warm-50 border border-warm-200 rounded-sm p-8">
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">1. <?php echo $lang === 'ca' ? 'Responsable del Tractament' : 'Responsable del Tratamiento'; ?></h2>
                <p class="space-y-1 text-sm">
                    <strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Raó Social' : 'Razón Social'; ?>:</strong> CONSTRUCCIONS SANTA FE SIGLO XXI SL.<br>
                    <strong class="text-warm-900">NIF:</strong> B01843911<br>
                    <strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Domicili' : 'Domicilio'; ?>:</strong> CALLE CAMPCARDOS, 49 - PISO 4 PTA 3 - 17006 GIRONA (Girona)<br>
                    <strong class="text-warm-900">Email:</strong> <?php echo COMPANY_EMAIL; ?><br>
                    <strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Persona de contacte' : 'Persona de contacto'; ?>:</strong> Paulo
                </p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">2. <?php echo $lang === 'ca' ? 'Dades Recollides i Finalitat' : 'Datos Recopilados y Finalidad'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Recollim dades estrictament necessàries per:' : 'Recopilamos datos estrictamente necesarios para:'; ?></p>
                <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                    <li><?php echo $lang === 'ca' ? 'Formularis de contacte: Gestió de consultes comercials i pressupostos.' : 'Formularios de contacto: Gestión de consultas comerciales y presupuestos.'; ?></li>
                    <li><?php echo $lang === 'ca' ? 'Logs del Servidor: Seguretat i detecció d\'errors tècnics (processats a la nostra infraestructura de Hostinger).' : 'Logs del Servidor: Seguridad y detección de errores técnicos (procesados en nuestra infraestructura de Hostinger).'; ?></li>
                    <li><?php echo $lang === 'ca' ? 'Cookies: Anàlisi de trànsit i experiència d\'usuari.' : 'Cookies: Análisis de tráfico y experiencia de usuario.'; ?></li>
                </ul>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">3. <?php echo $lang === 'ca' ? 'Base Legal' : 'Base Legal'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'El tractament de les seves dades es basa en el consentiment explícit de l\'usuari en contactar-nos i en l\'interès legítim de garantir la seguretat de la nostra infraestructura tecnològica.' : 'El tratamiento de sus datos se basa en el consentimiento explícito del usuario al contactarnos y en el interés legítimo de garantizar la seguridad de nuestra infraestructura tecnológica.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">4. <?php echo $lang === 'ca' ? 'Seguretat de les Dades (SecOps)' : 'Seguridad de los Datos (SecOps)'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Apliquem protocols de seguretat avançats per protegir la seva informació:' : 'Aplicamos protocolos de seguridad avanzados para proteger su información:'; ?></p>
                <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                    <li><strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Xifrat SSL' : 'Cifrado SSL'; ?>:</strong> <?php echo $lang === 'ca' ? 'Connexió segura mitjançant protocol HTTPS (Mode Full/Strict via Cloudflare).' : 'Conexión segura mediante protocolo HTTPS (Modo Full/Strict vía Cloudflare).'; ?></li>
                    <li><strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Gestió de Credencials' : 'Gestión de Credenciales'; ?>:</strong> <?php echo $lang === 'ca' ? 'Ús de variables d\'entorn (.env) i voltes de seguretat (Bitwarden) per evitar fuites d\'accés a bases de dades.' : 'Uso de variables de entorno (.env) y bóvedas de seguridad (Bitwarden) para evitar fugas de acceso a bases de datos.'; ?></li>
                    <li><strong class="text-warm-900"><?php echo $lang === 'ca' ? 'Monitorització' : 'Monitorización'; ?>:</strong> <?php echo $lang === 'ca' ? 'Supervisió 24/7 de la integritat del lloc per prevenir accessos no autoritzats.' : 'Supervisión 24/7 de la integridad del sitio para prevenir accesos no autorizados.'; ?></li>
                </ul>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">5. <?php echo $lang === 'ca' ? 'Drets de l\'Usuari' : 'Derechos del Usuario'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Vostè té dret a accedir, rectificar, suprimir o limitar el tractament de les seves dades enviant un correu a ' . COMPANY_EMAIL . '.' : 'Usted tiene derecho a acceder, rectificar, suprimir o limitar el tratamiento de sus datos enviando un correo a ' . COMPANY_EMAIL . '.'; ?></p>
            </div>

            <?php elseif ($type === 'cookies'): ?>

            <p class="text-xs text-warm-400"><?php echo $lang === 'ca' ? 'Aquesta política de cookies va ser actualitzada per última vegada el maig 10, 2026 i s\'aplica als ciutadans i residents legals permanents de l\'Espai Econòmic Europeu i Suïssa.' : 'Esta política de cookies fue actualizada por última vez el mayo 10, 2026 y se aplica a los ciudadanos y residentes legales permanentes del Espacio Económico Europeo y Suiza.'; ?></p>

            <div class="bg-warm-50 border border-warm-200 rounded-sm p-8">
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">1. <?php echo $lang === 'ca' ? 'Introducció' : 'Introducción'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'La nostra web, https://santafe-construcciones.com (en endavant: «la web») utilitza cookies i altres tecnologies relacionades. Les cookies també són col·locades per tercers als que hem contractat. En el següent document t\'informem sobre l\'ús de cookies a la nostra web.' : 'Nuestra web, https://santafe-construcciones.com (en adelante: «la web») utiliza cookies y otras tecnologías relacionadas. Las cookies también son colocadas por terceros a los que hemos contratado. En el siguiente documento te informamos sobre el uso de cookies en nuestra web.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">2. <?php echo $lang === 'ca' ? 'Què són les cookies?' : '¿Qué son las cookies?'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Una cookie és un petit fitxer que s\'envia juntament amb les pàgines d\'aquesta web i que el teu navegador emmagatzema al disc dur del seu ordinador o altre dispositiu. La informació emmagatzemada pot ser retornada als nostres servidors o als servidors de tercers apropiats durant una visita posterior.' : 'Una cookie es un pequeño archivo que se envía junto con las páginas de esta web y que tu navegador almacena en el disco duro de su ordenador u otro dispositivo. La información almacenada puede ser devuelta a nuestros servidores o a los servidores de terceros apropiados durante una visita posterior.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">3. <?php echo $lang === 'ca' ? 'Què són els scripts?' : '¿Qué son los scripts?'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Un script és un fragment de codi de programa que s\'utilitza per fer que la nostra web funcioni correctament i de forma interactiva. Aquest codi s\'executa al nostre servidor o al teu dispositiu.' : 'Un script es un fragmento de código de programa que se utiliza para hacer que nuestra web funcione correctamente y de forma interactiva. Este código se ejecuta en nuestro servidor o en tu dispositivo.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">4. <?php echo $lang === 'ca' ? 'Què és una baliza web?' : '¿Qué es una baliza web?'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Una baliza web (o una etiqueta de píxel) és una petita i invisible peça de text o imatge en una web que s\'utilitza per monitoritzar el trànsit en una web. Per a això, s\'emmagatzemen diverses dades sobre vostè mitjançant aquestes balises web.' : 'Una baliza web (o una etiqueta de píxel) es una pequeña e invisible pieza de texto o imagen en una web que se utiliza para monitorear el tráfico en una web. Para ello, se almacenan varios datos sobre usted mediante estas balizas web.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">5. <?php echo $lang === 'ca' ? 'Cookies' : 'Cookies'; ?></h2>
                <h3 class="font-semibold text-warm-900 mt-4 mb-2">5.1 <?php echo $lang === 'ca' ? 'Cookies tècniques o funcionals' : 'Cookies técnicas o funcionales'; ?></h3>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Algunes cookies asseguren que certes parts de la web funcionin correctament i que les teves preferències d\'usuari segueixin recordant-se. En col·locar cookies funcionals, et facilitem la visita a la nostra web. Podem col·locar aquestes cookies sense el teu consentiment.' : 'Algunas cookies aseguran que ciertas partes de la web funcionen correctamente y que tus preferencias de usuario sigan recordándose. Al colocar cookies funcionales, te facilitamos la visita a nuestra web. Podemos colocar estas cookies sin tu consentimiento.'; ?></p>
                <h3 class="font-semibold text-warm-900 mt-4 mb-2">5.2 <?php echo $lang === 'ca' ? 'Cookies d\'estadístiques' : 'Cookies de estadísticas'; ?></h3>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Utilitzem cookies estadístiques per optimitzar l\'experiència de la web per als nostres usuaris. Amb aquestes cookies estadístiques obtenim informació sobre l\'ús de la nostra web. Et demanem el teu permís per col·locar cookies d\'estadístiques.' : 'Utilizamos cookies estadísticas para optimizar la experiencia de la web para nuestros usuarios. Con estas cookies estadísticas obtenemos información sobre el uso de nuestra web. Te pedimos tu permiso para colocar cookies de estadísticas.'; ?></p>
                <h3 class="font-semibold text-warm-900 mt-4 mb-2">5.3 <?php echo $lang === 'ca' ? 'Cookies de màrqueting/seguiment' : 'Cookies de marketing/seguimiento'; ?></h3>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Les cookies de màrqueting/seguiment són cookies, o qualsevol altra forma d\'emmagatzematge local, usades per crear perfils d\'usuari per mostrar publicitat o per fer el seguiment de l\'usuari en aquesta web o en diverses webs amb fins de màrqueting similars.' : 'Las cookies de marketing/seguimiento son cookies, o cualquier otra forma de almacenamiento local, usadas para crear perfiles de usuario para mostrar publicidad o para hacer el seguimiento del usuario en esta web o en varias webs con fines de marketing similares.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">6. <?php echo $lang === 'ca' ? 'Cookies utilitzades' : 'Cookies usadas'; ?></h2>
                <div class="overflow-x-auto">
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-warm-100">
                            <th class="p-2 text-left font-semibold text-warm-900 border border-warm-200"><?php echo $lang === 'ca' ? 'Nom' : 'Nombre'; ?></th>
                            <th class="p-2 text-left font-semibold text-warm-900 border border-warm-200"><?php echo $lang === 'ca' ? 'Proveïdor' : 'Proveedor'; ?></th>
                            <th class="p-2 text-left font-semibold text-warm-900 border border-warm-200"><?php echo $lang === 'ca' ? 'Finalitat' : 'Finalidad'; ?></th>
                            <th class="p-2 text-left font-semibold text-warm-900 border border-warm-200"><?php echo $lang === 'ca' ? 'Durada' : 'Duración'; ?></th>
                            <th class="p-2 text-left font-semibold text-warm-900 border border-warm-200"><?php echo $lang === 'ca' ? 'Tipus' : 'Tipo'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="p-2 border border-warm-200">wordpress_logged_in_*</td><td class="p-2 border border-warm-200">WordPress</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Mantenir sessió d\'usuari' : 'Mantener sesión de usuario'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Persistent' : 'Persistente'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Funcional' : 'Funcional'; ?></td></tr>
                        <tr><td class="p-2 border border-warm-200">wpEmojiSettingsSupports</td><td class="p-2 border border-warm-200">WordPress</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Guardar detalls del navegador' : 'Guardar detalles del navegador'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Sessió' : 'Sesión'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Funcional' : 'Funcional'; ?></td></tr>
                        <tr><td class="p-2 border border-warm-200">Google Fonts API</td><td class="p-2 border border-warm-200">Google Fonts</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Mostrar tipografies web' : 'Mostrar tipografías web'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Cap' : 'Ninguna'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Màrqueting' : 'Marketing'; ?></td></tr>
                        <tr><td class="p-2 border border-warm-200">rc::c / rc::b / rc::a</td><td class="p-2 border border-warm-200">Google reCAPTCHA</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Llegir i filtrar sol·licituds de bots' : 'Leer y filtrar solicitudes de bots'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Sessió / Persistent' : 'Sesión / Persistente'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Màrqueting' : 'Marketing'; ?></td></tr>
                        <tr><td class="p-2 border border-warm-200">Google Maps API</td><td class="p-2 border border-warm-200">Google Maps</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Mostrar mapes incrustats' : 'Mostrar mapas incrustados'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Cap' : 'Ninguna'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Màrqueting' : 'Marketing'; ?></td></tr>
                        <tr><td class="p-2 border border-warm-200">cmplz_*</td><td class="p-2 border border-warm-200">Complianz</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Gestió de consentiment de cookies' : 'Gestión de consentimiento de cookies'; ?></td><td class="p-2 border border-warm-200">365 <?php echo $lang === 'ca' ? 'dies' : 'días'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Funcional' : 'Funcional'; ?></td></tr>
                        <tr><td class="p-2 border border-warm-200">_ga / _ga_*</td><td class="p-2 border border-warm-200">Google Analytics</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Anàlisi de trànsit' : 'Análisis de tráfico'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Persistent' : 'Persistente'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Estadística' : 'Estadística'; ?></td></tr>
                        <tr><td class="p-2 border border-warm-200">santafe_consent_v1</td><td class="p-2 border border-warm-200">Santa Fe</td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Preferències de consentiment del tema' : 'Preferencias de consentimiento del tema'; ?></td><td class="p-2 border border-warm-200">365 <?php echo $lang === 'ca' ? 'dies' : 'días'; ?></td><td class="p-2 border border-warm-200"><?php echo $lang === 'ca' ? 'Funcional' : 'Funcional'; ?></td></tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">7. <?php echo $lang === 'ca' ? 'Consentiment' : 'Consentimiento'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Quan visitis la nostra web per primera vegada, et mostrarem una finestra emergent amb una explicació sobre les cookies. Tan bon punt facis clic a «Guardar la meva selecció», acceptes que fem servir les categories de cookies i plugins que has seleccionat a la finestra emergent, tal com es descriu en aquesta política de cookies. Pots desactivar l\'ús de cookies a través del teu navegador, però, si us plau, tingues en compte que la nostra web pot deixar de funcionar correctament.' : 'Cuando visites nuestra web por primera vez, te mostraremos una ventana emergente con una explicación sobre las cookies. Tan pronto como hagas clic en «Guardar mi selección», aceptas que usemos las categorías de cookies y plugins que has seleccionado en la ventana emergente, tal y como se describe en esta política de cookies. Puedes desactivar el uso de cookies a través de tu navegador, pero, por favor, ten en cuenta que nuestra web puede dejar de funcionar correctamente.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">8. <?php echo $lang === 'ca' ? 'Activació/desactivació i eliminació de cookies' : 'Activación/desactivación y borrado de cookies'; ?></h2>
                <p class="text-sm"><?php echo $lang === 'ca' ? 'Pots utilitzar el teu navegador d\'Internet per eliminar les cookies de forma automàtica o manual. També pots especificar que certes cookies no poden ser col·locades. Una altra opció és canviar els ajustos del teu navegador d\'Internet per rebre un missatge cada vegada que es col·loca una cookie. Tingues en compte que la nostra web pot no funcionar correctament si totes les cookies estan desactivades.' : 'Puedes utilizar tu navegador de Internet para eliminar las cookies de forma automática o manual. También puedes especificar que ciertas cookies no pueden ser colocadas. Otra opción es cambiar los ajustes de tu navegador de Internet para que recibas un mensaje cada vez que se coloca una cookie. Ten en cuenta que nuestra web puede no funcionar correctamente si todas las cookies están desactivadas.'; ?></p>
            </div>
            <div>
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">9. <?php echo $lang === 'ca' ? 'Els teus drets amb relació a les dades personals' : 'Tus derechos con respecto a los datos personales'; ?></h2>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <li><?php echo $lang === 'ca' ? 'Tens dret a saber per què es necessiten les teves dades personals, què passarà amb elles i durant quant de temps es conservaran.' : 'Tiene derecho a saber por qué se necesitan tus datos personales, qué sucederá con ellos y durante cuánto tiempo se conservarán.'; ?></li>
                    <li><?php echo $lang === 'ca' ? 'Dret d\'accés: tens dret a accedir a les teves dades personals que coneixem.' : 'Derecho de acceso: tienes derecho a acceder a tus datos personales que conocemos.'; ?></li>
                    <li><?php echo $lang === 'ca' ? 'Dret de rectificació: tens dret a completar, rectificar, esborrar o bloquejar les teves dades personals quan ho desitgis.' : 'Derecho de rectificación: tienes derecho a completar, rectificar, borrar o bloquear tus datos personales cuando lo desees.'; ?></li>
                    <li><?php echo $lang === 'ca' ? 'Si ens dones el teu consentiment per processar les teves dades, tens dret a revocar aquest consentiment i que s\'eliminin les teves dades personals.' : 'Si nos das tu consentimiento para procesar tus datos, tienes derecho a revocar dicho consentimiento y a que se eliminen tus datos personales.'; ?></li>
                    <li><?php echo $lang === 'ca' ? 'Dret de cessió de les teves dades: tens dret a sol·licitar totes les teves dades personals al responsable del tractament i a transferir-les íntegrament a un altre responsable del tractament.' : 'Derecho de cesión de tus datos: tienes derecho a solicitar todos tus datos personales al responsable del tratamiento y a transferirlos íntegramente a otro responsable del tratamiento.'; ?></li>
                    <li><?php echo $lang === 'ca' ? 'Dret d\'oposició: pots oposar-te al tractament de les teves dades.' : 'Derecho de oposición: puedes oponerte al tratamiento de tus datos.'; ?></li>
                </ul>
                <p class="mt-2 text-sm"><?php echo $lang === 'ca' ? 'Per exercir aquests drets, contacta amb nosaltres a ' . COMPANY_EMAIL . '. Si tens alguna queixa sobre com gestionem les teves dades, també tens dret a enviar una queixa a l\'autoritat de protecció de dades.' : 'Para ejercer estos derechos, contacta con nosotros en ' . COMPANY_EMAIL . '. Si tienes alguna queja sobre cómo gestionamos tus datos, también tienes derecho a enviar una queja a la autoridad de protección de datos.'; ?></p>
            </div>
            <div class="bg-warm-50 border border-warm-200 rounded-sm p-8">
                <h2 class="font-display font-bold text-xl text-warm-900 mb-4">10. <?php echo $lang === 'ca' ? 'Dades de contacte' : 'Datos de contacto'; ?></h2>
                <p class="space-y-1 text-sm">
                    <strong class="text-warm-900">CONSTRUCCIONS SANTA FE SIGLO XXI SL.</strong><br>
                    CALLE CAMPCARDOS, 49 - PISO 4 PTA 3 - 17006 GIRONA (Girona)<br>
                    <?php echo $lang === 'ca' ? 'Espanya' : 'España'; ?><br>
                    Web: https://santafe-construcciones.com<br>
                    Email: <?php echo COMPANY_EMAIL; ?><br>
                    <?php echo $lang === 'ca' ? 'Telèfon' : 'Teléfono'; ?>: <?php echo COMPANY_PHONE_DISPLAY; ?>
                </p>
            </div>
            <p><button type="button" onclick="cookieConsent.showSettings()" class="text-brand-400 hover:text-brand-300 underline"><?php echo $lang === 'ca' ? 'Configurar cookies' : 'Configurar cookies'; ?></button></p>

            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
