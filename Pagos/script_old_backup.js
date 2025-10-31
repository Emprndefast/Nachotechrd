// ===== SISTEMA DE NOTIFICACIONES PROFESIONAL =====
// Sistema de notificaciones para reemplazar alert() básicos

function showNotification(title, message, type = 'info', duration = 5000) {
    const container = document.getElementById('notificationContainer');
    if (!container) {
        // Fallback a alert si no existe el contenedor
        alert(`${title}\n\n${message}`);
        return;
    }
    
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    const icons = {
        'success': '✅',
        'error': '❌',
        'warning': '⚠️',
        'info': 'ℹ️'
    };
    
    const icon = icons[type] || icons.info;
    
    notification.innerHTML = `
        <div class="notification-header">
            <span class="notification-icon">${icon}</span>
            <div class="notification-content">
                <div class="notification-title">${title}</div>
                <div class="notification-message">${message}</div>
            </div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">&times;</button>
        <div class="notification-progress" style="animation-duration: ${duration}ms;"></div>
    `;
    
    container.appendChild(notification);
    
    // Remover después de la duración
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, duration);
}

// Función para mostrar error de forma profesional
function showError(title, message, duration = 7000) {
    showNotification(title, message, 'error', duration);
}

// Función para mostrar éxito de forma profesional
function showSuccess(title, message, duration = 5000) {
    showNotification(title, message, 'success', duration);
}

// Función para mostrar advertencia de forma profesional
function showWarning(title, message, duration = 6000) {
    showNotification(title, message, 'warning', duration);
}

// Función para mostrar información de forma profesional
function showInfo(title, message, duration = 5000) {
    showNotification(title, message, 'info', duration);
}
// ===== FIN SISTEMA DE NOTIFICACIONES =====

// Obtener el modal y elementos relacionados
let modal, infoModal, modalTitle, modalInfo, closeBtn, closeInfoBtn;
let currentMethod = null;

// FUNCIÓN NUEVA: Capturar email de URL para integrar con PHP
function capturarEmailURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const email = urlParams.get('email');
    const name = urlParams.get('name');
    
    if (email) {
        const emailInput = document.getElementById('userEmail');
        const serverEmailInput = document.getElementById('serverEmail');
        const serverEmailLocalInput = document.getElementById('serverEmailLocal');
        
        if (emailInput) emailInput.value = email;
        if (serverEmailInput) serverEmailInput.value = email;
        if (serverEmailLocalInput) serverEmailLocalInput.value = email;
        
        console.log('✅ Email capturado de URL:', email);
    }
    
    if (name) {
        const nameInput = document.getElementById('userName');
        if (nameInput) nameInput.value = decodeURIComponent(name);
    }
}

// Inicializar elementos del DOM cuando esté listo
function initializeModalElements() {
    modal = document.getElementById('paymentModal');
    infoModal = document.getElementById('infoModal');
    modalTitle = document.getElementById('modalTitle');
    modalInfo = document.getElementById('modalInfo');
    closeBtn = document.getElementsByClassName('close')[0];
    closeInfoBtn = document.getElementsByClassName('close-info')[0];
    
    // Capturar email de URL cuando carga la página
    capturarEmailURL();
    
    console.log('Modal elements initialized:', {
        modal: !!modal,
        modalTitle: !!modalTitle,
        modalInfo: !!modalInfo,
        closeBtn: !!closeBtn
    });
}

// Configuración del servidor
const SERVER_URL = window.location.origin; // URL del servidor actual

// Frases para rotación automática - Desbloqueos, Reparaciones y Herramientas
const slogans = [
    "Tu Aliado Digital de Confianza 💎",
    "Expertos en Tecnología y Soluciones 🔧",
    "Desbloqueos Rápidos y Seguros 🔓",
    "Reparaciones Profesionales Garantizadas ✅",
    "Herramientas Premium al Mejor Precio 🛠️",
    "Soporte Técnico 24/7 🚀",
    "La Mejor Tecnología para ti ⚡",
    "Soluciones Digitales Confiables 🌟",
    "Desbloqueo de iCloud Instantáneo 🎯",
    "Reparación de Dispositivos Garantizada 💼"
];

const subSlogans = [
    "Desbloqueos • Reparaciones • Herramientas Premium",
    "🔓 Desbloqueo de Cuentas • 🔧 Reparación de Dispositivos • 🛠️ Tools Premium",
    "📱 Reparación de iCloud • 🔑 Desbloqueo de Patrones • 💎 Software Original",
    "⚙️ Herramientas Profesionales • ⚡ Desbloqueos Instantáneos • 🛡️ Soporte 24/7",
    "✅ Reparaciones Garantizadas • 🎯 Tools Únicas • 💰 Precios Inigualables",
    "📞 Desbloqueo por IMEI • 🔧 Reparación de Teléfonos • 🛠️ Herramientas Pro",
    "🎯 Solución Total para tu Dispositivo • ⚡ Reparaciones Rápidas • 🛠️ Tools Premium",
    "🚀 Desbloqueos y Más • 💎 La Tecnología que Necesitas • ⚡ Resultados Inmediatos",
    "🔓 iCloud • 📱 Cuentas • 🔑 Teléfonos • 🛠️ Todo en un Solo Lugar",
    "⚡ Velocidad • 🎯 Precisión • ✅ Garantía • 💎 Calidad Premium"
];

let sloganIndex = 0;
let subSloganIndex = 0;

