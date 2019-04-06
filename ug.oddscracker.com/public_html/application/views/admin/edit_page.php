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
if ($page) {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/pages">Pages</a></li>
		<li>Edit <?php echo $page['Name'];?></li>
	</ul>
	<h3 class="text-center">Edit <strong><?php echo $page['Name'];?></strong></h3>
	<form class="form form-horizontal" role="form" method="post" action="/admin/update_page">
		<input type="hidden" name="PageID" value="<?php echo $page['PageID'];?>">
		<div class="form-group">
			<div class="col-sm-6">
				<label>Meta title*</label>
				<textarea name="MetaTitle" class="form-control input-lg" rows="3" required="required"><?php echo $page['MetaTitle'];?></textarea>
			</div>
			<div class="col-sm-6">
				<label>Meta description</label>
				<textarea name="MetaDescription" class="form-control input-lg" rows="3"><?php echo $page['MetaDescription'];?></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label>Heading</label>
				<textarea name="Heading" class="form-control input-lg" rows="3"><?php echo $page['Heading'];?></textarea>
			</div>
			<div class="col-sm-6">
				<label>HTML static content (you can use html tags)</label>
				<textarea name="Html" class="form-control input-lg" rows="10"><?php echo htmlspecialchars($page['Html']);?></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-lg btn-primary" value="Update">
			</div>
		</div>
	</form>
<?php
}
?>
</div>
