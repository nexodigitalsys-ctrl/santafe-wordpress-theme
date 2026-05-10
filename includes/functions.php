<?php
/**
 * includes/functions.php — Helpers genéricos del frontend
 * SEO, breadcrumbs, helpers de contenido, imágenes responsive, schemas
 */

declare(strict_types=1);

/**
 * Obtiene contenido traducible desde la base de datos (fallback a JSON i18n)
 */
function getContent(string $key, string $lang = 'es', string $context = 'general'): string {
    try {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT content_value FROM content WHERE content_key = :key AND lang = :lang AND page_context = :ctx LIMIT 1");
        $stmt->execute([':key' => $key, ':lang' => $lang, ':ctx' => $context]);
        $result = $stmt->fetchColumn();
        return $result !== false ? $result : '';
    } catch (Throwable $e) {
        return '';
    }
}

/**
 * Obtiene proyectos publicados para la galería
 */
function getPublishedProjects(int $limit = 6, bool $featured_only = false): array {
    try {
        $pdo = Database::getInstance();
        $sql = "SELECT slug, title_es, title_ca, description_es, description_ca, image_main, service_type, location, year FROM projects WHERE status = 'published'";
        if ($featured_only) $sql .= " AND is_featured = 1";
        $sql .= " ORDER BY year DESC, updated_at DESC LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Obtiene servicios activos ordenados
 */
function getServices(): array {
    try {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT slug, name_es, name_ca, short_desc_es, short_desc_ca, icon_class, meta_title_es, meta_description_es FROM services ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Obtiene slides activos del hero
 */
function getActiveSlides(): array {
    try {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM slider_images WHERE is_active = 1 ORDER BY slide_order ASC");
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Genera tag <picture> con WebP/AVIF fallback
 * @param string $src Camino de la imagen original (ej: /assets/images/portfolio/reforma1.jpg)
 * @param string $alt Texto alternativo
 * @param string $class Clases CSS
 * @param string $sizes Atributo sizes
 * @param bool $lazy Si debe usar loading="lazy"
 * @return string HTML del picture
 */
function responsive_image(string $src, string $alt = '', string $class = '', string $sizes = '100vw', bool $lazy = true): string {
    $path_info = pathinfo($src);
    $base = $path_info['dirname'] . '/' . $path_info['filename'];
    $ext = $path_info['extension'] ?? 'jpg';

    $webp_src = $base . '.webp';
    $avif_src = $base . '.avif';

    $theme_uri = get_template_directory_uri();

    // Convertir rutas relativas a absolutas del tema
    $src_abs = strpos($src, 'http') === 0 ? $src : $theme_uri . $src;
    $webp_abs = strpos($webp_src, 'http') === 0 ? $webp_src : $theme_uri . $webp_src;
    $avif_abs = strpos($avif_src, 'http') === 0 ? $avif_src : $theme_uri . $avif_src;

    $html = '<picture>';
    $html .= '<source srcset="' . esc_url($avif_abs) . '" type="image/avif">';
    $html .= '<source srcset="' . esc_url($webp_abs) . '" type="image/webp">';
    $html .= '<img src="' . esc_url($src_abs) . '" alt="' . esc_attr($alt) . '"';
    if ($class) $html .= ' class="' . esc_attr($class) . '"';
    $html .= ' loading="' . ($lazy ? 'lazy' : 'eager') . '" decoding="async"';
    if ($sizes) $html .= ' sizes="' . esc_attr($sizes) . '"';
    $html .= '>';
    $html .= '</picture>';

    return $html;
}

/**
 * Genera breadcrumb HTML semántico + Schema JSON-LD inline
 */
function renderBreadcrumb(array $items, string $lang = 'es'): string {
    $domain = defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url();
    $html = '<nav aria-label="Breadcrumb" class="breadcrumb"><ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';
    $count = count($items);
    $schema_items = [];
    $position = 1;

    foreach ($items as $i => $item) {
        $name = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
        $is_last = ($i === $count - 1);
        $html .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        if (!$is_last && !empty($item['url'])) {
            $url = htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8');
            $html .= '<a itemprop="item" href="' . $url . '"><span itemprop="name">' . $name . '</span></a>';
        } else {
            $html .= '<span itemprop="name">' . $name . '</span>';
        }
        $html .= '<meta itemprop="position" content="' . $position . '">';
        $html .= '</li>';

        $schema_items[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $item['name'],
            'item' => $domain . ($item['url'] ?? '')
        ];
        $position++;
    }
    $html .= '</ol></nav>';

    // Schema JSON-LD inline
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $schema_items,
    ];
    $html .= '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';

    return $html;
}

/**
 * Genera sitemap XML completo
 */
function generateSitemap(string $domain = ''): string {
    $domain = $domain !== '' ? $domain : (defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url());
    $pdo = Database::getInstance();
    $urls = [];
    $today = date('Y-m-d');

    // Páginas estáticas
    $static = [
        ['loc' => '/es/', 'priority' => '1.0'],
        ['loc' => '/ca/', 'priority' => '1.0'],
        ['loc' => '/es/servicios/', 'priority' => '0.8'],
        ['loc' => '/ca/serveis/', 'priority' => '0.8'],
        ['loc' => '/es/proyectos/', 'priority' => '0.8'],
        ['loc' => '/ca/projectes/', 'priority' => '0.8'],
        ['loc' => '/es/sobre-nosotros/', 'priority' => '0.6'],
        ['loc' => '/ca/sobre-nosaltres/', 'priority' => '0.6'],
        ['loc' => '/es/contacto/', 'priority' => '0.9'],
        ['loc' => '/ca/contacte/', 'priority' => '0.9'],
        ['loc' => '/es/obra-nueva/', 'priority' => '0.8'],
        ['loc' => '/ca/obra-nova/', 'priority' => '0.8'],
        ['loc' => '/es/reformas-integrales/', 'priority' => '0.8'],
        ['loc' => '/ca/reformes-integrals/', 'priority' => '0.8'],
        ['loc' => '/es/pladur-acabados/', 'priority' => '0.8'],
        ['loc' => '/ca/pladur-acabats/', 'priority' => '0.8'],
        ['loc' => '/es/obra-publica/', 'priority' => '0.8'],
        ['loc' => '/ca/obra-publica/', 'priority' => '0.8'],
        ['loc' => '/es/obra-civil/', 'priority' => '0.8'],
        ['loc' => '/ca/obra-civil/', 'priority' => '0.8'],
        ['loc' => '/es/reformas-barcelona/', 'priority' => '0.7'],
        ['loc' => '/es/reformas-girona/', 'priority' => '0.7'],
        ['loc' => '/es/reformas-tarragona/', 'priority' => '0.7'],
        ['loc' => '/es/obra-nueva-barcelona/', 'priority' => '0.7'],
        ['loc' => '/es/obra-nueva-girona/', 'priority' => '0.7'],
        ['loc' => '/es/obra-nueva-tarragona/', 'priority' => '0.7'],
        ['loc' => '/es/pladur-barcelona/', 'priority' => '0.7'],
        ['loc' => '/es/pladur-girona/', 'priority' => '0.7'],
        ['loc' => '/es/pladur-tarragona/', 'priority' => '0.7'],
    ];
    foreach ($static as $s) {
        $urls[] = "<url><loc>{$domain}{$s['loc']}</loc><lastmod>{$today}</lastmod><priority>{$s['priority']}</priority></url>";
    }

    // Servicios
    try {
        $stmt = $pdo->query("SELECT slug, updated_at FROM services");
        foreach ($stmt->fetchAll() as $svc) {
            $date = date('Y-m-d', strtotime($svc['updated_at']));
            $urls[] = "<url><loc>{$domain}/es/servicios/{$svc['slug']}/</loc><lastmod>{$date}</lastmod><priority>0.7</priority></url>";
            $urls[] = "<url><loc>{$domain}/ca/serveis/{$svc['slug']}/</loc><lastmod>{$date}</lastmod><priority>0.7</priority></url>";
        }
    } catch (Throwable $e) {}

    // Proyectos publicados
    try {
        $stmt = $pdo->query("SELECT slug, updated_at FROM projects WHERE status = 'published'");
        foreach ($stmt->fetchAll() as $proy) {
            $date = date('Y-m-d', strtotime($proy['updated_at']));
            $urls[] = "<url><loc>{$domain}/es/proyectos/{$proy['slug']}/</loc><lastmod>{$date}</lastmod><priority>0.6</priority></url>";
        }
    } catch (Throwable $e) {}

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    $xml .= implode("\n", $urls);
    $xml .= "\n</urlset>";
    return $xml;
}

/**
 * Obtiene OG image para una ruta específica
 */
function get_og_image(string $route = '', string $lang = 'es'): string {
    $domain = defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url();
    $theme_uri = get_template_directory_uri();

    // Mapeo de rutas a imágenes específicas
    $map = [
        'obra-nueva' => '/assets/images/og-obra-nueva.jpg',
        'reformas-integrales' => '/assets/images/og-reformas-integrales.jpg',
        'pladur-acabados' => '/assets/images/og-pladur-acabados.jpg',
        'obra-publica' => '/assets/images/og-obra-publica.jpg',
        'obra-civil' => '/assets/images/og-obra-civil.jpg',
        'reformas-barcelona' => '/assets/images/og-reformas-barcelona.jpg',
        'reformas-girona' => '/assets/images/og-reformas-girona.jpg',
        'reformas-tarragona' => '/assets/images/og-reformas-tarragona.jpg',
        'obra-nueva-barcelona' => '/assets/images/og-obra-nueva-barcelona.jpg',
        'obra-nueva-girona' => '/assets/images/og-obra-nueva-girona.jpg',
        'obra-nueva-tarragona' => '/assets/images/og-obra-nueva-tarragona.jpg',
        'pladur-barcelona' => '/assets/images/og-pladur-barcelona.jpg',
        'pladur-girona' => '/assets/images/og-pladur-girona.jpg',
        'pladur-tarragona' => '/assets/images/og-pladur-tarragona.jpg',
        'contacto' => '/assets/images/og-contacto.jpg',
        'contacte' => '/assets/images/og-contacto.jpg',
        'proyectos' => '/assets/images/og-proyectos.jpg',
        'projectes' => '/assets/images/og-proyectos.jpg',
        'sobre-nosotros' => '/assets/images/og-sobre-nosotros.jpg',
        'sobre-nosaltres' => '/assets/images/og-sobre-nosotros.jpg',
        'blog' => '/assets/images/og-blog.jpg',
    ];

    $route = trim($route, '/');
    if (isset($map[$route]) && file_exists(get_template_directory() . $map[$route])) {
        return $domain . $map[$route];
    }

    return $domain . '/assets/images/og-default.jpg';
}
