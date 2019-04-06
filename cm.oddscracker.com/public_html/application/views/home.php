<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h1 class="sr-only"><?php echo $page['Heading'];?></h1>
	<?php
	echo $page['Html'];
	if ( !$today_events ) {
	?>
	<h2 class="up-next"><i class="fa fa-lg fa-angle-double-right"></i> Cotes des paris du jour</h2>
	<h3 class="text-center">Aucun événement de paris prévu pour aujourd'hui</h3>
	<?php
		if ($next_events) {
		?>
		<h2 class="up-next"><i class="fa fa-lg fa-angle-double-right"></i> Cotes des paris suivants</h2>
		<table class="table table-striped">
			<tbody>
			<?php
			foreach ($next_events as $key => $value) {
				if ( strtotime($value['Time']) >= strtotime('+1 days') && strtotime($value['Time']) <= strtotime('+2 days') ) {
				?>
					<tr>
						<td>
							<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
								<?php echo date('d M H:i', strtotime($value['Time']));?>
							</a>
						</td>
						<td>
							<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
								<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>
							</a>
							<span class="pull-right">
								<span class="hidexs"><?php echo $value['LeagueName']; ?>&nbsp;</span>
								<img src="<?php echo $value['CountryFlag']; ?>" style="height:14px;" alt="<?php echo $value['CountryCode']; ?>" data-toggle="tooltip" data-title="<?php echo $value['LeagueName']; ?>">
							</span>
						</td>
					</tr>
				<?php
			}
		}
		?>
			</tbody>
		</table>
		<?php
		}
	} else {
	?>
		<div class="best-odds">
			<div class="inner">
				<h2><a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($best['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($best['Team2']))) . '-' . $best['EventID'];?>" title="<?php echo $best['Team1'];?> - <?php echo $best['Team2'];?>"><?php echo $best['Team1'];?> - <?php echo $best['Team2'];?></a></h2>
				<hr>
				<h3><?php echo $best['League'];?></h3>
				<p><i class="fa fa-fw fa-clock-o"></i> <?php echo date('H:i', strtotime($best['Time']));?></p>
			</div>

		<?php if ($best) { ?>
			<p class="best-odds-title">Meilleure cote pour aujourd'hui</p>
			<div class="best-odds-container row text-center">
				<div class="col-xs-4">
					<a href="<?php if (strstr($best['odds']['1']['url'], '?')) { echo $best['odds']['1']['url'] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $best['odds']['1']['url'] . '?utm_source=oddscracker&utm_medium=affiliate'; } ?>" rel="nofollow" target="_blank" title="<?php echo $best['Team1'];?> at <?php echo $best['odds']['1']['value'];?>">
						<?php echo $best['Team1'];?>
						<br>
						<?php echo $best['odds']['1']['value'];?>
						<br>
						<img src="/uploads/<?php echo $best['odds']['1']['bookmaker_logo'];?>" alt="<?php echo $best['odds']['1']['bookmaker_name'];?>" style="height:20px;">
					</a>
				</div>
				<div class="col-xs-4">
					<a href="<?php if (strstr($best['odds']['X']['url'], '?')) { echo $best['odds']['X']['url'] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $best['odds']['X']['url'] . '?utm_source=oddscracker&utm_medium=affiliate'; } ?>" rel="nofollow" target="_blank" title="Draw at <?php echo $best['odds']['X']['value'];?>">
						match nul
						<br>
						<?php echo $best['odds']['X']['value'];?>
						<br>
						<img src="/uploads/<?php echo $best['odds']['X']['bookmaker_logo'];?>" alt="<?php echo $best['odds']['X']['bookmaker_name'];?>" style="height:20px;">
					</a>
				</div>
				<div class="col-xs-4">
					<a href="<?php if (strstr($best['odds']['2']['url'], '?')) { echo $best['odds']['2']['url'] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $best['odds']['2']['url'] . '?utm_source=oddscracker&utm_medium=affiliate'; } ?>" rel="nofollow" target="_blank" title="<?php echo $best['Team2'];?> at <?php echo $best['odds']['2']['value'];?>">
						<?php echo $best['Team2'];?>
						<br>
						<?php echo $best['odds']['2']['value'];?>
						<br>
						<img src="/uploads/<?php echo $best['odds']['2']['bookmaker_logo'];?>" alt="<?php echo $best['odds']['2']['bookmaker_name'];?>" style="height:20px;">
					</a>
				</div>
			</div>
		<?php
		} 
		?>

		</div>
		<h2 class="up-next"><i class="fa fa-lg fa-angle-double-right"></i> Cotes des paris du jour</h2>
		<table class="table table-striped">
			<tbody>
		<?php
		foreach ($today_events as $key => $value) {
		?>
				<tr>
					<td>
						<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
							<i class="fa fa-fw fa-clock-o<?php if (strtotime($value['Time']) < time()) { echo ' text-danger'; } else { echo ' text-success'; } ?>"></i> <?php echo date('H:i', strtotime($value['Time']));?>
						</a>
					</td>
					<td>
						<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
							<span class="sr-only">Obtenez les meilleures cotes de paris sportifs pour </span><?php echo $value['Team1'];?> - <?php echo $value['Team2'];?><span class="sr-only"> in <?php echo $value['LeagueName'];?></span>
						</a>
						<span class="pull-right">
							<span class="hidexs"><?php echo $value['LeagueName']; ?>&nbsp;</span>
							<img src="/images/flags/<?php echo strtolower($value['CountryCode']); ?>.png" style="height:14px;" alt="<?php echo $value['CountryCode']; ?>" data-toggle="tooltip" data-title="<?php echo $value['LeagueName']; ?>">
						</span>
					</td>
				</tr>
		<?php
		}
		?>
			</tbody>
		</table>
		<?php
		if (isset($next_events) && count($next_events) > 0 ) {
		?>
		<h2 class="up-next"><i class="fa fa-lg fa-angle-double-right"></i> Cotes des paris de demain</h2>
		<table class="table table-striped">
			<tbody>
		<?php
		foreach ($next_events as $key => $value) {
			if ( strtotime($value['Time']) >= strtotime('+1 days') && strtotime($value['Time']) <= strtotime('+2 days') ) {
			?>
				<tr>
					<td>
						<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
							<?php echo date('d M H:i', strtotime($value['Time']));?>
						</a>
					</td>
					<td>
						<a href="/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['Team2']))) . '-' . $key;?>" title="<?php echo $value['Team1'];?> - <?php echo $value['Team2'];?>">
							<span class="sr-only">Obtenez les meilleures cotes de paris sportifs pour </span><?php echo $value['Team1'];?> - <?php echo $value['Team2'];?><span class="sr-only"> in <?php echo $value['LeagueName'];?></span>
						</a>
						<span class="pull-right">
							<span class="hidexs"><?php echo $value['LeagueName']; ?>&nbsp;</span>
							<img src="/images/flags/<?php echo strtolower($value['CountryCode']); ?>.png" style="height:14px;" alt="<?php echo $value['CountryCode']; ?>" data-toggle="tooltip" data-title="<?php echo $value['LeagueName']; ?>">
						</span>
					</td>
				</tr>
<?php
			}
		}
?>
			</tbody>
		</table>
		<div class="text-center">
			<a href="/events" title="Toutes les cotes de paris à venir" class="btn btn-lg btn-success">Toutes les cotes de paris à venir <i class="fa fa-lg fa-angle-double-right"></i></a>
		</div>
		<br>
<?php
		}
	}
?>
</div>
