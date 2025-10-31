<div class="dashboard">
<div class="row">
  <div class="col-lg-12">
  <h2>IMEI Code Request</h2>
  </div>
</div>

<style>
/* Search Bar Styles */
.search-bar-container {
    background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
    border-radius: 16px;
    padding: 30px;
    margin: 25px 0;
    box-shadow: 0 8px 25px rgba(14, 165, 233, 0.25);
}

.search-wrapper {
    position: relative;
    max-width: 600px;
    margin: 0 auto;
}

.search-input {
    width: 100%;
    padding: 16px 50px 16px 50px;
    font-size: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    transition: all 0.3s;
    color: #0f172a;
    font-weight: 600;
}

.search-input:focus {
    outline: none;
    border-color: #fff;
    background: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.search-input::placeholder {
    color: #94a3b8;
    font-weight: 500;
}

.search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #64748b;
}

.clear-search {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    background: #ef4444;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    display: none;
    transition: all 0.3s;
}

.clear-search:hover {
    background: #dc2626;
    transform: translateY(-50%) scale(1.1);
}

.search-stats {
    text-align: center;
    margin-top: 15px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
}

.search-stats span {
    background: rgba(255, 255, 255, 0.2);
    padding: 5px 12px;
    border-radius: 20px;
    margin: 0 5px;
}

/* Cards Grid */
.imei-card-grid { 
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px; 
    margin-bottom: 30px; 
}

.imei-card { 
    background: linear-gradient(135deg, #f9fafb 0%, #fff 100%); 
    border: 2px solid #bae6fd; 
    border-radius: 14px; 
    padding: 22px; 
    cursor: pointer; 
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

/* Badge "Nuevo" */
.service-new-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
    z-index: 2;
}

.imei-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s;
}

.imei-card:hover::before {
    opacity: 1;
}

.imei-card:hover { 
    box-shadow: 0 8px 35px rgba(14, 165, 233, 0.3); 
    border-color: #0ea5e9; 
    background: #fff;
    transform: translateY(-5px);
}

.imei-card.hidden {
    display: none;
}

