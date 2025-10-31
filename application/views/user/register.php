<h2 class="auth-title">📝 Crear Cuenta</h2>
<p class="auth-subtitle">Únete a la plataforma líder en servicios IMEI</p>

<?php 
// Mostrar mensajes de éxito/error
if($this->session->flashdata('success')): ?>
	<div class="alert alert-success">
		✅ <?php echo $this->session->flashdata('success'); ?>
	</div>
<?php endif; ?>

<?php if($this->session->flashdata('fail')): ?>
	<div class="alert alert-danger">
		❌ <?php echo $this->session->flashdata('fail'); ?>
	</div>
<?php endif; ?>

<?php if(validation_errors()): ?>
	<div class="alert alert-danger">
		❌ <?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<?php echo form_open('register', array('role' => 'form', 'method' => 'post')); ?>
	<div class="form-row">
		<div class="form-group">
			<label for="firstname">👤 Nombre</label>
			<input 
				type="text" 
				name="FirstName" 
				id="firstname"
				value="<?php echo set_value('FirstName'); ?>" 
				class="form-control" 
				placeholder="Juan" 
				required
				autofocus
			>
		</div>
		
		<div class="form-group">
			<label for="lastname">👤 Apellido</label>
			<input 
				type="text" 
				name="LastName" 
				id="lastname"
				value="<?php echo set_value('LastName'); ?>" 
				class="form-control" 
				placeholder="Pérez" 
				required
			>
		</div>
	</div>
	
	<div class="form-group">
		<label for="email">📧 Correo Electrónico</label>
		<input 
			type="email" 
			name="Email" 
			id="email"
			value="<?php echo set_value('Email'); ?>" 
			class="form-control" 
			placeholder="tu@email.com" 
			required
		>
	</div>
	
	<div class="form-group">
		<label for="password">🔒 Contraseña</label>
		<input 
			type="password" 
			name="Password" 
			id="password"
			class="form-control" 
			placeholder="Mínimo 8 caracteres" 
			required
			minlength="8"
		>
	</div>
	
	<div class="form-group">
		<label for="cpassword">✅ Confirmar Contraseña</label>
		<input 
			type="password" 
			name="CPassword" 
			id="cpassword"
			class="form-control" 
			placeholder="Repite tu contraseña" 
			required
			minlength="8"
		>
	</div>
	
	<div class="alert alert-info" style="margin-top: 20px;">
		📌 <strong>Nota:</strong> Al registrarte, aceptas nuestros términos de servicio y política de privacidad.
	</div>
	
	<button type="submit" class="btn-primary-auth">
		🎉 Crear mi Cuenta Gratis
	</button>
<?php echo form_close(); ?>
