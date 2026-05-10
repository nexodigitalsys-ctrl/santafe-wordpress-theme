<?php
/**
 * Schema JSON-LD — Review & AggregateRating
 * Placeholder estructurado para cuando haya reviews reales
 */

declare(strict_types=1);

function get_schema_reviews(array $reviews = [], float $rating_value = 0, int $review_count = 0): string {
    if (empty($reviews) && $review_count === 0) {
        return '';
    }

    $domain = defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url();
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        '@id' => $domain . '#business',
        'name' => defined('COMPANY_NAME') ? COMPANY_NAME : 'Santa Fe Construcciones',
    ];

    if ($review_count > 0) {
        $schema['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $rating_value,
            'bestRating' => '5',
            'reviewCount' => (string) $review_count,
        ];
    }

    if (!empty($reviews)) {
        $schema['review'] = [];
        foreach ($reviews as $review) {
            $schema['review'][] = [
                '@type' => 'Review',
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => (string) ($review['rating'] ?? 5),
                    'bestRating' => '5',
                ],
                'author' => [
                    '@type' => 'Person',
                    'name' => $review['author'] ?? 'Cliente',
                ],
                'reviewBody' => $review['body'] ?? '',
                'datePublished' => $review['date'] ?? date('Y-m-d'),
            ];
        }
    }

    return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
