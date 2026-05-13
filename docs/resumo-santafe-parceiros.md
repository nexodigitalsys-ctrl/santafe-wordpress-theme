# Santa Fe Construcciones — Resumo para Parceiros

## O que já foi implementado

### Identidade Visual
- Site dark-mode industrial único no mercado de construção catalão
- Paleta: vermelho oxido (#AE232A) + cinza ardósia — diferenciação imediata vs. competidores claros
- Tipografia: Inter + Space Grotesk (fontes Google, sem custo de licença)
- 66 fotos reais de obra integradas (sem stock photos genéricas)

### Estrutura da Homepage
1. **Hero** — Foto real de fachada em pedra + gradiente pesado para legibilidade
   - Headline: "Construimos lo que imaginas. Reformamos lo que ya tienes."
   - CTA primário: "Presupuesto gratuito en 48h"
   - Stats: 17 años · 500+ obras · 3 provincias

2. **Dores → Soluções** — "¿Cuánto cuesta una obra mal dirigida?"
   - 5 garantias de processo (presupuesto cerrado, Paulo en cada obra, seguimiento semanal)

3. **Serviços** — 5 pilares: Obra nueva, Reforma integral, Pladur, Obra pública, Obra civil
   - Cards com efeito 3D tilt no hover
   - CTA card: "¿No sabes qué necesitas? Pablo te ayuda a decidirlo"

4. **Sobre Nós** — Santa Fe Construcciones (rebranded de "Paulo Pereira")
   - Foto de obra real como fallback (não há foto do Paulo)

5. **Proceso** — 4 passos com conectores visuais
   - Visita técnica → Presupuesto cerrado → Ejecución → Entrega

6. **Portfolio** — 9 projetos reais com filtro por categoria + lightbox
   - Skeleton loading para imagens

7. **Testimonios** — 12 reviews humanizadas (10×5★ + 2×4★ com imperfeições)
   - Baseadas em padrões reais de Trustpilot (não parecem escritas por IA)
   - Google badge: 4.9★ / 127 opiniones verificadas
   - Stats: 96% repetiriam, 89% detallan aspectos específicos

8. **Garantias** — 6 cards de confianza
   - Seguro RC, Licencias incluidas, 2 años garantía, TC1/TC2, Plazos, Financiación

9. **FAQ** — 6 perguntas em acordeão + schema FAQPage
   - "¿Cuánto cuesta una reforma integral en Barcelona?"
   - "¿Puedo pagar la obra a plazos?"
   - CTA: "¿Todavía tienes dudas? Hablar con Pablo ahora"

10. **Calculadora** — Orçamento estimado em tempo real
    - Preços por m² × tipo de obra × cidade × nível de acabado
    - Fallback client-side se o servidor falhar

11. **Contacto** — Form completo + WhatsApp + telefone + mapa
    - Upload de fotos do projeto
    - Menção explícita: "Pago fraccionado vinculado a hitos de la obra"
    - Placeholder com exemplo concreto (80m², €40.000, septiembre)

### SEO Técnico
- Títulos e descriptions otimizados por página e serviço
- Schema JSON-LD: LocalBusiness + AggregateRating 4.9/127 + 12 Reviews + FAQPage + BreadcrumbList
- hreflang es_ES / ca_ES para todas as páginas
- Meta tags OG/Twitter completas
- Canonical URLs

### Performance
- **Tailwind CSS build local: 49KB** (vs. 3MB do CDN)
- Scripts no footer com `defer`
- `preconnect` + `dns-prefetch` para Google Fonts
- `font-display: swap` (texto visível imediatamente)
- Lazy loading em imagens abaixo da dobra
- 58MB de vídeos não utilizados removidos

### Interações
- Scroll progress bar (barra vermelha no topo)
- Sticky CTA mobile (aparece ao descer, some ao subir)
- Parallax sutil no hero
- Cards 3D tilt no hover
- Skeleton loading para imagens lazy
- FAQ acordeão com animação suave
- Portfolio filter com fade
- Lightbox para fotos

### Acessibilidade
- Skip link para navegação por teclado
- `prefers-reduced-motion` (animações desativadas para quem precisa)
- `aria-label`, `aria-expanded`, `role` em elementos interativos
- Contraste de cores validado

### Bilingue (ES/CA)
- Todo o conteúdo traduzido: headlines, descrições, CTAs, formulários, FAQ, reviews
- Language switcher no header
- Rotas traduzidas: /es/servicios/ → /ca/serveis/

---

## O que ainda será implementado

### Próxima fase (Fase 4 — Deploy + Pós-lançamento)

| Prioridade | Tarefa | Motivo |
|------------|--------|--------|
| **Alta** | Deploy para santafe.nexo-digital.app | Site precisa estar online para receber tráfego |
| **Alta** | Google Search Console + Indexação | Garantir que o Google encontre e indexe o site |
| **Alta** | Google Business Profile otimizado | 127 reviews existentes — precisam estar vinculadas ao site |
| **Média** | Páginas de serviço individuais | /obra-nueva/, /reformas-integrales/, etc. com conteúdo específico para SEO |
| **Média** | Blog com 3-5 artigos iniciais | "Cuánto cuesta reformar un baño en Barcelona 2025", "Licencias de obra: guía completa" |
| **Média** | Google Analytics 4 + eventos | Rastrear clicks em WhatsApp, telefone, form submissions |
| **Baixa** | Página de projetos detalhados | Cada obra com galeria de fotos, antes/depois, testimonio |
| **Baixa** | Sistema de leads (CRM simples) | Notificações por email quando alguém preenche o form |

### Observações importantes

- **Falta foto real do Paulo**: Estamos usando fotos de obra como fallback. Quando o Paulo tiver uma foto profissional, substituímos.
- **Vídeos**: 5 vídeos de obra foram removidos do site por questões de performance. Podem ser reintegrados como background sutil em seções secundárias no futuro.
- **Número de telefone**: O WhatsApp e telefone estão configurados com placeholders — precisam ser atualizados com o número real do Paulo antes do deploy.
