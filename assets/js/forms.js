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
                // Bot detectado — rechazar silenciosamente
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
                const phoneRegex = /^[\+]?[\d\s\-\(\)]{9,20}$/;
                if (!phoneRegex.test(phoneField.value)) {
                    phoneField.setCustomValidity('Por favor, introduce un teléfono válido.');
                    phoneField.reportValidity();
                    return;
                } else {
                    phoneField.setCustomValidity('');
                }
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Enviando...';
            }

            const formData = new FormData(form);
            if (!formData.get('csrf_token') && window.santafeConfig && window.santafeConfig.csrfToken) {
                formData.set('csrf_token', window.santafeConfig.csrfToken);
            }
            const data = {};
            formData.forEach(function(value, key) {
                data[key] = value;
            });

            fetch(form.action || (window.santafeConfig && window.santafeConfig.ajaxUrl) || '/wp-admin/admin-post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': (window.santafeConfig && window.santafeConfig.csrfToken) || window.csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(function(response) {
                if (!response.ok) throw new Error('Error en el envío');
                return response.json();
            })
            .then(function(result) {
                if (result.success) {
                    form.reset();
                    trackEvent('form_submit');
                    showFormMessage(form, 'success', result.message || 'Mensaje enviado correctamente.');
                } else {
                    trackEvent('form_error');
                    showFormMessage(form, 'error', result.message || 'Ha ocurrido un error. Inténtalo de nuevo.');
                }
            })
            .catch(function() {
                trackEvent('form_error');
                showFormMessage(form, 'error', 'Error de conexión. Por favor, inténtalo más tarde.');
            })
            .finally(function() {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
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
