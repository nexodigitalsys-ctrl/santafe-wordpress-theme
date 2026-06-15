# Design: reCAPTCHA v2 + Correção de Cookies Duplicados — Santa Fe Construcciones

**Data:** 2026-06-11  
**Autor:** Kimi Code  
**Status:** Aguardando aprovação

---

## 1. Contexto

O site **Santa Fe Construcciones** possui atualmente dois problemas na página de contato:

1. **Cookies duplicados:** o tema carrega um banner customizado próprio e, ao mesmo tempo, o plugin **Complianz GDPR** também renderiza seu próprio banner/modal de consentimento.
2. **Ausência de reCAPTCHA:** o formulário de contato depende apenas de um honeypot simples (`input[name="website"]`) para proteção contra bots.

## 2. Objetivos

- Eliminar o conflito de banners de cookies mantendo apenas o banner customizado do tema.
- Adicionar **reCAPTCHA v2 Checkbox** funcional nos formulários de contato.
- Garantir que a validação do reCAPTCHA ocorra no backend antes do envio de e-mail/Telegram.
- Manter a experiência do usuário e o design system existente.

## 3. Escopo

### Dentro do escopo
- Remover/desativar o plugin Complianz GDPR.
- Adicionar constantes de configuração para reCAPTCHA.
- Carregar script do Google reCAPTCHA v2 no frontend.
- Renderizar widget reCAPTCHA nos formulários de contato.
- Validar token reCAPTCHA no backend.
- Tratar erros de validação com mensagens traduzidas (ES/CA).
- Salvar chaves de reCAPTCHA localmente em arquivo fora do Git.

### Fora do escopo
- Alterar a lógica de Consent Mode v2 do banner customizado.
- Refatorar o formulário da calculadora.
- Alterar o sistema de traduções.

## 4. Arquitetura

### 4.1 Cookies

O tema já possui um banner customizado funcional em `includes/footer.php` + `assets/js/cookies.js`. A solução é remover o plugin Complianz, que está gerando o segundo banner/modal.

**Ação:**
- Desativar/excluir o plugin **Complianz GDPR** no wp-admin.
- Limpar cache após a remoção.

### 4.2 reCAPTCHA v2 Checkbox

```
Frontend (formulário)
  ↓
Widget reCAPTCHA renderizado pelo Google
  ↓
Usuário clica em "Não sou um robô"
  ↓
Google gera g-recaptcha-response
  ↓
forms.js envia o token junto com FormData
  ↓
Backend (functions.php)
  ↓
POST para https://www.google.com/recaptcha/api/siteverify
  ↓
Se success === true → envia e-mail/Telegram
Se falhar → retorna erro ao usuário
```

## 5. Arquivos alterados

| Arquivo | Alteração |
|---|---|
| `config/constants.php` | Adicionar `RECAPTCHA_SITE_KEY` e `RECAPTCHA_SECRET_KEY` via `getenv()` com fallback vazio. |
| `includes/header.php` | Carregar `https://www.google.com/recaptcha/api.js` com `async defer` quando a chave estiver configurada. |
| `pages/contacto.php` | Inserir `<div class="g-recaptcha" data-sitekey="..."></div>` acima do botão de envio. |
| `pages/partials/section-contacto.php` | Inserir `<div class="g-recaptcha" data-sitekey="..."></div>` acima do botão de envio. |
| `functions.php` | Adicionar função `santafe_verify_recaptcha()`; chamá-la em `santafe_tailwind_handle_contact_form()` antes de processar o lead. |
| `assets/js/forms.js` | Garantir que `g-recaptcha-response` seja enviado com o FormData; exibir mensagens de erro corretamente. |
| `lang/es.json` | Adicionar mensagens: `recaptcha_missing`, `recaptcha_invalid`. |
| `lang/ca.json` | Adicionar mensagens: `recaptcha_missing`, `recaptcha_invalid`. |
| `recaptcha.local.txt` | Arquivo local com as chaves (já criado, fora do Git). |
| `.gitignore` | Ignorar `recaptcha.local.txt`. |

## 6. Configuração no servidor

As chaves já foram geradas e salvas localmente em `recaptcha.local.txt`. Para produção, as variáveis de ambiente devem ser configuradas no servidor:

```bash
RECAPTCHA_SITE_KEY=6Lfu7RktAAAAAOy_3OBZ8gkrasoI7Uw1_dogvkxM
RECAPTCHA_SECRET_KEY=6Lfu7RktAAAAAIpxrmxI8U0zZmNjmxoSL4-gPTBv
```

> **Atenção:** a chave secreta nunca deve ser commitada no repositório.

## 7. Fluxo detalhado

### 7.1 Backend — validação

```php
function santafe_verify_recaptcha(string $token): bool {
    $secret = RECAPTCHA_SECRET_KEY;
    if ($secret === '') {
        return true; // fallback seguro: não bloqueia se não configurado
    }
    if ($token === '') {
        return false;
    }
    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ],
        'timeout' => 10,
    ]);
    if (is_wp_error($response)) {
        return false;
    }
    $body = json_decode(wp_remote_retrieve_body($response), true);
    return is_array($body) && !empty($body['success']);
}
```

A função será chamada em `santafe_tailwind_handle_contact_form()` após a validação do nonce e antes do processamento do lead.

### 7.2 Frontend — envio AJAX

O `forms.js` já coleta todos os campos via `FormData`. Como o reCAPTCHA v2 cria um input hidden `g-recaptcha-response` automaticamente dentro do formulário, nenhuma alteração complexa é necessária — o token já será enviado.

Será adicionada uma verificação extra para garantir que o token exista antes de enviar:

```javascript
const recaptchaToken = form.querySelector('textarea[name="g-recaptcha-response"]')?.value;
if (!recaptchaToken) {
    showFormMessage(form, 'error', 'Por favor, completa el reCAPTCHA.');
    return;
}
```

> Nota: o reCAPTCHA v2 cria um `textarea` com `name="g-recaptcha-response"`, não um `input`.

## 8. Tratamento de erros

| Cenário | Comportamento |
|---|---|
| Chaves não configuradas | Loga warning; permite envio (fallback seguro). |
| Token ausente | Retorna erro `recaptcha_missing` sem processar o lead. |
| Token inválido | Retorna erro `recaptcha_invalid` sem processar o lead. |
| API do Google indisponível | Retorna erro genérico de conexão. |
| Complianz ainda ativo | O usuário deve desativar manualmente no wp-admin. |

## 9. Testes

1. Acessar `/es/contacto/` e verificar que só aparece o banner customizado de cookies.
2. Verificar que o widget reCAPTCHA é renderizado acima do botão "Enviar mensaje".
3. Tentar enviar sem marcar o reCAPTCHA → deve aparecer erro.
4. Marcar o reCAPTCHA e enviar → mensagem de sucesso.
5. Verificar no backend (e-mail/Telegram) que o lead chegou.
6. Repetir o teste na home (seção CTA de contato).

## 10. Checklist de deploy

- [ ] Desativar/excluir plugin Complianz GDPR no wp-admin.
- [ ] Configurar variáveis de ambiente `RECAPTCHA_SITE_KEY` e `RECAPTCHA_SECRET_KEY` no servidor.
- [ ] Fazer deploy do tema atualizado.
- [ ] Limpar cache do WordPress e do navegador.
- [ ] Testar formulário de contato em `/es/contacto/`.
- [ ] Testar formulário CTA na home.

---

## Aprovação

Assim que você aprovar este spec, seguirei para o plano de implementação.
