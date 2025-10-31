<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html lang="en-US">
<!--<![endif]--><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>NACHOTECHRD:: <?php echo $Title; ?></title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!--Google Font-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table.css" type="text/css" media="screen">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />

    
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- Styles -->

</head>

<body>
<?php 
// Cargar crédito si no está definido
if (!isset($credit)) {
    $this->load->model('credit_model');
    $member_id = $this->session->userdata('MemberID');
    $credit = $this->credit_model->get_credit($member_id);
    if(empty($credit) || $credit[0]['credit'] == "") {
        $credit[0]['credit'] = 0;
    }
}
// Obtener información de configuración para contacto
$this->load->model('configuration_model');
$config = $this->configuration_model->get_all();
$contact_email = !empty($config[0]['Email']) ? $config[0]['Email'] : 'info@nachotechrd.com';
$whatsapp = !empty($config[0]['CallUs']) ? $config[0]['CallUs'] : '18093408435';
$telegram_group_url = 'https://t.me/NachoTechRdG';
$telegram_channel_url = 'https://t.me/Nachotechrdc';
$social_handle = '@nachotechrd';
$member_name = $this->session->userdata('MemberFirstName') . " " . $this->session->userdata("MemberLastName");
$member_email = $this->session->userdata('MemberEmail');
$balance = number_format($credit[0]['credit'], 2);
?>
<!-- PROMO BANNER TOP siempre visible -->
    <div class="promo-banners">
        <div class="promo-banner promo-teal-1">
            <div class="marquee left" id="banner1">
            <span class="marquee-track">✔ ⚡ PANEL FMI OFF DE RAIZ - DRAGON SERVER - DISPONIBLE MUNDIAL ⚡ ✓ — SOPORTE 24/7 — ENTREGA RÁPIDA — DESCUENTOS PARA MAYORISTAS — PRUEBAS DISPONIBLES —</span>
            <span class="marquee-track">✔ ⚡ PANEL FMI OFF DE RAIZ - DRAGON SERVER - DISPONIBLE MUNDIAL ⚡ ✓ — SOPORTE 24/7 — ENTREGA RÁPIDA — DESCUENTOS PARA MAYORISTAS — PRUEBAS DISPONIBLES —</span>
            </div>
        </div>
        <div class="promo-banner promo-yellow">
            <div class="marquee right" id="banner2">
            <span class="marquee-track">LIBERACIÓN DE RED USA — T‑Mobile — AT&T — Cricket — US Reseller Flex — Boost Mobile — Xfinity — POLÍTICAS ACTUALIZADAS — RESULTADOS GARANTIZADOS —</span>
            <span class="marquee-track">LIBERACIÓN DE RED USA — T‑Mobile — AT&T — Cricket — US Reseller Flex — Boost Mobile — Xfinity — POLÍTICAS ACTUALIZADAS — RESULTADOS GARANTIZADOS —</span>
            </div>
        </div>
        <div class="promo-banner promo-teal-2">
            <div class="marquee left" id="banner3">
            <span class="marquee-track">💜 ✨ ⭐ BYPASS FULL WIFI — iPhone XR al 15 Pro Max — Eliminar iCloud Pantalla HELLO — Cobertura Global — Precios Competitivos — Seguridad y Confianza —</span>
            <span class="marquee-track">💜 ✨ ⭐ BYPASS FULL WIFI — iPhone XR al 15 Pro Max — Eliminar iCloud Pantalla HELLO — Cobertura Global — Precios Competitivos — Seguridad y Confianza —</span>
        </div>
    </div>
</div>
    <script>
    (function(){
        var sets = {
            banner1: [
                '✔ ⚡ PANEL FMI OFF DE RAIZ - DRAGON SERVER - DISPONIBLE MUNDIAL ⚡ ✓ — SOPORTE 24/7 — ENTREGA RÁPIDA — DESCUENTOS PARA MAYORISTAS — PRUEBAS DISPONIBLES —',
                '✓ Seguridad empresarial — Integraciones API — Atención Prioritaria — Entrega Estimada en Tiempo Real — Actualizaciones Constantes —'
            ],
            banner2: [
                'LIBERACIÓN DE RED USA — T‑Mobile — AT&T — Cricket — US Reseller Flex — Boost Mobile — Xfinity — POLÍTICAS ACTUALIZADAS — RESULTADOS GARANTIZADOS —',
                'SERVICIOS DE OPERADOR — Verificación IMEI — Consultas GSX — Soporte Multi-Carrier — Promociones Semanales —'
            ],
            banner3: [
                '💜 ✨ ⭐ BYPASS FULL WIFI — iPhone XR al 15 Pro Max — Eliminar iCloud Pantalla HELLO — Cobertura Global — Precios Competitivos — Seguridad y Confianza —',
                '🔒 Soluciones Avanzadas — Altas tasas de éxito — Documentación clara — Equipo experto —'
            ]
        };
        function updateBanner(id){
            var el = document.getElementById(id);
            if(!el) return;
            var data = sets[id];
        data.push(data.shift());
            el.innerHTML = '<span class="marquee-track">'+data[0]+'</span><span class="marquee-track">'+data[0]+'</span>';
        }
        setInterval(function(){ updateBanner('banner1'); }, 20000);
        setInterval(function(){ updateBanner('banner2'); }, 22000);
        setInterval(function(){ updateBanner('banner3'); }, 24000);
    })();
    </script>

