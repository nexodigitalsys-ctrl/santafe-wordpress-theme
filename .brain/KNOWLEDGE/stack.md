# 🛠️ Stack Técnico — Santa Fe

## Core

| Tecnologia | Versão | Uso |
|-----------|--------|-----|
| PHP | 8.3+ | Backend, templates |
| WordPress | Última | CMS |
| Tailwind CSS | v4 | Estilos |
| Vanilla JS | ES6+ | Interatividade |

## Fontes

- **Inter** — Body text (300-900)
- **Space Grotesk** — Display/headings

## Cores do Design System

```css
--color-brand-500: #AE232A;   /* Vermelho coral — primária */
--color-brand-600: #991B1B;   /* Vermelho escuro — hover */
--color-brand-400: #f87171;   /* Vermelho claro — accents */
--color-slate-950: #020617;   /* Fundo principal (quase preto) */
--color-slate-900: #0f172a;   /* Fundo secundário */
--color-slate-800: #1e293b;   /* Cards, bordas */
--color-slate-400: #94a3b8;   /* Texto secundário */
--color-slate-300: #cbd5e1;   /* Texto primário */
```

## Breakpoints (Tailwind)

- `sm:` — 640px
- `md:` — 768px
- `lg:` — 1024px
- `xl:` — 1280px
- `2xl:` — 1536px

## Scripts JS

| Arquivo | Propósito |
|---------|-----------|
| `utils.js` | Core utilities |
| `premium-interactions.js` | Scroll reveal, counters, slider |
| `slider.js` | Before/After slider |
| `navigation.js` | Menu mobile, scroll spy |
| `forms.js` | Form validation, AJAX |
| `main.js` | Inicialização geral |
| `embla-carousel.umd.js` | Carousel de depoimentos |
| `bug-detector.iife.js` | Bug detector (dev only) |

## i18n

- ES: `lang/es.json`
- CA: `lang/ca.json`
- Função: `load_translations($lang)` em `includes/i18n.php`

---

_Atualizado: 2026-05-18_
