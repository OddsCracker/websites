<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<br>
<div class="container">
<?php
if (isset($message)) {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/messages">Messages</a></li>
		<li>Message #<?php echo $message['MessageID'];?></li>
	</ul>
	<h3>Message #<?php echo $message['MessageID'];?></h3>
	<table class="table table-bordered">
		<tbody>
			<tr><td>Date and time:</td><td><?php echo $message['DateTime'];?></td></tr>
			<tr><td>Author name:</td><td><?php echo $message['Name'];?></td></tr>
			<tr><td>Author email:</td><td><a href="mailto:<?php echo $message['Email'];?>"><?php echo $message['Email'];?></a></td></tr>
			<tr><td>Author phone:</td><td><?php echo $message['Phone'];?></td></tr>
			<tr><td>Author IP address:</td><td><?php echo $message['IpAddr'];?></td></tr>
			<tr><td>Text:</td><td><?php echo nl2br($message['Message']);?></td></tr>
		</tbody>
	</table>
	<p class="text-center">
		<a href="/admin/delete_message/<?php echo $message['MessageID'];?>" class="confirm btn btn-lg btn-danger" title="Delete"><i class="fa fa-fw fa-remove"></i> Delete</a>
	</p>
<?php
}
?>
</div>
