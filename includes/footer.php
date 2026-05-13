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
<footer class="bg-slate-950 border-t border-slate-800 pt-16 pb-8" role="contentinfo">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-10 mb-16">
      <div class="lg:col-span-2">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-8 h-8 bg-brand-600 rounded-sm flex items-center justify-center">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M2 22h20M2 6h20M2 10h20M2 14h20M2 18h20"/><line x1="6" y1="2" x2="6" y2="22"/><line x1="12" y1="2" x2="12" y2="22"/><line x1="18" y1="2" x2="18" y2="22"/></svg>
          </div>
          <span class="font-display font-bold text-white">SANTA FE</span>
        </div>
        <p class="text-slate-400 text-sm leading-relaxed mb-4 max-w-sm"><?php echo t($translations, 'footer.tagline'); ?></p>
        <div class="space-y-2 text-sm">
          <a href="mailto:<?php echo COMPANY_EMAIL; ?>" class="text-slate-300 hover:text-brand-400 transition-colors block"><?php echo COMPANY_EMAIL; ?></a>
          <a href="tel:<?php echo COMPANY_PHONE; ?>" class="text-slate-300 hover:text-brand-400 transition-colors block" data-track-event="phone_click"><?php echo COMPANY_PHONE_DISPLAY; ?></a>
        </div>
      </div>

      <nav aria-label="Servicios">
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4"><?php echo t($translations, 'footer.services_title'); ?></h4>
        <ul class="space-y-2.5 text-sm">
          <li><a href="/<?php echo $lang; ?>/servicios/obra-nueva/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'services.new_build'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/reformas-integrales/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'services.renovation'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/pladur-acabados/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'services.plaster'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/obra-publica/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'services.public'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/servicios/obra-civil/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'services.civil'); ?></a></li>
        </ul>
      </nav>

      <nav aria-label="Empresa">
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4"><?php echo t($translations, 'footer.company_title'); ?></h4>
        <ul class="space-y-2.5 text-sm">
          <li><a href="/<?php echo $lang; ?>/proyectos/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'nav.projects'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/sobre-nosotros/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'nav.about'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/contacto/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'nav.contact'); ?></a></li>
        </ul>
      </nav>

      <nav aria-label="Legal">
        <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4"><?php echo t($translations, 'footer.legal_title'); ?></h4>
        <ul class="space-y-2.5 text-sm">
          <li><a href="/<?php echo $lang; ?>/aviso-legal/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'footer.legal_notice'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/politica-privacidad/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'footer.privacy'); ?></a></li>
          <li><a href="/<?php echo $lang; ?>/politica-cookies/" class="text-slate-400 hover:text-brand-400 transition-colors"><?php echo t($translations, 'footer.cookies'); ?></a></li>
          <li><button type="button" class="text-slate-400 hover:text-brand-400 transition-colors" onclick="cookieConsent.showSettings()"><?php echo t($translations, 'footer.configure_cookies'); ?></button></li>
        </ul>
      </nav>
    </div>

    <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
      <p class="text-slate-600 text-xs">© <?php echo $current_year; ?> <?php echo t($translations, 'footer.company'); ?>. <?php echo t($translations, 'footer.rights'); ?></p>
      <div class="flex items-center gap-6">
        <a href="/<?php echo $lang; ?>/aviso-legal/" class="text-slate-600 hover:text-brand-400 text-xs transition-colors"><?php echo t($translations, 'footer.legal_notice'); ?></a>
        <a href="/<?php echo $lang; ?>/politica-privacidad/" class="text-slate-600 hover:text-brand-400 text-xs transition-colors"><?php echo t($translations, 'footer.privacy'); ?></a>
        <a href="/<?php echo $lang; ?>/politica-cookies/" class="text-slate-600 hover:text-brand-400 text-xs transition-colors"><?php echo t($translations, 'footer.cookies'); ?></a>
      </div>
    </div>
  </div>
</footer>

