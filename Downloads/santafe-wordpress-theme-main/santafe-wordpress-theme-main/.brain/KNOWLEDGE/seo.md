# 🔍 SEO — Estratégia Santa Fe

## Schemas Ativos

| Schema | Páginas | Arquivo |
|--------|---------|---------|
| LocalBusiness + ConstructionCompany | Todas | `schema-localbusiness.php` |
| AggregateRating (5.0/5, 6 reviews) | Todas | `schema-reviews.php` |
| FAQPage | Home, Serviços | `schema-faq.php` |
| Service | Páginas de serviço | `schema-services.php` |
| BreadcrumbList | Service, Contacto, Garantias | `functions.php` (renderBreadcrumb) |

## Metadados por Rota

Definidos em `includes/seo.php` — função `santafe_get_seo_data()`.

## hreflang

```html
<link rel="alternate" hreflang="es_ES" href=".../es/...">
<link rel="alternate" hreflang="ca_ES" href=".../ca/...">
<link rel="alternate" hreflang="x-default" href=".../es/...">
```

## Sitemap

- Gerado em `functions.php` → `generateSitemap()`
- Prioridades: Home (1.0), Contacto (0.9), Serviços (0.8), Local (0.7)

## Oportunidades

1. Integrar Google Reviews real (API) para schema dinâmico
2. Adicionar `SearchAction` schema quando `/buscar` existir
3. Criar páginas de cidade (SEO local) — já existem rotas no router
4. Blog: adicionar `Article` schema nos posts

---

_Atualizado: 2026-05-18_
