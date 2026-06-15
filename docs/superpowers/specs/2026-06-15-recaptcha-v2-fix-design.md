# Design: Correção do reCAPTCHA v2 Checkbox — Tema WordPress Santa Fe

**Data:** 2026-06-15  
**Projeto:** Tema WordPress Santa Fe Construcciones  
**Escopo:** Formulários de contato (página de contato + CTA final da home)  
**Versão:** 1.0

---

## 1. Objetivo

Corrigir a implementação atual de reCAPTCHA, que está híbrida/quebrada, transformando-a em um **reCAPTCHA v2 Checkbox real e funcional** nos formulários de contato do tema.

---

## 2. Contexto atual

A documentação interna (`RESUMO-ENTREGAS.md`) afirma que o reCAPTCHA v2 Checkbox foi entregue, mas a inspeção do código revela:

| O que está documentado | O que o código realmente faz |
|---|---|
| reCAPTCHA v2 Checkbox | O JS chama `grecaptcha.execute()` — padrão do **v3 / v2 Invisible** |
| Script Google carregado no `header.php` | **Não está carregado** |
| Widget v2 visível nos formulários | Apenas `<input type="hidden" name="g-recaptcha-response">` |
| Validação backend segura | Existe, mas aceita envio caso a secret key esteja vazia (fallback inseguro) |

Como resultado, o formulário pode ser enviado sem qualquer validação real do reCAPTCHA.

---

## 3. Decisões

### 3.1 Versão do reCAPTCHA
Usar **reCAPTCHA v2 Checkbox** ("No soy un robot") por:
- Ser o comportamento documentado no projeto.
- Oferecer hard block simples e confiável.
- Ter backend simples (apenas validar token, sem interpretar score).
- Ser adequado para um formulário de orçamento B2B onde a conversão é importante, mas a segurança direta é prioridade nesta entrega.

### 3.2 Envio de notificações
Nesta correção, o envio de notificações será **apenas por email** (`wp_mail`). O envio para Telegram será removido do handler do formulário de contato, conforme solicitação do usuário. A função `santafe_send_to_telegram` permanece no arquivo para uso futuro, mas não será chamada no fluxo de contato.

### 3.3 Fallback de chave secreta
O fallback que aceita envio quando `RECAPTCHA_SECRET_KEY` está vazia será removido. Se a chave não estiver configurada, o envio será rejeitado com mensagem de erro clara.

---

## 4. Arquivos alterados

| Arquivo | Alteração |
|---|---|
| `includes/header.php` | Carregar script `https://www.google.com/recaptcha/api.js` quando `RECAPTCHA_SITE_KEY` estiver definida; expor site key para o JS. |
| `pages/contacto.php` | Renderizar widget `<div class="g-recaptcha">` no lugar do input hidden; desabilitar botão até o checkbox ser marcado. |
| `pages/partials/section-contacto.php` | Mesma alteração do formulário da página de contato. |
| `assets/js/forms.js` | Remover lógica de `grecaptcha.execute()`; validar token do v2 antes do envio; tratar expiração do token. |
| `functions.php` | Remover fallback inseguro; manter validação via `siteverify`; remover chamada ao Telegram no handler de contato. |
| `lang/es.json` | Garantir mensagem `contact.recaptcha_invalid`. |
| `lang/ca.json` | Garantir mensagem `contact.recaptcha_invalid`. |

---

## 5. Fluxo de dados

```
Usuário acessa página com formulário
        ↓
header.php carrega api.js do Google
        ↓
Widget v2 é renderizado no formulário
        ↓
Usuário preenche os campos
        ↓
Usuário clica no checkbox "No soy un robot"
        ↓
Google chama data-callback com token
        ↓
Token preenche input hidden g-recaptcha-response
        ↓
Botão de envio é habilitado
        ↓
Usuário clica em Enviar
        ↓
JS valida: honeypot vazio + campos válidos + token preenchido
        ↓
AJAX POST para admin-post.php
        ↓
Backend valida: nonce/CSRF + honeypot + reCAPTCHA token
        ↓
Se válido: envia email de notificação + autoreply
        ↓
Retorna sucesso/erro para o frontend
```

---

## 6. Detalhes técnicos

### 6.1 Carregamento do script