.imei-serv-title { 
    font-size: 18px; 
    font-weight: 800; 
    color: #0f172a; 
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

/* Emojis en títulos de servicios */
.imei-serv-title emoji {
    font-size: 1.1em;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
}

.imei-serv-details { 
    font-size: 14px; 
    color: #64748b; 
    font-weight: 500;
    line-height: 1.5;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.imei-price-chip { 
    background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
    color: #fff; 
    padding: 4px 12px; 
    border-radius: 10px; 
    font-size: 14px; 
    font-weight: 800; 
    display: inline-block; 
    margin-bottom: 5px; 
    margin-right: 8px;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.imei-delivery { 
    font-size: 13px; 
    color: #1e293b; 
    margin-top: 8px;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

/* Category Headers - Mejorado con diseño más colorido y divisores */
.category-section {
    margin-bottom: 50px;
}

.category-divider {
    height: 4px;
    background: linear-gradient(90deg, transparent 0%, #8b5cf6 20%, #ec4899 50%, #0ea5e9 80%, transparent 100%);
    margin: 35px 0;
    border-radius: 2px;
    opacity: 0.6;
}

.category-header {
    margin: 40px 0 25px 0;
    padding: 25px 35px;
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #0ea5e9 100%);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 8px 30px rgba(139, 92, 246, 0.4);
    position: relative;
    overflow: hidden;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.category-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% { opacity: 0; }
    50% { opacity: 1; }
}

.category-header-left {
    display: flex;
    align-items: center;
    gap: 18px;
    flex: 1;
    position: relative;
    z-index: 1;
}

.category-header.hidden {
    display: none;
}

.category-icon {
    font-size: 38px;
    filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.3));
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.category-title {
    font-size: 28px;
    font-weight: 900;
    color: #ffffff;
    margin: 0;
    flex: 1;
    text-shadow: 0 3px 10px rgba(0, 0, 0, 0.4);
    letter-spacing: 0.8px;
    text-transform: uppercase;
    line-height: 1.3;
}

/* Emojis y badges en títulos de grupos */
.category-title emoji {
    display: inline-block;
    margin-right: 10px;
    font-size: 0.9em;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.category-count {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 15px;
    font-weight: 800;
    border: 2px solid rgba(255, 255, 255, 0.4);
    position: relative;
    z-index: 1;
    font-weight: 800;
}

/* No Results */
.no-results {
    display: none;
    text-align: center;
    padding: 60px 30px;
    background: #f8fafc;
    border-radius: 16px;
    margin: 30px 0;
}

.no-results.active {
    display: block;
}

.no-results-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.no-results-text {
    font-size: 20px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 10px;
}

.no-results-subtext {
    font-size: 15px;
    color: #94a3b8;
}

/* Modal Styles */
.imei-modal-overlay { 
    display: none; 
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center; 
    justify-content: center; 
} 

.imei-modal-overlay.active {
    display: flex;
} 

.imei-modal {
    background: #fff;
    max-width: 450px;
    width: 94vw;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
    padding: 30px;
    position: relative; 
    animation: fadeInUp 0.3s;
} 

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(60px);
    }
    to {
        opacity: 1;
        transform: none;
    } 
} 

.imei-modal-close {
    position: absolute;
    top: 15px;
    right: 18px;
    font-size: 28px;
    background: rgba(100, 116, 139, 0.1);
    border: none;
    color: #64748b;
    cursor: pointer;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.imei-modal-close:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    transform: rotate(90deg);
}

.imei-modal h3 {
    font-size: 22px;
    font-weight: 800;
    color: #0ea5e9;
    margin: 0 0 20px 0;
}

.imei-modal label {
    color: #0f172a;
    font-size: 14px; 
    font-weight: 700; 
    margin-top: 12px;
    margin-bottom: 6px;
    display: block;
}

.imei-modal input, 
.imei-modal textarea { 
    width: 100%;
    padding: 12px 14px; 
    margin-bottom: 12px;
    border: 2px solid #e2e8f0;
    border-radius: 10px; 
    resize: none; 
    font-size: 15px;
    transition: all 0.3s;
}

.imei-modal input:focus,
.imei-modal textarea:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

.imei-modal .btn-modal {
    margin-top: 15px;
    width: 100%;
    padding: 14px 0;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
    color: #fff;
    font-weight: 800;
    font-size: 17px;
    letter-spacing: 0.5px; 
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
}

.imei-modal .btn-modal:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
}

/* Page Title */
.page-title {
    margin: 35px 0 0 0;
    font-weight: 900;
    font-size: 32px;
    color: #0f172a;
    text-align: center;
}

@media (max-width: 768px) {
    .imei-card-grid {
        grid-template-columns: 1fr;
    }
    
    .category-header {
        flex-direction: column;
        text-align: center;
    }
    
    .page-title {
        font-size: 26px;
    }
}
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 35px 0 20px 0; flex-wrap: wrap; gap: 15px;">
  <h2 class="page-title" style="margin: 0; flex: 1;">📱 Servicios IMEI Disponibles</h2>
  <button id="toggleViewMode" onclick="toggleViewMode()" style="padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3); transition: all 0.3s;">
    <span id="viewModeIcon">📋</span> <span id="viewModeText">Ver Todos Juntos</span>
  </button>
</div>

<!-- Search Bar -->
<div class="search-bar-container">
    <div class="search-wrapper">
        <span class="search-icon">🔍</span>
        <input 
            type="text" 
            id="serviceSearch" 
            class="search-input" 
            placeholder="Buscar servicios por nombre, descripción o precio..."
            autocomplete="off"
        >
        <button class="clear-search" id="clearSearch">×</button>
    </div>
    <div class="search-stats">
        Mostrando <span id="visibleCount">0</span> de <span id="totalCount">0</span> servicios
  </div>
</div>

<!-- No Results Message -->
<div class="no-results" id="noResults">
    <div class="no-results-icon">🔍</div>
    <div class="no-results-text">No se encontraron servicios</div>
    <div class="no-results-subtext">Intenta con otros términos de búsqueda</div>
    </div>
    
<!-- Services by Category -->
<?php 
$hasServices = false;
$totalServices = 0;

// Debug: Verificar si la variable existe
if(!isset($imeimethods)) {
    echo '<div style="padding:60px;text-align:center;background:#fff3cd;border:2px solid #ffc107;border-radius:16px;margin:30px 0;">';
    echo '<h3 style="color:#856404;font-size:24px;margin-bottom:15px;">⚠️ Error de Configuración</h3>';
    echo '<p style="color:#856404;font-size:16px;">La variable <code>$imeimethods</code> no está definida.</p>';
    echo '<p style="color:#856404;margin-top:10px;">Por favor contacta al administrador del sistema.</p>';
    echo '</div>';
    $imeimethods = array(); // Evitar errores
}

foreach($imeimethods as $networkId => $network): 
  if(!empty($network['methods'])): 
    $hasServices = true;
    $totalServices += count($network['methods']);
?>
  <div class="category-section" data-category-id="<?php echo $networkId; ?>" data-group-name="<?php echo htmlspecialchars($network['Title'], ENT_QUOTES, 'UTF-8'); ?>">
    <!-- Divisor Visual entre Grupos -->
    <?php if($hasServices && $totalServices > count($network['methods'])): ?>
    <div class="category-divider"></div>
    <?php endif; ?>
    
    <div class="category-header">
      <div class="category-header-left">
        <span class="category-icon">🚀</span>
        <h3 class="category-title">
          <?php 
          $groupName = isset($network['Title']) && $network['Title'] != '' ? htmlspecialchars($network['Title'], ENT_QUOTES, 'UTF-8') : 'Categoría General';
          // Detectar emojis comunes en el nombre del grupo y mantenerlos
          echo $groupName;
          ?>
        </h3>
      </div>
      <span class="category-count" data-original-count="<?php echo count($network['methods']); ?>">
        ✅ <?php echo count($network['methods']); ?> servicios
      </span>
    </div>
    
    <div class="imei-card-grid">
      <?php 
      $serviceIndex = 0;
      foreach($network['methods'] as $method): 
        $serviceIndex++;
        // Detectar si el servicio tiene emojis en el título
        $serviceTitle = htmlspecialchars($method['Title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $isNewService = ($serviceIndex <= 3); // Marcar primeros 3 como "nuevos" como ejemplo
      ?>
      <div 
        class="imei-card" 
        data-methodid="<?php echo $method['ID']; ?>"
        data-title="<?php echo htmlspecialchars($method['Title'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>"
        data-description="<?php echo isset($method['Description']) ? htmlspecialchars($method['Description'], ENT_QUOTES, 'UTF-8') : ''; ?>"
        data-price="<?php echo isset($method['Price']) ? $method['Price'] : ''; ?>"
        data-category-id="<?php echo $networkId; ?>"
        onclick='openImeiModal(<?php echo json_encode($method["ID"]); ?>, <?php echo json_encode($method["Title"]); ?>, <?php echo json_encode(isset($method["Price"])?$method["Price"]:""); ?>)'
      >
        <?php if($isNewService): ?>
        <div class="service-new-badge">✨ Nuevo</div>
        <?php endif; ?>
        
        <div class="imei-serv-title">
          <?php echo $serviceTitle; ?>
        </div>
        <div class="imei-serv-details">
          <?php echo isset($method['Description']) && $method['Description']!='' && $method['Description'] != $network['Title'] ? htmlspecialchars($method['Description'], ENT_QUOTES | ENT_HTML5, 'UTF-8') : 'Servicio premium disponible'; ?>
        </div>
        <div class="imei-delivery">⏱️ Tiempo: <?php echo isset($method['DeliveryTime']) && $method['DeliveryTime']!='' ? htmlspecialchars($method['DeliveryTime'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?></div>
        <div style="display:flex;align-items:center;margin-top:12px;gap:8px;flex-wrap:wrap;">
          <span class="imei-price-chip">💰 $<?php echo isset($method['Price'])?number_format($method['Price'], 2):'?'; ?></span>
          <span style="color:#64748b;font-size:12px;font-weight:700;background:#f1f5f9;padding:4px 10px;border-radius:6px;">🔢 ID #<?php echo $method['ID'];?></span>
	    </div>
  	</div>
      <?php endforeach; ?>
    </div>
  </div>
<?php 
  endif;
endforeach; 

if(!$hasServices): ?>
  <div style="padding:60px;text-align:center;background:linear-gradient(135deg,#f8fafc 0%,#e0f2fe 100%);border:2px solid #0ea5e9;border-radius:20px;margin:30px 0;box-shadow:0 4px 15px rgba(14,165,233,0.15);">
    <div style="font-size:64px;margin-bottom:20px;">📭</div>
    <h3 style="color:#0f172a;font-size:26px;font-weight:800;margin-bottom:15px;">No hay servicios IMEI disponibles</h3>
    <p style="color:#475569;font-size:16px;margin-bottom:20px;max-width:600px;margin-left:auto;margin-right:auto;">
      El administrador aún no ha importado servicios IMEI desde la API.
    </p>
    <div style="background:#fff;border-radius:12px;padding:25px;max-width:700px;margin:25px auto;text-align:left;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
      <h4 style="color:#0ea5e9;font-size:18px;font-weight:800;margin-bottom:15px;">📋 Para Administradores:</h4>
      <ol style="color:#475569;font-size:14px;line-height:1.8;padding-left:20px;">
        <li>Ve a <strong>Admin Panel</strong> → <strong>API Manager</strong></li>
        <li>Selecciona tu <strong>API tipo "Imei"</strong> (ID 16 - adyunlocker.com)</li>
        <li>Haz clic en <strong>"Ver Servicios"</strong></li>
        <li>El sistema filtrará automáticamente solo servicios con <code>SERVICETYPE='IMEI'</code></li>
        <li>Selecciona los servicios que deseas importar</li>
        <li>Haz clic en <strong>"Add Selected Services"</strong></li>
      </ol>
      <div style="background:#dbeafe;border-left:4px solid #0ea5e9;padding:15px;margin-top:20px;border-radius:8px;">
        <p style="color:#1e40af;font-size:13px;margin:0;"><strong>💡 Nota:</strong> El filtro automático por <code>SERVICETYPE</code> asegura que solo veas servicios IMEI aquí, y servicios SERVER en la sección correspondiente.</p>
	    </div>
  	</div>
    <p style="color:#64748b;font-size:14px;margin-top:25px;">
      Si eres cliente, por favor contacta al administrador para que importe los servicios.
    </p>
  </div>
<?php endif; ?>

<!-- MODAL -->
<div id="imeiModalOverlay" class="imei-modal-overlay" tabindex="-1">
  <div class="imei-modal">
    <button class="imei-modal-close" onclick="closeImeiModal()">×</button>
    <h3 id="imeiModalTitle">Servicio</h3>
    <form method="post" action="<?php echo site_url('member/imeirequest/insert'); ?>">
      <input type="hidden" name="MethodID" id="ModalMethodID" required>
      
      <label for="ModalIMEI">IMEI <span style="color:#dc2626;font-weight:700;">*</span></label>
      <textarea name="IMEI" id="ModalIMEI" placeholder="Ingrese 1 o varios IMEI (uno por línea)" rows="3" required></textarea>
      
      <label for="ModalEmail">Email <span style="color:#dc2626;font-weight:700;">*</span></label>
      <input type="email" name="Email" id="ModalEmail" required placeholder="ejemplo@correo.com">
      
      <label for="ModalNote">Nota (opcional)</label>
      <textarea name="Note" id="ModalNote" placeholder="Información adicional..." rows="2"></textarea>
      
      <button type="submit" class="btn-modal">🚀 Solicitar Servicio</button>
    </form>
  </div>
  </div>

<!-- Modal de Éxito para Orden Creada -->
<div id="imeiSuccessModal" class="imei-modal-overlay" style="display: none;">
  <div class="imei-modal" style="max-width: 500px;">
    <div style="text-align: center; padding: 20px 0;">
      <div style="font-size: 64px; color: #10b981; margin-bottom: 15px;">✅</div>
      <h3 style="color: #10b981; margin-bottom: 10px;">¡Orden Creada Exitosamente!</h3>
    </div>
    
    <div id="successDetails" style="background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;">
      <div style="margin-bottom: 12px;">
        <strong>Servicio:</strong> <span id="successServiceName">-</span>
      </div>
      <div style="margin-bottom: 12px;">
        <strong>Órdenes creadas:</strong> <span id="successOrdersCount">-</span>
      </div>
      <div style="margin-bottom: 12px;">
        <strong>Monto total:</strong> $<span id="successTotalAmount">-</span> USD
      </div>
      <div style="color: #059669; font-size: 14px; margin-top: 10px;">
        ✅ Los créditos han sido descontados y tu pedido será procesado automáticamente.
      </div>
    </div>
    
    <div id="successCountdown" style="text-align: center; padding: 15px; background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(16, 185, 129, 0.1)); border-radius: 12px; margin: 20px 0;">
      <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
        <span style="font-size: 18px;">⏱️</span>
        <span>Redirigiendo automáticamente en <strong id="countdownSeconds" style="color: #0ea5e9; font-size: 20px;">10</strong> segundos...</span>
      </div>
    </div>
    
    <div style="display: flex; gap: 12px; margin-top: 25px;">
      <button onclick="createAnotherOrder()" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #0ea5e9, #10b981); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 15px; cursor: pointer; transition: all 0.3s;">
        🔄 Realizar Otra Orden
      </button>
      <button onclick="goToHistory()" style="flex: 1; padding: 14px; background: #64748b; color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 15px; cursor: pointer; transition: all 0.3s;">
        📋 Ver Historial
      </button>
    </div>
    
    <button onclick="closeSuccessModal()" style="position: absolute; top: 15px; right: 15px; background: rgba(100, 116, 139, 0.1); border: none; color: #64748b; cursor: pointer; width: 32px; height: 32px; border-radius: 50%; font-size: 20px; display: flex; align-items: center; justify-content: center;">
      ×
    </button>
  </div>
</div>

<script>
// Variables globales para el modal de éxito
var successModalTimer = null;
var successCountdownInterval = null;
var currentMethodId = null;

// Verificar si hay una orden exitosa (usando JavaScript vanilla para mayor compatibilidad)
var imeiOrderSuccess = <?php echo $this->session->flashdata('imei_order_success') ? 'true' : 'false'; ?>;
var imeiOrdersCount = <?php echo $this->session->flashdata('imei_orders_count') ?: 0; ?>;
var imeiTotalAmount = <?php echo $this->session->flashdata('imei_total_amount') ?: 0; ?>;
var imeiMethodTitle = <?php echo json_encode($this->session->flashdata('imei_method_title') ?: 'Servicio IMEI'); ?>;
var imeiMethodId = <?php echo $this->session->flashdata('imei_method_id') ?: 0; ?>;

// Función para mostrar modal cuando la página esté lista
function initSuccessModal() {
    if (imeiOrderSuccess && imeiOrdersCount > 0) {
        currentMethodId = imeiMethodId;
        
        console.log('✅ Mostrando modal de éxito:', {
            ordersCount: imeiOrdersCount,
            totalAmount: imeiTotalAmount,
            methodTitle: imeiMethodTitle,
            methodId: imeiMethodId
        });
        
        showSuccessModal({
            serviceName: imeiMethodTitle,
            ordersCount: imeiOrdersCount,
            totalAmount: parseFloat(imeiTotalAmount).toFixed(2)
        });
    }
}

// Intentar con jQuery primero, luego con JavaScript vanilla
if (typeof jQuery !== 'undefined') {
    jQuery(document).ready(function($) {
        initSuccessModal();
    });
} else {
    // Fallback a JavaScript vanilla
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSuccessModal);
    } else {
        // DOM ya está listo
        initSuccessModal();
    }
}

function showSuccessModal(data) {
    document.getElementById('successServiceName').textContent = data.serviceName || 'Servicio IMEI';
    document.getElementById('successOrdersCount').textContent = data.ordersCount || '0';
    document.getElementById('successTotalAmount').textContent = data.totalAmount || '0.00';
    
    // Resetear contador
    document.getElementById('countdownSeconds').textContent = '10';
    
    // Mostrar modal
    document.getElementById('imeiSuccessModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Iniciar contador
    startSuccessCountdown();
}

function startSuccessCountdown() {
    var seconds = 10;
    var countdownEl = document.getElementById('countdownSeconds');
    
    successCountdownInterval = setInterval(function() {
        seconds--;
        
        if(seconds <= 0) {
            clearInterval(successCountdownInterval);
            closeSuccessModal();
        } else {
            countdownEl.textContent = seconds.toString();
        }
    }, 1000);
    
    // Backup timer
    successModalTimer = setTimeout(function() {
        if(successCountdownInterval) {
            clearInterval(successCountdownInterval);
        }
        closeSuccessModal();
    }, 10000);
}

function closeSuccessModal() {
    if(successModalTimer) {
        clearTimeout(successModalTimer);
        successModalTimer = null;
    }
    if(successCountdownInterval) {
        clearInterval(successCountdownInterval);
        successCountdownInterval = null;
    }
    
    document.getElementById('imeiSuccessModal').style.display = 'none';
    document.body.style.overflow = '';
}

function createAnotherOrder() {
    closeSuccessModal();
    
    // Si tenemos el MethodID guardado, abrir modal con ese servicio
    if(currentMethodId && currentMethodId > 0) {
        // Buscar el card del servicio usando data-methodid
        var serviceCard = document.querySelector('[data-methodid="' + currentMethodId + '"]');
        if(serviceCard) {
            var serviceId = serviceCard.dataset.methodid;
            var serviceTitle = serviceCard.dataset.title;
            var servicePrice = serviceCard.dataset.price || '';
            
            setTimeout(function() {
                openImeiModal(serviceId, serviceTitle, servicePrice);
            }, 300);
        } else {
            // Si no se encuentra, simplemente recargar la página
            location.reload();
        }
    } else {
        location.reload();
    }
}

function goToHistory() {
    closeSuccessModal();
    window.location.href = '<?php echo site_url("member/imeirequest/history"); ?>';
}

// Cerrar modal al hacer clic fuera
document.getElementById('imeiSuccessModal').addEventListener('click', function(e) {
    if(e.target === this) {
        closeSuccessModal();
    }
});

// Modal Functions
function openImeiModal(id, title, price) {
    document.getElementById('imeiModalOverlay').classList.add('active');
    document.getElementById('ModalMethodID').value = id;
    document.getElementById('ModalIMEI').value = '';
    document.getElementById('ModalEmail').value = '';
    document.getElementById('ModalNote').value = '';
    document.getElementById('imeiModalTitle').textContent = title + (price ? ' - $'+price : '');
    setTimeout(function(){ document.getElementById('ModalIMEI').focus(); }, 150);
}

function closeImeiModal() { 
    document.getElementById('imeiModalOverlay').classList.remove('active'); 
}

document.getElementById('imeiModalOverlay').addEventListener('click', function(e) { 
    if(e.target === this) closeImeiModal(); 
});

// View Mode Toggle (Ver Todos Juntos / Por Categorías)
var viewMode = 'categories'; // 'categories' or 'all'

function toggleViewMode() {
    viewMode = viewMode === 'categories' ? 'all' : 'categories';
    
    const iconEl = document.getElementById('viewModeIcon');
    const textEl = document.getElementById('viewModeText');
    const categoryHeaders = document.querySelectorAll('.category-header');
    const categorySections = document.querySelectorAll('.category-section');
    
    if(viewMode === 'all') {
        // Modo: Todos juntos
        iconEl.textContent = '📁';
        textEl.textContent = 'Ver por Categorías';
        
        // Ocultar headers de categorías
        categoryHeaders.forEach(header => {
            header.style.display = 'none';
        });
        
        // Mostrar todos los cards en un solo grid
        const allCards = document.querySelectorAll('.imei-card');
        const firstGrid = document.querySelector('.imei-card-grid');
        
        if(firstGrid && allCards.length > 0) {
            // Mover todos los cards al primer grid
            categorySections.forEach((section, index) => {
                if(index === 0) {
                    // Primera sección: mantener su grid visible
                    section.style.display = 'block';
                } else {
                    // Otras secciones: mover cards y ocultar
                    const grid = section.querySelector('.imei-card-grid');
                    if(grid) {
                        const cards = grid.querySelectorAll('.imei-card');
                        cards.forEach(card => {
                            firstGrid.appendChild(card);
                        });
                    }
                    section.style.display = 'none';
                }
            });
        }
    } else {
        // Modo: Por categorías
        iconEl.textContent = '📋';
        textEl.textContent = 'Ver Todos Juntos';
        
        // Mostrar headers
        categoryHeaders.forEach(header => {
            header.style.display = 'flex';
        });
        
        // Mostrar todas las secciones (los cards ya están en su lugar por el HTML original)
        location.reload(); // Simplificado: recargar para resetear
    }
}

// Search Functionality
(function() {
    const searchInput = document.getElementById('serviceSearch');
    const clearBtn = document.getElementById('clearSearch');
    const noResults = document.getElementById('noResults');
    const visibleCountEl = document.getElementById('visibleCount');
    const totalCountEl = document.getElementById('totalCount');
    
    const allCards = document.querySelectorAll('.imei-card');
    const allCategories = document.querySelectorAll('.category-section');
    const totalServices = <?php echo $totalServices; ?>;
    
    totalCountEl.textContent = totalServices;
    visibleCountEl.textContent = totalServices;
    
    function updateSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        if(searchTerm) {
            clearBtn.style.display = 'flex';
        } else {
            clearBtn.style.display = 'none';
        }
        
        let visibleCount = 0;
        const categoryVisibility = {};
        
        // Filter cards
        allCards.forEach(card => {
            const title = card.dataset.title.toLowerCase();
            const description = card.dataset.description.toLowerCase();
            const price = card.dataset.price.toLowerCase();
            const categoryId = card.dataset.categoryId;
            
            const matches = title.includes(searchTerm) || 
                          description.includes(searchTerm) || 
                          price.includes(searchTerm);
            
            if(matches) {
                card.classList.remove('hidden');
                visibleCount++;
                categoryVisibility[categoryId] = true;
            } else {
                card.classList.add('hidden');
            }
        });
        
        // Update category visibility and counts
        allCategories.forEach(category => {
            const categoryId = category.dataset.categoryId;
            const categoryHeader = category.querySelector('.category-header');
            const categoryCountEl = category.querySelector('.category-count');
            const visibleCardsInCategory = category.querySelectorAll('.imei-card:not(.hidden)').length;
            const originalCount = categoryCountEl.dataset.originalCount;
            
            if(categoryVisibility[categoryId]) {
                categoryHeader.classList.remove('hidden');
                if(searchTerm) {
                    categoryCountEl.textContent = visibleCardsInCategory + ' de ' + originalCount + ' servicios';
                } else {
                    categoryCountEl.textContent = originalCount + ' servicios';
                }
            } else {
                categoryHeader.classList.add('hidden');
            }
        });
        
        // Show/hide no results message
        if(visibleCount === 0 && searchTerm) {
            noResults.classList.add('active');
        } else {
            noResults.classList.remove('active');
        }
        
        // Update stats
        visibleCountEl.textContent = visibleCount;
    }
    
    searchInput.addEventListener('input', updateSearch);
    
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        updateSearch();
        searchInput.focus();
    });
    
    // Keyboard shortcut: Ctrl+K or Cmd+K to focus search
    document.addEventListener('keydown', function(e) {
        if((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
        
        // ESC to clear search
        if(e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.value = '';
            updateSearch();
        }
    });
})();
</script>

    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var id = $("#MethodID").val();
    if(id != "") {
        var data = $("#imeireq").serialize();
        $.ajax({
            type: "post",
            url: "<?php echo site_url('member/imeirequest/formfields'); ?>",
            data: data,
            cache: false,
            success: function(data) {
                $("#load-field").html('');
                $("#load-field").html(data);
                $("#load-field .form-group").hide();
            }
        });		
    }	    
    
    $("#MethodID").change(function() {
        var id = $("#MethodID").val();
        if(id != "") {
            var data = $("#imeireq").serialize();
            $.ajax({
                type: "post",
                url: "<?php echo site_url('member/imeirequest/formfields'); ?>",
                data: data,
                cache: false,
                success: function(data) {
                    $("#load-field").html('');
                    $("#load-field").html(data);
                    $("#load-field .form-group").hide();
                }
            });		
        } else {
            $("#load-field").html('');
        }
    });
    
    $('#MethodID').select2();	
});
</script>
