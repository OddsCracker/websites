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
if (count($campaigns) == 0) {
?>
	<p class="alert alert-warning">No campaigns defined!</p>
	<p class="text-center"><a href="/admin/add_campaign">Add campaign</a></p>
<?php
} else {
?>
	<h3 class="text-center"><?php echo count($campaigns);?> CPC campaings</h3>
	<table id="campaigns_table" class="table table-bordered">
		<thead>
			<tr>
				<th>Bookmaker</th>
				<th>Campaign type</th>
				<th>Start date</th>
				<th>End date</th>
				<th>Budget type</th>
				<th>Budget</th>
				<th>Cost per Click</th>
				<th class="text-center">Manage</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($campaigns as $key => $value): ?>
			<tr>
				<td><?php echo $value['Name'];?></td>
				<td><?php if ($value['Ongoing'] > 0) { echo 'Ongoing'; } else { echo 'Fixed duration'; } ?></td>
				<td><?php if ($value['StartDate'] > 0) { echo date('Y-m-d', $value['StartDate']); } ?></td>
				<td><?php if ($value['EndDate'] > 0) { echo date('Y-m-d', $value['EndDate']); } ?></td>
				<td><?php if ($value['Budget'] == 0) { echo 'Flexible'; } else { echo 'Fixed'; } ?></td>
				<td><?php echo $value['Budget'];?></td>
				<td><?php echo $value['CostPerClick'];?></td>
				<td class="text-center">
					<a href="/admin/view_campaign/<?php echo $key;?>" title="View details"><i class="fa fa-lg fa-eye"></i></a>&nbsp;&nbsp;
					<a href="/admin/edit_campaign/<?php echo $key;?>" title="Edit"><i class="fa fa-lg fa-edit"></i></a>&nbsp;&nbsp;
					<a href="/admin/delete_campaign/<?php echo $key;?>" title="Delete" class="confirm"><i class="fa fa-lg fa-remove"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<p class="text-center"><a href="/admin/add_campaign">Add campaign</a></p>
<?php
}
?>