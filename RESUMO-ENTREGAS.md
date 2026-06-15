# 📋 Resumo de Entregas — Santa Fe Construcciones

> **Data:** 13/06/2026  
> **Projeto:** Tema WordPress Santa Fe Construcciones  
> **Idiomas:** ES / CA  
> **Tecnologias:** PHP 8.3, Tailwind CSS, Embla Carousel, WordPress

---

## 🎯 O que o cliente pediu (PDF "Revisión Básica 1.1")

| # | Pedido do Cliente | Status |
|---|-------------------|--------|
| 1 | **Validação do formulário de contato** — email, telefone, anti-bot | ✅ **Entregue** |
| 2 | **Ícones de redes sociais no footer** — Instagram, Facebook, LinkedIn | ✅ **Entregue** |
| 3 | **Correção de texto invisível no dark mode** | ✅ **Entregue** |
| 4 | **Fotos do carrossel específicas da página** — parquet só fotos de parquet, etc. | ✅ **Entregue** |
| 5 | **Revisão de preços** — confirmar se estão atualizados | ⏳ **Pendente** (aguardando cliente) |
| 6 | **reCAPTCHA v2 + cookies duplicados** — proteção anti-bot real | ✅ **Entregue** (11/06) |
| 7 | **Reviews reais de Google** — substituir 12 fictícias por 6 reais | ✅ **Entregue** (12/06) |
| 8 | **Inputs visíveis em dark mode** — campos do formulário ilegíveis | ✅ **Entregue** (12/06) |
| 9 | **Título "24-48 horas"** — alterar prazo no CTA | ✅ **Entregue** (12/06) |
| 10 | **Email: notificação + auto-resposta** — fix From/Reply-To, auto-reply HTML, logo nos emails | ✅ **Entregue** (13/06) |
| 11 | **Email: envio direto a Gmail** — saltar forward IONOS, entregar a admsantafeconstruciones@gmail.com | ✅ **Entregue** (13/06) |
| 12 | **Email: adjuntar arquivos (fotos/PDF)** — upload + wp_mail attachments | ✅ **Entregue** (13/06) |
| 13 | **Botões minimalistas** — reduzir padding/font/sombra em todos os CTAs (hero, sticky, final CTA, WhatsApp float) | ✅ **Entregue** (13/06) |
| 14 | **Redes sociais: Instagram, TikTok, X** — substituir Facebook/LinkedIn | ✅ **Entregue** (13/06) |
| 15 | **Testimonials carrossel minimalista** — reduzir fontes, paddings, avatares, estrelas | ✅ **Entregue** (13/06) |
| 16 | **Dark mode: texto dos botões branco** — fix CSS para .text-xs em a/button dentro de section | ✅ **Entregue** (13/06) |

---

## ✅ Detalhamento das entregas

### 1. Validação do Formulário (`assets/js/forms.js`)

**O que foi feito:**
- Regex de email: só aceita emails válidos (`nome@dominio.com`)
- Regex de telefone: aceita `+34`, parênteses, espaços, hífens e pontos (`/^[\+]?[\d\s\-\(\)\.]{9,20}$/`)
- **Honeypot anti-bot**: campo invisível `website` que se preenchido bloqueia o envio
- Token CSRF para segurança
- Mensagens de erro em espanhol/catalão
- Loading state no botão para evitar double-submit

**Como testar:**
- Tente enviar com email `teste@teste` → erro
- Tente enviar com telefone `abc` → erro
- Preencher o campo honeypot (inspecionar elemento) → bloqueado

---

### 2. Ícones de Redes Sociais no Footer (`includes/footer.php`)

**O que foi feito:**
- 3 ícones circulares: Instagram, Facebook, LinkedIn (SVG oficiais)
- Design escuro com hover laranja (`bg-warm-800` → `bg-brand-600`)
- URLs configuráveis em `config/constants.php`:
  ```php
  define('SOCIAL_INSTAGRAM', ''); // preencher com URL real
  define('SOCIAL_FACEBOOK', '');
  define('SOCIAL_LINKEDIN', '');
  ```
- Enquanto não houver URL, os ícones apontam para `#` e mostram um `title` com o nome da rede
- Totalmente responsivo e acessível (`aria-label`)

**Próximo passo do cliente:**
- Fornecer os links reais das redes sociais para ativar os botões

---

### 3. Correção de Texto Invisível no Dark Mode (`includes/header.php` + vários)

**O problema:**
No dark mode, vários textos ficavam cinza-claro sobre fundo cinza-escuro → **ilegíveis**.

**A solução:**
Criamos **Design Tokens** (variáveis CSS) por seção. Em vez de cores hardcoded, cada seção tem suas próprias variáveis:

```css
--sobre-title: #1e293b;      /* light mode */
--sobre-body: #475569;
html.dark --sobre-title: #f8fafc;  /* dark mode override */
html.dark --sobre-body: #cbd5e1;
```

**Seções com tokens completos:**
- Hero, Serviços, Sobre Nosotros, Testimonios, CTA Final, Proyectos, Blog, FAQ, Garantías, Contacto, Footer

