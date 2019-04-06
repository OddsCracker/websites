<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<br>
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
		<li>Site Settings</li>
	</ul>
	<h3 class="text-center">Global site settings</h3>
	<form class="form form-horizontal" role="form" method="post" action="/admin/update_settings">
		<div class="form-group">
			<div class="col-sm-4">
				<h4>Variable name (readonly)</h4>
			</div>
			<div class="col-sm-4">
				<h4>Variable description (optional)</h4>
			</div>
			<div class="col-sm-4">
				<h4>Value (required)</h4>
			</div>
		</div>
		<?php
		foreach ($site_settings as $key => $value) {
		?>
		<div class="form-group">
			<input type="hidden" name="SettingID[]" value="<?php echo $key;?>">
			<div class="form-group">
				<div class="col-sm-4">
					<input type="text" name="Name[]" class="form-control input-lg" value="<?php echo $value['Name'];?>" readonly="readonly">
				</div>
				<div class="col-sm-4">
					<textarea name="Description[]" class="form-control input-lg" rows="3"><?php echo $value['Description'];?></textarea>
				</div>
				<div class="col-sm-4">
					<textarea name="Value[]" class="form-control input-lg" required="required" rows="3"><?php echo $value['Value'];?></textarea>
				</div>
			</div>
		</div>
		<?php
		}
		?>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-lg btn-primary" value="Update all settings">
			</div>
		</div>
	</form>
</div>