<!-- Cookie Banner -->
<div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-slate-900/98 backdrop-blur-xl border-t border-slate-800 z-50" hidden role="dialog" aria-modal="true" aria-labelledby="cookie-title">
  <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
    <p id="cookie-title" class="text-slate-300 text-sm flex-1"><?php echo t($translations, 'cookies.banner_text'); ?> <a href="/<?php echo $lang; ?>/politica-cookies/" class="text-brand-400 hover:text-brand-300 underline"><?php echo t($translations, 'cookies.policy_link'); ?></a></p>
    <div class="flex gap-3 flex-shrink-0">
      <button type="button" class="px-5 py-2.5 border border-slate-600 text-slate-300 text-sm font-medium rounded-sm hover:border-slate-400 hover:text-white transition-all" onclick="cookieConsent.rejectAll()"><?php echo t($translations, 'cookies.reject_all'); ?></button>
      <button type="button" class="px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-sm hover:bg-brand-500 transition-all" onclick="cookieConsent.acceptAll()"><?php echo t($translations, 'cookies.accept_all'); ?></button>
    </div>
  </div>
</div>

<!-- Cookie Settings Panel -->
<div id="cookie-settings" class="fixed inset-0 bg-black/50 z-[60] items-center justify-center" hidden role="dialog" aria-modal="true">
  <div class="bg-slate-900 border border-slate-800 rounded-sm p-8 max-w-lg w-[90%] max-h-[90vh] overflow-y-auto">
    <h2 class="font-display font-bold text-2xl text-white mb-6"><?php echo t($translations, 'cookies.configure'); ?></h2>
    
    <div class="space-y-5 mb-8">
      <div class="pb-5 border-b border-slate-800">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" checked disabled class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-white"><?php echo t($translations, 'cookies.necessary_title'); ?></span>
        </label>
        <p class="text-slate-500 text-sm ml-9"><?php echo t($translations, 'cookies.necessary_desc'); ?></p>
      </div>
      <div class="pb-5 border-b border-slate-800">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" id="consent-analytics" class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-white"><?php echo t($translations, 'cookies.analytics_title'); ?></span>
        </label>
        <p class="text-slate-500 text-sm ml-9"><?php echo t($translations, 'cookies.analytics_desc'); ?></p>
      </div>
      <div class="pb-5 border-b border-slate-800">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" id="consent-functional" class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-white"><?php echo t($translations, 'cookies.functional_title'); ?></span>
        </label>
        <p class="text-slate-500 text-sm ml-9"><?php echo t($translations, 'cookies.functional_desc'); ?></p>
      </div>
      <div class="pb-5 border-b border-slate-800">
        <label class="flex items-center gap-4 cursor-pointer mb-2">
          <input type="checkbox" id="consent-marketing" class="w-5 h-5 accent-brand-600">
          <span class="font-semibold text-white"><?php echo t($translations, 'cookies.marketing_title'); ?></span>
        </label>
        <p class="text-slate-500 text-sm ml-9"><?php echo t($translations, 'cookies.marketing_desc'); ?></p>
      </div>
    </div>
    
    <div class="flex justify-between items-center">
      <a href="/<?php echo $lang; ?>/politica-cookies/" class="text-brand-400 text-sm hover:text-brand-300 underline"><?php echo t($translations, 'cookies.policy_link'); ?></a>
      <button type="button" class="bg-brand-600 hover:bg-brand-500 text-white font-semibold px-6 py-3 rounded-sm transition-all" onclick="cookieConsent.saveCustom()"><?php echo t($translations, 'cookies.save_preferences'); ?></button>
    </div>
  </div>
</div>

<!-- Sticky CTA Mobile -->
<div id="sticky-cta-mobile" class="fixed bottom-0 left-0 right-0 z-50 bg-slate-950/95 backdrop-blur-xl border-t border-slate-800 p-4 lg:hidden" aria-hidden="true">
  <div class="flex items-center gap-3">
    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20quiero%20un%20presupuesto" 
       target="_blank" rel="noopener noreferrer"
       class="flex-1 bg-[#25d366] hover:bg-[#128c7e] text-white font-semibold py-3 px-4 rounded-sm text-center text-sm transition-colors"
       data-track-event="whatsapp_click">
      WhatsApp — Responde en 2h
    </a>
    <a href="tel:<?php echo COMPANY_PHONE; ?>" 
       class="flex-1 bg-brand-600 hover:bg-brand-500 text-white font-semibold py-3 px-4 rounded-sm text-center text-sm transition-colors"
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

  // 4. Header scroll detection (if not already handled by navigation.js)
  var header = document.getElementById('site-nav');
  if (header) {
    function updateHeader() {
      if (window.scrollY > 50) {
        header.classList.add('header-scrolled');
      } else {
        header.classList.remove('header-scrolled');
      }
    }
    window.addEventListener('scroll', function() {
      requestAnimationFrame(updateHeader);
    }, { passive: true });
    updateHeader();
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
