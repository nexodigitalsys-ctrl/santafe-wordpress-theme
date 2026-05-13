/**
 * Premium Interactions — Código pronto e otimizado
 * Counter Animation + Before/After + Focus Cards + Scroll Spy
 * Fontes: snippets open-source + adaptações próprias
 */

(function() {
    'use strict';

    // ==========================================
    // 1. Counter Animation (IntersectionObserver)
    // Referência: countUp.js simplificado + IntersectionObserver
    // ==========================================
    function animateCounter(el, target, duration, suffix) {
        var start = 0;
        var startTime = null;
        suffix = suffix || '';
        function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }
        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var current = Math.floor(easeOutQuart(progress) * target);
            el.textContent = current.toLocaleString('es-ES') + suffix;
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString('es-ES') + suffix;
        }
        requestAnimationFrame(step);
    }

    var counters = document.querySelectorAll('[data-counter]');
    if (counters.length && 'IntersectionObserver' in window) {
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    var target = parseInt(el.dataset.counter, 10);
                    var duration = parseInt(el.dataset.counterDuration, 10) || 2000;
                    var suffix = el.dataset.counterSuffix || '';
                    animateCounter(el, target, duration, suffix);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(function(el) { counterObserver.observe(el); });
    }

    // ==========================================
    // 2. Before/After Image Comparison Slider
    // Referência: TwentyTwenty (simplificado, sem jQuery)
    // ==========================================
    function initBeforeAfter(container) {
        var before = container.querySelector('.before-after__before');
        var after = container.querySelector('.before-after__after');
        var handle = container.querySelector('.before-after__handle');
        var dragging = false;

        function updatePosition(x) {
            var rect = container.getBoundingClientRect();
            var pos = Math.max(0, Math.min(1, (x - rect.left) / rect.width));
            before.style.clipPath = 'inset(0 ' + ((1 - pos) * 100) + '% 0 0)';
            handle.style.left = (pos * 100) + '%';
        }

        handle.addEventListener('mousedown', function(e) { dragging = true; e.preventDefault(); });
        handle.addEventListener('touchstart', function(e) { dragging = true; }, {passive: true});

        window.addEventListener('mousemove', function(e) { if (dragging) updatePosition(e.clientX); });
        window.addEventListener('touchmove', function(e) { if (dragging) updatePosition(e.touches[0].clientX); }, {passive: true});

        window.addEventListener('mouseup', function() { dragging = false; });
        window.addEventListener('touchend', function() { dragging = false; });

        container.addEventListener('click', function(e) { updatePosition(e.clientX); });
    }

    document.querySelectorAll('.before-after').forEach(initBeforeAfter);

    // ==========================================
    // 3. Service Card Focus Effect
    // Referência: Space Care hover pattern
    // ==========================================
    var serviceGrid = document.getElementById('servicios-grid');
    if (serviceGrid) {
        var cards = serviceGrid.querySelectorAll('.service-card');
        cards.forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                cards.forEach(function(c) {
                    if (c !== card) c.style.opacity = '0.35';
                });
            });
            card.addEventListener('mouseleave', function() {
                cards.forEach(function(c) { c.style.opacity = '1'; });
            });
        });
    }

    // ==========================================
    // 4. Sticky Dot Navigation (ScrollSpy)
    // Referência: Bootstrap ScrollSpy simplificado
    // ==========================================
    var sections = document.querySelectorAll('section[id]');
    var dotsContainer = document.getElementById('section-dots');
    if (dotsContainer && sections.length) {
        var dots = dotsContainer.querySelectorAll('.section-dot');
        var sectionObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var id = entry.target.id;
                    dots.forEach(function(dot) {
                        var active = dot.dataset.target === '#' + id;
                        dot.classList.toggle('active', active);
                        dot.classList.toggle('bg-brand-500', active);
                        dot.classList.toggle('scale-150', active);
                        dot.classList.toggle('bg-slate-600', !active);
                    });
                }
            });
        }, { threshold: 0.3, rootMargin: '-100px 0px -50% 0px' });
        sections.forEach(function(s) { sectionObserver.observe(s); });

        dots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                var target = document.querySelector(dot.dataset.target);
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }

    // ==========================================
    // 5. Scroll-triggered reveal for sections
    // Referência: AOS.js simplificado
    // ==========================================
    var revealEls = document.querySelectorAll('[data-reveal]');
    if (revealEls.length && 'IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    var delay = parseInt(el.dataset.revealDelay, 10) || 0;
                    setTimeout(function() {
                        el.classList.add('is-revealed');
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, delay);
                    revealObserver.unobserve(el);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
        revealEls.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = 'opacity 0.8s cubic-bezier(0.16,1,0.3,1), transform 0.8s cubic-bezier(0.16,1,0.3,1)';
            revealObserver.observe(el);
        });
        // Fallback: reveal all after 3s if observer never fired (prevents invisible content bugs)
        setTimeout(function() {
            revealEls.forEach(function(el) {
                if (!el.classList.contains('is-revealed')) {
                    el.classList.add('is-revealed');
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }
            });
        }, 3000);
    }

})();
