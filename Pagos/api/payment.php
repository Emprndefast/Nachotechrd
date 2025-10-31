<?php
/**
 * API Endpoint para Procesar Pagos
 * Sistema Semi-Automático: Procesa automáticamente hasta llegar al admin
 */

// Control de errores/salida: evitar que avisos rompan el JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);
if (function_exists('ob_get_level') && ob_get_level() === 0) { ob_start(); }

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    if (function_exists('ob_get_length') && ob_get_length()) { ob_clean(); }
    echo json_encode(['error' => 'Método no permitido']);
    if (function_exists('ob_get_level') && ob_get_level() > 0) { ob_end_flush(); }
    exit;
}

// Configuración de Telegram
define('TELEGRAM_BOT_TOKEN', '8241590103:AAG28HU_hkBItB3sGTchrA-QHGZH5cRbFoU');
define('TELEGRAM_CHAT_ID', '1022929574');
define('TELEGRAM_API_URL', 'https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/sendMessage');

// Configuración de Base de Datos (ajusta según tu configuración)
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'tu_base_datos');

// Función para enviar notificación a Telegram
function sendTelegramNotification($message) {
    $data = [
        'chat_id' => TELEGRAM_CHAT_ID,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = @file_get_contents(TELEGRAM_API_URL, false, $context);
    
    return $result !== false;
}

// Función para guardar en base de datos
function savePaymentToDatabase($paymentData) {
    try {
        // Conectar a la base de datos solo si se han configurado credenciales reales
        if (DB_USER === 'tu_usuario' || DB_NAME === 'tu_base_datos') {
            return false; // Saltar guardado si es ambiente de prueba
        }

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            error_log("Error de conexión: " . $conn->connect_error);
            return false;
        }
        
        // Preparar datos
        $method = $conn->real_escape_string($paymentData['method'] ?? '');
        $userName = $conn->real_escape_string($paymentData['userName'] ?? '');
        $userEmail = $conn->real_escape_string($paymentData['userEmail'] ?? '');
        $amount = floatval($paymentData['amount'] ?? 0);
        $transactionRef = $conn->real_escape_string($paymentData['transactionRef'] ?? '');
        $serverEmail = $conn->real_escape_string($paymentData['serverEmail'] ?? '');
        $additionalInfo = $conn->real_escape_string($paymentData['additionalInfo'] ?? '');
        $network = $conn->real_escape_string($paymentData['network'] ?? '');
        $status = 'pending'; // Estado inicial: pendiente de validación admin
        
        // Query SQL
        $sql = "INSERT INTO payments (
            method, 
            user_name, 
            user_email, 
            server_email,
            amount, 
            transaction_ref, 
            additional_info, 
            network,
            status,
            created_at
        ) VALUES (
            '$method',
            '$userName',
            '$userEmail',
            '$serverEmail',
            $amount,
            '$transactionRef',
            '$additionalInfo',
            '$network',
            '$status',
            NOW()
        )";
        
        if ($conn->query($sql) === TRUE) {
            $paymentId = $conn->insert_id;
            $conn->close();
            return $paymentId;
        } else {
            error_log("Error en SQL: " . $conn->error);
            $conn->close();
            return false;
        }
    } catch (Exception $e) {
        error_log("Error guardando pago: " . $e->getMessage());
        return false;
    }
}

// Obtener datos del POST
$rawData = file_get_contents('php://input');
$paymentData = json_decode($rawData, true);

if (!$paymentData || !is_array($paymentData)) {
    http_response_code(400);
    if (function_exists('ob_get_length') && ob_get_length()) { ob_clean(); }
    echo json_encode(['error' => 'Datos inválidos']);
    if (function_exists('ob_get_level') && ob_get_level() > 0) { ob_end_flush(); }
    exit;
}

// Validar datos requeridos
$required = ['method', 'userName', 'userEmail', 'amount', 'transactionRef'];
foreach ($required as $field) {
    if (empty($paymentData[$field])) {
        http_response_code(400);
        if (function_exists('ob_get_length') && ob_get_length()) { ob_clean(); }
        echo json_encode(['error' => "Campo requerido faltante: $field"]);
        if (function_exists('ob_get_level') && ob_get_level() > 0) { ob_end_flush(); }
        exit;
    }
}

// Ya es array, usar directamente
$dataArray = $paymentData;

// Guardar en base de datos
$paymentId = savePaymentToDatabase($dataArray);

if ($paymentId === false) {
    // Si falla la BD, aún enviamos la notificación
    error_log("Error guardando en BD, pero continuando con notificación");
}

// Preparar mensaje para Telegram
$methodName = $paymentData['methodName'] ?? $paymentData['method'];
$amount = number_format(floatval($paymentData['amount']), 2);
$timestamp = date('d/m/Y H:i:s');

// Construir mensaje HTML para Telegram
$message = "💰 <b>NUEVA SOLICITUD DE PAGO</b>\n\n";
$message .= "🆔 ID: #" . ($paymentId ?: 'N/A') . "\n";
$message .= "👤 Cliente: <b>" . htmlspecialchars($paymentData['userName']) . "</b>\n";
$message .= "📧 Email: " . htmlspecialchars($paymentData['userEmail']) . "\n";

if (!empty($paymentData['serverEmail'])) {
    $message .= "🎮 Server Email: " . htmlspecialchars($paymentData['serverEmail']) . "\n";
}

$message .= "💳 Método: <b>" . htmlspecialchars($methodName) . "</b>\n";
$message .= "💰 Monto: <b>$" . $amount . " USD</b>\n";

if (!empty($paymentData['localAmount'])) {
    $message .= "💵 Monto Local: " . htmlspecialchars($paymentData['localAmount']) . "\n";
}

if (!empty($paymentData['network'])) {
    $message .= "🌐 Red: " . htmlspecialchars($paymentData['network']) . "\n";
}

$message .= "🔗 Referencia: <code>" . htmlspecialchars($paymentData['transactionRef']) . "</code>\n";
$message .= "📅 Fecha: " . $timestamp . "\n";

if (!empty($paymentData['additionalInfo'])) {
    $message .= "\n📝 Info Adicional:\n" . htmlspecialchars($paymentData['additionalInfo']) . "\n";
}

$message .= "\n⚠️ <b>Estado: PENDIENTE DE VALIDACIÓN</b>";

// Enviar notificación a Telegram
$telegramSent = sendTelegramNotification($message);

// Respuesta
$response = [
    'success' => true,
    'message' => 'Pago registrado correctamente',
    'paymentId' => $paymentId,
    'telegramSent' => $telegramSent,
    'timestamp' => $timestamp
];

if (function_exists('ob_get_length') && ob_get_length()) { ob_clean(); }
http_response_code(200);
echo json_encode($response);
if (function_exists('ob_get_level') && ob_get_level() > 0) { ob_end_flush(); }

?>

