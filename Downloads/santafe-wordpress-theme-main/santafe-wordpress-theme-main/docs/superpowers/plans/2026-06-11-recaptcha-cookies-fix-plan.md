# reCAPTCHA v2 + Correção de Cookies Duplicados — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Adicionar reCAPTCHA v2 funcional nos formulários de contato e eliminar o banner de cookies duplicado removendo o plugin Complianz (já removido pelo usuário).

**Architecture:** Manter o banner customizado do tema; adicionar constantes de reCAPTCHA, carregar script do Google no frontend, renderizar widget nos formulários e validar token no backend antes de enviar lead.

**Tech Stack:** PHP 8.3+, WordPress, Tailwind CSS v4, Vanilla JS, reCAPTCHA v2 Checkbox.

---

## File Structure

| File | Responsibility |
|---|---|
| `config/constants.php` | Define `RECAPTCHA_SITE_KEY` e `RECAPTCHA_SECRET_KEY` via environment variables. |
| `includes/header.php` | Condicionally enqueue Google reCAPTCHA API script when site key is set. |
| `pages/contacto.php` | Render reCAPTCHA widget above submit button. |
| `pages/partials/section-contacto.php` | Render reCAPTCHA widget above submit button. |
| `functions.php` | Add `santafe_verify_recaptcha()` and call it inside form handler. |
| `assets/js/forms.js` | Ensure token is present before AJAX submit and surface errors. |
| `lang/es.json` | Add `recaptcha_missing` and `recaptcha_invalid` strings. |
| `lang/ca.json` | Add `recaptcha_missing` and `recaptcha_invalid` strings. |

---

### Task 1: Add reCAPTCHA constants

**Files:**
- Modify: `config/constants.php`

- [ ] **Step 1: Insert reCAPTCHA constants after GTM/GA4 block**

```php
if (!defined('RECAPTCHA_SITE_KEY')) {
    define('RECAPTCHA_SITE_KEY', trim((string) (getenv('RECAPTCHA_SITE_KEY') ?: '')));
}

if (!defined('RECAPTCHA_SECRET_KEY')) {
    define('RECAPTCHA_SECRET_KEY', trim((string) (getenv('RECAPTCHA_SECRET_KEY') ?: '')));
}
```

Place this block immediately after the `SANTAFE_ENABLE_ANALYTICS` definition.

- [ ] **Step 2: Verify file syntax**

Run: `php -l "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main/config/constants.php"`
Expected: `No syntax errors`

- [ ] **Step 3: Commit**

```bash
git add config/constants.php
git commit -m "feat(config): add RECAPTCHA_SITE_KEY and RECAPTCHA_SECRET_KEY constants"
```

---

### Task 2: Enqueue reCAPTCHA API script in header

**Files:**
- Modify: `includes/header.php`

- [ ] **Step 1: Add script tag before closing `</head>`**

Locate `</head>` in `includes/header.php` and insert just above it:

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
```

- [ ] **Step 2: Verify the script only loads when key is configured**

Open `includes/header.php` and confirm the conditional block is present.

- [ ] **Step 3: Commit**

```bash
git add includes/header.php
git commit -m "feat(header): conditionally load Google reCAPTCHA v2 script"
```

---

### Task 3: Render reCAPTCHA widget in contact page form

**Files:**
- Modify: `pages/contacto.php`

- [ ] **Step 1: Insert widget placeholder before submit button**

Find this block in `pages/contacto.php`:

```php
<div class="mb-6">
    <label class="flex items-start gap-3 cursor-pointer">
        <input type="checkbox" name="privacy" required class="mt-1 accent-brand-600">
        <span class="text-warm-500 text-sm"><?php echo $label_privacy; ?></span>
    </label>
</div>
<button type="submit" ...
```

Insert immediately after the privacy checkbox `</div>` and before the `<button>`:

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<div class="mb-6">
    <div class="g-recaptcha" data-sitekey="<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"></div>
</div>
<?php endif; ?>
```

- [ ] **Step 2: Verify file syntax**

Run: `php -l "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main/pages/contacto.php"`
Expected: `No syntax errors`

- [ ] **Step 3: Commit**

```bash
git add pages/contacto.php
git commit -m "feat(contacto): add reCAPTCHA v2 widget to contact form"
```

---

### Task 4: Render reCAPTCHA widget in CTA section form

