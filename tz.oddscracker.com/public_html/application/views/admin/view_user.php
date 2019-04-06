<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/users">Users</a></li>
		<li><?php echo $user['Username'];?></li>
	</ul>
	<h3 class="text-center"><strong><?php echo $user['Username'];?></strong> details</h3>
	<?php
	if ($this->session->flashdata('success')) {
		echo '<p class="alert alert-success">' . $this->session->flashdata('success') . '</p>';
	}
	if ($this->session->flashdata('error')) {
		echo '<p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';
	}
	?>
	<table class="table table-responsive">
		<tbody>
			<tr><td>Username (nickname)</td><td><?php echo $user['Username'];?></td></tr>
			<tr><td>First name</td><td><?php echo $user['FirstName'];?></td></tr>
			<tr><td>Last name</td><td><?php echo $user['LastName'];?></td></tr>
			<tr><td>Email</td><td><?php echo $user['Email'];?></td></tr>
			<tr><td>Country</td><td><?php echo $user['Country'];?></td></tr>
			<tr><td>Active</td><td><?php if ($user['Active'] > 0) { echo '<i class="fa fa-lg fa-check text-success"></i>';} else { echo '<i class="fa fa-lg fa-minus-circle text-danger"></i>';}?></td></tr>
			<tr><td>Login type</td><td><?php if ($user['FacebookLogin'] > 0) { echo 'Facebook';} elseif ($user['GoogleLogin'] > 0) { echo 'Google';} else { echo 'Form';}?></td></tr>
			<tr><td>Last login</td><td><?php echo $user['LastLogin'];?></td></tr>
		</tbody>
	</table>
	<p class="text-center">
		<a href="/admin/edit_user/<?php echo $user['UserID'];?>" class="btn btn-lg btn-primary" title="Edit">Edit user</a>
	</p>
</div>
