<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<ul class="breadcrumb">
		<li>Dashboard</li>
	</ul>
	<h3 class="text-center">Traffic statistics</h3>
	<h4>Summary:</h4>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Last 24 hours</th>
				<th>Last 7 days</th>
				<th>Last 30 days</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $stats['total']['day'];?></td>
				<td><?php echo $stats['total']['week'];?></td>
				<td><?php echo $stats['total']['month'];?></td>
			</tr>
		</tbody>
	</table>
	<h4>Online (based on last 15 minutes activity):</h4>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>IP</th>
				<th>Country</th>
				<th>City</th>
				<th>Time</th>
				<th>Hits</th>
				<th>User Agent</th>
				<th>URL</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Logged in visitors:</td>
				<td colspan="6"><?php echo count($stats['online']['loggedin']);?></td>
			</tr>
			<?php 
			foreach ($stats['online']['loggedin'] as $key => $value) {
			?>
			<tr>
				<td>
					<?php echo $value['IpAddr'];?>
					<a href="#" class="ban-btn" data-ip="<?php echo $value['IpAddr']; ?>"><i class="fa fa-fw fa-ban"></i>Block</a>
				</td>
				<td><?php echo $value['Country'];?></td>
				<td><?php echo $value['City'];?></td>
				<td><?php echo $value['LastTime'];?></td>
				<td><?php echo $value['HitCounter'];?></td>
				<td><?php echo $value['UserAgent'];?></td>
				<td><?php echo $value['Url'];?></td>
			</tr>
			<?php
			}
			?>
		</tbody>
		<tbody>
			<tr>
				<td>Anonymous visitors:</td>
				<td colspan="6"><?php echo count($stats['online']['anonymous']);?></td>
			</tr>
			<?php 
			foreach ($stats['online']['anonymous'] as $key => $value) {
			?>
			<tr>
				<td>
					<?php echo $value['IpAddr'];?>
					<a href="#" class="ban-btn" data-ip="<?php echo $value['IpAddr']; ?>"><i class="fa fa-fw fa-ban"></i>Block</a>
				</td>
				<td><?php echo $value['Country'];?></td>
				<td><?php echo $value['City'];?></td>
				<td><?php echo $value['LastTime'];?></td>
				<td><?php echo $value['HitCounter'];?></td>
				<td><?php echo $value['UserAgent'];?></td>
				<td><?php echo $value['Url'];?></td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<h4>Last 500 visiting:</h4>
	<table id="analytics_table" class="table table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>IP</th>
				<th>Location</th>
				<th>ISP</th>
				<th>Hits</th>
				<th>Last URL</th>
				<th>User Agent</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($stats['last500'] as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['LastTime'];?></td>
				<td>
					<?php echo $value['IpAddr'];?>
					<a href="#" class="ban-btn" data-ip="<?php echo $value['IpAddr']; ?>"><i class="fa fa-fw fa-ban"></i>Block</a>
				</td>
				<td><?php echo $value['City'];?>,<br><?php echo $value['Country'];?><br><?php echo $value['Latitude'];?>,<?php echo $value['Longitude'];?></td>
				<td><?php echo $value['Isp'];?></td>
				<td><?php echo $value['HitCounter'];?></td>
				<td><?php echo $value['Url'];?></td>
				<td><?php echo $value['UserAgent'];?></td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
