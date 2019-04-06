<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h1 class="up-next">
		<i class="fa fa-lg fa-angle-double-right"></i> Next betting odds
		<?php if ($this->uri->segment(2)) { echo ' - ' . preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2))); } ?>
	</h1>
<?php
if (!$this->uri->segment(2)) {
	if (!$events) {
	?>
	<h2 class="text-center">No events scheduled</h2>	
	<?php
	} else {
	?>
	<table class="table table-striped">
		<tbody>
		<?php
		foreach ($events as $key => $value) {
		?>
			<tr>
				<td>
					<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
						<?php if (strtotime($value['Time']) < strtotime('+1 day')) { echo '<i class="fa fa-fw fa-clock-o'; if (strtotime($value['Time']) < time()) { echo ' text-danger'; } else { echo ' text-success'; } echo '"></i>' . date('H:i', strtotime($value['Time'])); } else { echo date('d M H:i', strtotime($value['Time'])); } ?>
					</a>
				</td>
				<td>
					<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
						<span class="sr-only">Get the best betting odds comparison for </span><?php echo $value['Team1'];?> - <?php echo $value['Team2'];?><span class="sr-only"> in <?php echo $value['LeagueName'];?></span>
					</a>
				</td>
				<td class="pull-right">
					<?php echo $value['LeagueName'];?>
					&nbsp;<img src="/images/flags/<?php echo strtolower($value['CountryCode']);?>.png" style="height:14px;" alt="<?php echo $value['LeagueName'];?>" title="<?php echo $value['LeagueName'];?>">
				</td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<div class="grey-bg text-center row">
		<div class="col-sm-6">
			<a href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/events/<?php echo preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2)));?>" class="facebook-share" target="_blank"><i class="fa fa-lg fa-facebook"></i> Share on Facebook</a>
		</div>
		<div class="col-sm-6">
			<a href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/events/<?php echo  preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2)));?>&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/events/<?php echo preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2)));?>" class="twitter-share" target="_blank"><i class="fa fa-lg fa-twitter" target="_blank"></i> Share on Twitter</a>
		</div>
	</div>
	<?php
	}
} else {
	if ( !isset($league_events) || count($league_events) == 0 ) {
?>
		<h2 class="text-center">No events scheduled for <?php echo preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2))) ?></h2>
<?php
	} else {
?>
		<table class="table table-striped">
			<tbody>
			<?php
			foreach ($league_events as $key => $value) {
			?>
				<tr>
					<td>
						<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
							<?php if ( strtotime($value['Time']) < strtotime('+1 day') ) { echo '<i class="fa fa-fw fa-clock-o'; if (strtotime($value['Time']) < time()) { echo ' text-danger'; } else { echo ' text-success'; } echo '"></i>' . date('H:i', strtotime($value['Time'])); } else { echo date('d M H:i', strtotime($value['Time'])); } ?>
						</a>
					</td>
					<td>
						<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
							<span class="sr-only">Get the best betting odds comparison for </span><?php echo $value['Team1'];?> - <?php echo $value['Team2'];?><span class="sr-only"> in <?php echo $value['LeagueName'];?></span>
							<i class="fa fa-lg fa-angle-double-right pull-right"></i>
						</a>
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
		<div class="grey-bg text-center row">
			<div class="col-sm-6">
				<a href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/events/<?php echo preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2)));?>" title="Share on Facebook" class="facebook-share" target="_blank"><i class="fa fa-lg fa-facebook"></i> Share on Facebook</a>
			</div>
			<div class="col-sm-6">
				<a href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/events/<?php echo  preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2)));?>&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/events/<?php echo preg_replace('/[^a-zA-Z0-9\-\s]/', '', str_replace('_', ' ', $this->uri->segment(2)));?>" title="Share on Twitter" class="twitter-share" target="_blank"><i class="fa fa-lg fa-twitter" target="_blank"></i> Share on Twitter</a>
			</div>
		</div>
<?php
	}
}
?>
</div>
