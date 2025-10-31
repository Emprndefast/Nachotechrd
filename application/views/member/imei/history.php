<div class="dashboard imei-history-pro">

<!-- Header con estadísticas -->
<div class="history-header">
  <div class="header-title">
    <h1>📱 Historial IMEI</h1>
    <p>Gestiona y monitorea todas tus órdenes IMEI</p>
  </div>
</div>

<!-- Estadísticas rápidas -->
<div class="stats-grid">
  <div class="stat-card stat-total">
    <div class="stat-icon">📊</div>
    <div class="stat-info">
      <div class="stat-label">Total Órdenes</div>
      <div class="stat-value" id="stat-total">0</div>
    </div>
  </div>
  <div class="stat-card stat-completed">
    <div class="stat-icon">✅</div>
    <div class="stat-info">
      <div class="stat-label">Completadas</div>
      <div class="stat-value" id="stat-completed">0</div>
    </div>
  </div>
  <div class="stat-card stat-pending">
    <div class="stat-icon">⏰</div>
    <div class="stat-info">
      <div class="stat-label">Pendientes</div>
      <div class="stat-value" id="stat-pending">0</div>
    </div>
  </div>
  <div class="stat-card stat-rejected">
    <div class="stat-icon">❌</div>
    <div class="stat-info">
      <div class="stat-label">Rechazadas</div>
      <div class="stat-value" id="stat-rejected">0</div>
    </div>
  </div>
</div>

<!-- Barra de herramientas mejorada -->
<div class="toolbar-container">
  <div class="toolbar-left">
    <!-- Búsqueda en vivo -->
    <div class="search-box">
      <span class="search-icon">🔍</span>
      <input type="text" id="live-search" placeholder="Buscar por IMEI, servicio, código...">
    </div>
    
    <!-- Selector de vista -->
    <div class="view-selector">
      <button class="view-btn active" data-view="cards" title="Vista de tarjetas">
        <span>📇</span>
      </button>
      <button class="view-btn" data-view="table" title="Vista de tabla">
        <span>📋</span>
      </button>
    </div>
  </div>
  
  <div class="toolbar-right">
    <!-- Filtros de Estado -->
    <div class="status-filters">
      <button class="status-filter-btn active" data-status="all">
        <span class="filter-icon">📊</span> TODO
      </button>
      <button class="status-filter-btn" data-status="Issued">
        <span class="filter-icon">✅</span> Completados
      </button>
      <button class="status-filter-btn" data-status="Pending">
        <span class="filter-icon">⏰</span> Pendientes
      </button>
      <button class="status-filter-btn" data-status="Canceled">
        <span class="filter-icon">❌</span> Rechazados
      </button>
    </div>
    
    <!-- Botón de exportación -->
    <button class="export-btn" id="export-csv">
      <span>📥</span> Exportar CSV
    </button>
  </div>
</div>

<!-- Contenedor de órdenes -->
<div id="orders-container" class="orders-wrapper cards-view">
  <div class="loading-state">
    <div class="loading-spinner"></div>
    <p>Cargando órdenes...</p>
  </div>
</div>

</div>

<style>
/* ==== ESTILOS PRO HISTORIAL IMEI ==== */
.imei-history-pro {
  padding: 0;
}

/* Header */
.history-header {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  padding: 30px 25px;
  border-radius: 12px;
  margin-bottom: 25px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.header-title h1 {
  color: #fff;
  font-size: 28px;
  font-weight: 700;
  margin: 0 0 8px 0;
}

.header-title p {
  color: rgba(255,255,255,0.7);
  margin: 0;
  font-size: 15px;
}

/* Estadísticas */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
  margin-bottom: 25px;
}

