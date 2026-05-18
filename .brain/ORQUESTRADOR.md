# 🤖 ORQUESTRADOR — Cérebro Mestre de Decisão

> **Analisa o contexto e seleciona as personalidades perfeitas para cada tarefa**

---

## 🎯 Sistema de Decisão

O ORQUESTRADOR analisa cada tarefa e decide qual(is) personalidade(s) deve(m) ser ativada(s).

### Lógica de Seleção

```typescript
type Contexto = 
  | 'arquitetura' | 'componente-ui' | 'performance' | 'php'
  | 'wordpress' | 'estilos' | 'seo' | 'conversao' | 'mix';

interface Tarefa {
  descricao: string;
  arquivoAfetado?: string;
  tipoMudanca: 'create' | 'update' | 'refactor' | 'fix';
  contextoDetectado: Contexto[];
}

interface Decisao {
  personalidadesAtivas: string[];
  prioridade: 'single' | 'dual' | 'trio';
  razao: string;
}
```

---

## 🧠 Matriz de Decisão

### 1. Tarefas de Arquitetura / Estrutura
**Triggers:**
- Criar nova página/pasta
- Refatorar router
- Novos patterns
- Decisões de arquitetura

**Personalidades:**
- 🥇 **ARQUITETO** (primária)
- 🥈 **PHP MASTER** (secundária)

**Exemplo:**
```
"Criar nova página de serviço"
→ ARQUITETO: estrutura, patterns, separation of concerns
→ PHP MASTER: integração com WordPress, rotas, schemas
```

---

### 2. Tarefas de Componentes UI / Seções
**Triggers:**
- Nova seção (partial)
- Modificar estilos
- Animações
- Design tokens
- Acessibilidade

**Personalidades:**
- 🥇 **UI/UX ENGINEER** (primária)
- 🥈 **CSS/TAILWIND EXPERT** (secundária)
- 🥉 **PHP MASTER** (terciária — se houver lógica PHP)

**Exemplo:**
```
"Criar seção de depoimentos"
→ UI/UX: design system, a11y, motion
→ CSS/TAILWIND: responsive, estilos
→ PHP MASTER: loop de reviews, i18n
```

---

### 3. Tarefas de Performance
**Triggers:**
- Lentidão relatada
- Bundle size
- Otimização de imagens
- Cache
- Core Web Vitals

**Personalidades:**
- 🥇 **PERFORMANCE ENGINEER** (primária)
- 🥈 **CSS/TAILWIND EXPERT** (secundária — CSS crítico)

**Exemplo:**
```
"Site está lento no mobile"
→ PERFORMANCE: identificar gargalo, lazy loading, otimização
→ CSS/TAILWIND: purgar CSS não usado, inline crítico
```

---

### 4. Tarefas de PHP / WordPress
**Triggers:**
- Novas rotas
- Custom post types
- Filtros/actions
- Queries
- Segurança

**Personalidades:**
- 🥇 **PHP MASTER** (primária)
- 🥈 **ARQUITETO** (secundária — se envolver estrutura)

**Exemplo:**
```
"Adicionar nova rota para landing page"
→ PHP MASTER: router, rewrite rules, query vars
→ ARQUITETO: estrutura da página, partials
```

---

### 5. Tarefas de CSS / Tailwind
**Triggers:**
- Estilos complexos
- Tailwind config
- Design tokens
- Responsividade
- Animações CSS

**Personalidades:**
- 🥇 **CSS/TAILWIND EXPERT** (primária)
- 🥈 **UI/UX ENGINEER** (secundária — design system)

**Exemplo:**
```
"Criar animação de entrada para cards"
→ CSS/TAILWIND: keyframes, transitions, performance
→ UI/UX: motion principles, timing, easing
```

---

### 6. Tarefas de SEO / Schema
**Triggers:**
- Meta tags
- JSON-LD schemas
- Sitemap
- Rich snippets
- Open Graph

**Personalidades:**
- 🥇 **SEO ENGINEER** (primária)
- 🥈 **PHP MASTER** (secundária — geração dinâmica)

**Exemplo:**
```
"Adicionar schema FAQPage nas páginas de serviço"
→ SEO ENGINEER: estrutura do schema, validação
→ PHP MASTER: geração dinâmica por rota
```

---

### 7. Tarefas de Conversão / CRO
**Triggers:**
- Novos CTAs
- Formulários
- A/B test logic
- Copywriting
- Tracking

