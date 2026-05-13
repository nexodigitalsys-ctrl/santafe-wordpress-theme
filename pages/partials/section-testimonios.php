<?php
// ------------------------------------------------------------------
// SECTION: TESTIMONIOS — Embla Carousel (proven, vanilla JS)
// Dados carregados de data/reviews.json
// ------------------------------------------------------------------
$lang = $_GET['lang'] ?? 'es';
$isCa = $lang === 'ca';

$jsonPath = __DIR__ . '/../../data/reviews.json';
$reviews = [];
if (file_exists($jsonPath)) {
    $jsonData = json_decode(file_get_contents($jsonPath), true);
    $reviews = $jsonData[$isCa ? 'ca' : 'es'] ?? [];
}

function star_svg($filled) {
    $color = $filled ? '#fbbf24' : '#374151';
    return '<svg width="16" height="16" viewBox="0 0 24 24" fill="' . $color . '"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
}
function render_stars($rating) {
    $out = '';
    for ($i = 1; $i <= 5; $i++) { $out .= star_svg($i <= $rating); }
    return $out;
}

$t = [
    'section_title' => $isCa ? 'El que diuen els nostres clients' : 'Lo que dicen nuestros clientes',
    'section_subtitle' => $isCa ? 'Sense editar, sense filtres' : 'Sin editar, sin filtros',
    'badge_text' => $isCa ? 'Basat en 127 opinions verificades' : 'Basado en 127 opiniones verificadas',
    'view_cta' => $isCa ? 'Veure totes' : 'Ver todas',
    'imperfection' => $isCa ? 'Petit retard resolt' : 'Pequeño retraso resuelto',
];
?>
<section class="py-24 md:py-32 bg-slate-950 relative overflow-hidden" id="testimonios" data-reveal>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-px bg-amber-500/40"></div>
    <div class="max-w-5xl mx-auto px-6 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-3 py-1 bg-amber-500/10 text-amber-400 text-xs font-bold tracking-widest uppercase rounded-full border border-amber-500/20 mb-4"><?php echo $t['section_subtitle']; ?></span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 tracking-tight"><?php echo $t['section_title']; ?></h2>
            <a href="https://g.co/kgs/8t9vHjZ" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-3 bg-slate-900 border border-slate-700 rounded-full px-5 py-2.5 hover:border-amber-500/40 transition-colors group">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                <span class="text-white font-bold text-lg">4.9</span>
                <div class="flex"><?php echo render_stars(5); ?></div>
                <span class="text-slate-400 text-sm"><?php echo $t['badge_text']; ?></span>
                <svg class="w-4 h-4 text-slate-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

        <?php if (!empty($reviews)): ?>
        <!-- Embla Carousel -->
        <div class="embla relative" id="testimonios-embla">
            <div class="embla__viewport overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/50 backdrop-blur-sm">
                <div class="embla__container flex">
                    <?php foreach ($reviews as $r): ?>
                    <div class="embla__slide min-w-0 px-6 md:px-12 py-12 md:py-16" style="flex: 0 0 100%;">
                        <div class="max-w-3xl mx-auto text-center">
                            <div class="flex justify-center gap-1 mb-8"><?php echo render_stars($r['rating']); ?></div>
                            <blockquote class="text-xl md:text-2xl lg:text-3xl text-white font-light leading-relaxed mb-10">&ldquo;<?php echo htmlspecialchars($r['text'], ENT_QUOTES, 'UTF-8'); ?>&rdquo;</blockquote>
                            <div class="flex items-center justify-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brand-600 to-brand-800 flex items-center justify-center text-white font-bold text-lg"><?php echo htmlspecialchars(substr($r['author'], 0, 1), ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="text-left">
                                    <p class="text-white font-semibold"><?php echo htmlspecialchars($r['author'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="text-slate-400 text-sm"><?php echo htmlspecialchars($r['type'], ENT_QUOTES, 'UTF-8'); ?> &middot; <?php echo htmlspecialchars($r['city'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            </div>
                            <?php if ($r['rating'] === 4): ?>
                            <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full">
                                <svg class="w-3 h-3 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span class="text-amber-400 text-xs"><?php echo $t['imperfection']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Arrows -->
            <button type="button" class="embla__prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-6 w-10 h-10 md:w-12 md:h-12 rounded-full border border-slate-700 bg-slate-900/90 text-slate-300 hover:text-white hover:border-brand-500 flex items-center justify-center transition-all z-10" aria-label="Anterior">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button type="button" class="embla__next absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-6 w-10 h-10 md:w-12 md:h-12 rounded-full border border-slate-700 bg-slate-900/90 text-slate-300 hover:text-white hover:border-brand-500 flex items-center justify-center transition-all z-10" aria-label="Siguiente">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <!-- Dots -->
            <div class="embla__dots flex justify-center gap-2 mt-8">
                <?php foreach ($reviews as $i => $r): ?>
                <button type="button" class="embla__dot w-2 h-2 rounded-full transition-all duration-300 <?php echo $i === 0 ? 'bg-brand-500 w-6' : 'bg-slate-700 hover:bg-slate-500'; ?>" data-index="<?php echo $i; ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>

        <script src="<?php echo get_template_directory_uri(); ?>/assets/js/embla-carousel.umd.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/assets/js/embla-carousel-autoplay.umd.js"></script>
        <script>
        (function() {
            var emblaNode = document.getElementById('testimonios-embla');
            if (!emblaNode || typeof EmblaCarousel === 'undefined') return;

            var viewportNode = emblaNode.querySelector('.embla__viewport');
            var prevBtn = emblaNode.querySelector('.embla__prev');
            var nextBtn = emblaNode.querySelector('.embla__next');
            var dots = emblaNode.querySelectorAll('.embla__dot');

            var autoplayPlugin = EmblaCarouselAutoplay({
                delay: 5000,
                stopOnInteraction: false,
                stopOnMouseEnter: true,
                rootNode: function(emblaRoot) { return emblaRoot.parentNode; }
            });

            var embla = EmblaCarousel(viewportNode, {
                loop: true,
                align: 'start',
                containScroll: false
            }, [autoplayPlugin]);

            function updateDots() {
                var selected = embla.selectedScrollSnap();
                dots.forEach(function(dot, i) {
                    var isActive = i === selected;
                    dot.classList.toggle('bg-brand-500', isActive);
                    dot.classList.toggle('w-6', isActive);
                    dot.classList.toggle('bg-slate-700', !isActive);
                    dot.classList.toggle('w-2', !isActive);
                });
            }

            embla.on('select', updateDots);

            prevBtn.addEventListener('click', function() {
                embla.scrollPrev();
                autoplayPlugin.reset();
            });
            nextBtn.addEventListener('click', function() {
                embla.scrollNext();
                autoplayPlugin.reset();
            });
            dots.forEach(function(dot) {
                dot.addEventListener('click', function() {
                    embla.scrollTo(parseInt(dot.dataset.index));
                    autoplayPlugin.reset();
                });
            });

            updateDots();
        })();
        </script>
        <?php endif; ?>

        <div class="text-center mt-12">
            <a href="https://g.co/kgs/8t9vHjZ" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-slate-400 hover:text-amber-400 transition-colors text-sm font-medium">
                <?php echo $t['view_cta']; ?>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
