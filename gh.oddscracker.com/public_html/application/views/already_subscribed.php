<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h2 class="page-title">Subscribe to our newsletter</h2>
	<br>
	<h4>Already subscribed, thank you!</h4>
	<div class="row">
		<p>Thank you, but your email already exists in our subscription list.</p>
		<p>You will be returned to the Oddscracker homepage in 3 seconds.</p>
		<p>Click <a href="/">here</a> if you are not redirected.</p>
		<meta http-equiv="refresh" content="3,url=<?php echo $settings['abs_url']; ?>">
		<hr>
		<p class="text-center">
			<a href="http://www.aweber.com/antispam.htm" target="_blank">No Spam Policy</a>&nbsp;&amp;&nbsp;
			<a href="http://www.aweber.com/permission.htm" target="_blank">Privacy Policy</a>
		</p>
	</div>
</div>