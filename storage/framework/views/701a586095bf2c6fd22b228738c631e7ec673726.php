<?php $__env->startSection('title', 'Registro'); ?>

<?php $__env->startPush('css'); ?>
<link href="/assets/plugins/parsleyjs/src/parsley.css" rel="stylesheet" />
<link href="/assets/plugins/smartwizard/dist/css/smart_wizard.css" rel="stylesheet" />
<link href="/assets/plugins/jstree/themes/default/style.min.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- begin register -->
<div class="register register-with-news-feed">
	<!-- begin news-feed -->
	<div class="news-feed">
		<div class="news-image" style="background-image: url(../assets/img/login-bg/banner.jpg)"></div>
		<div class="news-caption">
			<h4 class="caption-title"><b>S O P</b> Sistema de Operatividad Política</h4>
			<p>---
			</p>
		</div>
	</div>
	<!-- end news-feed -->
	<!-- begin right-content -->
	<div class="right-content">
		<!-- begin register-header -->
		<h1 class="register-header">
			Registro
			<small>Registro de Candidato para administrar tu cuenta.</small>
		</h1>
		<!-- end register-header -->
		<!-- begin register-content -->
		<div class="register-content">

			<!-- begin wizard-form -->
			<form action="<?php echo e(route('registrosop')); ?>" method="post" name="form-wizard" class="form-control-with-bg">
				<?php echo csrf_field(); ?>
				<!-- begin wizard -->
				<div id="wizard">
					<!-- begin wizard-step -->
					<ul>
						<li class="col-md-3 col-sm-4 col-6">
							<a href="#step-1">
								<span class="number">1</span>
								<span class="info text-ellipsis">
									Información Personal
									<small class="text-ellipsis">Nombre, Clave Elector</small>
								</span>
							</a>
						</li>
						<li class="col-md-3 col-sm-4 col-6">
							<a href="#step-2">
								<span class="number">2</span>
								<span class="info text-ellipsis">
									Selección de Candidatura
									<small class="text-ellipsis">Entidad Federativa, Municipios, Distritos</small>
								</span>
							</a>
						</li>
						<li class="col-md-3 col-sm-4 col-6">
							<a href="#step-3">
								<span class="number">3</span>
								<span class="info text-ellipsis">
									Cuenta de Accesso
									<small class="text-ellipsis">Usuario y Contraseña</small>
								</span>
							</a>
						</li>
						<li class="col-md-3 col-sm-4 col-6">
							<a href="#step-4">
								<span class="number">4</span>
								<span class="info text-ellipsis">
									Finalizar
									<small class="text-ellipsis">Finalizar Registro</small>
								</span>
							</a>
						</li>
					</ul>
					<!-- end wizard-step -->
					<!-- begin wizard-content -->
					<div>
						<!-- begin step-1 -->
						<div id="step-1">
							<!-- begin fieldset -->
							<fieldset>
								<!-- begin row -->
								<div class="row">
									<!-- begin col-8 -->
									<div class="col-md-8 offset-md-2">
										<legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">
											Información personal sobre ti</legend>
										<!-- begin form-group -->
										<div class="form-group row m-b-10">
											<label class="col-md-3 col-form-label text-md-right">Nombre <span
													class="text-danger">*</span></label>
											<div class="col-md-6">
												<input type="text" id="nombre" name="nombre" placeholder="Nombre"
													data-parsley-group="step-1" data-parsley-required="true"
													class="form-control" />
											</div>
										</div>
										<!-- begin form-group -->
										<div class="form-group row m-b-10">
											<label class="col-md-3 col-form-label text-md-right">Clave Elector <span
													class="text-danger">*</span></label>
											<div class="col-md-6">
												<input type="text" id="ce" name="ce" placeholder="Clave de Elector"
													class="form-control" onkeyup="upperCase(this.id)"
													data-parsley-group="step-1" data-parsley-required="true"
													data-parsley-pattern="[A-Z]{6}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[0-3]{1}[0-9]{1}[HM]{1}[0-9]{1}[0-9]{2}$">
											</div>
										</div>
										<!-- end form-group -->
									</div>
									<!-- end col-8 -->
								</div>
								<!-- end row -->
							</fieldset>
							<!-- end fieldset -->
						</div>
						<!-- end step-1 -->
						<!-- begin step-2 -->
						<div id="step-2">
							<!-- begin fieldset -->
							<fieldset>
								<!-- begin row -->
								<div class="row">
									<!-- begin col-8 -->
									<div class="col-md-8 md-offset-2">
										<legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">
											Selecciona la Entidad Federativa, Municipios, y Distritos requeridos para tu
											Candidatura </legend>
										<!-- begin form-group -->
										<!-- begin form-group -->
										<input type="hidden" id="values" name="values" value="">
										<div class="form-group row m-b-10">
											<div id="jstree-checkable"></div>
										</div>
										<!-- end form-group -->
									</div>
									<!-- end col-8 -->
								</div>
								<!-- end row -->
							</fieldset>
							<!-- end fieldset -->
						</div>
						<!-- end step-2 -->
						<!-- begin step-3 -->
						<div id="step-3">
							<!-- begin fieldset -->
							<fieldset>
								<!-- begin row -->
								<div class="row">
									<!-- begin col-8 -->
									<div class="col-md-8 offset-md-2">
										<legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">
											Ingrese su correo y contraseña de inicio de sesión</legend>
										<!-- begin form-group -->
										<div class="form-group row m-b-10">
											<label class="col-md-3 col-form-label text-md-right">Correo Electrónico
												<span class="text-danger">*</span></label>
											<div class="col-md-6">
												<input type="email" id="email" name="email"
													placeholder="Correo Electrónico" class="form-control"
													data-parsley-group="step-3" data-parsley-required="true"
													data-parsley-type="email" />
											</div>
										</div>
										<!-- end form-group -->
										<!-- begin form-group -->
										<div class="form-group row m-b-10">
											<label class="col-md-3 col-form-label text-md-right">Contraseña <span
													class="text-danger">*</span></label>
											<div class="col-md-6">
												<input type="password" id="password" name="password"
													placeholder="Tu Contraseña" class="form-control"
													data-parsley-group="step-3" data-parsley-required="true" />
											</div>
										</div>
										<!-- end form-group -->
										<!-- begin form-group -->
										<div class="form-group row m-b-10">
											<label class="col-md-3 col-form-label text-md-right">Confirma Contraseña
												<span class="text-danger">*</span></label>
											<div class="col-md-6">
												<input type="password" name="password_confirm"
													placeholder="Confirma Contraseña" class="form-control"
													data-parsley-group="step-3" data-parsley-equalto="#password"
													data-parsley-required="true" />
											</div>
										</div>
										<!-- end form-group -->
									</div>
									<!-- end col-8 -->
								</div>
								<!-- end row -->
							</fieldset>
							<!-- end fieldset -->
						</div>
						<!-- end step-3 -->
						<!-- begin step-4 -->
						<div id="step-4">
							<div class="jumbotron m-b-0 text-center">
								<!--<h2 class="text-inverse">Finalizar Registro</h2>-->
								<button type="submit" class="btn btn-primary btn-lg">
									Finalizar Registro
								</button>
							</div>
						</div>
						<!-- end step-4 -->
					</div>
					<!-- end wizard-content -->
				</div>
				<!-- end wizard -->
			</form>
			<!-- end wizard-form -->
			<p class="text-center">
				&copy; SOP Sistema de Operatividad Política 2020
			</p>
		</div>
		<!-- end register-content -->
	</div>
	<!-- end right-content -->
</div>
<!-- end register -->
<?php $__env->stopSection(); ?>

<style>
	.register.register-with-news-feed .news-feed {
		right: 70% !important;
	}

	.register.register-with-news-feed .right-content {
		width: 70% !important;
	}
</style>


<?php $__env->startPush('scripts'); ?>
<script src="/assets/plugins/parsleyjs/dist/parsley.js"></script>
<script src="/assets/plugins/smartwizard/dist/js/jquery.smartWizard.js"></script>
<script src="/assets/js/sop/form-wizards-login.js"></script>
<script>
	$(document).ready(function() {
		FormWizardValidation.init();
	});
</script>

<script src="/assets/plugins/jstree/jstree.min.js"></script>
<script src="/assets/js/sop/ui-tree.js"></script>
<script>
	$(function () {
		$.ajax({
			async: true,
			type: "GET",
			url: "<?php echo e(route('tree')); ?>",
			dataType: "json",
			success: function (json) {
				TreeView.init(json);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		});            
	});
</script>

<script type="text/javascript">
	function upperCase(x){
		var y=document.getElementById(x).value;
		document.getElementById(x).value=y.toUpperCase();
	}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DMPI\so-politica\api\resources\views/sopolitica/registro.blade.php ENDPATH**/ ?>