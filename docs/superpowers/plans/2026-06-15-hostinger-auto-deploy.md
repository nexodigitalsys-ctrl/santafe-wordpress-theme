# Hostinger Auto-Deploy Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Configurar deploy automático via GitHub Actions para publicar o tema na pasta correta do WordPress em `santafe-construcciones.com` a cada push na `main`.

**Architecture:** Workflow GitHub Actions existente (`easingthemes/ssh-deploy`) será corrigido para apontar para o domínio e pasta corretos. Uma chave SSH dedicada será gerada no servidor, sua chave pública autorizada e a chave privada entregue ao usuário para cadastro no GitHub Secret `SSH_PRIVATE_KEY`.

**Tech Stack:** GitHub Actions, SSH/rsync, Hostinger shared hosting.

---

## File Structure

| File | Responsibility |
|------|----------------|
| `.github/workflows/deploy.yaml` | Workflow de deploy. Receberá apenas a correção do `TARGET`. |
| `~/.ssh/santafe_deploy_key` (servidor) | Chave privada SSH gerada para deploy. Nunca deve sair do servidor exceto para o GitHub Secret. |
| `~/.ssh/santafe_deploy_key.pub` (servidor) | Chave pública SSH a ser adicionada a `~/.ssh/authorized_keys`. |
| `~/.ssh/authorized_keys` (servidor) | Lista de chaves autorizadas a fazer login via SSH. |

---

## Task 1: Corrigir o destino do deploy no workflow

**Files:**
- Modify: `.github/workflows/deploy.yaml:22`

- [ ] **Step 1: Ler o workflow atual**

  Run:
  ```bash
  cat "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main/.github/workflows/deploy.yaml"
  ```

- [ ] **Step 2: Alterar o TARGET para o domínio e pasta corretos**

  Modify `.github/workflows/deploy.yaml` line 22:

  ```yaml
  TARGET: "domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/"
  ```

  A seção completa do deploy deve ficar assim:

  ```yaml
      - name: 🚀 Despliegue vía SFTP/SSH
        uses: easingthemes/ssh-deploy@main
        with:
          SSH_PRIVATE_KEY: ${{ secrets.SSH_PRIVATE_KEY }}
          REMOTE_HOST: ${{ secrets.SSH_HOST }}
          REMOTE_USER: ${{ secrets.SSH_USER }}
          REMOTE_PORT: 65002
          TARGET: "domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/"
          SOURCE: "/"
          ARGS: "-rlgoDzvc -i --delete"
          EXCLUDE: "/.github/, /.git/, /node_modules/, .gitignore, README.md"
  ```

- [ ] **Step 3: Commit e push**

  Run:
  ```bash
  cd "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main"
  git add .github/workflows/deploy.yaml
  git commit -m "ci: corrige destino do deploy para santafe-construcciones.com"
  git push origin main
  ```

---

## Task 2: Criar o diretório do tema no servidor

**Files:**
- Create directory: `/home/u526996563/domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/`

- [ ] **Step 1: Criar pasta com permissões corretas**

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "mkdir -p /home/u526996563/domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme && ls -la /home/u526996563/domains/santafe-construcciones.com/public_html/wp-content/themes/"
  ```

  Expected output: directory `santafe-wordpress-theme` listed with owner `u526996563`.

---

## Task 3: Gerar chave SSH dedicada no servidor

**Files:**
- Create: `~/.ssh/santafe_deploy_key` (private key, server-side)
- Create: `~/.ssh/santafe_deploy_key.pub` (public key, server-side)

- [ ] **Step 1: Verificar se a chave já existe**

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "ls -la ~/.ssh/santafe_deploy_key* 2>/dev/null || echo 'NENHUMA_CHAVE'"
  ```

  If keys already exist, skip generation and use existing ones.

- [ ] **Step 2: Gerar nova chave sem passphrase**

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "ssh-keygen -t ed25519 -C 'github-actions-deploy@santafe' -f ~/.ssh/santafe_deploy_key -N '' && ls -la ~/.ssh/santafe_deploy_key*"
  ```

  Expected output: two files, `santafe_deploy_key` and `santafe_deploy_key.pub`.

- [ ] **Step 3: Exibir a chave pública**

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "cat ~/.ssh/santafe_deploy_key.pub"
  ```

  Save the output. It looks like:
  ```
  ssh-ed25519 AAAAC3NzaC... github-actions-deploy@santafe
  ```

---

## Task 4: Autorizar a chave pública no servidor

**Files:**
- Modify: `~/.ssh/authorized_keys`

- [ ] **Step 1: Adicionar chave pública ao authorized_keys**

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "cat ~/.ssh/santafe_deploy_key.pub >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys && grep 'github-actions-deploy@santafe' ~/.ssh/authorized_keys"
  ```

  Expected output: the public key line is present in `authorized_keys`.

- [ ] **Step 2: Testar login com a nova chave**

  Copy the private key content to a temporary local file and test:

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "cat ~/.ssh/santafe_deploy_key" > /tmp/santafe_deploy_key
  chmod 600 /tmp/santafe_deploy_key
  ssh -i /tmp/santafe_deploy_key -p 65002 -o StrictHostKeyChecking=no u526996563@92.113.28.234 "hostname && pwd"
  rm -f /tmp/santafe_deploy_key
  ```

  Expected output: `santafe-construcciones.com` or server hostname, plus `/home/u526996563`.

