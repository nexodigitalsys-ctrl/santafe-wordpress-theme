-- ============================================================
-- KNOWLEDGE BASE v5 - SCHEMA COMPLETO
-- Ejecutar en phpMyAdmin sobre la base de datos vacía
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- ── TABLA: users ──────────────────────────────────────────
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('admin','tech','viewer') NOT NULL DEFAULT 'tech',
    is_active     TINYINT(1)   NOT NULL DEFAULT 1,
    last_login    TIMESTAMP    NULL,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_active   (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABLA: documents ─────────────────────────────────────
DROP TABLE IF EXISTS documents;
CREATE TABLE documents (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    filename    VARCHAR(255) NOT NULL,
    content     LONGTEXT     NOT NULL,
    pages       INT          DEFAULT 0,
    size        INT          DEFAULT 0,
    uploaded_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_filename (filename),
    FULLTEXT idx_content (content)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABLA: search_history ────────────────────────────────
DROP TABLE IF EXISTS search_history;
CREATE TABLE search_history (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    query         VARCHAR(500) NOT NULL,
    results_count INT          DEFAULT 0,
    searched_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_query      (query(100)),
    INDEX idx_searched   (searched_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABLA: ai_interactions ───────────────────────────────
DROP TABLE IF EXISTS ai_interactions;
CREATE TABLE ai_interactions (
    id         INT PRIMARY KEY AUTO_INCREMENT,
    user_id    INT  NULL,
    query      TEXT NOT NULL,
    answer     LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user    (user_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABLA: saved_searches ────────────────────────────────
DROP TABLE IF EXISTS saved_searches;
CREATE TABLE saved_searches (
    id         INT PRIMARY KEY AUTO_INCREMENT,
    user_id    INT          NOT NULL,
    query      VARCHAR(500) NOT NULL,
    ai_answer  LONGTEXT     DEFAULT NULL,
    notes      TEXT         DEFAULT NULL,
    category   VARCHAR(100) DEFAULT 'General',
    is_pinned  TINYINT(1)   DEFAULT 0,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user     (user_id),
    INDEX idx_category (category),
    INDEX idx_pinned   (is_pinned),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABLA: login_attempts ────────────────────────────────
DROP TABLE IF EXISTS login_attempts;
CREATE TABLE login_attempts (
    id           INT PRIMARY KEY AUTO_INCREMENT,
    ip_address   VARCHAR(45) NOT NULL,
    attempted_at TIMESTAMP   DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip   (ip_address),
    INDEX idx_time (attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABLA: audit_log ─────────────────────────────────────
DROP TABLE IF EXISTS audit_log;
CREATE TABLE audit_log (
    id         INT PRIMARY KEY AUTO_INCREMENT,
    user_id    INT          NULL,
    action     VARCHAR(100) NOT NULL,
    details    TEXT         DEFAULT NULL,
    ip_address VARCHAR(45)  DEFAULT NULL,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user   (user_id),
    INDEX idx_action (action),
    INDEX idx_time   (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ── STORED PROCEDURES ────────────────────────────────────
DROP PROCEDURE IF EXISTS sp_search_documents;
DELIMITER //
CREATE PROCEDURE sp_search_documents(IN p_query VARCHAR(500), IN p_limit INT)
BEGIN
    SELECT
        id,
        filename,
        SUBSTRING(content, 1, 400) AS content,
        pages,
        size,
        ROUND(MATCH(content) AGAINST(p_query IN BOOLEAN MODE), 4) AS relevance
    FROM documents
    WHERE MATCH(content) AGAINST(p_query IN BOOLEAN MODE)
    ORDER BY relevance DESC
    LIMIT p_limit;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_log_search;
DELIMITER //
CREATE PROCEDURE sp_log_search(IN p_query VARCHAR(500), IN p_results INT)
BEGIN
    INSERT INTO search_history (query, results_count) VALUES (p_query, p_results);
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_cleanup_login_attempts;
DELIMITER //
CREATE PROCEDURE sp_cleanup_login_attempts()
BEGIN
    DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL 1 DAY);
END //
DELIMITER ;

-- ── USUARIO ADMIN POR DEFECTO ────────────────────────────
-- Contraseña: Admin2025! (cámbiala tras el primer login)
INSERT INTO users (username, password_hash, role, is_active)
VALUES ('admin', '$2y$10$YKkMKBVvmQkVFPKqKGUCa.FhIlELuoqazmWGQLf1X.JDLZ9RIFnMi', 'admin', 1);
