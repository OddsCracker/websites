<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/bookmakers">Bookmakers</a></li>
		<li>Add New Bookmaker</li>
	</ul>
	<h3 class="text-center">Add new bookmaker</h3>
	<br>
	<?php if ($this->session->flashdata('error')) { echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';}?>
	<form class="form form-horizontal" role="form" method="post" action="/admin/save_bookmaker" enctype="multipart/form-data">
		<div class="form-group">
			<div class="col-sm-4">
				<label>Name *</label>
				<input type="text" name="Name" class="form-control input-lg" required="required">
			</div>
			<div class="col-sm-4">
				<label>Display order*</label>
				<select name="SortOrder" class="form-control input-lg" required="required">
				<?php foreach ($sort_numbers as $key => $value) { echo '<option value="' . $value . '">' . $value . '</option>' . "\n";}?>
				</select>
			</div>
			<div class="col-sm-4">
				<label>Licensed (text)</label>
				<input type="text" name="Licensed" class="form-control input-lg">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Meta title *</label>
				<input type="text" name="MetaTitle" class="form-control input-lg" required="required">
			</div>
			<div class="col-sm-6">
				<label>Meta description</label>
				<textarea name="MetaDescription" class="form-control input-lg" rows="3"></textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-4">
				<label>Software</label>
				<textarea name="Software" class="form-control input-lg" rows="3"></textarea>
			</div>
			<div class="col-sm-4">
				<label>Withdrawals</label>
				<textarea name="Withdrawals" class="form-control input-lg" rows="3"></textarea>
			</div>
			<div class="col-sm-4">
				<label>Deposits</label>
				<textarea name="Deposits" class="form-control input-lg" rows="3"></textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-2">
				<label>Bonuses</label>
				<br>
				<input type="radio" name="Bonuses" value="0">&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="Bonuses" value="1">&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>Live chat</label>
				<br>
				<input type="radio" name="Livechat" value="0">&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="Livechat" value="1">&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>Mobile betting</label>
				<br>
				<input type="radio" name="MobileBetting" value="0">&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="MobileBetting" value="1">&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>SMS betting</label>
				<br>
				<input type="radio" name="SmsBetting" value="0">&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="SmsBetting" value="1">&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>Casino</label>
				<br>
				<input type="radio" name="Casino" value="0">&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="Casino" value="1">&nbsp;Yes
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-2">
				<label>Ease of use rating</label>
				<input type="number" class="form-control input-lg" name="RatingUse" min="0.1" max="10.0" step="0.1" value="5.0">
			</div>
			<div class="col-sm-2">
				<label>Games offer rating</label>
				<input type="number" class="form-control input-lg" name="RatingGames" min="0.1" max="10.0" step="0.1" value="5.0">
			</div>
			<div class="col-sm-2">
				<label>Bonus rating</label>
				<input type="number" class="form-control input-lg" name="RatingBonus" min="0.1" max="10.0" step="0.1" value="5.0">
			</div>
			<div class="col-sm-2">
				<label>Service rating</label>
				<input type="number" class="form-control input-lg" name="RatingService" min="0.1" max="10.0" step="0.1" value="5.0">
			</div>
			<div class="col-sm-2">
				<label>Mobile rating</label>
				<input type="number" class="form-control input-lg" name="RatingMobile" min="0.1" max="10.0" step="0.1" value="5.0">
			</div>
			<div class="col-sm-2">
				<label>Withdrawal rating</label>
				<input type="number" class="form-control input-lg" name="RatingWithdraw" min="0.1" max="10.0" step="0.1" value="5.0">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Logo image (png/jpeg only)*</label>
				<input type="file" name="Logo" required="required">
				<br>
				<label>Logo image alternate text (alt)</label>
				<input type="text" name="LogoAlt" class="form-control input-lg">
			</div>
			<div class="col-sm-6">
				<label>Cover image (png/jpeg only)*</label>
				<input type="file" name="Cover" required="required">
				<br>
				<label>Cover image alternate text (alt)</label>
				<input type="text" name="CoverAlt" class="form-control input-lg">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-6">
				<label>About (text)</label>
				<textarea name="About" class="form-control input-lg" rows="5"></textarea>
				<br>
				<label>URL:</label>
				<input type="text" name="Link" class="form-control input-lg" required="required">
			</div>
			<div class="col-sm-6">
				<label>Description (text, html formatting is permitted)</label>
				<textarea name="Description" class="form-control input-lg" rows="10"></textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-lg btn-primary" value="Save">
			</div>
		</div>
	</form>
</div>
