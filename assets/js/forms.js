/**
 * Forms.js — Validación frontend + envío AJAX con CSRF
 * Validación nativa + custom para mejor UX
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
    const forms = document.querySelectorAll('form[data-ajax]');

    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Honeypot check
            const honeypot = form.querySelector('input[name="website"]');
            if (honeypot && honeypot.value !== '') {
                return;
            }

            // Validación nativa HTML5
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Validación custom adicional
            const emailField = form.querySelector('input[type="email"]');
            if (emailField) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    emailField.setCustomValidity('Por favor, introduce un email válido.');
                    emailField.reportValidity();
                    return;
                } else {
                    emailField.setCustomValidity('');
                }
            }

            const phoneField = form.querySelector('input[type="tel"]');
            if (phoneField && phoneField.value) {
                const phoneRegex = /^[\d]{9,20}$/;
                if (!phoneRegex.test(phoneField.value)) {
                    phoneField.setCustomValidity('Por favor, introduce un teléfono válido.');
                    phoneField.reportValidity();
                    return;
                } else {
                    phoneField.setCustomValidity('');
                }
            }

            // reCAPTCHA v3 — invisible
            const recaptchaField = form.querySelector('input[name="g-recaptcha-response"]');
            const executeRecaptcha = recaptchaField && typeof grecaptcha !== 'undefined' && grecaptcha.execute
                ? Promise.race([
                    grecaptcha.execute(window.santafeConfig.recaptchaSiteKey || '', { action: 'submit' }).then(function(token) {
                      recaptchaField.value = token;
                    }),
                    new Promise(function(resolve) { setTimeout(resolve, 8000); })
                  ]).catch(function() {})
                : Promise.resolve();

            executeRecaptcha.then(function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Enviando...';
            }

            const formData = new FormData(form);
            formData.set('action', 'santafe_contact_form');
            const csrf = (window.santafeConfig && window.santafeConfig.csrfToken) || window.csrfToken || '';
            formData.set('csrf_token', csrf);

            var fetchUrl = form.getAttribute('action') || (window.santafeConfig && window.santafeConfig.ajaxUrl) || '/wp-admin/admin-post.php';
            fetch(fetchUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(function(response) {
                return response.text().then(function(text) {
                    var result;
                    try {
                        result = JSON.parse(text);
                    } catch(e) {
                        showFormMessage(form, 'error', 'Error del servidor. Recarga la página e inténtalo de nuevo.');
                        return;
                    }
                    if (result.success) {
                        form.reset();
                        trackEvent('form_submit');
                        showFormMessage(form, 'success', result.message || 'Mensaje enviado correctamente.');
                    } else {
                        trackEvent('form_error');
                        showFormMessage(form, 'error', result.message || 'Ha ocurrido un error. Inténtalo de nuevo.');
                    }
                });
            })
            .catch(function(err) {
                trackEvent('form_error');
                showFormMessage(form, 'error', err.message || 'Error de conexión. Por favor, inténtalo más tarde.');
            })
            .finally(function() {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
            });
        });
    });

    function showFormMessage(form, type, message) {
        let msgEl = form.querySelector('.form-message');
        if (!msgEl) {
            msgEl = document.createElement('div');
            msgEl.className = 'form-message';
            msgEl.setAttribute('role', 'alert');
            msgEl.style.marginTop = '1rem';
            msgEl.style.padding = '0.75rem 1rem';
            msgEl.style.borderRadius = '4px';
            msgEl.style.fontWeight = '500';
            form.appendChild(msgEl);
        }
        msgEl.textContent = message;
        msgEl.style.background = type === 'success' ? '#111111' : '#161616';
        msgEl.style.border = type === 'success' ? '1px solid #22C55E' : '1px solid #EF4444';
        msgEl.style.color = type === 'success' ? '#FFFFFF' : '#FFFFFF';
        msgEl.hidden = false;

        if (type === 'success') {
            setTimeout(function() {
                msgEl.hidden = true;
            }, 5000);
        }
    }

    function trackEvent(name, params) {
        if (typeof window.gtag === 'function') {
            window.gtag('event', name, params || {});
        }
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(Object.assign({ event: name }, params || {}));
    }

    document.addEventListener('click', function(event) {
        const target = event.target.closest('[data-track-event]');
        if (!target) return;
        trackEvent(target.getAttribute('data-track-event'));
    });
    });
})();