<?php
/**
 * Footer con Tailwind CSS + Cookie Banner
 */

require_once __DIR__ . '/../config/constants.php';

$lang = isset($page_data['lang']) && in_array($page_data['lang'], ['es','ca'], true) ? $page_data['lang'] : 'es';
$translations = load_translations($lang);

$current_year = date('Y');
?>
</main>

<!-- Footer -->
<footer class="bg-gradient-to-br from-warm-900 to-brand-950 text-warm-400 pt-20 pb-10 border-t border-warm-800" role="contentinfo">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-10 mb-16">
      <div class="lg:col-span-2">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-600/20">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M2 22h20M2 6h20M2 10h20M2 14h20M2 18h20"/><line x1="6" y1="2" x2="6" y2="22"/><line x1="12" y1="2" x2="12" y2="22"/><line x1="18" y1="2" x2="18" y2="22"/></svg>
          </div>
          <span class="font-display font-bold text-white text-lg tracking-tight">SANTA FE</span>
        </div>
        <p class="text-warm-400 text-sm leading-relaxed mb-6 max-w-sm"><?php echo t($translations, 'footer.tagline'); ?></p>
        <div class="space-y-3 text-sm">
          <a href="mailto:<?php echo COMPANY_EMAIL; ?>" class="text-warm-400 hover:text-brand-400 transition-colors duration-300 block flex items-center gap-2">
            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <?php echo COMPANY_EMAIL; ?>
          </a>
          <a href="tel:<?php echo COMPANY_PHONE; ?>" class="text-warm-400 hover:text-brand-400 transition-colors duration-300 block flex items-center gap-2" data-track-event="phone_click">
            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            <?php echo COMPANY_PHONE_DISPLAY; ?>
          </a>
        </div>
      </div>

      <nav aria-label="Servicios">
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5"><?php echo t($translations, 'footer.services_title'); ?></h4>
        <ul class="space-y-3 text-sm">
          <li><a href="/<?php echo $lang; ?>/servicios/obra-nueva/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'services.new_build'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/reformas-integrales/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'services.renovation'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/pladur-acabados/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'services.plaster'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/obra-publica/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'services.public'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/obra-civil/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'services.civil'); ?></a></li>
        </ul>
      </nav>

      <nav aria-label="Empresa">
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5"><?php echo t($translations, 'footer.company_title'); ?></h4>
        <ul class="space-y-3 text-sm">
          <li><a href="/<?php echo $lang; ?>/proyectos/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'nav.projects'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/sobre-nosotros/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'nav.about'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/contacto/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'nav.contact'); ?></a></li>
        </ul>
      </nav>

      <nav aria-label="Legal">
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5"><?php echo t($translations, 'footer.legal_title'); ?></h4>
        <ul class="space-y-3 text-sm">
          <li><a href="/<?php echo $lang; ?>/aviso-legal/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'footer.legal_notice'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/politica-privacidad/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'footer.privacy'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/politica-cookies/" class="text-warm-400 hover:text-brand-400 transition-colors duration-300"><?php echo t($translations, 'footer.cookies'); ?></a></li>
          <li><button type="button" class="text-warm-400 hover:text-brand-400 transition-colors duration-300" onclick="cookieConsent.showSettings()"><?php echo t($translations, 'footer.configure_cookies'); ?></button></li>
        </ul>
      </nav>
    </div>

    <div class="border-t border-warm-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
      <p class="text-warm-500 text-xs">© <?php echo $current_year; ?> <?php echo t($translations, 'footer.company'); ?>. <?php echo t($translations, 'footer.rights'); ?></p>
      <div class="flex items-center gap-6">
        <a href="/<?php echo $lang; ?>/aviso-legal/" class="text-warm-500 hover:text-brand-400 text-xs transition-colors duration-300"><?php echo t($translations, 'footer.legal_notice'); ?></a>
        <a href="/<?php echo $lang; ?>/politica-privacidad/" class="text-warm-500 hover:text-brand-400 text-xs transition-colors duration-300"><?php echo t($translations, 'footer.privacy'); ?></a>
        <a href="/<?php echo $lang; ?>/politica-cookies/" class="text-warm-500 hover:text-brand-400 text-xs transition-colors duration-300"><?php echo t($translations, 'footer.cookies'); ?></a>
      </div>
    </div>
  </div>
</footer>

<!-- Cookie Banner -->
<div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-white/98 backdrop-blur-xl border-t border-warm-200 z-50" hidden role="dialog" aria-modal="true" aria-labelledby="cookie-title">
  <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
    <p id="cookie-title" class="text-warm-600 text-sm flex-1"><?php echo t($translations, 'cookies.banner_text'); ?> <a href="/<?php echo $lang; ?>/politica-cookies/" class="text-brand-600 hover:text-brand-500 underline transition-colors"><?php echo t($translations, 'cookies.policy_link'); ?></a></p>
    <div class="flex gap-3 flex-shrink-0">
      <button type="button" class="px-5 py-2.5 border border-warm-300 text-warm-600 text-sm font-medium rounded-xl hover:border-warm-400 hover:text-warm-900 transition-all duration-300" onclick="cookieConsent.rejectAll()"><?php echo t($translations, 'cookies.reject_all'); ?></button>
      <button type="button" class="px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-all duration-300 shadow-lg shadow-brand-600/20" onclick="cookieConsent.acceptAll()"><?php echo t($translations, 'cookies.accept_all'); ?></button>
    </div>
  </div>
</div>

