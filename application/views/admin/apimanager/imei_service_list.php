<style>
    .service-selection-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #0ea5e9 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 6px 25px rgba(139, 92, 246, 0.3);
    }
    
    .service-selection-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 900;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .selection-actions {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .btn-select-all, .btn-deselect-all {
        padding: 8px 16px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s;
    }
    
    .btn-deselect-all {
        background: linear-gradient(135deg, #64748b, #475569);
    }
    
    .btn-select-all:hover, .btn-deselect-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .selected-count {
        padding: 8px 16px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border-radius: 8px;
        font-weight: 700;
    }
    
    .table tbody tr:hover {
        background: rgba(139, 92, 246, 0.05);
    }
    
    .table tbody tr.selected-service {
        background: rgba(139, 92, 246, 0.15) !important;
        border-left: 3px solid #8b5cf6;
    }
    
    /* Estilos para el campo de búsqueda */
    #serviceSearchInput:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    /* Animación para filas que aparecen/desaparecen */
    .service-row {
        transition: opacity 0.2s ease;
    }
    
    .service-row[style*="display: none"] {
        opacity: 0;
    }
</style>

<div class="workplace">
    <div class="service-selection-header">
        <h1>📱 Seleccionar Servicios IMEI</h1>
        <p style="margin: 10px 0 0 0; font-size: 14px; opacity: 0.9;">Selecciona los servicios que deseas agregar antes de cargarlos</p>
    </div>
    
    <div class="row-fluid">
        <div class="span12">   
              <?php $this->load->view('admin/includes/message'); ?>
              <?php 
              // El segmento 4 contiene el ID de la API
              $api_id = $this->uri->segment(4);
              echo form_open('admin/apimanager/add_imei_service_list/'.$api_id, array('id' => 'imeiServiceForm', 'novalidate' => 'novalidate')); 
              ?>
              
              <!-- Barra de Búsqueda y Filtros -->
              <div class="search-filter-bar" style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                  <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                      <div style="flex: 1; min-width: 300px;">
                          <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569; font-size: 13px;">
                              🔍 Buscar por nombre de servicio:
                          </label>
                          <input 
                              type="text" 
                              id="serviceSearchInput" 
                              placeholder="Escribe el nombre del servicio para filtrar..." 
                              style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 8px; font-size: 14px; transition: all 0.3s;"
                              onkeyup="filterServices()"
                          />
                      </div>
                      <div style="display: flex; gap: 10px; align-items: flex-end;">
                          <button type="button" onclick="clearSearch()" style="padding: 12px 20px; background: linear-gradient(135deg, #64748b, #475569); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px;">
                              🗑️ Limpiar
                          </button>
                      </div>
                  </div>
                  <div style="margin-top: 15px; display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                      <span style="padding: 8px 16px; background: linear-gradient(135deg, #0ea5e9, #0284c7); color: white; border-radius: 8px; font-weight: 700; font-size: 13px;">
                          <span id="visibleServicesCount">0</span> servicios visibles
                      </span>
                      <span style="padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border-radius: 8px; font-weight: 700; font-size: 13px;">
                          <span id="selectedServicesCount">0</span> servicios seleccionados
                      </span>
                  </div>
              </div>
              
              <!-- Control de Precios Masivo -->
              <div class="price-control-bar" style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 2px solid #f59e0b;">
                  <h3 style="margin: 0 0 15px 0; color: #92400e; font-size: 18px; font-weight: 900;">💰 Ajuste Masivo de Precios</h3>
                  <div style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                      <div style="flex: 1; min-width: 200px;">
                          <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #92400e; font-size: 13px;">
                              Incremento Fijo ($):
                          </label>
                          <input 
                              type="number" 
                              id="priceIncrementFixed" 
                              placeholder="Ej: 1.00" 
                              step="0.01"
                              min="0"
                              style="width: 100%; padding: 10px; border: 2px solid #f59e0b; border-radius: 8px; font-size: 14px;"
                          />
                          <small style="color: #92400e; font-size: 11px;">Agrega esta cantidad a cada precio visible</small>
                      </div>
                      <div style="flex: 1; min-width: 200px;">
                          <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #92400e; font-size: 13px;">
                              Incremento Porcentual (%):
                          </label>
                          <input 
                              type="number" 
                              id="priceIncrementPercent" 
                              placeholder="Ej: 10" 
                              step="0.1"
                              min="0"
                              max="1000"
                              style="width: 100%; padding: 10px; border: 2px solid #f59e0b; border-radius: 8px; font-size: 14px;"
                          />
                          <small style="color: #92400e; font-size: 11px;">Aumenta el precio en este porcentaje</small>
                      </div>
                      <div style="display: flex; gap: 10px; flex-direction: column;">
                          <button type="button" onclick="applyPriceIncrement()" style="padding: 12px 24px; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px; white-space: nowrap;">
                              ➕ Aplicar Incremento
                          </button>
                          <button type="button" onclick="resetPrices()" style="padding: 12px 24px; background: linear-gradient(135deg, #64748b, #475569); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px; white-space: nowrap;">
                              🔄 Resetear Precios
                          </button>
                      </div>
                  </div>
                  <div style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;">
                      <button type="button" onclick="quickIncrement(0.5)" class="quick-price-btn" style="padding: 8px 16px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          +$0.50
                      </button>
                      <button type="button" onclick="quickIncrement(1)" class="quick-price-btn" style="padding: 8px 16px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          +$1.00
                      </button>
                      <button type="button" onclick="quickIncrement(2)" class="quick-price-btn" style="padding: 8px 16px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          +$2.00
                      </button>
                      <button type="button" onclick="quickIncrement(5)" class="quick-price-btn" style="padding: 8px 16px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          +$5.00
                      </button>
                      <button type="button" onclick="quickPercentIncrement(5)" class="quick-price-btn" style="padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          +5%
                      </button>
                      <button type="button" onclick="quickPercentIncrement(10)" class="quick-price-btn" style="padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          +10%
                      </button>
                      <button type="button" onclick="quickPercentIncrement(20)" class="quick-price-btn" style="padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          +20%
                      </button>
                  </div>
                  <div style="margin-top: 10px; padding: 10px; background: rgba(255,255,255,0.5); border-radius: 6px;">
                      <small style="color: #92400e; font-size: 11px;">
                          💡 <strong>Tip:</strong> Los ajustes se aplican solo a los servicios <strong>visibles</strong> (después de filtrar por búsqueda). 
                          Puedes editar precios individuales después si necesitas ajustar alguno específico.
                      </small>
                  </div>
              </div>
              
              <!-- Acciones de Selección -->
              <div class="selection-actions">
                  <button type="button" class="btn-select-all" onclick="selectAllVisibleServices()">✅ Seleccionar Todos Visibles</button>
                  <button type="button" class="btn-select-all" onclick="selectAllServices()">✅ Seleccionar Todos</button>
                  <button type="button" class="btn-deselect-all" onclick="deselectAllServices()">❌ Deseleccionar Todos</button>
              </div>
              
              <!-- Botón de Guardar - Movido arriba para mejor UX -->
              <div style="margin: 20px 0; text-align: center;">
                  <?php if(isset($service_list) && !empty($service_list)): ?>
                  <button 
                      type="submit" 
                      form="imeiServiceForm"
                      class="btn" 
                      style="padding: 14px 30px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border: none; border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 16px; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4); transition: all 0.3s;"
                      onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(139, 92, 246, 0.5)';"
                      onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(139, 92, 246, 0.4)';"
                  >
                      ➕ Agregar Servicios Seleccionados
                  </button>
                  <?php endif; ?>
              </div>
              
              <div class="head clearfix" style="display: none;">
                  <div class="isw-grid"></div>
                  <h1>IMEI Services List</h1>                      
              </div>
            <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="">
                    <thead>
                        <tr>                           
                          <th width="5%"><input type="checkbox" id="checkall" onclick="toggleAllServices(this)"/></th>             
                          <th width="24%">Service Name</th>
                          <th width="5%">Price</th>
                          <th width="5%">Info</th>
                          <th width="12%">Time</th>
                          <th width="12%">Network</th>
                          <th width="5%">Set Price</th>                                                                      
                        </tr>
                    </thead>
                    <tbody>
                      <?php
      foreach($service_list as $groups)
      {
        // Verificar que el GROUPTYPE sea IMEI (importante para filtrar correctamente)
        $group_type = isset($groups['GROUPTYPE']) ? $groups['GROUPTYPE'] : '';
        
        // SOLO procesar grupos de tipo IMEI
        if($group_type !== 'IMEI') {
          continue; // Saltar grupos que no son IMEI
        }
        
        // Verificar que existan servicios en este grupo
        if(!isset($groups['SERVICES']) || empty($groups['SERVICES'])) {
          continue;
        }
        
        foreach($groups['SERVICES'] as $service )
        {
              // VERIFICACIÓN ADICIONAL: Solo mostrar servicios de tipo IMEI
              $service_type = isset($service['SERVICETYPE']) ? $service['SERVICETYPE'] : '';
              if($service_type !== 'IMEI') {
                continue; // Saltar servicios que no son IMEI
              }
              
              $service_id = $service['SERVICEID'];
          ?>
                          <tr class="service-row" data-service-id="<?php echo $service_id; ?>" data-service-name="<?php echo htmlspecialchars(strtolower($service['SERVICENAME']), ENT_QUOTES, 'UTF-8'); ?>" data-original-price="<?php echo floatval($service['CREDIT']); ?>">
                            <td><input type="checkbox" value="<?php echo $service_id; ?>" name="chk[]" class="span12 service-checkbox" onchange="updateSelectedCount()" /></td>		
                            <td><input type="text" name="ServiceName[<?php echo $service_id; ?>]" value="<?php echo htmlspecialchars($service['SERVICENAME'], ENT_QUOTES, 'UTF-8'); ?>" class="span12" /></td>
                            <td><input type="text" value="<?php echo $service['CREDIT']; ?>" class="span12" disabled="disabled" style="font-weight: 700; color: #059669;" /></td>
                            <td><?php echo $service['INFO']; ?></td>
                            <td><input type="text" name="Time[<?php echo $service_id; ?>]" value="<?php echo $service['TIME']; ?>" class="span12" /></td>
                            <td>
                            <select name="NetworkID[<?php echo $service_id; ?>]"  class="span12" >
                            <?php foreach($networks as $val): ?>
                              <option value="<?php echo $val['ID']; ?>" ><?php echo $val['Title']; ?></option>
                            <?php endforeach; ?>	
                            </select>
                            </td>
                            <td><input type="number" name="Price[<?php echo $service_id; ?>]" value="<?php echo $service['CREDIT']; ?>" class="span12 price-input" step="0.01" min="0" data-service-id="<?php echo $service_id; ?>" style="font-weight: 700; color: #8b5cf6;" /></td>                                   
                        </tr>
          <?php
          // Guardar GROUPNAME para agrupar servicios en el frontend
          $group_name = isset($groups['GROUPNAME']) ? $groups['GROUPNAME'] : (isset($groups['GROUPTYPE']) ? 'Grupo General' : 'Sin Grupo');
          echo form_hidden("GroupName[$service_id]", htmlspecialchars($group_name, ENT_QUOTES, 'UTF-8'));
          
          echo form_hidden("Network[$service_id]", $service['Requires.Network']);
          echo form_hidden("Mobile[$service_id]", $service['Requires.Mobile']);
          echo form_hidden("Provider[$service_id]", $service['Requires.Provider']);
          echo form_hidden("PIN[$service_id]", $service['Requires.PIN']);
          echo form_hidden("KBH[$service_id]", $service['Requires.KBH']);
          echo form_hidden("MEP[$service_id]", $service['Requires.MEP']);
          echo form_hidden("PRD[$service_id]", $service['Requires.PRD']);
          echo form_hidden("Type[$service_id]", $service['Requires.Type']);
          echo form_hidden("Locks[$service_id]", $service['Requires.Locks']);
          echo form_hidden("Reference[$service_id]", $service['Requires.Reference']);
        }
      }
      ?>
                    </tbody>                                
                </table>
            </div>
            <?php echo form_close(); ?>
            
<script type="text/javascript">
// Función principal de filtrado por nombre
function filterServices() {
    var searchTerm = document.getElementById('serviceSearchInput').value.toLowerCase().trim();
    var rows = document.querySelectorAll('.service-row');
    var visibleCount = 0;
    
    rows.forEach(function(row) {
        var serviceName = row.getAttribute('data-service-name') || '';
        
        if(searchTerm === '' || serviceName.indexOf(searchTerm) !== -1) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Actualizar contador de servicios visibles
    document.getElementById('visibleServicesCount').textContent = visibleCount;
    
    // Actualizar contador de seleccionados
    updateSelectedCount();
    
    // Actualizar checkbox "seleccionar todos" basado en los visibles
    updateSelectAllCheckbox();
}

// Limpiar búsqueda
function clearSearch() {
    document.getElementById('serviceSearchInput').value = '';
    filterServices();
}

// Seleccionar todos los servicios visibles
function selectAllVisibleServices() {
    var visibleCheckboxes = document.querySelectorAll('.service-row:not([style*="display: none"]) .service-checkbox');
    visibleCheckboxes.forEach(function(cb) {
        cb.checked = true;
        updateRowSelection(cb);
    });
    updateSelectedCount();
    updateSelectAllCheckbox();
}

// Seleccionar todos los servicios (incluyendo ocultos)
function selectAllServices() {
    document.querySelectorAll('.service-checkbox').forEach(function(cb) {
        cb.checked = true;
        updateRowSelection(cb);
    });
    document.getElementById('checkall').checked = true;
    updateSelectedCount();
}

function toggleAllServices(checkbox) {
    var checked = checkbox.checked;
    // Solo afectar servicios visibles si hay un filtro activo
    var searchTerm = document.getElementById('serviceSearchInput').value.trim();
    var checkboxes = searchTerm === '' 
        ? document.querySelectorAll('.service-checkbox')
        : document.querySelectorAll('.service-row:not([style*="display: none"]) .service-checkbox');
    
    checkboxes.forEach(function(cb) {
        cb.checked = checked;
        updateRowSelection(cb);
    });
    updateSelectedCount();
}

function deselectAllServices() {
    document.querySelectorAll('.service-checkbox').forEach(function(cb) {
        cb.checked = false;
        updateRowSelection(cb);
    });
    document.getElementById('checkall').checked = false;
    updateSelectedCount();
}

function updateRowSelection(checkbox) {
    var row = checkbox.closest('tr');
    if(checkbox.checked) {
        row.classList.add('selected-service');
    } else {
        row.classList.remove('selected-service');
    }
}

function updateSelectedCount() {
    var count = document.querySelectorAll('.service-checkbox:checked').length;
    document.getElementById('selectedServicesCount').textContent = count;
    
    // Actualizar filas seleccionadas visualmente
    document.querySelectorAll('.service-checkbox').forEach(function(cb) {
        updateRowSelection(cb);
    });
}

function updateSelectAllCheckbox() {
    var visibleCheckboxes = document.querySelectorAll('.service-row:not([style*="display: none"]) .service-checkbox');
    var visibleChecked = document.querySelectorAll('.service-row:not([style*="display: none"]) .service-checkbox:checked');
    
    if(visibleCheckboxes.length === 0) {
        document.getElementById('checkall').checked = false;
        return;
    }
    
    document.getElementById('checkall').checked = visibleCheckboxes.length === visibleChecked.length;
}

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', function() {
    // Contar servicios totales al inicio
    var totalServices = document.querySelectorAll('.service-row').length;
    document.getElementById('visibleServicesCount').textContent = totalServices;
    
    updateSelectedCount();
    
    // Agregar listeners a todos los checkboxes
    document.querySelectorAll('.service-checkbox').forEach(function(cb) {
        cb.addEventListener('change', function() {
            updateSelectedCount();
            updateSelectAllCheckbox();
        });
    });
    
    // Agregar listener al campo de búsqueda para Enter
    document.getElementById('serviceSearchInput').addEventListener('keypress', function(e) {
        if(e.key === 'Enter') {
            e.preventDefault();
            filterServices();
        }
    });
    
    // Agregar listener para cambios en tiempo real
    document.getElementById('serviceSearchInput').addEventListener('input', function() {
        filterServices();
    });
});

// Funciones para ajuste masivo de precios
function applyPriceIncrement() {
    var fixedIncrement = parseFloat(document.getElementById('priceIncrementFixed').value) || 0;
    var percentIncrement = parseFloat(document.getElementById('priceIncrementPercent').value) || 0;
    
    if (fixedIncrement === 0 && percentIncrement === 0) {
        alert('⚠️ Por favor ingresa un incremento fijo o porcentual');
        return;
    }
    
    var visibleRows = document.querySelectorAll('.service-row:not([style*="display: none"])');
    var updated = 0;
    
    visibleRows.forEach(function(row) {
        var priceInput = row.querySelector('.price-input');
        if (!priceInput) return;
        
        var currentPrice = parseFloat(priceInput.value) || 0;
        var originalPrice = parseFloat(row.getAttribute('data-original-price')) || currentPrice;
        
        // Si el precio no ha sido modificado, usar el original
        if (currentPrice === originalPrice || Math.abs(currentPrice - originalPrice) < 0.01) {
            currentPrice = originalPrice;
        }
        
        var newPrice = currentPrice;
        
        // Aplicar incremento fijo
        if (fixedIncrement > 0) {
            newPrice += fixedIncrement;
        }
        
        // Aplicar incremento porcentual
        if (percentIncrement > 0) {
            newPrice = newPrice * (1 + percentIncrement / 100);
        }
        
        // Redondear a 2 decimales
        newPrice = Math.round(newPrice * 100) / 100;
        
        priceInput.value = newPrice.toFixed(2);
        updated++;
        
        // Efecto visual
        priceInput.style.background = '#dbeafe';
        setTimeout(function() {
            priceInput.style.background = '';
        }, 500);
    });
    
    if (updated > 0) {
        showPriceNotification('✅ Se actualizaron ' + updated + ' precio(s)', 'success');
    } else {
        showPriceNotification('⚠️ No hay servicios visibles para actualizar', 'warning');
    }
}

function quickIncrement(amount) {
    document.getElementById('priceIncrementFixed').value = amount;
    document.getElementById('priceIncrementPercent').value = '';
    applyPriceIncrement();
}

function quickPercentIncrement(percent) {
    document.getElementById('priceIncrementFixed').value = '';
    document.getElementById('priceIncrementPercent').value = percent;
    applyPriceIncrement();
}

function resetPrices() {
    if (!confirm('⚠️ ¿Resetear todos los precios visibles al precio original de la API?')) {
        return;
    }
    
    var visibleRows = document.querySelectorAll('.service-row:not([style*="display: none"])');
    var reset = 0;
    
    visibleRows.forEach(function(row) {
        var priceInput = row.querySelector('.price-input');
        if (!priceInput) return;
        
        var originalPrice = parseFloat(row.getAttribute('data-original-price')) || 0;
        priceInput.value = originalPrice.toFixed(2);
        reset++;
        
        // Efecto visual
        priceInput.style.background = '#fee2e2';
        setTimeout(function() {
            priceInput.style.background = '';
        }, 500);
    });
    
    if (reset > 0) {
        showPriceNotification('🔄 Se resetearon ' + reset + ' precio(s) al precio original', 'info');
    }
}

function showPriceNotification(message, type) {
    var notification = document.createElement('div');
    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; padding: 15px 20px; background: ' + 
        (type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 
         type === 'warning' ? 'linear-gradient(135deg, #f59e0b, #d97706)' : 
         'linear-gradient(135deg, #3b82f6, #2563eb)') + 
        '; color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 10000; font-weight: 700; animation: slideIn 0.3s ease;';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(function() {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(function() {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Agregar estilos CSS para animaciones
var style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
    .price-input:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
`;
document.head.appendChild(style);

// Prevenir error de validación HTML5 en campos ocultos
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('imeiServiceForm');
    if(form) {
        form.addEventListener('submit', function(e) {
            // IMPORTANTE: Primero verificar que haya checkboxes seleccionados ANTES de deshabilitar nada
            var selectedCheckboxes = form.querySelectorAll('input[name="chk[]"]:checked');
            
            // Si no hay checkboxes seleccionados, prevenir envío
            if(selectedCheckboxes.length === 0) {
                e.preventDefault();
                alert('⚠️ Por favor selecciona al menos un servicio para agregar.');
                return false;
            }
            
            console.log('✅ Servicios seleccionados:', selectedCheckboxes.length);
            console.log('🔍 Total de filas en la tabla:', form.querySelectorAll('tr.service-row').length);
            
            // PASO 1: Obtener los IDs de los servicios seleccionados
            var selectedIds = [];
            selectedCheckboxes.forEach(function(checkbox) {
                selectedIds.push(checkbox.value);
            });
            console.log('📋 IDs seleccionados:', selectedIds);
            
            // PASO 2: ELIMINAR COMPLETAMENTE el atributo 'name' de TODOS los campos NO seleccionados
            // Esto es más agresivo que deshabilitarlos - asegura que no se envíen
            var allRows = form.querySelectorAll('tr.service-row');
            var totalFieldsRemoved = 0;
            
            allRows.forEach(function(row) {
                var checkbox = row.querySelector('input[name="chk[]"]');
                if(checkbox) {
                    var isSelected = selectedIds.indexOf(checkbox.value) !== -1;
                    
                    if(!isSelected) {
                        // NO está seleccionado: ELIMINAR name de TODOS los campos
                        var allInputs = row.querySelectorAll('input, select, textarea');
                        allInputs.forEach(function(input) {
                            if(input.type !== 'checkbox' && input.name && input.name !== 'chk[]') {
                                // Guardar el name original en un atributo data por si acaso
                                input.setAttribute('data-original-name', input.name);
                                input.name = ''; // Eliminar el name para que NO se envíe
                                input.disabled = true;
                                totalFieldsRemoved++;
                            }
                        });
                    } else {
                        // ESTÁ seleccionado: asegurar que todos los campos estén habilitados y tengan name
                        checkbox.disabled = false;
                        checkbox.checked = true;
                        var row = checkbox.closest('tr');
                        if(row) {
                            row.style.display = '';
                            var allInputs = row.querySelectorAll('input, select, textarea');
                            allInputs.forEach(function(input) {
                                input.disabled = false;
                                // Restaurar el name si fue eliminado antes
                                if(input.type !== 'checkbox' && !input.name && input.hasAttribute('data-original-name')) {
                                    input.name = input.getAttribute('data-original-name');
                                }
                            });
                        }
                    }
                }
            });
            
            // PASO 3: Eliminar name de filas ocultas
            var hiddenRows = form.querySelectorAll('tr.service-row[style*="display: none"]');
            hiddenRows.forEach(function(row) {
                var inputs = row.querySelectorAll('input:not([type="checkbox"]), select, textarea');
                inputs.forEach(function(input) {
                    if(input.name && input.name !== 'chk[]') {
                        input.setAttribute('data-original-name', input.name);
                        input.name = '';
                        input.disabled = true;
                        totalFieldsRemoved++;
                    }
                });
            });
            
            console.log('🗑️ Campos eliminados del envío:', totalFieldsRemoved);
            
            // Verificación final
            var finalCheck = form.querySelectorAll('input[name="chk[]"]:checked:not([disabled])');
            if(finalCheck.length === 0) {
                e.preventDefault();
                alert('⚠️ Error: Los checkboxes seleccionados no están disponibles.');
                return false;
            }
            
            // Contar cuántos campos con name quedan (solo para debug)
            var remainingFields = form.querySelectorAll('input[name]:not([name="chk[]"]), select[name], textarea[name]').length;
            console.log('✅ Campos que se enviarán:', remainingFields);
            console.log('✅ Enviando formulario con', finalCheck.length, 'servicios seleccionados');
            
            // El formulario se enviará normalmente
        });
    }
});
</script>         
        </div>                                

    </div>            

    <div class="dr"><span></span></div>            

</div>
