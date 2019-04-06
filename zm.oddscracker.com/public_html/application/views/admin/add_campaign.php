<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.datepicker').datepicker();
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
		<li>Add New Campaign</li>
	</ul>
	<h3 class="text-center">Add new campaign</h3>
	<br>
	<?php if ($this->session->flashdata('error')) { echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';}?>
	<form class="form form-horizontal" role="form" method="post" action="/admin/save_campaign">
		<div class="form-group">
			<div class="col-sm-4">
				<label>Select bookmaker</label>
				<select name="BookmakerID" class="form-control input-lg" required="required">
					<?php foreach ($bookmakers as $key => $value): ?>
					<option value="<?php echo $value['BookmakerID'];?>"><?php echo $value['Name'];?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-sm-4">
				<label>Campaign budget (leave 0 if budget is unlimited)</label>
				<input type="number" name="Budget" class="form-control input-lg" required="required" value="0" step="0.01">
			</div>
			<div class="col-sm-4">
				<label>Cost per Click</label>
				<input type="number" name="CostPerClick" class="form-control input-lg" required="required" step="0.001">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4">
				<label>Timeframe (ongoing vs. fixed)</label>
				<select name="Ongoing" class="form-control input-lg" required="required">
					<option value="1">Ongoing</option>
					<option value="0">Fixed time</option>
				</select>
			</div>
			<div id="timeframe" style="display:none;">
				<div class="col-sm-4">
					<label>Start date</label>
					<input type="text" name="StartDate" class="form-control input-lg datepicker">
				</div>
				<div class="col-sm-4">
					<label>End date</label>
					<input type="text" name="EndDate" class="form-control input-lg datepicker">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-lg btn-primary" value="Save">
			</div>
		</div>
	</form>
</div>