<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h1 class="page-title"><?php echo $page['Heading'];?></h1>
	<br>
	<div class="row">
		<?php echo $page['Html'];?>
		<?php
		if (count($jackpots) > 0) {
			?>
			<table class="table table-responsive">
				<thead>
					<tr>
						<th class="text-center">Bookmaker</th>
						<th>Games</th>
						<th>Stake</th>
						<th>Jackpot</th>
					</tr>
				</thead>
				<tbody>
			<?php
			foreach ($jackpots as $key => $value) {
				?>
				<tr>
					<td><a href="<?php if (strstr($value['Url'], '?')) { echo $value['Url'] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $value['Url'] . '?utm_source=oddscracker&utm_medium=affiliate'; } ?>" rel="nofollow" target="_blank" title="<?php echo $value['Bookmaker'];?> jackpot"><img src="/uploads/<?php echo $value['Logo'];?>" alt="<?php echo $value['LogoAlt'];?>" title="<?php echo $value['Name'];?>" class="img img-responsive center-block" style="width:100px;"></a></td>
					<td><strong class="text-success"><?php echo $value['Games'];?></strong></td>
					<td><strong class="text-success"><?php if (is_numeric($value['Stake'])) { echo number_format($value['Stake'], 0, '.', ','); } else { echo $value['Stake']; } ?></strong></td>
					<td><strong class="text-success"><?php if (is_numeric($value['Jackpot'])) { echo number_format($value['Jackpot'], 0, '.', ','); } else { echo $value['Jackpot']; } ?></strong></td>
				</tr>
				<?php
			}
			?>
				</tbody>
			</table>
			<div class="grey-bg text-center row">
				<div class="col-sm-6">
					<a 
					href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/jackpots/" 
					title="Share on Facebook" 
					class="facebook-share" 
					target="_blank">
						<i class="fa fa-lg fa-facebook"></i> Share on Facebook
					</a>
				</div>
				<div class="col-sm-6">
					<a 
					href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/jackpots/&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/jackpots/" 
					title="Share on Twitter" 
					class="twitter-share" 
					target="_blank">
						<i class="fa fa-lg fa-twitter" target="_blank"></i> Share on Twitter
					</a>
				</div>
			</div>			
			<?php
		} else {
			?>
			<h2 class="text-center">No jackpots available!</h2>
			<?php
		}
		?>
	</div>
</div>
