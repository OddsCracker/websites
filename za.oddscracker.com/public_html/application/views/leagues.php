<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h1 class="page-title"><span class="sr-only">Get the best odds for all </span>Sport Betting Leagues</h1>
	<br>
	<div class="row">
		<?php
		foreach ($leagues as $league_key => $league) {
		?>
		<div class="league-header">
			<a href="/events/<?php echo $league['Slug'];?>" title="Best odds comparison for <?php echo $league['Name']; ?>">
				<img src="<?php echo $league['CountryFlag'];?>" class="pull-left" alt="<?php echo $league['Name'];?>" title="<?php echo $league['Name'];?>">&nbsp;&nbsp;
				<span class="sr-only">Best betting odds for </span><?php echo $league['Name'];?><span class="sr-only"> <?php echo $league['CountryName'];?></span>
				<?php if ($league['EventCount'] > 0) { ?>
					<span class="pull-right"><?php echo $league['EventCount']; ?> events today <i class="fa fa-lg fa-angle-double-right"></i></span>
				<?php } ?>
			</a>
		</div>
		<?php
		}
		?>
	</div>
</div>
