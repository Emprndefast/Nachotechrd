<style>
    /* Estilos mejorados para Admin Panel - Methods */
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
    
    .config-btn {
        padding: 8px 16px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
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
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .row-checkbox, #selectAll {
        width: 18px;
        height: 18px;
        cursor: pointer;
        margin: 0;
        accent-color: #8b5cf6;
    }
    
    tr.selected {
        background: rgba(139, 92, 246, 0.1) !important;
        border-left: 3px solid #8b5cf6;
    }
    
    .isb-edit, .isb-delete, .isb-sync {
        display: inline-block;
        width: 24px;
        height: 24px;
        background-size: 20px 20px !important;
        margin: 0 5px;
        opacity: 0.8;
        transition: all 0.3s;
    }
    
    .isb-edit:hover, .isb-delete:hover, .isb-sync:hover {
        opacity: 1;
        transform: scale(1.15);
    }
    
    /* Sistema de Notificaciones Modernas */
    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 320px;
        max-width: 450px;
        padding: 18px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 15px;
        z-index: 10000;
        opacity: 0;
        transform: translateX(400px);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .custom-notification.show {
        opacity: 1;
        transform: translateX(0);
    }
    
    .custom-notification.success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .custom-notification.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    
    .custom-notification.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    
    .custom-notification.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }
    
    .notification-icon {
        font-size: 28px;
        flex-shrink: 0;
        animation: pulse 2s ease-in-out infinite;
    }
    
    .notification-message {
        flex: 1;
        font-size: 15px;
        font-weight: 600;
        line-height: 1.5;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .notification-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
        line-height: 1;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        flex-shrink: 0;
    }
    
    .notification-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    /* Spinner para botón de carga */
    .spinner {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.6s linear infinite;
        vertical-align: middle;
        margin-right: 6px;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Suprimir alertas nativas de DataTables */
    .dataTables_wrapper .dataTables_processing {
        background: rgba(139, 92, 246, 0.9) !important;
        color: white !important;
        border-radius: 8px !important;
        padding: 15px 25px !important;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3) !important;
    }
</style>

<div class="workplace">
    <div class="admin-header-enhanced">
        <div>
            <h1>📱 IMEI Methods</h1>
            <p class="subtitle" style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Gestiona tus servicios IMEI</p>
        </div>
        <div>
            <?php echo form_open('admin/method/add',array('method' => 'post','id'=>'form')); ?>
            <?php echo form_submit(array('value'=> '➕ Agregar Método','class'=>'btn-enhanced btn-primary-enhanced', 'style'=>'padding: 12px 24px; background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px); color: white; border: 2px solid rgba(255, 255, 255, 0.4); border-radius: 10px; font-weight: 700; cursor: pointer;')); ?>
            <?php echo form_close(); ?>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">   
        <?php $this->load->view('admin/includes/message'); ?>
            <div class="head clearfix" style="display: none;">
                    <div class="isw-grid"></div>
                    <h1>IMEI Methods</h1>                      
                </div>
            
            <!-- Filtros y Operaciones Masivas -->
            <div class="filter-bar">
                <!-- Operaciones Masivas -->
                <span id="selectedCount" style="padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border-radius: 8px; font-weight: 700; display: none;">
                    <span id="countNumber">0</span> seleccionados
                </span>
                
                <button class="config-btn" onclick="bulkDelete()" id="bulkDeleteBtn" style="display: none;" title="Eliminar seleccionados">
                    🗑️ Eliminar Seleccionados
                </button>
            </div>
            
            <div class="block-fluid table-sorting clearfix">
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="TableDeferLoading">
                    <thead>
                        <tr>                                        
                            <th width="3%"><input type="checkbox" id="selectAll" title="Seleccionar todos"></th>                                        
                            <th width="5%">ID</th>
                            <th>Title</th>
                            <th width="10%">Status</th>
                            <th width="10%">Price</th>
                            <th width="15%">Created Date Time</th>                                        
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
              <li><i class="isb-edit"></i> Edit Record</li>
              <li><i class="isb-sync"></i> Sync Required Parameter List</li>
              <li><i class="isb-delete"></i> Delete Record</li>
            </ul>
          </div>
        </div>
    </div> 
