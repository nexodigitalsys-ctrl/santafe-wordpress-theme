<?php
/**
 * Schema JSON-LD — Review & AggregateRating
 * 6 reviews reales de Google para fusionar en el nodo LocalBusiness principal.
 */

declare(strict_types=1);

/**
 * Provee aggregateRating + review[] como ARRAY para fusionar DENTRO del nodo
 * LocalBusiness principal (ver get_schema_localbusiness($domain, $business_extra)).
 * NO emite bloque <script> propio: un segundo nodo con el mismo @id y otro
 * aggregateRating provoca "La reseña tiene varias puntuaciones agregadas" en GSC.
 */
function get_reviews_extra_data(string $lang = 'es'): array {
    $reviews = [
        [
            'author' => 'Guilherme Gomes',
            'rating' => 5,
            'body' => 'Calidad y responsabilidad 👏…',
            'date' => '2026-06-12',
        ],
        [
            'author' => 'Luiz Philipe Goncalves Magalhaes',
            'rating' => 5,
            'body' => 'Excelente empresa de construcción. Muy profesionales, responsables y comprometidos con la calidad de su trabajo. Cumplieron los plazos acordados y el resultado final superó mis expectativas. Recomiendo sus servicios al 100%.',
            'date' => '2026-06-12',
        ],
        [
            'author' => 'Adriano Santana',
            'rating' => 5,
            'body' => 'Profesionales excelentes y trabajos de calidad',
            'date' => '2026-06-12',
        ],
        [
            'author' => 'Enoque Santos',
            'rating' => 5,
            'body' => 'Grandes profesionales. Arreglando todo lo que necesitaba, eficiente y rápidos en Sabadell Barcelona. Gracias Paulo',
            'date' => '2026-06-12',
        ],
        [
            'author' => 'AGENDA JUS EUROPA',
            'rating' => 5,
            'body' => 'Muy profesionales súper recomendable 👏🏻👏🏻👏🏻👏🏻…',
            'date' => '2026-06-12',
        ],
        [
            'author' => 'zapping peluqueros las tablas',
            'rating' => 5,
            'body' => 'sin comentarios',
            'date' => '2026-06-12',
        ],
    ];

    $extra = [
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => 5.0,
            'bestRating' => 5,
            'worstRating' => 1,
            'reviewCount' => 6,
            'ratingCount' => 6,
        ],
        'review' => [],
    ];

    foreach ($reviews as $review) {
        $extra['review'][] = [
            '@type' => 'Review',
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => (float) $review['rating'],
                'bestRating' => 5,
                'worstRating' => 1,
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $review['author'],
            ],
            'reviewBody' => $review['body'],
            'datePublished' => $review['date'],
        ];
    }

    return $extra;
}
