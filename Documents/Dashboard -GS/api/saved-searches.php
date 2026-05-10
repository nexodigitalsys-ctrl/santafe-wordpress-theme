<?php
/**
 * API SAVED SEARCHES v5
 */
require_once '../config_v5.php';
require_auth();

$action = $_GET['action'] ?? '';
$user = get_current_user_array();

switch ($action) {
    case 'list':
        $cat = sanitize_input($_GET['category'] ?? '');
        $sql = "SELECT id, query, LEFT(ai_answer, 200) as ai_preview, notes, category, is_pinned, created_at FROM saved_searches WHERE user_id = ?";
        $params = [$user['id']];
        if ($cat) { $sql .= " AND category = ?"; $params[] = $cat; }
        $sql .= " ORDER BY is_pinned DESC, updated_at DESC LIMIT " . (int)MAX_SAVED;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        json_response(true, '', $stmt->fetchAll());
        break;

    case 'get':
        $id = (int)($_GET['id'] ?? 0);
        $stmt = $pdo->prepare("SELECT * FROM saved_searches WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user['id']]);
        $row = $stmt->fetch();
        if ($row) json_response(true, '', $row);
        else json_response(false, 'No encontrada', null, 404);
        break;

    case 'save':
        check_csrf();
        $query    = sanitize_input($_POST['query'] ?? '');
        $answer   = $_POST['ai_answer'] ?? '';
        $notes    = sanitize_input($_POST['notes'] ?? '');
        $category = sanitize_input($_POST['category'] ?? 'General');
        if (empty($query)) json_response(false, 'Consulta vacía');
        $stmt = $pdo->prepare("INSERT INTO saved_searches (user_id, query, ai_answer, notes, category) VALUES (?,?,?,?,?)");
        $stmt->execute([$user['id'], $query, $answer, $notes, $category]);
        audit('save_search', $query);
        json_response(true, 'Guardada');
        break;

    case 'pin':
        check_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $pin = (int)($_POST['is_pinned'] ?? 0);
        $pdo->prepare("UPDATE saved_searches SET is_pinned = ? WHERE id = ? AND user_id = ?")->execute([$pin, $id, $user['id']]);
        json_response(true, 'Actualizado');
        break;

    case 'delete':
        check_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("DELETE FROM saved_searches WHERE id = ? AND user_id = ?")->execute([$id, $user['id']]);
        audit('delete_saved', "ID: $id");
        json_response(true, 'Eliminada');
        break;

    default:
        json_response(false, 'Acción no válida', null, 400);
}
