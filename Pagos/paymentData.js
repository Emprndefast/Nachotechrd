const paymentMethods = {
    usdt: {
        name: "USDT TRC20 (Tron)",
        details: {
            bank: "Binance - Red TRX (TRON)",
            accountNumber: "TCRFphD1bb18MQh1m9KkAkzVCZqTanmTkh",
            accountName: "NachoTechRD",
            type: "Crypto Wallet",
            network: "TRC20 (Red TRON)",
            minimumAmount: "10 USD",
            qrCode: "theterdcymarqr.jpg",
            warning: "⚠️ No envíes NFT a esta dirección",
            advancedNote: "No se admiten depósitos de contratos inteligentes, a excepción de las redes ETH con ERC20, BSC con BEP20, Arbitrum y Optimism.",
            note: "💰 Monto mínimo: 10 USD. ⚡ Red más barata y rápida (Recomendada). La comisión la paga quien envía. ⏱️ Depósitos instantáneos."
        }
    },
    usdterc20: {
        name: "USDT ERC20 (Ethereum)",
        details: {
            bank: "Binance - Red ETH (Ethereum)",
            accountNumber: "0xa740e8838d5bf000557bbe52c6fb439b4af5c490",
            accountName: "NachoTechRD",
            type: "Crypto Wallet",
            network: "ERC20 (Red Ethereum)",
            minimumAmount: "10 USD",
            qrCode: "erc20cymar.jpg",
            warning: "⚠️ No envíes NFT a esta dirección",
            advancedNote: "✅ Red más segura. Comisiones más altas. Soporta contratos inteligentes.",
            note: "💰 Monto mínimo: 10 USD. 🔒 Red más segura pero con comisiones altas. La comisión la paga quien envía. ⏱️ Confirmación: 15-30 min."
        }
    },
    usdtbep20: {
        name: "USDT BEP20 (BNB Chain)",
        details: {
            bank: "Binance - Red BSC (BNB Smart Chain)",
            accountNumber: "0xa740e8838d5bf000557bbe52c6fb439b4af5c490",
            accountName: "NachoTechRD",
            type: "Crypto Wallet",
            network: "BEP20 (BSC)",
            minimumAmount: "10 USD",
            qrCode: "bep20cymar.jpg",
            warning: "⚠️ No envíes NFT a esta dirección",
            advancedNote: "⚖️ Equilibrio entre velocidad y costo. Soporta contratos inteligentes.",
            note: "💰 Monto mínimo: 10 USD. ⚖️ Red equilibrada: costos moderados y velocidad media. La comisión la paga quien envía. ⏱️ Confirmación: 3-5 min."
        }
    },
    mexico: {
        name: "STP México (Cuenta Virtual)",
        details: {
            bank: "STP",
            accountName: "Jose Ignacio Ysabel Torres",
            clabe: "646180546701099491",
            type: "Transferencia Bancaria",
            exchangeRate: "💱 Tasa: $1 USD = 18.5874 MXN",
            minimumAmount: "50 MXN",
            processingTime: "⏱️ 1 día hábil",
            commission: "💰 Comisión: $1.50 (Gratis)",
            note: "🇲🇽 Cuenta virtual en México. Transferencias SPEI. Mínimo: 50 MXN. Procesamiento rápido."
        }
    },
    usabank: {
        name: "Lead Bank (USA - Cuenta Virtual)",
        details: {
            bank: "Lead Bank",
            accountName: "Jose Ignacio Ysabel Torres",
            accountNumber: "210240080080",
            routingNumberACH: "101019644",
            accountType: "Cuenta Corriente",
            bankAddress: "1801 Main St., Kansas City",
            type: "ACH Transfer / Wire Transfer",
            processingTime: "⏱️ 1-3 días hábiles",
            commission: "💰 $2 por transacción",
            note: "🇺🇸 Cuenta virtual en Estados Unidos. Acepta transferencias ACH y Wire. Ideal para pagos desde USA."
        }
    },
    europebank: {
        name: "Modulr Finance (Europa - Cuenta Virtual)",
        details: {
            bank: "Modulr Finance, Ireland Branch",
            accountName: "Bridge Building",
            accountType: "Cuenta de Negocio",
            iban: "IE79MODR99035511851805",
            bic: "MODRIE22XXX",
            type: "SEPA Transfer",
            exchangeRate: "💱 Tasa: 1 EUR = $1.1508 USD",
            processingTime: "⏱️ 1 día hábil",
            commission: "💰 $2 (Gratis)",
            note: "🇪🇺 Cuenta virtual en Europa (Irlanda). Transferencias SEPA. Ideal para pagos desde Europa. Comisión gratuita."
        }
    },
    yape: {
        name: "YAPE (Perú)",
        details: {
            bank: "YAPE",
            accountName: "Martin Laguna Sanchez",
            yapeNumber: "996757429",
            type: "Mobile Payment",
            exchangeRate: "1 crédito = 4 soles",
            minimumAmount: "40 soles",
            maximumAmount: "500 soles",
            qrCode: "yapecymar.jpg",
            acceleration: "Enviar foto de pago a @CymartSoporte telegram",
            note: "No enviar notas en el pago ❌ o su pago será rechazado sin lugar a reembolso - Transferencia instantánea Yape. Procesamiento inmediato. Paga con Yape escaneando el QR."
        }
    },
    bcp: {
        name: "BCP (Perú)",
        details: {
            bank: "BCP - Banco de Crédito del Perú",
            accountNumber: "19197799371040",
            accountName: "Martin Laguna Sanchez",
            type: "Bank Transfer",
            exchangeRate: "1 crédito = 4 soles",
            minimumAmount: "10 soles",
            acceleration: "Enviar foto de pago a @CymartSoporte telegram",
            note: "No enviar notas en el pago ❌ o su pago será rechazado sin lugar a reembolso - Procesamiento inmediato"
        }
    },
    bancopopular: {
        name: "Banco Popular (República Dominicana)",
        details: {
            bank: "Banco Popular",
            accountNumber: "9607552721",
            accountName: "José Ignacio Ysabel Torres",
            type: "Bank Transfer",
            accountType: "Cuenta de Ahorro",
            exchangeRate: "1 crédito = 68 RD$",
            note: "Solo transferencias banco a banco. Sin notas en el pago."
        }
    },
    banreservas: {
        name: "BanReservas (República Dominicana)",
        details: {
            bank: "BanReservas",
            accountNumber: "9607552721",
            accountName: "José Ignacio Ysabel Torres",
            type: "Bank Transfer",
            accountType: "Cuenta de Ahorro",
            exchangeRate: "1 crédito = 68 RD$",
            note: "Solo transferencias banco a banco. Sin notas en el pago."
        }
    },
    bhd: {
        name: "BHD (República Dominicana)",
        details: {
            bank: "Banco BHD",
            accountNumber: "31335410013",
            accountName: "Jose Ysabel",
            type: "Bank Transfer",
            accountType: "Cuenta de Ahorro",
            exchangeRate: "1 crédito = 68 RD$"
        }
    },
    mioreserva: {
        name: "MiO - Reserva (República Dominicana)",
        details: {
            bank: "MiO - Reserva",
            accountNumber: "4201623995",
            accountName: "Jose I Ysabel Torres",
            type: "Bank Transfer",
            accountType: "Cuenta Corriente",
            exchangeRate: "1 crédito = 68 RD$"
        }
    },
    qik: {
        name: "Qik (República Dominicana)",
        details: {
            bank: "Qik",
            accountNumber: "1000206764",
            accountName: "Jose Torres",
            type: "Bank Transfer",
            accountType: "Cuenta de Ahorro"
        }
    },
    binance: {
        name: "Binance Pay",
        details: {
            platform: "Binance Pay",
            binanceId: "322582964",
            email: "djnachord@icloud.com",
            note: "Envía solo en USDT; confirma red y monto exacto."
        }
    },
    paypalcustom: {
        name: "PayPal",
        details: {
            platform: "PayPal",
            username: "@nachotechrd",
            email: "ntdesweb2.0@gmail.com",
            note: "Envío como 'Friends & Family' si está disponible."
        }
    },
    lemoncash: {
        name: "Lemon Cash USDT",
        details: {
            bank: "Lemon Cash",
            accountName: "Martin Laguna Sanchez",
            lemontag: "cymart22",
            type: "Digital Wallet",
            availableCountries: "Argentina - Perú - Colombia - Brasil - México - Chile - Uruguay - Ecuador",
            acceleration: "Enviar foto de pago a @CymartSoporte telegram",
            note: "Procesamiento inmediato."
        }
    }
};

