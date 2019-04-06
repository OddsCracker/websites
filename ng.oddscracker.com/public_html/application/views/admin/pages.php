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
if (count($pages) == 0) {
?>
	<p class="alert alert-warning">No pages in the database!</p>
<?php
} else {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Pages</li>
	</ul>
	<h3 class="text-center">Pages</h3>
	<table id="pages_table" class="table table-responsive table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Slug</th>
				<th>Meta title</th>
				<th>Meta description</th>
				<th>Heading</th>
				<th>HTML (static content)</th>
				<th>Manage</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($pages as $key => $value) {
		?>
			<tr>
				<td><a href="/admin/page_info/<?php echo $key;?>"><?php echo $value['Name'];?></a></td>
				<td><?php echo $value['Slug'];?></td>
				<td><?php echo $value['MetaTitle'];?></td>
				<td><?php echo $value['MetaDescription'];?></td>
				<td><?php echo $value['Heading'];?></td>
				<td>
					<?php echo substr(htmlspecialchars($value['Html']), 0, 100);?> ...
					
				</td>
				<td>
					<a href="/admin/edit_page/<?php echo $key;?>" title="Edit"><i class="fa fa-lg fa-edit"></i></a>&nbsp;&nbsp;
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