// Función para rotar slogans
function rotateSlogans() {
    const sloganElement = document.getElementById('rotatingSlogan');
    const subSloganElement = document.getElementById('rotatingSubSlogan');
    
    if (sloganElement && subSloganElement) {
        // Efecto de fade out
        sloganElement.style.opacity = '0';
        subSloganElement.style.opacity = '0';
        
        setTimeout(() => {
            // Cambiar texto
            sloganIndex = (sloganIndex + 1) % slogans.length;
            subSloganIndex = (subSloganIndex + 1) % subSlogans.length;
            
            sloganElement.textContent = slogans[sloganIndex];
            subSloganElement.textContent = subSlogans[subSloganIndex];
            
            // Efecto de fade in
            sloganElement.style.opacity = '1';
            subSloganElement.style.opacity = '1';
        }, 300);
    }
}

// Iniciar rotación cada 5 segundos (tiempo suficiente para leer)
setInterval(rotateSlogans, 5000);

// Rotación del banner de noticias
let bannerIndex = 0;
function rotateBanners() {
    const banners = document.querySelectorAll('.banner-slide');
    if (banners.length > 0) {
        // Remover clase active de todos
        banners.forEach(banner => banner.classList.remove('active'));
        
        // Agregar active al banner actual
        banners[bannerIndex].classList.add('active');
        
        // Incrementar índice
        bannerIndex = (bannerIndex + 1) % banners.length;
    }
}

// Iniciar rotación del banner cada 4 segundos
setInterval(rotateBanners, 4000);

// Activar el primer banner al cargar
document.addEventListener('DOMContentLoaded', () => {
    rotateBanners();
});

// Carrusel de Imágenes
let slideIndex = 0;

function showSlide(n) {
    const slides = document.getElementsByClassName('carousel-slide');
    const dots = document.getElementsByClassName('dot');
    
    slideIndex = n;
    
    if (slideIndex >= slides.length) {
        slideIndex = 0;
    }
    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    }
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove('active');
        dots[i].classList.remove('active');
    }
    
    slides[slideIndex].classList.add('active');
    dots[slideIndex].classList.add('active');
}

function changeSlide(n) {
    slideIndex += n;
    showSlide(slideIndex);
}

function currentSlide(n) {
    slideIndex = n - 1;
    showSlide(slideIndex);
}

// Auto-slide del carrusel
setInterval(() => {
    changeSlide(1);
}, 5000);

// Inicializar el carrusel
showSlide(0);

// Agregar transición CSS
const style = document.createElement('style');
style.textContent = `
    .slogan, .sub-slogan {
        transition: opacity 0.3s ease-in-out;
    }
`;
document.head.appendChild(style);

// Función para alternar grupos (disponible globalmente)
function toggleGroup(element) {
    if (!element) return;
    var group = element.closest ? element.closest('.payment-group') : (element.parentElement || null);
    if (!group) return;
    var alreadyOpen = group.classList.contains('active');
    // Cerrar todos
    document.querySelectorAll('.payment-group').forEach(function(g){
        g.classList.remove('active');
        var b = g.querySelector('.payment-main-button');
        var s = g.querySelector('.payment-submenu');
        if (b) b.classList.remove('active');
        if (s) s.classList.remove('active');
    });
    // Si ya estaba abierto, simplemente lo dejamos cerrado
    if (alreadyOpen) return;
    // Abrir solo el clicado
    group.classList.add('active');
    var submenu = group.querySelector('.payment-submenu');
    if (submenu) submenu.classList.add('active');
    element.classList.add('active');
}

// Hacer función disponible globalmente
window.toggleGroup = toggleGroup;

// Función de test para debug
window.testToggle = function() {
    console.log('Testing toggle function...');
    const firstGroup = document.querySelector('.payment-main-button');
    if (firstGroup) {
        console.log('Found first group:', firstGroup);
        toggleGroup(firstGroup);
    } else {
        console.error('No payment groups found');
    }
};

// Notificaciones de Telegram - Sistema simplificado y activo
// Las notificaciones se envían automáticamente al procesar pagos

// Event listeners para botones de pago
function initializePaymentButtons() {
    console.log('Initializing payment buttons...');
    
    // Inicializar elementos del modal
    initializeModalElements();
    
    // Verificar que paymentMethods esté disponible
    if (typeof paymentMethods === 'undefined') {
        console.error('paymentMethods no está definido. ¿Se cargó paymentData.js?');
        return;
    }
    // Asegurar que todos los grupos inicien cerrados
    document.querySelectorAll('.payment-group').forEach(function(g){
        g.classList.remove('active');
        var b = g.querySelector('.payment-main-button');
        var s = g.querySelector('.payment-submenu');
        if (b) b.classList.remove('active');
        if (s) s.classList.remove('active');
    });
    
    // Botones de métodos de pago
    const paymentButtons = document.querySelectorAll('.payment-button');
    console.log(`Found ${paymentButtons.length} payment buttons`);
    
    paymentButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        const method = button.dataset.method;
            console.log('Payment button clicked:', method);
            if (method) {
            openPaymentModal(method);
        }
        e.stopPropagation();
    });
});
    
    // Configurar cerrar modal
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }
    
    if (closeInfoBtn) {
        closeInfoBtn.addEventListener('click', () => {
            infoModal.style.display = 'none';
        });
    }
    
    // Cerrar modal al hacer click fuera
    window.addEventListener('click', (e) => {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
        if (e.target === infoModal) {
            infoModal.style.display = 'none';
        }
    });
    
    console.log('Payment system initialized successfully');
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializePaymentButtons);
} else {
    // Usar setTimeout para asegurar que todos los scripts se carguen
    setTimeout(initializePaymentButtons, 100);
}