**Classes utilitárias criadas:**
- `.section-sobre-eeat-card`, `.section-sobre-values-card`, etc.

**Resultado:** Troca de tema é instantânea, sem texto invisível em nenhuma página.

---

### 4. Carrossel de Imagens 100% Específico por Serviço (`pages/service-template.php`)

**A regra imposta:**
> *"Cada carrossel mostra APENAS imagens do serviço dessa página. Nunca misturar fotos de serviços diferentes."*

**O que foi corrigido:**

| Serviço | Antes (problema) | Depois (solução) |
|---------|-----------------|------------------|
| **Obra Nueva** | Tinha `reforma-general-santafe` e `rehabilitacion-casa` (fotos de reforma/rehab) | 5 fotos 100% de obra nueva: construção desde zero, vivenda unifamiliar, fachada de pedra, piscina/jardim |
| **Reformas Integrales** | Tinha `reforma-interiores-vivienda` (genérica) | Substituida por foto real de trabalhadores com azulejos |
| **Pladur** | Tinha `reforma-interiores-vivienda` (genérica) | Removida. Agora só pladur específico |
| **Obra Pública** | — | +1 foto real de calçada acabada em Tarragona |
| **Obra Civil** | Tinha `obra-nueva-construcciones-girona` (foto de obra nova!) | Removida. Agora só muros, bordillos e aceras |
| **Parquet** | Tinha `reforma-interiores-vivienda` e `reforma-gerona` (genéricas) | Removidas. Agora só parquet: instalação, renovação, reparação |
| **Rehabilitación Fachadas** | Tinha `obra-nueva-construcciones-santafe` (foto de obra nova!) | Removida. Agora só rehab: casa, paramento, revestimento madeira |
| **Reformas Comerciales** | Tinha `reforma-interiores-vivienda` (foto de VIVIENDA em página comercial!) | Removida. Agora só comercial: loja, local, acabados |

**Sistema escalável:**
O array `$galleries` está documentado com a REGRA. Adicionar uma nova imagem é só copiar o formato:
```php
['img' => '/caminho/foto.webp', 'title' => 'Título · Cidade · Ano', 'cat' => 'Categoria'],
```

---

### 5. Carrossel Embla Configurável (`pages/service-template.php`)

**O que foi feito:**
O carrossel tem **variáveis globais + overrides por serviço**:

```php
$carousel_defaults = [
    'autoplay_delay' => 4000,      // 4 segundos entre slides
    'slides_desktop' => 3,         // 3 fotos no desktop
    'slides_tablet' => 2,          // 2 no tablet
    'slides_mobile' => 1,          // 1 no mobile
    'loop' => true,                // loop infinito
];

// Override por serviço
$carousel_per_service = [
    'parquet-pavimentos' => ['slides_desktop' => 4],  // 4 fotos (são mais finas)
    'obra-nueva' => ['autoplay_delay' => 5000],       // 5 segundos (fotos mais impactantes)
];
```

**Benefício:** Quer mudar o tempo de autoplay de TODOS os serviços? Altera 1 linha em `$carousel_defaults`. Quer que só o Parquet tenha 4 slides? Adiciona 1 linha em `$carousel_per_service`.

---

### 6. reCAPTCHA v2 + Correção de Cookies Duplicados (11/06)

**O que foi feito:**
- Adicionado **reCAPTCHA v2 Checkbox** nos formulários de contato (`contacto.php` e `section-contacto.php`)
- Plugin **Complianz GDPR** removido (banner duplicado)
- Validação do token no backend (`functions.php`)
- Verificação no frontend antes do envio AJAX (`forms.js`)
- Mensagens de erro traduzidas (ES/CA)

**Arquivos alterados:**
- `config/constants.php` — constantes `RECAPTCHA_SITE_KEY` e `RECAPTCHA_SECRET_KEY`
- `includes/header.php` — carregamento condicional do script Google
- `pages/contacto.php`, `pages/partials/section-contacto.php` — widget reCAPTCHA
- `functions.php` — `santafe_verify_recaptcha()`
- `assets/js/forms.js` — bloqueio de envio sem token
- `lang/es.json`, `lang/ca.json` — mensagens de erro

---

### 7. Reviews Reais de Google (12/06)

**O que foi feito:**
- Substituídas 12 reviews humanizadas (fictícias) por **6 reviews reais do perfil Google**
- `data/reviews.json` — atualizado com dados reais
- `includes/schema-reviews.php` — reviews + AggregateRating: 5.0/5, 6 reviews
- `includes/schema-localbusiness.php` — AggregateRating sincronizado
- `pages/partials/section-testimonios.php` — badge "6 opiniones verificadas", 5.0★
- `pages/partials/section-google-reviews.php` — featured reviews reais, badge 5.0★

**Resultado:** Schema JSON-LD agora reflete dados verdadeiros. Zero risco de penalização Google.

---

### 8. Inputs Visíveis em Dark Mode (12/06)

**O problema:**
No modo escuro, os campos do formulário (nome, tel, email, etc.) tinham borda `#64748b` sobre fundo `#1e293b` — praticamente invisíveis.

