<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h2 class="page-title"><?php echo $page['Heading'];?></h2>
	<br>
<?php
if ($this->session->flashdata('success')) {
	echo '<p class="alert alert-success">' . $this->session->flashdata('success') . '</p>';
}
?>
	<div class="row">
		<?php echo $page['Html'];?>
	</div>
	<hr>
	<form id="edit-account-form" class="form form-horizontal" role="form" method="post" action="/account/update">
		<?php if (get_cookie('csrf')) { echo '<input type="hidden" name="csrf" value="' . get_cookie('csrf') . '">' . "\n"; } ?>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Email <span class="required">*</span></label>
				<input type="email" name="Email" class="form-control" required="required" value="<?php echo $user['Email'];?>">
			</div>
			<div class="col-sm-6">
				<label>Username (nickname)</label>
				<input type="text" name="Username" class="form-control" value="<?php echo $user['Username'];?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>First Name</label>
				<input type="text" name="FirstName" class="form-control" value="<?php echo $user['FirstName'];?>" placeholder="First name">
			</div>
			<div class="col-sm-6">
				<label>Last Name</label>
				<input type="text" name="LastName" class="form-control" value="<?php echo $user['LastName'];?>" placeholder="Last name">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Phone number</label>
				<input type="tel" name="Phone" class="form-control" value="<?php echo $user['Phone'];?>" placeholder="Phone number">
			</div>
			<div class="col-sm-6">
				<label>Country</label>
				<select name="Country" class="form-control">
					<?php foreach ($countries as $key => $value) { echo '<option value="' . $value['CountryName'] . '"'; if ($user['Country'] == $value['CountryName']) { echo ' selected="selected"';} echo '>' . $value['CountryName'] . '</option>';}?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>New password</label>
				<input type="password" name="Password" class="form-control" autocomplete="off" placeholder="New password">
			</div>
			<div class="col-sm-6">
				<label>Re-type new password</label>
				<input type="password" name="ConfirmPassword" class="form-control" autocomplete="off" placeholder="Re-type new password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="checkbox" name="newsletter"<?php if ($newsletter) { echo ' checked';}?>> &nbsp; Subscribe to newsletter to receive news and promotions
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-success" value="Update">
			</div>
		</div>
	</form>
</div>
