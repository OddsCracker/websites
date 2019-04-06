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
if ($league) {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/leagues">Leagues</a></li>
		<li>Edit <?php echo $league['Name'];?></li>
	</ul>
	<h3 class="text-center">Edit <strong><?php echo $league['Name'];?></strong></h3>
	<form class="form form-horizontal" role="form" method="post" action="/admin/update_league">
		<input type="hidden" name="LeagueID" value="<?php echo $league['LeagueID'];?>">
		<div class="form-group">
			<div class="col-sm-6">
				<label>Name</label>
				<input type="text" name="Name" class="form-control input-lg" required="required" value="<?php echo $league['Name'];?>">
			</div>
			<div class="col-sm-6">
				<label>Country</label>
				<select name="CountryCode" class="form-control input-lg">
					<option value="">No Country</option>
					<?php foreach ($countries as $key => $value) { echo '<option value="' . $value['CountryCode'] . '"'; if ($league['CountryCode'] == $value['CountryCode']) { echo ' selected="selected"';} echo '>' . $value['CountryName'] . '</option>';}?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Display order</label>
				<select name="SortOrder" class="form-control input-lg" required="required">
					<?php foreach ($sort_numbers as $key => $value) { echo '<option value="' . $value . '"'; if ($league['SortOrder'] == $value) { echo ' selected="selected"';} echo '>' . $value . '</option>';}?>
				</select>
			</div>
			<div class="col-sm-6"></div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-primary btn-lg" value="Update">
			</div>
		</div>
	</form>
<?php
}
?>
</div>
