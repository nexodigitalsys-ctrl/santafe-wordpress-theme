<?php
/**
 * Proof placeholders for Phase 1.
 * This intentionally avoids publishing unconfirmed testimonials as real.
 */

declare(strict_types=1);

$proofItems = $lang === 'ca'
    ? [
        ['title' => 'Testimonis reals', 'copy' => 'Espai preparat per publicar opinions verificades de clients quan Paulo les validi.'],
        ['title' => 'Casos d obra', 'copy' => 'Estructura preparada per connectar cada testimoni amb una obra, fotos i resultat.'],
        ['title' => 'Prova documentada', 'copy' => 'Substituirem aquest bloc per noms, projectes i dades reals autoritzades.'],
    ]
    : [
        ['title' => 'Testimonios reales', 'copy' => 'Espacio preparado para publicar opiniones verificadas de clientes cuando Paulo las valide.'],
        ['title' => 'Casos de obra', 'copy' => 'Estructura preparada para conectar cada testimonio con una obra, fotos y resultado.'],
        ['title' => 'Prueba documentada', 'copy' => 'Sustituiremos este bloque por nombres, proyectos y datos reales autorizados.'],
    ];
?>

<!-- PROOF PLACEHOLDERS -->
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-3xl mb-14">
            <div class="flex items-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]">
                    <?php echo $lang === 'ca' ? 'Prova en validacio' : 'Prueba en validacion'; ?>
                </span>
            </div>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-5">
                <?php echo $lang === 'ca' ? 'La confianca es publica nomes quan es pot demostrar.' : 'La confianza se publica solo cuando se puede demostrar.'; ?>
            </h2>
            <p class="text-slate-400 text-lg leading-relaxed">
                <?php echo $lang === 'ca' ? 'Aquest espai esta reservat per testimonis i casos reals. Fins que el client autoritzi dades, mantenim placeholders visibles per no inventar prova social.' : 'Este espacio queda reservado para testimonios y casos reales. Hasta que el cliente autorice datos, mantenemos placeholders visibles para no inventar prueba social.'; ?>
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($proofItems as $item): ?>
            <article class="bg-slate-950 border border-slate-800 p-8 rounded-sm">
                <span class="text-brand-500 text-xs font-bold uppercase tracking-[0.25em]">Placeholder</span>
                <h3 class="font-display text-2xl font-bold text-white mt-4 mb-4"><?php echo $item['title']; ?></h3>
                <p class="text-slate-400 leading-relaxed"><?php echo $item['copy']; ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
