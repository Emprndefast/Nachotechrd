/**
 * ========================================================================
 * NACHOTECH RD PREMIUM PAYMENT SYSTEM - JavaScript
 * Version: 3.0 Premium Edition
 * Author: NTDESWEB
 * Description: Sistema completo con tema oscuro, búsqueda, favoritos, y más
 * ========================================================================
 */

'use strict';

// ==========================================================================
// CONFIGURACIÓN GLOBAL Y UTILIDADES
// ==========================================================================

const App = {
    version: '3.0.0',
    name: 'NachoTechRD Premium',
    initialized: false,
    currentMethod: null,
    favorites: [],
    theme: 'light',
    config: {
        loader: {
            duration: 1500,
            minDuration: 800
        },
        stats: {
            animationDuration: 2000,
            counterDelay: 100
        },
        notifications: {
            duration: 5000,
            maxStack: 5
        }
    }
};

// LocalStorage helper
const Storage = {
    get: (key, defaultValue = null) => {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (e) {
            console.error('Error reading from localStorage:', e);
            return defaultValue;
        }
    },
    set: (key, value) => {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (e) {
            console.error('Error writing to localStorage:', e);
            return false;
        }
    },
    remove: (key) => {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (e) {
            console.error('Error removing from localStorage:', e);
            return false;
        }
    }
};

// ==========================================================================
// SISTEMA DE NOTIFICACIONES MEJORADO
// ==========================================================================

