<div class="dashboard add-credits-pro">

<!-- Header Premium -->
<div class="credits-header">
  <div class="header-content">
    <div class="header-icon">💎</div>
    <div class="header-text">
      <h1>Recargar Créditos</h1>
      <p>Selecciona tu método de pago preferido</p>
    </div>
  </div>
  <div class="current-balance">
    <span class="balance-label">Saldo Actual</span>
    <span class="balance-amount">$<?php echo number_format(!empty($credit[0]['credit']) ? $credit[0]['credit'] : 0, 2); ?></span>
  </div>
</div>

<?php $this->load->view('includes/messages'); ?>

<!-- Métodos de Pago -->
<div class="payment-methods-grid">
  
  <!-- Método 1: PayPal (Existente) -->
  <div class="payment-method-card">
    <div class="method-header">
      <div class="method-icon paypal-icon">
        <i class="fab fa-paypal"></i>
      </div>
      <div class="method-info">
        <h3>PayPal</h3>
        <p>Pago rápido y seguro con PayPal</p>
      </div>
    </div>
    
    <div class="method-body">
      <?php echo form_open('member/checkout', array('role' => 'form', 'method' => 'post','id' => 'paypal-form', 'class' => 'payment-form')); ?>
        
        <div class="form-group-pro">
          <label class="form-label-pro">
            <i class="fas fa-coins"></i> Cantidad de Créditos
          </label>
          <div class="input-wrapper">
            <span class="input-prefix">$</span>
            <input type="number" 
                   min="5" 
                   step="0.1" 
                   name="Credit" 
                   placeholder="Mínimo 5.00" 
                   required 
                   class="form-input-pro"
                   id="paypal-amount">
          </div>
          <small class="form-hint">Comisión: <?php echo $paypal_settings[0]['percent'].'%' ?> + $0.35</small>
        </div>
        
        <input type="hidden" name="payment_type" value="paypal">
        
        <button type="submit" class="btn-payment paypal-btn">
          <i class="fab fa-paypal"></i>
          <span>Pagar con PayPal</span>
          <i class="fas fa-arrow-right"></i>
        </button>
        
        <div class="payment-features">
          <div class="feature-item">
            <i class="fas fa-shield-alt"></i>
            <span>Pago Seguro</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-clock"></i>
            <span>Acreditación Inmediata</span>
          </div>
        </div>
        
      <?php echo form_close(); ?>
    </div>
  </div>
  
  <!-- Método 2: Pagos Múltiples (Nuevo) -->
  <div class="payment-method-card featured">
    <div class="featured-badge">
      <i class="fas fa-star"></i> Recomendado
    </div>
    
    <div class="method-header">
      <div class="method-icon crypto-icon">
        <i class="fas fa-coins"></i>
      </div>
      <div class="method-info">
        <h3>Pagos Múltiples</h3>
        <p>Crypto, Yape, Transferencias y más</p>
      </div>
    </div>
    
    <div class="method-body">
      <div class="payment-options-list">
        <div class="payment-option">
          <i class="fab fa-bitcoin crypto-color"></i>
          <span>USDT (TRC20, ERC20, BEP20)</span>
        </div>
        <div class="payment-option">
          <i class="fas fa-mobile-alt yape-color"></i>
          <span>Yape / Plin</span>
        </div>
        <div class="payment-option">
          <i class="fas fa-university bank-color"></i>
          <span>Transferencia Bancaria</span>
        </div>
        <div class="payment-option">
          <i class="fas fa-credit-card card-color"></i>
          <span>Western Union / MoneyGram</span>
        </div>
        <div class="payment-option">
          <i class="fas fa-wallet paypal-color"></i>
          <span>Binance Pay / Perfect Money</span>
        </div>
      </div>
      
      <button type="button" class="btn-payment crypto-btn" onclick="abrirPagosCymar()">
        <i class="fas fa-rocket"></i>
        <span>Ir a Métodos de Pago</span>
        <i class="fas fa-external-link-alt"></i>
      </button>
      
      <div class="payment-features">
        <div class="feature-item">
          <i class="fas fa-percentage"></i>
          <span>Sin Comisiones</span>
        </div>
        <div class="feature-item">
          <i class="fas fa-bolt"></i>
          <span>Confirmación Rápida</span>
        </div>
        <div class="feature-item">
          <i class="fas fa-globe"></i>
          <span>Opciones Globales</span>
        </div>
      </div>
    </div>
  </div>
  
