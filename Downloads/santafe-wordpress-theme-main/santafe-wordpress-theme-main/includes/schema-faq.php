<?php
/**
 * Schema JSON-LD — FAQPage
 * Preguntas frecuentes ricas en keywords SEO
 */

declare(strict_types=1);

function get_schema_faq_page(string $lang = 'es'): string {
    $faqs = $lang === 'ca' ? [
        [
            'q' => 'Quant costa una reforma integral a Barcelona?',
            'a' => 'El cost d\'una reforma integral a Barcelona depèn dels metres quadrats, l\'estat inicial i el nivell d\'acabat. Per donar-te una forquilla realista, hem creat una calculadora online. Per a un pressupost tancat i per escrit, programem una visita tècnica gratuïta sense compromís.',
        ],
        [
            'q' => 'Gestioneu les llicències d\'obra a Barcelona i Girona?',
            'a' => 'Sí, les llicències d\'obra estan incloses en tots els nostres projectes. Gestionem tràmits municipals a Barcelona, Girona i Tarragona: llicències d\'obra major, obra menor, certificacions i comunicacions. Tu no has de preocupar-te de la paperassa.',
        ],
        [
            'q' => 'Qui supervisa l\'obra? Tindré un interlocutor únic?',
            'a' => 'Paulo Pereira, fundador de Santa Fe Construcciones, supervisa personalment cada obra i és el teu únic interlocutor. No hi ha call centers ni intermediaris: parles directament amb qui pren decisions. Respon al WhatsApp i al telèfon habitualment en menys de 2 hores.',
        ],
        [
            'q' => 'Feu obra nova o només reformes?',
            'a' => 'Fem tant obra nova com a reformes integrals. Obra nova des de zero (cases, locals, edificis), reforma integral de pisos i locals, pladur i acabats, obra pública per a administracions i obra civil (murs, fonamentacions, estructures).',
        ],
        [
            'q' => 'Treballes a Girona i Tarragona, o només a Barcelona?',
            'a' => 'Operem a les tres províncies: Barcelona, Girona i Tarragona. Tenim equips locals a cada zona per garantir temps de resposta ràpids i coneixement de la normativa municipal específica de cada ajuntament.',
        ],
        [
            'q' => 'Puc pagar l\'obra a terminis?',
            'a' => 'Sí, oferim finançament a mesura amb pagament fraccionat vinculat a fites de l\'obra. No has de pagar-ho tot al principi. Cada pagament està lligat a una fase concreta completada i verificada.',
        ],
        [
            'q' => 'Quin tipus de garantia oferiu?',
            'a' => 'Tota la nostra obra té 2 anys de garantia d\'execució. A més, tenim assegurança de responsabilitat civil, tots els treballadors donats d\'alta a la Seguretat Social (TC1/TC2) i gestionem totes les llicències. Si surt alguna cosa, ho arreglem sense cost.',
        ],
        [
            'q' => 'Puc viure al pis mentre es fa la reforma?',
            'a' => 'Depèn de l\'abast. Per reformes parcials (cuina, bany) sovint és possible organitzar les obres per zones i protegir l\'espai habitable. Per reformes integrals completes, recomanem buscar alternativa temporal. T\'ho assessorem a la visita tècnica.',
        ],
    ] : [
        [
            'q' => '¿Cuánto cuesta una reforma integral en Barcelona?',
            'a' => 'El coste de una reforma integral en Barcelona depende de los metros cuadrados, el estado inicial y el nivel de acabado. Para darte una horquilla realista, hemos creado una calculadora online. Para un presupuesto cerrado y por escrito, programamos una visita técnica gratuita sin compromiso.',
        ],
        [
            'q' => '¿Gestionáis las licencias de obra en Barcelona y Girona?',
            'a' => 'Sí, las licencias de obra están incluidas en todos nuestros proyectos. Gestionamos trámites municipales en Barcelona, Girona y Tarragona: licencias de obra mayor, obra menor, certificaciones y comunicaciones. Tú no tienes que preocuparte del papeleo.',
        ],
        [
            'q' => '¿Quién supervisa la obra? ¿Tendré un interlocutor único?',
            'a' => 'Paulo Pereira, fundador de Santa Fe Construcciones, supervisa personalmente cada obra y es tu único interlocutor. No hay call centers ni intermediarios: hablas directamente con quien toma decisiones. Responde al WhatsApp y al teléfono habitualmente en menos de 2 horas.',
        ],
        [
            'q' => '¿Hacéis obra nueva o solo reformas?',
            'a' => 'Hacemos tanto obra nueva como reformas integrales. Obra nueva desde cero (casas, locales, edificios), reforma integral de pisos y locales, pladur y acabados, obra pública para administraciones y obra civil (muros, cimentaciones, estructuras).',
        ],
        [
            'q' => '¿Trabajáis en Girona y Tarragona, o solo en Barcelona?',
            'a' => 'Operamos en las tres provincias: Barcelona, Girona y Tarragona. Contamos con equipos locales en cada zona para garantizar tiempos de respuesta rápidos y conocimiento de la normativa municipal específica de cada ayuntamiento.',
        ],
        [
            'q' => '¿Puedo pagar la obra a plazos?',
            'a' => 'Sí, ofrecemos financiación a medida con pago fraccionado vinculado a hitos de la obra. No tienes que pagarlo todo al principio. Cada pago está ligado a una fase concreta completada y verificada.',
        ],
        [
            'q' => '¿Qué tipo de garantía ofrecéis?',
            'a' => 'Toda nuestra obra tiene 2 años de garantía de ejecución. Además, tenemos seguro de responsabilidad civil, todos los trabajadores dados de alta en la Seguridad Social (TC1/TC2) y gestionamos todas las licencias. Si sale algo, lo arreglamos sin costo.',
        ],
        [
            'q' => '¿Puedo vivir en el piso mientras se hace la reforma?',
            'a' => 'Depende del alcance. Para reformas parciales (cocina, baño) a menudo es posible organizar las obras por zonas y proteger el espacio habitable. Para reformas integrales completas, recomendamos buscar alternativa temporal. Te lo asesoramos en la visita técnica.',
        ],
    ];

    return get_schema_faq($faqs);
}
