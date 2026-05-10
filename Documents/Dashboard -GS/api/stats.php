<?php
/**
 * API STATS v5 — Compatible con get_stats.php original
 */
require_once '../config_v5.php';
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");

// Quick mode — compatible con el get_stats.php original (solo cuenta docs)
$quick = isset($_GET['quick']);

try {
    if ($quick) {
        $stmt = $pdo->query("SELECT COUNT(*) as total_docs FROM documents");
        $row = $stmt->fetch();
        json_response(true, '', ['total_docs' => (int)$row['total_docs']]);
    }

    // Full stats (requiere auth)
    require_auth();

    $docs     = (int)$pdo->query("SELECT COUNT(*) as c FROM documents")->fetch()['c'];
    $searches = (int)$pdo->query("SELECT COUNT(*) as c FROM search_history")->fetch()['c'];
    $ai       = (int)$pdo->query("SELECT COUNT(*) as c FROM ai_interactions")->fetch()['c'];
    $users    = (int)$pdo->query("SELECT COUNT(*) as c FROM users WHERE is_active = 1")->fetch()['c'];
    $weekly   = (int)$pdo->query("SELECT COUNT(DISTINCT query) as c FROM search_history WHERE searched_at > DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch()['c'];

    // Top searches
    $top = $pdo->query("SELECT query, COUNT(*) as count, MAX(searched_at) as last_searched FROM search_history GROUP BY query ORDER BY count DESC LIMIT 15")->fetchAll();

    json_response(true, '', [
        'total_docs'      => $docs,
        'total_searches'  => $searches,
        'total_ai'        => $ai,
        'total_users'     => $users,
        'weekly_searches' => $weekly,
        'top_searches'    => $top
    ]);
} catch (Exception $e) {
    log_message("Stats error: " . $e->getMessage(), 'ERROR');
    echo json_encode(['success' => false, 'message' => 'Error']);
}
