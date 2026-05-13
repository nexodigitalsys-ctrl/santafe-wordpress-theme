/**
 * Main.js — Santa Fe Construcciones
 * Calculadora AJAX, Portfolio Filter, Scroll Reveal
 */

(function() {
    'use strict';

    // ==========================================
    // 1. Budget Calculator (AJAX)
    // ==========================================
    const calcForm = document.getElementById('form-calculadora');
    const calcResult = document.getElementById('calculadora-resultado');

    if (calcForm) {
        const service = calcForm.querySelector('[data-calc-service]');
        const m2 = calcForm.querySelector('[data-calc-m2]');
        const city = calcForm.querySelector('[data-calc-city]');
        const finish = calcForm.querySelector('[data-calc-finish]');
        const resultDisplay = calcForm.querySelector('[data-calc-result]');

        function formatEuro(value) {
            return new Intl.NumberFormat('es-ES', {
                style: 'currency',
                currency: 'EUR',
                maximumFractionDigits: 0
            }).format(value);
        }

        function calculateClientSide() {
            // Precios base por m² según manual
            var precios = {
                'obra_nueva': { 'basico': 800, 'estandar': 1100, 'premium': 1600 },
                'reforma_integral': { 'basico': 600, 'estandar': 900, 'premium': 1400 },
                'pladur': { 'basico': 40, 'estandar': 70, 'premium': 120 },
                'obra_publica': { 'basico': 500, 'estandar': 800, 'premium': 1200 },
                'obra_civil': { 'basico': 400, 'estandar': 700, 'premium': 1000 }
            };
            var multiplicador = {
                'barcelona': 1.0,
                'girona': 0.95,
                'tarragona': 0.90,
                'otros': 1.0
            };

            var tipo = service ? service.value : 'reforma_integral';
            var metros = m2 ? parseFloat(m2.value) || 0 : 0;
            var ciudad = city ? city.value : 'barcelona';
            var acabado = finish ? finish.value : 'estandar';

            if (metros < 10) metros = 10;

            var precio_m2 = (precios[tipo] && precios[tipo][acabado]) ? precios[tipo][acabado] : 900;
            var mult = multiplicador[ciudad] || 1.0;
            var base = metros * precio_m2 * mult;
            var low = Math.round(base * 0.82 / 100) * 100;
            var high = Math.round(base * 1.18 / 100) * 100;

            if (resultDisplay) {
                resultDisplay.textContent = formatEuro(low) + ' — ' + formatEuro(high);
            }

            return { min: low, max: high, base: base };
        }

        if (service) service.addEventListener('change', calculateClientSide);
        if (m2) { m2.addEventListener('input', calculateClientSide); m2.addEventListener('change', calculateClientSide); }
        if (city) city.addEventListener('change', calculateClientSide);
        if (finish) finish.addEventListener('change', calculateClientSide);
        calculateClientSide();

        // AJAX submit
        calcForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var submitBtn = calcForm.querySelector('button[type="submit"]');
            var originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Calculando...'; }
            if (calcResult) calcResult.innerHTML = '';

            var formData = new FormData(calcForm);
            var data = {};
            formData.forEach(function(value, key) { data[key] = value; });

            fetch(calcForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': (window.santafeConfig && window.santafeConfig.csrfToken) || window.csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success && res.estimacion) {
                    if (calcResult) {
                        calcResult.innerHTML = '<div class="border border-green-500 bg-slate-950 p-4 rounded-sm text-white mt-4" role="alert">' +
                            '<p class="font-display font-bold text-xl">Horquilla: ' + formatEuro(res.estimacion.min) + ' — ' + formatEuro(res.estimacion.max) + '</p>' +
                            '<p class="text-slate-400 text-sm mt-2">' + (res.message || '') + '</p>' +
                        '</div>';
                    }
                } else if (res.errors && res.errors.length) {
                    if (calcResult) calcResult.innerHTML = '<div class="border border-red-500 bg-slate-950 p-4 rounded-sm text-white mt-4" role="alert">' + res.errors.join('<br>') + '</div>';
                }
            })
            .catch(function() {
                // Fallback: mostrar cálculo client-side
                var est = calculateClientSide();
                if (calcResult) {
                    calcResult.innerHTML = '<div class="border border-brand-500 bg-slate-950 p-4 rounded-sm text-white mt-4" role="alert">' +
                        '<p class="font-display font-bold text-xl">Horquilla: ' + formatEuro(est.min) + ' — ' + formatEuro(est.max) + '</p>' +
                        '<p class="text-slate-400 text-sm mt-2">Estimación inicial. Solicita visita técnica para precisión real.</p>' +
                    '</div>';
                }
            })
            .finally(function() {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
            });
        });
    }

    // ==========================================
    // 2. Portfolio Filter
    // ==========================================
    var filterBtns = document.querySelectorAll('.portfolio-filter__btn');
    var portfolioItems = document.querySelectorAll('.portfolio-card');

    if (filterBtns.length > 0) {
        filterBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var filter = btn.dataset.filter;
                filterBtns.forEach(function(b) {
                    b.classList.remove('bg-brand-600', 'border-brand-600', 'text-slate-950');
                    b.classList.add('border-slate-700', 'text-slate-300');
                });
                btn.classList.remove('border-slate-700', 'text-slate-300');
                btn.classList.add('bg-brand-600', 'border-brand-600', 'text-slate-950');

                portfolioItems.forEach(function(item) {
                    var category = item.dataset.category;
                    if (filter === 'all' || category === filter) {
                        item.style.display = '';
                        setTimeout(function() { item.style.opacity = '1'; }, 10);
                    } else {
                        item.style.opacity = '0';
                        setTimeout(function() { item.style.display = 'none'; }, 300);
                    }
                });
            });
        });
    }

    // ==========================================
    // 3. Scroll Reveal
    // ==========================================
    var revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length > 0 && 'IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        revealElements.forEach(function(el) { revealObserver.observe(el); });
    }

    // ==========================================
    // 4. Portfolio Lightbox
    // ==========================================
    var lightbox = document.getElementById('portfolio-lightbox');
    var lightboxImg = document.getElementById('portfolio-lightbox-img');
    var lightboxTitle = document.getElementById('portfolio-lightbox-title');
    var lightboxClose = document.getElementById('portfolio-lightbox-close');

    if (lightbox && lightboxImg) {
        document.querySelectorAll('.portfolio-card img').forEach(function(img) {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', function() {
                lightboxImg.src = this.src;
                lightboxImg.alt = this.alt;
                if (lightboxTitle) {
                    lightboxTitle.textContent = this.alt;
                }
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });
        });

        if (lightboxClose) {
            lightboxClose.addEventListener('click', function() {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.style.overflow = '';
            });
        }

        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.style.overflow = '';
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.style.overflow = '';
            }
        });
    }

    // ==========================================
    // 5. Smooth Scroll
    // ==========================================
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})();
