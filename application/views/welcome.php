<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>NACHOTECHRD - Líder en Servicios de Desbloqueo Premium</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		
		body {
			font-family: 'Inter', 'Segoe UI', sans-serif;
			background: #0f172a;
			color: #fff;
			overflow-x: hidden;
		}
		
		/* Animated Background */
		.animated-bg {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
			z-index: -1;
		}
		
		.animated-bg::before {
			content: '';
			position: absolute;
			width: 500px;
			height: 500px;
			background: radial-gradient(circle, rgba(14,165,233,0.15) 0%, transparent 70%);
			border-radius: 50%;
			top: -250px;
			right: -250px;
			animation: float 20s ease-in-out infinite;
		}
		
		.animated-bg::after {
			content: '';
			position: absolute;
			width: 400px;
			height: 400px;
			background: radial-gradient(circle, rgba(16,185,129,0.12) 0%, transparent 70%);
			border-radius: 50%;
			bottom: -200px;
			left: -200px;
			animation: float 15s ease-in-out infinite reverse;
		}
		
		@keyframes float {
			0%, 100% { transform: translate(0, 0) scale(1); }
			50% { transform: translate(100px, 100px) scale(1.1); }
		}
		
		/* Header */
		.landing-header {
			background: rgba(15, 23, 42, 0.95);
			backdrop-filter: blur(10px);
			padding: 20px 0;
			box-shadow: 0 2px 20px rgba(0,0,0,0.3);
			position: sticky;
			top: 0;
			z-index: 100;
			border-bottom: 1px solid rgba(14,165,233,0.2);
		}
		
		.header-container {
			max-width: 1280px;
			margin: 0 auto;
			padding: 0 30px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		
		.logo {
			font-size: 28px;
			font-weight: 900;
			color: #fff;
			text-decoration: none;
			letter-spacing: 1px;
			background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
		}
		
		.nav-links {
			display: flex;
			gap: 35px;
			align-items: center;
		}
		
		.nav-links a {
			color: #cbd5e1;
			text-decoration: none;
			font-size: 15px;
			font-weight: 600;
			transition: all 0.3s;
		}
		
		.nav-links a:hover {
			color: #0ea5e9;
		}
		
		.btn-header {
			background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
			color: #fff;
			padding: 10px 24px;
			border-radius: 8px;
			font-weight: 700;
			box-shadow: 0 4px 15px rgba(14,165,233,0.3);
		}
		
		.btn-header:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(14,165,233,0.4);
			color: #fff;
		}
		
		/* Hero Section */
		.hero {
			padding: 120px 30px 80px;
			text-align: center;
		}
		
		.hero-container {
			max-width: 1100px;
			margin: 0 auto;
		}
		
		.hero-badge {
			display: inline-block;
			background: rgba(16, 185, 129, 0.15);
			color: #10b981;
			padding: 8px 20px;
			border-radius: 30px;
			font-size: 14px;
			font-weight: 700;
			margin-bottom: 25px;
			border: 1px solid rgba(16, 185, 129, 0.3);
		}
		
		.hero h1 {
			font-size: 68px;
			font-weight: 900;
			line-height: 1.1;
			margin-bottom: 25px;
			background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
		}
		
		.hero h1 .gradient-text {
			background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
		}
		
		.hero p {
			font-size: 20px;
			color: #94a3b8;
			max-width: 700px;
			margin: 0 auto 45px;
			line-height: 1.7;
		}
		
		.cta-buttons {
			display: flex;
			gap: 20px;
			justify-content: center;
			flex-wrap: wrap;
			margin-bottom: 60px;
		}
		
		.btn-primary {
			background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
			color: #fff;
			padding: 18px 45px;
			font-size: 17px;
			font-weight: 700;
			border-radius: 12px;
			text-decoration: none;
			display: inline-block;
			transition: all 0.3s;
			box-shadow: 0 8px 25px rgba(14,165,233,0.35);
		}
		
		.btn-primary:hover {
			transform: translateY(-3px);
			box-shadow: 0 12px 35px rgba(14,165,233,0.45);
			color: #fff;
		}
		
		.btn-secondary {
			background: rgba(255, 255, 255, 0.05);
			color: #fff;
			padding: 18px 45px;
			font-size: 17px;
			font-weight: 700;
			border: 2px solid rgba(255, 255, 255, 0.2);
			border-radius: 12px;
			text-decoration: none;
			display: inline-block;
			transition: all 0.3s;
			backdrop-filter: blur(10px);
		}
		
		.btn-secondary:hover {
			background: rgba(255, 255, 255, 0.1);
			border-color: #0ea5e9;
			transform: translateY(-3px);
			color: #fff;
		}
		
		/* Stats Section */
		.stats {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 30px;
			max-width: 1000px;
			margin: 0 auto;
			padding: 0 30px;
		}
		
		.stat-card {
			background: rgba(255, 255, 255, 0.03);
			border: 1px solid rgba(255, 255, 255, 0.08);
			padding: 30px 20px;
			border-radius: 16px;
			text-align: center;
			backdrop-filter: blur(10px);
			transition: all 0.3s;
		}
		
		.stat-card:hover {
			background: rgba(255, 255, 255, 0.05);
			border-color: rgba(14, 165, 233, 0.3);
			transform: translateY(-5px);
		}
		
		.stat-number {
			font-size: 42px;
			font-weight: 900;
			background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
			margin-bottom: 8px;
		}
		
		.stat-label {
			color: #94a3b8;
			font-size: 15px;
			font-weight: 600;
		}
		
		/* Features Section */
		.features-section {
			padding: 100px 30px;
		}
		
		.section-title {
			text-align: center;
			font-size: 48px;
			font-weight: 900;
			margin-bottom: 60px;
		}
		
		.features-grid {
			max-width: 1200px;
			margin: 0 auto;
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
			gap: 30px;
		}
		
		.feature-card {
			background: rgba(255, 255, 255, 0.03);
			border: 1px solid rgba(255, 255, 255, 0.08);
			padding: 40px 30px;
			border-radius: 20px;
			transition: all 0.3s;
			backdrop-filter: blur(10px);
		}
		
		.feature-card:hover {
			background: rgba(255, 255, 255, 0.05);
			border-color: rgba(14, 165, 233, 0.3);
			transform: translateY(-8px);
			box-shadow: 0 15px 40px rgba(14, 165, 233, 0.2);
		}
		
		.feature-icon {
			font-size: 52px;
			margin-bottom: 20px;
		}
		
		.feature-card h3 {
			font-size: 24px;
			font-weight: 800;
			margin-bottom: 15px;
			color: #f1f5f9;
		}
		
		.feature-card p {
			color: #94a3b8;
			line-height: 1.7;
			font-size: 15px;
		}
		
		/* Services Section */
		.services-section {
			padding: 80px 30px;
			background: rgba(255, 255, 255, 0.02);
		}
		
		.services-grid {
			max-width: 1100px;
			margin: 0 auto;
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
			gap: 25px;
		}
		
		.service-item {
			background: linear-gradient(135deg, rgba(14, 165, 233, 0.08) 0%, rgba(16, 185, 129, 0.08) 100%);
			border: 1px solid rgba(14, 165, 233, 0.2);
			padding: 25px;
			border-radius: 15px;
			display: flex;
			align-items: center;
			gap: 15px;
			transition: all 0.3s;
		}
		
		.service-item:hover {
			transform: translateX(10px);
			border-color: #0ea5e9;
			background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(16, 185, 129, 0.15) 100%);
		}
		
		.service-icon {
			font-size: 32px;
		}
		
		.service-name {
			font-weight: 700;
			color: #f1f5f9;
		}
		
		/* Footer */
		.landing-footer {
			background: rgba(15, 23, 42, 0.95);
			padding: 50px 30px 30px;
			margin-top: 80px;
			border-top: 1px solid rgba(255, 255, 255, 0.08);
		}
		
		.footer-content {
			max-width: 1200px;
			margin: 0 auto;
			text-align: center;
		}
		
		.footer-content p {
			color: #64748b;
			margin-bottom: 20px;
		}
		
		.footer-links {
			display: flex;
			justify-content: center;
			gap: 30px;
			flex-wrap: wrap;
			margin-bottom: 30px;
		}
		
		.footer-links a {
			color: #94a3b8;
			text-decoration: none;
			font-size: 14px;
			transition: color 0.3s;
		}
		
		.footer-links a:hover {
			color: #0ea5e9;
		}
		
	/* Services Carousel */
	.services-carousel {
		padding: 80px 30px;
		background: rgba(15, 23, 42, 0.6);
		backdrop-filter: blur(10px);
		margin: 60px 0;
		border-top: 1px solid rgba(14,165,233,0.2);
		border-bottom: 1px solid rgba(14,165,233,0.2);
	}
	
	.carousel-container {
		max-width: 1400px;
		margin: 0 auto;
		position: relative;
	}
	
	.carousel-title {
		text-align: center;
		font-size: 48px;
		font-weight: 900;
		margin-bottom: 60px;
		background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		background-clip: text;
	}
	
	.carousel-wrapper {
		position: relative;
		overflow: hidden;
		border-radius: 24px;
		padding: 30px 0;
	}
	
	.carousel-track {
		display: flex;
		transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
		gap: 30px;
	}
	
	.carousel-slide {
		min-width: calc(33.333% - 20px);
		flex-shrink: 0;
		background: linear-gradient(135deg, rgba(14,165,233,0.15) 0%, rgba(16,185,129,0.15) 100%);
		border: 2px solid rgba(14,165,233,0.3);
		border-radius: 20px;
		padding: 35px;
		text-align: center;
		transition: all 0.4s;
		position: relative;
		overflow: hidden;
	}
	
	.carousel-slide::before {
		content: '';
		position: absolute;
		top: -50%;
		left: -50%;
		width: 200%;
		height: 200%;
		background: radial-gradient(circle, rgba(14,165,233,0.25) 0%, transparent 70%);
		opacity: 0;
		transition: opacity 0.4s;
	}
	
	.carousel-slide:hover::before {
		opacity: 1;
	}
	
	.carousel-slide:hover {
		transform: translateY(-10px);
		border-color: #0ea5e9;
		box-shadow: 0 20px 50px rgba(14,165,233,0.4);
	}
	
	.carousel-slide img {
		width: 100%;
		max-width: 300px;
		height: 190px;
		object-fit: contain;
		border-radius: 16px;
		margin-bottom: 25px;
		position: relative;
		z-index: 1;
		background: rgba(255,255,255,0.03);
		padding: 15px;
		border: 1px solid rgba(255,255,255,0.1);
	}
	
	.carousel-slide h3 {
		font-size: 24px;
		font-weight: 800;
		color: #fff;
		margin-bottom: 12px;
		position: relative;
		z-index: 1;
	}
	
	.carousel-slide p {
		font-size: 14px;
		color: #94a3b8;
		line-height: 1.6;
		position: relative;
		z-index: 1;
	}
	
	.carousel-controls {
		display: flex;
		justify-content: center;
		gap: 20px;
		margin-top: 50px;
	}
	
	.carousel-btn {
		background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
		border: none;
		width: 60px;
		height: 60px;
		border-radius: 50%;
		color: #fff;
		font-size: 28px;
		cursor: pointer;
		transition: all 0.3s;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 6px 20px rgba(14,165,233,0.4);
	}
	
	.carousel-btn:hover {
		transform: scale(1.15);
		box-shadow: 0 8px 30px rgba(14,165,233,0.6);
	}
	
	.carousel-btn:active {
		transform: scale(0.95);
	}
	
	.carousel-indicators {
		display: flex;
		justify-content: center;
		gap: 12px;
		margin-top: 35px;
	}
	
	.indicator {
		width: 14px;
		height: 14px;
		border-radius: 50%;
		background: rgba(148,163,184,0.4);
		cursor: pointer;
		transition: all 0.3s;
		border: 2px solid transparent;
	}
	
	.indicator:hover {
		background: rgba(148,163,184,0.7);
	}
	
	.indicator.active {
		background: #0ea5e9;
		width: 40px;
		border-radius: 7px;
		box-shadow: 0 0 15px rgba(14,165,233,0.6);
	}
	
	@media (max-width: 1024px) {
		.carousel-slide {
			min-width: calc(50% - 15px);
		}
		
		.carousel-title {
			font-size: 38px;
		}
	}
	
	@media (max-width: 768px) {
		.hero h1 { font-size: 42px; }
		.hero p { font-size: 18px; }
		.section-title { font-size: 36px; }
		.nav-links { display: none; }
		
		.carousel-slide {
			min-width: 100%;
		}
		
		.carousel-title {
			font-size: 32px;
		}
		
		.carousel-slide img {
			max-width: 250px;
			height: 160px;
		}
		
		.carousel-btn {
			width: 50px;
			height: 50px;
			font-size: 24px;
		}
		
		.services-carousel {
			padding: 60px 20px;
		}
	}
	</style>