<!-- LÍNEA 1: CONTACTOS / REDES -->
<div class="nav-contact-bar-horizontal">
 <div class="container contacts-horizontal-row">
    <span class="chip"><span class="chip-icon">💬</span> <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/','', $whatsapp); ?>" target="_blank">WhatsApp</a></span>
    <span class="chip"><span class="chip-icon">✉️</span> <a href="mailto:<?php echo $contact_email; ?>">Email</a></span>
    <span class="chip"><span class="chip-icon">🌐</span> <?php echo $social_handle; ?></span>
    <a href="<?php echo $telegram_group_url; ?>" class="chip" target="_blank">👥 Telegram</a>
    <a href="<?php echo $telegram_channel_url; ?>" class="chip" target="_blank">📢 Canal</a>
        </div>
    </div>

<!-- LÍNEA 2: MENÚ PRINCIPAL HORIZONTAL CON SUBMENÚS + LOGO -->
<nav class="horizontal-main-menu nav-highlight">
  <div class="container menu-flex-row">
    <div class="mainmenu-logo-block">
      <a href="<?php echo site_url('member/dashboard'); ?>" class="mainlogo-link">
        <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo" class="mainlogo-img">
                        </a>
                    </div>
    <ul class="main-horizontal-menu">
      <li><a href="<?php echo site_url('member/dashboard'); ?>">🏠 Dashboard</a></li>
      <li class="dropdown">
        <a href="#">📝 Registrar Servicio <span>▼</span></a>
        <ul class="submenu">
          <li><a href="<?php echo site_url('member/imeirequest'); ?>">📱 Servicios IMEI Premium</a></li>
          <li><a href="<?php echo site_url('member/fileservices'); ?>">💻 Servicios Server / Tools</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#">📋 Historial <span>▼</span></a>
        <ul class="submenu">
          <li><a href="<?php echo site_url('member/imeirequest/history'); ?>">📱 Historial IMEI</a></li>
          <li><a href="<?php echo site_url('member/fileservices/history'); ?>">💻 Historial Servidores</a></li>
        </ul>
                                </li>
      <li><a href="<?php echo site_url('member/dashboard/addfund'); ?>">⚡ Recargar Crédito</a></li>
                                        </ul>
    <div class="user-box">
        <span class="avatar-badge"><?php echo strtoupper(substr($member_name, 0, 1)); ?></span>
        <span class="user-name-trunc"> <?php echo htmlspecialchars($member_name); ?> </span>
        <span class="user-balance-mini">$ <?php echo $balance; ?></span>
        <a href="<?php echo site_url('logout'); ?>" class="logout-mini" title="Cerrar sesión">⎋</a>
    </div>
                                    </div>
</nav>

<!-- LÍNEA 3: ACCESOS RÁPIDOS, BARRA COLORIDA, CADA UNO CON SUBMENÚ DROPDOWN -->
<div class="nav-quick-services-bar">
    <div class="container quickaccess-flex-row">
        <ul class="quick-services-menu">
          <li class="dropdown">
            <a href="#">📱 Premium IMEI <span>▼</span></a>
            <ul class="submenu">
              <li><a href="<?php echo site_url('member/imeirequest'); ?>">📱 Ver Servicios IMEI</a></li>
              <li><a href="<?php echo site_url('member/imeirequest/history'); ?>">📋 Historial IMEI</a></li>
            </ul>
                                </li>
          <li class="dropdown">
            <a href="#">💻 Server Express <span>▼</span></a>
            <ul class="submenu">
              <li><a href="<?php echo site_url('member/fileservices'); ?>">💻 Ver Servicios Server</a></li>
              <li><a href="<?php echo site_url('member/fileservices/history'); ?>">📋 Historial Server</a></li>
            </ul>
                                </li>
          <li class="dropdown">
            <a href="#">📊 Historial Rápido <span>▼</span></a>
            <ul class="submenu">
              <li><a href="<?php echo site_url('member/imeirequest/history'); ?>">📱 IMEI Recientes</a></li>
              <li><a href="<?php echo site_url('member/fileservices/history'); ?>">💻 Servidores Recientes</a></li>
              <li><a href="<?php echo site_url('member/dashboard'); ?>">📋 Ver Todo</a></li>
                                        </ul>
                                </li>
          <li class="dropdown">
            <a href="#">⚡ Recargar <span>▼</span></a>
            <ul class="submenu">
              <li><a href="<?php echo site_url('member/dashboard/addfund'); ?>">💰 Agregar Crédito</a></li>
              <li><a href="<?php echo site_url('member/dashboard'); ?>">📊 Ver Balance</a></li>
                                        </ul>
                                </li>
                            </ul>
                    </div>
                </div>

