<style>
/* Dashboard Modern Styles */
.dashboard { background: #f8fafc; min-height: 100vh; padding-bottom: 40px; }

/* Hero Section Mejorado */
.dash-hero-modern {
    background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
    border-radius: 20px;
    padding: 40px;
    margin: 25px 0;
    box-shadow: 0 10px 40px rgba(14, 165, 233, 0.25);
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 30px;
    align-items: center;
}

.hero-avatar {
    width: 120px;
    height: 120px;
    border-radius: 20px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    object-fit: cover;
}

.hero-info {
    color: #fff;
}

.hero-info .name {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 8px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.hero-info .email {
    font-size: 16px;
    opacity: 0.95;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.hero-info .phone {
    font-size: 16px;
    opacity: 0.95;
    display: flex;
    align-items: center;
    gap: 8px;
}

.hero-circles {
    display: flex;
    gap: 20px;
}

.circle-stat {
    text-align: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 20px;
    min-width: 130px;
}

.circle-stat .value {
    font-size: 42px;
    font-weight: 900;
    color: #fff;
    margin-bottom: 5px;
}

.circle-stat .label {
    font-size: 14px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
}

/* Balance Bar */
.balance-bar {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 20px 35px;
    margin: 25px 0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.balance-bar ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 15px;
}

.balance-bar li {
    color: #94a3b8;
    font-size: 16px;
    font-weight: 600;
}

.balance-bar span {
    color: #10b981;
    font-size: 28px;
    font-weight: 900;
}

/* Tabs Modernos */
.order-history {
    background: #fff;
    border-radius: 20px;
    padding: 0;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.nav-tabs {
    border-bottom: 2px solid #e2e8f0;
    padding: 0 25px;
    background: #f8fafc;
    margin: 0;
}

.nav-tabs > li {
    margin-bottom: -2px;
}

.nav-tabs > li > a {
    border: none;
    border-radius: 12px 12px 0 0;
    color: #64748b;
    font-weight: 700;
    font-size: 15px;
    padding: 18px 28px;
    margin-right: 5px;
    transition: all 0.3s;
}

.nav-tabs > li > a:hover {
    background: rgba(14, 165, 233, 0.1);
    color: #0ea5e9;
    border: none;
}

.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
    background: #fff;
    color: #0ea5e9;
    border: none;
    border-bottom: 3px solid #0ea5e9;
}

.tab-content {
    padding: 25px;
}

/* DataTables Modernas */
.display {
    width: 100% !important;
    border-collapse: separate !important;
    border-spacing: 0 8px !important;
}

.display thead th {
    background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
    color: #fff;
    font-weight: 800;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 16px 12px;
    border: none;
}

.display thead th:first-child {
    border-radius: 10px 0 0 10px;
}

.display thead th:last-child {
    border-radius: 0 10px 10px 0;
}

.display tbody td {
    background: #f8fafc;
    padding: 16px 12px;
    border: none;
    font-size: 14px;
    color: #1e293b;
}

.display tbody tr {
    transition: all 0.2s;
}

.display tbody tr:hover td {
    background: #e0f2fe;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
}

.display tbody td:first-child {
    border-radius: 10px 0 0 10px;
    font-weight: 700;
    color: #0ea5e9;
}

.display tbody td:last-child {
    border-radius: 0 10px 10px 0;
}

/* DataTables Controls */
.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 14px;
    transition: all 0.3s;
}

.dataTables_wrapper .dataTables_length select:focus,
.dataTables_wrapper .dataTables_filter input:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 14px;
    margin: 0 3px;
    color: #64748b !important;
    font-weight: 600;
    transition: all 0.3s;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #0ea5e9 !important;
    color: #fff !important;
    border-color: #0ea5e9 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%) !important;
    color: #fff !important;
    border-color: #0ea5e9 !important;
}

/* Modales de Bienvenida y Noticias */
.welcome-modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s;
}

.welcome-modal-overlay.active {
    display: flex;
}

.welcome-modal {
    background: #fff;
    border-radius: 24px;
    max-width: 500px;
    width: 90%;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.4s;
    position: relative;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header-custom {
    background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
    padding: 30px;
    text-align: center;
    border-radius: 24px 24px 0 0;
    color: #fff;
}

.modal-header-custom.news {
    background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
}

.modal-header-custom h2 {
    font-size: 28px;
    font-weight: 900;
    margin: 0 0 8px 0;
}

.modal-header-custom p {
    font-size: 15px;
    opacity: 0.95;
    margin: 0;
}

.modal-body-custom {
    padding: 30px;
}

.modal-close-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.support-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin: 20px 0;
}