```php
<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
<script src="https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit" async defer></script>
<?php endif; ?>
```

O `render=explicit` evita que o Google tente renderizar widgets automaticamente, dando controle total ao JS do tema.

### 6.2 Renderização do widget

```html
<div id="recaptcha-contacto" class="g-recaptcha"></div>
<input type="hidden" name="g-recaptcha-response" value="">
```

O JS renderiza explicitamente no container informando:
- `sitekey`
- `theme` (light/dark conforme tema do site)
- `callback` para preencher o token
- `expired-callback` para limpar o token

### 6.3 Validação no frontend (forms.js)

- Verificar se existe widget reCAPTCHA no formulário.
- Se existir, exigir `g-recaptcha-response` preenchido.
- Se o token expirar, limpar o campo e pedir nova verificação.
- Bloquear envio se o script do Google não carregar.

### 6.4 Validação no backend (functions.php)

```php
$recaptcha_token = sanitize_text_field($payload['g-recaptcha-response'] ?? '');
$recaptcha_result = santafe_verify_recaptcha($recaptcha_token);
if (!$recaptcha_result['success']) {
    // retorna erro traduzido
}
```

A função `santafe_verify_recaptcha` continuará chamando `https://www.google.com/recaptcha/api/siteverify`, mas será alterada para:
- Rejeitar caso a secret key esteja vazia.
- Registrar logs seguros (sem expor a secret key).

### 6.5 Remoção do Telegram

No handler `santafe_tailwind_handle_contact_form`, a chamada `santafe_send_to_telegram($lead)` será removida. A lógica de sucesso passa a depender apenas do envio de email:

```php
$email_sent = santafe_send_contact_email($lead, $attachments);
if (!$email_sent) {
    // erro
}
```

---

## 7. Tratamento de erros

| Cenário | Comportamento esperado |
|---|---|
| Checkbox não marcado | Mensagem: "Por favor, marca la casilla 'No soy un robot'." |
| Token expirado | Limpar campo e pedir para marcar novamente |
| Script do Google não carrega | Botão permanece desabilitado; mensagem informando para recarregar |
| Token inválido no backend | Mensagem traduzida de erro do reCAPTCHA |
| Secret key não configurada | Envio rejeitado; log registrado |
| Honeypot preenchido | Bloqueio silencioso (sucesso falso) |

---

## 8. Testes

1. Acessar `/es/contacto/` e confirmar que o widget v2 aparece.
2. Tentar enviar sem marcar o checkbox → erro.
3. Marcar o checkbox e enviar → sucesso.
4. Esperar ~2 minutos e enviar → erro de token expirado.
5. Preencher honeypot via DevTools → bloqueio silencioso.
6. Testar o formulário CTA final na home com os mesmos cenários.
7. Testar versão em catalão (`/ca/contacte/`).
8. Verificar dark mode: widget deve usar tema escuro quando aplicável.

---

## 9. Riscos e mitigações

| Risco | Impacto | Mitigação |
|---|---|---|
| reCAPTCHA v2 pode reduzir conversão | Médio | É a escolha deliberada do usuário; futuramente pode migrar para v3 |
| Script do Google bloqueado por adblocker/privacy | Baixo | Exibir mensagem pedindo desativação temporária ou recarga |
| Configuração de chaves incorreta | Alto | Testar em staging antes de produção; falhar fechado quando secret vazia |

---

## 10. Critérios de aceitação

- [ ] Widget reCAPTCHA v2 checkbox visível em ambos os formulários.
- [ ] Envio bloqueado quando o checkbox não é marcado.
- [ ] Envio bloqueado quando o token é inválido.
- [ ] Backend não aceita envio sem secret key configurada.
- [ ] Telegram não é mais chamado no fluxo de contato.
- [ ] Mensagens de erro traduzidas em ES/CA.
- [ ] Testes manuais passam em staging.

---

## 11. Notas

- As chaves reCAPTCHA (`RECAPTCHA_SITE_KEY` e `RECAPTCHA_SECRET_KEY`) já existem em `config/constants.php`. Não serão alteradas nesta tarefa.
- O tema Tailwind e os tokens de design existentes não serão modificados.
- A função `santafe_send_to_telegram` permanece no código, apenas deixa de ser usada no handler de contato.
