<?php
/**
 * API SEARCH v5 — Usa el mismo stored procedure sp_search_documents que el original
 */
require_once '../config_v5.php';
require_auth();
check_api_rate_limit('search', 30, 60); // max 30 búsquedas por minuto por usuario

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Método no permitido', null, 405);
}

$query = isset($_POST['query']) ? sanitize_input($_POST['query']) : '';
if (empty($query) || strlen($query) < 2) {
    json_response(false, 'Búsqueda muy corta (mínimo 2 caracteres)', null, 400);
}
if (strlen($query) > 300) {
    json_response(false, 'Búsqueda demasiado larga (máximo 300 caracteres)', null, 400);
}

try {
    // 1. Ejecutar búsqueda (mismo stored procedure que el original)
    $stmt = $pdo->prepare("CALL sp_search_documents(?, ?)");
    $stmt->execute([$query, (int)RESULTS_PER_SEARCH]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // 2. Registrar en log (mismo stored procedure que el original)
    $results_count = count($results);
    $log_stmt = $pdo->prepare("CALL sp_log_search(?, ?)");
    $log_stmt->execute([$query, $results_count]);
    $log_stmt->closeCursor();

    $formatted = [];
    foreach ($results as $row) {
        $formatted[] = [
            'id'       => $row['id'],
            'document' => $row['filename'] ?? $row['document'] ?? 'Sin nombre',
            'content'  => $row['content'] ?? $row['snippet'] ?? '',
            'pages'    => (int)($row['pages'] ?? 0),
            'score'    => round((float)($row['relevance'] ?? 0), 2)
        ];
    }

    audit('search', $query);
    json_response(true, "Encontrados $results_count resultados", ['results' => $formatted]);

} catch (Exception $e) {
    log_message("Error API Search: " . $e->getMessage(), 'ERROR');
    json_response(false, 'Error interno del servidor', null, 500);
}
