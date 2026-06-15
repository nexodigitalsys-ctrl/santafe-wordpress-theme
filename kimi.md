# 🧠 kimi.md — Instruções Permanentes para IA

> **LEIA ESTE ARQUIVO ANTES DE QUALQUER AÇÃO.**  
> Toda sessão inicia aqui. Sem exceções.

---

## 🚨 REGRA #1 — SE NÃO SABE, PERGUNTE

- **NUNCA** suponha detalhes que o usuário não confirmou.
- **NUNCA** preencha lacunas com valores genéricos ou placeholders.
- **SEMPRE** pergunte antes de criar, modificar ou configurar algo que tenha mais de uma interpretação possível.

## 🚫 REGRA #2 — NÃO INVENTE O QUE NÃO FOI PEDIDO

- Faça apenas o que foi solicitado.
- Não adicione features, arquivos ou dependências "por conta própria".
- Se uma ideia de melhoria surgir, **sugira ao usuário** antes de implementar.

## ✅ REGRA #3 — VERIFIQUE ANTES DE ENTREGAR

1. Leia o que foi pedido.
2. Implemente a mudança mínima necessária.
3. Teste/verifique se funciona (build, render, lógica, integração).
4. Confirme que não quebrou nada existente.
5. Só então considere a tarefa entregue.

## 🧠 REGRA #4 — USE O `.brain/` COMO ORQUESTRADOR CENTRAL

- **Consulte** `.brain/ORQUESTRADOR.md` antes de tarefas grandes.
- **Siga** as personalidades definidas em `.brain/AGENTES.md`.
- **Revise** com `.brain/REVISOR.md` antes de entregar.
- **Documente** decisões em `.brain/MEMORIA/`.

### Pastas do brain local:
```
.brain/
├── README.md          # Contexto do projeto Santa Fe
├── ORQUESTRADOR.md    # Como escolher agentes/personalidades
├── AGENTES.md         # Personalidades disponíveis
├── REVISOR.md         # Checklist de qualidade pré-entrega
├── MEMORIA/
│   ├── decisoes.md    # Decisões arquiteturais
│   ├── bugs.md        # Bugs conhecidos e resolvidos
│   └── sessoes/       # Logs de sessão (YYYY-MM-DD.md)
└── KNOWLEDGE/
    ├── stack.md       # Stack técnico do projeto
    ├── auditoria.md   # Auditoria .BRAIN completa
    └── seo.md         # Estratégia SEO
```

## 📝 REGRA #5 — DOCUMENTE NO BRAIN

- **Cada sessão significativa** deve deixar rastro em `.brain/MEMORIA/sessoes/YYYY-MM-DD.md`.
- **Registre** decisões, bugs encontrados, padrões descobertos.
- **Use frontmatter YAML** em notas importantes:
  ```yaml
  ---
  created: 2026-05-18
  tags: [bugfix, wordpress, session]
  status: done
  related: [[outra-nota]]
  ---
  ```

## 🐛 REGRA #6 — BUG DETECTOR PRO É FERRAMENTA EXISTENTE

> O Bug Detector já está injetado no tema (`header.php`).  
> Dashboard: `http://localhost:4567` (PM2 auto-restart).

- Não crie um bug detector novo.
- Se o usuário pedir para debugar, use o existente.

---

## 🎯 COMO CRIAR UM NOVO `kimi.md`

Se você estiver criando um `kimi.md` para outro projeto:

1. **Copie este arquivo** como base.
2. **Adapte a seção #4** para refletir a estrutura do projeto.
3. **Adapte a seção #6** se houver ferramentas específicas.
4. **Mantenha as 6 regras** — elas são universais.
5. **Adicione regras específicas** do domínio (React, PHP, etc.) no `.brain/AGENTES.md`, não aqui.

---

## 🔗 LINKS RÁPIDOS

| Recurso | Caminho |
|---------|---------|
| Brain remoto (Nexo Digital) | `https://github.com/Jhin1v9/principal-brain` |
| Brain local | `./.brain/README.md` |
| Orquestrador | `./.brain/ORQUESTRADOR.md` |
| Agentes | `./.brain/AGENTES.md` |
| Revisor | `./.brain/REVISOR.md` |

---

_Atualizado: 2026-05-18_  
_Versão: 1.0 — Sem suposições. Apenas perguntas, verificação e documentação._
