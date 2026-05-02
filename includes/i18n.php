<?php
/**
 * Sistema de Internacionalización (i18n)
 * Carga traducciones desde JSON según parámetro ?lang=
 * Fallback: ES
 */

function load_translations($lang = 'es') {
    $allowed = ['es', 'ca'];
    if (!in_array($lang, $allowed, true)) {
        $lang = 'es';
    }

    $file = __DIR__ . '/../lang/' . $lang . '.json';
    if (!file_exists($file)) {
        $file = __DIR__ . '/../lang/es.json';
    }

    $json = file_get_contents($file);
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
        return [];
    }
    return $data;
}

function t($data, $key, $replacements = []) {
    $parts = explode('.', $key);
    $value = $data;
    foreach ($parts as $part) {
        if (isset($value[$part])) {
            $value = $value[$part];
        } else {
            return $key;
        }
    }
    if (is_string($value) && !empty($replacements)) {
        foreach ($replacements as $search => $replace) {
            $value = str_replace('{' . $search . '}', $replace, $value);
        }
    }
    return is_string($value) ? $value : $key;
}
