<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends MY_Controller {
	public function index() {
		ob_start();
		echo '
<!DOCTYPE html>
<html>
	<head>
		<title>Oddscracker | CPC Campaign report</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta name="robots" content="noindex,nofollow">
		<link rel="icon" href="/images/favicon.png" type="image/png">
		<style type="text/css">' . str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/bootstrap.css')) . "\n" . str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/font-awesome.css')) . "\n" . str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/bootstrap-datepicker.css')) . '
			#main { min-height: 550px; }
			#footer { border-top: 1px solid grey; padding: 25px; }
		</style>
		<script type="text/javascript">' . file_get_contents(FCPATH . '/js/jquery.min.js') . "\n" . file_get_contents(FCPATH . '/js/bootstrap.min.js') . "\n" . file_get_contents(FCPATH . '/js/bootstrap-datepicker.js') . '
		$(document).ready(function(){
			$(\'.datepicker\').datepicker({ format: \'yyyy-mm-dd\'});
		});
		</script>
	</head>
	<body>
		<div id="main" class="container">
		';
		if (!$this->uri->segment(2)) {
			echo '<h3 class="alert alert-danger">Error: Invalid request!</h3>';
		} else {
			$token = preg_replace('/[^a-z0-9]/', '', $this->uri->segment(2));
			$campaign = $this->FrontModel->get_campaign($token);
			if (!$campaign) {
				echo '<h3 class="alert alert-danger">Error: Invalid access token!</h3>';
			} else {
				echo '<h3 class="page-header text-center"><strong>' . $campaign['bookmaker']['Name'] . '</strong> report</h3>';
				require_once FCPATH . 'application/libraries/googleapi/vendor/autoload.php';
				$client = new Google_Client();
				$client->setAuthConfig(FCPATH . 'application/libraries/googleapi/client_secrets.json');
				$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
				if (isset($_SESSION['access_token']) && ($_SESSION['access_token']['created']+$_SESSION['access_token']['expires_in'] > time())) {
					$view_id = $this->data['settings']['ga_view_id'];
					$bookmaker = $campaign['bookmaker']['Name'];
					if (isset($_POST['start_date'])) {
						$start_date = date('Y-m-d', strtotime($_POST['start_date']));
					} else {
						$start_date = date('Y-m-d', strtotime('-7 days'));
					}
					if (isset($_POST['end_date'])) {
						$end_date = date('Y-m-d', strtotime($_POST['end_date']));
					} else {
						$end_date = date('Y-m-d');
					}
					function getReport($analytics, $view_id, $start_date, $end_date) {
						$VIEW_ID = $view_id;
						$dateRange = new Google_Service_AnalyticsReporting_DateRange();
						$dateRange->setStartDate($start_date);
						$dateRange->setEndDate($end_date);
						$clicks = new Google_Service_AnalyticsReporting_Dimension();
						$clicks->setName("ga:eventCategory");
						$sessions = new Google_Service_AnalyticsReporting_Metric();
						$sessions->setExpression("ga:totalEvents");
						$sessions->setAlias("Outbound link clicks");
						$request = new Google_Service_AnalyticsReporting_ReportRequest();
						$request->setViewId($VIEW_ID);
						$request->setDateRanges($dateRange);
						$request->setDimensions(array($clicks));
						$request->setMetrics(array($sessions));
						$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
						$body->setReportRequests( array( $request) );
						return $analytics->reports->batchGet($body);
					}
					function getPageViews($analytics, $view_id, $start_date, $end_date) {
						$VIEW_ID = $view_id;
						$dateRange = new Google_Service_AnalyticsReporting_DateRange();
						$dateRange->setStartDate($start_date);
						$dateRange->setEndDate($end_date);
						$clicks = new Google_Service_AnalyticsReporting_Dimension();
						$clicks->setName("ga:pagePath");
						$sessions = new Google_Service_AnalyticsReporting_Metric();
						$sessions->setExpression("ga:pageviews");
						$sessions->setAlias("Outbound link clicks");
						$request = new Google_Service_AnalyticsReporting_ReportRequest();
						$request->setViewId($VIEW_ID);
						$request->setDateRanges($dateRange);
						$request->setDimensions(array($clicks));
						$request->setMetrics(array($sessions));
						$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
						$body->setReportRequests( array( $request) );
						return $analytics->reports->batchGet($body);
					}
					$client->setAccessToken($_SESSION['access_token']);
					$analytics = new Google_Service_AnalyticsReporting($client);
					$reports = getReport($analytics, $view_id, $start_date, $end_date);
					function getResults($reports, $bookmaker) {
						for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
							$data = array();
							$report = $reports[ $reportIndex ];
							$header = $report->getColumnHeader();
							$dimensionHeaders = $header->getDimensions();
							$metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
							$rows = $report->getData()->getRows();
							for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
								$row = $rows[ $rowIndex ];
								$dimensions = $row->getDimensions();
								$metrics = $row->getMetrics();
								for ($j = 0; $j < count($metrics); $j++) {
									$values = $metrics[$j]->getValues();
									for ($k = 0; $k < count($values); $k++) {
										$entry = $metricHeaders[$k];
										if ( strstr($dimensions[$j], $bookmaker)) {
											$data['clicks'] = $values[$k];
										}
										
									}
								}
							}
						}
						return $data;
					}
					function getPageViewsResults($views, $path) {
						$total_views = 0;
						for ( $reportIndex = 0; $reportIndex < count( $views ); $reportIndex++ ) {
							$report = $views[ $reportIndex ];
							$header = $report->getColumnHeader();
							$dimensionHeaders = $header->getDimensions();
							$metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
							$rows = $report->getData()->getRows();
							for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
								$row = $rows[ $rowIndex ];
								$dimensions = $row->getDimensions();
								$metrics = $row->getMetrics();
								for ($j = 0; $j < count($metrics); $j++) {
									$values = $metrics[$j]->getValues();
									for ($k = 0; $k < count($values); $k++) {
										$entry = $metricHeaders[$k];
										if (strstr($dimensions[$j], $path)) {
											$total_views++;
										}
										
									}
								}
							}
						}
						return $total_views;
					}
					$ga_data = getResults($reports, $bookmaker);
					$ga_event_views = getPageViews($analytics, $view_id, $start_date, $end_date);
					$event_views = getPageViewsResults($ga_event_views, '/event/');
					echo '
					<br>
						<form class="form form-horizontal" role="form" method="post" action="/campaign/' . $token . '">
							<div class="form-group">
								<div class="col-sm-3"></div>
								<div class="col-sm-3">
									<label>Report start date</label>
									<input type="text" name="start_date" class="form-control input-lg datepicker" required="required" value="'; if (isset($_POST['start_date'])) { echo date('Y-m-d', strtotime($_POST['start_date'])); } else { echo date('Y-m-d', strtotime('-7 days')); } echo '">
								</div>
								<div class="col-sm-3">
									<label>Report end date</label>
									<input type="text" name="end_date" class="form-control input-lg datepicker" required="required" value="'; if (isset($_POST['end_date'])) { echo date('Y-m-d', strtotime($_POST['end_date'])); } else { echo date('Y-m-d'); } echo '">
								</div>
								<div class="col-sm-3">
									<label>&nbsp;</label><br>
									<input type="submit" class="btn btn-lg btn-primary" value="Submit">
								</div>
							</div>
						</form>
					<br>
					<table class="table table-responsive table-bordered">
						<tbody>
							<tr>
								<td>Client name</td><td>' . $bookmaker . '</td>
							</tr>
							<tr>
								<td>Campaign active</td>
								<td>'; if ($campaign['Active'] > 0) { echo '<i class="fa fa-fw fa-check text-success"></i>'; } else { echo '<i class="fa fa-fw fa-times text-danger"></i>'; } echo '</td>
							</tr>
							<tr>
								<td>Campaign time frame</td>
								<td>'; if ($campaign['Ongoing'] > 0) { echo 'Ongoing'; } else { echo 'Start date: ' . date('Y-m-d', $campaign['StartDate']) . '<br>End date: ' . date('Y-m-d', $campaign['EndDate']); } echo '</td>
							</tr>
							<tr>
								<td>Budget</td>
								<td>'; if ($campaign['Budget'] == 0) { echo 'Unlimited'; } else { echo number_format($campaign['Budget'], 2, '.', ','); } echo '</td>
							</tr>
							<tr>
								<td>Impressions (<small>* sourced from Google Analytics</small>)</td>
								<td>' . $event_views . '</td>
							</tr>
							<tr>
								<td>Clicks (<small>* sourced from Google Tag Manager</small>)</td>
								<td>'; if (isset($ga_data['clicks'])) { echo $ga_data['clicks']; } else { echo '0'; } echo '</td>
							</tr>
							<tr>
								<td>CTR (Click Through Rate)</td>
								<td>'; if (isset($ga_data['clicks'])) { echo round($ga_data['clicks']/$event_views, 2)*100 . '%'; } else { echo '0%'; } echo '</td>
							</tr>
							<tr>
								<td>Cost per Click</td>
								<td>'; echo number_format($campaign['CostPerClick'], 4, '.', ','); echo '</td>
							</tr>
							<tr>
								<td>Amount spent</td>
								<td>'; if (isset($ga_data['clicks'])) { echo number_format($campaign['CostPerClick']*$ga_data['clicks'], 4, '.', ','); } else { echo '0'; } echo '</td>
							</tr>
							<tr>
								<td>Report start date</td>
								<td>' . $start_date . '</td>
							</tr>
							<tr>
								<td>Report end date</td>
								<td>' . $end_date . '</td>
							</tr>
						</tbody>
					</table>
					';
				} else {
					$_SESSION['_campaign_id'] = $token;
					redirect($this->data['settings']['abs_url'] . '/ga/oauth2callback');
				}
			}
		}
		echo '
		</div>
		<p id="footer" class="text-center"><a href="' . $this->data['settings']['abs_url'] . '">Oddscracker Kenya</a></p>
	</body>
</html>
		';
		ob_end_flush();
	}
}