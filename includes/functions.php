<?php
/**
 * includes/functions.php — Helpers genéricos del frontend
 * SEO, breadcrumbs, helpers de contenido desde BD
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
 * Genera breadcrumb HTML semántico
 */
function renderBreadcrumb(array $items, string $lang = 'es'): string {
    $html = '<nav aria-label="Breadcrumb" class="breadcrumb"><ol class="breadcrumb-list">';
    $count = count($items);
    foreach ($items as $i => $item) {
        $name = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
        if ($i < $count - 1) {
            $url = htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8');
            $html .= "<li><a href=\"{$url}\">{$name}</a><span aria-hidden=\"true\"> / </span></li>";
        } else {
            $html .= "<li><span aria-current=\"page\">{$name}</span></li>";
        }
    }
    $html .= '</ol></nav>';
    return $html;
}

/**
 * Genera sitemap XML completo
 */
function generateSitemap(string $domain = 'https://www.dominio.com'): string {
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
