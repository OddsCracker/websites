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
					<label class="second-label">Re-type Email*</label>
					<input type="email" name="ConfirmEmail" class="form-control" required="required" placeholder="Re-type Email" data-toggle="tooltip" title="Required field! Re-type your email" autocomplete="off">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Password (6 - 50 characters)*</label>
					<input type="password" name="Password" class="form-control" required="required" placeholder="Password" data-toggle="tooltip" title="Minimum 6 characters, maximum 50 characters, required field" autocomplete="off">
				</div>
				<div class="col-sm-6">
					<label class="second-label">Re-type password*</label>
					<input type="password" name="ConfirmPassword" class="form-control" required="required" placeholder="Re-Type Email" data-toggle="tooltip" title="Re-type your password, required field!" autocomplete="off">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Known as (Username)*</label>
					<input type="text" name="Username" class="form-control" required="required" placeholder="Username" data-toggle="tooltip" title="Your displayed username, minimum 3 characters, maximum 65">
				</div>
				<div class="col-sm-6">
					<label class="second-label">Country*</label>
					<select name="Country" class="form-control" required="required">
					<?php foreach ($countries as $key => $value) { echo '<option value="' . $value['CountryName'] . '">' . $value['CountryName'] . '</option>';}?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Enter the code in the image</label>
					<input type="text" name="Captcha" class="form-control" required="required">
				</div>
				<div class="col-sm-6">
					<br>
					<?php echo $captcha['image'];?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<input type="checkbox" name="agreement" required="required"> I agree to <a href="/terms" title="Terms of Use">terms of use</a> and <a href="/privacy" title="Privacy Policy">privacy policy</a>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12 text-center">
					<input type="submit" class="btn btn-lg btn-success" value="Create my account">
				</div>
			</div>
		</form>
		<p id="register_wait_alert" class="alert alert-warning text-center" style="display:none;">Please wait to receive a response after submitting the form!</p>
		<br>
		<div class="row text-center">
			<a href="/login/facebook" class="btn btn-lg btn-facebook"><i class="fa fa-fw fa-facebook"></i> Signup with Facebook</a>
			&nbsp;
			<a href="/login/google" class="btn btn-lg btn-google"><i class="fa fa-fw fa-google-plus"></i> Signup with Google</a>
		</div>
	</div>
</div>
