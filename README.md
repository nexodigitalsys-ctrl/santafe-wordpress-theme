# Santa Fe Tailwind Theme

Tema WordPress da Construcciones Santa Fe — convertido desde template PHP/Tailwind original.

**Preview:** https://santafe.nexo-digital.app/es/

## Stack

- PHP 8.3+
- Tailwind CSS v4 (CDN)
- Vanilla JS
- WordPress custom router
- i18n: ES/CA via JSON

## Estrutura de pastas

```text
assets/images/      # Fotos reais das obras (WebP)
assets/videos/      # Vídeos de obras (MP4)
assets/css/         # Estilos custom
assets/js/          # Scripts
includes/           # Funções, schemas, SEO
pages/              # Templates de páginas
pages/partials/     # Seções reutilizáveis
lang/               # Traduções ES/CA
config/             # Constantes e dados
```

## Deploy

**Pasta na Hostinger:**
```text
public_html/wp-content/themes/santafe-wordpress-theme/
```

**Deploy automático via Git webhook:**
- Repositório: `nexodigitalsys-ctrl/santafe-wordpress-theme`
- Branch: `main`
- Webhook Hostinger configurado no GitHub

## Atualizações recentes

- **Fotos reais integradas** — 31 fotos de obras do cliente convertidas para WebP
- **Imagens OG geradas** — 18 imagens JPG para redes sociais
- **Cache LiteSpeed** — desativado para desenvolvimento
- **Git webhook** — deploy automático ativado
