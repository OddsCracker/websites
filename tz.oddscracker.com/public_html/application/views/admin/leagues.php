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
if (count($leagues) == 0) {
?>
	<p class="alert alert-info">No leagues defined!</p>
	<p class="text-center"><a href="/admin/add_league" class="btn btn-primary">Add League</a></p>
<?php
} else {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Leagues</li>
	</ul>
	<h3 class="text-center">Leagues</h3>
	<p class="text-center"><a href="/admin/add_league" class="btn btn-primary">Add New League</a></p>
	<table id="leagues_table" class="table table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Country</th>
				<th>Continent</th>
				<th>Display order</th>
				<th>Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($leagues as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['Name'];?></td>
				<td><?php echo $value['CountryName'];?></td>
				<td><?php echo $value['ContinentName'];?></td>
				<td><?php echo $value['SortOrder'];?></td>
				<td>
					<a href="/admin/edit_league/<?php echo $key;?>" title="Edit"><i class="fa fa-lg fa-edit"></i></a>&nbsp;
					<a href="/admin/delete_league/<?php echo $key;?>" class="confirm" title="Delete"><i class="fa fa-lg fa-remove"></i></a>
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
