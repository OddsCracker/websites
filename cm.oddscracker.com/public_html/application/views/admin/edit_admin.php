<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
<?php
if ($this->session->flashdata('error')) {
	echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';
}
if ($this->session->flashdata('success')) {
	echo '<p class="alert alert-success">' . $this->session->flashdata('success') . '</p>';
}
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Edit My Login</li>
	</ul>
	<h3 class="text-center">Edit my login details</h3>
	<br>
	<form class="form form-horizontal" role="form" method="post" action="/admin/update">
		<input type="hidden" name="UserID" value="<?php echo $admin['UserID'];?>">
		<div class="form-group">
			<div class="col-sm-6">
				<label>Email</label>
				<input type="email" name="Email" class="form-control input-lg" required="required" value="<?php echo $admin['Email'];?>">
				<br>
				<label>Re-type Email</label>
				<input type="email" name="ConfirmEmail" class="form-control input-lg" required="required" autocomplete="off">
			</div>
			<div class="col-sm-6">
				<label>Set password to (leave blank if no change):</label>
				<input type="password" name="Password" class="form-control input-lg" autocomplete="off">
				<br>
				<label>Re-type password (leave blank if no change):</label>
				<input type="password" name="ConfirmPassword" class="form-control input-lg" autocomplete="off">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="submit" class="btn btn-lg btn-primary" value="Update">
			</div>
		</div>
	</form>
</div>
