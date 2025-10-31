// Configuración de tasas de cambio y comisiones
// Este archivo puede ser actualizado fácilmente sin tocar el código principal

const currencyConfig = {
    // Tasas de cambio (pueden ser actualizadas manualmente o mediante API)
    exchangeRates: {
        USD_DOP: 68.00,    // 1 USD = 68 Pesos Dominicanos (RD)
        USD_EUR: 0.8690,   // 1 USD = 0.8690 Euros (inverso de 1.1508)
        USD_MXN: 18.5874,  // 1 USD = 18.5874 Pesos Mexicanos
        USD_COP: 4150,     // 1 USD = 4150 Pesos Colombianos
        USD_PEN: 4.00,     // 1 USD = 4.00 Soles Peruanos
        USD_CLP: 800,      // 1 USD = 800 Pesos Chilenos
        USD_BRL: 5.20,     // 1 USD = 5.20 Reales Brasileños
        USD_VES: 36.50,    // 1 USD = 36.50 Bolívares Venezolanos
    },
    
    // Tasas y configuración específica por método de pago
    paymentMethods: {
        // República Dominicana
        bancopopular: { currency: 'DOP', rate: 68.00, symbol: 'RD$', commission: 0, name: 'Banco Popular' },
        banreservas: { currency: 'DOP', rate: 68.00, symbol: 'RD$', commission: 0, name: 'BanReservas' },
        bhd: { currency: 'DOP', rate: 68.00, symbol: 'RD$', commission: 0, name: 'BHD León' },
        mioreserva: { currency: 'DOP', rate: 68.00, symbol: 'RD$', commission: 0, name: 'MiO - Reserva' },
        qik: { currency: 'DOP', rate: 68.00, symbol: 'RD$', commission: 0, name: 'Qik' },
        
        // Criptomonedas (1:1 con USD, sin comisión oculta)
        usdt: { currency: 'USD', rate: 1.00, symbol: '$', commission: 0, name: 'USDT TRC20', network: 'TRC20' },
        usdterc20: { currency: 'USD', rate: 1.00, symbol: '$', commission: 0, name: 'USDT ERC20', network: 'ERC20' },
        usdtbep20: { currency: 'USD', rate: 1.00, symbol: '$', commission: 0, name: 'USDT BEP20', network: 'BEP20' },
        
        // México
        mexico: { currency: 'MXN', rate: 18.5874, symbol: 'MXN $', commission: 0, name: 'STP México', minimum: 50 },
        
        // USA
        usabank: { currency: 'USD', rate: 1.00, symbol: '$', commission: 2.00, name: 'Lead Bank USA', processingDays: '1-3 días' },
        
        // Europa
        europebank: { currency: 'EUR', rate: 0.8690, symbol: '€', commission: 0, name: 'Modulr Finance', processingDays: '1 día' },
        
        // Perú
        yape: { currency: 'PEN', rate: 4.00, symbol: 'S/', commission: 0, name: 'YAPE', maximum: 500 },
        bcp: { currency: 'PEN', rate: 4.00, symbol: 'S/', commission: 0, name: 'BCP', minimum: 10 },
        
        // Otros
        lemoncash: { currency: 'USD', rate: 1.00, symbol: '$', commission: 0, name: 'Lemon Cash' },
        binance: { currency: 'USD', rate: 1.00, symbol: '$', commission: 0, name: 'Binance Pay' },
        paypalcustom: { currency: 'USD', rate: 1.00, symbol: '$', commission: 0, name: 'PayPal' }
    },
    
    // Comisiones y tarifas
    fees: {
        serviceCommission: 6.50,        // Comisión fija del servicio en USD
        percentageCommission: 0,        // Comisión porcentual (0% por defecto)
        minimumAmount: 10.00,          // Monto mínimo en USD (actualizado a 10 USD)
        maximumAmount: 10000.00        // Monto máximo en USD
    },
    
    // Configuración de display
    display: {
        primaryCurrency: 'USDT',        // Moneda principal del servidor (siempre USDT)
        defaultCurrency: 'USDT',        // Moneda por defecto para mostrar
        referenceCurrencies: ['USD', 'DOP', 'EUR', 'MXN'], // Monedas de referencia
        decimalPlaces: 2,               // Lugares decimales
        showBreakdown: true,            // Mostrar desglose de costos
        showExchangeRate: true,         // Mostrar tasa de cambio
        autoUpdate: true                // Actualización automática de tasas
    },
    
    // Información sobre las tasas
    rateInfo: {
        lastUpdate: new Date().toISOString(),
        source: 'Manual',               // 'Manual' o 'API'
        updateFrequency: 'daily',       // 'hourly', 'daily', 'manual'
        apiEndpoint: null               // URL de API para tasas de cambio (opcional)
    },
    
    // Mensajes personalizables
    messages: {
        calculatorTitle: 'Calculadora de Divisas',
        calculatorSubtitle: 'Calcula exactamente cuánto USDT debes enviar sin confundirte con comisiones',
        inputLabel: 'Cantidad que desea recibir en Server (en USD):',
        usdtAmountLabel: '💰 Cantidad a enviar en USDT (Criptomoneda):',
        sendAmountLabel: 'Equivalente en USD (Referencia):',
        pesosAmountLabel: 'Equivalente en Pesos Dominicanos (Referencia):',
        breakdownTitle: '🔢 Desglose de Costos en USDT:',
        baseAmountLabel: 'Monto deseado en el servidor:',
        commissionLabel: 'Comisión del servicio:',
        totalLabel: '🎯 Total a enviar en USDT:',
        exchangeRateLabel: '💰 1 USDT = 1 USD (Estable)',
        noteText: '🎯 El servidor siempre recibe en USDT. USDT es una criptomoneda estable equivalente al dólar. Las conversiones a otras monedas son solo para tu referencia al momento de comprar USDT.',
        mainCurrencyNote: '✅ Esta es la cantidad que recibirá el servidor',
        breakdownNote: '💡 El servidor siempre recibe en USDT. Las conversiones a otras monedas son solo de referencia.',
        minimumAmountError: 'El monto mínimo es ${minimum} USDT',
        maximumAmountError: 'El monto máximo es ${maximum} USDT'
    },
    
    // Función para obtener la tasa de cambio actual
    getExchangeRate: function(fromCurrency = 'USD', toCurrency = 'DOP') {
        const rateKey = `${fromCurrency}_${toCurrency}`;
        return this.exchangeRates[rateKey] || 1;
    },
    
    // Función para calcular el total con comisiones
    calculateTotal: function(baseAmount) {
        const commission = this.fees.serviceCommission;
        const percentageCommission = (baseAmount * this.fees.percentageCommission / 100);
        return baseAmount + commission + percentageCommission;
    },
    
    // Función para validar el monto
    validateAmount: function(amount) {
        if (amount < this.fees.minimumAmount) {
            return {
                valid: false,
                error: this.messages.minimumAmountError.replace('{minimum}', this.fees.minimumAmount)
            };
        }
        if (amount > this.fees.maximumAmount) {
            return {
                valid: false,
                error: this.messages.maximumAmountError.replace('{maximum}', this.fees.maximumAmount)
            };
        }
        return { valid: true };
    },
    
    // Función para formatear números como moneda
    formatCurrency: function(amount, currency = 'USD', decimals = null) {
        const places = decimals !== null ? decimals : this.display.decimalPlaces;
        const formatted = parseFloat(amount).toFixed(places);
        
        // Agregar separadores de miles
        return formatted.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    },
    
    // Función para actualizar una tasa de cambio específica
    updateExchangeRate: function(fromCurrency, toCurrency, newRate) {
        const rateKey = `${fromCurrency}_${toCurrency}`;
        this.exchangeRates[rateKey] = newRate;
        this.rateInfo.lastUpdate = new Date().toISOString();
        this.rateInfo.source = 'Manual';
        return true;
    },
    
    // Función para actualizar la comisión
    updateCommission: function(newCommission) {
        this.fees.serviceCommission = newCommission;
        return true;
    },
    
    // Función para obtener configuración de un método de pago
    getPaymentMethodConfig: function(methodId) {
        return this.paymentMethods[methodId] || {
            currency: 'USD',
            rate: 1.00,
            symbol: '$',
            commission: 0,
            name: 'Desconocido'
        };
    },
    
    // Función para calcular cuánto debe enviar el cliente
    calculateAmountToSend: function(desiredUSD, methodId) {
        const config = this.getPaymentMethodConfig(methodId);
        const totalUSD = desiredUSD + config.commission;
        const amountInLocalCurrency = totalUSD * config.rate;
        
        return {
            desiredUSD: desiredUSD,
            commission: config.commission,
            totalUSD: totalUSD,
            localCurrency: config.currency,
            localSymbol: config.symbol,
            exchangeRate: config.rate,
            amountToSend: amountInLocalCurrency,
            methodName: config.name
        };
    }
};

