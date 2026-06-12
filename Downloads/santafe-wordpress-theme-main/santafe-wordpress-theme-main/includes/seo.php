<?php
/**
 * Central SEO data for Santa Fe rendered routes.
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

function santafe_get_seo_data(string $route = '', string $lang = 'es'): array {
    $route = trim($route, '/');
    $domain = defined('COMPANY_DOMAIN') ? COMPANY_DOMAIN : home_url();
    $base = [
        'lang' => $lang,
        'title' => 'Santa Fe Construcciones | Reformas y obra nueva en Barcelona',
        'description' => 'Santa Fe Construcciones realiza reformas integrales, obra nueva, pladur, obra civil y obra pública en Barcelona, Girona y Tarragona.',
        'canonical' => $domain . '/' . $lang . '/' . ($route ? $route . '/' : ''),
        'schemas' => [],
    ];

    $es = [
        '' => ['Santa Fe Construcciones | Reformas y obra nueva en Barcelona, Girona y Tarragona', 'Empresa de construcción con 17 años de experiencia. Reformas integrales, obra nueva, pladur, obra pública y obra civil. Presupuesto cerrado en 48h, sin sorpresas.'],
        'contacto' => ['Contacto | Santa Fe Construcciones - Presupuesto en 48h', 'Solicita presupuesto gratuito para reforma, obra nueva o pladur en Barcelona, Girona o Tarragona. Respuesta en menos de 2 horas.'],
        'servicios' => ['Servicios de construcción | Santa Fe Construcciones', 'Servicios de obra nueva, reformas integrales, pladur, obra pública y obra civil en Barcelona, Girona y Tarragona con control técnico.'],
        'proyectos' => ['Ejemplos visuales de construcción | Santa Fe', 'Referencias visuales de obra nueva, reformas, pladur, obra pública y obra civil hasta publicar proyectos reales autorizados.'],
        'sobre-nosotros' => ['Sobre Santa Fe Construcciones | Paulo desde 2008', 'Conoce la trayectoria de Santa Fe Construcciones, empresa dirigida por Paulo para reformas y construcción en Barcelona, Girona y Tarragona.'],
        'blog' => ['Blog de reformas y construcción | Santa Fe', 'Guías sobre precios, licencias, pladur, reformas integrales y obra nueva para decidir mejor antes de empezar una obra en Cataluña.'],
        'obra-nueva' => ['Obra nueva en Barcelona y Girona | Santa Fe', 'Construcción de viviendas y edificaciones con planificación técnica, presupuesto por fases y seguimiento claro desde licencia hasta entrega.'],
        'reformas-integrales' => ['Reformas integrales Barcelona | Presupuesto cerrado en 48h', 'Reforma integral de pisos y locales en Barcelona, Girona y Tarragona. Presupuesto detallado por partidas, plazo garantizado y seguimiento semanal con fotos.'],
        'pladur-acabados' => ['Pladur y acabados en Barcelona y Girona | Santa Fe', 'Instalación de pladur, techos, trasdosados, divisiones interiores, aislamiento y acabados con criterio técnico en Cataluña.'],
        'obra-publica' => ['Obra pública en Barcelona y Girona | Santa Fe', 'Ejecución de obra pública con documentación, cumplimiento, coordinación técnica y trazabilidad para administraciones y entidades.'],
        'obra-civil' => ['Obra civil en Barcelona y Girona | Santa Fe', 'Obra civil, cimentaciones, muros, canalizaciones y estructuras con planificación, seguridad y ejecución técnica en Cataluña.'],
        'reformas-barcelona' => ['Reformas en Barcelona | Santa Fe Construcciones', 'Reformas en Barcelona con visita técnica, presupuesto por partidas, coordinación de gremios y seguimiento directo durante toda la obra.'],
        'reformas-girona' => ['Reformas en Girona | Santa Fe Construcciones', 'Reformas en Girona para viviendas, locales y comunidades con alcance claro, planificación técnica y comunicación directa con Paulo.'],
        'reformas-tarragona' => ['Reformas en Tarragona | Santa Fe Construcciones', 'Reformas en Tarragona con presupuesto claro, control de fases, coordinación de gremios y acabados cuidados para cada proyecto.'],
        'obra-nueva-barcelona' => ['Obra nueva en Barcelona | Santa Fe Construcciones', 'Obra nueva en Barcelona con planificación técnica, coordinación de fases, control de costes y seguimiento claro hasta la entrega.'],
        'obra-nueva-girona' => ['Obra nueva en Girona | Santa Fe Construcciones', 'Obra nueva en Girona para viviendas y edificaciones con presupuesto por fases, coordinación técnica y ejecución ordenada.'],
        'reformas-integrales-barcelona' => ['Reformas integrales en Barcelona | Santa Fe', 'Reformas integrales en Barcelona con control de gremios, planificación previa, presupuesto por partidas y seguimiento directo.'],
        'reformas-integrales-girona' => ['Reformas integrales en Girona | Santa Fe', 'Reformas integrales en Girona con visita técnica, fases claras, coordinación de oficios y acabados pensados para durar.'],
        'pladur-barcelona' => ['Pladur en Barcelona | Santa Fe Construcciones', 'Pladur en Barcelona para techos, tabiques, trasdosados, aislamiento acústico y acabados interiores con ejecución profesional.'],
        'pladur-girona' => ['Pladur en Girona | Santa Fe Construcciones', 'Pladur en Girona para divisiones interiores, techos, aislamiento y acabados limpios con criterio técnico y presupuesto claro.'],
    ];

    $ca = [
        '' => ['Santa Fe Construcciones | Reformes i obra nova a Catalunya', 'Empresa de reformes, obra nova, pladur, obra civil i obra pública a Barcelona, Girona i Tarragona amb seguiment directe.'],
        'contacte' => ['Contacte | Santa Fe Construcciones - Pressupost en 24h', 'Contacta amb Santa Fe Construcciones per sol·licitar visita tècnica, pressupost de reforma, obra nova, pladur o obra civil.'],
        'serveis' => ['Serveis de construcció | Santa Fe Construcciones', 'Serveis d obra nova, reformes integrals, pladur, obra pública i obra civil a Barcelona, Girona i Tarragona amb control tècnic.'],
        'projectes' => ['Referències visuals de construcció | Santa Fe', 'Referències visuals d obra nova, reformes, pladur, obra pública i obra civil fins a publicar projectes reals autoritzats.'],
        'sobre-nosaltres' => ['Sobre Santa Fe Construcciones | Paulo des de 2008', 'Coneix la trajectòria de Santa Fe Construcciones, empresa dirigida per Paulo per a reformes i construcció a Catalunya.'],
        'blog' => ['Blog de reformes i construcció | Santa Fe', 'Guies sobre preus, llicències, pladur, reformes integrals i obra nova per decidir millor abans de començar una obra.'],
    ];

    $map = $lang === 'ca' ? $ca : $es;
    if (isset($map[$route])) {
        $base['title'] = $map[$route][0];
        $base['description'] = $map[$route][1];
    }

    return $base;
}

function santafe_normalize_seo_data(array $page_data, string $route = '', string $lang = 'es'): array {
    $defaults = santafe_get_seo_data($route, $lang);
    $merged = array_merge($defaults, $page_data);

    if (empty($merged['title']) || strlen((string) $merged['title']) < 30) {
        $merged['title'] = $defaults['title'];
    }
    if (empty($merged['description']) || strlen((string) $merged['description']) < 120) {
        $merged['description'] = $defaults['description'];
    }
    if (empty($merged['canonical']) || strpos((string) $merged['canonical'], 'http') !== 0) {
        $merged['canonical'] = $defaults['canonical'];
    }

    return $merged;
}
