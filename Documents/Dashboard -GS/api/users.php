<?php
/**
 * API USERS v5 — Admin only (create, list, toggle, audit)
 */
require_once '../config_v5.php';
require_auth();

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        require_admin();
        $stmt = $pdo->query("SELECT id, username, role, created_at, last_login, is_active FROM users ORDER BY created_at DESC");
        json_response(true, '', $stmt->fetchAll());
        break;

    case 'create':
        require_admin();
        check_csrf();
        $username = sanitize_input($_POST['new_username'] ?? '');
        $password = $_POST['new_password'] ?? '';
        $role     = sanitize_input($_POST['new_role'] ?? 'tech');

        if (empty($username) || empty($password)) {
            json_response(false, 'Campos requeridos', null, 400);
        }
        if (strlen($password) < 6) {
            json_response(false, 'Contraseña mínimo 6 caracteres', null, 400);
        }
        if (!in_array($role, ['admin','tech','viewer'])) $role = 'tech';

        // Check duplicate
        $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $check->execute([$username]);
        if ($check->fetch()) {
            json_response(false, 'Usuario ya existe', null, 409);
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hash, $role]);

        audit('create_user', "$username ($role)");
        json_response(true, 'Usuario creado');
        break;

    case 'toggle':
        require_admin();
        check_csrf();
        $id     = (int)($_POST['id'] ?? 0);
        $active = (int)($_POST['is_active'] ?? 0);

        // Don't deactivate yourself
        if ($id === (int)($_SESSION['user_id'] ?? 0)) {
            json_response(false, 'No puedes desactivarte a ti mismo', null, 400);
        }

        $pdo->prepare("UPDATE users SET is_active = ? WHERE id = ?")->execute([$active, $id]);
        audit('toggle_user', "ID:$id active:$active");
        json_response(true, 'Actualizado');
        break;

    case 'audit':
        require_admin();
        $stmt = $pdo->query("SELECT al.created_at, al.action, al.details, al.ip_address, u.username FROM audit_log al LEFT JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT 50");
        json_response(true, '', $stmt->fetchAll());
        break;

    default:
        json_response(false, 'Acción no válida', null, 400);
}
