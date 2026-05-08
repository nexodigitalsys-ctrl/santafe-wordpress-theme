/**
 * Main.js — Inicializador principal
 * Carga de traducciones para JS, csrf token global
 */

// Helper _t para traducciones desde JS (si se cargan dinámicamente)
window._t = function(key, replacements) {
    if (!window._translations) return key;
    var parts = key.split('.');
    var value = window._translations;
    for (var i = 0; i < parts.length; i++) {
        if (value && typeof value === 'object' && parts[i] in value) {
            value = value[parts[i]];
        } else {
            return key;
        }
    }
    if (typeof value === 'string' && replacements) {
        for (var search in replacements) {
            if (replacements.hasOwnProperty(search)) {
                value = value.replace('{' + search + '}', replacements[search]);
            }
        }
    }
    return typeof value === 'string' ? value : key;
};

// CSRF token global para AJAX
window.csrfToken = (window.santafeConfig && window.santafeConfig.csrfToken) || '';

// Cargar traducciones para JS si es necesario (async)
// Las traducciones principales se renderizan server-side en PHP

document.addEventListener('DOMContentLoaded', function() {
    const calculator = document.querySelector('[data-budget-calculator]');
    if (!calculator) return;

    const service = calculator.querySelector('[data-calc-service]');
    const m2 = calculator.querySelector('[data-calc-m2]');
    const city = calculator.querySelector('[data-calc-city]');
    const finish = calculator.querySelector('[data-calc-finish]');
    const result = calculator.querySelector('[data-calc-result]');

    function formatEuro(value) {
        return new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'EUR',
            maximumFractionDigits: 0
        }).format(value);
    }

    function calculate() {
        const base = Number(service.value || 0);
        const meters = Math.max(1, Number(m2.value || 0));
        const cityFactor = Number(city.value || 1);
        const finishFactor = Number(finish.value || 1);
        const midpoint = base * meters * cityFactor * finishFactor;
        const low = Math.round(midpoint * 0.82 / 100) * 100;
        const high = Math.round(midpoint * 1.18 / 100) * 100;

        result.textContent = formatEuro(low) + ' - ' + formatEuro(high);

        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: 'calculator_use',
            calculator_service_rate: base,
            calculator_m2: meters
        });
        if (typeof window.gtag === 'function') {
            window.gtag('event', 'calculator_use', {
                service_rate: base,
                m2: meters
            });
        }
    }

    [service, m2, city, finish].forEach(function(field) {
        field.addEventListener('input', calculate);
        field.addEventListener('change', calculate);
    });
    calculate();
});
