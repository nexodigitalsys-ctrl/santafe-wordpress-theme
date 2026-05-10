<?php
/**
 * API MOST-SEARCHED v5
 * Mismo comportamiento que el original: consulta ai_interactions agrupado
 */
require_once '../config_v5.php';
require_auth();
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");

try {
    $stmt = $pdo->query("SELECT query, COUNT(*) as total FROM ai_interactions GROUP BY query ORDER BY MAX(created_at) DESC LIMIT " . (int)MAX_HISTORY);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => ['history' => $history]], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