// Forzar que solo se abra el grupo clicado y evitar aperturas múltiples
(function bindGroupToggles(){
    function bind() {
        var buttons = document.querySelectorAll('.payment-main-button');
        buttons.forEach(function(btn){
            btn.addEventListener('click', function(ev){
                ev.preventDefault();
                ev.stopPropagation();
                toggleGroup(btn);
            }, { passive: true });
            // Cerrar con click en la flecha también (icono derecho)
            var arrow = btn.querySelector('i:last-child');
            if (arrow) {
                arrow.addEventListener('click', function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    toggleGroup(btn);
                }, { passive: true });
            }
        });
        // Cerrar al salir con el mouse (desktop)
        document.querySelectorAll('.payment-group').forEach(function(group){
            var closeTimer = null;
            group.addEventListener('mouseleave', function(){
                closeTimer = setTimeout(function(){
                    group.classList.remove('active');
                    var b = group.querySelector('.payment-main-button');
                    var s = group.querySelector('.payment-submenu');
                    if (b) b.classList.remove('active');
                    if (s) s.classList.remove('active');
                }, 150);
            });
            group.addEventListener('mouseenter', function(){
                if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
            });
        });
        // Evitar que clicks internos (botones de método) re-accionen en cabecera
        document.querySelectorAll('.payment-submenu .payment-button').forEach(function(item){
            item.addEventListener('click', function(e){ e.stopPropagation(); }, { passive: true });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bind);
    } else {
        setTimeout(bind, 50);
    }
})();

// Abrir modal de pago
function openPaymentModal(method) {
    currentMethod = method;
    const paymentData = paymentMethods[method];
    
    if (!paymentData) {
        alert('Método de pago no encontrado');
        return;
    }

    // OCULTAR COMISIÓN INMEDIATAMENTE AL ABRIR EL MODAL (antes de cualquier otra cosa)
    const modalCommissionContainer = document.getElementById('modalCommissionContainer');
    if (modalCommissionContainer) {
        modalCommissionContainer.style.display = 'none';
        modalCommissionContainer.style.visibility = 'hidden';
        modalCommissionContainer.style.opacity = '0';
        modalCommissionContainer.style.height = '0';
        modalCommissionContainer.style.padding = '0';
        modalCommissionContainer.style.margin = '0';
        modalCommissionContainer.style.overflow = 'hidden';
        modalCommissionContainer.setAttribute('data-hidden', 'true');
    }

    modalTitle.textContent = paymentData.name;
    
    // Definir si es USDT antes de usarlo
    const isUSDT = method === 'usdt' || method === 'usdterc20' || method === 'usdtbep20';
    
    // Mostrar/ocultar campos específicos según el método de pago
    togglePaymentFields(method);
    
    // Crear HTML para la información bancaria
    let html = '<div class="bank-details">';
    html += `<h3>Información del Método de Pago</h3>`;
    
    // Verificar si tiene QR Code
    let hasQR = false;
    if (paymentData.details.qrCode) {
        hasQR = true;
        html += `<div class="qr-code-container">`;
        
        if (isUSDT) {
            const networkName = method === 'usdt' ? 'TRC20' : 
                              method === 'usdterc20' ? 'ERC20' : 
                              method === 'usdtbep20' ? 'BEP20' : 'USDT';
            html += `<img src="${paymentData.details.qrCode}" alt="QR Code USDT ${networkName}" class="qr-code">`;
            html += `<p class="qr-note"><strong>Escanea para enviar USDT (${networkName})</strong></p>`;
        } else {
            // Para métodos no-USDT (como YAPE)
            const methodName = paymentData.name || method.toUpperCase();
            html += `<img src="${paymentData.details.qrCode}" alt="QR Code ${methodName}" class="qr-code">`;
            html += `<p class="qr-note"><strong>Escanea para pagar con ${methodName}</strong></p>`;
        }
        
        html += `</div>`;
    }
    
    Object.entries(paymentData.details).forEach(([key, value]) => {
        // Saltar el QR code, lo mostramos arriba
        if (key === 'qrCode') return;
        
        const label = key
            .replace(/([A-Z])/g, ' $1')
            .replace(/^./, str => str.toUpperCase())
            .replace(/(\d)$/g, ' $1');
        
        html += `<p><strong>${label}:</strong> ${value}</p>`;
    });
    
    html += '</div>';
    modalInfo.innerHTML = html;
    
    // Resetear formulario
    document.getElementById('paymentForm').reset();
    
    // Configurar campos requeridos según el método (reutilizar isUSDT ya declarado)
    const isLocalPayment = ['yape', 'bcp', 'mexico', 'bancopopular', 'banreservas', 'bhd', 'mioreserva', 'qik', 'lemoncash', 'binance', 'paypalcustom'].includes(method);
    
    const serverEmailInput = document.getElementById('serverEmail');
    const serverEmailLocalInput = document.getElementById('serverEmailLocal');
    
    if (serverEmailInput) {
        serverEmailInput.required = isUSDT;
    }
    if (serverEmailLocalInput) {
        serverEmailLocalInput.required = isLocalPayment;
    }
    
    // Mostrar calculadora del modal (solo para métodos no-crypto - reutilizar isUSDT ya declarado)
    const modalCalculator = document.getElementById('modalCalculator');
    
    if (modalCalculator) {
        if (isUSDT) {
            // Para criptomonedas USDT, ocultar calculadora
            modalCalculator.style.display = 'none';
        } else {
            // Para métodos locales, mostrar calculadora
            modalCalculator.style.display = 'block';
            initializeModalCalculator(method, paymentData);
        }
    }
    
    // OCULTAR COMISIÓN UNA VEZ MÁS ANTES DE MOSTRAR EL MODAL
    if (modalCommissionContainer) {
        modalCommissionContainer.style.display = 'none';
        modalCommissionContainer.style.visibility = 'hidden';
        modalCommissionContainer.style.opacity = '0';
        modalCommissionContainer.style.height = '0';
    }
    
    // Mostrar modal
    modal.style.display = 'block';
    
    // OCULTAR COMISIÓN DESPUÉS DE MOSTRAR EL MODAL (última protección)
    setTimeout(function() {
        if (modalCommissionContainer) {
            modalCommissionContainer.style.display = 'none';
            modalCommissionContainer.style.visibility = 'hidden';
        }
    }, 10);
}

