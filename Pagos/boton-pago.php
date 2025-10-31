<?php
/**
 * CÓDIGO PARA INTEGRAR EN EL PANEL DEL CLIENTE
 * 
 * Este código muestra cómo agregar un botón que lleva a la página de pagos
 * con el email del usuario prellenado automáticamente.
 */

// Obtener datos del usuario logueado (ajusta esto según tu sistema)
session_start();

// Obtener email del usuario logueado
$userEmail = $_SESSION['email'] ?? ''; // Ajusta según tu sistema de sesiones
$userName = $_SESSION['name'] ?? ''; // Otra variable según tu sistema

// URL de tu página de pagos
$pagoUrl = 'https://cliente.com/pagos/'; // Cambiar por la URL real
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <style>
        .recargar-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }
        
        .recargar-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .credit-balance {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    
    <!-- PÁGINA DEL PANEL (tu código existente) -->
    <h1>Bienvenido a tu Panel</h1>
    
    <div class="credit-balance">
        📊 Saldo Actual: $<?php echo number_format($_SESSION['balance'] ?? 0, 2); ?>
    </div>
    
    <!-- BOTÓN PARA RECARGAR -->
    <div style="text-align: center; margin: 20px 0;">
        <h3>💎 ¿Necesitas más créditos?</h3>
        <p>Recarga tu cuenta rápidamente</p>
        <button class="recargar-btn" onclick="irAPago()">
            💰 RECARGAR CRÉDITOS
        </button>
    </div>
    
    <!-- Tu contenido existente del panel aquí -->
    <div id="services">
        <!-- Tus servicios aquí -->
    </div>
    
    <script>
    function irAPago() {
        // Obtener email del usuario (desde PHP)
        const email = '<?php echo htmlspecialchars($userEmail); ?>';
        const name = '<?php echo htmlspecialchars($userName); ?>';
        
        // URL de la página de pagos
        const urlPagos = '<?php echo $pagoUrl; ?>';
        
        // Construir URL con parámetros
        const url = `${urlPagos}?email=${encodeURIComponent(email)}&name=${encodeURIComponent(name)}`;
        
        // Abrir en nueva pestaña
        window.open(url, '_blank');
    }
    </script>
    
</body>
</html>

