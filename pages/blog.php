<?php
/**
 * Blog — Hub com 12 artigos SEO
 */

declare(strict_types=1);

$lang = isset($current_lang) ? $current_lang : 'es';
$isCa = $lang === 'ca';
$translations = load_translations($lang);

$page_data = [
    'lang' => $lang,
    'title' => $isCa ? 'Blog de reformes i construcció | Santa Fe' : 'Blog de reformas y construcción | Santa Fe',
    'description' => $isCa ? 'Guies pràctiques sobre reformes, obra nova, pladur, llicències i pressupostos a Catalunya.' : 'Guías prácticas sobre reformas, obra nueva, pladur, licencias y presupuestos en Cataluña.',
    'canonical' => COMPANY_DOMAIN . '/' . $lang . '/blog/',
    'schemas' => [],
];

$posts = [
    ['slug' => 'cuanto-cuesta-reformar-piso-barcelona', 'title' => 'Cuánto cuesta reformar un piso en Barcelona en 2024: precios reales por m²', 'desc' => 'Desglose detallado de costes por m² para acabados básico, estándar y premium. Factores que modifican el presupuesto y ejemplos prácticos.', 'tag' => 'Precios'],
    ['slug' => 'licencias-reformas-integrales-cataluna', 'title' => 'Licencias para reformas integrales en Cataluña: guía completa 2024', 'desc' => '¿Cuándo necesitas permiso? Tipos de licencia, documentación requerida, plazos y errores comunes que retrasan tu obra.', 'tag' => 'Licencias'],
    ['slug' => 'pladur-cuando-conviene-cuanto-cuesta', 'title' => 'Pladur: cuándo conviene, cuánto cuesta y qué debes saber antes de instalarlo', 'desc' => 'Usos del pladur en techos, tabiques y trasdosados. Precios por m², aislamiento acústico y errores comunes.', 'tag' => 'Pladur'],
    ['slug' => 'errores-encarecen-reforma', 'title' => '7 errores que encarecen una reforma (y cómo evitarlos)', 'desc' => 'Decisiones improvisadas, cambios sin documentar y falta de coordinación entre gremios pueden duplicar tu presupuesto.', 'tag' => 'Reformas'],
    ['slug' => 'como-elegir-empresa-reformas-barcelona', 'title' => 'Cómo elegir una empresa de reformas en Barcelona: 8 preguntas que debes hacer', 'desc' => 'Señales de alerta, preguntas clave y cómo verificar la experiencia real de una empresa de construcción.', 'tag' => 'Guía'],
    ['slug' => 'reforma-integral-vs-parcial', 'title' => 'Reforma integral vs reforma parcial: qué conviene y cuándo', 'desc' => 'Diferencias, costes, plazos y situaciones donde cada opción tiene sentido. Marco de decisión práctico.', 'tag' => 'Guía'],
    ['slug' => 'cuanto-tarda-reforma-integral', 'title' => 'Cuánto tarda una reforma integral: plazos reales según el tipo de obra', 'desc' => 'Desglose de plazos por fase. Factores que alargan o acortan el calendario y ejemplos reales por tamaño de piso.', 'tag' => 'Plazos'],
    ['slug' => 'obra-nueva-barcelona-guia', 'title' => 'Obra nueva en Barcelona: guía completa para construir tu casa en 2024', 'desc' => 'Pasos desde la compra del terreno hasta la entrega. Licencias, costes por m² y errores que cometen los primerizos.', 'tag' => 'Obra nueva'],
    ['slug' => 'materiales-reforma-calidad-precio', 'title' => 'Materiales para reformas: cómo elegir entre calidad y precio sin arrepentirte', 'desc' => 'Dónde invertir y dónde ahorrar. Suelos, grifería, encimeras y pintura: comparativa por durabilidad y coste.', 'tag' => 'Materiales'],
    ['slug' => 'humedades-viviendas-causas-soluciones', 'title' => 'Humedades en viviendas: causas, tipos y soluciones definitivas', 'desc' => 'Cómo identificar cada tipo de humedad, cuándo puedes arreglarlo tú y cuándo necesitas un profesional.', 'tag' => 'Problemas'],
    ['slug' => 'pago-fraccionado-reformas', 'title' => 'Pago fraccionado en reformas: cómo funciona y por qué es más seguro', 'desc' => 'Estructura de pagos por hitos, contrato y señales de alerta. Cómo proteger tu dinero durante la obra.', 'tag' => 'Financiación'],
    ['slug' => 'reformas-edificios-antiguos-barcelona', 'title' => 'Reformas en edificios antiguos de Barcelona: riesgos y recomendaciones', 'desc' => 'Amianto, tuberías de plomo, electricidad obsoleta. Cómo modernizar sin perder el carácter del edificio.', 'tag' => 'Reformas'],
];

