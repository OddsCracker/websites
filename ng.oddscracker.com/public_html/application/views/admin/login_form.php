<br><br>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4">
		<?php if ($this->session->flashdata('error')) { echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';} ?>
		<form class="form form-horizontal" method="post" action="/admin/dologin">
			<?php if (get_cookie('csrf')) { echo '<input type="hidden" name="csrf" value="' . get_cookie('csrf') . '">' . "\n"; } ?>
			<div class="form-group">
				<label>Email</label>
				<input type="email" name="Email" class="form-control input-lg" required="required" autocomplete="off">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="Password" class="form-control input-lg" required="required" autocomplete="off">
			</div>
			<div class="form-group">
				<input type="checkbox" name="rememberme"> Keep me logged in
			</div>
			<hr>
			<div class="form-group text-center">
				<input type="submit" class="btn btn-lg btn-primary" value="Login">
			</div>
		</form>
	</div>
	<div class="col-sm-4"></div>
</div>
