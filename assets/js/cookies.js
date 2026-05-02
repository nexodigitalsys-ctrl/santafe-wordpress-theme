/**
 * Cookies.js — Banner de Consentimiento RGPD 2026
 * Primera capa + Segunda capa + Bloqueo previo de scripts + Audit Trail
 * Botones de IDÉNTICO peso visual (tamaño, color, fuente)
 * Google Consent Mode v2 (si aplica)
 */

(function() {
    function domReady(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
        } else {
            callback();
        }
    }
    domReady(function() {
    class CookieConsent {
        constructor() {
            this.banner = document.getElementById('cookie-banner');
            this.settingsPanel = document.getElementById('cookie-settings');
            this.consentKey = 'santafe_consent_v1';
            this.policyVersion = '1.0'; // Incrementar cuando cambie la política
            this.init();
        }

        init() {
            const stored = this.getStoredConsent();
            if (!stored || stored.policyVersion !== this.policyVersion || this.isExpired(stored.date)) {
                this.showBanner();
            } else {
                this.applyConsent(stored.choices);
            }
        }

        getStoredConsent() {
            try {
                const raw = localStorage.getItem(this.consentKey);
                return raw ? JSON.parse(raw) : null;
            } catch (e) {
                return null;
            }
        }

        isExpired(dateString) {
            if (!dateString) return true;
            const date = new Date(dateString);
            const now = new Date();
            const diffMonths = (now.getFullYear() - date.getFullYear()) * 12 + (now.getMonth() - date.getMonth());
            return diffMonths >= 12;
        }

        showBanner() {
            if (this.banner) {
                this.banner.hidden = false;
                this.banner.focus();
            }
        }

        hideBanner() {
            if (this.banner) this.banner.hidden = true;
        }

        showSettings() {
            if (this.settingsPanel) {
                this.settingsPanel.hidden = false;
                this.settingsPanel.focus();
            }
        }

        hideSettings() {
            if (this.settingsPanel) this.settingsPanel.hidden = true;
        }

        acceptAll() {
            const choices = { necessary: true, analytics: true, functional: true, marketing: true };
            this.saveConsent(choices, 'accept_all');
        }

        rejectAll() {
            const choices = { necessary: true, analytics: false, functional: false, marketing: false };
            this.saveConsent(choices, 'reject_all');
        }

        saveCustom() {
            const choices = {
                necessary: true,
                analytics: document.getElementById('consent-analytics') ? document.getElementById('consent-analytics').checked : false,
                functional: document.getElementById('consent-functional') ? document.getElementById('consent-functional').checked : false,
                marketing: document.getElementById('consent-marketing') ? document.getElementById('consent-marketing').checked : false
            };
            this.saveConsent(choices, 'customize');
        }

        saveConsent(choices, action) {
            const data = {
                choices,
                action,
                policyVersion: this.policyVersion,
                date: new Date().toISOString()
            };

            try {
                localStorage.setItem(this.consentKey, JSON.stringify(data));
            } catch (e) {
                // Fallback si localStorage no disponible
            }

            // Audit trail — beacon AJAX al backend (immutable log)
            this.sendAuditTrail(data);

            this.applyConsent(choices);
            this.hideBanner();
            this.hideSettings();
        }

        sendAuditTrail(data) {
            const payload = {
                choices: data.choices,
                action: data.action,
                policyVersion: data.policyVersion,
                date: data.date,
                url: window.location.href,
                timestamp: new Date().toISOString()
            };

            if (navigator.sendBeacon) {
                const blob = new Blob([JSON.stringify(payload)], { type: 'application/json' });
                navigator.sendBeacon('/api/log-consent.php', blob);
            } else {
                fetch('/api/log-consent.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': window.csrfToken || ''
                    },
                    body: JSON.stringify(payload),
                    keepalive: true
                }).catch(function() {});
            }
        }

        applyConsent(choices) {
            // Necesarias: siempre activas (sesión, seguridad, idioma)

            // Analíticas: GA4 con Consent Mode v2
            if (choices.analytics) {
                this.loadAnalytics();
            } else {
                // Denegar por defecto (Consent Mode v2 default)
                this.setConsentModeDefault();
            }

            // Funcionales: WhatsApp widget, mapas, etc.
            if (choices.functional) {
                this.loadFunctionalScripts();
            }

            // Marketing: reservado para futuras campañas
            if (choices.marketing) {
                // Placeholder para scripts de marketing
            }
        }

        setConsentModeDefault() {
            window.dataLayer = window.dataLayer || [];
            window.gtag = function() { dataLayer.push(arguments); };
            gtag('consent', 'default', {
                'ad_storage': 'denied',
                'analytics_storage': 'denied',
                'ad_user_data': 'denied',
                'ad_personalization': 'denied'
            });
        }

        loadAnalytics() {
            window.dataLayer = window.dataLayer || [];
            window.gtag = function() { dataLayer.push(arguments); };
            gtag('js', new Date());
            gtag('config', 'GA_MEASUREMENT_ID'); // Reemplazar con ID real
            gtag('consent', 'update', {
                'analytics_storage': 'granted'
            });

            const script = document.createElement('script');
            script.src = 'https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID';
            script.async = true;
            document.head.appendChild(script);
        }

        loadFunctionalScripts() {
            // Cargar scripts funcionales solo tras consentimiento
            // Ejemplo: widget de mapas, funcionalidades extra
        }
    }

    window.cookieConsent = new CookieConsent();
    });
})();
