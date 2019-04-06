<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.datepicker').datepicker();
	var Ongoing = $('select[name="Ongoing"]').val();
	if (Ongoing == 0) {
		$('#timeframe').css('display', 'block');
	} else {
		$('#timeframe').css('display', 'none');
	}
});
$(document).on('change', 'select[name="Ongoing"]', function(){
	var Ongoing = $(this).val();
	if (Ongoing == 0) {
		$('#timeframe').css('display', 'block');
	} else {
		$('#timeframe').css('display', 'none');
	}
});
</script>
<style type="text/css"><?php echo file_get_contents(FCPATH . '/css/bootstrap-datepicker.css');?></style>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/campaigns">Campaigns</a></li>
		<li>Edit <?php echo $campaign['bookmaker']['Name']; ?> Campaign</li>
	</ul>
	<br>
	<?php if ($this->session->flashdata('error')) { echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';}?>
	<form class="form form-horizontal" role="form" method="post" action="/admin/update_campaign">
		<input type="hidden" name="CampaignID" value="<?php echo $campaign['CampaignID'];?>">
		<div class="form-group">
			<div class="col-sm-4">
				<label>Select bookmaker</label>
				<select name="BookmakerID" class="form-control input-lg" required="required">
					<?php foreach ($bookmakers as $key => $value): ?>
					<option value="<?php echo $value['BookmakerID'];?>"<?php if ($campaign['BookmakerID'] == $key) { echo ' selected="selected"'; } ?>><?php echo $value['Name'];?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-sm-4">
				<label>Campaign budget (leave 0 if budget is unlimited)</label>
				<input type="number" name="Budget" class="form-control input-lg" required="required" value="<?php echo $campaign['Budget']?>" step="0.01">
			</div>
			<div class="col-sm-4">
				<label>Cost per Click</label>
				<input type="number" name="CostPerClick" class="form-control input-lg" required="required" step="0.001" value="<?php echo $campaign['CostPerClick']; ?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3">
				<label>Status</label>
				<select name="Active" class="form-control input-lg" required="required">
					<option value="1"<?php if ($campaign['Active'] > 0) { echo ' selected="selected"'; } ?>>Active</option>
					<option value="0"<?php if ($campaign['Active'] == 0) { echo ' selected="selected"'; } ?>>Inactive</option>
				</select>
			</div>
			<div class="col-sm-3">
				<label>Timeframe (ongoing vs. fixed)</label>
				<select name="Ongoing" class="form-control input-lg" required="required">
					<option value="1"<?php if ($campaign['Ongoing'] > 0) { echo ' selected="selected"'; } ?>>Ongoing</option>
					<option value="0"<?php if ($campaign['Ongoing'] == 0) { echo ' selected="selected"'; } ?>>Fixed time</option>
				</select>
			</div>
			<div id="timeframe" style="display:none;">
				<div class="col-sm-3">
					<label>Start date</label>
					<input type="text" name="StartDate" class="form-control input-lg datepicker" value="<?php if ($campaign['StartDate'] > 0) { echo date('Y/m/d', $campaign['StartDate']); } ?>">
				</div>
				<div class="col-sm-3">
					<label>End date</label>
					<input type="text" name="EndDate" class="form-control input-lg datepicker" value="<?php if ($campaign['EndDate'] > 0) { echo date('Y/m/d', $campaign['EndDate']); } ?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-lg btn-primary" value="Update">
			</div>
		</div>
	</form>
</div>