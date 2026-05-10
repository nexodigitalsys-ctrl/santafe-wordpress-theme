<?php
/**
 * API LOGIN v5 — Rate-limited + CSRF + Audit
 */
require_once '../config_v5.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Método no permitido', null, 405);
}

check_csrf();

$username = sanitize_input($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    json_response(false, 'Usuario y contraseña requeridos', null, 400);
}

// Rate limiting
if (!check_rate_limit('login')) {
    $mins = LOGIN_LOCKOUT_MINUTES;
    audit('login_blocked', "IP bloqueada tras demasiados intentos: $username");
    json_response(false, "Demasiados intentos. Espera $mins minutos.", null, 429);
}

try {
    $stmt = $pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ? AND is_active = 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        record_attempt();
        audit('login_fail', "Usuario: $username");
        log_message("Login fallido: $username", 'WARNING');
        json_response(false, 'Usuario o contraseña incorrectos', null, 401);
    }

    // Success — regenerate session
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'] ?? 'tech';
    $_SESSION['_created'] = time();

    clear_attempts();

    // Update last_login
    $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);

    audit('login_ok', $user['username']);
    log_message("Login exitoso: {$user['username']}");
    json_response(true, 'Login exitoso');

} catch (PDOException $e) {
    log_message("Error login: " . $e->getMessage(), 'ERROR');
    json_response(false, 'Error interno', null, 500);
}