</head>
<body>
	<div class="animated-bg"></div>
	
	<!-- Header -->
	<header class="landing-header">
		<div class="header-container">
			<a href="<?php echo site_url(); ?>" class="logo">💎 NACHOTECHRD</a>
			<div class="nav-links">
				<a href="#servicios">Servicios</a>
				<a href="#caracteristicas">Características</a>
				<a href="<?php echo site_url('login'); ?>" class="btn-header">Iniciar Sesión</a>
			</div>
		</div>
	</header>
	
	<!-- Hero -->
	<section class="hero">
		<div class="hero-container">
			<div class="hero-badge">✨ Plataforma Premium de Desbloqueo</div>
			<h1>
				Desbloquea el Poder de<br>
				<span class="gradient-text">Servicios IMEI Premium</span>
			</h1>
			<p>
				Plataforma líder en servicios de desbloqueo profesional, bypass iCloud, liberación de red y soluciones móviles avanzadas. 
				Tecnología de última generación, soporte 24/7 y entregas rápidas.
			</p>
			<div class="cta-buttons">
				<a href="<?php echo site_url('login'); ?>" class="btn-primary">🚀 Comenzar Ahora</a>
				<a href="<?php echo site_url('register'); ?>" class="btn-secondary">📝 Crear Cuenta Gratis</a>
			</div>
			
			<!-- Stats -->
			<div class="stats">
				<div class="stat-card">
					<div class="stat-number">15K+</div>
					<div class="stat-label">Clientes Satisfechos</div>
				</div>
				<div class="stat-card">
					<div class="stat-number">50K+</div>
					<div class="stat-label">Servicios Procesados</div>
				</div>
				<div class="stat-card">
					<div class="stat-number">98%</div>
					<div class="stat-label">Tasa de Éxito</div>
				</div>
				<div class="stat-card">
					<div class="stat-number">24/7</div>
					<div class="stat-label">Soporte Disponible</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Services Carousel -->
	<section class="services-carousel">
		<div class="carousel-container">
			<h2 class="carousel-title">🚀 Nuestras Herramientas Premium</h2>
			
			<div class="carousel-wrapper">
				<div class="carousel-track" id="carouselTrack">
					<!-- Slide 1 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/A12HFZ.png" alt="HFZ Activator">
						<h3>HFZ Activator</h3>
						<p>La nueva era del bypass iCloud. Compatible con iPhone XR, iPhone 16 Pro Max y iPads. Windows y macOS.</p>
					</div>
					
					<!-- Slide 2 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/A12iRemovalPRO.png" alt="iRemoval PRO">
						<h3>iRemoval PRO</h3>
						<p>Solución profesional para bypass Hello 15 Pro & 15 Pro Max. Compatible con Windows y macOS.</p>
					</div>
					
					<!-- Slide 3 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/A12iRemoveTools.png" alt="iRemove Tools">
						<h3>iRemove Tools</h3>
						<p>Herramientas avanzadas de bypass para dispositivos iOS. Soporte multiplataforma Windows y macOS.</p>
					</div>
					
					<!-- Slide 4 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/A12Minacriss.png" alt="Minacriss">
						<h3>Minacriss MacBook</h3>
						<p>Bypass iCloud 1 Click - Fast para MacBook. Sin cambiar serial, rápido y efectivo.</p>
					</div>
					
					<!-- Slide 5 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/A12Otix.png" alt="Otix Activator">
						<h3>Otix Activator</h3>
						<p>Activador premium para MacBook. Bypass iCloud profesional con soporte completo.</p>
					</div>
					
					<!-- Slide 6 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/A12Signal.png" alt="Signal">
						<h3>Signal</h3>
						<p>Bypass Hello Signal para iPhone 15 Pro & 15 Pro Max. Compatible con Windows y macOS.</p>
					</div>
					
					<!-- Slide 7 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/A12SMD.png" alt="SMD Activator">
						<h3>SMD Activator</h3>
						<p>iCloud Bypass Software Activator Pro para MacBook. Solución profesional y confiable.</p>
					</div>
					
					<!-- Slide 8 -->
					<div class="carousel-slide">
						<img src="<?php echo base_url(); ?>assets/img/BypassWifi.png" alt="Bypass Wifi">
						<h3>Bypass WiFi</h3>
						<p>Bypass iCloud 1 Click Fast para Windows y MacBook. Sin cambiar serial, proceso rápido.</p>
					</div>
				</div>
			</div>
			
			<!-- Controls -->
			<div class="carousel-controls">
				<button class="carousel-btn" onclick="prevSlide()">&#8249;</button>
				<button class="carousel-btn" onclick="nextSlide()">&#8250;</button>
			</div>
			
			<!-- Indicators -->
			<div class="carousel-indicators" id="carouselIndicators"></div>
		</div>
	</section>
	
	<!-- Features -->
	<section class="features-section" id="caracteristicas">
		<h2 class="section-title">🌟 ¿Por Qué Elegirnos?</h2>
		<div class="features-grid">
			<div class="feature-card">
				<div class="feature-icon">⚡</div>
				<h3>Entrega Ultrarrápida</h3>
				<p>Procesamiento automático en tiempo real. La mayoría de servicios se completan en minutos, no horas.</p>
			</div>
			<div class="feature-card">
				<div class="feature-icon">🔒</div>
				<h3>100% Seguro y Confiable</h3>
				<p>Transacciones encriptadas, datos protegidos y garantía de satisfacción en todos nuestros servicios.</p>
			</div>
			<div class="feature-card">
				<div class="feature-icon">💰</div>
				<h3>Precios Competitivos</h3>
				<p>Mejores tarifas del mercado con descuentos para mayoristas y API disponible para integraciones.</p>
			</div>
			<div class="feature-card">
				<div class="feature-icon">🌐</div>
				<h3>Cobertura Global</h3>
				<p>Servicios para operadoras de todo el mundo. Soporte para más de 200 países y 1000+ carriers.</p>
			</div>
			<div class="feature-card">
				<div class="feature-icon">🎯</div>
				<h3>Alta Tasa de Éxito</h3>
				<p>98% de tasa de éxito garantizada. Si no funciona, reembolso completo sin preguntas.</p>
			</div>
			<div class="feature-card">
				<div class="feature-icon">👨‍💻</div>
				<h3>Soporte Experto 24/7</h3>
				<p>Equipo técnico disponible en todo momento vía WhatsApp, Telegram y email para asistencia inmediata.</p>
			</div>
		</div>
	</section>
	
	<!-- Services -->
	<section class="services-section" id="servicios">
		<h2 class="section-title">🛠️ Nuestros Servicios</h2>
		<div class="services-grid">
			<div class="service-item">
				<div class="service-icon">🔓</div>
				<div class="service-name">Liberación de Red USA/Mundial</div>
			</div>
			<div class="service-item">
				<div class="service-icon">📱</div>
				<div class="service-name">Bypass iCloud / FMI OFF</div>
			</div>
			<div class="service-item">
				<div class="service-icon">🔧</div>
				<div class="service-name">FRP / Google Lock Removal</div>
			</div>
			<div class="service-item">
				<div class="service-icon">🎮</div>
				<div class="service-name">Activaciones & Credits</div>
			</div>
			<div class="service-item">
				<div class="service-icon">💻</div>
				<div class="service-name">Servidores Premium (Rent Tools)</div>
			</div>
			<div class="service-item">
				<div class="service-icon">🚀</div>
				<div class="service-name">API Integration Pro</div>
			</div>
		</div>
	</section>
	
	<!-- Footer -->
	<footer class="landing-footer">
		<div class="footer-content">
			<p style="font-size: 18px; color: #94a3b8; font-weight: 600;">💎 NACHOTECHRD - Tu Socio de Confianza en Desbloqueo Premium</p>
			<div class="footer-links">
				<a href="#">Términos de Servicio</a>
				<a href="#">Política de Privacidad</a>
				<a href="#">Reembolsos</a>
				<a href="#">API Documentation</a>
				<a href="#">Contacto</a>
			</div>
			<p>&copy; <?php echo date('Y'); ?> NACHOTECHRD. Todos los derechos reservados.</p>
		</div>
	</footer>
	
	<script>
		// Carousel functionality
		let currentSlide = 0;
		const track = document.getElementById('carouselTrack');
		const slides = document.querySelectorAll('.carousel-slide');
		const totalSlides = slides.length;
		const slidesPerView = window.innerWidth > 1024 ? 3 : window.innerWidth > 768 ? 2 : 1;
		const maxSlide = Math.ceil(totalSlides / slidesPerView) - 1;
		
		// Create indicators
		const indicatorsContainer = document.getElementById('carouselIndicators');
		for (let i = 0; i <= maxSlide; i++) {
			const indicator = document.createElement('div');
			indicator.className = 'indicator' + (i === 0 ? ' active' : '');
			indicator.onclick = () => goToSlide(i);
			indicatorsContainer.appendChild(indicator);
		}
		
		function updateCarousel() {
			const slideWidth = slides[0].offsetWidth;
			const gap = 30;
			const offset = currentSlide * (slideWidth + gap) * slidesPerView;
			track.style.transform = `translateX(-${offset}px)`;
			
			// Update indicators
			document.querySelectorAll('.indicator').forEach((ind, idx) => {
				ind.classList.toggle('active', idx === currentSlide);
			});
		}
		
		function nextSlide() {
			currentSlide = currentSlide >= maxSlide ? 0 : currentSlide + 1;
			updateCarousel();
		}
		
		function prevSlide() {
			currentSlide = currentSlide <= 0 ? maxSlide : currentSlide - 1;
			updateCarousel();
		}
		
		function goToSlide(index) {
			currentSlide = index;
			updateCarousel();
		}
		
		// Auto-play carousel
		setInterval(nextSlide, 5000);
		
		// Update on window resize
		window.addEventListener('resize', () => {
			updateCarousel();
		});
	</script>
</body>
</html>
