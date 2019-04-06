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
if (count($users) == 0) {
?>
	<p class="alert alert-warning">No users in the database!</p>
<?php
} else {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Users</li>
	</ul>
	<h3 class="text-center">Users</h3>
	<table id="users_table" class="table table-bordered">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Email</th>
				<th>Login type</th>
				<th>Active</th>
				<th>Manage</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($users as $key => $value) {
		?>
			<tr>
				<td><?php echo $key;?></td>
				<td><a href="/admin/user_info/<?php echo $key;?>"><?php echo $value['Username'];?></a></td>
				<td><?php echo $value['Email'];?></td>
				<td><?php if ($value['FacebookLogin'] > 0) { echo 'Facebook';} elseif ($value['GoogleLogin'] > 0) { echo 'Google';} else { echo 'Site Form';}?></td>
				<td><?php echo $value['Active'];?></td>
				<td>
					<a href="/admin/edit_user/<?php echo $key;?>" title="Edit"><i class="fa fa-lg fa-edit"></i></a>&nbsp;&nbsp;
					<a href="/admin/delete_user/<?php echo $key;?>" title="Delete" class="confirm"><i class="fa fa-lg fa-remove"></i></a>
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
