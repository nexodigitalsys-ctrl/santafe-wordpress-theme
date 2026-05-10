<?php
/**
 * KNOWLEDGE BASE v5 - CONFIGURACIÓN SEGURA
 * ==========================================
 * Basado en config_v4.php — mantiene compatibilidad con stored procedures y tablas existentes
 * IMPORTANTE: Cambia las credenciales antes de subir a producción
 */

// ── LOAD .env (secrets never hardcoded) ──
(function () {
    $envFile = __DIR__ . '/.env';
    if (!file_exists($envFile)) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Archivo .env no encontrado']));
    }
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        putenv(trim($k) . '=' . trim($v));
    }
})();

// ── DATABASE ──
define('DB_HOST',     getenv('DB_HOST')     ?: 'localhost');
define('DB_USER',     getenv('DB_USER')     ?: '');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_NAME',     getenv('DB_NAME')     ?: '');
define('DB_PORT',     (int)(getenv('DB_PORT') ?: 3306));

// ── GEMINI API (server-side only) ──
define('GEMINI_API_KEY', getenv('GEMINI_API_KEY') ?: '');

// ── APP ──
define('APP_NAME', 'Knowledge Base IT');
define('APP_VERSION', '5.0');
date_default_timezone_set('Europe/Madrid');

// ── SESSION (misma cookie que v4 para no cerrar sesiones activas) ──
define('SESSION_NAME', 'kb_dashboard_session_v4');
define('SESSION_TIMEOUT', 28800); // 8 hours

// ── SEARCH (usa los mismos stored procedures: sp_search_documents, sp_log_search, etc.) ──
define('RESULTS_PER_SEARCH', 5);
define('SNIPPET_LENGTH', 400);
define('MAX_HISTORY', 20);
define('MAX_SAVED', 100);

// ── SECURITY ──
define('FORCE_HTTPS', true);
define('DEBUG_MODE', false);
define('LOG_FILE', '/home/u526996563/public_html/gsc/logs/app.log');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_MINUTES', 15);

