<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Bans</li>
	</ul>
	<?php
	if ($this->session->flashdata('error')) {
		echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';
	}
	if ($this->session->flashdata('success')) {
		echo '<p class="alert alert-success">' . $this->session->flashdata('success') . '</p>';
	}
	if (!$bans) {
		?>
		<p class="alert alert-info">No active IP bans!</p>
		<?php
	} else {
		?>
		<h3 class="text-center">Active IP bans</h3>
		<table id="bans_table" class="table table-bordered">
			<thead>
				<tr>
					<th class="hidden"></th>
					<th>IP address</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($bans as $key => $value) { ?>
				<tr>
					<td class="hidden"><?php echo $key;?></td>
					<td><?php echo $value;?></td>
					<td><a href="/admin/delete_ban/<?php echo $key;?>" title="Delete"><i class="fa fa-lg fa-remove"></i></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php
	}
	?>
</div>