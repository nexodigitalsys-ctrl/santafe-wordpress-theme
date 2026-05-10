<?php
/**
 * KNOWLEDGE BASE v5 - MAIN ENTRY
 * Basado en index.php original — mantiene login inline + dashboard
 */
error_reporting(0);
require_once 'config_v5.php';

// Handle logout (mismo que v4)
if (isset($_GET['logout'])) {
    audit('logout', $_SESSION['username'] ?? '');
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

$is_auth = is_authenticated();
$user = $is_auth ? get_current_user_array() : null;
$csrf = csrf_token();

// Nonce para CSP — generado por request, permite el bloque <script> inline sin unsafe-inline global
$csp_nonce = base64_encode(random_bytes(16));
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-src 'none'; object-src 'none';");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/dashboard.css?v=5.0">
</head>
<body class="<?php echo $is_auth ? 'app-body' : 'login-body'; ?>">

<?php if (!$is_auth): ?>
<!-- ═══════════════════════ LOGIN (basado en el original) ═══════════════════════ -->
<div class="login-shell">
    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0110 0v4"></path></svg>
            </div>
            <h1>Knowledge Base IT</h1>
            <p>Acceso al panel de soporte</p>
        </div>
        <form id="loginForm" method="post" onsubmit="return handleLogin(event)">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <div class="field">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required autocomplete="username" autofocus>
            </div>
            <div class="field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-primary full" id="loginBtn">Acceder</button>
            <div id="loginError" class="form-error" style="display:none"></div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ═══════════════════════ APP SHELL ═══════════════════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="brand-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </span>
        <span class="brand-text">KB IT <small>v5</small></span>
    </div>

    <nav class="sidebar-nav">
        <a href="#" class="nav-item active" data-page="dashboard">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect></svg>
            <span>Dashboard</span>
        </a>
        <a href="#" class="nav-item" data-page="saved">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"></path></svg>
            <span>Guardadas</span>
        </a>
        <a href="#" class="nav-item" data-page="history">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Historial IA</span>
        </a>
        <a href="#" class="nav-item" data-page="documents">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            <span>Documentos</span>
        </a>
        <a href="#" class="nav-item" data-page="stats">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
            <span>Estadísticas</span>
        </a>
        <a href="#" class="nav-item" data-page="admin">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"></path></svg>
            <span>Admin</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-badge">
            <span class="user-avatar"><?php echo strtoupper(substr($user['username'],0,1)); ?></span>
            <span class="user-name"><?php echo htmlspecialchars($user['username']); ?></span>
        </div>
        <a href="?logout=1" class="nav-item logout-link" title="Cerrar sesión">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            <span>Salir</span>
        </a>
    </div>
</aside>

<main class="main-content" id="mainContent">
    <header class="top-bar">
        <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        <h2 class="page-title" id="pageTitle">Dashboard</h2>
        <div class="top-bar-right">
            <span class="doc-badge" id="docBadge" title="Procedimientos ITI indexados">0 docs</span>
        </div>
    </header>

    <!-- ══════ PAGE: DASHBOARD ══════ -->
    <div class="page active" id="page-dashboard">
        <div class="search-hero">
            <h2>¿Qué incidencia necesitas resolver?</h2>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Describe el problema o código ITI..." autocomplete="off">
                <button class="btn-primary" onclick="KB.search()">Buscar</button>
            </div>
        </div>

        <div class="ai-response-card" id="aiCard" style="display:none">
            <div class="ai-card-header">
                <span class="ai-label">Solución IA — Gemini 2.5 Flash</span>
                <div class="ai-actions">
                    <select id="copyFormat" class="select-sm">
                        <option value="plain">Texto plano</option>
                        <option value="markdown">Markdown</option>
                        <option value="ticket">Formato Ticket</option>
                    </select>
                    <button class="btn-sm" onclick="KB.copyAI()">Copiar</button>
                    <button class="btn-sm btn-accent" onclick="KB.saveSearch()">Guardar</button>
                </div>
            </div>
            <div id="aiContent" class="ai-content-body"></div>
            <div id="relatedDocs" class="related-pdfs" style="display:none">
                <h4>Documentos relacionados</h4>
                <div id="docLinks" class="pdf-links"></div>
            </div>
        </div>

        <div class="dashboard-grid">
            <section class="card results-card">
                <h3 class="card-title">Procedimientos ITI relacionados</h3>
                <div id="resultsContainer" class="results-list">
                    <p class="muted">Los resultados aparecerán aquí</p>
                </div>
            </section>
            <aside class="card sidebar-card">
                <h3 class="card-title">Más buscados</h3>
                <div id="topSearches" class="history-list"><p class="muted">Cargando...</p></div>
                <h3 class="card-title mt">Historial reciente</h3>
                <div id="recentAI" class="history-list"><p class="muted">Cargando...</p></div>
            </aside>
        </div>
    </div>

    <!-- ══════ PAGE: SAVED ══════ -->
    <div class="page" id="page-saved">
        <div class="page-header">
            <h2>Búsquedas guardadas</h2>
            <div class="page-actions">
                <input type="text" id="savedFilter" class="input-sm" placeholder="Filtrar..." oninput="KB.filterSaved()">
                <select id="savedCategory" class="select-sm" onchange="KB.loadSaved()">
                    <option value="">Todas</option>
                    <option value="General">General</option>
                    <option value="Red">Red</option>
                    <option value="Software">Software</option>
                    <option value="Hardware">Hardware</option>
                    <option value="SIGES">SIGES</option>
                    <option value="TPV">TPV</option>
                </select>
            </div>
        </div>
        <div id="savedList" class="saved-grid"><p class="muted">Sin búsquedas guardadas</p></div>
    </div>

    <!-- ══════ PAGE: HISTORY ══════ -->
    <div class="page" id="page-history">
        <div class="page-header">
            <h2>Historial de consultas IA</h2>
            <button class="btn-sm btn-danger" onclick="KB.clearHistory()">Limpiar historial</button>
        </div>
        <div id="historyList" class="history-full-list"><p class="muted">Cargando...</p></div>
        <div class="pagination" id="historyPagination"></div>
    </div>

    <!-- ══════ PAGE: DOCUMENTS (texto extraído de la BD, no PDFs) ══════ -->
    <div class="page" id="page-documents">
        <div class="page-header">
            <h2>Documentos indexados</h2>
            <span class="muted" id="docTotal"></span>
        </div>
        <div class="doc-filter-bar">
            <input type="text" id="docFilter" class="input-sm" placeholder="Filtrar por nombre..." oninput="KB.filterDocs()">
        </div>
        <div id="docsList" class="docs-table"><p class="muted">Cargando documentos...</p></div>

        <!-- Visor de contenido del documento (texto extraído) -->
        <div id="docViewer" class="doc-viewer-wrap" style="display:none">
            <div class="doc-viewer-header">
                <h3 id="docViewerTitle"></h3>
                <div class="doc-viewer-actions">
                    <button class="btn-sm" onclick="KB.copyDocContent()">Copiar contenido</button>
                    <button class="btn-sm" onclick="KB.closeDocViewer()">Cerrar</button>
                </div>
            </div>
            <div id="docViewerContent" class="doc-viewer-body"></div>
        </div>
    </div>

    <!-- ══════ PAGE: STATS ══════ -->
    <div class="page" id="page-stats">
        <div class="page-header"><h2>Estadísticas</h2></div>
        <div class="stats-grid" id="statsGrid"><p class="muted">Cargando...</p></div>
        <div class="card mt">
            <h3 class="card-title">Top búsquedas (últimos 30 días)</h3>
            <div id="statsTopSearches"></div>
        </div>
    </div>

    <!-- ══════ PAGE: ADMIN ══════ -->
    <div class="page" id="page-admin">
        <div class="page-header">
            <h2>Administración</h2>
            <button class="btn-primary btn-sm" onclick="KB.showAddUser()">Nuevo usuario</button>
        </div>
        <div id="addUserForm" class="card" style="display:none; margin-bottom:20px;">
            <h3 class="card-title">Crear usuario</h3>
            <form onsubmit="return KB.createUser(event)">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <div class="form-row">
                    <input type="text" name="new_username" placeholder="Usuario" required class="input-sm">
                    <input type="password" name="new_password" placeholder="Contraseña" required class="input-sm">
                    <select name="new_role" class="select-sm">
                        <option value="tech">Técnico</option>
                        <option value="admin">Admin</option>
                        <option value="viewer">Visor</option>
                    </select>
                    <button type="submit" class="btn-primary btn-sm">Crear</button>
                </div>
            </form>
        </div>
        <div id="usersList" class="docs-table"><p class="muted">Cargando usuarios...</p></div>
        <div class="card mt">
            <h3 class="card-title">Log de auditoría (últimos 50)</h3>
            <div id="auditLog" class="audit-list"><p class="muted">Cargando...</p></div>
        </div>
    </div>
</main>

<!-- Modal for viewing full content -->
<div class="modal-overlay" id="modal" style="display:none" onclick="if(event.target===this)KB.closeModal()">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modalTitle"></h3>
            <div class="modal-header-actions">
                <button class="btn-sm" id="modalCopyBtn" onclick="KB.copyModalContent()">Copiar</button>
                <button class="modal-close" onclick="KB.closeModal()">&times;</button>
            </div>
        </div>
        <div id="modalBody" class="modal-body"></div>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="toast"></div>

<script nonce="<?php echo $csp_nonce; ?>">
    window.KB_CONFIG = {
        csrf: "<?php echo $csrf; ?>",
        user: <?php echo json_encode($user); ?>,
        version: "<?php echo APP_VERSION; ?>"
    };
</script>
<script src="js/app.js?v=5.0" nonce="<?php echo $csp_nonce; ?>"></script>
<?php endif; ?>

</body>
</html>