</div>

<!-- Historial Reciente -->
<div class="recent-transactions">
  <div class="section-header">
    <h3><i class="fas fa-history"></i> Transacciones Recientes</h3>
    <a href="<?php echo site_url('member/dashboard'); ?>" class="view-all-link">
      Ver todas <i class="fas fa-arrow-right"></i>
    </a>
  </div>
  <div class="transactions-info">
    <p>Puedes ver todo tu historial de transacciones en el dashboard principal.</p>
  </div>
</div>

<!-- Información de Ayuda -->
<div class="help-section">
  <div class="help-card">
    <i class="fas fa-question-circle"></i>
    <h4>¿Necesitas Ayuda?</h4>
    <p>Contacta con nuestro soporte 24/7 para cualquier duda sobre pagos.</p>
    <a href="https://t.me/CymartSoporte" target="_blank" class="help-link">
      <i class="fab fa-telegram"></i> Telegram Support
    </a>
  </div>
</div>

</div>

<style>
/* ==== ESTILOS PRO AGREGAR CRÉDITOS ==== */
.add-credits-pro {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0;
}

/* Header Premium */
.credits-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 30px;
  border-radius: 16px;
  margin-bottom: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 8px 16px rgba(102,126,234,0.3);
  flex-wrap: wrap;
  gap: 20px;
}

.header-content {
  display: flex;
  align-items: center;
  gap: 20px;
}

.header-icon {
  font-size: 48px;
  line-height: 1;
}

.header-text h1 {
  color: #fff;
  margin: 0 0 8px 0;
  font-size: 28px;
  font-weight: 700;
}

.header-text p {
  color: rgba(255,255,255,0.9);
  margin: 0;
  font-size: 15px;
}

.current-balance {
  background: rgba(255,255,255,0.2);
  padding: 15px 25px;
  border-radius: 12px;
  text-align: center;
  backdrop-filter: blur(10px);
}

.balance-label {
  display: block;
  color: rgba(255,255,255,0.9);
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 5px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.balance-amount {
  display: block;
  color: #fff;
  font-size: 32px;
  font-weight: 700;
  line-height: 1;
}

/* Grid de Métodos de Pago */
.payment-methods-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
  gap: 25px;
  margin-bottom: 30px;
}

.payment-method-card {
  background: #fff;
  border-radius: 16px;
  padding: 30px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: all 0.3s;
  position: relative;
  border: 2px solid transparent;
}

.payment-method-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

.payment-method-card.featured {
  border-color: #667eea;
}

.featured-badge {
  position: absolute;
  top: -12px;
  right: 20px;
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  color: #fff;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 700;
  box-shadow: 0 4px 8px rgba(245,87,108,0.3);
}

.method-header {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 25px;
  padding-bottom: 20px;
  border-bottom: 2px solid #f3f4f6;
}

.method-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
}

