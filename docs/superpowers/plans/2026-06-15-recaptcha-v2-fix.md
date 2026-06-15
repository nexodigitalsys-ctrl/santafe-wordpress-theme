# Correção do reCAPTCHA v2 Checkbox — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Corrigir a implementação híbrida/quebrada de reCAPTCHA no tema WordPress Santa Fe, tornando o reCAPTCHA v2 Checkbox funcional nos formulários de contato.

**Architecture:** Carregar o script oficial do Google reCAPTCHA v2 no header, renderizar o widget checkbox explicitamente nos formulários, validar o token no frontend antes do envio AJAX e verificar o token no backend via `siteverify`. Remover fallback inseguro e notificações Telegram do fluxo de contato.

**Tech Stack:** PHP 8.3, WordPress, Tailwind CSS, Vanilla JS, Google reCAPTCHA v2.

---

## File Structure

| File | Responsibility |
|---|---|
| `includes/header.php` | Carregar o script `api.js` do reCAPTCHA v2 quando a site key estiver configurada. |
| `pages/contacto.php` | Renderizar widget v2 no formulário da página de contato. |
| `pages/partials/section-contacto.php` | Renderizar widget v2 no formulário CTA final. |
| `assets/js/forms.js` | Validar token do reCAPTCHA v2 no submit; expor callbacks globais. |
| `functions.php` | Validar token no backend; remover fallback inseguro; remover chamada Telegram. |
| `lang/es.json` | Confirmar traduções de erro do reCAPTCHA. |
| `lang/ca.json` | Confirmar traduções de erro do reCAPTCHA. |

---

## Task 1: Carregar script do reCAPTCHA v2 no header

**Files:**
- Modify: `includes/header.php`

- [ ] **Step 1: Abrir `includes/header.php` e localizar o fechamento do `</head>`**

- [ ] **Step 2: Adicionar o script do reCAPTCHA v2 antes de `</head>`**

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<script src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>
<?php endif; ?>
```

Inserir logo antes de:
```html
</head>
```

- [ ] **Step 3: Salvar o arquivo**

- [ ] **Step 4: Commit**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
git add includes/header.php
git commit -m "feat(recaptcha): carrega script reCAPTCHA v2 no header"
```

---

## Task 2: Adicionar widget reCAPTCHA v2 na página de contato

**Files:**
- Modify: `pages/contacto.php`

- [ ] **Step 1: Localizar o bloco reCAPTCHA atual em `pages/contacto.php`**

O trecho a ser substituído está próximo da linha 139:
```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<div class="mb-6">
    <input type="hidden" name="g-recaptcha-response" value="">
</div>
<?php endif; ?>
```

- [ ] **Step 2: Substituir pelo widget reCAPTCHA v2 checkbox**

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<div class="mb-6">
    <div class="g-recaptcha"
         data-sitekey="<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"
         data-callback="santafeRecaptchaVerified"
         data-expired-callback="santafeRecaptchaExpired"></div>
    <input type="hidden" name="g-recaptcha-response" value="">
</div>
<?php endif; ?>
```

- [ ] **Step 3: Salvar o arquivo**

- [ ] **Step 4: Commit**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
git add pages/contacto.php
git commit -m "feat(recaptcha): adiciona widget reCAPTCHA v2 na pagina de contato"
```

---

## Task 3: Adicionar widget reCAPTCHA v2 no CTA final

**Files:**
- Modify: `pages/partials/section-contacto.php`

- [ ] **Step 1: Localizar o bloco reCAPTCHA atual em `pages/partials/section-contacto.php`**

O trecho a ser substituído está próximo da linha 134:
```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<div class="mb-6">
    <input type="hidden" name="g-recaptcha-response" value="">
</div>
<?php endif; ?>
```

- [ ] **Step 2: Substituir pelo widget reCAPTCHA v2 checkbox**

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<div class="mb-6">
    <div class="g-recaptcha"
         data-sitekey="<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"
         data-callback="santafeRecaptchaVerified"
         data-expired-callback="santafeRecaptchaExpired"></div>
    <input type="hidden" name="g-recaptcha-response" value="">
</div>
<?php endif; ?>
```

- [ ] **Step 3: Salvar o arquivo**

- [ ] **Step 4: Commit**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
git add pages/partials/section-contacto.php
git commit -m "feat(recaptcha): adiciona widget reCAPTCHA v2 no CTA final"
```

---

## Task 4: Refatorar `forms.js` para validar reCAPTCHA v2

**Files:**
- Modify: `assets/js/forms.js`

- [ ] **Step 1: Abrir `assets/js/forms.js`**

- [ ] **Step 2: Substituir toda a lógica de reCAPTCHA atual**

