<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-12" style="width:100%;">
	<h1 class="page-title"><?php echo $page['Heading'];?></h1>
	<br>
	<div class="row">
		<?php echo $page['Html'];?>
	</div>
	<script type="text/javascript">if (window.innerHeight > window.innerWidth) { alert('Landscape orientation is recommended on this page to view it correctly!');}</script>
	<div class="row">
		<table class="table-striped">
			<thead>
				<tr>
					<th></th>
				<?php foreach ($bookmakers as $key => $value) { echo '<th><a href="/bookmakers/reviews/' . $value['Slug'] . '" title="' . $value['Name'] . '"><img src="/uploads/' . $value['Logo'] . '" class="img img-responsive center-block" alt="' . $value['LogoAlt'] . '" title="' . $value['Name'] . '"></a></th>'; }?>
				</tr>
			</thead>
			<tbody>
				<tr class="text-center">
					<td>Paris en direct</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['LiveBetting'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Parier sur le mobile</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['MobileBetting'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Jackpots</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['Jackpots'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Bonus</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['Bonuses'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Programmes de référence</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['Referrals'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Pari par SMS</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['SmsBetting'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Casino</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['Casino'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Assistance par chat en direct</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['Livechat'] > 0) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Limite de mise inférieure</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['MinBetLimit'] > 0) { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} else { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Limite supérieure de pari</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['MaxBetLimit'] > 0) { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} else { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Frais de retrait</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if ($value['WithdrawalTax'] > 0) { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} else { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Restrictions de pays</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if (strlen($value['RestrictedCountries']) > 0) { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} else { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} echo '</td>'; }?>
				</tr>
				<tr class="text-center">
					<td>Retraits MPESA</td>
				<?php foreach ($bookmakers as $key => $value) { echo '<td>'; if (stristr($value['Withdrawals'], 'mpesa')) { echo '<i class="fa fa-lg fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-lg fa-times-circle text-danger"></i>';} echo '</td>'; }?>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="grey-bg text-center row">
		<div class="col-sm-6">
			<a 
			href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/bookmakers/comparison/" 
			class="facebook-share" 
			title="Share on Facebook" 
			target="_blank">
				<i class="fa fa-lg fa-facebook"></i> Partager sur Facebook
			</a>
		</div>
		<div class="col-sm-6">
			<a 
			href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/bookmakers/comparison/&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/bookmakers/comparison/" 
			class="twitter-share" 
			title="Share on Twitter" 
			target="_blank">
				<i class="fa fa-lg fa-twitter" target="_blank"></i> Partager sur Twitter
			</a>
		</div>
	</div>
</div>
