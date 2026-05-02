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
            const honeypot = form.querySelector('.form-honeypot');
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
            const data = {};
            formData.forEach(function(value, key) {
                data[key] = value;
            });

            fetch(form.action || '/api/contact-form.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': window.csrfToken || ''
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
                    showFormMessage(form, 'success', result.message || 'Mensaje enviado correctamente.');
                } else {
                    showFormMessage(form, 'error', result.message || 'Ha ocurrido un error. Inténtalo de nuevo.');
                }
            })
            .catch(function() {
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
        msgEl.style.background = type === 'success' ? '#c6f6d5' : '#fed7d7';
        msgEl.style.color = type === 'success' ? '#22543d' : '#742a2a';
        msgEl.hidden = false;

        if (type === 'success') {
            setTimeout(function() {
                msgEl.hidden = true;
            }, 5000);
        }
    }
    });
})();
