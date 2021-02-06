<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<!-- begin login -->
<div class="login bg-black animated fadeInDown">
	<!-- begin brand -->
	<div class="login-header">
		<div class="brand">
			<span class="logo"></span> <b>S O P</b>
			<small>Sistema de Operatividad Política</small>
		</div>
		<div class="icon">
			<i class="fa fa-lock"></i>
		</div>
	</div>
	<!-- end brand -->
	<!-- begin login-content -->
	<div class="login-content">
		<form action="<?php echo e(route('loginsop')); ?>" method="post" class="margin-bottom-0">
			<?php echo csrf_field(); ?>
			<div class="form-group m-b-20">
				<input id="email" type="email" placeholder="Usuario"
					class="form-control form-control-lg inverse-mode<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
					name="email" value="<?php echo e(old('email')); ?>" required autofocus>
				<?php if($errors->has('email')): ?>
				<span class="invalid-feedback" role="alert">
					<strong><?php echo e($errors->first('email')); ?></strong>
				</span>
				<?php endif; ?>
			</div>
			<div class="form-group m-b-20">
				<input id="password" type="password" placeholder="Contraseña"
					class="form-control form-control-lg inverse-mode<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>"
					name="password" required>
				<?php if($errors->has('password')): ?>
				<span class="invalid-feedback" role="alert">
					<strong><?php echo e($errors->first('password')); ?></strong>
				</span>
				<?php endif; ?>
			</div>
			<div class="login-buttons">
				<button type="submit" class="btn btn-success btn-block btn-lg">Iniciar</button>
			</div>
		</form>
	</div>
	<!-- end login-content -->
</div>
<!-- end login -->

<?php $__env->stopSection(); ?>

<style>
	.fa-lock:before {
		color: black;
	}
</style>
<?php echo $__env->make('layouts.empty', ['paceTop' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DMPI\so-politica\resources\views/sopolitica/login.blade.php ENDPATH**/ ?>