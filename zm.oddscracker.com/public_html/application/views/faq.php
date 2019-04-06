<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h2 class="page-title"><?php echo $page['Heading'];?></h2>
	<br>
	<div class="row">
		<?php echo $page['Html'];?>
		<?php
		if (!get_cookie('__dismiss_info_strip')) {
			$expire = time()+30*86400;
			setcookie('__dismiss_info_strip', md5(time()), $expire, '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
			?>
			<script type="text/javascript">
				document.getElementById('topnav').style.marginTop = '0px';
				document.getElementById('info-strip').style.visibility='hidden';
			</script>
			<?php
		}
		?>
	</div>
</div>