.paypal-icon {
  background: linear-gradient(135deg, #0070ba 0%, #1546a0 100%);
  color: #fff;
}

.crypto-icon {
  background: linear-gradient(135deg, #f7931a 0%, #f7931a 100%);
  color: #fff;
}

.method-info h3 {
  margin: 0 0 5px 0;
  font-size: 20px;
  font-weight: 700;
  color: #1f2937;
}

.method-info p {
  margin: 0;
  font-size: 14px;
  color: #6b7280;
}

/* Formulario */
.payment-form {
  margin: 0;
}

.form-group-pro {
  margin-bottom: 20px;
}

.form-label-pro {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 8px;
}

.form-label-pro i {
  color: #667eea;
  margin-right: 6px;
}

.input-wrapper {
  position: relative;
}

.input-prefix {
  position: absolute;
  left: 15px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 16px;
  font-weight: 600;
  color: #6b7280;
}

.form-input-pro {
  width: 100%;
  padding: 12px 15px 12px 35px;
  border: 2px solid #e5e7eb;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  transition: all 0.3s;
}

.form-input-pro:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
}

.form-hint {
  display: block;
  margin-top: 6px;
  font-size: 12px;
  color: #6b7280;
}

/* Botones de Pago */
.btn-payment {
  width: 100%;
  padding: 15px 20px;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition: all 0.3s;
  margin-bottom: 20px;
}

.paypal-btn {
  background: linear-gradient(135deg, #0070ba 0%, #1546a0 100%);
  color: #fff;
  box-shadow: 0 4px 12px rgba(0,112,186,0.3);
}

.paypal-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,112,186,0.4);
}

.crypto-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: #fff;
  box-shadow: 0 4px 12px rgba(102,126,234,0.3);
}

.crypto-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(102,126,234,0.4);
}

/* Opciones de Pago */
.payment-options-list {
  margin-bottom: 20px;
}

.payment-option {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background: #f9fafb;
  border-radius: 8px;
  margin-bottom: 8px;
  font-size: 14px;
  font-weight: 500;
  color: #374151;
}

.payment-option i {
  font-size: 20px;
}

.crypto-color { color: #f7931a; }
.yape-color { color: #722c85; }
.bank-color { color: #1e40af; }
.card-color { color: #059669; }
.paypal-color { color: #0070ba; }

/* Features */
.payment-features {
  display: flex;
  justify-content: space-around;
  padding-top: 15px;
  border-top: 1px solid #e5e7eb;
}

.feature-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: #6b7280;
  text-align: center;
}

.feature-item i {
  font-size: 18px;
  color: #667eea;
}

/* Sección de Transacciones */
.recent-transactions {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  margin-bottom: 25px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.section-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 700;
  color: #1f2937;
}

.section-header h3 i {
  color: #667eea;
  margin-right: 8px;
}

.view-all-link {
  color: #667eea;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s;
}

.view-all-link:hover {
  color: #764ba2;
}

.transactions-info {
  padding: 20px;
  background: #f9fafb;
  border-radius: 8px;
  text-align: center;
  color: #6b7280;
}

/* Sección de Ayuda */
.help-section {
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.help-card {
  text-align: center;
}

.help-card i {
  font-size: 40px;
  color: #d97706;
  margin-bottom: 15px;
}

.help-card h4 {
  margin: 0 0 10px 0;
  font-size: 20px;
  font-weight: 700;
  color: #92400e;
}

.help-card p {
  margin: 0 0 15px 0;
  color: #78350f;
  font-size: 14px;
}

.help-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #fff;
  color: #0088cc;
  padding: 10px 20px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s;
}

.help-link:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  color: #0088cc;
}

/* Responsive */
@media (max-width: 968px) {
  .payment-methods-grid {
    grid-template-columns: 1fr;
  }
  
  .credits-header {
    flex-direction: column;
    text-align: center;
  }
  
  .header-content {
    flex-direction: column;
  }
}
</style>

<script>
function abrirPagosCymar() {
  // Obtener email del usuario actual
  const email = '<?php echo $this->session->userdata("MemberEmail"); ?>';
  const name = '<?php echo $this->session->userdata("MemberFirstName"); ?>';
  
  // URL de la página de pagos (ajustar según tu configuración)
  const urlPagos = '<?php echo base_url("Pagos/"); ?>';
  
  // Construir URL con parámetros
  const url = urlPagos + '?email=' + encodeURIComponent(email) + '&name=' + encodeURIComponent(name);
  
  // Abrir en nueva pestaña
  window.open(url, '_blank');
}
</script>