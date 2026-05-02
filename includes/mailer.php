<?php
/**
 * includes/mailer.php — Configuración PHPMailer para Hostinger
 * SMTP con autenticación, anti-spam headers, variables de entorno
 */

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer debe estar disponible en includes/PHPMailer/ o via Composer
// Si se sube manualmente: copiar src/ de PHPMailer a includes/PHPMailer/
require_once __DIR__ . '/../includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';

/**
 * Envía email de contacto vía SMTP autenticado
 */
function sendContactEmail(string $to, string $subject, string $body, ?string $replyTo = null): array {
    $config = loadMailerConfig();

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['user'];
        $mail->Password   = $config['pass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // tls en puerto 587
        $mail->Port       = (int)$config['port'];
        $mail->CharSet    = 'UTF-8';

        // Remitente y destinatario
        $mail->setFrom($config['user'], COMPANY_NAME);
        $mail->addAddress($to);
        if ($replyTo) $mail->addReplyTo($replyTo);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        // Headers anti-spam adicionales
        $mail->XMailer = ' ';
        $mail->addCustomHeader('X-Priority', '3');
        $mail->addCustomHeader('X-Mailer', 'SantaFeCMS/1.0');

        $mail->send();
        return ['success' => true];
    } catch (Exception $e) {
        log_error("Mailer Error: " . $mail->ErrorInfo);
        return ['success' => false, 'error' => $mail->ErrorInfo];
    }
}

/**
 * Carga configuración SMTP desde .env
 */
function loadMailerConfig(): array {
    $envFile = dirname(__DIR__) . '/.env';
    $env = [];
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0 || strpos($line, '=') === false) continue;
            [$k, $v] = explode('=', $line, 2);
            $env[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        }
    }

    return [
        'host' => $env['SMTP_HOST'] ?? getenv('SMTP_HOST') ?? 'smtp.hostinger.com',
        'user' => $env['SMTP_USER'] ?? getenv('SMTP_USER') ?? '',
        'pass' => $env['SMTP_PASS'] ?? getenv('SMTP_PASS') ?? '',
        'port' => $env['SMTP_PORT'] ?? getenv('SMTP_PORT') ?? '587',
    ];
}
