<?php
/**
 * API DOCUMENTS v5 — Lista documentos desde la BD (texto extraído)
 * NO gestiona subida de PDFs — los documentos se cargan via carga_total.sql
 */
require_once '../config_v5.php';
require_auth();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        try {
            $stmt = $pdo->query("SELECT id, filename, pages, size, uploaded_at FROM documents ORDER BY filename ASC");
            $docs = $stmt->fetchAll();
            json_response(true, '', $docs);
        } catch (Exception $e) {
            json_response(false, 'Error', null, 500);
        }
        break;

    case 'view':
        // Devuelve el contenido completo de un documento (texto extraído del PDF)
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) json_response(false, 'ID requerido', null, 400);
        try {
            $stmt = $pdo->prepare("SELECT id, filename, content, pages, size FROM documents WHERE id = ?");
            $stmt->execute([$id]);
            $doc = $stmt->fetch();
            if ($doc) {
                audit('view_doc', $doc['filename']);
                json_response(true, '', $doc);
            } else {
                json_response(false, 'Documento no encontrado', null, 404);
            }
        } catch (Exception $e) {
            json_response(false, 'Error', null, 500);
        }
        break;

    case 'search':
        // Búsqueda dentro de documentos específicos
        $q = sanitize_input($_GET['q'] ?? '');
        if (strlen($q) < 2) json_response(false, 'Búsqueda muy corta', null, 400);
        try {
            $stmt = $pdo->prepare("SELECT id, filename, SUBSTRING(content, 1, 500) as snippet, pages, 
                ROUND(MATCH(content) AGAINST(? IN BOOLEAN MODE), 2) as relevance 
                FROM documents WHERE MATCH(content) AGAINST(? IN BOOLEAN MODE) 
                ORDER BY relevance DESC LIMIT 10");
            $stmt->execute([$q, $q]);
            json_response(true, '', $stmt->fetchAll());
        } catch (Exception $e) {
            json_response(false, 'Error', null, 500);
        }
        break;

    default:
        json_response(false, 'Acción no válida', null, 400);
}