</div>
<script type="text/javascript" charset="utf-8">

var table;

$(document).ready(function()
  {
	    table = $('#TableDeferLoading').dataTable
		({
		      'bProcessing'    : true,
		      'bServerSide'    : true,
		      'bAutoWidth'     : false,
		      'sPaginationType': 'full_numbers',
		      'sAjaxSource'    : '<?php echo site_url('admin/method/listener'); ?>',
		      'aoColumnDefs': [ 
		          { "bSortable": false, "aTargets": [ 0, 6 ] }, // Checkbox y Options no ordenables
		          { "bSearchable": false, "aTargets": [ 0, 6 ] } // Checkbox y Options no buscables
		      ], 
		      'sDom'		   : 'T<"clear">lfrtip', //datatable export buttons
		      'oTableTools'	  : 
		      { //datatable export buttons
		      	"sSwfPath": "<?php echo $this->config->item('assets_url');?>js/plugins/dataTables/media/swf/copy_csv_xls_pdf.swf",
		      	"sRowSelect": "multi"		      	
		      }, 
		      'aoColumns'      : 
			      [
			        // Columna 0: Checkbox (no viene del servidor, se llena manualmente)
			        { 
			            'bSearchable': false, 
			            'bVisible': true, 
			            'sClass': 'checkbox-column',
			            'sDefaultContent': '',
			            'bSortable': false,
			            'mData': null // Esta columna no tiene datos del servidor
			        },
			        // Columna 1: ID - aData[0]
			        { 
			            'bSearchable': false, 
			            'bVisible': true,
			            'bSortable': true,
			            'mData': 0 // ID viene en índice 0
			        },
			        // Columna 2: Title - aData[1]
			        { 'mData': 1 },
			        // Columna 3: Status - aData[2]
			        { 'mData': 2 },
			        // Columna 4: Price - aData[3]
			        { 'mData': 3 },
			        // Columna 5: CreatedDateTime - aData[4]
			        { 'mData': 4 },
			        // Columna 6: Options - aData[5]
			        {
			            'mData': 5,
			            'bSortable': false,
			            'bSearchable': false
			        }
			      ],
			      'fnRowCallback': function(nRow, aData, iDisplayIndex) {
			          try {
			              // Estructura de aData desde el servidor: [ID, Title, Status, Price, CreatedDateTime, delete/options]
			              // Con mData definido, DataTables ya mapeó correctamente las columnas 1-6
			              // Solo necesitamos agregar el checkbox y verificar que todo esté bien
			              
			              if(!aData || aData.length < 6) {
			                  console.error('aData incompleto en fila', iDisplayIndex, ':', aData);
			                  return nRow;
			              }
			              
			              var id = String(aData[0] || '');
			              var optionsHtml = aData[5] || '';
			              
              // Agregar checkbox en primera columna (td:eq(0))
              // Las demás columnas ya están mapeadas por DataTables con mData
              var checkbox = '<input type="checkbox" class="row-checkbox" data-id="' + id + '" title="Seleccionar fila" />';
              $('td:eq(0)', nRow).html(checkbox);
              $(nRow).addClass('selectable-row');
			              
			              // Asegurar que Options tenga los iconos correctos (si no vienen del servidor)
			              if(!optionsHtml || (typeof optionsHtml === 'string' && optionsHtml.indexOf('isb-') === -1)) {
			                  optionsHtml = '<a href="<?php echo site_url("admin/method/edit"); ?>/' + id + '" title="Edit this record" class="tip"><span class="isb-edit"></span></a> ';
			                  optionsHtml += '<a href="<?php echo site_url("admin/method/sync"); ?>/' + id + '" title="Sync Required Parameter List" class="tip"><span class="isb-sync"></span></a> ';
			                  optionsHtml += '<a href="<?php echo site_url("admin/method/delete"); ?>/' + id + '" title="Delete this record" class="tip" onclick="return confirm(\'Are sure want to delete this record?\');"><span class="isb-delete"></span></a>';
			                  $('td:eq(6)', nRow).html(optionsHtml);
			              }
			              
			          } catch(e) {
			              console.error('Error en fnRowCallback:', e, 'aData:', aData);
			          }
			          
			          return nRow;
			      },
			      'fnServerData': function(sSource, aoData, fnCallback)
			      {
			      		<?php				if($this->config->item('csrf_protection') === TRUE){	?>
			      	aoData.push({ name : '<?php echo $this->config->item('csrf_token_name'); ?>', value :  $.cookie('<?php echo $this->config->item('csrf_cookie_name'); ?>') });
<?php				}	?>
			        $.ajax({
				          'dataType': 'json',
				          'type'    : 'POST',
				          'url'     : sSource,
				          'data'    : aoData,
				          'success' : function(json) {
				              // Validar estructura de respuesta
				              if(!json || typeof json !== 'object') {
				                  if(typeof showNotification === 'function') {
				                      showNotification('Formato de respuesta inválido', 'error');
				                  }
				                  fnCallback({
				                      "sEcho": 0,
				                      "iTotalRecords": 0,
				                      "iTotalDisplayRecords": 0,
				                      "aaData": []
				                  });
				                  return;
				              }
				              // Verificar que aaData exista y sea array
				              if(!json.aaData || !Array.isArray(json.aaData)) {
				                  if(typeof showNotification === 'function') {
				                      showNotification('Datos de tabla inválidos', 'error');
				                  }
				                  json.aaData = [];
				              }
				              fnCallback(json);
				          },
				          'error': function(xhr, error, thrown) {
				              // Suprimir alertas de DataTables y mostrar notificación bonita
				              var errorMsg = 'Error al cargar datos';
				              if(xhr.responseJSON && xhr.responseJSON.error) {
				                  errorMsg = xhr.responseJSON.error;
				              } else if(xhr.status === 0) {
				                  errorMsg = 'No se pudo conectar al servidor';
				              } else if(xhr.status === 404) {
				                  errorMsg = 'Página no encontrada';
				              } else if(xhr.status === 500) {
				                  errorMsg = 'Error interno del servidor';
				              }
				              if(typeof showNotification === 'function') {
				                  showNotification(errorMsg, 'error');
				              }
				              // Devolver datos vacíos para evitar alerta de DataTables
				              fnCallback({
				                  "sEcho": 0,
				                  "iTotalRecords": 0,
				                  "iTotalDisplayRecords": 0,
				                  "aaData": []
				              });
				          }
			        });
			      }
		});
		
		// Selección múltiple: Seleccionar todos
		$('#selectAll').on('change', function() {
		    var checked = $(this).prop('checked');
		    $('.row-checkbox').prop('checked', checked);
		    
		    if(checked) {
		        $('.row-checkbox').closest('tr').addClass('selected');
		    } else {
		        $('.row-checkbox').closest('tr').removeClass('selected');
		    }
		    
		    updateSelectedCount();
		});
		
		// Selección múltiple: Checkboxes individuales
		$(document).on('change', '.row-checkbox', function() {
		    if($(this).prop('checked')) {
		        $(this).closest('tr').addClass('selected');
		    } else {
		        $(this).closest('tr').removeClass('selected');
		    }
		    updateSelectedCount();
		    
		    // Si todos están seleccionados, marcar el "select all"
		    var total = $('.row-checkbox').length;
		    var checked = $('.row-checkbox:checked').length;
		    $('#selectAll').prop('checked', total > 0 && total === checked);
		});
		
		// Selección con teclado (Shift+Click)
		var lastChecked = null;
		$(document).on('click', '.row-checkbox', function(e) {
		    var checkbox = $(this);
		    
		    if(e.shiftKey && lastChecked && lastChecked !== this) {
		        // Seleccionar rango con Shift
		        var checkboxes = $('.row-checkbox');
		        var start = checkboxes.index($(lastChecked));
		        var end = checkboxes.index(checkbox);
		        
		        var startIdx = Math.min(start, end);
		        var endIdx = Math.max(start, end);
		        
		        checkboxes.slice(startIdx, endIdx + 1).prop('checked', true);
		        checkboxes.slice(startIdx, endIdx + 1).closest('tr').addClass('selected');
		    }
		    
		    lastChecked = this;
		    updateSelectedCount();
		});
		
		// Actualizar contador de seleccionados
		function updateSelectedCount() {
		    var count = $('.row-checkbox:checked').length;
		    $('#countNumber').text(count);
		    
		    if(count > 0) {
		        $('#selectedCount').show();
		        $('#bulkDeleteBtn').show();
		    } else {
		        $('#selectedCount').hide();
		        $('#bulkDeleteBtn').hide();
		    }
		}
		
  });
		
		
		// Operación masiva: Eliminar (debe estar fuera de document.ready para ser accesible globalmente)
		window.bulkDelete = function() {
		    try {
		        var selected = [];
		        $('.row-checkbox:checked').each(function() {
		            selected.push($(this).data('id'));
		        });
		        
		        if(selected.length === 0) {
		            showNotification('Por favor selecciona al menos un elemento', 'warning');
		            return;
		        }
		        
		        if(!confirm('⚠️ ¿Estás seguro de eliminar ' + selected.length + ' método(s)?\n\nEsto eliminará permanentemente los elementos seleccionados.')) {
		            return;
		        }
		        
		        var $btn = $('#bulkDeleteBtn');
		        var originalHtml = $btn.html(); // Guardar HTML completo
		        
		        // Mostrar loading - GUARDAR referencia para asegurar restauración
		        $btn.prop('disabled', true).html('⏳ Eliminando...');
		        
		        // Llamada AJAX para eliminar múltiples
		        $.ajax({
		            url: '<?php echo site_url("admin/method/bulk_delete"); ?>',
		            type: 'POST',
		            data: {
		                ids: selected
		            },
		            dataType: 'json',
		            timeout: 30000, // 30 segundos timeout
		            success: function(response) {
		                try {
		                    if(response && response.success) {
		                        showNotification(response.message || 'Elementos eliminados correctamente', 'success');
		                        // Recargar tabla
		                        if(table && typeof table.draw === 'function') {
		                            table.draw(false); // false = mantener página actual
		                        } else {
		                            location.reload();
		                        }
		                        // Limpiar selección
		                        $('.row-checkbox').prop('checked', false);
		                        $('#selectAll').prop('checked', false);
		                        if(typeof updateSelectedCount === 'function') {
		                            updateSelectedCount();
		                        }
		                    } else {
		                        showNotification(response.error || 'No se pudo eliminar', 'error');
		                    }
		                } catch(e) {
		                    console.error('Error procesando respuesta:', e);
		                    showNotification('Error al procesar la respuesta', 'error');
		                }
		            },
		            error: function(xhr, status, error) {
		                var errorMsg = 'Error al eliminar';
		                if(xhr.responseJSON && xhr.responseJSON.error) {
		                    errorMsg = xhr.responseJSON.error;
		                } else if(error) {
		                    errorMsg = error;
		                } else if(status === 'timeout') {
		                    errorMsg = 'Tiempo de espera agotado';
		                }
		                showNotification(errorMsg, 'error');
		                console.error('Error details:', xhr.responseText);
		            },
		            complete: function() {
		                // SIEMPRE restaurar el botón, incluso si hay errores
		                try {
		                    $btn.prop('disabled', false).html(originalHtml);
		                } catch(e) {
		                    // Si falla, forzar restauración
		                    setTimeout(function() {
		                        $('#bulkDeleteBtn').prop('disabled', false).html('🗑️ Eliminar Seleccionados');
		                    }, 100);
		                }
		            }
		        });
		    } catch(e) {
		        console.error('Error en bulkDelete:', e);
		        showNotification('Error inesperado: ' + e.message, 'error');
		        // Asegurar que el botón se restaure
		        $('#bulkDeleteBtn').prop('disabled', false).html('🗑️ Eliminar Seleccionados');
		    }
		};		
			
</script>            