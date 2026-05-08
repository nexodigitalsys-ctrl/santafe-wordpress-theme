<?php
/**
 * Phase 1 enterprise hero.
 * Uses confirmed-safe copy and avoids publishing unverified proof.
 */

declare(strict_types=1);

$audiences = $lang === 'ca'
    ? [
        ['title' => 'Particulars', 'copy' => 'Reformes i obra nova amb abast clar, fases visibles i decisions documentades.'],
        ['title' => 'Empreses', 'copy' => 'Coordinació de gremis, acabats i terminis per a locals, oficines i actius en funcionament.'],
        ['title' => 'Obra pública', 'copy' => 'Execució ordenada, documentació i compliment per a projectes amb traçabilitat.'],
    ]
    : [
        ['title' => 'Particulares', 'copy' => 'Reformas y obra nueva con alcance claro, fases visibles y decisiones documentadas.'],
        ['title' => 'Empresas', 'copy' => 'Coordinación de gremios, acabados y plazos para locales, oficinas y activos en funcionamiento.'],
        ['title' => 'Obra pública', 'copy' => 'Ejecución ordenada, documentación y cumplimiento para proyectos con trazabilidad.'],
    ];

$risks = $lang === 'ca'
    ? ['Sobrecostos no previstos', 'Retards sense responsable', 'Gremis descoordinats', 'Llicències mal plantejades', 'Acabats sense criteri', 'Comunicació opaca']
    : ['Sobrecostes no previstos', 'Retrasos sin responsable', 'Gremios descoordinados', 'Licencias mal planteadas', 'Acabados sin criterio', 'Comunicación opaca'];
?>

<!-- HERO ENTERPRISE PHASE 1 -->
<section class="relative min-h-screen flex items-end overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center hero-bg"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-slate-950/20"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/35"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pb-16 pt-40">
        <div class="grid lg:grid-cols-[1.08fr_0.92fr] gap-12 items-end">
            <div class="max-w-4xl">
                <div class="flex items-center gap-4 mb-8 animate-fade-in">
                    <div class="industrial-line w-16"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">
                        <?php echo $lang === 'ca' ? 'Construccions Santa Fe - Barcelona, Girona i Tarragona' : 'Construcciones Santa Fe - Barcelona, Girona y Tarragona'; ?>
                    </span>
                </div>

                <h1 class="font-display font-bold text-5xl sm:text-6xl md:text-7xl lg:text-8xl text-white leading-[0.92] tracking-tight mb-8 animate-slide-up">
                    <?php echo $lang === 'ca' ? 'Obra seriosa.' : 'Obra seria.'; ?><br>
                    <span class="text-brand-500">Control total.</span><br>
                    <?php echo $lang === 'ca' ? 'Sense sorpreses.' : 'Sin sorpresas.'; ?>
                </h1>

                <p class="text-slate-300 text-lg md:text-xl max-w-2xl mb-10 leading-relaxed animate-slide-up delay-200">
                    <?php echo $lang === 'ca' ? 'Obra nova, reformes integrals, pladur, obra civil i obra pública amb criteri tècnic, pressupost clar i seguiment real d obra.' : 'Obra nueva, reformas integrales, pladur, obra civil y obra pública con criterio técnico, presupuesto claro y seguimiento real de obra.'; ?>
                </p>

                <div class="flex flex-wrap gap-4 animate-slide-up delay-300">
                    <a href="#calculadora" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-slate-950 font-semibold px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                        <?php echo $lang === 'ca' ? 'Calcular pressupost estimat' : 'Calcular presupuesto estimado'; ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="/<?php echo $lang; ?>/proyectos/" class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-200 font-medium px-8 py-4 rounded-sm transition-all tracking-wide text-sm uppercase">
                        <?php echo $lang === 'ca' ? 'Veure exemples visuals' : 'Ver proyectos realizados'; ?>
                    </a>
                </div>
            </div>

            <div class="grid gap-3 animate-slide-up delay-400">
                <?php foreach ($audiences as $item): ?>
                <article class="group border border-slate-700/70 bg-slate-950/55 backdrop-blur-md p-5 rounded-sm hover:border-brand-600/70 hover:bg-slate-900/80 transition-all">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-display text-white text-xl font-bold mb-2"><?php echo $item['title']; ?></h2>
                            <p class="text-slate-400 text-sm leading-relaxed"><?php echo $item['copy']; ?></p>
                        </div>
                        <span class="text-brand-500 transition-transform group-hover:translate-x-1">&rarr;</span>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- TRUST STRIP -->
<section class="border-y border-slate-800 bg-slate-900/70">
    <div class="max-w-7xl mx-auto px-6 py-8 grid md:grid-cols-4 gap-4">
        <div class="border-l border-brand-700/70 pl-4">
            <p class="font-display font-bold text-2xl text-white"><?php echo $lang === 'ca' ? 'Des de 2008' : 'Desde 2008'; ?></p>
            <p class="text-slate-500 text-xs uppercase tracking-wider mt-1"><?php echo $lang === 'ca' ? 'Trajectòria professional' : 'Trayectoria profesional'; ?></p>
        </div>
        <div class="border-l border-slate-700 pl-4">
            <p class="font-display font-bold text-2xl text-white">BCN / Girona</p>
            <p class="text-slate-500 text-xs uppercase tracking-wider mt-1"><?php echo $lang === 'ca' ? 'Zones de servei' : 'Zonas de servicio'; ?></p>
        </div>
        <div class="border-l border-slate-700 pl-4">
            <p class="font-display font-bold text-2xl text-white"><?php echo $lang === 'ca' ? 'Pressupost clar' : 'Presupuesto claro'; ?></p>
            <p class="text-slate-500 text-xs uppercase tracking-wider mt-1"><?php echo $lang === 'ca' ? 'Abast, fases i decisions per escrit' : 'Alcance, fases y decisiones por escrito'; ?></p>
        </div>
        <div class="border-l border-slate-700 pl-4">
            <p class="font-display font-bold text-2xl text-white"><?php echo $lang === 'ca' ? 'Seguiment real' : 'Seguimiento real'; ?></p>
            <p class="text-slate-500 text-xs uppercase tracking-wider mt-1"><?php echo $lang === 'ca' ? 'Sense desaparèixer després del pressupost' : 'Sin desaparecer después del presupuesto'; ?></p>
        </div>
    </div>
</section>

<!-- RISK CONTROL -->
<section class="py-20 bg-slate-950 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-[0.8fr_1.2fr] gap-12 items-start">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'Control de risc' : 'Control de riesgo'; ?></span>
                </div>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-white tracking-tight mb-5">
                    <?php echo $lang === 'ca' ? 'El que una obra mal dirigida et pot costar.' : 'Lo que una obra mal dirigida te puede costar.'; ?>
                </h2>
                <p class="text-slate-400 leading-relaxed">
                    <?php echo $lang === 'ca' ? 'El valor no es nomes construir. Es anticipar errors, ordenar gremis, protegir el pressupost i mantenir el client informat.' : 'El valor no es solo construir. Es anticipar errores, ordenar gremios, proteger el presupuesto y mantener al cliente informado.'; ?>
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <?php foreach ($risks as $risk): ?>
                <div class="flex items-center gap-3 bg-slate-900 border border-slate-800 p-4 rounded-sm">
                    <span class="w-2 h-2 bg-brand-500 rounded-full flex-shrink-0"></span>
                    <span class="text-slate-200 text-sm font-medium"><?php echo $risk; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
