<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.datepicker').datepicker();
});
$(document).on('change', 'input[name="datetime"]', function(){
	var date_time = $(this).val();
	window.location.href = '/archives/'+date_time.replace(/\//g, '-');
});
</script>
<div id="center-col" class="col-sm-6">
	<h1 class="page-title"><?php echo $page['Heading'];?></h1>
	<br>
	<div class="row">
		<?php echo $page['Html'];?>
	</div>
	<div class="row text-center">
		<h2>Choisissez une date:</h2> <input type="text" name="datetime" class="datepicker center-block" data-date-format="dd/mm/yyyy" data-date-end-date="-1d" value="<?php echo date('d/m/Y', strtotime('-1 day'));?>" required="required" placeholder="Select date">
	</div>
	<?php
	if (count($archives) > 0) {
		?>
		<h3 class="up-next">Cotes de paris archivées <?php if ($this->uri->segment(2)) { echo preg_replace('/[^0-9\-]/', '', $this->uri->segment(2)); } else { echo date('Y-m-d', strtotime('-1 day')); } ?></h3>
		<table class="table table-striped">
			<tbody>
			<?php
			foreach ($archives as $key => $value) {
			?>
				<tr>
					<td>
						<a href="/archive/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $value['team1'])) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $value['team2'])) . '-' . $value['id'];?>" title="<?php echo $value['team1'];?> - <?php echo $value['team2'];?>"><?php echo date('d M H:i', strtotime($value['start_time']));?></a>
					</td>
					<td>
						<a href="/archive/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $value['team1'])) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $value['team2'])) . '-' . $value['id'];?>" title="<?php echo $value['team1'];?> - <?php echo $value['team2'];?>">
						<?php echo $value['team1'];?> - <?php echo $value['team2'];?>
						</a>
					</td>
					<td>
						<?php echo $value['country'] . ' - ' . $value['league'];?>
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
		<?php
	} else {
	?>
		<h3 class="text-center">Aucune cote de pari archivée pour <?php if ($this->uri->segment(2)) { echo preg_replace('/[^0-9\-]/', '', $this->uri->segment(2)); } else { echo date('Y-m-d', strtotime('-1 day')); } ?></h3>
	<?php
	}
	?>
</div>
