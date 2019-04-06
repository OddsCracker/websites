<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h1 class="page-title"><?php echo $page['Heading'];?></h1>
	<br>
	<div class="container">
		<?php echo $page['Html'];?>
	</div>
	<div class="container">
		<p id="contact_form_error"></p>
		<p id="contact_form_success"></p>
		<form id="contact-form" class="form form-horizontal" method="post">
			<?php if (get_cookie('csrf')) { echo '<input type="hidden" name="csrf" value="' . get_cookie('csrf') . '">' . "\n"; } ?>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Your Name*</label>
					<input type="text" name="Name" class="form-control" required="required" placeholder="Your name">
				</div>
				<div class="col-sm-6">
					<label class="second-label">Your Phone Number*</label>
					<input type="tel" name="Phone" class="form-control" required="required" placeholder="Your phone number">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Your Email*</label>
					<input type="email" name="Email" class="form-control" required="required" placeholder="Your email">
				</div>
				<div class="col-sm-6">
					<label class="second-label">Your message*</label>
					<textarea name="Message" class="form-control" required="required" rows="5"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Enter the code in the image*</label>
					<input type="text" name="Captcha" class="form-control" required="required">
				</div>
				<div class="col-sm-6">
					<br><?php echo $captcha['image'];?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12 text-center">
					<input type="submit" class="btn btn-lg btn-success" value="Send">
				</div>
			</div>
		</form>
	</div>
</div>
