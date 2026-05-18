<?php
/**
 * test-email.php — Envío de email de prueba
 * Uso: php test-email.php
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/mailer.php';

// Configuración de prueba
$to      = 'nexodigital.sys@gmail.com';
$subject = 'Test Santa Fe Construcciones — Luna Cto Nexo Digital';
$body    = implode("\n", [
    '👤 Nombre: Test Automation',
    '📞 Teléfono: +34 666 666 666',
    '📧 Email: test@example.com',
    '🏗️ Obra: Reforma integral',
    '📍 Ciudad: Barcelona',
    '',
    '💬 Mensaje:',
    'Este es un email de prueba enviado automáticamente.',
    '',
    '--',
    'Luna Cto Nexo Digital -',
]);

// Enviar vía PHPMailer SMTP
$result = sendContactEmail($to, $subject, $body, 'test@example.com');

if ($result['success']) {
    echo "✅ Email de prueba enviado correctamente a: {$to}\n";
    echo "   Asunto: {$subject}\n";
    echo "   Firma: Luna Cto Nexo Digital -\n";
    exit(0);
} else {
    echo "❌ Error al enviar email: " . ($result['error'] ?? 'Desconocido') . "\n";
    echo "   Verifica SMTP_HOST, SMTP_USER y SMTP_PASS en .env o variables de entorno.\n";
    exit(1);
}
