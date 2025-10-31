<div class="workplace">
    <style>
        /* Estilos mejorados para Admin Panel */
        .admin-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        
        .admin-header {
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
        
        .admin-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 900;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .admin-header-actions {
            display: flex;
            gap: 12px;
        }
        
        .btn-enhanced {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
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
        
        .table-enhanced {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }
        
        .table-enhanced thead th {
            background: linear-gradient(135deg, #64748b, #475569);
            color: white;
            font-weight: 700;
            padding: 15px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        .table-enhanced tbody td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table-enhanced tbody tr:hover {
            background: #f8fafc;
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
        
        .config-save-btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-size: 12px;
        }
        
        .config-save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
    </style>

    <div class="admin-header">
        <div>
            <h1>🚀 API Manager</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Gestiona tus APIs y sus servicios</p>
        </div>
        <div class="admin-header-actions">
            <a href="<?php echo site_url('admin/apimanager/add'); ?>" class="btn-enhanced btn-primary-enhanced">
                ➕ Agregar API
            </a>
        </div>
    </div>

    <?php $this->load->view('admin/includes/message'); ?>

    <div class="admin-card">
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
            
            <button class="config-save-btn" onclick="saveTableConfig()" title="Guardar configuración actual">
                💾 Guardar Config
            </button>
            
            <button class="config-save-btn" onclick="loadTableConfig()" title="Cargar configuración guardada" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                📥 Cargar Config
            </button>
        </div>

        <div class="block-fluid table-sorting clearfix">
            <table cellpadding="0" cellspacing="0" width="100%" class="table table-enhanced" id="TableDeferLoading">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Title</th>
                        <th width="25%">Host</th>
                        <th width="12%">Username</th>
                        <th width="10%">Api Type</th>
                        <th width="10%">Status</th>
                        <th width="12%">Updated Date</th>
                        <th width="11%">Options</th>
                    </tr>
                </thead>
            </table>
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

function saveTableConfig() {
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

var table;

$(document).ready(function() {
    table = $('#TableDeferLoading').dataTable({
        'bProcessing': true,
        'bServerSide': true,
        'bAutoWidth': false,
        'sPaginationType': 'full_numbers',
        'sAjaxSource': '<?php echo site_url('admin/apimanager/listener'); ?>',
        'aoColumnDefs': [ { "bSortable": false, "aTargets": [ 7 ] } ],
        'sDom': 'T<"clear">lfrtip',
        'iDisplayLength': parseInt(tableConfig.pageLength),
        'aaSorting': [[parseInt(tableConfig.orderColumn), tableConfig.orderDirection]],
        'oTableTools': {
            "sSwfPath": "<?php echo $this->config->item('assets_url');?>js/plugins/dataTables/media/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi"
        },
        'aoColumns': [
            { 'bSearchable': false, 'bVisible': true },
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ],
        'fnRowCallback': function(nRow, aData, iDisplayIndex) {
            // Agregar badges de Status
            var status = aData[5] || '';
            var statusHtml = '';
            if(status.toLowerCase() === 'enabled') {
                statusHtml = '<span class="status-badge status-enabled">✅ Activa</span>';
            } else {
                statusHtml = '<span class="status-badge status-disabled">❌ Desactivada</span>';
            }
            $('td:eq(5)', nRow).html(statusHtml);
            
            // Agregar badge de ApiType
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
            $('td:eq(4)', nRow).html(typeHtml);
            
            return nRow;
        },
        'fnServerData': function(sSource, aoData, fnCallback) {
            // Agregar filtros personalizados
            aoData.push({ 'name': 'custom_filter_status', 'value': document.getElementById('filterStatus').value });
            aoData.push({ 'name': 'custom_filter_api_type', 'value': document.getElementById('filterApiType').value });
            aoData.push({ 'name': 'custom_search', 'value': document.getElementById('searchInput').value });
            
            <?php if($this->config->item('csrf_protection') === TRUE){ ?>
            aoData.push({ name : '<?php echo $this->config->item('csrf_token_name'); ?>', value : $.cookie('<?php echo $this->config->item('csrf_cookie_name'); ?>') });
            <?php } ?>
            
            $.ajax({
                'dataType': 'json',
                'type': 'POST',
                'url': sSource,
                'data': aoData,
                'success': fnCallback
            });
        }
    });
    
    // Aplicar filtros cuando cambien
    $('#filterStatus, #filterApiType, #searchInput').on('change keyup', function() {
        table.draw();
        saveTableConfig(); // Auto-guardar configuración
    });
});
</script>