// Función para mostrar/ocultar campos específicos según el método de pago
function togglePaymentFields(method) {
    // Limpiar todos los campos específicos
    const allSpecific = document.querySelectorAll('.usdt-specific, .local-payment-specific, .yape-specific, .bcp-specific, .mexico-specific, .dominicana-specific');
    const allWarnings = document.querySelectorAll('.usdt-warning, .yape-warning, .bcp-warning, .mexico-warning, .dominicana-warning, .lemoncash-warning');
    const generalElements = document.querySelectorAll('.general-amount, .general-ref');
    
    // Ocultar todos los elementos específicos
    allSpecific.forEach(element => element.style.display = 'none');
    allWarnings.forEach(element => element.style.display = 'none');
    
    // Determinar qué campos mostrar
    const isMethodUSDT = method === 'usdt' || method === 'usdterc20' || method === 'usdtbep20';
    const isLocalPayment = ['yape', 'bcp', 'mexico', 'bancopopular', 'banreservas', 'bhd', 'mioreserva', 'qik', 'lemoncash', 'binance', 'paypalcustom'].includes(method);
    
    // Mostrar campos apropiados
    if (isMethodUSDT) {
        document.querySelectorAll('.usdt-specific').forEach(el => el.style.display = 'block');
        document.querySelector('.usdt-warning').style.display = 'block';
        generalElements.forEach(element => element.style.display = 'none');
        
        // Actualizar contenido específico según la red USDT
        updateUSDTNetworkInfo(method);
    } else if (isLocalPayment) {
        document.querySelectorAll('.local-payment-specific').forEach(el => el.style.display = 'block');
        generalElements.forEach(element => element.style.display = 'none');
        
        // Mostrar campos específicos del método
        showMethodSpecificFields(method);
    } else {
        // Métodos generales
        generalElements.forEach(element => element.style.display = 'inline');
    }
}

// Función para actualizar información específica de redes USDT
function updateUSDTNetworkInfo(method) {
    const networkName = method === 'usdt' ? 'TRC20' : 
                      method === 'usdterc20' ? 'ERC20' : 
                      method === 'usdtbep20' ? 'BEP20' : 'USDT';
    const networkFull = method === 'usdt' ? 'TRC20 (Tron)' : 
                      method === 'usdterc20' ? 'ERC20 (Ethereum)' : 
                      method === 'usdtbep20' ? 'BEP20 (BNB Chain)' : 'USDT';
    
    // Actualizar nota de transacción
    const transactionNote = document.getElementById('transactionNote');
    if (transactionNote) {
        transactionNote.textContent = `Ingresa el hash de la transacción de USDT en la red ${networkName}`;
    }
    
    // Actualizar warning de red
    const networkWarning = document.getElementById('networkWarning');
    if (networkWarning) {
        networkWarning.textContent = networkFull;
    }
}

// Función para mostrar campos específicos por método
function showMethodSpecificFields(method) {
    // Mostrar campos específicos del método
    const methodClass = `.${method}-specific`;
    const methodWarning = `.${method}-warning`;
    
    document.querySelectorAll(methodClass).forEach(el => el.style.display = 'block');
    
    const warningElement = document.querySelector(methodWarning);
    if (warningElement) {
        warningElement.style.display = 'block';
    }
    
    // Casos especiales para República Dominicana
    if (method === 'bancopopular' || method === 'banreservas') {
        document.querySelectorAll('.dominicana-specific').forEach(el => el.style.display = 'block');
        document.querySelector('.dominicana-warning').style.display = 'block';
    }
}