Localizar o trecho (aproximadamente linhas 59-79):
```javascript
const recaptchaField = form.querySelector('input[name="g-recaptcha-response"]');
const executeRecaptcha = recaptchaField && typeof grecaptcha !== 'undefined' && grecaptcha.execute
    ? new Promise(function(resolve) {
        var timeout = setTimeout(function() { resolve(); }, 3000);
        try {
          grecaptcha.ready(function() {
            grecaptcha.execute(window.santafeConfig.recaptchaSiteKey || '', { action: 'submit' }).then(function(token) {
              recaptchaField.value = token;
              clearTimeout(timeout);
              resolve();
            }).catch(function() {
              clearTimeout(timeout);
              resolve();
            });
          });
        } catch(e) {
          clearTimeout(timeout);
          resolve();
        }
      })
    : Promise.resolve();
```

Substituir por:
```javascript
const recaptchaWidget = form.querySelector('.g-recaptcha');
const recaptchaField = form.querySelector('input[name="g-recaptcha-response"]');

function validateRecaptcha() {
    if (!recaptchaWidget) {
        return true; // Formulário sem reCAPTCHA
    }
    if (!recaptchaField || recaptchaField.value === '') {
        var lang = (window.santafeConfig && window.santafeConfig.lang) || 'es';
        var msg = lang === 'ca'
            ? 'Si us plau, completa el reCAPTCHA abans d\'enviar.'
            : 'Por favor, completa el reCAPTCHA antes de enviar.';
        showFormMessage(form, 'error', msg);
        return false;
    }
    return true;
}
```

- [ ] **Step 3: Adicionar callbacks globais do reCAPTCHA no escopo do IIFE**

Adicionar imediatamente após a função `domReady` (dentro do IIFE, antes do listener de submit):

```javascript
window.santafeRecaptchaVerified = function(token) {
    document.querySelectorAll('input[name="g-recaptcha-response"]').forEach(function(field) {
        field.value = token;
    });
};

window.santafeRecaptchaExpired = function() {
    document.querySelectorAll('input[name="g-recaptcha-response"]').forEach(function(field) {
        field.value = '';
    });
};
```

- [ ] **Step 4: Inserir chamada `validateRecaptcha()` no handler de submit**

Localizar o início do listener:
```javascript
form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Honeypot check
    ...
```

Adicionar após a validação custom do telefone e antes de `executeRecaptcha.then`:

```javascript
if (!validateRecaptcha()) {
    return;
}
```

- [ ] **Step 5: Remover o wrapper `executeRecaptcha.then`**

O código atual está assim:
```javascript
executeRecaptcha.then(function() {
    // ... todo o envio AJAX ...
});
```

Remover o `executeRecaptcha.then(function() {` no início e o `});` correspondente no final do listener. O envio AJAX deve ficar diretamente no fluxo do submit.

- [ ] **Step 6: Salvar o arquivo**

O arquivo final deve ter a seguinte estrutura no listener de submit:

```javascript
form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Honeypot check
    const honeypot = form.querySelector('input[name="website"]');
    if (honeypot && honeypot.value !== '') {
        return;
    }

    // Validação nativa HTML5
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Validação custom adicional
    ...email...
    ...phone...

    // Validação reCAPTCHA v2
    if (!validateRecaptcha()) {
        return;
    }

    // Envio AJAX
    const submitBtn = form.querySelector('button[type="submit"]');
    ...
});
```