.stat-card {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 15px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  border-left: 4px solid #0d9488;
  transition: all 0.3s;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.stat-card.stat-total { border-left-color: #0ea5e9; }
.stat-card.stat-completed { border-left-color: #10b981; }
.stat-card.stat-pending { border-left-color: #f97316; }
.stat-card.stat-rejected { border-left-color: #ef4444; }

.stat-icon {
  font-size: 36px;
  line-height: 1;
}

.stat-label {
  font-size: 13px;
  color: #6b7280;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 5px;
}

.stat-value {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  line-height: 1;
}

/* Barra de herramientas */
.toolbar-container {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  margin-bottom: 25px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.toolbar-left, .toolbar-right {
  display: flex;
  align-items: center;
  gap: 15px;
  flex-wrap: wrap;
}

/* Búsqueda */
.search-box {
  position: relative;
  min-width: 280px;
}

.search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 18px;
}

#live-search {
  width: 100%;
  padding: 10px 10px 10px 40px;
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.3s;
}

#live-search:focus {
  outline: none;
  border-color: #0d9488;
  box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
}

/* Selector de vista */
.view-selector {
  display: flex;
  gap: 5px;
  background: #f3f4f6;
  padding: 4px;
  border-radius: 8px;
}

.view-btn {
  background: transparent;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 18px;
  transition: all 0.3s;
}

.view-btn.active {
  background: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.view-btn:hover:not(.active) {
  background: rgba(255,255,255,0.5);
}

/* Filtros de estado */
.status-filters {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.status-filter-btn {
  background: #f3f4f6;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 13px;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 6px;
  white-space: nowrap;
}

.status-filter-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.status-filter-btn.active {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  color: #fff;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.status-filter-btn[data-status="Issued"]:not(.active):hover {
  background: linear-gradient(135deg, #059669 0%, #10b981 100%);
  color: #fff;
}

.status-filter-btn[data-status="Pending"]:not(.active):hover {
  background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
  color: #fff;
}

.status-filter-btn[data-status="Canceled"]:not(.active):hover {
  background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
  color: #fff;
}

/* Botón exportar */
.export-btn {
  background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s;
  white-space: nowrap;
}

.export-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(13,148,136,0.3);
}

/* Contenedor de órdenes */
.orders-wrapper {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  min-height: 400px;
}

/* Vista de tarjetas */
.cards-view .orders-grid {
  display: grid;
  gap: 20px;
}

.order-card {
  background: #ffffff;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  padding: 20px;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.order-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 5px;
  height: 100%;
  background: #0d9488;
  transition: width 0.3s;
}

.order-card:hover {
  border-color: #0d9488;
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  transform: translateY(-3px);
}

.order-card:hover::before {
  width: 8px;
}

.order-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 18px;
  gap: 15px;
}

.order-service {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
}

.order-service-icon {
  font-size: 24px;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  white-space: nowrap;
}

.status-badge.pending {
  background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
  color: white;
  box-shadow: 0 2px 6px rgba(234,88,12,0.3);
}

.status-badge.issued {
  background: linear-gradient(135deg, #059669 0%, #10b981 100%);
  color: white;
  box-shadow: 0 2px 6px rgba(5,150,105,0.3);
}

.status-badge.canceled {
  background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
  color: white;
  box-shadow: 0 2px 6px rgba(220,38,38,0.3);
}

.order-details {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 18px;
  margin-top: 18px;
}

.order-detail-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.order-detail-label {
  font-size: 11px;
  color: #6b7280;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.8px;
}

.order-detail-value {
  font-size: 14px;
  color: #1f2937;
  font-weight: 600;
  word-break: break-all;
}

.order-code-box {
  background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
  padding: 15px;
  border-radius: 10px;
  margin-top: 15px;
  border-left: 4px solid #0d9488;
  font-family: 'Courier New', monospace;
}

.order-code-box.empty {
  background: #f9fafb;
  border-left-color: #9ca3af;
}

.order-note {
  margin-top: 12px;
  padding: 12px;
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  border-radius: 8px;
  border-left: 3px solid #f59e0b;
}

.order-note-label {
  font-size: 11px;
  color: #92400e;
  font-weight: 700;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.order-note-text {
  font-size: 13px;
  color: #78350f;
  line-height: 1.5;
}

/* Vista de tabla */
.table-view .orders-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}

.orders-table thead {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.orders-table th {
  padding: 15px 12px;
  text-align: left;
  font-size: 12px;
  font-weight: 700;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 0.8px;
}

.orders-table th:first-child {
  border-radius: 8px 0 0 0;
}

.orders-table th:last-child {
  border-radius: 0 8px 0 0;
}

.orders-table tbody tr {
  background: #fff;
  border-bottom: 1px solid #e5e7eb;
  transition: all 0.2s;
}

.orders-table tbody tr:hover {
  background: #f9fafb;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.orders-table td {
  padding: 15px 12px;
  font-size: 13px;
  color: #1f2937;
}

/* Estados */
.loading-state {
  text-align: center;
  padding: 80px 20px;
  color: #6b7280;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #e5e7eb;
  border-top-color: #0d9488;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 20px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.empty-state {
  text-align: center;
  padding: 80px 20px;
  color: #9ca3af;
}

.empty-state-icon {
  font-size: 72px;
  margin-bottom: 20px;
  opacity: 0.6;
}

.empty-state h3 {
  color: #6b7280;
  margin-bottom: 12px;
  font-size: 20px;
}

.empty-state p {
  color: #9ca3af;
  font-size: 15px;
}

/* Responsive */
@media (max-width: 1024px) {
  .toolbar-container {
    flex-direction: column;
    align-items: stretch;
  }
  
  .toolbar-left, .toolbar-right {
    flex-direction: column;
    align-items: stretch;
  }
  
  .search-box {
    min-width: 100%;
  }
}

@media (max-width: 768px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .status-filters {
    flex-direction: column;
  }
  
  .status-filter-btn {
    justify-content: center;
  }
  
  .order-details {
    grid-template-columns: 1fr;
  }
  
  .order-header {
    flex-direction: column;
    gap: 10px;
  }
}
</style>

<script>
$(document).ready(function() {
  var allOrders = [];
  var filteredOrders = [];
  var currentFilter = 'all';
  var currentView = 'cards';
  var searchTerm = '';
  
  // Cargar todas las órdenes al inicio
  loadOrders('all');
  
  // Filtros de estado
  $('.status-filter-btn').click(function() {
    $('.status-filter-btn').removeClass('active');
    $(this).addClass('active');
    currentFilter = $(this).data('status');
    filterAndDisplay();
  });
  
  // Cambio de vista
  $('.view-btn').click(function() {
    $('.view-btn').removeClass('active');
    $(this).addClass('active');
    currentView = $(this).data('view');
    $('#orders-container').removeClass('cards-view table-view').addClass(currentView + '-view');
    displayOrders(filteredOrders);
  });
  
  // Búsqueda en vivo
  $('#live-search').on('input', function() {
    searchTerm = $(this).val().toLowerCase();
    filterAndDisplay();
  });
  
  // Exportar CSV
  $('#export-csv').click(function() {
    exportToCSV();
  });
  
  function loadOrders(status) {
    // Mostrar loading
    $('#orders-container').html('<div class="loading-state"><div class="loading-spinner"></div><p>Cargando órdenes...</p></div>');
    
    var urls = [];
    if (status === 'all') {
      urls = [
        '<?php echo site_url('member/imeirequest/get_orders_list'); ?>?status=Issued',
        '<?php echo site_url('member/imeirequest/get_orders_list'); ?>?status=Pending',
        '<?php echo site_url('member/imeirequest/get_orders_list'); ?>?status=Canceled'
      ];
    } else {
      urls = ['<?php echo site_url('member/imeirequest/get_orders_list'); ?>?status=' + status];
    }
    
    Promise.all(urls.map(url => 
      $.ajax({
        url: url,
        type: 'POST',
        data: { status: status === 'all' ? url.split('status=')[1] : status },
        dataType: 'json'
      })
    )).then(function(responses) {
      allOrders = [];
      responses.forEach(function(response) {
        if (response.success && response.data) {
          allOrders = allOrders.concat(response.data);
        }
      });
      
      // Ordenar por fecha más reciente
      allOrders.sort(function(a, b) {
        return new Date(b.CreatedDateTime) - new Date(a.CreatedDateTime);
      });
      
      updateStats(allOrders);
      filterAndDisplay();
    }).catch(function(error) {
      console.error('Error cargando órdenes:', error);
      $('#orders-container').html(
        '<div class="empty-state">' +
        '<div class="empty-state-icon">⚠️</div>' +
        '<h3>Error al Cargar</h3>' +
        '<p>No se pudieron cargar las órdenes. Por favor, intenta de nuevo.</p>' +
        '</div>'
      );
    });
  }
  
  function filterAndDisplay() {
    filteredOrders = allOrders.filter(function(order) {
      // Filtrar por estado
      var statusMatch = currentFilter === 'all' || order.Status === currentFilter;
      
      // Filtrar por búsqueda
      var searchMatch = true;
      if (searchTerm) {
        var searchFields = [
          order.IMEI || '',
          order.Title || '',
          order.Method || '',
          order.Code || '',
          order.Status || '',
          order.CreatedDateTime || ''
        ].join(' ').toLowerCase();
        searchMatch = searchFields.includes(searchTerm);
      }
      
      return statusMatch && searchMatch;
    });
    
    displayOrders(filteredOrders);
  }
  
  function updateStats(orders) {
    var total = orders.length;
    var completed = orders.filter(o => o.Status === 'Issued').length;
    var pending = orders.filter(o => o.Status === 'Pending').length;
    var rejected = orders.filter(o => o.Status === 'Canceled').length;
    
    $('#stat-total').text(total);
    $('#stat-completed').text(completed);
    $('#stat-pending').text(pending);
    $('#stat-rejected').text(rejected);
  }
  
  function displayOrders(orders) {
    if (orders.length === 0) {
      $('#orders-container').html(
        '<div class="empty-state">' +
        '<div class="empty-state-icon">📭</div>' +
        '<h3>No hay órdenes</h3>' +
        '<p>No se encontraron órdenes con los filtros seleccionados.</p>' +
        '</div>'
      );
      return;
    }
    
    if (currentView === 'cards') {
      displayCardsView(orders);
    } else {
      displayTableView(orders);
    }
  }
  
  function displayCardsView(orders) {
    var html = '<div class="orders-grid">';
    
    orders.forEach(function(order) {
      var statusInfo = getStatusInfo(order.Status);
      var codeContent = getCodeContent(order);
      
      html += '<div class="order-card">';
      html += '<div class="order-header">';
      html += '<div class="order-service">';
      html += '<span class="order-service-icon">📱</span>';
      html += '<span>' + (order.Title || order.Method || 'Servicio no especificado') + '</span>';
      html += '</div>';
      html += '<span class="status-badge ' + statusInfo.class + '">' + statusInfo.icon + ' ' + statusInfo.text + '</span>';
      html += '</div>';
      
      html += '<div class="order-details">';
      html += '<div class="order-detail-item">';
      html += '<div class="order-detail-label">IMEI</div>';
      html += '<div class="order-detail-value">' + (order.IMEI || 'N/A') + '</div>';
      html += '</div>';
      html += '<div class="order-detail-item">';
      html += '<div class="order-detail-label">Fecha</div>';
      html += '<div class="order-detail-value">' + order.CreatedDateTime + '</div>';
      html += '</div>';
      html += '</div>';
      
      html += codeContent;
      
      if (order.Note && order.Note.trim() !== '') {
        html += '<div class="order-note">';
        html += '<div class="order-note-label">📌 NOTA</div>';
        html += '<div class="order-note-text">' + order.Note + '</div>';
        html += '</div>';
      }
      
      html += '</div>';
    });
    
    html += '</div>';
    $('#orders-container').html(html);
  }
  
  function displayTableView(orders) {
    var html = '<table class="orders-table">';
    html += '<thead><tr>';
    html += '<th>Estado</th>';
    html += '<th>Servicio</th>';
    html += '<th>IMEI</th>';
    html += '<th>Código</th>';
    html += '<th>Fecha</th>';
    html += '</tr></thead><tbody>';
    
    orders.forEach(function(order) {
      var statusInfo = getStatusInfo(order.Status);
      
      html += '<tr>';
      html += '<td><span class="status-badge ' + statusInfo.class + '">' + statusInfo.icon + ' ' + statusInfo.text + '</span></td>';
      html += '<td>' + (order.Title || order.Method || 'N/A') + '</td>';
      html += '<td>' + (order.IMEI || 'N/A') + '</td>';
      html += '<td>' + (order.Code && order.Code.trim() !== '' ? order.Code.substring(0, 30) + '...' : '—') + '</td>';
      html += '<td>' + order.CreatedDateTime + '</td>';
      html += '</tr>';
    });
    
    html += '</tbody></table>';
    $('#orders-container').html(html);
  }
  
  function getStatusInfo(status) {
    switch(status) {
      case 'Issued':
        return { class: 'issued', text: 'Completado', icon: '✅' };
      case 'Pending':
        return { class: 'pending', text: 'Pendiente', icon: '⏰' };
      case 'Canceled':
        return { class: 'canceled', text: 'Rechazado', icon: '❌' };
      default:
        return { class: 'pending', text: status, icon: '⏳' };
    }
  }
  
  function getCodeContent(order) {
    var html = '';
    if (order.Code && order.Code.trim() !== '') {
      html = '<div class="order-code-box"><div class="order-detail-value">' + 
             order.Code.replace(/\n/g, '<br>') + '</div></div>';
    } else if (order.Status === 'Pending') {
      html = '<div class="order-code-box empty"><div class="order-detail-value">⏰ Pedido Pendiente</div></div>';
    } else if (order.Status === 'Canceled') {
      html = '<div class="order-code-box empty"><div class="order-detail-value">❌ ' + 
             (order.Comments || 'Orden rechazada') + '</div></div>';
    } else {
      html = '<div class="order-code-box empty"><div class="order-detail-value">Código pendiente</div></div>';
    }
    return html;
  }
  
  function exportToCSV() {
    if (filteredOrders.length === 0) {
      alert('No hay órdenes para exportar');
      return;
    }
    
    var csv = 'Estado,Servicio,IMEI,Código,Fecha,Nota\n';
    
    filteredOrders.forEach(function(order) {
      var row = [
        order.Status || '',
        (order.Title || order.Method || '').replace(/,/g, ';'),
        order.IMEI || '',
        (order.Code || '').replace(/,/g, ';').replace(/\n/g, ' '),
        order.CreatedDateTime || '',
        (order.Note || '').replace(/,/g, ';')
      ];
      csv += row.join(',') + '\n';
    });
    
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'historial_imei_' + new Date().toISOString().split('T')[0] + '.csv';
    link.click();
  }
});
</script>
