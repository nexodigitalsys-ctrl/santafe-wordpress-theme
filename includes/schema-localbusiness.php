<?php
/**
 * Schema JSON-LD — LocalBusiness + ConstructionCompany (Principal)
 * Inyectar en <head> de todas las páginas
 * Adaptar domain real en producción
 */

function get_schema_localbusiness($domain = 'https://www.dominio.com') {
    $schema = [
        "@context" => "https://schema.org",
        "@graph" => [
            [
                "@type" => ["LocalBusiness", "ConstructionCompany"],
                "@id" => $domain . "#business",
                "name" => "Construcciones Santa Fe Siglo XXI SLU",
                "alternateName" => "Santa Fe Construcciones",
                "url" => $domain,
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => $domain . "/assets/images/logo-santafe.png",
                    "width" => 512,
                    "height" => 512
                ],
                "image" => [
                    "@type" => "ImageObject",
                    "url" => $domain . "/assets/images/team-santafe.jpg",
                    "width" => 1200,
                    "height" => 800
                ],
                "telephone" => "+34665737547",
                "email" => "Constrsantafe@gmail.com",
                "priceRange" => "€€",
                "description" => "Empresa de construcción, obra nueva, reformas integrales, pladur, obra pública y obra civil en Barcelona y Girona. Más de 15 años de experiencia.",
                "address" => [
                    "@type" => "PostalAddress",
                    "addressLocality" => "Barcelona",
                    "addressRegion" => "Cataluña",
                    "addressCountry" => "ES"
                ],
                "geo" => [
                    "@type" => "GeoCoordinates",
                    "latitude" => 41.3851,
                    "longitude" => 2.1734
                ],
                "openingHoursSpecification" => [
                    [
                        "@type" => "OpeningHoursSpecification",
                        "dayOfWeek" => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                        "opens" => "08:00",
                        "closes" => "18:00"
                    ]
                ],
                "areaServed" => [
                    [
                        "@type" => "City",
                        "name" => "Barcelona",
                        "containedInPlace" => [
                            "@type" => "AdministrativeArea",
                            "name" => "Provincia de Barcelona"
                        ]
                    ],
                    [
                        "@type" => "City",
                        "name" => "Girona",
                        "containedInPlace" => [
                            "@type" => "AdministrativeArea",
                            "name" => "Provincia de Girona"
                        ]
                    ]
                ],
                "hasOfferCatalog" => [
                    "@type" => "OfferCatalog",
                    "name" => "Servicios de construcción",
                    "itemListElement" => [
                        [
                            "@type" => "Offer",
                            "itemOffered" => [
                                "@type" => "Service",
                                "name" => "Obra nueva"
                            ]
                        ],
                        [
                            "@type" => "Offer",
                            "itemOffered" => [
                                "@type" => "Service",
                                "name" => "Reformas integrales"
                            ]
                        ],
                        [
                            "@type" => "Offer",
                            "itemOffered" => [
                                "@type" => "Service",
                                "name" => "Pladur y acabados interiores"
                            ]
                        ],
                        [
                            "@type" => "Offer",
                            "itemOffered" => [
                                "@type" => "Service",
                                "name" => "Obra pública"
                            ]
                        ],
                        [
                            "@type" => "Offer",
                            "itemOffered" => [
                                "@type" => "Service",
                                "name" => "Obra civil"
                            ]
                        ]
                    ]
                ],
                "contactPoint" => [
                    [
                        "@type" => "ContactPoint",
                        "telephone" => "+34665737547",
                        "contactType" => "sales",
                        "availableLanguage" => ["Spanish", "Catalan"],
                        "areaServed" => "ES"
                    ],
                    [
                        "@type" => "ContactPoint",
                        "email" => "Constrsantafe@gmail.com",
                        "contactType" => "customer service",
                        "availableLanguage" => ["Spanish", "Catalan"]
                    ]
                ],
                "sameAs" => [
                    "https://wa.me/34665737547"
                ]
            ],
            [
                "@type" => "WebSite",
                "@id" => $domain . "#website",
                "url" => $domain,
                "name" => "Construcciones Santa Fe Siglo XXI SLU",
                "publisher" => [
                    "@id" => $domain . "#business"
                ],
                "potentialAction" => [
                    "@type" => "SearchAction",
                    "target" => [
                        "@type" => "EntryPoint",
                        "urlTemplate" => $domain . "/es/buscar?q={search_term_string}"
                    ],
                    "query-input" => "required name=search_term_string"
                ],
                "inLanguage" => ["es-ES", "ca-ES"]
            ]
        ]
    ];
    return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
