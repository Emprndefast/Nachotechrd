<style>
    /* Estilos para selección múltiple y notificaciones */
    .admin-header-enhanced {
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #0ea5e9 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 6px 25px rgba(139, 92, 246, 0.3);
    }
    
    .filter-bar {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .config-btn {
        padding: 10px 20px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
    }
    
    .config-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }
    
    .config-btn.delete-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    .config-btn.status-btn {
        background: linear-gradient(135deg, #10b981, #059669);
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
    
    .selected-count {
        padding: 8px 16px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border-radius: 8px;
        font-weight: 700;
    }
</style>

<div class="workplace">
    <div class="admin-header-enhanced">
        <div>
            <h1>📱 IMEI Orders</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Gestiona y procesa órdenes IMEI</p>
        </div>
    </div>
    
    <div class="row-fluid">
        <div class="span12">   
      <?php $this->load->view('admin/includes/message'); ?>
      <?php echo form_open('admin/imeiorder/bulk',array('method' => 'post','id'=>'form')); ?>
            <div class="block-fluid table-sorting clearfix">
              <div class="block-fluid">                        
                  <div class="row-form clearfix">
                      <div class="span1">IMEI:</div>
                      <div class="span3" id="IMEI"></div>
                      <div class="span1">Methods:</div>
                      <div class="span2" id="Methods"></div>
                      <div class="span1">Status:</div>
                      <div class="span2" id="Status"></div>
                  </div>                                                                             
                </div>
            <!-- Filtros y Operaciones Masivas -->
            <div class="filter-bar">
                <span id="selectedCount" class="selected-count" style="display: none;">
                    <span id="countNumber">0</span> órdenes seleccionadas
                </span>
                
                <button type="button" class="config-btn" onclick="bulkEdit()" id="bulkEditBtn" style="display: none;">
                    ✏️ Editar Seleccionadas
                </button>
                
                <button type="button" class="config-btn status-btn" onclick="bulkChangeStatus()" id="bulkStatusBtn" style="display: none;">
                    🔄 Cambiar Estado
                </button>
                
                <button type="button" class="config-btn" onclick="return bulk_issue();" id="bulkIssueBtn" style="display: none;">
                    ✅ Procesar Códigos
                </button>
                
                <button type="button" class="config-btn delete-btn" onclick="bulkDelete()" id="bulkDeleteBtn" style="display: none;">
                    🗑️ Eliminar Seleccionadas
                </button>
            </div>
            
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="TableDeferLoading">
                    <thead>
                        <tr>                                        
                            <th width="3%"><input type="checkbox" id="selectAll" title="Seleccionar todos"></th>
                            <th width="5%">ID</th>
                            <th width="13%">IMEI</th>
                            <th width="23%">Method</th>
                            <th width="15%">Email</th>
                            <th>Comments</th>
                            <th width="5%">Status</th>
                            <th width="15%">Created Date Time</th>         
                            <th width="10%">Options</th>                                
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>                                        
                            <th></th>
                            <th>ID</th>
                            <th>IMEI</th>
                            <th>Method</th>
                            <th>Email</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th>Created Date Time</th>      
                            <th>Options</th>                                
                        </tr>
                    </tfoot>                                
                </table>
            </div>
              <?php echo form_close(); ?>              
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
              <li><i class="isb-edit"></i> Edit Order</li>
              <li><i class="isb-cancel"></i> Cancel Order</li>
              <li><i class="isb-delete"></i> Delete Order</li>
            </ul>
          </div>
        </div>
    </div>     
</div>
<script type="text/javascript" charset="utf-8">

$(document).ready(function()
  {
	    $('#TableDeferLoading').dataTable
		({
		      'bProcessing'    : true,
		      'bServerSide'    : true,
		      'bAutoWidth'     : false,
		      'sPaginationType': 'full_numbers',
		      'sAjaxSource'    : '<?php echo site_url('admin/imeiorder/listener'); ?>',
		      'aoColumnDefs'   : [ 
		          { "bSortable": false, "aTargets": [ 0, 8 ] }, // Checkbox y Options no ordenables
		          { "bSearchable": false, "aTargets": [ 0, 8 ] } // Checkbox y Options no buscables
		      ],
              'aaSorting'      : [[1, 'desc']], // Ordenar por ID descendente
		      'aLengthMenu'    : [25, 50, 100, 200, 500, 1000],
		      'iDisplayLength' : 100,
		      'sDom'		   : 'T<"clear">lfrtip', //datatable export buttons
		      'oTableTools'	  : 
		      { //datatable export buttons
		      	"sSwfPath": "<?php echo $this->config->item('assets_url');?>js/plugins/dataTables/media/swf/copy_csv_xls_pdf.swf",
		      	"sRowSelect": "multi"		      	
		      }, 
		      'aoColumns'      : 
			      [
			        // Columna 0: Checkbox
			        {
			          'bSearchable': false,
			          'bVisible'   : true,
			          'sClass': 'checkbox-column',
			          'sDefaultContent': '',
			          'bSortable': false,
			          'mData': null
			        },
			        // Columna 1: ID - aData[0]
			        { 'mData': 0 },
			        // Columna 2: IMEI - aData[1]
			        { 'mData': 1 },
			        // Columna 3: Method - aData[2]
			        { 'mData': 2 },
			        // Columna 4: Email - aData[3]
			        { 'mData': 3 },
			        // Columna 5: Comments - aData[4]
			        { 'mData': 4 },
			        // Columna 6: Status - aData[5]
			        { 'mData': 5 },
			        // Columna 7: CreatedDateTime - aData[6]
			        { 'mData': 6 },
			        // Columna 8: Options - aData[7]
			        {
			            'mData': 7,
			            'bSortable': false,
			            'bSearchable': false
			        }
			      ],
			      'fnRowCallback': function(nRow, aData, iDisplayIndex) {
			          try {
			              if(!aData || aData.length < 8) {
			                  console.error('aData incompleto:', aData);
			                  return nRow;
			              }
			              
			              var id = String(aData[0] || '');
			              
			              // Agregar checkbox en primera columna
			              var checkbox = '<input type="checkbox" class="row-checkbox" data-id="' + id + '" title="Seleccionar orden" />';
			              $('td:eq(0)', nRow).html(checkbox);
			              $(nRow).addClass('selectable-row');
			              
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
			        $.ajax
			        ({
				          'dataType': 'json',
				          'type'    : 'POST',
				          'url'     : sSource,
				          'data'    : aoData,
				          'success' : fnCallback
			        });
			      }
		})
		.columnFilter({
				aoColumns: [ 
					null, // Checkbox
					null, // ID
					{ sSelector: "#IMEI", type: "number"},
					{ sSelector: "#Methods", type: "select", values: <?php echo $method_list; ?>},
					null, // Email
					null, // Comments
					{ sSelector: "#Status", type: "select", values: ["Pending", "Issued", "Canceled"]},
				    null, // CreatedDateTime
				    null  // Options
				]				
		});
		
		// Selección múltiple
		var table = $('#TableDeferLoading').dataTable();
		
		// Seleccionar todos
		$('#selectAll').on('change', function() {
		    var checked = this.checked;
		    $('.row-checkbox').each(function() {
		        this.checked = checked;
		        updateRowSelection(this);
		    });
		    updateSelectedCount();
		});
		
		// Selección individual
		$(document).on('change', '.row-checkbox', function() {
		    updateRowSelection(this);
		    updateSelectedCount();
		    
		    // Actualizar "Seleccionar todos" si todos están marcados
		    var total = $('.row-checkbox').length;
		    var checked = $('.row-checkbox:checked').length;
		    $('#selectAll').prop('checked', total > 0 && total === checked);
		});
		
		function updateRowSelection(checkbox) {
		    var row = $(checkbox).closest('tr');
		    if($(checkbox).is(':checked')) {
		        row.addClass('selected');
		    } else {
		        row.removeClass('selected');
		    }
		}
		
		function updateSelectedCount() {
		    var count = $('.row-checkbox:checked').length;
		    $('#countNumber').text(count);
		    
		    if(count > 0) {
		        $('#selectedCount').show();
		        $('#bulkEditBtn').show();
		        $('#bulkStatusBtn').show();
		        $('#bulkIssueBtn').show();
		        $('#bulkDeleteBtn').show();
		    } else {
		        $('#selectedCount').hide();
		        $('#bulkEditBtn').hide();
		        $('#bulkStatusBtn').hide();
		        $('#bulkIssueBtn').hide();
		        $('#bulkDeleteBtn').hide();
		    }
		}
  });
  
  function bulk_issue()
  {
      var selected = [];
      $('.row-checkbox:checked').each(function() {
          selected.push($(this).data('id'));
      });
      
      if(selected.length === 0) {
          alert('⚠️ Por favor selecciona al menos una orden');
          return false;
      }
      
      if(!confirm('⚠️ ¿Estás seguro de procesar códigos para ' + selected.length + ' orden(es) seleccionada(s)?')) {
          return false;
      }
      
      var form = $('<?php echo str_replace (array("\r\n", "\n", "\r"), '', form_open('admin/imeiorder/bulk')); ?>' +
        '<input type="hidden" name="json" value="' + JSON.stringify(selected) + '" />' +
        '</form>');
      $('body').append(form);
      $(form).submit();
  }
  
  function bulkEdit() {
      var selected = [];
      $('.row-checkbox:checked').each(function() {
          selected.push($(this).data('id'));
      });
      
      if(selected.length === 0) {
          alert('⚠️ Por favor selecciona al menos una orden');
          return;
      }
      
      // Redirigir a página de edición masiva
      var form = $('<form method="post" action="<?php echo site_url("admin/imeiorder/bulk_edit"); ?>">' +
        '<input type="hidden" name="ids" value="' + JSON.stringify(selected) + '" />' +
        '</form>');
      $('body').append(form);
      $(form).submit();
  }
  
  function bulkChangeStatus() {
      var selected = [];
      $('.row-checkbox:checked').each(function() {
          selected.push($(this).data('id'));
      });
      
      if(selected.length === 0) {
          alert('⚠️ Por favor selecciona al menos una orden');
          return;
      }
      
      var newStatus = prompt('Ingresa el nuevo estado:\n- Pending\n- Issued\n- Canceled', '');
      
      if(!newStatus || !['Pending', 'Issued', 'Canceled'].includes(newStatus)) {
          if(newStatus !== null) {
              alert('❌ Estado inválido. Debe ser: Pending, Issued o Canceled');
          }
          return;
      }
      
      if(!confirm('⚠️ ¿Cambiar estado a "' + newStatus + '" para ' + selected.length + ' orden(es)?')) {
          return;
      }
      
      $.ajax({
          url: '<?php echo site_url("admin/imeiorder/bulk_update_status"); ?>',
          type: 'POST',
          data: {
              ids: selected,
              status: newStatus
          },
          dataType: 'json',
          success: function(response) {
              if(response.success) {
                  alert('✅ ' + response.message);
                  $('#TableDeferLoading').dataTable().fnDraw();
                  $('.row-checkbox').prop('checked', false);
                  $('#selectAll').prop('checked', false);
                  updateSelectedCount();
              } else {
                  alert('❌ Error: ' + (response.error || 'No se pudo actualizar'));
              }
          },
          error: function() {
              alert('❌ Error al cambiar el estado');
          }
      });
  }
  
  function bulkDelete() {
      var selected = [];
      $('.row-checkbox:checked').each(function() {
          selected.push($(this).data('id'));
      });
      
      if(selected.length === 0) {
          alert('⚠️ Por favor selecciona al menos una orden');
          return;
      }
      
      if(!confirm('⚠️ ¿Estás seguro de eliminar ' + selected.length + ' orden(es)?\n\nEsta acción no se puede deshacer.')) {
          return;
      }
      
      $.ajax({
          url: '<?php echo site_url("admin/imeiorder/bulk_delete"); ?>',
          type: 'POST',
          data: {
              ids: selected
          },
          dataType: 'json',
          success: function(response) {
              if(response.success) {
                  alert('✅ ' + response.message);
                  $('#TableDeferLoading').dataTable().fnDraw();
                  $('.row-checkbox').prop('checked', false);
                  $('#selectAll').prop('checked', false);
                  updateSelectedCount();
              } else {
                  alert('❌ Error: ' + (response.error || 'No se pudo eliminar'));
              }
          },
          error: function() {
              alert('❌ Error al eliminar');
          }
      });
  }
</script> 