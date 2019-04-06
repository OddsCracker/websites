<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="left-col" class="col-sm-3">
	<ul class="list-group hidexs">
		<?php if ($today_events) {
			?>
			<li class="list-group-item"><span><i class="fa fa-fw fa-calendar"></i> Today's betting odds (<?php if ($today_events) { echo count($today_events); } ?>)</span></li>
<?php
			$count = 0;
			foreach ($leagues as $league_key => $league) {
				if ($league['EventCount'] > 0) {
?>
				<li class="list-group-item">
					<a href="/events/<?php echo $league['Slug'];?>" title="<?php echo $league['Name'];?>">
						<img src="<?php echo $league['CountryFlag'];?>" alt="<?php echo $league['Name'];?>" title="<?php echo $league['Name'];?>">&nbsp;<?php echo $league['Name'];?>
						<?php if ($league['EventCount'] > 0) { ?>
							<span class="badge pull-right"><?php echo $league['EventCount'];?></span>
						<?php } ?>
					</a>
				</li>
<?php
				}
			}
?>
			<li class="list-group-item"><a href="/leagues" title="All betting leagues">All betting leagues <i class="fa fa-lg fa-angle-double-right"></i></a></li>
<?php
		} else {
?>
		<li class="list-group-item">Top betting leagues</li>
<?php
			$counter = 0;
			foreach ($leagues as $league_key => $league) {
				if ($counter < 10) {
?>
				<li class="list-group-item">
					<a href="/events/<?php echo $league['Slug'];?>" title="<?php echo $league['Name'];?>">
						<img src="<?php echo $league['CountryFlag'];?>" alt="<?php echo $league['Name'];?>" title="<?php echo $league['Name'];?>">&nbsp;<?php echo $league['Name'];?>
						<?php if ($league['EventCount'] > 0) { ?>
						<span class="badge pull-right"><?php echo $league['EventCount'];?></span>
						<?php } ?>
					</a>
				</li>
<?php
					$counter++;
				}
			}
		}

?>
	</ul>
</div>