// ── INCIDENT RESPONSE TEMPLATE (used in Gemini prompt) ──
define('INCIDENT_TEMPLATE', '
Responde SIEMPRE en español con esta estructura exacta para formato helpdesk/IT:

## DIAGNÓSTICO
Breve descripción del problema detectado basándote en los procedimientos ITI.

## CAUSA PROBABLE
Causa raíz más probable según los manuales y códigos ITI consultados.

## PASOS DE RESOLUCIÓN
1. Paso concreto 1
2. Paso concreto 2
3. (tantos como sean necesarios, siguiendo el formato de los procedimientos ITI)

## VERIFICACIÓN
Cómo comprobar que el problema se ha resuelto.

## ESCALADO
Si no se resuelve, indicar a qué nivel transferir (Nivel 2 o Tercer Nivel) según los procedimientos.

## DOCUMENTOS CONSULTADOS
Lista los códigos ITI y documentos de la base de conocimiento utilizados.
');

// ══════════════════════════════════════════
// DATABASE CONNECTION
// ══════════════════════════════════════════
try {
    $dsn = "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['success'=>false,'message'=>'Database unavailable']));
}

// ══════════════════════════════════════════
// SESSION (hardened)
// ══════════════════════════════════════════
ini_set('session.name', SESSION_NAME);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', FORCE_HTTPS ? 1 : 0);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.gc_maxlifetime', SESSION_TIMEOUT);
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID periodically
if (!isset($_SESSION['_created'])) {
    $_SESSION['_created'] = time();
} elseif (time() - $_SESSION['_created'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['_created'] = time();
}

// Session timeout check
if (isset($_SESSION['_last_activity']) && (time() - $_SESSION['_last_activity'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['_last_activity'] = time();

// ══════════════════════════════════════════
// HELPER FUNCTIONS
// ══════════════════════════════════════════

function sanitize_input($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function json_response($success, $message = '', $data = null, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    $r = ['success' => $success, 'message' => $message];
    if ($data !== null) $r['data'] = $data;
    echo json_encode($r, JSON_UNESCAPED_UNICODE);
    exit();
}

function log_message($msg, $level = 'INFO') {
    $dir = dirname(LOG_FILE);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $ts = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'cli';
    file_put_contents(LOG_FILE, "[$ts] [$level] [$ip] $msg\n", FILE_APPEND | LOCK_EX);
}

function audit($action, $details = '') {
    global $pdo;
    try {
        $uid = $_SESSION['user_id'] ?? null;
        $ip  = $_SERVER['REMOTE_ADDR'] ?? '';
        $st  = $pdo->prepare("INSERT INTO audit_log (user_id, action, details, ip_address) VALUES (?,?,?,?)");
        $st->execute([$uid, $action, $details, $ip]);
    } catch (Exception $e) { /* silent */ }
}

// ── Auth helpers (v5 names) ──
function is_authenticated() {
    return isset($_SESSION['user_id'], $_SESSION['username']);
}
function get_current_user_array() {
    if (!is_authenticated()) return null;
    return [
        'id'       => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role'     => $_SESSION['role'] ?? 'tech'
    ];
}
function require_auth() {
    if (!is_authenticated()) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            json_response(false, 'No autorizado', null, 401);
        }
        header('Location: index.php');
        exit();
    }
}
function require_admin() {
    require_auth();
    if (($_SESSION['role'] ?? '') !== 'admin') {
        json_response(false, 'Acceso denegado', null, 403);
    }
}

// ── Backward-compatible aliases (v4 function names) ──
function autenticado_kb_v4() { return is_authenticated(); }
function obtener_usuario_v4() { return get_current_user_array(); }
function requerir_login_v4() { return require_auth(); }
function logout_v4() {
    session_unset();
    session_destroy();
}

// ── CSRF ──
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
function check_csrf() {
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!verify_csrf($token)) {
        json_response(false, 'Token de seguridad inválido', null, 403);
    }
}

// ── Rate limiting (login) ──
function check_rate_limit($action = 'login') {
    global $pdo;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $window = LOGIN_LOCKOUT_MINUTES;
    $st = $pdo->prepare("SELECT COUNT(*) as cnt FROM login_attempts WHERE ip_address = ? AND attempted_at > DATE_SUB(NOW(), INTERVAL ? MINUTE)");
    $st->execute([$ip, $window]);
    $row = $st->fetch();
    return ($row['cnt'] ?? 0) < MAX_LOGIN_ATTEMPTS;
}
function record_attempt() {
    global $pdo;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $pdo->prepare("INSERT INTO login_attempts (ip_address) VALUES (?)")->execute([$ip]);
}
function clear_attempts() {
    global $pdo;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $pdo->prepare("DELETE FROM login_attempts WHERE ip_address = ?")->execute([$ip]);
}

// ── Rate limiting (endpoints API) ──
function check_api_rate_limit(string $action, int $maxRequests = 20, int $windowSeconds = 60): void {
    $key   = "rl_{$action}";
    $tsKey = "rl_{$action}_ts";
    $now   = time();

    if (!isset($_SESSION[$tsKey]) || ($now - $_SESSION[$tsKey]) >= $windowSeconds) {
        $_SESSION[$tsKey] = $now;
        $_SESSION[$key]   = 0;
    }

    $_SESSION[$key]++;

    if ($_SESSION[$key] > $maxRequests) {
        http_response_code(429);
        header('Retry-After: ' . $windowSeconds);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'message' => 'Demasiadas solicitudes. Espera un momento.']);
        exit();
    }
}

// ── Error handler ──
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    log_message("PHP Error [$errno]: $errstr in $errfile:$errline", 'ERROR');
    if (DEBUG_MODE) {
        echo "<b>Error:</b> $errstr in $errfile:$errline";
    }
});
