// Configuración centralizada del sistema
// Este archivo maneja toda la configuración del frontend

// Configuración global del sistema
window.CONFIG = {
    // URLs de API
    URLS: {
        TELEGRAM_API: 'https://api.telegram.org',
        // Usar ruta relativa al folder Pagos para evitar file:// y CORS en pruebas locales
        PAYMENT_API: 'api/payment.php'
    },
    
    // Configuración de Telegram
        TELEGRAM: {
        BOT_TOKEN: '8447635816:AAHd3XBpQpIbyk7GXs_pFN9t88Wf1bmHhWk',
        CHAT_ID: '7459084066',
        ADMIN_CHATS: ['7459084066'],
        
        // URLs específicas del bot
        get WEBHOOK_URL() {
            return `${CONFIG.URLS.TELEGRAM_API}/bot${this.BOT_TOKEN}`;
        },
        
        get GET_UPDATES_URL() {
            return `${this.WEBHOOK_URL}/getUpdates`;
        },
        
        get SEND_MESSAGE_URL() {
            return `${this.WEBHOOK_URL}/sendMessage`;
        },
        
        get BOT_INFO_URL() {
            return `${this.WEBHOOK_URL}/getMe`;
        }
    },
    
    // Configuración del sistema
    SYSTEM: {
        VERSION: '2.1.0',
        ENVIRONMENT: window.location.hostname === 'localhost' ? 'development' : 'production',
        DEBUG: window.location.hostname === 'localhost',
        
        // Configuración de logs
        ENABLE_CONSOLE_LOGS: true,
        ENABLE_TELEGRAM_LOGS: true,
        
        // Configuración de UI
        SHOW_ADMIN_CONTROLS: window.location.hostname === 'localhost',
        AUTO_HIDE_NOTIFICATIONS: true,
        NOTIFICATION_TIMEOUT: 5000
    },
    
    // Configuración de pagos
    PAYMENTS: {
        DEFAULT_CURRENCY: 'USD',
        ENABLE_MULTI_CURRENCY: true,
        ENABLE_CALCULATOR: true,
        
        // Configuración de validación
        ENABLE_VALIDATION: true,
        REQUIRE_EMAIL: true,
        REQUIRE_SERVER_EMAIL: true,
        
        // Configuración de notificaciones
        NOTIFY_ON_PAYMENT: true,
        NOTIFY_ADMINS: true,
        INCLUDE_USER_DATA: true
    },
    
    // Mensajes del sistema
    MESSAGES: {
        TELEGRAM: {
            BOT_NOT_CONFIGURED: '⚠️ Telegram Bot no configurado completamente.',
            CHAT_ID_MISSING: '⚠️ Chat ID no configurado. Usa los botones de configuración.',
            CONNECTION_ERROR: '❌ Error de conexión con Telegram.',
            MESSAGE_SENT: '✅ Mensaje enviado correctamente.',
            TEST_SUCCESS: '🎉 Prueba exitosa - Sistema funcionando correctamente.'
        },
        
        PAYMENTS: {
            VALIDATION_ERROR: '⚠️ Por favor completa todos los campos requeridos.',
            AMOUNT_TOO_LOW: '⚠️ El monto es menor al mínimo requerido.',
            PAYMENT_SUCCESS: '✅ Pago procesado correctamente.',
            PAYMENT_ERROR: '❌ Error procesando el pago.'
        },
        
        SYSTEM: {
            LOADING: '⏳ Cargando...',
            ERROR: '❌ Ha ocurrido un error.',
            SUCCESS: '✅ Operación completada.',
            WELCOME: '👋 Bienvenido al sistema de pagos NACHOTECH'
        }
    },
    
    // Configuración de desarrollo
    DEV: {
        MOCK_PAYMENTS: false,
        SIMULATE_DELAYS: false,
        VERBOSE_LOGGING: true,
        SHOW_DEBUG_INFO: true
    }
};

// Funciones de configuración
CONFIG.isProduction = () => CONFIG.SYSTEM.ENVIRONMENT === 'production';
CONFIG.isDevelopment = () => CONFIG.SYSTEM.ENVIRONMENT === 'development';
CONFIG.shouldShowAdminControls = () => CONFIG.SYSTEM.SHOW_ADMIN_CONTROLS && CONFIG.isDevelopment();

// Función para actualizar configuración dinámicamente
CONFIG.updateTelegramChatId = (chatId) => {
    CONFIG.TELEGRAM.CHAT_ID = chatId;
    console.log(`✅ CONFIG: Chat ID actualizado a ${chatId}`);
};

CONFIG.addAdminChat = (chatId) => {
    if (!CONFIG.TELEGRAM.ADMIN_CHATS.includes(chatId)) {
        CONFIG.TELEGRAM.ADMIN_CHATS.push(chatId);
        console.log(`✅ CONFIG: Admin chat agregado ${chatId}`);
    }
};

// Función para verificar configuración completa
CONFIG.isFullyConfigured = () => {
    return !!(
        CONFIG.TELEGRAM.BOT_TOKEN && 
        CONFIG.TELEGRAM.CHAT_ID &&
        CONFIG.TELEGRAM.CHAT_ID !== ''
    );
};

// Log de inicialización (solo en desarrollo)
if (CONFIG.isDevelopment()) {
    console.log('🔧 CONFIG inicializado:', {
        version: CONFIG.SYSTEM.VERSION,
        environment: CONFIG.SYSTEM.ENVIRONMENT,
        telegramConfigured: CONFIG.isFullyConfigured(),
        botToken: CONFIG.TELEGRAM.BOT_TOKEN ? '✅ Configurado' : '❌ Faltante',
        chatId: CONFIG.TELEGRAM.CHAT_ID ? '✅ Configurado' : '⚠️ Pendiente'
    });
}

// Exportar para compatibilidad con módulos
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CONFIG;
}