<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li><a href="/admin/">Dashboard</a></li>
		<li><a href="/admin/bookmakers">Bookmakers</a></li>
		<li><?php echo $bookmaker['Name'];?></li>
	</ul>
	<h3 class="text-center"><strong><?php echo $bookmaker['Name'];?></strong> details</h3>
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
			<tr><td>Dispay order</td><td><?php echo $bookmaker['SortOrder'];?></td></tr>
			<tr><td>Name</td><td><?php echo $bookmaker['Name'];?></td></tr>
			<tr><td>Slug</td><td><?php echo $bookmaker['Slug'];?></td></tr>
			<tr><td>URL</td><td><a href="<?php echo $bookmaker['Link'];?>" target="_blank"><?php echo $bookmaker['Link'];?></a></td></tr>
			<tr><td>About</td><td><?php echo nl2br($bookmaker['About']);?></td></tr>
			<tr><td>Description</td><td><?php echo nl2br(htmlspecialchars($bookmaker['Description']));?></td></tr>
			<tr><td>Restricted countries</td><td><?php echo $bookmaker['RestrictedCountries'];?></td></tr>
			<tr><td>Software</td><td><?php echo $bookmaker['Software'];?></td></tr>
			<tr><td>Licensed</td><td><?php echo $bookmaker['Licensed'];?></td></tr>
			<tr><td>Deposits</td><td><?php echo $bookmaker['Deposits'];?></td></tr>
			<tr><td>Withdrawals</td><td><?php echo $bookmaker['Withdrawals'];?></td></tr>
			<tr><td>Withdrawal fees</td><td><?php echo $bookmaker['WithdrawalTax'];?></td></tr>
			<tr><td>Lower betting limit</td><td><?php echo $bookmaker['MinBetLimit'];?></td></tr>
			<tr><td>Upper betting limit</td><td><?php echo $bookmaker['MaxBetLimit'];?></td></tr>
			<tr><td>Bonuses</td><td><?php if ($bookmaker['Bonuses'] > 0) { echo '<i class="fa fa-fw fa-check text-success"></i>';} else { echo '<i class="fa fa-fw fa-minus-circle text-danger"></i>';}?></td></tr>
			<tr><td>Livechat</td><td><?php if ($bookmaker['Livechat'] > 0) { echo '<i class="fa fa-fw fa-check text-success"></i>';} else { echo '<i class="fa fa-fw fa-minus-circle text-danger"></i>';}?></td></tr>
			<tr><td>Mobile betting</td><td><?php if ($bookmaker['MobileBetting'] > 0) { echo '<i class="fa fa-fw fa-check text-success"></i>';} else { echo '<i class="fa fa-fw fa-minus-circle text-danger"></i>';}?></td></tr>
			<tr><td>SMS Betting</td><td><?php if ($bookmaker['SmsBetting'] > 0) { echo '<i class="fa fa-fw fa-check text-success"></i>';} else { echo '<i class="fa fa-fw fa-minus-circle text-danger"></i>';}?></td></tr>
			<tr><td>Casino</td><td><?php if ($bookmaker['Casino'] > 0) { echo '<i class="fa fa-fw fa-check text-success"></i>';} else { echo '<i class="fa fa-fw fa-minus-circle text-danger"></i>';}?></td></tr>
			<tr><td>Show odds to anonymous users</td><td><?php if ($bookmaker['DisplayOdds'] > 0) { echo '<i class="fa fa-fw fa-check text-success"></i>';} else { echo '<i class="fa fa-fw fa-minus-circle text-danger"></i>';}?></td></tr>
			<tr><td>Ease of use rating</td><td><?php echo $bookmaker['RatingUse'];?></td></tr>
			<tr><td>Games offer rating</td><td><?php echo $bookmaker['RatingGames'];?></td></tr>
			<tr><td>Bonuses rating</td><td><?php echo $bookmaker['RatingBonus'];?></td></tr>
			<tr><td>Service rating</td><td><?php echo $bookmaker['RatingService'];?></td></tr>
			<tr><td>Mobile experience rating</td><td><?php echo $bookmaker['RatingMobile'];?></td></tr>
			<tr><td>Withdrawals rating</td><td><?php echo $bookmaker['RatingWithdraw'];?></td></tr>
			<tr><td>Logo</td><td><?php if (!empty($bookmaker['Logo']) && file_exists(FCPATH . '/uploads/' . $bookmaker['Logo'])) { ?><img src="/uploads/<?php echo $bookmaker['Logo'];?>" class="img img-responsive center-block"><?php } ?></td></tr>
			<tr><td>Logo alternate text</td><td><?php echo $bookmaker['LogoAlt'];?></td></tr>
			<tr><td>Cover</td><td><?php if (!empty($bookmaker['Cover']) && file_exists(FCPATH . '/uploads/' . $bookmaker['Cover'])) { ?><img src="/uploads/<?php echo $bookmaker['Cover'];?>" class="img img-responsive center-block"><?php } ?></td></tr>
			<tr><td>Cover alternate text</td><td><?php echo $bookmaker['CoverAlt'];?></td></tr>
			<tr><td>User LIKES</td><td><?php echo $bookmaker['likes'];?></td></tr>
			<tr><td>User DISLIKES</td><td><?php echo $bookmaker['dislikes'];?></td></tr>
		</tbody>
	</table>
	<p class="text-center">
		<a href="/admin/edit_bookmaker/<?php echo $bookmaker['Slug'];?>" class="btn btn-lg btn-primary" title="Edit">Edit Bookmaker</a>&nbsp;&nbsp;
		<a href="/admin/delete_bookmaker/<?php echo $bookmaker['Slug'];?>" title="Delete" class="confirm btn btn-lg btn-danger">Delete Bookmaker</a>
	</p>
</div>
