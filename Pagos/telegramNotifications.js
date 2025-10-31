// Sistema de Notificaciones por Telegram
// Este archivo maneja el envío de notificaciones automáticas cuando se reciben pagos

class TelegramNotifier {
    constructor() {
        // Esperar a que CONFIG esté disponible
        this.initConfig();
    }
    
    initConfig() {
        // Usar configuración del archivo config.js
        if (typeof CONFIG !== 'undefined' && CONFIG.TELEGRAM) {
            this.botToken = CONFIG.TELEGRAM.BOT_TOKEN;
            this.chatId = CONFIG.TELEGRAM.CHAT_ID;
            this.adminChats = CONFIG.TELEGRAM.ADMIN_CHATS.join(',');
            this.apiUrl = `${CONFIG.URLS.TELEGRAM_API}/bot${this.botToken}`;
            
            // Verificar configuración
            if (!this.botToken) {
                console.warn('⚠️ Telegram Bot Token no configurado.');
            } else if (!this.chatId || this.chatId === '') {
                console.warn('⚠️ Telegram Chat ID no configurado. Usa los botones de configuración.');
            } else {
                console.log('✅ Telegram Bot configurado correctamente');
            }
        } else {
            // Sin fallback con datos ajenos para evitar fugas
            this.botToken = '';
            this.chatId = '';
            this.adminChats = '';
            this.apiUrl = `https://api.telegram.org/bot`;
            console.warn('⚠️ CONFIG no disponible. Configure BOT_TOKEN y CHAT_ID en Pagos/config.js');
        }
    }
    
    // Función para actualizar Chat ID dinámicamente
    setChatId(chatId) {
        this.chatId = chatId;
        if (typeof CONFIG !== 'undefined' && CONFIG.TELEGRAM) {
            CONFIG.TELEGRAM.CHAT_ID = chatId;
        }
        console.log(`✅ Chat ID actualizado: ${chatId}`);
    }
    
    // Función para verificar configuración
    isConfigured() {
        return !!(this.botToken && this.chatId);
    }
    
    // Función principal para enviar notificación de pago
    async sendPaymentNotification(paymentData) {
        if (!this.botToken || !this.chatId) {
            console.warn('Telegram no configurado, saltando notificación');
            return false;
        }
        
        try {
            const message = this.formatPaymentMessage(paymentData);
            const result = await this.sendMessage(message);
            
            // También enviar a administradores adicionales si están configurados
            if (this.adminChats) {
                const adminChatIds = this.adminChats.split(',').map(id => id.trim());
                for (const adminId of adminChatIds) {
                    if (adminId !== this.chatId) {
                        await this.sendMessage(message, adminId);
                    }
                }
            }
            
            console.log('✅ Notificación de pago enviada por Telegram');
            return result;
        } catch (error) {
            console.error('❌ Error enviando notificación por Telegram:', error);
            return false;
        }
    }
    
    // Formatear mensaje de pago
    formatPaymentMessage(data) {
        const emojis = {
            'usdt': '₿',
            'usdterc20': '₿',
            'usdtbep20': '₿',
            'yape': '🇵🇪',
            'bcp': '🏦',
            'mexico': '🇲🇽',
            'bancopopular': '🇩🇴',
            'banreservas': '🇩🇴',
            'lemoncash': '🍋'
        };
        
        const emoji = emojis[data.method] || '💰';
        const timestamp = new Date().toLocaleString('es-ES', {
            timeZone: 'America/Santo_Domingo',
            day: '2-digit',
            month: '2-digit', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        let message = `🚨 *NUEVO PAGO RECIBIDO* 🚨\n\n`;
        message += `${emoji} *Método:* ${data.methodName || data.method}\n`;
        message += `👤 *Cliente:* ${data.userName}\n`;
        message += `📧 *Email:* ${data.userEmail}\n`;
        
        if (data.serverEmail) {
            message += `🎮 *Email Servidor:* ${data.serverEmail}\n`;
        }
        
        message += `💵 *Monto:* $${data.amount} USD\n`;
        
        if (data.localAmount && data.exchangeRate) {
            message += `💱 *Equivalente:* ${data.localAmount}\n`;
        }
        
        if (data.transactionRef) {
            message += `🔗 *Referencia:* \`${data.transactionRef}\`\n`;
        }
        
        if (data.network) {
            message += `🌐 *Red:* ${data.network}\n`;
        }
        
        message += `\n⏰ *Fecha:* ${timestamp}\n`;
        
        if (data.additionalInfo) {
            message += `\n📝 *Info adicional:*\n${data.additionalInfo}`;
        }
        
        message += `\n\n✅ *Verifica el pago y procesa la recarga*`;
        
        return message;
    }
    
    // Enviar mensaje a Telegram
    async sendMessage(message, chatId = null) {
        const targetChatId = chatId || this.chatId;
        
        const url = `${this.apiUrl}/sendMessage`;
        const payload = {
            chat_id: targetChatId,
            text: message,
            parse_mode: 'Markdown',
            disable_web_page_preview: true
        };
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload)
        });
        
