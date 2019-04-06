<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/bookmakers">Bookmakers</a></li>
		<li>Edit <?php echo $bookmaker['Name'];?></li>
	</ul>
	<h3 class="text-center">Edit existing bookmaker</h3>
	<br>
	<?php if ($this->session->flashdata('error')) { echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';}?>
	<form class="form form-horizontal" role="form" method="post" action="/admin/update_bookmaker" enctype="multipart/form-data">
		<input type="hidden" name="BookmakerID" value="<?php echo $bookmaker['BookmakerID'];?>">
		<div class="form-group">
			<div class="col-sm-4">
				<label>Name *</label>
				<input type="text" name="Name" class="form-control input-lg" value="<?php echo $bookmaker['Name'];?>" required="required">
			</div>
			<div class="col-sm-4">
				<label>Display order*</label>
				<select name="SortOrder" class="form-control input-lg">
				<?php foreach ($sort_numbers as $key => $value) { echo '<option value="' . $value . '"'; if ($bookmaker['SortOrder'] == $value) { echo ' selected="selected"';} echo '>' . $value . '</option>' . "\n";}?>
				</select>
			</div>
			<div class="col-sm-4">
				<label>Slug (only a-z 0-9 and -)</label>
				<input type="text" name="Slug" class="form-control input-lg" value="<?php echo $bookmaker['Slug'];?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Meta title *</label>
				<input type="text" name="MetaTitle" class="form-control input-lg" value="<?php echo $bookmaker['MetaTitle'];?>" required="required">
			</div>
			<div class="col-sm-6">
				<label>Meta description</label>
				<textarea name="MetaDescription" class="form-control input-lg" rows="3"><?php echo $bookmaker['MetaDescription'];?></textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-4">
				<label>Software</label>
				<textarea name="Software" class="form-control input-lg" rows="3"><?php echo $bookmaker['Software'];?></textarea>
			</div>
			<div class="col-sm-4">
				<label>Withdrawals</label>
				<textarea name="Withdrawals" class="form-control input-lg" rows="3"><?php echo $bookmaker['Withdrawals'];?></textarea>
			</div>
			<div class="col-sm-4">
				<label>Deposits</label>
				<textarea name="Deposits" class="form-control input-lg" rows="3"><?php echo $bookmaker['Deposits'];?></textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-2">
				<label>Show Odds</label>
				<br>
				<input type="radio" name="DisplayOdds" value="0"<?php if ($bookmaker['DisplayOdds'] == 0) { echo ' checked';}?>>&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="DisplayOdds" value="1"<?php if ($bookmaker['DisplayOdds'] == 1) { echo ' checked';}?>>&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>Bonuses</label>
				<br>
				<input type="radio" name="Bonuses" value="0"<?php if ($bookmaker['Bonuses'] == 0) { echo ' checked';}?>>&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="Bonuses" value="1"<?php if ($bookmaker['Bonuses'] == 1) { echo ' checked';}?>>&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>Live chat</label>
				<br>
				<input type="radio" name="Livechat" value="0"<?php if ($bookmaker['Livechat'] == 0) { echo ' checked';}?>>&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="Livechat" value="1"<?php if ($bookmaker['Livechat'] == 1) { echo ' checked';}?>>&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>Mobile betting</label>
				<br>
				<input type="radio" name="MobileBetting" value="0"<?php if ($bookmaker['MobileBetting'] == 0) { echo ' checked';}?>>&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="MobileBetting" value="1"<?php if ($bookmaker['MobileBetting'] == 1) { echo ' checked';}?>>&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>SMS betting</label>
				<br>
				<input type="radio" name="SmsBetting" value="0"<?php if ($bookmaker['SmsBetting'] == 0) { echo ' checked';}?>>&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="SmsBetting" value="1"<?php if ($bookmaker['SmsBetting'] == 1) { echo ' checked';}?>>&nbsp;Yes
			</div>
			<div class="col-sm-2">
				<label>Casino</label>
				<br>
				<input type="radio" name="Casino" value="0"<?php if ($bookmaker['Casino'] == 0) { echo ' checked';}?>>&nbsp;No&nbsp;&nbsp;
				<input type="radio" name="Casino" value="1"<?php if ($bookmaker['Casino'] == 1) { echo ' checked';}?>>&nbsp;Yes
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-3">
				<label>Withdrawal commission</label>
				<input type="number" name="WithdrawalTax" class="form-control input-lg" min="0.00" max="1.00" step="0.01" value="<?php echo $bookmaker['WithdrawalTax'];?>">
			</div>
			<div class="col-sm-3">
				<label>Lower betting limit</label>
				<input type="number" name="MinBetLimit" class="form-control input-lg" min="0.00" step="0.01" value="<?php echo $bookmaker['MinBetLimit'];?>">
			</div>
			<div class="col-sm-3">
				<label>Upper betting limit</label>
				<input type="number" name="MaxBetLimit" class="form-control input-lg" min="0.00" step="0.01" value="<?php echo $bookmaker['MaxBetLimit'];?>">
			</div>
			<div class="col-sm-3">
				<label>Licensed (text)</label>
				<input type="text" name="Licensed" class="form-control input-lg"  value="<?php echo $bookmaker['Licensed'];?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-2">
				<label>Ease of use rating</label>
				<input type="number" class="form-control input-lg" name="RatingUse" min="0.0" max="10.0" step="0.1" value="<?php echo $bookmaker['RatingUse'];?>">
			</div>
			<div class="col-sm-2">
				<label>Games offer rating</label>
				<input type="number" class="form-control input-lg" name="RatingGames" min="0.0" max="10.0" step="0.1" value="<?php echo $bookmaker['RatingGames'];?>">
			</div>
			<div class="col-sm-2">
				<label>Bonus rating</label>
				<input type="number" class="form-control input-lg" name="RatingBonus" min="0.0" max="10.0" step="0.1" value="<?php echo $bookmaker['RatingBonus'];?>">
			</div>
			<div class="col-sm-2">
				<label>Service rating</label>
				<input type="number" class="form-control input-lg" name="RatingService" min="0.0" max="10.0" step="0.1" value="<?php echo $bookmaker['RatingService'];?>">
			</div>
			<div class="col-sm-2">
				<label>Mobile rating</label>
				<input type="number" class="form-control input-lg" name="RatingMobile" min="0.0" max="10.0" step="0.1" value="<?php echo $bookmaker['RatingMobile'];?>">
			</div>
			<div class="col-sm-2">
				<label>Withdrawal rating</label>
				<input type="number" class="form-control input-lg" name="RatingWithdraw" min="0.0" max="10.0" step="0.1" value="<?php echo $bookmaker['RatingWithdraw'];?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Logo image (png/jpeg - only select if you want to replace the existing)*</label>
				<input type="file" name="Logo">
				<br>
				<?php if (!empty($bookmaker['Logo']) && file_exists(FCPATH . '/uploads/' . $bookmaker['Logo'])) { ?>
				<img src="/uploads/<?php echo $bookmaker['Logo'];?>" class="img img-responsive thumbnail pull-right" style="width:200px;">
				<?php } ?>
				<div class="clearfix">&nbsp;</div>
				<label>Logo image alternate text (alt)</label>
				<input type="text" name="LogoAlt" class="form-control input-lg" value="<?php echo $bookmaker['LogoAlt'];?>">
			</div>
			<div class="col-sm-6">
				<label>Cover image (png/jpeg - only select if you want to replace the existing)*</label>
				<input type="file" name="Cover">
				<br>
				<?php if (!empty($bookmaker['Cover']) && file_exists(FCPATH . '/uploads/' . $bookmaker['Cover'])) { ?>
				<img src="/uploads/<?php echo $bookmaker['Cover'];?>" class="img img-responsive thumbnail pull-right" style="width:400px;">
				<?php } ?>
				<div class="clearfix">&nbsp;</div>
				<label>Cover image alternate text (alt)</label>
				<input type="text" name="CoverAlt" class="form-control input-lg" value="<?php echo $bookmaker['CoverAlt'];?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-6">
				<label>About (text)</label>
				<textarea name="About" class="form-control input-lg" rows="5"><?php echo htmlspecialchars($bookmaker['About']);?></textarea>
				<br>
				<label>URL:</label>
				<input type="text" name="Link" class="form-control input-lg" value="<?php echo $bookmaker['Link'];?>">
			</div>
			<div class="col-sm-6">
				<label>Description (text, html formatting is permitted)</label>
				<textarea name="Description" class="form-control input-lg" rows="10"><?php echo htmlspecialchars($bookmaker['Description']);?></textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-lg btn-primary" value="Update">
			</div>
		</div>
	</form>
</div>