<!-- LÍNEA 4: BREADCRUMB -->
<div class="nav-breadcrumb-bar">
    <div class="container">
        <ol class="breadcrumb">
            <li>You Are Here</li>
            <li><a href="<?php echo site_url('member/dashboard'); ?>">Home</a></li>
            <?php if(isset($breadcrumb_secondary)) echo $breadcrumb_secondary; ?>
        </ol>
    </div>
</div>

<div class="container">    
<?php $this->load->view($template); ?>
</div>
<footer class="home-footer">
  <div class="footer-main">
    <div class="container">
      <div class="footer-grid">
        <!-- Columna 1: Sobre Nosotros -->
        <div class="footer-col">
          <h4 class="footer-title">💎 NachoTechRD</h4>
          <p class="footer-desc">
            Proveedor líder de servicios IMEI premium, liberación de red, bypass iCloud y soluciones móviles profesionales. Confianza, rapidez y soporte 24/7.
          </p>
          <div class="footer-social">
            <a href="<?php echo $telegram_group_url; ?>" target="_blank" class="social-btn" title="Telegram Grupo">
              <span>👥</span> Grupo
            </a>
            <a href="<?php echo $telegram_channel_url; ?>" target="_blank" class="social-btn" title="Telegram Canal">
              <span>📢</span> Canal
            </a>
          </div>
        </div>

        <!-- Columna 2: Enlaces Rápidos -->
        <div class="footer-col">
          <h4 class="footer-title">🔗 Enlaces Rápidos</h4>
          <ul class="footer-links">
            <li><a href="<?php echo site_url('member/dashboard'); ?>">🏠 Dashboard</a></li>
            <li><a href="<?php echo site_url('member/imeirequest'); ?>">⭐ Servicios IMEI</a></li>
            <li><a href="<?php echo site_url('member/imeirequest/history'); ?>">📋 Historial IMEI</a></li>
            <li><a href="<?php echo site_url('member/fileservices/history'); ?>">💻 Historial Servidores</a></li>
            <li><a href="<?php echo site_url('member/dashboard/addfund'); ?>">⚡ Recargar Crédito</a></li>
          </ul>
        </div>

        <!-- Columna 3: Servicios -->
        <div class="footer-col">
          <h4 class="footer-title">🛠️ Nuestros Servicios</h4>
          <ul class="footer-links">
            <li><a href="<?php echo site_url('member/imeirequest'); ?>">🔓 Liberación de Red</a></li>
            <li><a href="<?php echo site_url('member/imeirequest'); ?>">📱 Bypass iCloud</a></li>
            <li><a href="<?php echo site_url('member/imeirequest'); ?>">🔧 FRP / Google Lock</a></li>
            <li><a href="<?php echo site_url('member/imeirequest'); ?>">💼 Soluciones Empresariales</a></li>
            <li><a href="<?php echo site_url('member/imeirequest'); ?>">🚀 API Integration</a></li>
          </ul>
        </div>

        <!-- Columna 4: Contacto -->
        <div class="footer-col">
          <h4 class="footer-title">📞 Contacto</h4>
          <ul class="footer-contact">
            <li>
              <span class="contact-icon">💬</span>
              <div>
                <strong>WhatsApp</strong>
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/','', $whatsapp); ?>" target="_blank">
                  +<?php echo preg_replace('/[^0-9]/','', $whatsapp); ?>
                </a>
              </div>
            </li>
            <li>
              <span class="contact-icon">✉️</span>
              <div>
                <strong>Email</strong>
                <a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a>
              </div>
            </li>
            <li>
              <span class="contact-icon">🌐</span>
              <div>
                <strong>Social</strong>
                <span><?php echo $social_handle; ?></span>
              </div>
            </li>
            <li>
              <span class="contact-icon">⏰</span>
              <div>
                <strong>Soporte</strong>
                <span>24/7 Disponible</span>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Barra inferior -->
      <div class="footer-bottom">
        <div class="footer-bottom-content">
          <p class="footer-copyright">
            © <?php echo date('Y'); ?> <strong>NachoTechRD</strong> - Todos los derechos reservados. 
            <span class="footer-badge">🔒 Seguro</span>
            <span class="footer-badge">✅ Verificado</span>
            <span class="footer-badge">⚡ Rápido</span>
          </p>
          <p class="footer-legal">
            <a href="#">Términos de Servicio</a> • 
            <a href="#">Política de Privacidad</a> • 
            <a href="#">Reembolsos</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.cookie.js'></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/bootstrap.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>
