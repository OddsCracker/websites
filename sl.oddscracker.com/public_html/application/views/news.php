<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h1 class="page-title"><?php echo $page['Heading'];?></h1>
	<br>
	<div class="row">
		<?php echo $page['Html'];?>
	</div>
	<div class="row">
		<?php
		foreach ($news as $key => $value) {
		?>
		<article class="row news">
			<div class="col-sm-4">
				<p class="news-meta" data-toggle="tooltip" data-title="Published on <?php echo date('Y-m-d', strtotime($value['DateTime']));?> at <?php echo date('H:i', strtotime($value['DateTime']));?> by <?php echo $value['Source'];?>">
					<i class="fa fa-fw fa-clock-o"></i> <?php echo date('Y-m-d H:i', strtotime($value['DateTime']));?>
					<br>
					<i class="fa fa-fw fa-globe"></i> <?php echo $value['Source'];?>
				</p>
			</div>
			<div class="col-sm-8">
				<h4>
					<a href="<?php echo $value['Url'];?>" data-toggle="tooltip" data-title="<?php echo $value['Title'];?>" title="<?php echo $value['Title'];?>" rel="nofollow" target="_blank"><?php echo $value['Title'];?></a>
				</h4>
				<p class="excerpt"><?php if (strlen(strip_tags($value['Content'])) > 10) { echo strip_tags($value['Content']) . ' ... <a href="' . $value['Url'] . '" target="_blank" rel="nofollow" title="Continue reading"><i class="fa fa-fw fa-external-link"></i></a>';}?></p>
			</div>
		</article>
		<?php
		}
		?>
	</div>
	<div class="row text-center">
		<?php echo $this->pagination->create_links();?>
	</div>
</div>