const NotificationSystem = {
    container: null,
    stack: [],
    
    init() {
        this.container = document.getElementById('notificationContainer');
        if (!this.container) {
            console.warn('Notification container not found');
        }
    },
    
    show(title, message, type = 'info', duration = App.config.notifications.duration) {
        if (!this.container) {
            alert(`${title}\n\n${message}`);
            return;
        }
        
        // Limitar stack
        if (this.stack.length >= App.config.notifications.maxStack) {
            this.stack[0].remove();
            this.stack.shift();
        }
        
        const notification = this.create(title, message, type, duration);
        this.container.appendChild(notification);
        this.stack.push(notification);
        
        // Auto-remove
        setTimeout(() => {
            this.remove(notification);
        }, duration);
    },
    
    create(title, message, type, duration) {
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas ${icons[type] || icons.info}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">${title}</div>
                <div class="notification-message">${message}</div>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
            <div class="notification-progress" style="animation-duration: ${duration}ms;"></div>
        `;
        
        notification.querySelector('.notification-close').addEventListener('click', () => {
            this.remove(notification);
        });
        
        return notification;
    },
    
    remove(notification) {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
                const index = this.stack.indexOf(notification);
                if (index > -1) {
                    this.stack.splice(index, 1);
                }
            }
        }, 300);
    },
    
    success(title, message, duration) {
        this.show(title, message, 'success', duration);
    },
    
    error(title, message, duration) {
        this.show(title, message, 'error', duration);
    },
    
    warning(title, message, duration) {
        this.show(title, message, 'warning', duration);
    },
    
    info(title, message, duration) {
        this.show(title, message, 'info', duration);
    }
};

// Alias globales para compatibilidad
window.showNotification = (title, message, type, duration) => NotificationSystem.show(title, message, type, duration);
window.showSuccess = (title, message, duration) => NotificationSystem.success(title, message, duration);
window.showError = (title, message, duration) => NotificationSystem.error(title, message, duration);
window.showWarning = (title, message, duration) => NotificationSystem.warning(title, message, duration);
window.showInfo = (title, message, duration) => NotificationSystem.info(title, message, duration);

// ==========================================================================
// SISTEMA DE TEMA OSCURO/CLARO
// ==========================================================================

const ThemeManager = {
    current: 'light',
    
    init() {
        // Cargar tema guardado o detectar preferencia del sistema
        const saved = Storage.get('theme');
        const preferred = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        this.current = saved || preferred;
        
        this.apply(this.current);
        this.setupToggle();
        
        // Escuchar cambios en preferencias del sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!Storage.get('theme')) {
                this.apply(e.matches ? 'dark' : 'light');
            }
        });
    },
    
    apply(theme) {
        this.current = theme;
        document.documentElement.setAttribute('data-theme', theme);
        Storage.set('theme', theme);
    },
    
    toggle() {
        const newTheme = this.current === 'light' ? 'dark' : 'light';
        this.apply(newTheme);
    },
    
    setupToggle() {
        const toggle = document.getElementById('themeToggle');
        if (toggle) {
            toggle.addEventListener('click', () => this.toggle());
        }
    }
};

// ==========================================================================
// PAGE LOADER
// ==========================================================================

const PageLoader = {
    element: null,
    startTime: null,
    
    init() {
        this.element = document.getElementById('pageLoader');
        this.startTime = Date.now();
    },
    
    hide() {
        if (!this.element) return;
        
        const elapsed = Date.now() - this.startTime;
        const minDuration = App.config.loader.minDuration;
        
        if (elapsed < minDuration) {
            setTimeout(() => this.hideElement(), minDuration - elapsed);
        } else {
            this.hideElement();
        }
    },
    
    hideElement() {
        if (this.element) {
            this.element.classList.add('hidden');
            setTimeout(() => {
                this.element.style.display = 'none';
            }, 500);
        }
    }
};

// ==========================================================================
// HERO BANNER CAROUSEL
// ==========================================================================

const HeroBanner = {
    banners: [],
    currentIndex: 0,
    interval: null,
    
    init() {
        this.banners = document.querySelectorAll('.hero-banner');
        if (this.banners.length > 0) {
            this.start();
        }
    },
    
    start() {
        this.interval = setInterval(() => this.next(), 5000);
    },
    
    stop() {
        if (this.interval) {
            clearInterval(this.interval);
        }
    },
    
    show(index) {
        this.banners.forEach((banner, i) => {
            banner.classList.toggle('active', i === index);
        });
        
        const indicators = document.querySelectorAll('.indicator');
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });
        
        this.currentIndex = index;
    },
    
    next() {
        this.show((this.currentIndex + 1) % this.banners.length);
    },
    
    prev() {
        this.show((this.currentIndex - 1 + this.banners.length) % this.banners.length);
    }
};

// Funciones globales para controles del banner
window.changeHeroBanner = (direction) => {
    direction > 0 ? HeroBanner.next() : HeroBanner.prev();
};

window.setHeroBanner = (index) => {
    HeroBanner.show(index);
};

// ==========================================================================
// ANIMATED STATS COUNTER
// ==========================================================================

const StatsAnimator = {
    animated: false,
    
    init() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.animated) {
                    this.animateStats();
                    this.animated = true;
                }
            });
        }, { threshold: 0.5 });
        
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    },
    
    animateStats() {
        const statNumbers = document.querySelectorAll('.stat-number');
        
        statNumbers.forEach(stat => {
            const target = parseFloat(stat.dataset.target) || 0;
            const isDecimal = target % 1 !== 0;
            const duration = App.config.stats.animationDuration;
            const increment = target / (duration / 16); // 60fps
            
            let current = 0;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                stat.textContent = isDecimal ? current.toFixed(1) : Math.floor(current);
            }, 16);
        });
    }
};

// ==========================================================================
// SERVICES CAROUSEL
// ==========================================================================

const ServicesCarousel = {
    container: null,
    cardWidth: 0,
    
    init() {
        this.container = document.querySelector('.services-carousel');
        if (!this.container) return;
        
        // Calcular ancho de tarjeta
        const card = this.container.querySelector('.service-card');
        if (card) {
            this.cardWidth = card.offsetWidth + parseFloat(getComputedStyle(this.container).gap);
        }
    },
    
    scroll(direction) {
        if (!this.container) return;
        
        const scrollAmount = this.cardWidth * direction;
        this.container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
};

window.scrollServicesCarousel = (direction) => {
    ServicesCarousel.scroll(direction);
};

// ==========================================================================
// PAYMENT SEARCH
// ==========================================================================

const PaymentSearch = {
    input: null,
    clearBtn: null,
    
    init() {
        this.input = document.getElementById('paymentSearch');
        this.clearBtn = document.getElementById('searchClear');
        
        if (!this.input) return;
        
        this.input.addEventListener('input', (e) => this.search(e.target.value));
        
        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => this.clear());
        }
    },
    
    search(query) {
        const normalized = query.toLowerCase().trim();
        
        // Mostrar/ocultar botón de limpiar
        if (this.clearBtn) {
            this.clearBtn.style.display = query ? 'flex' : 'none';
        }
        
        // Filtrar métodos de pago
        const methods = document.querySelectorAll('.payment-method-card');
        let visibleCount = 0;
        
        methods.forEach(method => {
            const methodName = method.querySelector('.method-info h4')?.textContent.toLowerCase() || '';
            const methodDesc = method.querySelector('.method-info p')?.textContent.toLowerCase() || '';
            const matches = methodName.includes(normalized) || methodDesc.includes(normalized);
            
            method.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });
        
        // Mostrar/ocultar grupos
        const groups = document.querySelectorAll('.payment-group');
        groups.forEach(group => {
            const visibleMethods = group.querySelectorAll('.payment-method-card:not([style*="display: none"])');
            group.style.display = visibleMethods.length > 0 ? '' : 'none';
        });
        
        // Mostrar mensaje si no hay resultados
        if (visibleCount === 0 && query) {
            NotificationSystem.info('Sin resultados', `No se encontraron métodos de pago para "${query}"`, 3000);
        }
    },
    
    clear() {
        if (this.input) {
            this.input.value = '';
            this.search('');
            this.input.focus();
        }
    }
};

// ==========================================================================
// PAYMENT FILTERS
// ==========================================================================

const PaymentFilters = {
    buttons: [],
    
    init() {
        this.buttons = document.querySelectorAll('.filter-btn');
        
        this.buttons.forEach(btn => {
            btn.addEventListener('click', () => this.filter(btn.dataset.filter));
        });
    },
    
    filter(category) {
        // Actualizar botones activos
        this.buttons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filter === category);
        });
        
        // Filtrar grupos de pago
        const groups = document.querySelectorAll('.payment-group');
        
        if (category === 'all') {
            groups.forEach(group => group.style.display = '');
        } else if (category === 'favorites') {
            this.showFavorites();
        } else {
            groups.forEach(group => {
                const matches = group.dataset.category === category;
                group.style.display = matches ? '' : 'none';
            });
        }
    },
    
    showFavorites() {
        const favorites = FavoritesManager.get();
        const methods = document.querySelectorAll('.payment-method-card');
        
        methods.forEach(method => {
            const methodId = method.dataset.method;
            method.style.display = favorites.includes(methodId) ? '' : 'none';
        });
        
        // Mostrar solo grupos que tengan favoritos
        const groups = document.querySelectorAll('.payment-group');
        groups.forEach(group => {
            const visibleMethods = group.querySelectorAll('.payment-method-card:not([style*="display: none"])');
            group.style.display = visibleMethods.length > 0 ? '' : 'none';
        });
        
        if (favorites.length === 0) {
            NotificationSystem.info('Sin favoritos', 'No tienes métodos de pago favoritos. Haz clic en el corazón de cualquier método para agregarlo.', 4000);
        }
    }
};

// ==========================================================================
// FAVORITES MANAGER
// ==========================================================================

const FavoritesManager = {
    favorites: [],
    
    init() {
        this.favorites = Storage.get('paymentFavorites', []);
        this.updateUI();
    },
    
    get() {
        return this.favorites;
    },
    
    toggle(methodId) {
        const index = this.favorites.indexOf(methodId);
        
        if (index > -1) {
            this.favorites.splice(index, 1);
            NotificationSystem.info('Favorito removido', 'El método de pago fue removido de favoritos', 2000);
        } else {
            this.favorites.push(methodId);
            NotificationSystem.success('Favorito agregado', 'El método de pago fue agregado a favoritos', 2000);
        }
        
        Storage.set('paymentFavorites', this.favorites);
        this.updateUI();
        
        return !this.favorites.includes(methodId);
    },
    
    updateUI() {
        const methods = document.querySelectorAll('.payment-method-card');
        
        methods.forEach(method => {
            const methodId = method.dataset.method;
            const favoriteBtn = method.querySelector('.method-favorite');
            
            if (favoriteBtn) {
                const icon = favoriteBtn.querySelector('i');
                const isFavorite = this.favorites.includes(methodId);
                
                favoriteBtn.classList.toggle('active', isFavorite);
                icon.className = isFavorite ? 'fas fa-heart' : 'far fa-heart';
            }
        });
    }
};

window.toggleFavorite = (event, methodId) => {
    event.stopPropagation();
    FavoritesManager.toggle(methodId);
};

// ==========================================================================
// PAYMENT GROUPS TOGGLE
// ==========================================================================

const PaymentGroups = {
    init() {
        // NO usar event listeners aquí, solo la función global
        console.log('PaymentGroups initialized - usando onclick inline');
    },
    
    toggle(element) {
        // Encontrar el grupo más cercano
        const group = element.closest ? element.closest('.payment-group') : element.parentElement;
        if (!group) {
            console.error('No se encontró el grupo de pago');
            return;
        }
        
        const isActive = group.classList.contains('active');
        
        console.log('Toggle grupo:', group.querySelector('.group-title')?.textContent, 'isActive:', isActive);
        
        // Cerrar otros grupos (comentado para permitir múltiples abiertos)
        // document.querySelectorAll('.payment-group').forEach(g => {
        //     if (g !== group) {
        //         g.classList.remove('active');
        //     }
        // });
        
        // Toggle el grupo actual
        if (isActive) {
            group.classList.remove('active');
        } else {
            group.classList.add('active');
        }
    }
};

// Función global SIMPLIFICADA para onclick
window.togglePaymentGroup = function(element) {
    console.log('🔄 Toggle llamado');
    
    // Buscar el payment-group padre
    let group = element;
    while (group && !group.classList.contains('payment-group')) {
        group = group.parentElement;
    }
    
    if (!group) {
        console.error('❌ No se encontró payment-group');
        return;
    }
    
    console.log('✅ Grupo encontrado:', group.querySelector('.group-title')?.textContent);
    
    // Simple toggle
    group.classList.toggle('active');
    
    console.log('📌 Estado ahora:', group.classList.contains('active') ? 'ABIERTO' : 'CERRADO');
};

// ==========================================================================
// MODAL MANAGER
// ==========================================================================

const ModalManager = {
    activeModal: null,
    
    open(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        modal.classList.add('active');
        this.activeModal = modal;
        document.body.style.overflow = 'hidden';
        
        // Focus en el primer input
        const firstInput = modal.querySelector('input:not([type="hidden"])');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 300);
        }
    },
    
    close(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        modal.classList.remove('active');
        this.activeModal = null;
        document.body.style.overflow = '';
    },
    
    closeActive() {
        if (this.activeModal) {
            this.activeModal.classList.remove('active');
            this.activeModal = null;
            document.body.style.overflow = '';
        }
    }
};

// ==========================================================================
// PAYMENT MODAL
// ==========================================================================

const PaymentModal = {
    modal: null,
    title: null,
    info: null,
    form: null,
    
    init() {
        this.modal = document.getElementById('paymentModal');
        this.title = document.getElementById('modalTitle');
        this.info = document.getElementById('modalInfo');
        this.form = document.getElementById('paymentForm');
        
        if (!this.modal) return;
        
        // Setup close button
        const closeBtn = this.modal.querySelector('.modal-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.close());
        }
        
        // Close on overlay click
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.close();
            }
        });
        
        // Esc key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.classList.contains('active')) {
                this.close();
            }
        });
    },
    
    open(method) {
        if (!paymentMethods || !paymentMethods[method]) {
            NotificationSystem.error('Error', 'Método de pago no encontrado');
            return;
        }
        
        App.currentMethod = method;
        
        // Guardar método en el modal como respaldo
        if (this.modal) {
            this.modal.setAttribute('data-payment-method', method);
        }
        
        // Guardar método en el formulario también
        if (this.form) {
            this.form.setAttribute('data-payment-method', method);
        }
        
        const data = paymentMethods[method];
        
        this.title.textContent = data.name;
        this.renderPaymentInfo(data);
        this.setupFormFields(method, data);
        this.form.reset();
        
        ModalManager.open('paymentModal');
        
        console.log('✅ Modal abierto para método:', method);
    },
    
    close() {
        ModalManager.close('paymentModal');
        App.currentMethod = null;
        
        // Limpiar atributos data
        if (this.modal) {
            this.modal.removeAttribute('data-payment-method');
        }
        if (this.form) {
            this.form.removeAttribute('data-payment-method');
        }
    },
    
    renderPaymentInfo(data) {
        let html = '<div class="payment-details">';
        
        // QR Code si existe
        if (data.details.qrCode) {
            html += `<div class="qr-code-container">
                <img src="${data.details.qrCode}" alt="QR Code" class="qr-code">
            </div>`;
        }
        
        // Detalles del método
        Object.entries(data.details).forEach(([key, value]) => {
            if (key === 'qrCode') return;
            
            const label = key
                .replace(/([A-Z])/g, ' $1')
                .replace(/^./, str => str.toUpperCase());
            
            html += `<p><strong>${label}:</strong> ${value}</p>`;
        });
        
        html += '</div>';
        this.info.innerHTML = html;
    },
    
    setupFormFields(method, data) {
        const isUSDT = ['usdt', 'usdterc20', 'usdtbep20'].includes(method);
        const isLocal = ['yape', 'bcp', 'mexico', 'bancopopular', 'banreservas', 'lemoncash', 'bhd', 'mioreserva', 'qik'].includes(method);
        
        // Mostrar/ocultar campos específicos
        document.querySelectorAll('.usdt-specific').forEach(el => {
            el.style.display = isUSDT ? 'block' : 'none';
        });
        
        document.querySelectorAll('.local-payment-specific').forEach(el => {
            el.style.display = isLocal ? 'block' : 'none';
        });
        
        document.querySelectorAll('.general-amount, .general-ref').forEach(el => {
            el.style.display = (!isUSDT && !isLocal) ? 'inline' : 'none';
        });
        
        // Warnings específicas
        document.querySelectorAll('.method-warning').forEach(el => {
            el.style.display = 'none';
        });
        
        if (isUSDT) {
            const warning = document.querySelector('.usdt-warning');
            if (warning) warning.style.display = 'flex';
        } else if (method === 'bancopopular' || method === 'banreservas') {
            const warning = document.querySelector('.dominicana-warning');
            if (warning) warning.style.display = 'flex';
        }
        
        // Configurar calculadora si aplica
        this.setupCalculator(method, data);
    },
    
    setupCalculator(method, data) {
        const calculator = document.getElementById('modalCalculator');
        if (!calculator) return;
        
        // Siempre mostrar la calculadora
        calculator.style.display = 'block';
        this.initSmartCalculator(method, data);
    },
    
    initSmartCalculator(method, data) {
        const input = document.getElementById('modalReceiveAmount');
        const sendAmount = document.getElementById('modalSendAmount');
        const localAmount = document.getElementById('modalLocalAmount');
        const conversion = document.getElementById('modalConversion');
        const calcNote = document.getElementById('modalCalcNote');
        const calcLabel = document.querySelector('#modalCalculator .calc-label');
        
        if (!input) return;
        
        // Obtener configuración del método desde currencyConfig
        const config = typeof currencyConfig !== 'undefined' 
            ? currencyConfig.getPaymentMethodConfig(method)
            : { currency: 'USD', rate: 1.00, symbol: '$', commission: 0, name: 'Desconocido' };
        
        console.log('💡 Calculadora inteligente inicializada:', {
            method: method,
            config: config
        });
        
        // Actualizar etiquetas según el método
        if (calcLabel) {
            calcLabel.innerHTML = `<i class="fas fa-dollar-sign"></i> Monto a Enviar:`;
        }
        
        const calculate = () => {
            const desiredUSD = parseFloat(input.value) || 0;
            
            if (desiredUSD <= 0) {
                sendAmount.textContent = '0.00 USD';
                conversion.style.display = 'none';
                return;
            }
            
            // Calcular usando currencyConfig
            let calculation;
            if (typeof currencyConfig !== 'undefined') {
                calculation = currencyConfig.calculateAmountToSend(desiredUSD, method);
            } else {
                // Fallback si currencyConfig no está disponible
                calculation = {
                    desiredUSD: desiredUSD,
                    commission: config.commission,
                    totalUSD: desiredUSD + config.commission,
                    localCurrency: config.currency,
                    localSymbol: config.symbol,
                    exchangeRate: config.rate,
                    amountToSend: (desiredUSD + config.commission) * config.rate,
                    methodName: config.name
                };
            }
            
            // Mostrar el monto que debe enviar
            if (config.currency === 'USD') {
                // Para métodos en USD (crypto, USA, etc.)
                if (config.commission > 0) {
                    sendAmount.innerHTML = `<strong>${calculation.totalUSD.toFixed(2)} USD</strong> <small>(incluye $${config.commission} comisión)</small>`;
                } else {
                    sendAmount.innerHTML = `<strong>${calculation.totalUSD.toFixed(2)} USD</strong>`;
                }
                conversion.style.display = 'none';
            } else {
                // Para métodos en moneda local
                sendAmount.innerHTML = `<strong>${calculation.totalUSD.toFixed(2)} USD</strong>`;
                
                // Mostrar conversión a moneda local
                localAmount.innerHTML = `<strong>${calculation.amountToSend.toFixed(2)} ${config.symbol}</strong>`;
                conversion.style.display = 'flex';
                
                // Actualizar etiqueta de conversión
                const conversionLabel = conversion.querySelector('.calc-label');
                if (conversionLabel) {
                    conversionLabel.textContent = `💱 Debes enviar (${config.currency}):`;
                }
            }
            
            // Actualizar nota informativa
            if (calcNote) {
                let noteText = '';
                
                if (config.currency === 'USD') {
                    noteText = `ℹ️ Envía exactamente ${calculation.totalUSD.toFixed(2)} USD y recibirás ${desiredUSD.toFixed(2)} USD en tu cuenta.`;
                } else {
                    noteText = `ℹ️ Tasa: 1 USD = ${config.rate} ${config.symbol} | Envía ${calculation.amountToSend.toFixed(2)} ${config.symbol} para recibir ${desiredUSD.toFixed(2)} USD`;
                }
                
                if (config.commission > 0) {
                    noteText += ` (incluye comisión de $${config.commission})`;
                }
                
                calcNote.innerHTML = `<i class="fas fa-info-circle"></i> ${noteText}`;
            }
            
            console.log('📊 Cálculo realizado:', calculation);
        };
        
        // Limpiar eventos anteriores
        const newInput = input.cloneNode(true);
        input.parentNode.replaceChild(newInput, input);
        
        // Agregar nuevos eventos
        newInput.addEventListener('input', calculate);
        newInput.addEventListener('change', calculate);
        
        // Calcular inicial
        calculate();
    }
};

window.openPaymentModal = (method) => {
    PaymentModal.open(method);
};

window.closePaymentModal = () => {
    PaymentModal.close();
};

// ==========================================================================
// INFO MODAL
// ==========================================================================

window.showRechargeInfo = () => {
    ModalManager.open('infoModal');
};

window.closeInfoModal = () => {
    ModalManager.close('infoModal');
};

// ==========================================================================
// FORM HANDLER
// ==========================================================================

async function handlePayment(event) {
    event.preventDefault();
    
    const submitBtn = event.target.querySelector('.submit-button');
    const originalHTML = submitBtn.innerHTML;
    
    // Loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Procesando...</span>';
    submitBtn.disabled = true;
    
    // Obtener el método de pago desde múltiples fuentes (con respaldo)
    let currentMethod = App.currentMethod;
    
    // Si no está en App, intentar obtenerlo del modal
    if (!currentMethod) {
        const modal = document.getElementById('paymentModal');
        if (modal) {
            currentMethod = modal.getAttribute('data-payment-method');
        }
    }
    
    // Si todavía no está, intentar del formulario
    if (!currentMethod) {
        const form = document.getElementById('paymentForm');
        if (form) {
            currentMethod = form.getAttribute('data-payment-method');
        }
    }
    
    // Log para debug
    console.log('🔍 Buscando método de pago:', {
        'App.currentMethod': App.currentMethod,
        'Modal data-attr': document.getElementById('paymentModal')?.getAttribute('data-payment-method'),
        'Form data-attr': document.getElementById('paymentForm')?.getAttribute('data-payment-method'),
        'Resultado final': currentMethod
    });
    
    // Recopilar datos del formulario
    const formData = {
        paymentMethod: currentMethod,  // Cambiado de 'method' a 'paymentMethod'
        userName: document.getElementById('userName').value.trim(),
        userEmail: document.getElementById('userEmail').value.trim(),
        amount: parseFloat(document.getElementById('amount').value),
        transactionRef: document.getElementById('transactionRef')?.value?.trim() || '',
        additionalInfo: document.getElementById('additionalInfo')?.value?.trim() || '',
        timestamp: new Date().toISOString()
    };
    
    // Validar que paymentMethod existe
    if (!formData.paymentMethod) {
        console.error('❌ paymentMethod no encontrado. App.currentMethod:', App.currentMethod);
        NotificationSystem.error('Error de Validación', 'No se pudo identificar el método de pago. Por favor, cierra y vuelve a abrir el método de pago.');
        submitBtn.innerHTML = originalHTML;
        submitBtn.disabled = false;
        return;
    }
    
    // Validar campos requeridos
    if (!formData.userName || !formData.userEmail || !formData.amount || formData.amount <= 0) {
        NotificationSystem.error('Error de Validación', 'Por favor, completa todos los campos requeridos correctamente.');
        submitBtn.innerHTML = originalHTML;
        submitBtn.disabled = false;
        return;
    }
    
    // Agregar campos específicos según el método
    const isUSDT = ['usdt', 'usdterc20', 'usdtbep20'].includes(formData.paymentMethod);
    const isLocal = ['yape', 'bcp', 'mexico', 'bancopopular', 'banreservas', 'bhd', 'mioreserva', 'qik', 'lemoncash'].includes(formData.paymentMethod);
    
    // Agregar serverEmail si el campo existe
    const serverEmailEl = document.getElementById('serverEmail');
    const serverEmailLocalEl = document.getElementById('serverEmailLocal');
    
    if (isUSDT && serverEmailEl) {
        formData.serverEmail = serverEmailEl.value || '';
        formData.network = formData.paymentMethod === 'usdt' ? 'TRC20' : formData.paymentMethod === 'usdterc20' ? 'ERC20' : 'BEP20';
        
        // Validar monto mínimo
        if (formData.amount < 10) {
            NotificationSystem.error('Error de Validación', 'El monto mínimo para USDT es 10 USD');
            submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
            return;
        }
    } else if (isLocal && serverEmailLocalEl) {
        formData.serverEmail = serverEmailLocalEl.value || '';
    } else {
        // Para otros métodos, serverEmail puede ser opcional
        formData.serverEmail = '';
    }
    
    // Debug log
    console.log('📤 Enviando datos:', {
        paymentMethod: formData.paymentMethod,
        userName: formData.userName,
        amount: formData.amount,
        hasServerEmail: !!formData.serverEmail
    });
    
    try {
        // Enviar solicitud a la API
        const response = await fetch('api/crear_solicitud_pago.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const result = await response.json();
        
        if (!response.ok || !result.success) {
            throw new Error(result.error || 'Error al procesar la solicitud');
        }
        
        // Éxito - Actualizar botón
        submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> <span>¡Enviado!</span>';
        
        // Enviar notificación por Telegram si está disponible
        if (typeof notifyPayment === 'function' && paymentMethods[App.currentMethod]) {
            try {
                await notifyPayment({
                    ...formData,
                    methodName: paymentMethods[App.currentMethod].name
                });
            } catch (e) {
                console.error('Error sending Telegram notification:', e);
            }
        }
        
        // Cerrar modal de pago
        PaymentModal.close();
        
        // Mostrar modal de éxito
        showSuccessModal(result.data);
        
        // Resetear formulario
        event.target.reset();
        submitBtn.innerHTML = originalHTML;
        submitBtn.disabled = false;
        
    } catch (error) {
        console.error('Payment error:', error);
        
        submitBtn.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>Error</span>';
        
        NotificationSystem.error(
            'Error al Procesar',
            error.message || 'Hubo un error al procesar tu solicitud. Por favor, inténtalo de nuevo o contacta con soporte.',
            8000
        );
        
        setTimeout(() => {
            submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
        }, 3000);
    }
}

// Hacer disponible globalmente
window.handlePayment = handlePayment;

// ==========================================================================
// MODAL DE ÉXITO Y REDIRECCIÓN
// ==========================================================================

let redirectTimer = null;
let countdownInterval = null;

function showSuccessModal(data) {
    const modal = document.getElementById('successModal');
    if (!modal) return;
    
    // Cancelar cualquier timer existente
    if (redirectTimer) {
        clearTimeout(redirectTimer);
        redirectTimer = null;
    }
    if (countdownInterval) {
        clearInterval(countdownInterval);
        countdownInterval = null;
    }
    
    // Actualizar información del modal
    document.getElementById('successUser').textContent = data.user_name || '-';
    document.getElementById('successAmount').textContent = `$${data.amount} USD`;
    document.getElementById('successMethod').textContent = getMethodName(data.payment_method);
    
    // Resetear contador
    const countdownEl = document.getElementById('countdownNumber');
    if (countdownEl) {
        countdownEl.textContent = '10';
    }
    
    // Mostrar modal
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Animación de entrada
    setTimeout(() => {
        modal.querySelector('.modal-container').style.animation = 'fadeInUp 0.4s ease';
    }, 10);
    
    // Iniciar contador de 10 segundos
    startRedirectCountdown();
}

function startRedirectCountdown() {
    const countdownEl = document.getElementById('countdownNumber');
    if (!countdownEl) return;
    
    let seconds = 10;
    
    // Actualizar cada segundo
    countdownInterval = setInterval(() => {
        seconds--;
        
        if (seconds <= 0) {
            // Redirigir cuando llegue a 0
            clearInterval(countdownInterval);
            countdownInterval = null;
            redirectToDashboard();
        } else {
            // Actualizar el número en pantalla
            countdownEl.textContent = seconds.toString();
        }
    }, 1000);
    
    // Backup: redirección después de 10 segundos por si acaso
    redirectTimer = setTimeout(() => {
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }
        redirectToDashboard();
    }, 10000);
}

function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    if (!modal) return;
    
    // Cancelar timers
    if (redirectTimer) {
        clearTimeout(redirectTimer);
        redirectTimer = null;
    }
    if (countdownInterval) {
        clearInterval(countdownInterval);
        countdownInterval = null;
    }
    
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

function redirectToDashboard() {
    // Cancelar timers
    if (redirectTimer) {
        clearTimeout(redirectTimer);
        redirectTimer = null;
    }
    if (countdownInterval) {
        clearInterval(countdownInterval);
        countdownInterval = null;
    }
    
    // Obtener base URL correcta
    // Desde: localhost/nachotechrd/Pagos/
    // A: localhost/nachotechrd/index.php/member/dashboard
    const currentPath = window.location.pathname;
    let baseUrl = window.location.origin;
    
    // Remover /Pagos/ del path
    if (currentPath.includes('/Pagos')) {
        const pathParts = currentPath.split('/Pagos');
        baseUrl += pathParts[0]; // Obtener hasta antes de /Pagos
    } else {
        // Si no está en Pagos, usar el path completo
        const pathParts = currentPath.split('/');
        pathParts.pop(); // Quitar última parte
        baseUrl += pathParts.join('/');
    }
    
    // Agregar la ruta del dashboard (CodeIgniter)
    const dashboardUrl = baseUrl + '/index.php/member/dashboard';
    
    console.log('🚀 Redirigiendo a:', dashboardUrl);
    
    // Redirigir
    window.location.href = dashboardUrl;
}

function getMethodName(methodId) {
    const names = {
        'usdt': 'USDT TRC20',
        'usdterc20': 'USDT ERC20',
        'usdtbep20': 'USDT BEP20',
        'bancopopular': 'Banco Popular',
        'banreservas': 'BanReservas',
        'bhd': 'BHD León',
        'mioreserva': 'MiO - Reserva',
        'qik': 'Qik',
        'mexico': 'STP México',
        'usabank': 'Lead Bank (USA)',
        'europebank': 'Modulr Finance (Europa)',
        'yape': 'YAPE',
        'bcp': 'BCP',
        'lemoncash': 'Lemon Cash',
        'binance': 'Binance Pay',
        'paypalcustom': 'PayPal'
    };
    return names[methodId] || methodId;
}

// Hacer disponibles globalmente
window.showSuccessModal = showSuccessModal;
window.closeSuccessModal = closeSuccessModal;
window.redirectToDashboard = redirectToDashboard;

// ==========================================================================
// SCROLL TO TOP
// ==========================================================================

const ScrollManager = {
    button: null,
    
    init() {
        this.button = document.getElementById('scrollToTop');
        if (!this.button) return;
        
        window.addEventListener('scroll', () => this.handleScroll());
        this.button.addEventListener('click', () => this.scrollToTop());
    },
    
    handleScroll() {
        if (window.pageYOffset > 300) {
            this.button.classList.add('visible');
        } else {
            this.button.classList.remove('visible');
        }
    },
    
    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
};

// ==========================================================================
// MOBILE MENU
// ==========================================================================

const MobileMenu = {
    toggle: null,
    nav: null,
    
    init() {
        this.toggle = document.getElementById('mobileMenuToggle');
        this.nav = document.querySelector('.main-nav');
        
        if (!this.toggle || !this.nav) return;
        
        this.toggle.addEventListener('click', () => this.toggleMenu());
    },
    
    toggleMenu() {
        this.nav.classList.toggle('active');
        this.toggle.classList.toggle('active');
    }
};

// ==========================================================================
// INICIALIZACIÓN DE LA APP
// ==========================================================================

function initializeApp() {
    console.log(`%c${App.name} v${App.version}`, 'color: #667eea; font-size: 20px; font-weight: bold;');
    console.log('%cDeveloped by NTDESWEB', 'color: #764ba2; font-size: 12px;');
    
    // Inicializar sistemas en orden
    PageLoader.init();
    ThemeManager.init();
    NotificationSystem.init();
    StatsAnimator.init();
    HeroBanner.init();
    ServicesCarousel.init();
    PaymentSearch.init();
    PaymentFilters.init();
    FavoritesManager.init();
    PaymentGroups.init();
    PaymentModal.init();
    ScrollManager.init();
    MobileMenu.init();
    
    // Ocultar loader
    PageLoader.hide();
    
    // Marcar como inicializado
    App.initialized = true;
    
    // Mostrar mensaje de bienvenida
    setTimeout(() => {
        NotificationSystem.success(
            '¡Bienvenido a NachoTechRD!',
            'Sistema de pagos cargado correctamente. Selecciona tu método de pago preferido.',
            5000
        );
    }, 2000);
}

// Esperar a que el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeApp);
} else {
    initializeApp();
}

// ==========================================================================
// EXPORT PARA TESTING Y DEBUG
// ==========================================================================

window.NachoTechApp = {
    App,
    ThemeManager,
    NotificationSystem,
    FavoritesManager,
    PaymentModal,
    version: App.version
};

// ==========================================================================
// END OF SCRIPT
// ==========================================================================