// Calculadora específica del modal
function initializeModalCalculator(method, paymentData) {
    console.log('Initializing modal calculator for:', method);
    
    // Obtener elementos de la calculadora del modal
    const modalReceiveAmount = document.getElementById('modalReceiveAmount');
    const modalSendAmount = document.getElementById('modalSendAmount');
    const modalCommission = document.getElementById('modalCommission');
    const modalLocalAmount = document.getElementById('modalLocalAmount');
    const modalConversion = document.getElementById('modalConversion');
    const modalCalcNote = document.getElementById('modalCalcNote');
    
    if (!modalReceiveAmount) return;
    
    // Ocultar comisión inmediatamente al inicializar (sin esperar cálculos)
    const modalCommissionContainer = document.getElementById('modalCommissionContainer');
    if (modalCommissionContainer) {
        modalCommissionContainer.style.display = 'none';
        modalCommissionContainer.style.visibility = 'hidden';
    }
    if (modalCommission) {
        modalCommission.textContent = '0.00 USD';
    }
    
    // Configurar calculadora según el método
    const config = getPaymentMethodConfig(method, paymentData);
    
    // Actualizar etiquetas y notas
    updateModalCalculatorLabels(config);
    
    // Asegurar que la nota no mencione comisión
    if (modalCalcNote && modalCalcNote.textContent) {
        const noteText = modalCalcNote.textContent.toLowerCase();
        if (noteText.includes('comisión') || noteText.includes('comision')) {
            // Reemplazar cualquier mención de comisión
            modalCalcNote.textContent = modalCalcNote.textContent.replace(/[Cc]omisi[óo]n[^.]*/gi, '').trim();
        }
    }
    
    // Function para calcular
    function calculateModal() {
        const receiveAmount = parseFloat(modalReceiveAmount.value) || 0;
        
        // Ocultar comisión SIEMPRE al inicio (sin excepción)
        const modalCommissionContainer = document.getElementById('modalCommissionContainer');
        if (modalCommissionContainer) {
            modalCommissionContainer.style.display = 'none';
            modalCommissionContainer.style.visibility = 'hidden';
        }
        if (modalCommission) {
            modalCommission.textContent = '0.00 USD';
        }
        
        // Validar monto mínimo
        if (receiveAmount > 0 && receiveAmount < config.minimumAmount) {
            modalSendAmount.textContent = `Mínimo: ${config.minimumAmount} ${config.baseCurrency}`;
            modalSendAmount.style.color = '#f44336';
            return;
        } else {
            modalSendAmount.style.color = '';
        }
        
        // Calcular monto a enviar (SIN comisión - el monto que se envía es igual al que se recibe)
        const totalToSend = receiveAmount; // NO agregar comisión
        
        // Actualizar resultados
        modalSendAmount.textContent = `${totalToSend.toFixed(2)} ${config.sendCurrency}`;
        
        // Asegurar que la comisión esté oculta nuevamente
        if (modalCommissionContainer) {
            modalCommissionContainer.style.display = 'none';
        }
        
        // Conversión local si aplica
        if (config.localRate && config.localCurrency) {
            const localAmount = totalToSend * config.localRate;
            modalLocalAmount.textContent = `${localAmount.toFixed(2)} ${config.localCurrency}`;
            if (modalConversion) {
                modalConversion.style.display = 'flex';
            }
        } else if (modalConversion) {
            modalConversion.style.display = 'none';
        }
    }
    
    // Event listener para cálculo en tiempo real
    modalReceiveAmount.addEventListener('input', calculateModal);
    modalReceiveAmount.addEventListener('change', calculateModal);
    
    // Cálculo inicial
    calculateModal();
}

// Función para obtener configuración del método de pago
function getPaymentMethodConfig(method, paymentData) {
    const config = {
        baseCurrency: 'USD',
        sendCurrency: 'USD',
        commission: 0, // sin comisión en calculadora
        minimumAmount: 1,
        localRate: null,
        localCurrency: null,
        note: '💡 Calculadora: conversión directa por tasa local'
    };
    
    // Configuraciones específicas por método
    if (method === 'usdt' || method === 'usdterc20' || method === 'usdtbep20') {
        config.sendCurrency = 'USDT';
        config.minimumAmount = 10;
        config.note = '💰 USDT es equivalente a USD (1:1).';
    } else if (method === 'yape' || method === 'bcp') {
        config.localRate = 4; // 1 USD = 4 soles
        config.localCurrency = 'soles';
        // YAPE mínimo 40 soles => 10 USD; BCP mantiene 10 soles (2.5 USD),
        // pero tomamos el más alto por método cuando se calcule validación específica.
        // Aquí fijamos 10 USD para que la calculadora de YAPE lo respete.
        config.minimumAmount = method === 'yape' ? 10 : 2.5;
        config.note = '🇵🇪 1 crédito = 4 soles peruanos.';
    } else if (method === 'mexico') {
        config.localRate = 23; // 1 USD = 23 pesos
        config.localCurrency = 'pesos MXN';
        config.minimumAmount = 10; // 230 pesos / 23
        config.note = '🇲🇽 1 crédito = 23 pesos mexicanos.';
    } else if (method === 'bancopopular' || method === 'banreservas') {
        config.localRate = 68; // 1 USD = 68 pesos
        config.localCurrency = 'pesos DOP';
        config.minimumAmount = 10; // 680 pesos / 68
        config.note = '🇩🇴 1 crédito = 68 pesos dominicanos.';
    } else if (method === 'lemoncash') {
        config.sendCurrency = 'USDT';
        config.minimumAmount = 1;
        config.note = '🍋 Lemon Cash maneja USDT directamente.';
    }
    
    return config;
}

// Función para actualizar etiquetas de la calculadora
function updateModalCalculatorLabels(config) {
    // Actualizar etiqueta del monto a enviar
    const sendAmountLabel = document.querySelector('#modalSendAmount').parentElement.querySelector('.calc-label');
    if (sendAmountLabel) {
        if (config.sendCurrency === 'USDT') {
            sendAmountLabel.textContent = '💰 USDT a Enviar:';
        } else {
            sendAmountLabel.textContent = `💰 ${config.sendCurrency} a Enviar:`;
        }
    }
    
    // Actualizar nota
    const modalCalcNote = document.getElementById('modalCalcNote');
    if (modalCalcNote) {
        modalCalcNote.textContent = config.note;
    }
}