// Función para obtener tasas de cambio desde una API (opcional)
async function fetchExchangeRatesFromAPI() {
    try {
        // API pública y gratuita (sin clave): open.er-api.com
        const response = await fetch('https://open.er-api.com/v6/latest/USD', { cache: 'no-store' });
        if (!response.ok) return false;
        const data = await response.json();
        if (data && data.result === 'success' && data.rates) {
            if (data.rates.DOP) currencyConfig.updateExchangeRate('USD', 'DOP', data.rates.DOP);
            if (data.rates.EUR) currencyConfig.updateExchangeRate('USD', 'EUR', data.rates.EUR);
            if (data.rates.MXN) currencyConfig.updateExchangeRate('USD', 'MXN', data.rates.MXN);
            if (data.rates.PEN) currencyConfig.updateExchangeRate('USD', 'PEN', data.rates.PEN || 3.75);
            if (data.rates.COP) currencyConfig.updateExchangeRate('USD', 'COP', data.rates.COP || 4150);
            currencyConfig.rateInfo.source = 'API';
            currencyConfig.rateInfo.lastUpdate = new Date().toISOString();
            currencyConfig.rateInfo.apiEndpoint = 'open.er-api.com';
            return true;
        }
        return false;
    } catch (error) {
        console.error('Error al obtener tasas de cambio desde API:', error);
        return false;
    }
}

// Auto-actualización de tasas al cargar si está habilitado
(function autoUpdateRates(){
    try {
        if (currencyConfig && currencyConfig.display && currencyConfig.display.autoUpdate) {
            fetchExchangeRatesFromAPI().then(function(updated){
                if (updated && typeof window !== 'undefined') {
                    // Recalcular si existe la calculadora en pantalla
                    if (window.currencyCalculator && typeof window.currencyCalculator.calculate === 'function') {
                        setTimeout(function(){ window.currencyCalculator.calculate(); }, 50);
                    }
                }
            });
        }
    } catch(e) { console.warn('Auto update rates skipped', e); }
})();

// Exportar para uso en otros archivos
if (typeof module !== 'undefined' && module.exports) {
    module.exports = currencyConfig;
}