include __DIR__ . '/../includes/header.php';
?>

<section class="pt-32 pb-20 md:pb-28 bg-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-px bg-brand-500/40"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="max-w-4xl">
            <div class="flex items-center gap-4 mb-6">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">Blog</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white tracking-tight mb-6 leading-[1.1]">
                <?php echo $isCa ? 'Guies per decidir millor<br>abans de començar una obra' : 'Guías para decidir mejor<br>antes de empezar una obra'; ?>
            </h1>
            <p class="text-warm-600 text-lg md:text-xl leading-relaxed max-w-2xl">
                <?php echo $isCa ? 'Contingut pràctic sobre costos, llicències, terminis i decisions que convé tancar abans d\'obrir una reforma.' : 'Contenido práctico sobre costes, licencias, plazos y decisiones que conviene cerrar antes de abrir una reforma.'; ?>
            </p>
        </div>
    </div>
</section>

<section class="py-24 md:py-32 bg-warm-50 border-y border-warm-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($posts as $post): ?>
            <article class="bg-white border border-warm-200 rounded-sm p-6 card-lift group">
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.25em]"><?php echo $post['tag']; ?></span>
                <h2 class="font-display font-bold text-xl text-warm-900 mt-4 mb-3 group-hover:text-brand-400 transition-colors">
                    <a href="/<?php echo $lang; ?>/blog/<?php echo $post['slug']; ?>/" class="focus:outline-none">
                        <?php echo $post['title']; ?>
                    </a>
                </h2>
                <p class="text-warm-500 text-sm leading-relaxed mb-4"><?php echo $post['desc']; ?></p>
                <a href="/<?php echo $lang; ?>/blog/<?php echo $post['slug']; ?>/" class="inline-flex items-center gap-2 text-brand-500 text-sm font-semibold group/link">
                    <?php echo $isCa ? 'Llegir més' : 'Leer más'; ?> <span class="transition-transform group-hover/link:translate-x-1">→</span>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 md:py-32 bg-white relative overflow-hidden" data-reveal>
    <div class="absolute inset-0 opacity-5 cta-bg-pattern"></div>
    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl text-warm-900 tracking-tight mb-6">
            <?php echo $isCa ? '¿Necessites ajuda amb el teu projecte?' : '¿Necesitas ayuda con tu proyecto?'; ?>
        </h2>
        <p class="text-warm-600 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
            <?php echo $isCa ? 'Contacta amb Paulo per WhatsApp o sol·licita un pressupost tancat gratuït.' : 'Contacta con Paulo por WhatsApp o solicita un presupuesto cerrado gratuito.'; ?>
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20he%20leído%20el%20blog"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-[#25d366] hover:bg-[#128c7e] text-white font-medium px-5 py-2.5 rounded-xl transition-all tracking-wide text-xs uppercase">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <?php echo $isCa ? 'WhatsApp — Respon en 2 h' : 'WhatsApp — Responde en 2 h'; ?>
            </a>
            <a href="/<?php echo $lang; ?>/contacto/"
               class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-medium px-5 py-2.5 rounded-xl transition-all tracking-wide text-xs uppercase">
                <?php echo $isCa ? 'Solicitar pressupost' : 'Solicitar presupuesto'; ?>
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