---

## Task 5: Entregar chave privada ao usuário para cadastro no GitHub

**Files:**
- Read: `~/.ssh/santafe_deploy_key`

- [ ] **Step 1: Exibir a chave privada completa**

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "cat ~/.ssh/santafe_deploy_key"
  ```

  Expected output: starts with `-----BEGIN OPENSSH PRIVATE KEY-----` and ends with `-----END OPENSSH PRIVATE KEY-----`.

- [ ] **Step 2: Entregar instruções ao usuário**

  Tell the user to go to:
  ```
  https://github.com/nexodigitalsys-ctrl/santafe-wordpress-theme/settings/secrets/actions
  ```

  And create these secrets:

  | Secret name | Value |
  |-------------|-------|
  | `SSH_PRIVATE_KEY` | (paste the entire private key content displayed above) |
  | `SSH_HOST` | `92.113.28.234` |
  | `SSH_USER` | `u526996563` |
  | `DISCORD_WEBHOOK` | (existing webhook URL, or leave blank to skip Discord notification) |

  Important: paste the private key exactly, including `-----BEGIN OPENSSH PRIVATE KEY-----` and `-----END OPENSSH PRIVATE KEY-----`.

---

## Task 6: Testar o deploy automático

**Files:**
- Modify: any tracked file (e.g., `README.md` or `style.css`)

- [ ] **Step 1: Fazer uma alteração pequena e commitar**

  Example: add a blank line or update a comment in `style.css`.

  Run:
  ```bash
  cd "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main"
  echo "/* Deploy auto test */" >> style.css
  git add style.css
  git commit -m "chore: testa deploy automatico corrigido"
  git push origin main
  ```

- [ ] **Step 2: Aguardar o workflow e verificar status**

  Run:
  ```bash
  sleep 60
  ```

  Then check the Actions tab:
  ```
  https://github.com/nexodigitalsys-ctrl/santafe-wordpress-theme/actions
  ```

  Expected: workflow "Deploy Santa Fe Theme to Hostinger" runs and succeeds.

- [ ] **Step 3: Verificar arquivo no servidor**

  Run:
  ```bash
  sshpass -p '@I6p4p0a6' ssh -o StrictHostKeyChecking=no -p 65002 u526996563@92.113.28.234 \
    "tail -n 5 /home/u526996563/domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/style.css"
  ```

  Expected output: last line contains `/* Deploy auto test */`.

- [ ] **Step 4: Reverter a alteração de teste (opcional)**

  Run:
  ```bash
  cd "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main"
  git revert HEAD --no-edit
  git push origin main
  ```

---

## Task 7: Documentar conclusão

**Files:**
- Create or modify: `ENTREGA-DEPLOY-2026-06-15.md`

- [ ] **Step 1: Criar documento de entrega**

  Create `ENTREGA-DEPLOY-2026-06-15.md` with:

  ```markdown
  # Entrega: Deploy Automático Corrigido

  ## O que foi configurado

  - Workflow `.github/workflows/deploy.yaml` agora publica em `santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/`.
  - Chave SSH dedicada gerada no servidor e autorizada em `~/.ssh/authorized_keys`.
  - Secrets `SSH_PRIVATE_KEY`, `SSH_HOST` e `SSH_USER` cadastrados no GitHub.

  ## Como usar

  1. Faça alterações no tema localmente.
  2. Commit e push para a branch `main`:
     ```bash
     git add .
     git commit -m "sua mensagem"
     git push origin main
     ```
  3. O GitHub Actions faz deploy automaticamente em aproximadamente 1 minuto.
  4. Verifique o status em: https://github.com/nexodigitalsys-ctrl/santafe-wordpress-theme/actions

  ## Destino final

  ```
  /home/u526996563/domains/santafe-construcciones.com/public_html/wp-content/themes/santafe-wordpress-theme/
  ```
  ```

- [ ] **Step 2: Commit e push do documento**

  Run:
  ```bash
  cd "/home/jhin/Downloads/Sante fe Construcciones/santafe-wordpress-theme-main"
  git add ENTREGA-DEPLOY-2026-06-15.md
  git commit -m "docs: adiciona documento de entrega do deploy automatico"
  git push origin main
  ```

---

## Self-Review Checklist

- [ ] Spec requirement: deploy na pasta correta → Task 1 e Task 2
- [ ] Spec requirement: domínio correto → Task 1
- [ ] Spec requirement: a cada push na main → Task 1 (workflow trigger já existente)
- [ ] Spec requirement: chave SSH dedicada → Tasks 3 e 4
- [ ] Spec requirement: secrets cadastrados pelo usuário → Task 5
- [ ] Spec requirement: teste de deploy → Task 6
- [ ] Nenhum placeholder (TBD, TODO, etc.)
- [ ] Todos os comandos têm caminhos absolutos ou relativos claros
