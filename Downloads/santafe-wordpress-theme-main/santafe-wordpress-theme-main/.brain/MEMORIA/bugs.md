# 🐛 Bugs Conhecidos

> Registro de bugs encontrados e resolvidos no projeto Santa Fe.

---

## RESOLVIDOS

### 2026-05-18 — Conteúdo invisível em mobile

**Severidade:** 🔴 Crítico  
**Descrição:** Animações `data-reveal` deixavam conteúdo invisível em mobile. IntersectionObserver com threshold alto + falta de fallback CSS.

**Causa:**
- `threshold: 0.1` era alto demais para telas pequenas
- Inline style `opacity: 0` permanecia se JS falhasse
- Sem fallback CSS puro

**Solução:**
- Reduzir threshold para `0.05` + `rootMargin: '0px 0px -50px 0px'`
- Usar classe `reveal-pending` em vez de inline style
- Adicionar `@keyframes revealFallback` com delay de 5s
- CSS base: `opacity: 1` por padrão, JS sobrescreve para `0`

**Arquivos:** `assets/js/premium-interactions.js`, `includes/header.php`

---

### 2026-05-18 — Schema review com 127 reviews (falso)

**Severidade:** 🔴 Crítico  
**Descrição:** `aggregateRating` declarava 127 reviews mas só existiam 12 embedadas.

**Causa:** Valor hardcoded inconsistente com dados reais.

**Solução:** Corrigir para `12` em `schema-reviews.php` e `schema-localbusiness.php`.

---

### 2026-05-18 — Mobile menu sem alternador de idioma

**Severidade:** 🟠 Alto  
**Descrição:** Menu mobile não permitia trocar ES/CA.

**Solução:** Adicionar botões ES/CA no final do menu mobile em `includes/header.php`.

---

## ATIVOS / MONITORAR

### 2026-05-18 — Tailwind v4 não detecta classes em PHP

**Severidade:** 🟡 Médio  
**Descrição:** Classes novas em arquivos PHP podem não ser incluídas no CSS buildado.

**Workaround:** Adicionar `@source` no `tailwind-input.css` + rebuild manual.

**Monitorar:** Após cada adição de classe Tailwind nova, verificar se foi gerada.

---

### 2026-05-18 — Bug Detector carrega sincronamente (render-blocking)

**Severidade:** 🟡 Médio  
**Descrição:** Script de 664KB no `<head>` bloqueia renderização.

**Workaround:** Nenhum — ferramenta de debug, não afeta produção.

**Nota:** Em produção, o bug detector pode ser removido ou carregado com `async`.

---

_Atualizado: 2026-05-18_
