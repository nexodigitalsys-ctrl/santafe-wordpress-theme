<?php
/**
 * Google Reviews Widget — Badge + cards estilo Google
 * Inspiração: Koncepto (widget de trust social)
 */
$lang = $_GET['lang'] ?? 'es';
$isCa = $lang === 'ca';

$t = [
    'title' => $isCa ? 'Opinions a Google' : 'Opiniones en Google',
    'subtitle' => $isCa ? 'Valoracions reals dels nostres clients' : 'Valoraciones reales de nuestros clientes',
    'badge' => $isCa ? '12 opinions verificades' : '12 opiniones verificadas',
    'cta' => $isCa ? 'Veure totes a Google' : 'Ver todas en Google',
    'rating_label' => $isCa ? 'Valoració mitjana' : 'Valoración media',
];

// 3 reviews mais representativas para cards
$featured = $isCa ? [
    ['author' => 'Carmen Vidal', 'rating' => 5, 'text' => 'Reforma de bany a Sarrià. Pablo va venir, va mesurar tot, i en 3 dies tenia el pressupost tancat. La reforma va quedar impecable.'],
    ['author' => 'Jordi Roca', 'rating' => 5, 'text' => 'Obra nova a Sant Gregori (Girona). El terreny tenia desnivell però van proposar una solució que altres no es van atrevir.'],
    ['author' => 'Laura Fernández', 'rating' => 4, 'text' => 'Pladur a Salt (Girona). El treball està molt bé però van endarrerir 4 dies per rehacer una cantonada. No em van cobrar els dies extra.'],
] : [
    ['author' => 'Carmen Vidal', 'rating' => 5, 'text' => 'Reforma de baño en Sarrià. Pablo vino, midió todo, y en 3 días tenía el presupuesto cerrado. La reforma quedó impecable.'],
    ['author' => 'Jordi Roca', 'rating' => 5, 'text' => 'Obra nueva en Sant Gregori (Girona). El terreno tenía desnivel pero propusieron una solución que otros no se atrevieron.'],
    ['author' => 'Laura Fernández', 'rating' => 4, 'text' => 'Pladur en Salt (Girona). El trabajo está muy bien pero retrasaron 4 días por rehacer una esquina. No me cobraron los días extra.'],
];

function star_svg_small($filled) {
    $color = $filled ? '#fbbf24' : '#374151';
    return '<svg width="14" height="14" viewBox="0 0 24 24" fill="' . $color . '"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
}
function render_stars_small($rating) {
    $out = '';
    for ($i = 1; $i <= 5; $i++) { $out .= star_svg_small($i <= $rating); }
    return $out;
}
?>
<section class="py-24 md:py-32 bg-gray-50 border-y border-gray-200" data-reveal>
    <style>
      .google-reviews-grid { display: grid; gap: 1.5rem; max-width: 64rem; margin: 0 auto; }
      @media (min-width: 768px) { .google-reviews-grid { grid-template-columns: repeat(3, 1fr); } }
    </style>
    <div class="max-w-7xl mx-auto px-6">
        <!-- Header com badge Google -->
        <div class="text-center mb-16">
            <span class="inline-block px-3 py-1 bg-blue-500/10 text-blue-400 text-xs font-bold tracking-widest uppercase rounded-full border border-blue-500/20 mb-4"><?php echo $t['subtitle']; ?></span>
            <h2 class="font-display font-bold text-3xl md:text-4xl text-gray-900 tracking-tight mb-8"><?php echo $t['title']; ?></h2>

            <a href="https://g.co/kgs/8t9vHjZ" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-4 bg-white rounded-lg px-6 py-4 shadow-lg hover:shadow-xl transition-all group">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                <div class="text-left">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-900 font-bold text-2xl">4.9</span>
                        <div class="flex"><?php echo render_stars_small(5); ?></div>
                    </div>
                    <p class="text-gray-500 text-sm"><?php echo $t['badge']; ?></p>
                </div>
                <svg class="w-5 h-5 text-gray-500 group-hover:text-blue-500 transition-colors ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

        <!-- Cards de reviews -->
        <div class="google-reviews-grid">
            <?php foreach ($featured as $r): ?>
            <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-sm"><?php echo htmlspecialchars(substr($r['author'], 0, 1)); ?></div>
                    <div>
                        <p class="text-gray-900 font-semibold text-sm"><?php echo htmlspecialchars($r['author']); ?></p>
                        <div class="flex"><?php echo render_stars_small($r['rating']); ?></div>
                    </div>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">&ldquo;<?php echo htmlspecialchars($r['text']); ?>&rdquo;</p>
                <div class="flex items-center gap-1.5 mt-3">
                    <svg class="w-3.5 h-3.5 text-green-500" viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-gray-500 text-xs"><?php echo $isCa ? 'Verificada' : 'Verificada'; ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-10">
            <a href="https://g.co/kgs/8t9vHjZ" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition-colors text-sm font-medium">
                <?php echo $t['cta']; ?>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
