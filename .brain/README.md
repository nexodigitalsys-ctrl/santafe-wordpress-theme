# .BRAIN — Santa Fe Construcciones

> Base operacional do projeto Santa Fe. Orquestrada por IA.

---

## 📋 PROJETO

**Nome:** Santa Fe Construcciones  
**Cliente:** Construcciones Santa Fe Siglo XXI SLU  
**Responsável:** Paulo (Fundador)  
**Equipe Nexo:** Elias, Jhin, Enoque  
**Site:** https://santafe.nexo-digital.app  

---

## 🏗️ STACK

| Camada | Tecnologia |
|--------|-----------|
| CMS | WordPress (tema custom) |
| Backend | PHP 8.3+ |
| Estilos | Tailwind CSS v4 |
| Scripts | Vanilla JS |
| Router | Custom (`santafe-wp-router.php`) |
| i18n | ES/CA via JSON |
| Deploy | Git webhook → Hostinger |

---

## 📁 ESTRUTURA DE PASTAS

```
assets/
  css/          # Tailwind built + input
  js/           # Premium interactions, slider, forms, navigation
  images/       # Fotos reais das obras (WebP)
  videos/       # Vídeos de obras (MP4)
includes/
  header.php    # Header semântico + CSS inline crítico
  footer.php    # Footer + Cookie Banner
  functions.php # Helpers, SEO, breadcrumbs
  seo.php       # Metadados por rota
  schema-*.php  # Schemas JSON-LD
pages/
  home.php                    # Homepage
  service-template.php        # Template reutilizável de serviço
  contacto.php                # Formulário de contato
  garantias.php               # Página de garantías
  obra-nueva.php              # (usa service-template)
  reformas-integrales.php     # (usa service-template)
  pladur-acabados.php         # (usa service-template)
  obra-publica.php            # (usa service-template)
  obra-civil.php              # (usa service-template)
  blog.php                    # Blog
  proyectos.php               # Galeria de projetos
  sobre-nosotros.php          # Sobre nós
  partials/                   # Seções reutilizáveis
    section-hero.php
    section-servicos.php
    section-paulo.php
    section-proceso.php
    section-portfolio.php
    section-before-after.php
    section-testimonios.php
    section-google-reviews.php
    section-garantias.php
    section-faq.php
    section-calculadora.php
    section-contacto.php
config/
  constants.php     # COMPANY_DOMAIN, WHATSAPP_NUMBER, etc.
  services-data.php # Dados dos 5 serviços
lang/
  es.json           # Traduções ES
  ca.json           # Traduções CA
data/
  reviews.json      # 12 reviews reais
```

---

## 🚀 DEPLOY

**Pasta na Hostinger:**
```
public_html/wp-content/themes/santafe-wordpress-theme/
```

**Webhook:** GitHub → Hostinger (auto-deploy no push para `main`)

---

## 📊 ESTADO ATUAL

### Fase 1 — Vitórias Rápidas ✅
- [x] Conteúdo invisível mobile corrigido
- [x] Formulário simplificado (3 campos obrigatórios)
- [x] CTAs após prova social
- [x] Schema review corrigido (127 → 12)
- [x] Badges de garantia no hero

### Fase 2 — Melhorias de Conversão ✅
- [x] Perfil do Paulo (section-paulo.php)
- [x] Alternador de idioma no menu mobile

### Fase 3 — Diferenciação Competitiva ✅
- [x] USP no Before/After
- [x] Processo 5 passos + CTA
- [x] Página de garantias dedicada
- [x] Breadcrumbs visuais + schema
- [x] Google Reviews widget

---

## 🧠 REGRAS DO BRAIN

1. **NUNCA** entregue código quebrado ou incompleto
2. **NUNCA** use placeholders genéricos — use dados REAIS do projeto
3. **NUNCA** ignore o contexto do `.brain/`
4. **SEMPRE** documente decisões em `.brain/MEMORIA/`
5. **SEMPRE** revise com `.brain/REVISOR.md` antes de entregar

---

_Atualizado: 2026-05-18_
