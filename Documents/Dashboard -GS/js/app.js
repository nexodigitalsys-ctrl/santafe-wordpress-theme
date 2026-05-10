/**
 * KNOWLEDGE BASE v5 — Main Application
 * ======================================
 * Compatible con la BD existente (stored procedures, ai_interactions, documents)
 * Los documentos son texto extraído de PDFs, cargados via SQL — no hay subida de archivos
 */

const KB = {
    csrf: window.KB_CONFIG?.csrf || '',
    user: window.KB_CONFIG?.user || {},
    currentPage: 'dashboard',
    historyPage: 0,
    _rawAI: '',
    _rawQuery: '',
    _currentDocContent: '',

    // ══════════════════════════════════
    // INIT
    // ══════════════════════════════════
    init() {
        this.bindNav();
        this.bindSearch();
        this.loadDocCount();
        this.loadTopSearches();
        this.loadRecentAI();

        // Restore page from hash
        const hash = location.hash.replace('#','');
        if (hash) this.navigate(hash);
    },

    // ══════════════════════════════════
    // NAVIGATION
    // ══════════════════════════════════
    bindNav() {
        document.querySelectorAll('.nav-item[data-page]').forEach(el => {
            el.addEventListener('click', e => {
                e.preventDefault();
                this.navigate(el.dataset.page);
                document.getElementById('sidebar')?.classList.remove('open');
            });
        });
    },

    navigate(page) {
        this.currentPage = page;
        location.hash = page;

        document.querySelectorAll('.nav-item[data-page]').forEach(el => {
            el.classList.toggle('active', el.dataset.page === page);
        });
        document.querySelectorAll('.page').forEach(el => {
            el.classList.toggle('active', el.id === 'page-' + page);
        });

        const titles = {
            dashboard: 'Dashboard',
            saved: 'Búsquedas guardadas',
            history: 'Historial IA',
            documents: 'Documentos indexados',
            stats: 'Estadísticas',
            admin: 'Administración'
        };
        document.getElementById('pageTitle').textContent = titles[page] || page;

        const loaders = {
            saved: () => this.loadSaved(),
            history: () => this.loadHistory(),
            documents: () => this.loadDocuments(),
            stats: () => this.loadStats(),
            admin: () => { this.loadUsers(); this.loadAudit(); }
        };
        if (loaders[page]) loaders[page]();
    },

    // ══════════════════════════════════
    // SEARCH + AI (misma lógica que v4, mejorada)
    // ══════════════════════════════════
    bindSearch() {
        const input = document.getElementById('searchInput');
        if (input) input.addEventListener('keydown', e => { if (e.key === 'Enter') this.search(); });
    },

    async search() {
        const q = document.getElementById('searchInput')?.value.trim();
        if (!q || q.length < 2) return;

        this._rawQuery = q;
        const container = document.getElementById('resultsContainer');
        const aiCard = document.getElementById('aiCard');
        const aiContent = document.getElementById('aiContent');

        container.innerHTML = '<p class="muted"><span class="loading-spinner"></span> Buscando en procedimientos ITI...</p>';
        aiCard.style.display = 'block';
        aiContent.innerHTML = '<p class="muted"><span class="loading-spinner"></span> Gemini está analizando los manuales...</p>';

        const fd = new FormData();
        fd.append('query', q);
        fd.append('csrf_token', this.csrf);

        try {
            // Lanzar búsqueda en BD + consulta IA en paralelo (mismo patrón que v4)
            const [searchRes, aiRes] = await Promise.all([
                fetch('api/search.php', { method: 'POST', body: fd }),
                fetch('api/ask_ai.php', { method: 'POST', body: fd })
            ]);

            const sData = await searchRes.json();
            if (sData.success) this.renderResults(sData.data.results);
            else container.innerHTML = '<p class="muted">Sin resultados en los manuales</p>';

            const aData = await aiRes.json();
            if (aData.success) {
                this._rawAI = aData.data.answer;
                aiContent.innerHTML = this.formatMarkdown(aData.data.answer);
                if (aData.data.cached) {
                    document.querySelector('.ai-label').textContent = 'Solución IA — Gemini 2.5 Flash (caché)';
                } else {
                    document.querySelector('.ai-label').textContent = 'Solución IA — Gemini 2.5 Flash';
                }
                this.renderRelatedDocs(aData.data.answer);
            } else {
                aiContent.innerHTML = '<p class="muted">Error: ' + this.esc(aData.message) + '</p>';
            }
        } catch (e) {
            container.innerHTML = '<p class="muted">Error de conexión con el servidor</p>';
            aiContent.innerHTML = '<p class="muted">Error de conexión con Gemini</p>';
            console.error(e);
        }

        // Refrescar paneles laterales
        setTimeout(() => { this.loadTopSearches(); this.loadRecentAI(); }, 500);
    },

    renderResults(results) {
        const c = document.getElementById('resultsContainer');
        if (!results?.length) {
            c.innerHTML = '<p class="muted">No hay procedimientos ITI específicos para esta consulta</p>';
            return;
        }
        c.innerHTML = results.map((r, i) => `
            <div class="result-item">
                <div class="result-doc">${this.esc(r.document)}</div>
                <div class="result-score">Relevancia: ${r.score}%</div>
                <div class="result-actions">
                    <button class="btn-sm" onclick="KB.viewDocument('${this.esc(r.document)}', ${i})">Ver documento</button>
                    <button class="btn-sm" onclick="KB.copyResult(${i})">Copiar</button>
                </div>
                <div id="rc_${i}" style="display:none">${this.esc(r.content)}</div>
            </div>`).join('');
    },

    renderRelatedDocs(answer) {
        const wrap = document.getElementById('relatedDocs');
        const links = document.getElementById('docLinks');
        // Extraer nombres de documento de la respuesta IA (códigos ITI o nombres de archivo)
        const itiCodes = answer.match(/ITI\d{5}/gi) || [];
        const pdfNames = answer.match(/[\w\-áéíóúÁÉÍÓÚñÑ]+\.pdf/gi) || [];
        const allDocs = [...new Set([...itiCodes, ...pdfNames])];

        if (!allDocs.length) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';
        links.innerHTML = allDocs.map(d =>
            `<a class="pdf-link" onclick="KB.searchDoc('${this.esc(d)}')">${this.esc(d)}</a>`
        ).join('');
    },

    // ══════════════════════════════════
    // VIEW DOCUMENT (texto extraído de la BD)
    // ══════════════════════════════════
    viewDocument(title, idx) {
        const content = document.getElementById('rc_' + idx)?.textContent || '';
        this.showModal(title, content);
    },

    async viewDocumentById(id, title) {
        try {
            const res = await fetch('api/documents.php?action=view&id=' + id + '&csrf_token=' + this.csrf);
            const data = await res.json();
            if (data.success && data.data) {
                this.showModal(data.data.filename, data.data.content);
            } else {
                this.toast('Documento no encontrado', 'error');
            }
        } catch { this.toast('Error al cargar documento', 'error'); }
    },

    searchDoc(term) {
        // Navegar al dashboard y buscar el término
        this.navigate('dashboard');
        document.getElementById('searchInput').value = term;
        this.search();
    },

    copyResult(idx) {
        const text = document.getElementById('rc_' + idx)?.textContent || '';
        this.clipboard(text);
    },

    // ══════════════════════════════════
    // COPY AI (3 formatos para pegar en formularios internos)
    // ══════════════════════════════════
    copyAI() {
        const format = document.getElementById('copyFormat')?.value || 'plain';
        let text = this._rawAI;

        if (format === 'plain') {
            // Quitar markdown para pegar en formularios planos
            text = text.replace(/#{1,3}\s*/g, '').replace(/\*\*/g, '').replace(/\*/g, '');
        } else if (format === 'ticket') {
            text = this.formatAsTicket(text);
        }
        // markdown = raw (ya viene en markdown de Gemini)

        this.clipboard(text);
    },

    formatAsTicket(raw) {
        const lines = raw.split('\n');
        let ticket = '═══════════════════════════════════\n';
        ticket += '  TICKET DE RESOLUCIÓN\n';
        ticket += '  Fecha: ' + new Date().toLocaleString('es-ES') + '\n';
        ticket += '  Consulta: ' + this._rawQuery + '\n';
        ticket += '  Técnico: ' + (this.user?.username || '') + '\n';
        ticket += '═══════════════════════════════════\n\n';
        ticket += lines.map(l => l.replace(/#{1,3}\s*/g, '▸ ').replace(/\*\*/g, '')).join('\n');
        ticket += '\n\n═══════════════════════════════════\n';
        ticket += '  Generado por Knowledge Base IT v5\n';
        ticket += '═══════════════════════════════════';
        return ticket;
    },

    // ══════════════════════════════════
    // SAVE SEARCH (guardar búsqueda para reutilizar)
    // ══════════════════════════════════
    async saveSearch() {
        if (!this._rawQuery || !this._rawAI) return this.toast('Realiza una búsqueda primero', 'error');
        const cat = prompt('Categoría (General, Red, Software, Hardware, SIGES, TPV):', 'General');
        if (cat === null) return;
        const notes = prompt('Notas adicionales (opcional):', '');

        const fd = new FormData();
        fd.append('csrf_token', this.csrf);
        fd.append('query', this._rawQuery);
        fd.append('ai_answer', this._rawAI);
        fd.append('category', cat || 'General');
        fd.append('notes', notes || '');

        try {
            const res = await fetch('api/saved-searches.php?action=save', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.success) this.toast('Búsqueda guardada', 'success');
            else this.toast(data.message, 'error');
        } catch { this.toast('Error de conexión', 'error'); }
    },

    // ══════════════════════════════════
    // SAVED SEARCHES PAGE
    // ══════════════════════════════════
    async loadSaved() {
        const cat = document.getElementById('savedCategory')?.value || '';
        try {
            const res = await fetch('api/saved-searches.php?action=list&category=' + encodeURIComponent(cat) + '&csrf_token=' + this.csrf);
            const data = await res.json();
            const list = document.getElementById('savedList');
            if (!data.success || !data.data?.length) {
                list.innerHTML = '<p class="muted">Sin búsquedas guardadas</p>';
                return;
            }
            list.innerHTML = data.data.map(s => `
                <div class="saved-card ${s.is_pinned ? 'pinned' : ''}">
                    <div class="saved-query">${this.esc(s.query)}</div>
                    <div class="saved-preview">${this.esc(s.ai_preview || '')}</div>
                    <div class="saved-meta">
                        <span class="saved-cat">${this.esc(s.category)}</span>
                        <span>${s.created_at}</span>
                    </div>
                    <div class="saved-actions" style="margin-top:8px">
                        <button class="btn-sm" onclick="KB.viewSaved(${s.id})">Ver</button>
                        <button class="btn-sm" onclick="KB.rerunSearch('${this.esc(s.query)}')">Rebuscar</button>
                        <button class="btn-sm btn-accent" onclick="KB.pinSaved(${s.id}, ${s.is_pinned ? 0 : 1})">${s.is_pinned ? 'Desfijar' : 'Fijar'}</button>
                        <button class="btn-sm btn-danger" onclick="KB.deleteSaved(${s.id})">Eliminar</button>
                    </div>
                </div>`).join('');
        } catch { document.getElementById('savedList').innerHTML = '<p class="muted">Error cargando</p>'; }
    },

    filterSaved() {
        const q = document.getElementById('savedFilter')?.value.toLowerCase() || '';
        document.querySelectorAll('.saved-card').forEach(c => {
            c.style.display = c.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    },

    async viewSaved(id) {
        try {
            const res = await fetch('api/saved-searches.php?action=get&id=' + id + '&csrf_token=' + this.csrf);
            const data = await res.json();
            if (data.success) {
                let body = data.data.ai_answer || '';
                if (data.data.notes) body += '\n\n── Notas ──\n' + data.data.notes;
                this.showModal(data.data.query, body);
            }
        } catch { this.toast('Error', 'error'); }
    },

    async pinSaved(id, pin) {
        const fd = new FormData();
        fd.append('csrf_token', this.csrf);
        fd.append('id', id);
        fd.append('is_pinned', pin);
        await fetch('api/saved-searches.php?action=pin', { method: 'POST', body: fd });
        this.loadSaved();
    },

    async deleteSaved(id) {
        if (!confirm('¿Eliminar esta búsqueda guardada?')) return;
        const fd = new FormData();
        fd.append('csrf_token', this.csrf);
        fd.append('id', id);
        await fetch('api/saved-searches.php?action=delete', { method: 'POST', body: fd });
        this.loadSaved();
        this.toast('Eliminada', 'success');
    },

    rerunSearch(q) {
        this.navigate('dashboard');
        document.getElementById('searchInput').value = q;
        this.search();
    },

    // ══════════════════════════════════
    // AI HISTORY PAGE (con paginación)
    // ══════════════════════════════════
    async loadHistory(page) {
        if (page === undefined) page = 0;
        this.historyPage = page;
        const limit = 20;
        try {
            const res = await fetch('api/ai-history.php?offset=' + (page * limit) + '&limit=' + limit + '&csrf_token=' + this.csrf);
            const data = await res.json();
            const list = document.getElementById('historyList');
            if (!data.success || !data.data?.history?.length) {
                list.innerHTML = '<p class="muted">Sin historial</p>';
                document.getElementById('historyPagination').innerHTML = '';
                return;
            }
            list.innerHTML = data.data.history.map(h => `
                <div class="history-entry" onclick="KB.viewHistoryEntry(${h.id})">
                    <div class="history-entry-q">${this.esc(h.query)}</div>
                    <div class="history-entry-preview">${this.esc(h.answer_preview || '')}</div>
                    <div class="history-entry-date">${h.created_at}</div>
                </div>`).join('');

            const total = data.data.total || 0;
            const pages = Math.ceil(total / limit);
            const pag = document.getElementById('historyPagination');
            if (pages > 1) {
                pag.innerHTML = Array.from({ length: pages }, (_, i) =>
                    '<button class="page-btn ' + (i === page ? 'active' : '') + '" onclick="KB.loadHistory(' + i + ')">' + (i + 1) + '</button>'
                ).join('');
            } else { pag.innerHTML = ''; }
        } catch { document.getElementById('historyList').innerHTML = '<p class="muted">Error</p>'; }
    },

    async viewHistoryEntry(id) {
        try {
            const res = await fetch('api/ai-history.php?action=get&id=' + id + '&csrf_token=' + this.csrf);
            const data = await res.json();
            if (data.success) this.showModal(data.data.query, data.data.answer);
        } catch { this.toast('Error', 'error'); }
    },

    async clearHistory() {
        if (!confirm('¿Eliminar todo el historial de consultas IA?')) return;
        const fd = new FormData();
        fd.append('csrf_token', this.csrf);
        await fetch('api/ai-history.php?action=clear', { method: 'POST', body: fd });
        this.loadHistory();
        this.toast('Historial limpiado', 'success');
    },

    // ══════════════════════════════════
    // DOCUMENTS PAGE (texto extraído de la BD)
    // ══════════════════════════════════
    async loadDocuments() {
        try {
            const res = await fetch('api/documents.php?action=list&csrf_token=' + this.csrf);
            const data = await res.json();
            const wrap = document.getElementById('docsList');
            const total = document.getElementById('docTotal');

            if (!data.success || !data.data?.length) {
                wrap.innerHTML = '<p class="muted">Sin documentos indexados</p>';
                return;
            }

            total.textContent = data.data.length + ' procedimientos indexados';

            wrap.innerHTML = '<table>' +
                '<thead><tr><th>Documento / Código ITI</th><th>Páginas</th><th>Tamaño</th><th>Fecha</th><th>Acciones</th></tr></thead>' +
                '<tbody>' + data.data.map(d => '<tr>' +
                    '<td style="font-weight:600;color:var(--text-head)">' + this.esc(d.filename) + '</td>' +
                    '<td>' + (d.pages || '—') + '</td>' +
                    '<td>' + (d.size ? Math.round(d.size / 1024) + ' KB' : '—') + '</td>' +
                    '<td>' + (d.uploaded_at || '—') + '</td>' +
                    '<td><button class="btn-sm" onclick="KB.viewDocumentById(' + d.id + ', \'' + this.esc(d.filename) + '\')">Ver contenido</button></td>' +
                '</tr>').join('') +
                '</tbody></table>';
        } catch {
            document.getElementById('docsList').innerHTML = '<p class="muted">Error cargando documentos</p>';
        }
    },

    filterDocs() {
        const q = document.getElementById('docFilter')?.value.toLowerCase() || '';
        document.querySelectorAll('#docsList tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    },

    closeDocViewer() {
        document.getElementById('docViewer').style.display = 'none';
    },

    copyDocContent() {
        this.clipboard(this._currentDocContent);
    },

    // ══════════════════════════════════
    // STATS
    // ══════════════════════════════════
    async loadStats() {
        try {
            const res = await fetch('api/stats.php?csrf_token=' + this.csrf);
            const data = await res.json();
            if (!data.success) return;
            const s = data.data;
            document.getElementById('statsGrid').innerHTML = [
                { n: s.total_docs, l: 'Documentos' },
                { n: s.total_searches, l: 'Búsquedas totales' },
                { n: s.total_ai, l: 'Consultas IA' },
                { n: s.total_users, l: 'Usuarios activos' },
                { n: s.weekly_searches, l: 'Búsq. esta semana' }
            ].map(c => '<div class="stat-card"><div class="stat-number">' + (c.n ?? 0) + '</div><div class="stat-label">' + c.l + '</div></div>').join('');

            if (s.top_searches?.length) {
                document.getElementById('statsTopSearches').innerHTML =
                    '<table class="docs-table"><thead><tr><th>Consulta</th><th>Veces</th><th>Última vez</th></tr></thead><tbody>' +
                    s.top_searches.map(t => '<tr><td>' + this.esc(t.query) + '</td><td>' + t.count + '</td><td>' + t.last_searched + '</td></tr>').join('') +
                    '</tbody></table>';
            }
        } catch {}
    },

    // ══════════════════════════════════
    // ADMIN (usuarios + auditoría)
    // ══════════════════════════════════
    showAddUser() { document.getElementById('addUserForm').style.display = 'block'; },

    async createUser(e) {
        e.preventDefault();
        const form = e.target;
        const fd = new FormData(form);
        fd.append('csrf_token', this.csrf);
        try {
            const res = await fetch('api/users.php?action=create', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.success) { this.toast('Usuario creado', 'success'); form.reset(); this.loadUsers(); }
            else this.toast(data.message, 'error');
        } catch { this.toast('Error', 'error'); }
        return false;
    },

    async loadUsers() {
        try {
            const res = await fetch('api/users.php?action=list&csrf_token=' + this.csrf);
            const data = await res.json();
            const wrap = document.getElementById('usersList');
            if (!data.success || !data.data?.length) { wrap.innerHTML = '<p class="muted">Sin usuarios</p>'; return; }
            wrap.innerHTML = '<table><thead><tr><th>Usuario</th><th>Rol</th><th>Creado</th><th>Último login</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>' +
                data.data.map(u => '<tr>' +
                    '<td style="font-weight:600;color:var(--text-head)">' + this.esc(u.username) + '</td>' +
                    '<td>' + (u.role || 'tech') + '</td>' +
                    '<td>' + (u.created_at || '—') + '</td>' +
                    '<td>' + (u.last_login || 'Nunca') + '</td>' +
                    '<td>' + (u.is_active ? '<span style="color:var(--green)">Activo</span>' : '<span style="color:var(--red)">Inactivo</span>') + '</td>' +
                    '<td><button class="btn-sm btn-danger" onclick="KB.toggleUser(' + u.id + ', ' + (u.is_active ? 0 : 1) + ')">' + (u.is_active ? 'Desactivar' : 'Activar') + '</button></td>' +
                '</tr>').join('') +
                '</tbody></table>';
        } catch {}
    },

    async toggleUser(id, active) {
        const fd = new FormData();
        fd.append('csrf_token', this.csrf);
        fd.append('id', id);
        fd.append('is_active', active);
        await fetch('api/users.php?action=toggle', { method: 'POST', body: fd });
        this.loadUsers();
    },

    async loadAudit() {
        try {
            const res = await fetch('api/users.php?action=audit&csrf_token=' + this.csrf);
            const data = await res.json();
            const wrap = document.getElementById('auditLog');
            if (!data.success || !data.data?.length) { wrap.innerHTML = '<p class="muted">Sin registros</p>'; return; }
            wrap.innerHTML = data.data.map(a =>
                '<div class="audit-entry">' +
                    '<span class="audit-time">' + a.created_at + '</span>' +
                    '<span class="audit-action">' + this.esc(a.action) + '</span>' +
                    '<span class="audit-detail">' + this.esc(a.details || '') + ' — ' + this.esc(a.username || '') + '</span>' +
                '</div>'
            ).join('');
        } catch {}
    },

    // ══════════════════════════════════
    // SIDEBAR LOADERS (compatible con APIs originales)
    // ══════════════════════════════════
    async loadDocCount() {
        try {
            const res = await fetch('api/stats.php?quick=1&t=' + Date.now());
            const data = await res.json();
            if (data.success) {
                document.getElementById('docBadge').textContent = (data.data.total_docs || 0) + ' docs';
            }
        } catch {}
    },

    async loadTopSearches() {
        try {
            // Usa most-searched.php que consulta ai_interactions (mismo que original)
            const res = await fetch('api/most-searched.php?t=' + Date.now());
            const data = await res.json();
            const el = document.getElementById('topSearches');
            if (!data.success || !data.data?.history?.length) {
                el.innerHTML = '<p class="muted">Sin datos</p>';
                return;
            }
            el.innerHTML = data.data.history.map(h =>
                '<div class="hist-item" onclick="KB.rerunSearch(\'' + this.esc(h.query) + '\')">' +
                    '<span>' + this.esc(h.query) + '</span>' +
                    '<span class="hist-count">' + h.total + '</span>' +
                '</div>'
            ).join('');
        } catch {}
    },

    async loadRecentAI() {
        try {
            const res = await fetch('api/ai-history.php?limit=8&t=' + Date.now());
            const data = await res.json();
            const el = document.getElementById('recentAI');
            if (!data.success || !data.data?.history?.length) {
                el.innerHTML = '<p class="muted">Sin historial</p>';
                return;
            }
            el.innerHTML = data.data.history.map(h =>
                '<div class="hist-item" onclick="KB.rerunSearch(\'' + this.esc(h.query) + '\')">' +
                    '<span>' + this.esc(h.query) + '</span>' +
                '</div>'
            ).join('');
        } catch {}
    },

    // ══════════════════════════════════
    // UTILITIES
    // ══════════════════════════════════
    formatMarkdown(text) {
        // Escapar HTML primero para prevenir XSS antes de inyectar tags seguros
        const d = document.createElement('div');
        d.textContent = text;
        const safe = d.innerHTML;
        return safe
            .replace(/^### (.*$)/gm, '<h3>$1</h3>')
            .replace(/^## (.*$)/gm, '<h2>$1</h2>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/^\d+\.\s(.+)/gm, '<li>$1</li>')
            .replace(/^[-•]\s(.+)/gm, '<li>$1</li>')
            .replace(/`([^`]+)`/g, '<code>$1</code>')
            .replace(/\n/g, '<br>');
    },

    esc(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML.replace(/'/g, '&#39;').replace(/"/g, '&quot;');
    },

    clipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => this.toast('Copiado al portapapeles', 'success'));
        } else {
            // Fallback para navegadores antiguos (mismo que v4)
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.cssText = 'position:fixed;opacity:0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            this.toast('Copiado', 'success');
        }
    },

    showModal(title, body) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalBody').textContent = body;
        this._currentDocContent = body;
        document.getElementById('modal').style.display = 'flex';
    },

    closeModal() {
        document.getElementById('modal').style.display = 'none';
    },

    copyModalContent() {
        this.clipboard(this._currentDocContent);
    },

    toast(msg, type) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className = 'toast show ' + (type || '');
        setTimeout(() => t.className = 'toast', 2500);
    }
};

// ── LOGIN HANDLER ──
function handleLogin(e) {
    e.preventDefault();
    const btn = document.getElementById('loginBtn');
    const err = document.getElementById('loginError');
    btn.disabled = true;
    btn.textContent = 'Accediendo...';
    err.style.display = 'none';

    const fd = new FormData(document.getElementById('loginForm'));

    fetch('api/login.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.php';
            } else {
                err.textContent = data.message;
                err.style.display = 'block';
                btn.disabled = false;
                btn.textContent = 'Acceder';
            }
        })
        .catch(() => {
            err.textContent = 'Error de conexión con el servidor';
            err.style.display = 'block';
            btn.disabled = false;
            btn.textContent = 'Acceder';
        });
    return false;
}

// ── BOOT ──
document.addEventListener('DOMContentLoaded', () => KB.init());
