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
if (count($newsletter) == 0) {
?>
	<p class="alert alert-info">No newsletter subscriptions!</p>
<?php
} else {
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li>Newsletter list</li>
	</ul>
	<h3 class="text-center">Newsletter subscriptions</h3>
	<p class="text-center">
		<a href="#" id="send_newsletter_btn" class="btn btn-lg btn-primary">Send Newsletter</a>
	</p>
	<div id="newsletter_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content newsletter-modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="text-center">Send email to all subscribers!</h3>
					<div class="row">
						<form method="post" action="/admin/send_newsletter">
							<div class="form-group">
								<label>Email subject (title)</label>
								<input type="text" name="Subject" class="form-control input-lg" requred="required">
							</div>
							<div class="form-group">
								<label>Message (you can use HTML formatting)</label>
								<textarea name="Message" class="form-control input-lg" required="required" rows="10"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-lg btn-subscribe" value="Send Now">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<table id="subscriptions_table" class="table table-bordered">
		<thead>
			<tr>
				<th>Subscription ID</th>
				<th>Email</th>
				<th>Date subscribed</th>
				<th>Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($newsletter as $key => $value) {
			?>
			<tr>
				<td><?php echo $key;?></td>
				<td><?php echo $value['Email'];?></td>
				<td><?php echo $value['SubscriptionDate'];?></td>
				<td>
					<a href="/admin/delete_subscription/<?php echo $key;?>" class="confirm" title="Delete">Delete</a>
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