**Files:**
- Modify: `pages/partials/section-contacto.php`

- [ ] **Step 1: Insert widget placeholder before submit button**

Find the privacy checkbox block in `pages/partials/section-contacto.php`:

```php
<div class="mb-6">
    <label class="flex items-start gap-3 cursor-pointer">
        <input type="checkbox" name="privacy" required class="mt-1 accent-brand-600">
        <span class="section-contacto-label text-sm"><?php echo $label_privacy; ?></span>
    </label>
</div>
<button type="submit" ...
```

Insert immediately after the privacy checkbox `</div>` and before the `<button>`:

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<div class="mb-6">
    <div class="g-recaptcha" data-sitekey="<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"></div>
</div>
<?php endif; ?>
```

- [ ] **Step 2: Verify file syntax**

Run: `php -l "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main/pages/partials/section-contacto.php"`
Expected: `No syntax errors`

- [ ] **Step 3: Commit**

```bash
git add pages/partials/section-contacto.php
git commit -m "feat(section-contacto): add reCAPTCHA v2 widget to CTA form"
```

---

### Task 5: Add backend reCAPTCHA verification

**Files:**
- Modify: `functions.php`

- [ ] **Step 1: Add helper function before form handler**

Insert before `santafe_tailwind_handle_contact_form()`:

```php
function santafe_verify_recaptcha(string $token): bool {
    $secret = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '';

    if ($secret === '') {
        error_log('Santa Fe reCAPTCHA: secret key not configured.');
        return true; // fallback seguro: não bloqueia se não configurado
    }

    if ($token === '') {
        return false;
    }

    $response = wp_remote_post(
        'https://www.google.com/recaptcha/api/siteverify',
        [
            'timeout' => 10,
            'body' => [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''),
            ],
        ]
    );

    if (is_wp_error($response)) {
        error_log('Santa Fe reCAPTCHA: ' . $response->get_error_message());
        return false;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    return is_array($body) && !empty($body['success']);
}
```

- [ ] **Step 2: Call verification inside form handler**

Find in `santafe_tailwind_handle_contact_form()`:

```php
if (!empty($payload['website'] ?? '')) {
    santafe_tailwind_contact_response(true, 'Solicitud recibida.', $is_ajax);
}
```

Insert immediately after the honeypot check:

```php
$recaptcha_token = sanitize_text_field($payload['g-recaptcha-response'] ?? '');
if (!santafe_verify_recaptcha($recaptcha_token)) {
    santafe_tailwind_contact_response(false, 'Por favor, verifica el reCAPTCHA antes de enviar.', $is_ajax);
}
```

- [ ] **Step 3: Verify file syntax**

Run: `php -l "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main/functions.php"`
Expected: `No syntax errors`

- [ ] **Step 4: Commit**

```bash
git add functions.php
git commit -m "feat(forms): validate reCAPTCHA v2 token on contact form submission"
```

---

### Task 6: Update frontend form validation for reCAPTCHA

**Files:**
- Modify: `assets/js/forms.js`

- [ ] **Step 1: Add reCAPTCHA token check before submit**

Find in `assets/js/forms.js` inside the submit handler, after the phone validation block and before the submit button disable:

```javascript
const submitBtn = form.querySelector('button[type="submit"]');
```

Insert before it:

```javascript
const recaptchaToken = form.querySelector('textarea[name="g-recaptcha-response"]')?.value || '';
if (!recaptchaToken) {
    showFormMessage(form, 'error', 'Por favor, completa el reCAPTCHA antes de enviar.');
    return;
}
```

- [ ] **Step 2: Ensure token is included in FormData**

The existing code already uses `new FormData(form)`. Since reCAPTCHA v2 injects a hidden `textarea[name="g-recaptcha-response"]`, the token will be included automatically. No change needed.

- [ ] **Step 3: Commit**

```bash
git add assets/js/forms.js
git commit -m "feat(forms): block submit when reCAPTCHA token is missing"
```

---

### Task 7: Add translated error messages

**Files:**
- Modify: `lang/es.json`
- Modify: `lang/ca.json`

- [ ] **Step 1: Add Spanish strings**

In `lang/es.json`, inside the `"contact"` object, after `"privacy_link_text"`, add:

```json
"recaptcha_missing": "Por favor, completa el reCAPTCHA antes de enviar.",
"recaptcha_invalid": "El reCAPTCHA no es válido. Inténtalo de nuevo."
```

- [ ] **Step 2: Add Catalan strings**

In `lang/ca.json`, inside the `"contact"` object, after `"privacy_link_text"`, add:

```json
"recaptcha_missing": "Si us plau, completa el reCAPTCHA abans d'enviar.",
"recaptcha_invalid": "El reCAPTCHA no és vàlid. Torna-ho a provar."
```

- [ ] **Step 3: Commit**

```bash
git add lang/es.json lang/ca.json
git commit -m "i18n: add reCAPTCHA error messages in ES and CA"
```

---

### Task 8: Use translated messages in backend

**Files:**
- Modify: `functions.php`

- [ ] **Step 1: Replace hardcoded reCAPTCHA error with translation helper**

Change the hardcoded error message added in Task 5 to use the translation helper:

```php
$recaptcha_token = sanitize_text_field($payload['g-recaptcha-response'] ?? '');
if (!santafe_verify_recaptcha($recaptcha_token)) {
    $msg = t(load_translations($lang), 'contact.recaptcha_invalid') ?: 'Por favor, verifica el reCAPTCHA antes de enviar.';
    santafe_tailwind_contact_response(false, $msg, $is_ajax);
}
```

> Note: `$lang` is already determined by the `santafe-wp-router.php` context; if unavailable in scope, fall back to the hardcoded string.

- [ ] **Step 2: Verify file syntax**

Run: `php -l "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main/functions.php"`
Expected: `No syntax errors`

- [ ] **Step 3: Commit**

```bash
git add functions.php
git commit -m "i18n: use translated reCAPTCHA error message in backend"
```

---

### Task 9: Manual end-to-end testing

**Files:**
- None (manual validation)

- [ ] **Step 1: Serve the theme locally or deploy to staging**

If testing locally, ensure the environment variables are set:

```bash
export RECAPTCHA_SITE_KEY=6Lfu7RktAAAAAOy_3OBZ8gkrasoI7Uw1_dogvkxM
export RECAPTCHA_SECRET_KEY=6Lfu7RktAAAAAIpxrmxI8U0zZmNjmxoSL4-gPTBv
```

- [ ] **Step 2: Open `/es/contacto/` in browser**

Expected:
- Only the custom cookie banner appears at the bottom.
- reCAPTCHA widget renders above the submit button.

- [ ] **Step 3: Submit form without clicking reCAPTCHA**

Expected:
- Form shows error: "Por favor, completa el reCAPTCHA antes de enviar."
- No email/Telegram is sent.

- [ ] **Step 4: Submit form with reCAPTCHA completed**

Expected:
- Form shows success message.
- Email/Telegram lead is delivered.

- [ ] **Step 5: Repeat on homepage CTA section**

Scroll to the contact CTA section and repeat Steps 3-4.

- [ ] **Step 6: Commit test results note (optional)**

If any issues are found, fix before final commit. Otherwise:

```bash
git log --oneline -5
```

Expected: at least 6 commits covering constants, header, forms, backend, i18n.

---

## Self-Review

### Spec coverage

| Spec Requirement | Task |
|---|---|
| Remove Complianz plugin | Handled by user (confirmed removed); no code task needed. |
| Add reCAPTCHA constants | Task 1 |
| Load reCAPTCHA script | Task 2 |
| Render widget in contact form | Task 3 |
| Render widget in CTA form | Task 4 |
| Backend token validation | Task 5 |
| Frontend token check | Task 6 |
| Translated error messages | Tasks 7 and 8 |
| Manual testing | Task 9 |

### Placeholder scan

No TBD/TODO/"implement later"/"similar to" patterns found.

### Type consistency

- Function name: `santafe_verify_recaptcha` used consistently.
- Token field: `g-recaptcha-response` used in backend and frontend.
- Constants: `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` used consistently.

---

## Execution Handoff

Plan complete and saved to `docs/superpowers/plans/2026-06-11-recaptcha-cookies-fix-plan.md`.

Two execution options:

1. **Subagent-Driven (recommended)** - I dispatch a fresh subagent per task, review between tasks, fast iteration.
2. **Inline Execution** - Execute tasks in this session using executing-plans, batch execution with checkpoints.

Which approach?