<?php
/**
 * Sección FAQ Visual — Acordeón vanilla JS
 * Preguntas frecuentes ricas en keywords SEO
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Preguntes que ens fan abans de començar' : 'Preguntas que nos hacen antes de empezar';
$subtitle = $lang === 'ca'
    ? 'Si no trobes la teva resposta, truca a Pablo directament. Respon personalment.'
    : 'Si no encuentras tu respuesta, llama a Pablo directamente. Responde personalmente.';

$faqs = $lang === 'ca' ? [
    [
        'q' => 'Quant costa una reforma integral a Barcelona?',
        'a' => 'El cost depèn dels metres quadrats, l\'estat inicial i el nivell d\'acabat. La nostra calculadora online et dóna una forquilla inicial realista. Per a un pressupost tancat i per escrit, programem una visita tècnica gratuïta sense compromís.',
    ],
    [
        'q' => 'Gestioneu les llicències d\'obra?',
        'a' => 'Sí, estan incloses. Gestionem tràmits municipals a Barcelona, Girona i Tarragona: llicències d\'obra major i menor, certificacions i comunicacions. Tu no has de preocupar-te de la paperassa.',
    ],
    [
        'q' => 'Qui supervisa l\'obra? Tindré un interlocutor únic?',
        'a' => 'Paulo Pereira supervisa personalment cada obra i és el teu únic interlocutor. No hi ha call centers: parles directament amb qui pren decisions. Respon al WhatsApp habitualment en menys de 2 hores.',
    ],
    [
        'q' => 'Feu obra nova o només reformes?',
        'a' => 'Tots dos. Obra nova des de zero (cases, locals, edificis), reforma integral de pisos, pladur i acabats, obra pública per a administracions i obra civil (murs, fonamentacions, estructures).',
    ],
    [
        'q' => 'Puc pagar l\'obra a terminis?',
        'a' => 'Sí. Oferim pagament fraccionat vinculat a fites de l\'obra. No has de pagar-ho tot al principi. Cada pagament està lligat a una fase concreta completada i verificada.',
    ],
    [
        'q' => 'Quina garantia oferiu?',
        'a' => '2 anys de garantia d\'execució, assegurança de responsabilitat civil, equip donat d\'alta a la Seguretat Social (TC1/TC2) i totes les llicències incloses. Si surt alguna cosa, ho arreglem sense cost.',
    ],
] : [
    [
        'q' => '¿Cuánto cuesta una reforma integral en Barcelona?',
        'a' => 'El coste depende de los metros cuadrados, el estado inicial y el nivel de acabado. Nuestra calculadora online te da una horquilla inicial realista. Para un presupuesto cerrado y por escrito, programamos una visita técnica gratuita sin compromiso.',
    ],
    [
        'q' => '¿Gestionáis las licencias de obra?',
        'a' => 'Sí, están incluidas. Gestionamos trámites municipales en Barcelona, Girona y Tarragona: licencias de obra mayor y menor, certificaciones y comunicaciones. Tú no tienes que preocuparte del papeleo.',
    ],
    [
        'q' => '¿Quién supervisa la obra? ¿Tendré un interlocutor único?',
        'a' => 'Paulo Pereira supervisa personalmente cada obra y es tu único interlocutor. No hay call centers: hablas directamente con quien toma decisiones. Responde al WhatsApp habitualmente en menos de 2 horas.',
    ],
    [
        'q' => '¿Hacéis obra nueva o solo reformas?',
        'a' => 'Ambas. Obra nueva desde cero (casas, locales, edificios), reforma integral de pisos, pladur y acabados, obra pública para administraciones y obra civil (muros, cimentaciones, estructuras).',
    ],
    [
        'q' => '¿Puedo pagar la obra a plazos?',
        'a' => 'Sí. Ofrecemos pago fraccionado vinculado a hitos de la obra. No tienes que pagarlo todo al principio. Cada pago está ligado a una fase concreta completada y verificada.',
    ],
    [
        'q' => '¿Qué garantía ofrecéis?',
        'a' => '2 años de garantía de ejecución, seguro de responsabilidad civil, equipo dado de alta en la Seguridad Social (TC1/TC2) y todas las licencias incluidas. Si sale algo, lo arreglamos sin costo.',
    ],
];
?>

<section data-reveal class="py-24 md:py-32 bg-slate-950 border-t border-slate-800" id="faq">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">FAQ</span>
                <div class="industrial-line industrial-line-reverse w-12"></div>
            </div>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-4"><?php echo $title; ?></h2>
            <p class="text-slate-400 text-lg"><?php echo $subtitle; ?></p>
        </div>

        <div class="space-y-4" id="faq-accordion">
            <?php foreach ($faqs as $i => $faq): ?>
            <div class="faq-item bg-slate-900 border border-slate-800 rounded-sm overflow-hidden hover:border-slate-600 transition-colors">
                <button
                    class="faq-trigger w-full flex items-center justify-between p-6 text-left group"
                    aria-expanded="false"
                    data-index="<?php echo $i; ?>"
                >
                    <span class="font-display font-semibold text-white text-lg pr-4 group-hover:text-brand-400 transition-colors"><?php echo htmlspecialchars($faq['q'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="faq-icon w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center flex-shrink-0 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-white transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75"/>
                        </svg>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6">
                    <p class="text-slate-300 leading-relaxed"><?php echo htmlspecialchars($faq['a'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA debajo del FAQ -->
        <div class="mt-12 text-center">
            <p class="text-slate-400 mb-4"><?php echo $lang === 'ca' ? 'Encara tens dubtes?' : '¿Todavía tienes dudas?'; ?></p>
            <a href="#contacto" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-slate-950 font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                <?php echo $lang === 'ca' ? 'Parlar amb Pablo ara' : 'Hablar con Pablo ahora'; ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <script>
    (function() {
        const accordion = document.getElementById('faq-accordion');
        if (!accordion) return;
        const items = accordion.querySelectorAll('.faq-item');
        items.forEach(function(item) {
            const trigger = item.querySelector('.faq-trigger');
            const content = item.querySelector('.faq-content');
            const icon = item.querySelector('.faq-icon');
            const svg = item.querySelector('.faq-icon svg');
            trigger.addEventListener('click', function() {
                const isOpen = !content.classList.contains('hidden');
                // Close all
                items.forEach(function(otherItem) {
                    otherItem.querySelector('.faq-content').classList.add('hidden');
                    otherItem.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
                    otherItem.querySelector('.faq-icon').classList.remove('bg-brand-600');
                    otherItem.querySelector('.faq-icon').classList.add('bg-slate-800');
                    otherItem.querySelector('.faq-icon svg').style.transform = 'rotate(0deg)';
                });
                // Toggle current
                if (!isOpen) {
                    content.classList.remove('hidden');
                    trigger.setAttribute('aria-expanded', 'true');
                    icon.classList.remove('bg-slate-800');
                    icon.classList.add('bg-brand-600');
                    svg.style.transform = 'rotate(45deg)';
                }
            });
        });
    })();
    </script>
</section>
