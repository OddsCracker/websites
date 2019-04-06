<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h2 class="page-title">Account activation</h2>
<?php
if ($this->session->flashdata('error')){
?>
	<br>
	<p class="alert alert-danger"><?php echo $this->session->flashdata('error');?></p>
<?php
}
if ($this->session->flashdata('success')){
?>
	<br>
	<p class="alert alert-success"><?php echo $this->session->flashdata('success');?></p>
	<script type="text/javascript">
	window.setTimeout(function(){
		$('#login_modal').modal();
	}, 3000);
	</script>
<?php
}
?>
</div>
