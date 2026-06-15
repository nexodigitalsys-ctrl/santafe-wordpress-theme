# 📋 Decisões Arquiteturais

> Registro de decisões importantes do projeto Santa Fe.

---

## 2026-05-18 — Auditoria .BRAIN e 3 Fases de Melhorias

**Contexto:** Auditoria completa dos 5 principais concorrentes (Koncepto, OAK, Sincro, The Room, Albatros).

**Decisões:**
1. **Manter fundo escuro no hero** — cria drama, diferencia do mercado
2. **Transicionar para fundo claro em seções de conteúdo** — melhora legibilidade
3. **Manter vermelho `#AE232A`** — validado pelo mercado (OAK usa similar)
4. **Before/After interativo como USP** — nenhum concorrente tem
5. **Formulário simplificado** — 4 campos obrigatórios (nome, tel, tipo obra, privacidade)

---

## 2026-05-18 — Página de Garantias Dedicada

**Decisão:** Criar página separada `/garantias/` em vez de apenas seção na home.

**Motivação:**
- Koncepto usa transparência legal como diferenciador
- Página dedicada permite SEO específico
- Pode ser linkada diretamente em propostas

---

## 2026-05-18 — Google Reviews Widget (não embed real)

**Decisão:** Criar widget visual próprio em vez de embed do Google.

**Motivação:**
- Google não oferece iframe oficial de reviews
- Widgets de terceiros (Elfsight) requerem conta/pagamento
- Widget próprio mantém controle de design e não adiciona dependência externa

---

## 2026-05-18 — Breadcrumbs visuais + Schema

**Decisão:** Implementar breadcrumbs HTML + JSON-LD simultaneamente.

**Motivação:**
- Schema sozinho não ajuda UX
- Breadcrumbs visuais melhoram navegação e SEO local
- Helper `renderBreadcrumb()` gera ambos em uma chamada

---

## 2026-05-18 — Tailwind v4 com @source

**Decisão:** Adicionar `@source` ao `tailwind-input.css` para scanear arquivos PHP.

**Motivação:**
- Tailwind v4 não detecta classes em arquivos PHP automaticamente
- Sem `@source`, variantes responsivas (`md:`) não são geradas
- Rebuild manual necessário após adicionar novas classes

---

_Atualizado: 2026-05-18_
