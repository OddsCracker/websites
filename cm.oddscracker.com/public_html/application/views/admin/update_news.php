<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<br>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>News Update</li>
	</ul>
	<p><?php echo nl2br($log);?></p>
	<p>Summary:<br><?php foreach ($count as $key => $value) { echo 'Imported ' . $value . ' news from ' . $key . '<br>';}?></p>
</div>