<!--[if IE]><script type="text/javascript" src="excanvas.js"></script><![endif]-->
<script src="<?php echo base_url(); ?>js/jquery.knob.js"></script>
<script type="text/javascript" charset="utf-8">
var asInitVals = new Array();
    
$(document).ready(function() {
    var oTable = $('#example2').dataTable( {
        "oLanguage": {
            "sSearch": "Search all columns:"
        }
    } );
    
    $("tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
    
    
    
    /*
        * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
        * the footer
        */
    $("tfoot input").each( function (i) {
        asInitVals[i] = this.value;
    } );
    
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
    
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );
    
    
} );
$(document).ready(function() {
    var oTable = $('#example').dataTable( {
        "oLanguage": {
            "sSearch": "Search all columns:"
        }
    } );
    
    $("tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
    
    
    
    /*
        * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
        * the footer
        */
    $("tfoot input").each( function (i) {
        asInitVals[i] = this.value;
    } );
    
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
    
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );
    
    
} );
    
    
</script>
<script>
(function(){
    // Hero carousel eliminado (no relevante en este archivo)
    // Mejorar notificación bienvenida
    var isMember = '<?php echo $this->uri->segment(1); ?>' === 'member';
    if(!isMember) return;
    function qs(id){ return document.getElementById(id); }
    if(!qs('modalWelcome')){
        var wrap1 = document.createElement('div');
        wrap1.id = 'modalWelcome';
        wrap1.className = 'modal-overlay';
        var memberName = <?php echo json_encode($member_name); ?>;
        var memberEmail = <?php echo json_encode($member_email); ?>;
        var balanceAmount = <?php echo json_encode($balance); ?>;
        var lastAccess = <?php echo json_encode(date('Y-m-d H:i')); ?>;
        var dashboardUrl = <?php echo json_encode(site_url('member/dashboard')); ?>;
        var historyUrl = <?php echo json_encode(site_url('member/imeirequest/history')); ?>;
        var telegramUrl = <?php echo json_encode($telegram_channel_url); ?>;
        
        wrap1.innerHTML = 
        '<div class="modal-card">' +
            '<div class="modal-header">✔ ¡Hola ' + memberName + ', Bienvenido a NachoTechRD!</div>' +
            '<div class="modal-body">' +
                '<p><b>Balance actual:</b> $' + balanceAmount + ' <br>' +
                '<b>Último acceso:</b> ' + lastAccess + ' <br>' +
                '<b>Pedidos activos:</b> <span id="pedidosActivosModal"></span><br>' +
                '<b>Email:</b> ' + memberEmail +
                '</p>' +
                '<ul style="margin:8px 0 10px 18px; color:#14b8a6;">' +
                  '<li>💡 Tip: ¿Necesitas ayuda? <a href="' + dashboardUrl + '">Ver panel de ayuda</a></li>' +
                  '<li>🚀 Ve a tus <a href="' + historyUrl + '"><b>últimos pedidos</b></a></li>' +
                  '<li>🔔 Unete al <a href="' + telegramUrl + '" target="_blank">Telegram de Noticias</a></li>' +
                '</ul>' +
            '</div>' +
            '<div class="modal-actions">' +
                '<button class="btn-modal secondary" id="mwClose">Cerrar</button>' +
            '</div>' +
        '</div>';
        document.body.appendChild(wrap1);
    }
    var shownKey = 'nachotech_member_modals_v2';
    if(localStorage.getItem(shownKey)==='1') return;
    var mw = document.getElementById('modalWelcome');
    function open(el){ el.classList.add('active'); }
    function close(el){ el.classList.remove('active'); }
    open(mw);
    qs('mwClose').onclick = function(){ close(mw); localStorage.setItem(shownKey,'1'); };
    mw.addEventListener('click', function(e){ if(e.target===mw){ close(mw); localStorage.setItem(shownKey,'1'); } });
    // Ajax para total pedidos activos
    fetch('<?php echo site_url('member/imeirequest/get_orders_list'); ?>?status=Pending').then(r=>r.json()).then(function(data){
      var el = document.getElementById('pedidosActivosModal');
      if(el && data.data) el.textContent = data.data.length;
    });
})();
</script>
</body>       
</html>