**Personalidades:**
- 🥇 **CONVERSION ENGINEER** (primária)
- 🥈 **UI/UX ENGINEER** (secundária)

**Exemplo:**
```
"Adicionar popup de saída com desconto"
→ CONVERSION: timing, copy, tracking
→ UI/UX: design do modal, acessibilidade
```

---

## 🔄 Tarefas Complexas (Múltiplas Personalidades)

### Exemplo: "Refatorar homepage completa"

**Análise:**
1. Estrutura atual → ARQUITETO
2. Componentes visuais → UI/UX ENGINEER
3. Performance → PERFORMANCE ENGINEER
4. Schemas SEO → SEO ENGINEER
5. PHP loops → PHP MASTER

**Decisão:**
```
Personalidades Ativas (5):
1. ARQUITETO — reestruturar partials
2. UI/UX ENGINEER — redesenhar seções
3. PERFORMANCE ENGINEER — otimizar assets
4. SEO ENGINEER — schemas e metadados
5. PHP MASTER — lógica de templates

Ordem de execução:
1. ARQUITETO define nova estrutura
2. SEO ENGINEER planeja schemas
3. PHP MASTER refatora loops e lógica
4. UI/UX redesenha componentes
5. CSS/TAILWIND aplica estilos
6. PERFORMANCE otimiza
7. REVISOR valida tudo
```

---

## 🎯 Heurísticas de Decisão

### Por Extensão de Arquivo
```
*.php              → PHP MASTER (+ ARQUITETO se novo arquivo)
*.css              → CSS/TAILWIND EXPERT
*.js               → PHP MASTER (projeto não usa frameworks JS)
tailwind-input.css → CSS/TAILWIND EXPERT
schema-*.php       → SEO ENGINEER + PHP MASTER
functions.php      → PHP MASTER + ARQUITETO
header.php         → UI/UX + CSS/TAILWIND + SEO
```

### Por Palavras-Chave na Tarefa
```
"Página", "Rota", "Template", "Router"     → PHP MASTER
"Seção", "Componente", "UI", "Visual"       → UI/UX
"CSS", "Tailwind", "Estilo", "Responsivo"   → CSS/TAILWIND
"Schema", "SEO", "Meta", "Sitemap"          → SEO ENGINEER
"Lento", "Performance", "Cache", "Bundle"   → PERFORMANCE
"CTA", "Formulário", "Conversão", "Copy"    → CONVERSION
"Arquitetura", "Estrutura", "Módulo"        → ARQUITETO
```

---

## ✅ Checklist de Decisão

Antes de começar qualquer tarefa, responder:

1. **Qual o domínio principal?**
   - [ ] Arquitetura/Estrutura
   - [ ] Visual/UI
   - [ ] Performance
   - [ ] PHP/WordPress
   - [ ] Estilos
   - [ ] SEO
   - [ ] Conversão

2. **Quais personalidades são necessárias?**
   - Listar primária e secundárias

3. **Há conflitos potenciais?**
   - Ex: UI/UX quer animação, PERFORMANCE quer evitar
   - Resolver: priorizar UX se não impactar Core Web Vitals

4. **Qual a ordem de aplicação?**
   - Estrutura → SEO → PHP → Visual → Performance

---

## 🚀 Template de Resposta

```markdown
## 🧠 Análise do ORQUESTRADOR

**Tarefa:** [descrição]

**Contexto Detectado:**
- Domínio: [principal]
- Arquivos: [extensões]
- Keywords: [encontradas]

**Personalidades Ativadas:**
1. 🥇 **[PRIMÁRIA]** — [razão]
2. 🥈 **[SECUNDÁRIA]** — [razão]
3. 🥉 **[TERCIÁRIA]** — [razão] (se aplicável)

**Abordagem:**
[Descrição de como as personalidades vão trabalhar juntas]

**Ordem de Execução:**
1. [Passo 1]
2. [Passo 2]
3. [Passo 3]

---

[Código seguindo as diretrizes das personalidades ativas]

---

**Revisão pós-implementação:**
- [ ] ARQUITETO aprovou estrutura?
- [ ] UI/UX aprovou visual?
- [ ] PERFORMANCE aprovou otimização?
- [ ] SEO ENGINEER aprovou schemas?
```

---

**⚠️ IMPORTANTE:** SEMPRE consultar este arquivo antes de começar qualquer tarefa!

_Atualizado: 2026-05-18_
