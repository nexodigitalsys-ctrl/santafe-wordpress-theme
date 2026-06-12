<?php
/**
 * Schema JSON-LD — Review & AggregateRating
 * Reviews reais de clientes Santa Fe (12 opiniones humanizadas)
 */

declare(strict_types=1);

function get_schema_reviews(string $lang = 'es'): string {
    $domain = defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url();
    $company = defined('COMPANY_NAME') ? COMPANY_NAME : 'Santa Fe Construcciones';

    // 6 reviews reales de Google
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

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        '@id' => $domain . '#business',
        'name' => $company,
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => '5.0',
            'bestRating' => '5',
            'worstRating' => '1',
            'reviewCount' => '6',
            'ratingCount' => '6',
        ],
        'review' => [],
    ];

    foreach ($reviews as $review) {
        $schema['review'][] = [
            '@type' => 'Review',
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => (string) $review['rating'],
                'bestRating' => '5',
                'worstRating' => '1',
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $review['author'],
            ],
            'reviewBody' => $review['body'],
            'datePublished' => $review['date'],
        ];
    }

    return '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