// Los event listeners de cerrar modal ahora están en initializePaymentButtons()

// Función para mostrar información de recarga
function showRechargeInfo() {
    if (!infoModal) {
        initializeModalElements();
    }
    if (infoModal) {
    infoModal.style.display = 'block';
    }
}

// Manejar envío del formulario de pago
async function handlePayment(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitBtn = form.querySelector('.submit-btn');
    const originalText = submitBtn.textContent;
    
    // Cambiar botón a estado de carga
    submitBtn.innerHTML = '<span class="loading"></span> Procesando...';
    submitBtn.disabled = true;
    
    // Obtener datos del formulario
    const paymentData = {
        method: currentMethod,
        userName: document.getElementById('userName').value,
        userEmail: document.getElementById('userEmail').value,
        amount: parseFloat(document.getElementById('amount').value),
        transactionRef: document.getElementById('transactionRef').value,
        additionalInfo: document.getElementById('additionalInfo').value,
        timestamp: new Date().toISOString()
    };
    
    // Agregar campos específicos según el método de pago
    const isUSDT = currentMethod === 'usdt' || currentMethod === 'usdterc20' || currentMethod === 'usdtbep20';
    const isLocalPayment = ['yape', 'bcp', 'mexico', 'bancopopular', 'banreservas', 'lemoncash'].includes(currentMethod);
    
    if (isUSDT) {
        const serverEmail = document.getElementById('serverEmail').value;
        if (serverEmail) {
            paymentData.serverEmail = serverEmail;
        }
        
        // Validar monto mínimo para USDT
        if (paymentData.amount < 10) {
            showError('Error de Validación', 'El monto mínimo para USDT es de 10 USD. Si envías menos, perderás tu dinero.');
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            return;
        }
        
        // Información adicional específica de USDT según la red
        paymentData.network = currentMethod === 'usdt' ? 'TRC20' : 
                            currentMethod === 'usdterc20' ? 'ERC20' : 'BEP20';
        paymentData.cryptoType = 'USDT';
        paymentData.networkFull = currentMethod === 'usdt' ? 'Tron (TRC20)' : 
                                currentMethod === 'usdterc20' ? 'Ethereum (ERC20)' : 'BNB Chain (BEP20)';
    } else if (isLocalPayment) {
        const serverEmailLocal = document.getElementById('serverEmailLocal').value;
        if (serverEmailLocal) {
            paymentData.serverEmail = serverEmailLocal;
        }
        
        // Validaciones específicas por método
        const validationResult = validateLocalPaymentMethod(currentMethod, paymentData.amount);
        if (!validationResult.valid) {
            showError('Error de Validación', validationResult.message);
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            return;
        }
        
        // Información adicional del método local
        paymentData.paymentMethod = currentMethod;
        paymentData.exchangeRate = getExchangeRateForMethod(currentMethod);
    }
    
    try {
        // Enviar datos al servidor
        const paymentApiUrl = (typeof CONFIG !== 'undefined' && CONFIG.URLS && CONFIG.URLS.PAYMENT_API)
            ? CONFIG.URLS.PAYMENT_API
            : 'api/payment.php';

        const response = await fetch(paymentApiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(paymentData)
        });
        
        // Intentar parsear JSON; si el servidor no ejecuta PHP devolverá HTML con "<?php"
        let result;
        const contentType = (response.headers && response.headers.get('content-type')) || '';
        if (contentType.includes('application/json')) {
            result = await response.json();
        } else {
            const rawText = await response.text();
            throw new Error(`Respuesta no JSON del servidor. Indica que PHP no se está ejecutando. Vista previa: ${rawText.substring(0,200)}`);
        }
        
        if (response.ok) {
            // Éxito
            submitBtn.textContent = '✓ Pago Enviado Correctamente';
            submitBtn.style.background = 'linear-gradient(135deg, #4CAF50 0%, #45a049 100%)';
            
            // 🚨 ENVIAR NOTIFICACIÓN POR TELEGRAM 🚨
            try {
                const notificationData = {
                    ...paymentData,
                    methodName: paymentMethods[currentMethod]?.name || currentMethod,
                    timestamp: new Date().toISOString()
                };
                
                // Agregar conversión local si aplica
                if (isLocalPayment) {
                    const config = getPaymentMethodConfig(currentMethod, paymentMethods[currentMethod]);
                    if (config.localRate && config.localCurrency) {
                        const localAmount = paymentData.amount * config.localRate;
                        notificationData.localAmount = `${localAmount.toFixed(2)} ${config.localCurrency}`;
                        notificationData.exchangeRate = config.note;
                    }
                }
                
                // Enviar notificación por Telegram (no bloquea el flujo)
                if (typeof notifyPayment === 'function') {
                    notifyPayment(notificationData).catch(error => {
                        console.error('Error enviando notificación Telegram:', error);
                    });
                } else {
                    console.warn('Sistema de notificaciones Telegram no disponible');
                }
            } catch (notificationError) {
                console.error('Error preparando notificación:', notificationError);
            }
            
            // Cerrar modal después de 2 segundos
            setTimeout(() => {
                modal.style.display = 'none';
                form.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                submitBtn.style.background = 'linear-gradient(135deg, #4CAF50 0%, #45a049 100%)';
            }, 2000);
            
            // Mensaje de éxito detallado con información del pago
            const successTitle = '✅ ¡Pago Registrado Correctamente!';
            const successMessage = `📋 Método: ${paymentMethods[currentMethod]?.name || currentMethod}
💰 Monto: $${paymentData.amount} USD
🔗 Referencia: ${paymentData.transactionRef}

📧 Confirmación por email: En proceso
📱 Notificación al equipo: Enviada
💾 Guardado en base de datos: ✅

⏰ Procesamiento: 5-30 minutos
🎮 Los créditos aparecerán en tu cuenta del servidor

¡Gracias por tu pago! 🎉`;

            showSuccess(successTitle, successMessage, 8000);

            // Redirigir al área de cliente después de confirmar
            try {
                setTimeout(() => {
                    window.location.href = 'https://cymartunlock.com/main';
                }, 3500);
            } catch (e) {
                console.warn('Redirección no disponible:', e);
            }
        } else {
            throw new Error(result.error || 'Error al procesar el pago');
        }
    } catch (error) {
        console.error('Error:', error);
        submitBtn.textContent = '✗ Error al Enviar';
        submitBtn.style.background = 'linear-gradient(135deg, #f44336 0%, #d32f2f 100%)';
        
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            submitBtn.style.background = 'linear-gradient(135deg, #4CAF50 0%, #45a049 100%)';
        }, 3000);
        
        showError('Error al Procesar el Pago', 'Por favor, inténtalo de nuevo o contacta con soporte. Si el problema persiste, escríbenos a @CymartSoporte en Telegram.', 8000);
    }
}

