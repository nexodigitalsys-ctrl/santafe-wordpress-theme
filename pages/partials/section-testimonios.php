<?php
/**
 * Sección Testimonios
 * "Lo que dicen nuestros clientes"
 * MANTENER HIDDEN hasta tener reviews reales autorizadas
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'El que diuen els nostres clients' : 'Lo que dicen nuestros clientes';

// Placeholder de reviews — sustituir por datos reales cuando estén autorizados
$reviews = [
    ['rating' => 5, 'text' => 'Placeholder de reseña 1', 'author' => 'Cliente 1', 'type' => 'Reforma integral', 'city' => 'Barcelona'],
    ['rating' => 5, 'text' => 'Placeholder de reseña 2', 'author' => 'Cliente 2', 'type' => 'Obra nueva', 'city' => 'Girona'],
    ['rating' => 5, 'text' => 'Placeholder de reseña 3', 'author' => 'Cliente 3', 'type' => 'Pladur', 'city' => 'Tarragona'],
];
?>

<!-- Testimonios: HIDDEN hasta autorización de reviews reales -->
<div class="hidden" data-testimonios-placeholder>
<section class="py-24 md:py-32 bg-slate-900 border-y border-slate-800" id="testimonios">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="industrial-line w-12"></div>
                <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $title; ?></span>
                <div class="industrial-line industrial-line-reverse w-12"></div>
            </div>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight"><?php echo $title; ?></h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($reviews as $review): ?>
            <blockquote class="bg-slate-950 border-l-2 border-brand-600 p-8 rounded-r-sm">
                <div class="text-brand-500 text-xl mb-4" aria-label="<?php echo $review['rating']; ?> estrellas">
                    <?php echo str_repeat('★', $review['rating']); ?>
                </div>
                <p class="text-slate-200 text-lg leading-relaxed mb-6 font-light">"<?php echo htmlspecialchars($review['text']); ?>"</p>
                <footer>
                    <cite class="not-italic">
                        <span class="text-white font-semibold block"><?php echo htmlspecialchars($review['author']); ?></span>
                        <span class="text-slate-500 text-sm"><?php echo htmlspecialchars($review['type']); ?> · <?php echo htmlspecialchars($review['city']); ?></span>
                    </cite>
                </footer>
            </blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>
</div>
