<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/pages">Pages</a></li>
		<li><?php echo $page['Name'];?></li>
	</ul>
	<h3 class="text-center"><strong><?php echo $page['Name'];?></strong> details</h3>
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
			<tr><td>Name</td><td><?php echo $page['Name'];?></td></tr>
			<tr><td>Slug</td><td><?php echo $page['Slug'];?></td></tr>
			<tr><td>Meta title</td><td><?php echo $page['MetaTitle'];?></td></tr>
			<tr><td>Meta description</td><td><?php echo $page['MetaDescription'];?></td></tr>
			<tr><td>Heading</td><td><?php echo htmlspecialchars($page['Heading']);?></td></tr>
			<tr><td>Html</td><td><?php echo nl2br(htmlspecialchars($page['Html']));?></td></tr>
		</tbody>
	</table>
	<p class="text-center">
		<a href="/admin/edit_page/<?php echo $page['PageID'];?>" class="btn btn-lg btn-primary" title="Edit">Edit page</a>
	</p>
</div>
