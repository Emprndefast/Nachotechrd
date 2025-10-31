<h2 class="auth-title">🔐 Iniciar Sesión</h2>
<p class="auth-subtitle">Accede a tu panel de control premium</p>

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

<?php echo form_open('login', array('role' => 'form', 'method' => 'post')); ?>
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
			autofocus
		>
	</div>
	
	<div class="form-group">
		<label for="password">🔒 Contraseña</label>
		<input 
			type="password" 
			name="Password" 
			id="password"
			class="form-control" 
			placeholder="••••••••" 
			required
		>
	</div>
	
	<button type="submit" class="btn-primary-auth">
		🚀 Iniciar Sesión
	</button>
<?php echo form_close(); ?>
