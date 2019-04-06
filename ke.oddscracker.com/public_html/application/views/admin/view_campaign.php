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
	<h3 class="text-center">CPC campaign for <strong><?php echo $campaign['bookmaker']['Name'];?></strong></h3>
	<table class="table table-bordered">
		<tr>
			<td>Status</td>
			<td><?php if ($campaign['Active'] > 0) { echo 'Active';} else { echo 'Inactive';} ?></td>
		</tr>
		<tr>
			<td>Time frame</td>
			<td><?php if ($campaign['Ongoing'] > 0) { echo 'Ongoing';} else { echo "Fixed";} ?></td>
		</tr>
		<tr>
			<td>Start date</td>
			<td><?php if ($campaign['StartDate'] > 0) { echo date('Y-m-d', $campaign['StartDate']); } ?></td>
		</tr>
		<tr>
			<td>End date</td>
			<td><?php if ($campaign['EndDate'] > 0) { echo date('Y-m-d', $campaign['EndDate']); } ?></td>
		</tr>
		<tr>
			<td>Budget type</td>
			<td><?php if ($campaign['Budget'] > 0) { echo 'Fixed budget'; } else { echo 'Flexible'; } ?></td>
		</tr>
		<tr>
			<td>Budget</td>
			<td><?php echo number_format($campaign['Budget'], 2, '.', ','); ?></td>
		</tr>
		<tr>
			<td>Cost per Click</td>
			<td><?php echo $campaign['CostPerClick'];?></td>
		</tr>
		<tr>
			<td>Campaign analytics (share view with bookmaker)</td>
			<td><a href="/campaign/<?php echo $campaign['Token'];?>" target="_blank"><?php echo $settings['abs_url'] . '/campaign/' . $campaign['Token'];?></a></td>
		</tr>
	</table>
	<p class="text-center">
		<a href="/admin/edit_campaign/<?php echo $campaign['CampaignID'];?>" class="btn btn-lg btn-info">Edit</a>&nbsp;&nbsp;
		<a href="/admin/delete_campaign/<?php echo $campaign['CampaignID'];?>" class="btn btn-lg btn-danger confirm">Delete</a>
	</p>
</div>