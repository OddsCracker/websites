<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
<script type="text/javascript">
$(document).ready(function(){
	$('#login_modal').modal();
});
</script>
	<h2 class="page-title"><?php echo $page['Heading'];?></h2>
	<div class="row">
		<?php echo nl2br($page['Html']);?>
	</div>
</div>
