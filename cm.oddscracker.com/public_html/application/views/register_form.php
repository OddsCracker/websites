<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h2 class="page-title"><?php echo $page['Heading'];?></h2>
	<div class="container">
		<?php echo $page['Html'];?>
	</div>
	<div class="container">
		<p id="form_error"></p>
		<p id="form_success"></p>
		<form id="register-form" class="form form-horizontal" method="post">
			<?php if (get_cookie('csrf')) { echo '<input type="hidden" name="csrf" value="' . get_cookie('csrf') . '">' . "\n"; } ?>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Email*</label>
					<input type="email" name="Email" class="form-control" required="required" placeholder="Email" data-toggle="tooltip" title="Email is required">
				</div>
				<div class="col-sm-6">
					<label class="second-label">Répétez l'email*</label>
					<input type="email" name="ConfirmEmail" class="form-control" required="required" placeholder="Répétez l'email" data-toggle="tooltip" title="Required field! Re-type your email" autocomplete="off">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Mot de passe (6 - 50 characters)*</label>
					<input type="password" name="Password" class="form-control" required="required" placeholder="Mot de passe" data-toggle="tooltip" title="Minimum 6 caractères, maximum 50 caractères, obligatoire" autocomplete="off">
				</div>
				<div class="col-sm-6">
					<label class="second-label">Répéter le mot de passe*</label>
					<input type="password" name="ConfirmPassword" class="form-control" required="required" placeholder="Répéter le mot de passe" data-toggle="tooltip" title="Répétez votre mot de passe, requis!" autocomplete="off">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Connu comme (Nom d'utilisateur public)*</label>
					<input type="text" name="Username" class="form-control" required="required" placeholder="Nom d'utilisateur" data-toggle="tooltip" title="Votre nom d'utilisateur public, minimum 3 caractères, maximum 65">
				</div>
				<div class="col-sm-6">
					<label class="second-label">Pays*</label>
					<select name="Country" class="form-control" required="required">
					<?php foreach ($countries as $key => $value) { echo '<option value="' . $value['CountryName'] . '">' . $value['CountryName'] . '</option>';}?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Tapez le code dans l'image</label>
					<input type="text" name="Captcha" class="form-control" required="required">
				</div>
				<div class="col-sm-6">
					<br>
					<?php echo $captcha['image'];?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<input type="checkbox" name="agreement" required="required"> J'accepte les <a href="/terms" title="Terms of Use">les conditions d'utilisation</a> et <a href="/privacy" title="Privacy Policy">la politique de confidentialité</a>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12 text-center">
					<input type="submit" class="btn btn-lg btn-success" value="Créer mon compte">
				</div>
			</div>
		</form>
		<p id="register_wait_alert" class="alert alert-warning text-center" style="display:none;">Attendez de recevoir une réponse après avoir soumis le formulaire!</p>
		<br>
		<div class="row text-center">
			<a href="/login/facebook" class="btn btn-lg btn-facebook"><i class="fa fa-fw fa-facebook"></i> S'inscrire avec Facebook</a>
			&nbsp;
			<a href="/login/google" class="btn btn-lg btn-google"><i class="fa fa-fw fa-google-plus"></i> S'inscrire avec Google</a>
		</div>
	</div>
</div>
