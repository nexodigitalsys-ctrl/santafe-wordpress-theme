/**
 * Slider.js — Hero Slider accesible y optimizado para CWV
 * Transiciones con transform/opacity únicamente. NUNCA width/height/top/left.
 * Respects prefers-reduced-motion.
 */

onReady(function() {
    class HeroSlider {
        constructor(selector, options) {
            this.container = document.querySelector(selector);
            if (!this.container) return;
            this.slides = this.container.querySelectorAll('.slide');
            if (this.slides.length === 0) return;

            this.current = 0;
            this.autoplay = options.autoplay || false;
            this.interval = options.interval || 5000;
            this.reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            this.timer = null;

            this.init();
        }

        init() {
            // Si reduced motion: mostrar solo slide 1, sin autoplay, sin controles
            if (this.reducedMotion) {
                this.showSlide(0);
                this.hideControls();
                return;
            }

            this.setupAccessibility();
            this.addEventListeners();
            this.showSlide(0);
            if (this.autoplay) this.startAutoplay();
        }

        setupAccessibility() {
            this.container.setAttribute('role', 'region');
            this.container.setAttribute('aria-label', window._t ? window._t('hero.slider_label') : 'Carrusel de servicios principales');

            const dots = this.container.querySelectorAll('.slider-dot');
            dots.forEach(function(dot, i) {
                dot.setAttribute('role', 'tab');
                dot.setAttribute('aria-controls', 'slide-' + i);
                dot.setAttribute('aria-label', 'Diapositiva ' + (i + 1));
            });
        }

        showSlide(index) {
            if (index < 0) index = this.slides.length - 1;
            if (index >= this.slides.length) index = 0;

            // Solo transform y opacity — nunca width/height/top/left
            this.slides.forEach(function(slide, i) {
                slide.style.transform = 'translateX(' + ((i - index) * 100) + '%)';
                slide.setAttribute('aria-hidden', i === index ? 'false' : 'true');
            });

            // Actualizar dots
            const dots = this.container.querySelectorAll('.slider-dot');
            dots.forEach(function(dot, i) {
                dot.setAttribute('aria-selected', i === index ? 'true' : 'false');
                dot.setAttribute('tabindex', i === index ? '0' : '-1');
            });

            this.current = index;
        }

        next() {
            this.showSlide(this.current + 1);
            this.resetAutoplay();
        }

        prev() {
            this.showSlide(this.current - 1);
            this.resetAutoplay();
        }

        startAutoplay() {
            if (this.reducedMotion) return;
            this.timer = setInterval(this.next.bind(this), this.interval);
        }

        stopAutoplay() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        }

        resetAutoplay() {
            if (!this.autoplay) return;
            this.stopAutoplay();
            this.startAutoplay();
        }

        hideControls() {
            const controls = this.container.querySelectorAll('.slider-nav, .slider-controls');
            controls.forEach(function(c) { c.style.display = 'none'; });
        }

        addEventListeners() {
            const self = this;
            const prevBtn = this.container.querySelector('.slider-prev');
            const nextBtn = this.container.querySelector('.slider-next');

            if (prevBtn) prevBtn.addEventListener('click', function() { self.prev(); });
            if (nextBtn) nextBtn.addEventListener('click', function() { self.next(); });

            const dots = this.container.querySelectorAll('.slider-dot');
            dots.forEach(function(dot, i) {
                dot.addEventListener('click', function() {
                    self.showSlide(i);
                    self.resetAutoplay();
                });
            });

            // Pausar autoplay al interactuar
            this.container.addEventListener('mouseenter', function() {
                self.stopAutoplay();
            });
            this.container.addEventListener('mouseleave', function() {
                if (self.autoplay) self.startAutoplay();
            });

            // Keyboard navigation
            this.container.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    self.prev();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    self.next();
                }
            });
        }
    }

    window.heroSlider = new HeroSlider('#hero-slider', { autoplay: true, interval: 6000 });
});
