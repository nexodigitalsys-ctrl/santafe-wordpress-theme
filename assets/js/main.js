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
window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

// Cargar traducciones para JS si es necesario (async)
// Las traducciones principales se renderizan server-side en PHP
