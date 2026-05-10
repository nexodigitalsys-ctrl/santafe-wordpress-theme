<?php
/**
 * API AI-HISTORY v5 — Paginated + Full view + Clear
 * Basado en el original pero con paginación y acciones extra
 */
require_once '../config_v5.php';
require_auth();

$action = $_GET['action'] ?? 'list';
$user = get_current_user_array();

switch ($action) {
    case 'list':
        $offset = max(0, (int)($_GET['offset'] ?? 0));
        $limit  = min(50, max(1, (int)($_GET['limit'] ?? 20)));

        try {
            // Count total
            $cnt = $pdo->prepare("SELECT COUNT(*) as total FROM ai_interactions WHERE user_id = ?");
            $cnt->execute([$user['id']]);
            $total = (int)$cnt->fetch()['total'];

            $stmt = $pdo->prepare("SELECT id, query, LEFT(answer, 300) as answer_preview, created_at FROM ai_interactions WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute([$user['id'], $limit, $offset]);

            json_response(true, '', ['history' => $stmt->fetchAll(), 'total' => $total]);
        } catch (Exception $e) {
            json_response(false, 'Error', null, 500);
        }
        break;

    case 'get':
        $id = (int)($_GET['id'] ?? 0);
        try {
            $stmt = $pdo->prepare("SELECT * FROM ai_interactions WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $user['id']]);
            $row = $stmt->fetch();
            if ($row) json_response(true, '', $row);
            else json_response(false, 'No encontrada', null, 404);
        } catch (Exception $e) {
            json_response(false, 'Error', null, 500);
        }
        break;

    case 'clear':
        check_csrf();
        try {
            $pdo->prepare("DELETE FROM ai_interactions WHERE user_id = ?")->execute([$user['id']]);
            audit('clear_ai_history', '');
            json_response(true, 'Historial limpiado');
        } catch (Exception $e) {
            json_response(false, 'Error', null, 500);
        }
        break;

    default:
        json_response(false, 'Acción no válida', null, 400);
}