**A solução:**
- `--contacto-input-bg`: `#1e293b` → `#334155` (fundo mais claro)
- `--contacto-input-border`: `#64748b` → `#94a3b8` (borda visível)
- `--contacto-input-text`: `#e2e8f0` → `#f1f5f9` (texto mais nítido)
- Adicionado `::placeholder` com cor visível e `color-scheme: dark` para selects

---

### 9. Título "24-48 horas" (12/06)

**O que foi feito:**
- `section-contacto.php`: "Presupuesto en 48 horas" → "Presupuesto en **24-48** horas. Sin compromiso."
- Versão em catalão: "Presupost en 48 hores" → "Presupost en **24-48** hores"

---

## 🚀 Melhorias extras que fizemos (além do pedido)

### A. Cards Premium na página "Sobre Nosotros"
- **Stats cards** com glassmorphism (`bg-slate-900/70 backdrop-blur-md`)
- **EEAT cards** (Experience, Expertise, Authoritativeness, Trust) com ícones e descrições
- **Values cards** com hover lift e animação sutil
- Tudo com suporte a dark mode completo

### B. Header Responsivo + Menu Mobile Fullscreen
- Header branco sólido no light mode, escuro no dark mode
- Menu mobile em tela cheia com animação suave
- Submenus em acordeão para mobile
- Zoom bloqueado em mobile para evitar layout quebrado

### C. Transição Suave Dark/Light
- Animação CSS de `0.3s ease` em TODOS os elementos que mudam de cor
- Troca de tema não pisca, é gradual e agradável

### D. Router Local Sincronizado
- `.local-preview-router.php` agora tem **todas as rotas** que existem no servidor de produção
- Adicionadas 8 rotas que faltavam (4 em ES + 4 em CA)
- Testado: todas retornam HTTP 200

### E. Precificação Alinhada com Mercado de Barcelona
- Preços atualizados conforme tabela de mercado 2024/2025
- Cada serviço tem faixa de preço realista (ex: Reforma Integral €450–850/m²)

### F. SEO Completo
- 9 páginas de serviço com Schema.org FAQ, HowTo, LocalBusiness
- Meta tags dinâmicas por página
- Canonical URLs corretas
- Sitemap gerado automaticamente

### G. 18 Fotos Reais do Cliente Categorizadas
- Fotos reais de obras (não stock!) organizadas por serviço
- Nomes descritivos: `obra-nueva-desde-cero.webp`, `parquet-instalacion.webp`
- Formatos WebP para performance

---

## 📝 Checklist do Cliente — O que falta VOCÊ fazer

| # | Tarefa | Prioridade | Como fazer |
|---|--------|------------|------------|
| 1 | **Confirmar se preços estão atualizados** | 🟡 Média | Verificar `config/services-data.php`. Se precisar alterar, é só mudar os valores |
| 2 | **Enviar mais fotos específicas** (opcional) | 🟢 Baixa | Serviços com poucas fotos: Parquet (3), Obra Civil (3), Rehabilitación (3), Comerciales (3). Mandar fotos reais que adicionamos ao carrossel |
| 3 | **Revisar textos em catalão** | 🟡 Média | Alguns títulos de fotos e seções podem ser revisados por nativo |

---

## 🛠️ Estrutura Técnica — Onde está cada coisa

```
config/
  ├── constants.php          ← Redes sociais, telefone, email
  └── services-data.php      ← Preços e dados dos 9 serviços

pages/
  ├── service-template.php   ← Template único dos 9 serviços (carrossel, FAQ, preços)
  └── sobre-nosotros.php     ← Página "Sobre Nosotros" com cards premium

includes/
  ├── header.php             ← Design tokens CSS (dark mode), WhatsApp float
  └── footer.php             ← Ícones sociais (Insta, TikTok, X), cookie banner, CTA sticky

assets/js/
  └── forms.js               ← Validação, honeypot, AJAX

data/
  └── reviews.json           ← 6 reviews reais de Google (ES + CA)

assets/images/real/          ← 18 fotos reais do cliente (WebP)
assets/images/servicios/     ← Fotos extras organizadas por pasta
```

---

## 🧪 Como testar localmente

1. Iniciar servidor:
   ```bash
   php -S 127.0.0.1:8765 .local-preview-router.php
   ```
2. Acessar: http://127.0.0.1:8765/es/servicios/parquet-pavimentos/
3. Testar dark mode: alternar no toggle do header
4. Testar formulário: página de contato → preencher campos inválidos
5. Testar mobile: diminuir a janela do navegador para < 768px

---

## 💬 Resumo em uma frase

> *"Entregamos tudo que foi pedido no PDF Revisión Básica 1.1, plus reCAPTCHA funcional, reviews reais de Google (5.0/6), inputs visíveis em dark mode, prazo atualizado para 24-48h, botões minimalistas, redes sociais (Instagram, TikTok, X), logo nos emails, envio direto a Gmail, e upload de arquivos nos formulários. Só falta o cliente confirmar os preços e revisar o catalão."*

---

*Documento gerado automaticamente. Última atualização: 13/06/2026*
