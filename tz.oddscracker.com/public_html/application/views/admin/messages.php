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
if (count($messages) == 0) {
?>
	<p class="alert alert-info">No site messages stored!</p>
<?php
} else {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Messages</li>
	</ul>
	<h3 class="text-center">Site messages (contact form)</h3>
	<table id="messages_table" class="table table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Author</th>
				<th>Status</th>
				<th>IP address</th>
				<th>Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($messages as $key => $value) {
			?>
			<tr<?php if ($value['IsRead'] == 0) { echo ' style="font-weight:900;"';}?>>
				<td><?php echo $value['DateTime'];?></td>
				<td><?php echo $value['Name'];?></td>
				<td><?php if ($value['IsRead'] > 0) { echo 'READ';} else { echo 'UNREAD';}?></td>
				<td><?php echo $value['IpAddr'];?></td>
				<td>
					<a href="/admin/view_message/<?php echo $key;?>" title="Read">Read</a>&nbsp;
					<a href="/admin/delete_message/<?php echo $key;?>" class="confirm" title="Delete">Delete</a>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<?php
}
?>
</div>
