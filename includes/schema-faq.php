<?php
/**
 * Schema JSON-LD — FAQPage
 * Preguntas frecuentes para la homepage
 */

declare(strict_types=1);

function get_schema_faq_page(string $lang = 'es'): string {
    $faqs = $lang === 'ca' ? [
        [
            'q' => 'Quant costa una reforma integral a Barcelona?',
            'a' => 'El cost depèn dels metres quadrats, l\'estat inicial i el nivell d\'acabat. La nostra calculadora online et dóna una forquilla inicial realista. Per a un pressupost tancat, programem una visita tècnica gratuïta.',
        ],
        [
            'q' => 'Gestionau les llicències d\'obra?',
            'a' => 'Sí. Gestionem tots els tràmits municipals, llicències d\'obra major i menor, i certificacions necessàries des del primer dia del projecte.',
        ],
        [
            'q' => 'Qui supervisa l\'obra?',
            'a' => 'Paulo Pereira, fundador de Santa Fe Construcciones, supervisa personalment cada obra. No deleguem la responsabilitat a tercers.',
        ],
        [
            'q' => 'Treballau a Girona i Tarragona?',
            'a' => 'Sí. Operem a Barcelona, Girona i Tarragona. Comptem amb equips locals a cada zona per garantir temps de resposta ràpids.',
        ],
    ] : [
        [
            'q' => '¿Cuánto cuesta una reforma integral en Barcelona?',
            'a' => 'El coste depende de los metros cuadrados, el estado inicial y el nivel de acabado. Nuestra calculadora online te da una horquilla inicial realista. Para un presupuesto cerrado, programamos una visita técnica gratuita.',
        ],
        [
            'q' => '¿Gestionáis las licencias de obra?',
            'a' => 'Sí. Gestionamos todos los trámites municipales, licencias de obra mayor y menor, y certificaciones necesarias desde el primer día del proyecto.',
        ],
        [
            'q' => '¿Quién supervisa la obra?',
            'a' => 'Paulo Pereira, fundador de Santa Fe Construcciones, supervisa personalmente cada obra. No delegamos la responsabilidad a terceros.',
        ],
        [
            'q' => '¿Trabajáis en Girona y Tarragona?',
            'a' => 'Sí. Operamos en Barcelona, Girona y Tarragona. Contamos con equipos locales en cada zona para garantizar tiempos de respuesta rápidos.',
        ],
    ];

    return get_schema_faq($faqs);
}
