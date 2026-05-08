<?php
/**
 * Copy and structured content for core service landing pages.
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

$base_services = [
    'obra-nueva' => [
        'h1' => 'Obra nueva en Barcelona y Girona | Santa Fe Construcciones',
        'title' => 'Obra nueva en Barcelona y Girona | Santa Fe Construcciones',
        'description' => 'Construimos viviendas y edificaciones con planificación técnica, control de costes y seguimiento claro desde licencia hasta entrega.',
        'problem' => 'Una obra nueva mal planificada multiplica cambios, retrasos y decisiones improvisadas. Antes de construir, hay que ordenar licencias, estructura, gremios, suministros y acabados.',
        'agitate' => 'Cuando cada industrial trabaja por separado, el presupuesto deja de ser una guía fiable. El cliente acaba coordinando problemas que deberían estar resueltos antes de iniciar la obra.',
        'solution' => 'En Santa Fe planificamos la obra por fases, validamos alcance técnico, coordinamos gremios y mantenemos comunicación directa para que cada decisión quede clara.',
        'prices' => 'Proyecto a medida tras visita técnica. Como referencia inicial, la obra nueva residencial suele depender de estructura, m², terreno, calidades y licencias.',
        'features' => ['Estudio técnico inicial', 'Plan de obra por fases', 'Coordinación de gremios', 'Seguimiento directo con Paulo', 'Entrega limpia y documentada'],
        'phases' => [
            ['title' => 'Visita técnica', 'desc' => 'Revisamos alcance, terreno, necesidades y restricciones.'],
            ['title' => 'Presupuesto', 'desc' => 'Preparamos partidas claras y fases de ejecución.'],
            ['title' => 'Ejecución', 'desc' => 'Coordinamos estructura, instalaciones y acabados.'],
            ['title' => 'Entrega', 'desc' => 'Revisión final, limpieza y cierre de detalles.'],
        ],
        'faq' => [
            ['q' => '¿Trabajáis con arquitecto?', 'a' => 'Es viable coordinarse con la dirección facultativa del cliente o recomendar técnicos colaboradores según el proyecto.'],
            ['q' => '¿El presupuesto es cerrado?', 'a' => 'Se entrega por partidas y alcance definido. Cualquier cambio se valida antes de ejecutarse.'],
            ['q' => '¿Gestionáis licencias?', 'a' => 'Acompañamos la tramitación y coordinación documental cuando el alcance lo requiere.'],
        ],
        'cta_primary' => 'Solicitar presupuesto de obra nueva',
        'cta_secondary' => 'Llamar a Paulo',
    ],
    'reformas-integrales' => [
        'h1' => 'Reformas integrales en Barcelona y Girona | Santa Fe Construcciones',
        'title' => 'Reformas integrales en Barcelona y Girona | Santa Fe Construcciones',
        'description' => 'Reformas integrales con presupuesto claro, coordinación de gremios, control de plazo y acabados cuidados.',
        'problem' => 'Una reforma integral concentra albañilería, instalaciones, carpintería, pintura y decisiones de acabado. Sin coordinación, cada cambio afecta al coste y al plazo.',
        'agitate' => 'El riesgo no está solo en reformar, sino en empezar sin alcance claro. Ahí aparecen extras, esperas, compras urgentes y acabados que no encajan.',
        'solution' => 'Ordenamos la reforma antes de empezar: visita, medición, alcance, prioridades, calendario y comunicación directa durante la ejecución.',
        'prices' => 'Referencia orientativa: reformas integrales desde 450-900 €/m² según estado inicial, calidades, instalaciones y complejidad.',
        'features' => ['Derribos y albañilería', 'Instalaciones y acabados', 'Planificación por fases', 'Presupuesto por partidas', 'Limpieza final'],
        'phases' => [
            ['title' => 'Diagnóstico', 'desc' => 'Analizamos vivienda, necesidades y estado de instalaciones.'],
            ['title' => 'Alcance', 'desc' => 'Definimos partidas, calidades y prioridades.'],
            ['title' => 'Obra', 'desc' => 'Coordinamos gremios y decisiones críticas.'],
            ['title' => 'Cierre', 'desc' => 'Revisión de acabados y entrega ordenada.'],
        ],
        'faq' => [
            ['q' => '¿Cuánto tarda una reforma integral?', 'a' => 'Depende de m² y complejidad. Tras visita técnica se puede estimar un calendario realista.'],
            ['q' => '¿Puedo vivir en casa durante la reforma?', 'a' => 'En reformas parciales a veces sí; en integrales completas normalmente no es recomendable.'],
            ['q' => '¿Incluís materiales?', 'a' => 'Se pueden incluir materiales y coordinar compras según el nivel de acabado acordado.'],
        ],
        'cta_primary' => 'Solicitar presupuesto de reforma',
        'cta_secondary' => 'Llamar a Paulo',
    ],
    'pladur-acabados' => [
        'h1' => 'Pladur y acabados interiores en Barcelona y Girona | Santa Fe Construcciones',
        'title' => 'Pladur y acabados interiores en Barcelona y Girona | Santa Fe Construcciones',
        'description' => 'Instalación de pladur, techos, trasdosados, divisiones interiores y acabados con criterio técnico.',
        'problem' => 'El pladur parece sencillo hasta que entran aislamiento, humedad, acústica, iluminación, cargas y encuentros con instalaciones.',
        'agitate' => 'Una mala ejecución se nota en juntas, fisuras, vibraciones, techos desnivelados y acabados que envejecen mal.',
        'solution' => 'Diseñamos la solución adecuada para cada estancia y ejecutamos con estructura, placa, aislamiento y acabado coherentes con el uso real.',
        'prices' => 'Referencia orientativa: trabajos de pladur desde 35-75 €/m² según tipo de placa, aislamiento, altura y acabado.',
        'features' => ['Tabiques y trasdosados', 'Techos continuos y registrables', 'Aislamiento acústico', 'Iluminación integrada', 'Acabados listos para pintar'],
        'phases' => [
            ['title' => 'Medición', 'desc' => 'Tomamos medidas y necesidades técnicas.'],
            ['title' => 'Solución', 'desc' => 'Elegimos placa, estructura y aislamiento.'],
            ['title' => 'Montaje', 'desc' => 'Ejecutamos estructura, placas y pasos técnicos.'],
            ['title' => 'Acabado', 'desc' => 'Tratamos juntas y dejamos listo para terminación.'],
        ],
        'faq' => [
            ['q' => '¿El pladur sirve para aislar ruido?', 'a' => 'Sí, si se diseña con placa, lana mineral y sistema adecuados.'],
            ['q' => '¿Se pueden colgar muebles?', 'a' => 'Sí, previendo refuerzos y anclajes adecuados según carga.'],
            ['q' => '¿Trabajáis techos con iluminación?', 'a' => 'Sí, coordinamos huecos, pasos y acabados para iluminación integrada.'],
        ],
        'cta_primary' => 'Solicitar presupuesto de pladur',
        'cta_secondary' => 'Llamar a Paulo',
    ],
    'obra-publica' => [
        'h1' => 'Obra pública en Barcelona y Girona | Santa Fe Construcciones',
        'title' => 'Obra pública en Barcelona y Girona | Santa Fe Construcciones',
        'description' => 'Ejecución de obra pública con documentación, cumplimiento, coordinación y trazabilidad.',
        'problem' => 'La obra pública exige cumplimiento, documentación y coordinación estricta. Los retrasos o fallos de trazabilidad tienen impacto administrativo y económico.',
        'agitate' => 'Sin control documental y técnico, una obra aparentemente simple puede bloquear certificaciones, recepciones o entregas.',
        'solution' => 'Trabajamos con planificación, comunicación y seguimiento para mantener orden técnico, documental y de ejecución.',
        'prices' => 'Presupuesto según pliego, mediciones, documentación y alcance de ejecución.',
        'features' => ['Coordinación técnica', 'Cumplimiento documental', 'Plan de trabajo', 'Control de ejecución', 'Entrega trazable'],
        'phases' => [
            ['title' => 'Análisis', 'desc' => 'Revisamos pliego, alcance y condicionantes.'],
            ['title' => 'Planificación', 'desc' => 'Organizamos fases, equipos y documentación.'],
            ['title' => 'Ejecución', 'desc' => 'Controlamos avance y comunicación técnica.'],
            ['title' => 'Cierre', 'desc' => 'Preparamos entrega y revisión final.'],
        ],
        'faq' => [
            ['q' => '¿Trabajáis para administraciones?', 'a' => 'Sí, en proyectos donde el alcance y documentación estén definidos.'],
            ['q' => '¿Podéis coordinar documentación?', 'a' => 'Sí, dentro del alcance acordado con la dirección técnica.'],
            ['q' => '¿En qué zonas trabajáis?', 'a' => 'Principalmente Barcelona, Girona, Tarragona y Cataluña.'],
        ],
        'cta_primary' => 'Consultar obra pública',
        'cta_secondary' => 'Llamar a Paulo',
    ],
    'obra-civil' => [
        'h1' => 'Obra civil en Barcelona y Girona | Santa Fe Construcciones',
        'title' => 'Obra civil en Barcelona y Girona | Santa Fe Construcciones',
        'description' => 'Obra civil, cimentaciones, muros, canalizaciones y estructuras con planificación y ejecución técnica.',
        'problem' => 'La obra civil no permite improvisación: terreno, cargas, drenajes, accesos y seguridad condicionan cada decisión.',
        'agitate' => 'Un error en fases iniciales puede afectar estabilidad, coste, plazos y reparaciones posteriores.',
        'solution' => 'Ejecutamos con criterio técnico, coordinación y seguimiento para que cada fase quede preparada para la siguiente.',
        'prices' => 'Presupuesto según mediciones, terreno, acceso, maquinaria, materiales y complejidad técnica.',
        'features' => ['Cimentaciones', 'Muros y estructuras', 'Canalizaciones', 'Preparación de terreno', 'Coordinación técnica'],
        'phases' => [
            ['title' => 'Revisión', 'desc' => 'Analizamos mediciones, terreno y condicionantes.'],
            ['title' => 'Preparación', 'desc' => 'Planificamos accesos, equipos y fases.'],
            ['title' => 'Ejecución', 'desc' => 'Desarrollamos obra con control técnico.'],
            ['title' => 'Validación', 'desc' => 'Revisamos resultados antes de cerrar fase.'],
        ],
        'faq' => [
            ['q' => '¿Hacéis cimentaciones?', 'a' => 'Sí, según proyecto técnico, mediciones y dirección facultativa.'],
            ['q' => '¿Trabajáis con empresas?', 'a' => 'Sí, para empresas, comunidades y clientes con necesidades técnicas.'],
            ['q' => '¿Visitáis la obra antes de presupuestar?', 'a' => 'Sí, la visita técnica ayuda a evitar presupuestos irreales.'],
        ],
        'cta_primary' => 'Consultar obra civil',
        'cta_secondary' => 'Llamar a Paulo',
    ],
];

$ca_services = [];
foreach ($base_services as $slug => $service) {
    $ca_services[$slug] = $service;
}

return [
    'obra-nueva' => ['es' => $base_services['obra-nueva'], 'ca' => $ca_services['obra-nueva']],
    'reformas-integrales' => ['es' => $base_services['reformas-integrales'], 'ca' => $ca_services['reformas-integrales']],
    'pladur-acabados' => ['es' => $base_services['pladur-acabados'], 'ca' => $ca_services['pladur-acabados']],
    'obra-publica' => ['es' => $base_services['obra-publica'], 'ca' => $ca_services['obra-publica']],
    'obra-civil' => ['es' => $base_services['obra-civil'], 'ca' => $ca_services['obra-civil']],
];
