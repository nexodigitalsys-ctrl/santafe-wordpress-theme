# Entrega: Deploy Automático Corrigido para Hostinger

## Status

✅ **Deploy automático funcionando corretamente.**

Todo `git push` na branch `main` do GitHub agora publica automaticamente o tema na pasta correta do WordPress em `santafe-construcciones.com`.

## O que foi configurado

- **Integração Git nativa do Hostinger** configurada no hPanel em:
  - `hPanel → Websites → santafe-construcciones.com → Advanced → Git`
- **Repositório:** `https://github.com/nexodigitalsys-ctrl/santafe-wordpress-theme/`
- **Rama:** `main`
- **Directorio de instalación:** `wp-content/themes/santafe-wordpress-theme`
- **Webhook do Hostinger** configurado no GitHub para disparar a cada push.

## Destino final correto

```
/home/u526996563/domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/
```

## Problemas resolvidos

1. **Deploy indo para domínio errado:** antes apontava para `santafe.nexo-digital.app`.
2. **Pasta do tema errada:** antes usava `santafe` em vez de `santafe-wordpress-theme`.
3. **Rota duplicada `public_html/public_html/`:** a configuração anterior usava `public_html/wp-content/...`, o que fazia o Hostinger criar uma pasta `public_html` dentro de `public_html`. Corrigido para `wp-content/themes/santafe-wordpress-theme`.
4. **Pasta antiga removida:** a pasta duplicada `public_html/public_html/` foi apagada para evitar confusão.
5. **Workflow do GitHub Actions removido:** `.github/workflows/deploy.yaml` foi removido porque o Hostinger bloqueava conexões SSH vindas dos runners do GitHub Actions (`Connection timed out`).

## Como usar

1. Faça alterações no tema localmente.
2. Commit e push para a branch `main`:
   ```bash
   git add .
   git commit -m "sua mensagem"
   git push origin main
   ```
3. O Hostinger recebe o webhook e faz deploy automaticamente em alguns segundos.
4. Verifique o status em `hPanel → Advanced → Git`.

## Testes realizados

- ✅ Commit de teste adicionando `style.css` chegou na pasta correta.
- ✅ Commit de teste removendo `style.css` removeu o arquivo da pasta correta (deploy automático funcionando).
- ✅ Site `https://santafe-construcciones.com/` continua online (HTTP 200).

## Notas

- Não é mais necessário acessar SSH manualmente para fazer deploy.
- O deploy depende do webhook do Hostinger; se o GitHub ou Hostinger tiverem instabilidade, o deploy pode atrasar.
- O site usa cache (LiteSpeed/Cloudflare); em alguns casos pode ser necessário limpar o cache após o deploy para ver mudanças imediatas.
