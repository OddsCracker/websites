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
if (count($bookmakers) == 0) {
?>
	<p class="alert alert-warning">No bookmakers!</p>
	<p class="text-center"><a href="/admin/add_bookmaker">Add a bookmaker</a></p>
<?php
} else {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Bookmakers</li>
	</ul>
	<h3 class="text-center">Bookmakers</h3>
	<p class="text-center"><a href="/admin/add_bookmaker" class="btn btn-primary">Add new bookmaker</a></p>
	<table id="bookmakers_table" class="table table-bordered">
		<thead>
			<tr>
				<th>ID</th>
				<th>Order</th>
				<th>Name</th>
				<th>Logo</th>
				<th>Rating</th>
				<th>Manage</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($bookmakers as $key => $value) {
		?>
			<tr>
				<td><?php echo $key;?></td>
				<td><?php echo $value['SortOrder'];?></td>
				<td><a href="/admin/bookmaker_info/<?php echo $value['Slug'];?>"><?php echo $value['Name'];?></a></td>
				<td><img src="/uploads/<?php echo $value['Logo'];?>" class="img img-responsive"></td>
				<td><?php echo $value['Rating'];?></td>
				<td>
					<a href="/admin/edit_bookmaker/<?php echo $value['Slug'];?>" title="Edit"><i class="fa fa-lg fa-edit"></i></a>&nbsp;&nbsp;
					<a href="/admin/delete_bookmaker/<?php echo $value['Slug'];?>" title="Delete" class="confirm"><i class="fa fa-lg fa-remove"></i></a>
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
