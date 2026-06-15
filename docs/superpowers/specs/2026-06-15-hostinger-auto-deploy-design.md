# Design: Deploy Automático Corrigido para Hostinger

## Contexto

O repositório `santafe-wordpress-theme` possui um workflow de deploy em `.github/workflows/deploy.yaml`, mas ele está configurado para publicar no domínio errado (`santafe.nexo-digital.app`) e em uma pasta de tema com nome incorreto (`santafe`).

No servidor Hostinger, a instalação WordPress real do domínio de produção está em:

```
/home/u526996563/domains/santafe-construcciones.com/public_html/
```

O tema deve ser publicado em:

```
/home/u526996563/domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/
```

> Nota: existe uma pasta git duplicada em `public_html/public_html/wp-content/themes/santafe-wordpress-theme/`, criada por deploys anteriores incorretos. Ela não será mais usada como destino oficial.

## Objetivo

Garantir que todo `git push` na branch `main` do GitHub publique automaticamente o tema na pasta correta do WordPress em produção, sem necessidade de acesso manual ao servidor.

## Decisões de Design

### Domínio de produção

- **Domínio:** `santafe-construcciones.com`
- **Não usar mais:** `santafe.nexo-digital.app` como destino principal

### Nome da pasta do tema

- **Pasta no servidor:** `santafe-wordpress-theme` (mesmo nome do repositório)
- **Motivo:** corresponde ao slug do tema no WordPress e ao nome do repositório, evitando confusão.

### Método de deploy

- **GitHub Actions com rsync via `easingthemes/ssh-deploy@main`**
- A action faz checkout do código e sincroniza os arquivos via rsync/SSH para o Hostinger.

### Fluxo

1. Desenvolvedor executa `git push` na branch `main`.
2. GitHub Actions dispara o workflow `deploy.yaml`.
3. O job faz checkout do repositório.
4. A action `ssh-deploy` sincroniza o conteúdo do repositório para o diretório do tema no servidor usando rsync.
5. Uma notificação é enviada ao Discord com o status do deploy.

## Alterações Necessárias

### 1. `.github/workflows/deploy.yaml`

Atualizar o campo `TARGET` para o caminho correto:

```yaml
TARGET: "domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/"
```

Manter:

- `SOURCE: "/"`
- `ARGS: "-rlgoDzvc -i --delete"`
- `EXCLUDE: "/.github/, /.git/, /node_modules/, .gitignore, README.md"`
- Notificação Discord com status

### 2. Secrets do GitHub

Cadastrar em **Settings > Secrets and variables > Actions**:

| Secret | Valor / Descrição |
|--------|-------------------|
| `SSH_PRIVATE_KEY` | Chave privada SSH que permite acesso ao Hostinger |
| `SSH_HOST` | `92.113.28.234` |
| `SSH_USER` | `u526996563` |
| `DISCORD_WEBHOOK` | URL do webhook do Discord (já deve existir) |

### 3. Chave SSH no Hostinger

Será gerado um par de chaves SSH no servidor (sem passphrase) e a chave pública será adicionada ao `~/.ssh/authorized_keys` do usuário `u526996563`. A chave privada será fornecida ao usuário para cadastrar no GitHub secret `SSH_PRIVATE_KEY`.

## Segurança

- A chave privada fica apenas no GitHub Secrets; nunca no código.
- O acesso SSH usa a porta `65002`.
- O rsync usa `--delete`, garantindo que arquivos removidos no repositório também sejam removidos no servidor.
- A chave SSH será restrita a esse deploy (recomenda-se não reusar chaves pessoais).

## Tratamento de Erros

| Cenário | Comportamento |
|---------|---------------|
| Secrets não configurados | Workflow falha no início |
| SSH rejeitado | Workflow falha; notificação de erro no Discord |
| Diretório não existe no servidor | rsync cria automaticamente |
| Arquivos removidos no repo | rsync remove do servidor (`--delete`) |
| Deploy bem-sucedido | Notificação de sucesso no Discord |

## Critérios de Sucesso

- [ ] Workflow `.github/workflows/deploy.yaml` aponta para `santafe-construcciones.com` na pasta `santafe-wordpress-theme`.
- [ ] Chave SSH gerada no servidor e chave pública configurada em `authorized_keys`.
- [ ] Secrets `SSH_PRIVATE_KEY`, `SSH_HOST` e `SSH_USER` cadastrados no GitHub pelo usuário.
- [ ] Após um `git push` na `main`, o arquivo alterado aparece no servidor em até 2 minutos.
- [ ] Notificação Discord é enviada com status do deploy.

## Notas

- O deploy não limpa cache do WordPress automaticamente. Se o site usar cache (LiteSpeed, Cloudflare, etc.), pode ser necessário limpar manualmente após o deploy.
- A pasta `public_html/public_html/...` antiga não será removida neste trabalho para evitar risco; apenas deixará de ser o destino oficial.
