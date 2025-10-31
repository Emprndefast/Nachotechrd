<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>NACHOTECHRD - <?php echo $title; ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		
		body {
			font-family: 'Inter', 'Segoe UI', sans-serif;
			background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
			position: relative;
			overflow-x: hidden;
		}
		
		/* Animated Background Circles */
		body::before {
			content: '';
			position: fixed;
			width: 600px;
			height: 600px;
			background: radial-gradient(circle, rgba(14,165,233,0.15) 0%, transparent 70%);
			border-radius: 50%;
			top: -300px;
			right: -300px;
			animation: float 20s ease-in-out infinite;
			z-index: 0;
		}
		
		body::after {
			content: '';
			position: fixed;
			width: 500px;
			height: 500px;
			background: radial-gradient(circle, rgba(16,185,129,0.12) 0%, transparent 70%);
			border-radius: 50%;
			bottom: -250px;
			left: -250px;
			animation: float 15s ease-in-out infinite reverse;
			z-index: 0;
		}
		
		@keyframes float {
			0%, 100% { transform: translate(0, 0) scale(1); }
			50% { transform: translate(100px, 100px) scale(1.1); }
		}
		
		.auth-container {
			width: 100%;
			max-width: 480px;
			position: relative;
			z-index: 1;
		}
		
		.auth-card {
			background: rgba(255, 255, 255, 0.98);
			backdrop-filter: blur(20px);
			border-radius: 24px;
			padding: 45px 40px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			border: 1px solid rgba(255, 255, 255, 0.1);
		}
		
		.auth-logo {
			text-align: center;
			margin-bottom: 35px;
		}
		
		.auth-logo h1 {
			font-size: 32px;
			font-weight: 900;
			background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
			margin-bottom: 8px;
		}
		
		.auth-logo p {
			color: #64748b;
			font-size: 15px;
			font-weight: 600;
		}
		
		.auth-title {
			font-size: 28px;
			font-weight: 900;
			color: #0f172a;
			margin-bottom: 10px;
			text-align: center;
		}
		
		.auth-subtitle {
			color: #64748b;
			font-size: 15px;
			margin-bottom: 30px;
			text-align: center;
		}
		
		.alert {
			padding: 14px 18px;
			border-radius: 12px;
			margin-bottom: 25px;
			font-size: 14px;
			font-weight: 600;
		}
		
		.alert-success {
			background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
			color: #065f46;
			border: 1px solid #10b981;
		}
		
		.alert-danger {
			background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
			color: #991b1b;
			border: 1px solid #ef4444;
		}
		
		.alert-info {
			background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
			color: #1e3a8a;
			border: 1px solid #3b82f6;
		}
		
		.form-group {
			margin-bottom: 22px;
		}
		
		.form-group label {
			display: block;
			color: #0f172a;
			font-weight: 700;
			font-size: 14px;
			margin-bottom: 8px;
		}
		
		.form-control {
			width: 100%;
			padding: 14px 18px;
			border: 2px solid #e2e8f0;
			border-radius: 12px;
			font-size: 15px;
			font-weight: 500;
			transition: all 0.3s;
			background: #f8fafc;
		}
		
		.form-control:focus {
			outline: none;
			border-color: #0ea5e9;
			background: #fff;
			box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
		}
		
		.form-control::placeholder {
			color: #94a3b8;
		}
		
		.btn-primary-auth {
			width: 100%;
			padding: 16px;
			background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
			color: #fff;
			border: none;
			border-radius: 12px;
			font-size: 16px;
			font-weight: 800;
			cursor: pointer;
			transition: all 0.3s;
			box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
			margin-top: 10px;
		}
		
		.btn-primary-auth:hover {
			transform: translateY(-2px);
			box-shadow: 0 12px 30px rgba(14, 165, 233, 0.4);
		}
		
		.btn-primary-auth:active {
			transform: translateY(0);
		}
		
		.auth-links {
			margin-top: 30px;
			padding-top: 25px;
			border-top: 1px solid #e2e8f0;
			text-align: center;
		}
		
		.auth-links-grid {
			display: flex;
			justify-content: center;
			gap: 25px;
			flex-wrap: wrap;
		}
		
		.auth-links a {
			color: #0ea5e9;
			text-decoration: none;
			font-weight: 700;
			font-size: 14px;
			transition: all 0.3s;
		}
		
		.auth-links a:hover {
			color: #0284c7;
			text-decoration: underline;
		}
		
		.auth-footer {
			text-align: center;
			margin-top: 25px;
			color: #fff;
			font-size: 13px;
		}
		
		.auth-footer a {
			color: #0ea5e9;
			text-decoration: none;
			font-weight: 600;
		}
		
		.auth-footer a:hover {
			text-decoration: underline;
		}
		
		.form-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 15px;
		}
		
		@media (max-width: 600px) {
			.auth-card {
				padding: 35px 25px;
			}
			
			.auth-logo h1 {
				font-size: 28px;
			}
			
			.auth-title {
				font-size: 24px;
			}
			
			.form-row {
				grid-template-columns: 1fr;
			}
		}
	</style>
</head>
<body>
	<div class="auth-container">
		<div class="auth-card">
			<div class="auth-logo">
				<h1>💎 NACHOTECHRD</h1>
				<p>Plataforma Premium de Desbloqueo</p>
			</div>
			
			<?php $this->load->view($master_template); ?>
			
			<div class="auth-links">
				<div class="auth-links-grid">
					<?php if($this->uri->segment(1) == "login"): ?>
						<a href="<?php echo site_url('forgot_password'); ?>">🔑 ¿Olvidaste tu contraseña?</a>
						<a href="<?php echo site_url('register'); ?>">📝 Crear Cuenta</a>
					<?php else: ?>
						<a href="<?php echo site_url('login'); ?>">🔐 Iniciar Sesión</a>
					<?php endif; ?>
					<a href="<?php echo site_url(); ?>">🏠 Volver al Inicio</a>
				</div>
			</div>
		</div>
		
		<div class="auth-footer">
			<p>&copy; <?php echo date('Y'); ?> NACHOTECHRD. Todos los derechos reservados.</p>
			<p style="margin-top: 8px;">
				<a href="#">Términos</a> • 
				<a href="#">Privacidad</a> • 
				<a href="https://wa.me/18093408435" target="_blank">Soporte WhatsApp</a>
			</p>
		</div>
	</div>
</body>
</html>
