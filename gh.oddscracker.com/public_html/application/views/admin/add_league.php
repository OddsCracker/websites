<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/leagues">Leagues</a></li>
		<li>Add New League</li>
	</ul>
	<h3 class="text-center">Add new league</h3>
	<form class="form form-horizontal" role="form" method="post" action="/admin/insert_league">
		<div class="form-group">
			<div class="col-sm-6">
				<label>Name</label>
				<input type="text" name="Name" class="form-control input-lg" required="required">
			</div>
			<div class="col-sm-6">
				<label>Country</label>
				<select name="CountryCode" class="form-control input-lg">
					<option value="">No country</option>
					<?php foreach ($countries as $key => $value) { echo '<option value="' . $value['CountryCode'] . '">' . $value['CountryName'] . '</option>';}?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Display order</label>
				<select name="SortOrder" class="form-control input-lg" required="required">
					<?php foreach ($sort_numbers as $key => $value) { echo '<option value="' . $value . '">' . $value . '</option>';}?>
				</select>
			</div>
			<div class="col-sm-6"></div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-primary btn-lg" value="Save">
			</div>
		</div>
	</form>
</div>