<!-- Cookie Settings Panel -->
<div id="cookie-settings" class="fixed inset-0 bg-black/50 z-[60] items-center justify-center" hidden role="dialog" aria-modal="true">
  <div class="bg-white border border-warm-200 rounded-2xl p-8 max-w-lg w-[90%] max-h-[90vh] overflow-y-auto shadow-2xl">
    <h2 class="font-display font-bold text-2xl text-warm-900 mb-6"><?php echo t($translations, 'cookies.configure'); ?></h2>
    
    <div class="space-y-5 mb-8">
      <div class="pb-5 border-b border-warm-200">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" checked disabled class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-warm-900"><?php echo t($translations, 'cookies.necessary_title'); ?></span>
        </label>
        <p class="text-warm-600 text-sm ml-9"><?php echo t($translations, 'cookies.necessary_desc'); ?></p>
      </div>
      <div class="pb-5 border-b border-warm-200">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" id="consent-analytics" class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-warm-900"><?php echo t($translations, 'cookies.analytics_title'); ?></span>
        </label>
        <p class="text-warm-600 text-sm ml-9"><?php echo t($translations, 'cookies.analytics_desc'); ?></p>
      </div>
      <div class="pb-5 border-b border-warm-200">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" id="consent-functional" class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-warm-900"><?php echo t($translations, 'cookies.functional_title'); ?></span>
        </label>
        <p class="text-warm-600 text-sm ml-9"><?php echo t($translations, 'cookies.functional_desc'); ?></p>
      </div>
      <div class="pb-5 border-b border-warm-200">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" id="consent-marketing" class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-warm-900"><?php echo t($translations, 'cookies.marketing_title'); ?></span>
        </label>
        <p class="text-warm-600 text-sm ml-9"><?php echo t($translations, 'cookies.marketing_desc'); ?></p>
      </div>
    </div>
    
    <div class="flex justify-between items-center">
      <a href="/<?php echo $lang; ?>/politica-cookies/" class="text-brand-600 text-sm hover:text-brand-500 underline transition-colors"><?php echo t($translations, 'cookies.policy_link'); ?></a>
      <button type="button" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 shadow-lg shadow-brand-600/20" onclick="cookieConsent.saveCustom()"><?php echo t($translations, 'cookies.save_preferences'); ?></button>
    </div>
  </div>
</div>

<!-- Sticky CTA Mobile -->
<div id="sticky-cta-mobile" class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-t border-warm-200 p-4 lg:hidden" aria-hidden="true">
  <div class="flex items-center gap-3">
    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20quiero%20un%20presupuesto" 
       target="_blank" rel="noopener noreferrer"
       class="flex-1 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold py-3 px-4 rounded-xl text-center text-sm transition-all duration-300 shadow-lg"
       data-track-event="whatsapp_click">
      WhatsApp — Responde en 2h
    </a>
    <a href="tel:<?php echo COMPANY_PHONE; ?>" 
       class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-4 rounded-xl text-center text-sm transition-all duration-300 shadow-lg shadow-brand-600/20"
       data-track-event="phone_click">
      Llamar ahora
    </a>
  </div>
</div>

<!-- Interaction Scripts -->
<script>
(function() {
  'use strict';

  // 1. Scroll Progress Bar
  var progressBar = document.getElementById('scroll-progress');
  if (progressBar) {
    var ticking = false;
    function updateProgress() {
      var scrollTop = window.scrollY || document.documentElement.scrollTop;
      var docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      var progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
      progressBar.style.width = progress + '%';
      ticking = false;
    }
    window.addEventListener('scroll', function() {
      if (!ticking) {
        requestAnimationFrame(updateProgress);
        ticking = true;
      }
    }, { passive: true });
  }

  // 2. Sticky CTA Mobile — aparece após scroll de 400px, some ao voltar ao topo
  var stickyCta = document.getElementById('sticky-cta-mobile');
  if (stickyCta) {
    var lastScrollY = 0;
    var ctaVisible = false;
    function updateStickyCta() {
      var scrollY = window.scrollY || document.documentElement.scrollTop;
      if (scrollY > 400 && scrollY > lastScrollY && !ctaVisible) {
        stickyCta.classList.add('visible');
        ctaVisible = true;
      } else if ((scrollY < 300 || scrollY < lastScrollY) && ctaVisible) {
        stickyCta.classList.remove('visible');
        ctaVisible = false;
      }
      lastScrollY = scrollY;
    }
    window.addEventListener('scroll', function() {
      requestAnimationFrame(updateStickyCta);
    }, { passive: true });
  }

  // 3. Parallax sutil no hero
  var heroSection = document.getElementById('inicio');
  var heroImg = heroSection ? heroSection.querySelector('img') : null;
  if (heroImg && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    var heroTicking = false;
    function updateHeroParallax() {
      var scrollY = window.scrollY || document.documentElement.scrollTop;
      if (scrollY < window.innerHeight) {
        heroImg.style.transform = 'translateY(' + (scrollY * 0.15) + 'px) scale(1.05)';
      }
      heroTicking = false;
    }
    window.addEventListener('scroll', function() {
      if (!heroTicking) {
        requestAnimationFrame(updateHeroParallax);
        heroTicking = true;
      }
    }, { passive: true });
  }

  // 5. 3D Tilt Effect on Cards
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('.tilt-card').forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var centerX = rect.width / 2;
        var centerY = rect.height / 2;
        var rotateX = (y - centerY) / centerY * -4;
        var rotateY = (x - centerX) / centerX * 4;
        card.style.transform = 'perspective(1000px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale3d(1.02, 1.02, 1.02)';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
      });
    });
  }

  // 6. Skeleton loading for images
  document.querySelectorAll('img[loading="lazy"]').forEach(function(img) {
    if (!img.complete) {
      img.classList.add('skeleton');
      img.addEventListener('load', function() {
        img.classList.remove('skeleton');
      });
      img.addEventListener('error', function() {
        img.classList.remove('skeleton');
      });
    }
  });
})();
</script>

<?php wp_footer(); ?>

</body>
</html>