// Validación en tiempo real
document.getElementById('userEmail').addEventListener('blur', (e) => {
    const email = e.target.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email && !emailRegex.test(email)) {
        showWarning('Email Inválido', 'Por favor, ingrese un correo electrónico válido');
    }
});

document.getElementById('amount').addEventListener('input', (e) => {
    const amount = parseFloat(e.target.value);
    if (amount && amount < 0) {
        showWarning('Monto Inválido', 'El monto no puede ser negativo');
        e.target.value = '';
    }
});

// Función para mostrar Login
function showLogin() {
    alert('Sistema de Login - En desarrollo');
    // Aquí puedes redirigir a la página de login o mostrar un modal
}

// Función para toggle del menú móvil
function toggleMobileMenu() {
    const menuContainer = document.querySelector('.navbar-menu-container');
    menuContainer.classList.toggle('active');
}

// Función para suscribirse al newsletter
function subscribeNewsletter() {
    const email = document.getElementById('newsletterEmail').value;
    
    if (!email) {
        showWarning('Email Requerido', 'Por favor, ingresa tu correo electrónico');
        return;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showWarning('Email Inválido', 'Por favor, ingresa un correo electrónico válido');
        return;
    }
    
    // Aquí puedes agregar la lógica para enviar el email al servidor
    showSuccess('¡Suscripción Exitosa!', `Gracias por suscribirte. Pronto recibirás nuestras actualizaciones en ${email}`);
    document.getElementById('newsletterEmail').value = '';
}