- [ ] **Step 7: Commit**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
git add assets/js/forms.js
git commit -m "feat(recaptcha): refatora forms.js para validar reCAPTCHA v2 checkbox"
```

---

## Task 5: Ajustar backend em `functions.php`

**Files:**
- Modify: `functions.php`

- [ ] **Step 1: Remover fallback inseguro em `santafe_verify_recaptcha`**

Localizar (aproximadamente linhas 226-232):
```php
function santafe_verify_recaptcha(string $token): array {
    $secret = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '';

    if ($secret === '') {
        error_log('Santa Fe reCAPTCHA: secret key not configured.');
        return ['success' => true, 'error' => '']; // fallback seguro
    }
```

Substituir por:
```php
function santafe_verify_recaptcha(string $token): array {
    $secret = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '';

    if ($secret === '') {
        error_log('Santa Fe reCAPTCHA: secret key not configured.');
        return ['success' => false, 'error' => 'secret_not_configured'];
    }
```

- [ ] **Step 2: Adicionar tradução para erro `secret_not_configured` no handler**

Localizar no handler `santafe_tailwind_handle_contact_form` (aproximadamente linhas 311-322):
```php
if ($error_code === 'http_error') {
    $msg = 'Error de conexión con el servicio de verificación. Inténtalo más tarde.';
} elseif ($error_code === 'token_vacio') {
    ...
} elseif ($error_code === 'timeout-or-duplicate') {
    ...
} else {
    ...
}
```

Adicionar após `timeout-or-duplicate`:
```php
} elseif ($error_code === 'secret_not_configured') {
    $msg = 'Error de configuración de seguridad. Contacta con el administrador.';
```

- [ ] **Step 3: Remover chamada ao Telegram no handler de contato**

Localizar (aproximadamente linhas 356-369):
```php
$telegram = santafe_send_to_telegram($lead);
$email_sent = santafe_send_contact_email($lead, $attachments);

if (!$telegram['success'] && !$email_sent) {
    error_log('Santa Fe lead delivery failed. Telegram: ' . ($telegram['error'] ?? 'unknown') . ' Email: failed');
    santafe_tailwind_contact_response(false, 'No hemos podido enviar el mensaje. Llámanos o escríbenos por WhatsApp.', $is_ajax);
    return;
}
```

Substituir por:
```php
$email_sent = santafe_send_contact_email($lead, $attachments);

if (!$email_sent) {
    error_log('Santa Fe lead delivery failed. Email: failed');
    santafe_tailwind_contact_response(false, 'No hemos podido enviar el mensaje. Llámanos o escríbenos por WhatsApp.', $is_ajax);
    return;
}
```

- [ ] **Step 4: Salvar o arquivo**

- [ ] **Step 5: Commit**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
git add functions.php
git commit -m "feat(recaptcha): remove fallback inseguro e notificacoes Telegram do contato"
```

---

## Task 6: Verificar traduções de erro do reCAPTCHA

**Files:**
- Read: `lang/es.json`
- Read: `lang/ca.json`

- [ ] **Step 1: Abrir `lang/es.json` e confirmar as chaves abaixo**

```json
"recaptcha_missing": "Por favor, completa el reCAPTCHA antes de enviar.",
"recaptcha_invalid": "El reCAPTCHA no es válido. Inténtalo de nuevo."
```

- [ ] **Step 2: Abrir `lang/ca.json` e confirmar as chaves abaixo**

```json
"recaptcha_missing": "Si us plau, completa el reCAPTCHA abans d'enviar.",
"recaptcha_invalid": "El reCAPTCHA no és vàlid. Torna-ho a provar."
```

- [ ] **Step 3: Se alguma chave estiver faltando, adicionar. Se ambas existirem, nenhuma alteração é necessária.**

- [ ] **Step 4: Commit (somente se houver alteração)**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
git add lang/es.json lang/ca.json
git commit -m "feat(recaptcha): garante traducoes de erro do reCAPTCHA"
```

---

## Task 7: Testar localmente

**Files:**
- Test: formulários em `http://127.0.0.1:8765/es/contacto/`

- [ ] **Step 1: Iniciar o servidor local**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
php -S 127.0.0.1:8765 .local-preview-router.php
```

- [ ] **Step 2: Abrir a página de contato em espanhol**

Acesse: `http://127.0.0.1:8765/es/contacto/`

- [ ] **Step 3: Verificar se o widget reCAPTCHA v2 aparece**

Esperado: checkbox "No soy un robot" visível acima do botão de envio.

- [ ] **Step 4: Testar envio sem marcar o checkbox**

Esperado: mensagem de erro "Por favor, completa el reCAPTCHA antes de enviar." e formulário não enviado.

- [ ] **Step 5: Marcar o checkbox e enviar com dados válidos**

Esperado: mensagem de sucesso.

- [ ] **Step 6: Testar o formulário CTA final na home**

Acesse: `http://127.0.0.1:8765/es/`

Rolar até a seção de contato e repetir os passos 4 e 5.

- [ ] **Step 7: Testar versão em catalão**

Acesse: `http://127.0.0.1:8765/ca/contacte/`

Esperado: mensagens de erro em catalão.

- [ ] **Step 8: Testar honeypot**

Via DevTools, preencher o campo `website` e tentar enviar.

Esperado: sucesso falso (bloqueio silencioso).

- [ ] **Step 9: Parar o servidor local**

Pressione `Ctrl+C` no terminal onde o servidor está rodando.

- [ ] **Step 10: Commit final com todos os testes realizados**

```bash
cd /home/jhin/Downloads/santafe-wordpress-theme-master/Downloads/santafe-wordpress-theme-main/santafe-wordpress-theme-main
git add -A
git commit -m "test(recaptcha): valida reCAPTCHA v2 localmente" || echo "Nada para commitar"
```

---

## Self-Review Checklist

- [ ] **Spec coverage:** Cada requisito do spec (`docs/superpowers/specs/2026-06-15-recaptcha-v2-fix-design.md`) está mapeado para uma task.
  - Carregar script v2 → Task 1
  - Widget v2 nos formulários → Tasks 2 e 3
  - Validação frontend → Task 4
  - Validação backend + remover Telegram → Task 5
  - Traduções → Task 6
  - Testes → Task 7
- [ ] **Placeholder scan:** Nenhum "TBD", "TODO" ou "implement later" no plano.
- [ ] **Type consistency:** Nomes de funções (`santafeRecaptchaVerified`, `santafeRecaptchaExpired`, `validateRecaptcha`) consistentes entre tasks.
- [ ] **Caminhos absolutos:** Todos os comandos usam o caminho correto do projeto.

---

## Execution Handoff

**Plan complete and saved to `docs/superpowers/plans/2026-06-15-recaptcha-v2-fix.md`. Two execution options:**

**1. Subagent-Driven (recommended)** - I dispatch a fresh subagent per task, review between tasks, fast iteration

**2. Inline Execution** - Execute tasks in this session using executing-plans, batch execution with checkpoints

**Which approach?**
