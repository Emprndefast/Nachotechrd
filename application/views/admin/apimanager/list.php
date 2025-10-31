<style>
    /* Estilos mejorados para Admin Panel */
    .admin-header-enhanced {
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #0ea5e9 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 6px 25px rgba(139, 92, 246, 0.3);
    }
    
    .admin-header-enhanced h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 900;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .admin-header-enhanced .subtitle {
        margin: 5px 0 0 0;
        font-size: 14px;
        opacity: 0.9;
    }
    
    .btn-enhanced {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary-enhanced {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.4);
    }
    
    .btn-primary-enhanced:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-enabled {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    
    .status-disabled {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    
    .api-type-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    
    .type-imei {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: white;
    }
    
    .type-server {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
    }
    
    .type-file {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .filter-bar {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-select {
        padding: 10px 15px;
        border-radius: 8px;
        border: 2px solid #cbd5e1;
        background: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    .config-btn {
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
    
    .config-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .config-btn.load {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
    }
    
    .table-enhanced tbody tr:hover {
        background: #f8fafc;
    }
    
    /* Estilos para checkboxes y selección múltiple */
    .row-checkbox, #selectAll {
        width: 18px;
        height: 18px;
        cursor: pointer;
        margin: 0;
        accent-color: #8b5cf6;
    }
    
    .row-checkbox:checked {
        accent-color: #8b5cf6;
    }
    
    /* Estilos para iconos de operaciones */
    .isb-edit, .isb-delete, .isb-cloud {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin: 0 3px;
        cursor: pointer;
        opacity: 0.7;
        transition: all 0.3s;
    }
    
    .isb-edit:hover, .isb-delete:hover, .isb-cloud:hover {
        opacity: 1;
        transform: scale(1.2);
    }
    
    /* Filas seleccionadas */
    tr.selected {
        background: rgba(139, 92, 246, 0.1) !important;
        border-left: 3px solid #8b5cf6;
    }
    
    /* Mejoras visuales para temas */
    .table thead th {
        position: relative;
    }
    
    .table tbody td {
        vertical-align: middle;
    }
    
    /* Animación para badges */
    .status-badge, .api-type-badge {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="workplace">
    <div class="admin-header-enhanced">
        <div>
            <h1>🚀 API Manager</h1>
            <p class="subtitle">Gestiona tus APIs y sus servicios</p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="<?php echo site_url('admin/apimanager/diagnostico_frontend'); ?>" class="btn-enhanced btn-primary-enhanced" style="background: linear-gradient(135deg, #f59e0b, #d97706); border-color: rgba(255, 255, 255, 0.5);">
                🔍 Diagnóstico Frontend
            </a>
            <a href="<?php echo site_url('admin/apimanager/add'); ?>" class="btn-enhanced btn-primary-enhanced">
                ➕ Agregar API
            </a>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">   
      <?php $this->load->view('admin/includes/message'); ?>
        <div class="head clearfix" style="display: none;">
                  <div class="isw-grid"></div>
                  <h1>API Manager</h1>    
              </div>
            <!-- Filtros y Configuración -->
            <div class="filter-bar">
                <select id="filterStatus" class="filter-select">
                    <option value="">Todos los Estados</option>
                    <option value="Enabled">✅ Activas</option>
                    <option value="Disabled">❌ Desactivadas</option>
                </select>
                
                <select id="filterApiType" class="filter-select">
                    <option value="">Todos los Tipos</option>
                    <option value="Imei">📱 IMEI</option>
                    <option value="Server">💻 Server</option>
                    <option value="File">📄 File</option>
                </select>
                
                <input type="text" id="searchInput" class="filter-select" placeholder="🔍 Buscar por nombre, host..." style="flex: 1; min-width: 200px;">
                
                <button class="config-btn" onclick="saveTableConfig()" title="Guardar configuración actual">
                    💾 Guardar Config
                </button>
                
                <button class="config-btn load" onclick="loadTableConfig()" title="Cargar configuración guardada">
                    📥 Cargar Config
                </button>
                
                <!-- Operaciones Masivas -->
                <span id="selectedCount" style="padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border-radius: 8px; font-weight: 700; display: none;">
                    <span id="countNumber">0</span> seleccionados
                </span>
                
                <button class="config-btn" onclick="bulkDelete()" id="bulkDeleteBtn" style="background: linear-gradient(135deg, #ef4444, #dc2626); display: none;" title="Eliminar seleccionados">
                    🗑️ Eliminar Seleccionados
                </button>
                
                <button class="config-btn" onclick="bulkEdit()" id="bulkEditBtn" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); display: none;" title="Editar seleccionados">
                    ✏️ Editar Seleccionados
                </button>
            </div>

            <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="TableDeferLoading">
                    <thead>
                        <tr>
                            <th width="3%"><input type="checkbox" id="selectAll" title="Seleccionar todos"></th>                                        
                            <th width="5%">ID</th>
                            <th width="13%">Title</th>
                            <th width="24%">Host</th>
                            <th width="12%">Username</th>
                            <th width="8%">Api Type</th>
                            <th width="10%">Status</th>
                            <th width="14%">Updated Date Time</th>
                            <th width="11%">Options</th>                                
                        </tr>
                    </thead>                                
                </table>
            </div>
            
        </div>                                

    </div>            

    <div class="dr"><span></span></div>            
    <div class="row-fluid">
        <div class="span3">
          <div class="head clearfix">
              <div class="isw-brush"></div>
              <h1>Options Icons</h1>
          </div>
          <div class="block">
            <ul class="the-icons clearfix">
              <li><i class="isb-cloud"></i> Services List</li>
              <li><i class="isb-edit"></i> Edit Record</li>
              <li><i class="isb-delete"></i> Delete Record</li>
            </ul>
          </div>
        </div>
    </div> 
</div>
<script type="text/javascript" charset="utf-8">

// Configuración persistente
var tableConfig = {
    pageLength: localStorage.getItem('admin_apimanager_pageLength') || 10,
    orderColumn: localStorage.getItem('admin_apimanager_orderColumn') || 0,
    orderDirection: localStorage.getItem('admin_apimanager_orderDirection') || 'asc',
    filterStatus: localStorage.getItem('admin_apimanager_filterStatus') || '',
    filterApiType: localStorage.getItem('admin_apimanager_filterApiType') || ''
};

// Aplicar filtros guardados
if(tableConfig.filterStatus) {
    document.getElementById('filterStatus').value = tableConfig.filterStatus;
}
if(tableConfig.filterApiType) {
    document.getElementById('filterApiType').value = tableConfig.filterApiType;
}

var table;

function saveTableConfig() {
    if(!table) return;
    
    var config = {
        pageLength: table.page.len(),
        orderColumn: table.order()[0][0],
        orderDirection: table.order()[0][1],
        filterStatus: document.getElementById('filterStatus').value,
        filterApiType: document.getElementById('filterApiType').value
    };
    
    localStorage.setItem('admin_apimanager_pageLength', config.pageLength);
    localStorage.setItem('admin_apimanager_orderColumn', config.orderColumn);
    localStorage.setItem('admin_apimanager_orderDirection', config.orderDirection);
    localStorage.setItem('admin_apimanager_filterStatus', config.filterStatus);
    localStorage.setItem('admin_apimanager_filterApiType', config.filterApiType);
    
    alert('✅ Configuración guardada correctamente');
}

function loadTableConfig() {
    if(!table) return;
    
    var savedPageLength = localStorage.getItem('admin_apimanager_pageLength');
    var savedOrderColumn = localStorage.getItem('admin_apimanager_orderColumn');
    var savedOrderDirection = localStorage.getItem('admin_apimanager_orderDirection');
    
    if(savedPageLength) {
        table.page.len(parseInt(savedPageLength)).draw();
    }
    if(savedOrderColumn && savedOrderDirection) {
        table.order([parseInt(savedOrderColumn), savedOrderDirection]).draw();
    }
    
    alert('✅ Configuración cargada');
}

$(document).ready(function()
  {
	    table = $('#TableDeferLoading').dataTable
		({
		      'bProcessing'    : true,
		      'bServerSide'    : true,
		      'bAutoWidth'     : false,
		      'sPaginationType': 'full_numbers',
		      'sAjaxSource'    : '<?php echo site_url('admin/apimanager/listener'); ?>',
		      'aoColumnDefs': [ 
		          { "bSortable": false, "aTargets": [ 0, 8 ] }, // Checkbox y Options no ordenables
		          { "bSearchable": false, "aTargets": [ 0, 8 ] } // Checkbox y Options no buscables
		      ], 
		      'sDom'		   : 'T<"clear">lfrtip', //datatable export buttons
		      'iDisplayLength': parseInt(tableConfig.pageLength),
		      'aaSorting': [[parseInt(tableConfig.orderColumn), tableConfig.orderDirection]],
		      'oTableTools'	  : 
		      { //datatable export buttons
		      	"sSwfPath": "<?php echo $this->config->item('assets_url');?>js/plugins/dataTables/media/swf/copy_csv_xls_pdf.swf",
		      	"sRowSelect": "multi"		      	
		      }, 
		      'aoColumns'      : 
			      [
			        { 'bSearchable': false, 'bVisible': true }, // Checkbox
			        { 'bSearchable': false, 'bVisible': true }, // ID
			        null, // Title
			        null, // Host
			        null, // Username
			        null, // ApiType
			        null, // Status
			        null, // UpdatedDateTime
			        null  // Options
			      ],
			      'fnRowCallback': function(nRow, aData, iDisplayIndex) {
			          // Estructura de aData (sin checkbox en el array):
			          // [ID, Title, Host, Username, ApiType, Status, UpdatedDateTime, CreatedDateTime, delete/options]
			          // La columna 'delete' viene del add_column en el modelo
			          // Ahora agregamos checkbox como primera celda visual, pero aData sigue igual
			          
			          // Agregar checkbox para selección múltiple en la primera celda
			          var id = aData[0]; // ID viene en la posición 0
			          var checkbox = '<input type="checkbox" class="row-checkbox" data-id="' + id + '" title="Seleccionar fila" />';
			          $('td:eq(0)', nRow).html(checkbox);
			          
			          // Agregar clase para hover
			          $(nRow).addClass('selectable-row');
			          
			          // El ID va en la segunda celda ahora
			          $('td:eq(1)', nRow).html(id);
			          
			          // Agregar badges de Status (posición 6: Status)
			          var status = aData[5] || '';
			          var statusHtml = '';
			          if(status.toLowerCase() === 'enabled') {
			              statusHtml = '<span class="status-badge status-enabled">✅ Activa</span>';
			          } else {
			              statusHtml = '<span class="status-badge status-disabled">❌ Desactivada</span>';
			          }
			          $('td:eq(6)', nRow).html(statusHtml);
			          
			          // Agregar badge de ApiType (posición 4: ApiType)
			          var apiType = aData[4] || '';
			          var typeHtml = '';
			          if(apiType.toLowerCase() === 'imei') {
			              typeHtml = '<span class="api-type-badge type-imei">📱 ' + apiType + '</span>';
			          } else if(apiType.toLowerCase() === 'server') {
			              typeHtml = '<span class="api-type-badge type-server">💻 ' + apiType + '</span>';
			          } else if(apiType.toLowerCase() === 'file') {
			              typeHtml = '<span class="api-type-badge type-file">📄 ' + apiType + '</span>';
			          } else {
			              typeHtml = apiType;
			          }
			          $('td:eq(5)', nRow).html(typeHtml);
			          
			          // Asegurar que los iconos de la última columna se muestren (posición 8: delete/options)
			          var optionsHtml = aData[8] || '';
			          var apiId = aData[0];
			          
			          // Si no tiene iconos o está vacío, crearlos manualmente
			          if(!optionsHtml || optionsHtml.indexOf('isb-') === -1) {
			              optionsHtml = '<a href="<?php echo site_url("admin/apimanager/edit"); ?>/' + apiId + '" title="Edit this record" class="tip"><span class="isb-edit"></span></a> ';
			              optionsHtml += '<a href="<?php echo site_url("admin/apimanager/service_list"); ?>/' + apiId + '" title="Services List" class="tip"><span class="isb-cloud"></span></a> ';
			              optionsHtml += '<a href="<?php echo site_url("admin/apimanager/delete"); ?>/' + apiId + '" title="Delete this record" class="tip" onclick="return confirm(\'Are sure want to delete this record?\');"><span class="isb-delete"></span></a>';
			          }
			          $('td:eq(8)', nRow).html(optionsHtml);
			          
			          return nRow;
			      },
			      'fnServerData': function(sSource, aoData, fnCallback)
			      {
			      	// Agregar filtros personalizados
			      	aoData.push({ 'name': 'custom_filter_status', 'value': document.getElementById('filterStatus').value });
			      	aoData.push({ 'name': 'custom_filter_api_type', 'value': document.getElementById('filterApiType').value });
			      	aoData.push({ 'name': 'custom_search', 'value': document.getElementById('searchInput').value });
			      	
			      	<?php				if($this->config->item('csrf_protection') === TRUE){	?>
			      	aoData.push({ name : '<?php echo $this->config->item('csrf_token_name'); ?>', value :  $.cookie('<?php echo $this->config->item('csrf_cookie_name'); ?>') }); 
<?php				}	?>
			        $.ajax
			        ({
				          'dataType': 'json',
				          'type'    : 'POST',
				          'url'     : sSource,
				          'data'    : aoData,
				          'success' : fnCallback
			        });
			      }
		});
		
		// Aplicar filtros cuando cambien
		$('#filterStatus, #filterApiType, #searchInput').on('change keyup', function() {
		    table.draw();
		    // Auto-guardar configuración después de un delay
		    clearTimeout(window.saveConfigTimeout);
		    window.saveConfigTimeout = setTimeout(saveTableConfig, 2000);
		});
		
		// Selección múltiple: Seleccionar todos
		$('#selectAll').on('change', function() {
		    var checked = $(this).prop('checked');
		    $('.row-checkbox').prop('checked', checked);
		    
		    // Agregar/quitar clase selected
		    if(checked) {
		        $('.row-checkbox').closest('tr').addClass('selected');
		    } else {
		        $('.row-checkbox').closest('tr').removeClass('selected');
		    }
		    
		    updateSelectedCount();
		});
		
		// Selección múltiple: Checkboxes individuales
		$(document).on('change', '.row-checkbox', function() {
		    updateSelectedCount();
		    // Si todos están seleccionados, marcar el "select all"
		    var total = $('.row-checkbox').length;
		    var checked = $('.row-checkbox:checked').length;
		    $('#selectAll').prop('checked', total > 0 && total === checked);
		});
		
		// Selección con teclado (Shift+Click, Ctrl+Click)
		var lastChecked = null;
		$(document).on('click', '.row-checkbox', function(e) {
		    var checkbox = $(this);
		    
		    if(e.shiftKey && lastChecked && lastChecked !== this) {
		        // Seleccionar rango con Shift
		        var checkboxes = $('.row-checkbox');
		        var start = checkboxes.index($(lastChecked));
		        var end = checkboxes.index(checkbox);
		        
		        // Determinar inicio y fin del rango
		        var startIdx = Math.min(start, end);
		        var endIdx = Math.max(start, end);
		        
		        // Seleccionar todos en el rango
		        checkboxes.slice(startIdx, endIdx + 1).prop('checked', true);
		        checkboxes.slice(startIdx, endIdx + 1).closest('tr').addClass('selected');
		    } else {
		        // Toggle individual
		        if(checkbox.prop('checked')) {
		            checkbox.closest('tr').addClass('selected');
		        } else {
		            checkbox.closest('tr').removeClass('selected');
		        }
		    }
		    
		    lastChecked = this;
		    updateSelectedCount();
		});
		
		// Agregar clase selected cuando se marca checkbox
		$(document).on('change', '.row-checkbox', function() {
		    if($(this).prop('checked')) {
		        $(this).closest('tr').addClass('selected');
		    } else {
		        $(this).closest('tr').removeClass('selected');
		    }
		});
		
		// Actualizar contador de seleccionados
		function updateSelectedCount() {
		    var count = $('.row-checkbox:checked').length;
		    $('#countNumber').text(count);
		    
		    if(count > 0) {
		        $('#selectedCount').show();
		        $('#bulkDeleteBtn').show();
		        $('#bulkEditBtn').show();
		    } else {
		        $('#selectedCount').hide();
		        $('#bulkDeleteBtn').hide();
		        $('#bulkEditBtn').hide();
		    }
		}
		
		// Operaciones masivas
		function bulkDelete() {
		    var selected = [];
		    $('.row-checkbox:checked').each(function() {
		        selected.push($(this).data('id'));
		    });
		    
		    if(selected.length === 0) {
		        alert('⚠️ Por favor selecciona al menos un elemento');
		        return;
		    }
		    
		    if(!confirm('⚠️ ¿Estás seguro de eliminar ' + selected.length + ' API(s)?\n\nEsto eliminará permanentemente los elementos seleccionados.')) {
		        return;
		    }
		    
		    // Mostrar loading
		    $('#bulkDeleteBtn').prop('disabled', true).text('⏳ Eliminando...');
		    
		    // Llamada AJAX para eliminar múltiples
		    $.ajax({
		        url: '<?php echo site_url("admin/apimanager/bulk_delete"); ?>',
		        type: 'POST',
		        data: {
		            ids: selected
		        },
		        dataType: 'json',
		        success: function(response) {
		            if(response.success) {
		                alert('✅ ' + response.message);
		                // Recargar tabla
		                table.draw();
		                // Limpiar selección
		                $('.row-checkbox').prop('checked', false);
		                $('#selectAll').prop('checked', false);
		                updateSelectedCount();
		            } else {
		                alert('❌ Error: ' + (response.error || 'No se pudo eliminar'));
		            }
		        },
		        error: function(xhr, status, error) {
		            alert('❌ Error al eliminar: ' + error);
		        },
		        complete: function() {
		            $('#bulkDeleteBtn').prop('disabled', false).text('🗑️ Eliminar Seleccionados');
		        }
		    });
		}
		
		function bulkEdit() {
		    var selected = [];
		    $('.row-checkbox:checked').each(function() {
		        selected.push($(this).data('id'));
		    });
		    
		    if(selected.length === 0) {
		        alert('⚠️ Por favor selecciona al menos un elemento');
		        return;
		    }
		    
		    // Redirigir con los IDs seleccionados
		    var form = $('<form>', {
		        method: 'POST',
		        action: '<?php echo site_url("admin/apimanager/bulk_edit"); ?>'
		    });
		    
		    selected.forEach(function(id) {
		        form.append($('<input>', {
		            type: 'hidden',
		            name: 'ids[]',
		            value: id
		        }));
		    });
		    
		    // Agregar token CSRF si existe
		    <?php if($this->config->item('csrf_protection') === TRUE){ ?>
		    form.append($('<input>', {
		        type: 'hidden',
		        name: '<?php echo $this->config->item('csrf_token_name'); ?>',
		        value: $.cookie('<?php echo $this->config->item('csrf_cookie_name'); ?>')
		    }));
		    <?php } ?>
		    
		    $('body').append(form);
		    form.submit();
		}
  });		
			
</script>            