        let result;
        try { result = await response.json(); } catch (e) { result = null; }
        
        if (!response.ok || (result && result.ok === false)) {
            const description = result && result.description ? result.description : `HTTP ${response.status}`;
            const friendly = this.translateTelegramError(description);
            const err = new Error(friendly);
            err.rawDescription = description;
            err.status = response.status;
            throw err;
        }
        
        return result || { ok: true };
    }

    // Traducción de errores comunes de Telegram
    translateTelegramError(desc) {
        const d = (desc || '').toLowerCase();
        if (d.includes('chat not found')) {
            return 'Chat no encontrado. Abre Telegram, busca tu bot y presiona /start para iniciar la conversación. Luego intenta de nuevo.';
        }
        if (d.includes('forbidden') && d.includes('bot was blocked')) {
            return 'El bot está bloqueado por el usuario. Desbloquea el bot en Telegram y vuelve a intentar.';
        }
        if (d.includes('bad request') && d.includes('chat_id')) {
            return 'Chat ID inválido. Verifica que el número de chat sea correcto.';
        }
        if (d.includes('bad request')) {
            return 'Solicitud inválida. Verifica el Chat ID y que hayas iniciado el bot con /start.';
        }
        return desc || 'Error desconocido en Telegram.';
    }
    
    // Enviar mensaje de test para verificar configuración
    async sendTestMessage() {
        const testMessage = `🤖 *Test de Notificaciones*\n\n✅ El bot de Telegram está funcionando correctamente.\n\n⏰ ${new Date().toLocaleString('es-ES')}`;
        
        try {
            await this.sendMessage(testMessage);
            console.log('✅ Mensaje de test enviado correctamente');
            return true;
        } catch (error) {
            console.error('❌ Error en mensaje de test:', error);
            if (typeof window !== 'undefined') {
                alert('❌ Telegram: ' + (error.message || 'Error enviando el test'));
            }
            return false;
        }
    }
    
    
    // Obtener información del bot
    async getBotInfo() {
        if (!this.botToken) return null;
        
        try {
            const response = await fetch(`${this.apiUrl}/getMe`);
            const result = await response.json();
            return result.ok ? result.result : null;
        } catch (error) {
            console.error('Error obteniendo info del bot:', error);
            return null;
        }
    }
}

// Crear instancia global
const telegramNotifier = new TelegramNotifier();

// Función de conveniencia para enviar notificaciones
async function notifyPayment(paymentData) {
    return await telegramNotifier.sendPaymentNotification(paymentData);
}

// Función de test
async function testTelegramNotification() {
    return await telegramNotifier.sendTestMessage();
}

// Exportar para uso en Node.js si está disponible
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        TelegramNotifier,
        telegramNotifier,
        notifyPayment,
        testTelegramNotification
    };
}

// Hacer disponible en el navegador
if (typeof window !== 'undefined') {
    window.TelegramNotifier = TelegramNotifier;
    window.telegramNotifier = telegramNotifier;
    window.notifyPayment = notifyPayment;
    window.testTelegramNotification = testTelegramNotification;
}

