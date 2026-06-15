# Entrega — Correção do reCAPTCHA v2 Checkbox

**Data:** 15/06/2026  
**Projeto:** Tema WordPress Santa Fe Construcciones  
**Branch:** `main`  
**Responsável:** Kimi Code CLI

---

## 1. Problema identificado

A documentação interna (`RESUMO-ENTREGAS.md`) afirmava que o reCAPTCHA v2 Checkbox tinha sido entregue em 11/06, mas a inspeção do código revelou uma implementação híbrida/quebrada:

- O script do Google reCAPTCHA **não estava sendo carregado** no `header.php`.
- O JavaScript chamava `grecaptcha.execute()` (API do reCAPTCHA v3 / v2 Invisible), em vez de validar um checkbox v2.
- Os formulários não renderizavam o widget visível `<div class="g-recaptcha">`; só havia um `<input type="hidden">` inútil.
- Se o reCAPTCHA falhasse no navegador, o formulário ainda era enviado.
- O backend tinha um **fallback inseguro**: se a `RECAPTCHA_SECRET_KEY` estivesse vazia, ele aceitava o envio como válido.
- O fluxo de contato também enviava notificação para Telegram, o que não era mais desejado.

Resultado: o formulário de contato podia ser submetido sem qualquer proteção real anti-bot.

---

## 2. O que foi consertado

### 2.1 Carregamento do script reCAPTCHA v2
**Arquivo:** `includes/header.php`

Adicionado carregamento condicional do script oficial do Google reCAPTCHA v2 antes do fechamento do `</head>`, apenas quando `RECAPTCHA_SITE_KEY` está configurada:

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
```

### 2.2 Widget reCAPTCHA v2 visível nos formulários
**Arquivos:** `pages/contacto.php` e `pages/partials/section-contacto.php`

Substituído o `<input type="hidden" name="g-recaptcha-response">` pelo widget checkbox real:

```php
<div class="g-recaptcha"
     data-sitekey="<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"
     data-callback="santafeRecaptchaVerified"
     data-expired-callback="santafeRecaptchaExpired"></div>
```

Removido o input hidden conflitante, pois o próprio widget v2 injeta o campo `g-recaptcha-response`.

### 2.3 Validação frontend correta
**Arquivo:** `assets/js/forms.js`

- Removida a lógica de reCAPTCHA v3 (`grecaptcha.execute()`).
- Adicionada função `validateRecaptcha(form)` que exige o token do widget v2 antes do envio AJAX.
- Adicionados callbacks globais `santafeRecaptchaVerified` e `santafeRecaptchaExpired`.
- Botão de envio é **desabilitado por padrão** e só é habilitado quando o usuário marca o checkbox.
- Após envio bem-sucedido, o widget é resetado com `grecaptcha.reset()` para permitir novo envio.
- Mensagens de erro em espanhol/catalão conforme idioma da página.

### 2.4 Backend seguro
**Arquivo:** `functions.php`

- Removido o fallback inseguro que aceitava envio quando `RECAPTCHA_SECRET_KEY` estava vazia. Agora o envio é rejeitado com erro `secret_not_configured`.
- Mantida a validação via endpoint oficial `https://www.google.com/recaptcha/api/siteverify`.
- Mensagens de erro do backend traduzidas para catalão quando `$lang === 'ca'`.
- Corrigida a sobrescrita do objeto `window.santafeConfig`: o segundo `wp_localize_script` (para `santafe-main`) agora usa `santafeMainConfig`.
- Adicionado `lang` ao objeto `santafeConfig` do `santafe-forms`, permitindo mensagens localizadas no frontend.
- **Removido o envio para Telegram** do handler do formulário de contato. Agora o fluxo depende apenas do email (`wp_mail`). A função `santafe_send_to_telegram` permanece no código para uso futuro.

### 2.5 Traduções
**Arquivos:** `lang/es.json` e `lang/ca.json`

Confirmada a existência das chaves:
- `contact.recaptcha_missing`
- `contact.recaptcha_invalid`

Ambas já estavam presentes com textos corretos em espanhol e catalão.

---

## 3. Fluxo final do reCAPTCHA

1. Página carrega e o script do Google é inserido no `<head>`.
2. O widget "No soy un robot" aparece acima do botão de envio.
3. Botão de envio começa **desabilitado**.
4. Usuário preenche os campos e clica no checkbox.
5. Google valida e habilita o botão de envio.
6. Ao clicar em enviar, o JS valida honeypot, campos e token do reCAPTCHA.
7. AJAX envia os dados para `admin-post.php`.
8. Backend valida nonce, honeypot e token via Google.
9. Se tudo OK: envia email de notificação + auto-resposta para o usuário.
10. Após sucesso, o widget é resetado.

---

## 4. Testes realizados

| Teste | Resultado |
|---|---|
| `php -l functions.php` | ✅ Sem erros |
| `php -l includes/header.php` | ✅ Sem erros |
| `php -l pages/contacto.php` | ✅ Sem erros |
| `php -l pages/partials/section-contacto.php` | ✅ Sem erros |
| `node --check assets/js/forms.js` | ✅ Sem erros |
| `node --check assets/js/main.js` | ✅ Sem erros |
| Servidor local `/es/contacto/` | ✅ HTTP 200 |
| Servidor local `/ca/contacte/` | ✅ HTTP 200 |
| Servidor local `/es/` | ✅ HTTP 200 |
| Script reCAPTCHA presente no header | ✅ Encontrado |
| Widget `.g-recaptcha` na página de contato | ✅ Encontrado |
| Widget `.g-recaptcha` na home (CTA final) | ✅ Encontrado |
| Input hidden conflitante removido | ✅ Não encontrado |

> **Nota:** Testes de envio real com token válido não foram executados porque as chaves reCAPTCHA configuradas podem não aceitar `localhost` como domínio. O deploy em produção (santafe.nexo-digital.app) deve ser testado manualmente.

---

## 5. Arquivos alterados

- `includes/header.php`
- `pages/contacto.php`
- `pages/partials/section-contacto.php`
- `assets/js/forms.js`
- `assets/js/main.js`
- `functions.php`
- `lang/es.json` (verificação, sem alteração)
- `lang/ca.json` (verificação, sem alteração)

---

## 6. Commits

```
f29a4c5 fix(recaptcha): corrige i18n, config overwrite e desabilita botao ate verificacao
9915fd5 fix(recaptcha): remove input hidden conflitante do contacto.php
707b795 feat(recaptcha): remove fallback inseguro e notificacoes Telegram do contato
c997925 feat(recaptcha): refatora forms.js para validar reCAPTCHA v2 checkbox
979b23e feat(recaptcha): adiciona widget reCAPTCHA v2 no CTA final
2e29de1 feat(recaptcha): adiciona widget reCAPTCHA v2 na pagina de contato
905972f feat(recaptcha): carrega script reCAPTCHA v2 no header (auto-render)
```

---

## 7. Próximos passos recomendados

1. **Testar em produção** após deploy: acessar `/es/contacto/`, marcar o checkbox e enviar.
2. **Verificar se as chaves reCAPTCHA** (`RECAPTCHA_SITE_KEY` e `RECAPTCHA_SECRET_KEY`) em `config/constants.php` correspondem ao domínio de produção.
3. **Monitorar** o console do Google reCAPTCHA para taxa de sucesso/erro nos primeiros dias.
4. **Opcional:** adicionar suporte a dark mode no widget via `data-theme="dark"` quando `html.dark` estiver ativo.

---

*Documento gerado em 15/06/2026.*
