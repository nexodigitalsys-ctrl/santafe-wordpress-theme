<?php
/**
 * Schema JSON-LD — Servicios Individuales (Service)
 * Funciones para generar schema @type: Service por cada servicio core
 */

function get_schema_service($service_slug, $lang = 'es', $domain = 'https://www.dominio.com') {
    $services = [
        'obra-nueva' => [
            'es' => [
                'name' => 'Obra nueva en Barcelona y Girona',
                'description' => 'Construcción de viviendas y edificaciones desde cero. Gestión integral con licencias, coordinación de gremios y entrega con llave en mano.',
                'url' => $domain . '/es/servicios/obra-nueva/'
            ],
            'ca' => [
                'name' => 'Obra nova a Barcelona i Girona',
                'description' => 'Construcció de habitatges i edificacions des de zero. Gestió integral amb llicències, coordinació de gremis i lliurament amb clau en mà.',
                'url' => $domain . '/ca/serveis/obra-nova/'
            ]
        ],
        'reformas-integrales' => [
            'es' => [
                'name' => 'Reformas integrales en Barcelona y Girona',
                'description' => 'Reforma integral de viviendas y locales. Presupuesto cerrado, plazo garantizado, limpieza final incluida y acabados de alta calidad.',
                'url' => $domain . '/es/servicios/reformas-integrales/'
            ],
            'ca' => [
                'name' => 'Reformes integrals a Barcelona i Girona',
                'description' => 'Reforma integral d\'habitatges i locals. Pressupost tancat, termini garantit, neteja final inclosa i acabats d\'alta qualitat.',
                'url' => $domain . '/ca/serveis/reformes-integrals/'
            ]
        ],
        'pladur-acabados' => [
            'es' => [
                'name' => 'Pladur y acabados interiores en Barcelona y Girona',
                'description' => 'Especialistas en pladur, escayola, techos decorativos y acabados interiores premium para viviendas y negocios.',
                'url' => $domain . '/es/servicios/pladur-acabados/'
            ],
            'ca' => [
                'name' => 'Pladur i acabats interiors a Barcelona i Girona',
                'description' => 'Especialistes en pladur, escaiola, sostres decoratius i acabats interiors premium per a habitatges i negocis.',
                'url' => $domain . '/ca/serveis/pladur-acabats/'
            ]
        ],
        'obra-publica' => [
            'es' => [
                'name' => 'Obra pública en Barcelona y Girona',
                'description' => 'Infraestructuras públicas, urbanización, edificación municipal y proyectos para administraciones con certificación de calidad.',
                'url' => $domain . '/es/servicios/obra-publica/'
            ],
            'ca' => [
                'name' => 'Obra pública a Barcelona i Girona',
                'description' => 'Infraestructures públiques, urbanització, edificació municipal i projectes per a administracions amb certificació de qualitat.',
                'url' => $domain . '/ca/serveis/obra-publica/'
            ]
        ],
        'obra-civil' => [
            'es' => [
                'name' => 'Obra civil en Barcelona y Girona',
                'description' => 'Estructuras de hormigón, cimentaciones, muros de contención, canalizaciones y obra civil de alta resistencia.',
                'url' => $domain . '/es/servicios/obra-civil/'
            ],
            'ca' => [
                'name' => 'Obra civil a Barcelona i Girona',
                'description' => 'Estructures de formigó, fonamentacions, murs de contenció, canalitzacions i obra civil d\'alta resistència.',
                'url' => $domain . '/ca/serveis/obra-civil/'
            ]
        ]
    ];

    if (!isset($services[$service_slug][$lang])) {
        return '';
    }

    $svc = $services[$service_slug][$lang];

    $schema = [
        "@context" => "https://schema.org",
        "@type" => "Service",
        "@id" => $svc['url'] . "#service",
        "serviceType" => $svc['name'],
        "name" => $svc['name'],
        "description" => $svc['description'],
        "url" => $svc['url'],
        "provider" => [
            "@id" => $domain . "#business"
        ],
        "areaServed" => [
            [
                "@type" => "City",
                "name" => $lang === 'es' ? 'Barcelona' : 'Barcelona'
            ],
            [
                "@type" => "City",
                "name" => $lang === 'es' ? 'Girona' : 'Girona'
            ]
        ],
        "availableChannel" => [
            "@type" => "ServiceChannel",
            "servicePhone" => [
                "@type" => "ContactPoint",
                "telephone" => "+34665737547",
                "contactType" => "sales",
                "availableLanguage" => ["Spanish", "Catalan"]
            ],
            "serviceSms" => [
                "@type" => "ContactPoint",
                "telephone" => "+34665737547",
                "contactType" => "sales"
            ]
        ]
    ];

    return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function get_schema_breadcrumb($items, $domain = 'https://www.dominio.com') {
    $itemListElement = [];
    $position = 1;
    foreach ($items as $item) {
        $itemListElement[] = [
            "@type" => "ListItem",
            "position" => $position++,
            "name" => $item['name'],
            "item" => $domain . $item['url']
        ];
    }

    $schema = [
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList",
        "itemListElement" => $itemListElement
    ];

    return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