// Calculadora de Divisas
const currencyCalculator = {
    // Función para obtener la configuración actual
    getConfig: function() {
        return window.currencyConfig || {
            exchangeRates: { USD_DOP: 59.50 },
            fees: { serviceCommission: 6.50 },
            display: { decimalPlaces: 2 }
        };
    },
    
    // Función para formatear números a moneda
    formatCurrency: function(amount, decimals = null) {
        const config = this.getConfig();
        const places = decimals !== null ? decimals : config.display.decimalPlaces;
        const formatted = parseFloat(amount).toFixed(places);
        return formatted.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    },
    
    // Función para calcular automáticamente todos los montos
    calculate: function() {
        const config = this.getConfig();
        
        // Buscar el input correcto (normal o mini)
        let receiveInput = document.getElementById('receiveAmount');
        if (!receiveInput) {
            receiveInput = document.querySelector('.mini-input-wrapper input');
        }
        
        const receiveAmount = receiveInput ? parseFloat(receiveInput.value) || 0 : 0;
        
        // Validar el monto
        const validation = config.validateAmount ? config.validateAmount(receiveAmount) : { valid: true };
        
        if (!validation.valid && receiveAmount > 0) {
            // Mostrar error si es necesario
            console.warn('Validation error:', validation.error);
        }
        
        // Calcular monto total en USDT (moneda principal del servidor)
        const usdtAmount = config.calculateTotal ? 
            config.calculateTotal(receiveAmount) : 
            receiveAmount + config.fees.serviceCommission;
        
        // USDT = USD (1:1 estable)
        const sendAmount = usdtAmount; // Equivalente en USD para referencia
        
        // Calcular conversiones de referencia
        const exchangeRate = config.getExchangeRate ? 
            config.getExchangeRate('USD', 'DOP') : 
            config.exchangeRates.USD_DOP;
        
        const pesosAmount = sendAmount * exchangeRate;
        
        // Actualizar la interfaz
        this.updateDisplay({
            baseAmount: receiveAmount,
            usdtAmount: usdtAmount,      // Cantidad principal en USDT
            sendAmount: sendAmount,      // Equivalente en USD (referencia)
            pesosAmount: pesosAmount,    // Equivalente en DOP (referencia)
            commission: config.fees.serviceCommission,
            total: usdtAmount,           // Total es en USDT
            exchangeRate: exchangeRate
        });
    },
    
    // Función para actualizar todos los elementos de la interfaz
    updateDisplay: function(amounts) {
        const config = this.getConfig();
        
        // Helper function para actualizar elementos si existen
        const updateElement = (id, value) => {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = this.formatCurrency(value);
            }
        };
        
        // Actualizar monto principal en USDT
        updateElement('usdtAmount', amounts.usdtAmount);
        
        // Actualizar montos de referencia
        updateElement('sendAmount', amounts.sendAmount);
        updateElement('pesosAmount', amounts.pesosAmount);
        
        // Actualizar desglose (todo en USDT)
        updateElement('baseAmount', amounts.baseAmount);
        updateElement('commissionAmount', amounts.commission);
        updateElement('totalAmount', amounts.total);
        
        // Actualizar tasa de cambio
        updateElement('exchangeRate', amounts.exchangeRate);
        
        // Actualizar fecha de última actualización
        const rateInfo = config.rateInfo || {};
        let updateTime;
        
        if (rateInfo.lastUpdate) {
            const lastUpdate = new Date(rateInfo.lastUpdate);
            updateTime = lastUpdate.toLocaleDateString('es-ES', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        } else {
            const now = new Date();
            updateTime = now.toLocaleDateString('es-ES', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }
        
        const rateUpdateElement = document.getElementById('rateUpdate');
        if (rateUpdateElement) {
            rateUpdateElement.textContent = `Actualizado: ${updateTime}`;
        }
    },
    
    // Función para actualizar las tasas de cambio
    updateExchangeRate: function(fromCurrency, toCurrency, newRate) {
        const config = this.getConfig();
        if (config.updateExchangeRate) {
            config.updateExchangeRate(fromCurrency, toCurrency, newRate);
            this.calculate(); // Recalcular con la nueva tasa
        }
    },
    
    // Función para actualizar la comisión
    updateCommission: function(newCommission) {
        const config = this.getConfig();
        if (config.updateCommission) {
            config.updateCommission(newCommission);
            this.calculate(); // Recalcular con la nueva comisión
        }
    },
    
    // Función para validar entrada en tiempo real
    validateInput: function(receiveInput) {
        const config = this.getConfig();
        const amount = parseFloat(receiveInput.value) || 0;
        
        if (amount > 0 && config.validateAmount) {
            const validation = config.validateAmount(amount);
            
            // Remover clases previas
            receiveInput.classList.remove('error', 'warning');
            
            if (!validation.valid) {
                receiveInput.classList.add('error');
                // Optionally show tooltip or message
                receiveInput.title = validation.error;
            } else {
                receiveInput.title = '';
            }
        } else {
            receiveInput.classList.remove('error', 'warning');
            receiveInput.title = '';
        }
    },
    
    // Función de inicialización
    init: function() {
        // Buscar tanto el input normal como el mini
        let receiveInput = document.getElementById('receiveAmount');
        
        if (!receiveInput) {
            // Si no encuentra el input principal, buscar en la calculadora mini
            receiveInput = document.querySelector('.mini-input-wrapper input');
        }
        
        if (receiveInput) {
            // Agregar event listeners para cálculo en tiempo real
            receiveInput.addEventListener('input', () => {
                this.calculate();
                this.validateInput(receiveInput);
            });
            
            receiveInput.addEventListener('change', () => {
                this.calculate();
                this.validateInput(receiveInput);
            });
            
            receiveInput.addEventListener('blur', () => {
                this.validateInput(receiveInput);
            });
            
            // Cálculo inicial
            this.calculate();
        }
    }
};

// Función para validar métodos de pago locales
function validateLocalPaymentMethod(method, amount) {
    const validations = {
        'yape': { 
            min: 10, // 40 soles / 4
            max: 125, // 500 soles / 4
            currency: 'USD',
            localMin: '40 soles',
            localMax: '500 soles' 
        },
        'bcp': { 
            min: 2.5, // 10 soles / 4 
            currency: 'USD',
            localMin: '10 soles' 
        },
        'mexico': { 
            min: 10, // 230 pesos / 23 
            currency: 'USD',
            localMin: '230 pesos' 
        },
        'bancopopular': { 
            min: 10, // 680 pesos / 68 
            currency: 'USD',
            localMin: '680 pesos' 
        },
        'banreservas': { 
            min: 10, // 680 pesos / 68 
            currency: 'USD',
            localMin: '680 pesos' 
        },
        'lemoncash': { 
            min: 1, 
            currency: 'USD' 
        }
    };
    
    const validation = validations[method];
    if (!validation) return { valid: true };
    
    if (amount < validation.min) {
        const message = validation.localMin ? 
            `Error: El monto mínimo para ${method.toUpperCase()} es ${validation.localMin} (${validation.min} USD equivalente).` :
            `Error: El monto mínimo para ${method.toUpperCase()} es ${validation.min} ${validation.currency}.`;
        return { valid: false, message };
    }
    
    if (validation.max && amount > validation.max) {
        const message = `Error: El monto máximo para ${method.toUpperCase()} es ${validation.localMax} (${validation.max} USD equivalente).`;
        return { valid: false, message };
    }
    
    return { valid: true };
}

// Función para obtener la tasa de cambio por método
function getExchangeRateForMethod(method) {
    const rates = {
        'yape': '1 crédito = 4 soles',
        'bcp': '1 crédito = 4 soles',
        'mexico': '1 crédito = 23 pesos',
        'bancopopular': '1 crédito = 68 pesos',
        'banreservas': '1 crédito = 68 pesos',
        'lemoncash': 'USDT directo'
    };
    
    return rates[method] || 'No especificada';
}

// Inicializar la calculadora cuando se cargue el DOM
document.addEventListener('DOMContentLoaded', () => {
    currencyCalculator.init();
});

