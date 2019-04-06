<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="left-col" class="col-sm-3">
	<ul class="list-group hidexs">
		<?php if ($today_events) {
			?>
			<li class="list-group-item">
				<i class="fa fa-fw fa-calendar"></i> <a href="/" title="Événements de paris d'aujourd'hui">Événements de paris d'aujourd'hui (<?php if ($today_events) { echo count($today_events); } ?>)</a>
			</li>
			<?php
		}
		foreach ($leagues as $league_key => $league) {
			?>
			<li class="list-group-item">
				<a href="/events/<?php echo $league['Slug'];?>" title="<?php echo $league['Name'];?>">
					<img src="<?php echo $league['CountryFlag'];?>" alt="<?php echo $league['Name'];?>">&nbsp;<?php echo $league['Name'];?>
					<?php if ($league['EventCount'] > 0) { ?>
					<span class="badge pull-right"><?php echo $league['EventCount'];?></span>
					<?php } ?>
				</a>
			</li>
			<?php
		}
		?>
	</ul>
</div>