.support-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 15px;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.support-btn.telegram {
    background: linear-gradient(135deg, #0088cc 0%, #0099dd 100%);
    color: #fff;
}

.support-btn.whatsapp {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: #fff;
}

.support-btn.group {
    background: #f1f5f9;
    color: #475569;
    border-color: #e2e8f0;
}

.support-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.support-btn.telegram:hover {
    box-shadow: 0 8px 20px rgba(0, 136, 204, 0.3);
}

.support-btn.whatsapp:hover {
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
}

.alert-note {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 2px solid #f59e0b;
    border-radius: 12px;
    padding: 16px;
    margin-top: 20px;
    font-size: 14px;
    color: #78350f;
    font-weight: 600;
}

.service-item {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    transition: all 0.3s;
}

.service-item:hover {
    border-color: #0ea5e9;
    background: #e0f2fe;
    transform: translateX(5px);
}

.service-name {
    font-weight: 800;
    font-size: 16px;
    color: #0f172a;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.new-badge {
    background: #10b981;
    color: #fff;
    padding: 3px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 800;
}

.service-details {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 8px;
}

.service-price {
    font-size: 18px;
    font-weight: 900;
    color: #10b981;
}

.modal-footer-custom {
    padding: 20px 30px;
    border-top: 1px solid #e2e8f0;
    text-align: center;
}

.btn-got-it {
    background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
    color: #fff;
    padding: 14px 35px;
    border-radius: 12px;
    border: none;
    font-weight: 800;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-got-it:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
    .dash-hero-modern {
        grid-template-columns: 1fr;
        text-align: center;
        justify-items: center;
    }
    
    .hero-circles {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .hero-avatar {
        width: 100px;
        height: 100px;
    }
    
    .hero-info .name {
        font-size: 24px;
    }
    
    .circle-stat {
        min-width: 110px;
        padding: 15px;
    }
    
    .circle-stat .value {
        font-size: 32px;
    }
    
    .welcome-modal {
        max-width: 95%;
    }
}
</style>

<!-- Hero Section Moderno -->
<div class="dash-hero-modern">
    <img src="<?php echo base_url(); ?>img/avatar.jpg" alt="Avatar" class="hero-avatar">
    
    <div class="hero-info">
        <div class="name">
            👤 <?php echo $this->session->userdata('MemberFirstName') . " " . $this->session->userdata("MemberLastName"); ?>
        </div>
        <div class="email">
            <span>📧</span> <?php echo $this->session->userdata("MemberEmail"); ?>
</div>
        <?php if($this->session->userdata("MemberPhone") != ""): ?>
        <div class="phone">
            <span>📱</span> <?php echo $this->session->userdata("MemberPhone"); ?>
</div>
        <?php endif; ?>
</div>

    <div class="hero-circles">
        <div class="circle-stat">
            <div class="value"><?php echo intval($appraovedPercentage); ?>%</div>
            <div class="label">✅ Completados</div>
            </div>
        <div class="circle-stat">
            <div class="value"><?php echo intval($rejectPercentage); ?>%</div>
            <div class="label">❌ Rechazados</div>
        </div>
        <div class="circle-stat">
            <div class="value"><?php echo intval($pendingPercentage); ?>%</div>
            <div class="label">⏳ Pendientes</div>
</div>
</div>
</div>

<!-- Balance Bar -->
<div class="balance-bar">
    <ul>
        <li><span>💰 <?php echo $credit[0]['credit'] ?> Créditos</span> disponibles en tu cuenta</li>
    </ul>
</div>

<!-- Tabs de Historial -->
<div class="order-history">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a data-toggle="tab" href="#imeiorders">📱 IMEI Orders</a></li>
        <li><a data-toggle="tab" href="#pendinginvoices">📁 File Services</a></li>
        <li><a data-toggle="tab" href="#latestnews">💳 Credit</a></li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
      <div id="imeiorders" class="tab-pane fade active in">
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="TableDeferLoading">
			<thead>
				<tr>
					<th width="3%">ID</th>
					<th width="15%">IMEI</th>
					<th width="30%">Method</th>
					<th width="22%">Code</th>
					<th width="15%">Note</th>
					<th width="5%">Status</th>
					<th width="10%">Date Time</th>
				</tr>
			</thead>
		</table>
      </div>
      <div id="pendinginvoices" class="tab-pane fade">
         <table cellpadding="0" cellspacing="0" border="0" class="display" id="TableDeferLoading1">
			<thead>
				<tr>
					<th width="3%">ID</th>
					<th width="15%">IMEI</th>
					<th width="30%">Method</th>
					<th width="22%">Code</th>
					<th width="15%">Note</th>
					<th width="5%">Status</th>
					<th width="10%">Date Time</th>
				</tr>
			</thead>
		</table>
      </div>
      <div id="latestnews" class="tab-pane fade">
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="Credit">
			<thead>
				<tr>
					<th width="3%">ID</th>
					<th width="7%">ID</th>
					<th width="5%">Amount</th>
					<th width="70%">Description</th>
					<th width="15%">Date Time</th>
				</tr>
			</thead>
		</table>
      </div>
    </div>
  </div>
  
<!-- Modal de Bienvenida y Soporte -->
<div id="welcomeModal" class="welcome-modal-overlay">
    <div class="welcome-modal">
        <button class="modal-close-btn" onclick="closeWelcomeModal()">×</button>
        <div class="modal-header-custom">
            <h2>✅ ¡Bienvenido a NachoTechRD!</h2>
            <p>Conéctate con nuestros canales de soporte</p>
        </div>
        <div class="modal-body-custom">
            <p style="margin-bottom: 20px; color: #475569; font-size: 15px;">
                Para recibir notificaciones de pedidos y códigos de seguridad OTP, sincroniza tu cuenta con nuestro bot de Telegram.
            </p>
            
            <div class="support-buttons">
                <a href="https://t.me/Nachotechrdc" target="_blank" class="support-btn telegram">
                    <span style="font-size: 24px;">📢</span>
                    <span>Canal de Noticias Telegram</span>
                </a>
                
                <a href="https://wa.me/18093408435" target="_blank" class="support-btn whatsapp">
                    <span style="font-size: 24px;">💬</span>
                    <span>Canal de WhatsApp</span>
                </a>
                
                <a href="https://t.me/NachoTechRdG" target="_blank" class="support-btn group">
                    <span style="font-size: 24px;">👥</span>
                    <span>Grupo Oficial</span>
                </a>
                
                <a href="https://t.me/nachotechrd_bot" target="_blank" class="support-btn telegram">
                    <span style="font-size: 24px;">🤖</span>
                    <span>Sincronizar Bot Telegram</span>
                </a>
                
                <a href="https://wa.me/18093408435" target="_blank" class="support-btn whatsapp">
                    <span style="font-size: 24px;">🆘</span>
                    <span>Soporte WhatsApp</span>
                </a>
            </div>
            
            <div class="alert-note">
                <strong>⚠️ Importante:</strong> No olvides sincronizar tu bot de Telegram para recibir notificaciones de pedidos y códigos de seguridad OTP para iniciar sesión.
            </div>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-got-it" onclick="closeWelcomeModal()">¡Entendido!</button>
</div>
</div>
</div>

<!-- Modal de Servicios Nuevos -->
<div id="newsModal" class="welcome-modal-overlay">
    <div class="welcome-modal">
        <button class="modal-close-btn" onclick="closeNewsModal()">×</button>
        <div class="modal-header-custom news">
            <h2>🚀 Nuevos Servicios Agregados</h2>
            <p>Descubre nuestras últimas adiciones</p>
        </div>
        <div class="modal-body-custom">
            <?php
            // Obtener los últimos 5 servicios
            $this->load->model('method_model');
            $this->db->select('gsm_methods.Title, gsm_methods.Price, gsm_methods.DeliveryTime, gsm_methods.Description');
            $this->db->from('gsm_methods');
            $this->db->where('gsm_methods.Status', 'Enabled');
            $this->db->order_by('gsm_methods.ID', 'DESC');
            $this->db->limit(5);
            $new_services = $this->db->get()->result_array();
            
            if(!empty($new_services)):
                foreach($new_services as $service):
            ?>
            <div class="service-item">
                <div class="service-name">
                    ⭐ <?php echo htmlspecialchars($service['Title']); ?>
                    <span class="new-badge">NUEVO</span>
                </div>
                <div class="service-details">
                    <?php echo !empty($service['Description']) ? htmlspecialchars($service['Description']) : 'Servicio premium disponible'; ?>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="service-price">$<?php echo number_format($service['Price'], 2); ?></div>
                    <div style="color: #64748b; font-size: 13px; font-weight: 600;">
                        ⏱ <?php echo !empty($service['DeliveryTime']) ? $service['DeliveryTime'] . ' h' : 'N/A'; ?>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else:
            ?>
            <div style="text-align: center; padding: 30px; color: #94a3b8;">
                <p style="font-size: 16px;">📭 No hay servicios nuevos por el momento</p>
            </div>
            <?php endif; ?>
            
            <a href="<?php echo site_url('member/imeirequest'); ?>" style="display: block; margin-top: 20px; text-align: center; background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%); color: #fff; padding: 14px; border-radius: 12px; text-decoration: none; font-weight: 800; font-size: 15px;">
                Ver Todos los Servicios →
            </a>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-got-it" onclick="closeNewsModal()">Cerrar</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Mostrar modales al cargar la página (solo una vez por sesión)
    if(!localStorage.getItem('nachotech_welcome_shown_v2')) {
        setTimeout(function() {
            document.getElementById('welcomeModal').classList.add('active');
        }, 1000);
    }
	
	$('#TableDeferLoading').dataTable
	({			  
			'bProcessing'    : true,
			'bServerSide'    : true,
			'bAutoWidth'     : false,
			'sPaginationType': 'full_numbers',
			'sAjaxSource'    : '<?php echo site_url('member/dashboard/listener'); ?>',
			'aLengthMenu': [25, 50, 100, 200, 500, 1000],
			'aaSorting'      : [[0, 'desc']],
			'iDisplayLength': 100,
			'sDom'		   : 'T<"clear">lfrtip',
			'oTableTools'	  : 
			{
			"sSwfPath": "<?php echo $this->config->item('assets_url');?>js/plugins/dataTables/media/swf/copy_csv_xls_pdf.swf",
			"sRowSelect": "multi"		      	
			}, 
			'aoColumns'      : 
				[
				{
					'bSearchable': false,
					'bVisible'   : true
				},			        
				null,
				null,
				null,
				null,
				null,
				null
				],
				'fnServerData': function(sSource, aoData, fnCallback)
				{
	<?php if($this->config->item('csrf_protection') === TRUE){	?>
				aoData.push({ name : '<?php echo $this->config->item('csrf_token_name'); ?>', value :  $.cookie('<?php echo $this->config->item('csrf_cookie_name'); ?>') });
	<?php }	?>			      	
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
	
	$('#TableDeferLoading1').dataTable
	({			  
			'bProcessing'    : true,
			'bServerSide'    : true,
			'bAutoWidth'     : false,
			'sPaginationType': 'full_numbers',
			'sAjaxSource'    : '<?php echo site_url('member/dashboard/fileorder'); ?>',
			'aoColumnDefs': [ { "bSortable": false, "aTargets": [ 6 ] } ],
			'aLengthMenu': [25, 50, 100, 200, 500, 1000],
			'aaSorting'      : [[0, 'desc']],
			'iDisplayLength': 100,
			'sDom'		   : 'T<"clear">lfrtip',
			'oTableTools'	  : 
			{
			"sSwfPath": "<?php echo $this->config->item('assets_url');?>js/plugins/dataTables/media/swf/copy_csv_xls_pdf.swf",
			"sRowSelect": "multi"		      	
			}, 
			'aoColumns'      : 
				[
				{
					'bSearchable': false,
					'bVisible'   : true
				},			        
				null,
				null,
				null,
				null,
				null,
				null
				],
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
	});

	$('#Credit').dataTable
	({			  
			'bProcessing'    : true,
			'bServerSide'    : true,
			'bAutoWidth'     : false,
			'sPaginationType': 'full_numbers',
			'sAjaxSource'    : '<?php echo site_url('member/dashboard/credit'); ?>',
			'aLengthMenu': [25, 50, 100, 200, 500, 1000],
			'aaSorting'      : [[0, 'desc']],
			'iDisplayLength': 100,
			'sDom'		   : 'T<"clear">lfrtip',
			'oTableTools'	  : 
			{
			"sSwfPath": "<?php echo $this->config->item('assets_url');?>js/plugins/dataTables/media/swf/copy_csv_xls_pdf.swf",
			"sRowSelect": "multi"		      	
			}, 
			'aoColumns'      : 
				[
				{
					'bSearchable': false,
					'bVisible'   : false
				},			        
				null,
				null,
				null,
				null
				
				],
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
	});
	
});	

function closeWelcomeModal() {
    document.getElementById('welcomeModal').classList.remove('active');
    localStorage.setItem('nachotech_welcome_shown_v2', '1');
    // Mostrar modal de noticias después de cerrar bienvenida
    setTimeout(function() {
        document.getElementById('newsModal').classList.add('active');
    }, 500);
}

function closeNewsModal() {
    document.getElementById('newsModal').classList.remove('active');
}

// Cerrar modales al hacer clic fuera
document.getElementById('welcomeModal').addEventListener('click', function(e) {
    if(e.target === this) closeWelcomeModal();
});

document.getElementById('newsModal').addEventListener('click', function(e) {
    if(e.target === this) closeNewsModal();
});	
</script>
