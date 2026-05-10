# Knowledge Base IT v5 — Guía de Despliegue

## Qué se mantiene del original (NO se toca)

- ✅ Tabla `documents` con todo el texto extraído de los PDFs (cargado via `carga_total.sql`)
- ✅ Tabla `search_history`, `ai_interactions`, `users`
- ✅ Stored procedures: `sp_search_documents`, `sp_log_search`, `sp_get_most_searched`, `sp_get_recent_searches`
- ✅ Credenciales de BD (mismas que config_v4)
- ✅ Cookie de sesión (misma que v4 — no cierra sesiones activas)
- ✅ Endpoints de Gemini API (v1 + v1beta fallback)
- ✅ Login con hash bcrypt

## Qué cambia (mejoras)

### Seguridad
- **API Key de Gemini** movida de `ask_ai.php` a `config_v5.php` (ya no visible en el código frontend)
- **CSRF tokens** en todas las peticiones POST
- **Rate limiting** en login: 5 intentos → bloqueo 15 min por IP
- **Session hardening**: regeneración periódica de ID, timeout 8h, HttpOnly, Secure, SameSite
- **.htaccess reforzado**: HTTPS forzado, CSP headers, HSTS, bloqueo SQL injection en URL
- **Auditoría**: login, búsquedas, consultas IA, todo queda registrado en `audit_log`
- **DEBUG_MODE = false** por defecto
- `SSL_VERIFYPEER = true` en cURL hacia Gemini

### Nuevas páginas (navegación por sidebar)
1. **Dashboard** — Buscador + respuesta IA + resultados en manuales
2. **Guardadas** — Búsquedas favoritas con categorías (General, Red, Software, Hardware, SIGES, TPV)
3. **Historial IA** — Todas las consultas con paginación
4. **Documentos** — Lista de procedimientos ITI indexados con visor de texto extraído
5. **Estadísticas** — Contadores + top búsquedas
6. **Admin** — Gestión usuarios + roles + log auditoría

### Formato de respuesta IA (adaptado a procedimientos ITI)
Gemini responde con estructura helpdesk:
- Diagnóstico → Causa Probable → Pasos de Resolución → Verificación → Escalado → Documentos

### Copiar en 3 formatos (para pegar en formularios internos)
- **Texto plano** — sin formato, listo para formularios
- **Markdown** — para wikis/documentación
- **Formato Ticket** — con cabecera, fecha, técnico, consulta

---

## Instrucciones de despliegue en Hostinger

### PASO 1: Base de datos (solo añadir tablas nuevas)
1. Abre phpMyAdmin en Hostinger
2. Selecciona tu BD `u526996563_knowledge_base`
3. Pestaña SQL → Pega el contenido de `database_v5.sql`
4. Ejecuta

Esto SOLO añade:
- `login_attempts` (rate limiting)
- `saved_searches` (favoritos)
- `audit_log` (auditoría)
- Columna `role` en `users`

**No toca** las tablas `documents`, `search_history`, `ai_interactions` ni los stored procedures.

### PASO 2: Subir archivos
Sube estos archivos a tu ruta en Hostinger (ej: `public_html/knowledge-base/`):

```
├── .htaccess              ← REEMPLAZA el existente
├── config_v5.php          ← NUEVO (reemplaza config_v4.php)
├── index.php              ← REEMPLAZA el existente
├── css/
│   └── dashboard.css      ← REEMPLAZA style.css
├── js/
│   └── app.js             ← REEMPLAZA app_v4_final.js
├── api/
│   ├── login.php          ← REEMPLAZA
│   ├── search.php         ← REEMPLAZA
│   ├── ask_ai.php         ← REEMPLAZA
│   ├── most-searched.php  ← REEMPLAZA
│   ├── ai-history.php     ← REEMPLAZA
│   ├── stats.php          ← NUEVO (reemplaza get_stats.php)
│   ├── saved-searches.php ← NUEVO
│   ├── users.php          ← NUEVO
│   └── documents.php      ← NUEVO
└── logs/                  ← ya existe
```

### PASO 3: Verificar config_v5.php
- Las credenciales de BD ya son las mismas
- La API key de Gemini ya está incluida
- `FORCE_HTTPS` → `true` (Hostinger tiene SSL)

### PASO 4: Primer acceso
- Usa tus credenciales existentes (admin/admin123 o lo que hayas cambiado)
- El login funciona exactamente igual, solo con protección extra

### PASO 5: Archivos que puedes eliminar del servidor (opcionales)
- `config.php` y `config_v4.php` (reemplazados por `config_v5.php`)
- `js/app_v4_final.js` y `js/app.js` antiguo
- `css/style.css` (reemplazado por `dashboard.css`)
- `api/get_stats.php`, `api/doc-count.php`, `api/history.php`, `api/top-searches.php` (integrados en v5)
- Carpetas `test_api/`, `BBDD_Hostinger/` (datos sensibles, no deben estar en servidor)
