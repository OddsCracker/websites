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
		<li><a href="/admin/users">Users</a></li>
		<li>Edit <?php echo $user['Username'];?></li>
	</ul>
	<h3 class="text-center">Edit <strong><?php echo $user['Username'];?></strong>'s profile</h3>
	<form class="form form-horizontal" role="form" method="post" action="/admin/update_user">
		<input type="hidden" name="UserID" value="<?php echo $user['UserID'];?>">
		<div class="form-group">
			<div class="col-sm-6">
				<label>Username (nickname)</label>
				<input type="text" name="Username" class="form-control input-lg" required="required" value="<?php echo $user['Username'];?>">
			</div>
			<div class="col-sm-6">
				<label>Email</label>
				<input type="email" name="Email" class="form-control input-lg" required="required" value="<?php echo $user['Email'];?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Country</label>
				<select name="Country" class="form-control input-lg" required="required">
					<?php foreach ($countries as $key => $value) { echo '<option value="' . $value['CountryName'] . '"'; if ($user['Country'] == $value['CountryName']) { echo ' selected="selected"';} echo '>' . $value['CountryName'] . '</option>' . "\n";}?>
				</select>
			</div>
			<div class="col-sm-6">
				<label>Is active (can login)</label>
				<select name="Active" class="form-control input-lg" required="required">
					<option value="1"<?php if ($user['Active'] > 0) { echo ' selected="selected"';}?>>Yes</option>
					<option value="0"<?php if ($user['Active'] == 0) { echo ' selected="selected"';}?>>No</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Set password to (leave blank if no change):</label>
				<input type="password" name="Password" class="form-control input-lg">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="submit" class="btn btn-lg btn-primary" value="Update">
			</div>
		</div>
	</form>
</div>
