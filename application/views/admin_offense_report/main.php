<?php
function determineStatus($status){
	if($status == 0){
		echo '<span class = "badge badge-secondary">Finished</span>';
	}else{
		echo '<span class = "badge badge-danger" style = "background:#ff3232;">Active</span>';
	}
}

function get_labels($attendance){
	$labels = array();
	if($attendance){
		foreach($attendance as $att){
			if($att->attendance_starttime == 0){
				array_push($labels, date('F d, Y', $att->attendance_created_at));
			}else{
				array_push($labels, date('F d, Y', $att->attendance_starttime));
			}
		}
	}

	$loop = 0;
	foreach($labels as $l){
		if($loop == (count($labels) - 1)){
			//LAST ITERATION
			echo '"'.$l.'"';
		}else{
			echo '"'.$l.'"'.', ';
		}
		$loop += 1;
	}
}

function get_data($attendance){
	$data = array();
	if($attendance){
		foreach($attendance as $att){
			array_push($data, $att->attendance_hours_rendered);
		}
	}

	$loop = 0;
	foreach($data as $d){
		if($loop == (count($data) - 1)){
			//LAST ITERATION
			echo $d;
		}else{
			echo $d.', ';
		}
		$loop += 1;
	}
}
?>
<div class="row">
	<ol class="breadcrumb">
		<li>
			<a href="<?= base_url() ?>AdminDashboard"><em class="fa fa-home"></em></a>
		</li>
		<li>
			<a href="<?= base_url() ?>AdminIncidentReport">Incident Report</a>
		</li>
		<li class="active">Offense Report</li>
	</ol>
</div><!--/.row breadcrumb-->

<div class="row">
	<div class = "col-xs-12">
		<h1><?= $cms->offense_report_title?></h1>
		<h5><?= $cms->offense_report_text?></h5>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="row margin-top-lg">
			<div class="col-xs-4">
				<div class="panel panel-primary">
					<div class="panel panel-heading">Incident Report Information</div>
						<div class="panel panel-body">
							<div class="row">
								<div class="col-xs-12 text-center">
									<center>
										<img src="<?= base_url().$incident_report->user_picture?>" class="img-responsive img-circle" width="150">
										<h4><?= $incident_report->user_firstname.' '.($incident_report->user_middlename!='' ? $incident_report->user_middlename:'').' '.$incident_report->user_lastname?></h4>
										<h5><?= ucfirst($incident_report->user_access)?></h5>
										<h6><?= determineStatus($incident_report->incident_report_status)?></h6>
									</center>
								</div>
								<div class="col-xs-6 margin-top-lg text-center">
									<h5><strong>Reported By:</strong></h5>
									<span><?php
										if ($incident_report->reportedby_id != "") {
											//if REPORTED_BY teacher, get user's name 
											echo $incident_report->reportedby_firstname . " " . ($incident_report->reportedby_middlename == "" ? "" : substr($incident_report->reportedby_middlename, 0, 1).". "). $incident_report->reportedby_lastname;
											echo " <small class = 'text-muted'><b>(".$incident_report->reportedby_access.")</b></small>";
										} else {
											//if REPORTED_BY admin, get admin's name
											echo "Admin";
										}
									?></span>
									<br/>
									<br/>
									<h5><strong>Place</strong></h5>
									<span><?= $incident_report->incident_report_place?></span>
									<br/>
									<br/>
									<h5><strong>Sanction</strong></h5>
									<span><?= $incident_report->effect_name?></span>
								</div>
								<div class="col-xs-6  margin-top-lg  text-center">
									<h5><strong>Violation</strong></h5>
									<span><?= ucfirst($incident_report->violation_name)?></span>
									<br/>
									<br/>
									<h5><strong>Time</strong></h5>
									<span><?= date('F d, Y \a\t h:i A', $incident_report->incident_report_datetime)?></span>
									<br/>
									<br/>
									<h5><strong>Message</strong></h5>
									<p><?= $incident_report->incident_report_message?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-8">
					<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-primary">
								<div class="panel panel-heading text-center">Attendance Record</div>
									<div class="panel panel-body">
										<div class ="table-responsive">
											<?php if($attendance):?>    
											<table class="table table-striped datatable" style="width:100%">
												<thead>
													<tr>
														<th>Start Date &amp; Time</th>
														<th>End Date &amp; Time</th>
														<th>Hours Rendered</th>
														<th>Department</th>
														<th>Supervisor</th>
														<?php if(!($total_hours->hours_rendered >= $incident_report->violation_hours)):?>
															<th>Action</th>
														<?php endif;?>
													</tr>
												</thead>
												<tbody>
													<?php foreach($attendance as $a):?>
													<tr>
														<td class="text-center">
															<?php if($a->attendance_starttime == 0):?>
																<span>-</span>
															<?php else:?>
																<span class = "hidden"><?= $a->attendance_starttime ?></span><?= date('m/d/Y h:iA', $a->attendance_starttime) ?>
															<?php endif;?>
														</td>
														<td class="text-center">
															<?php if($a->attendance_endtime == 0):?>
																<span>-</span>
															<?php else:?>
																<span class = "hidden"><?= $a->attendance_endtime ?></span><?= date('m/d/Y h:iA', $a->attendance_endtime) ?>
															<?php endif;?>
														</td>
														<td><?= $a->attendance_hours_rendered ?></td>
														<td><?= $a->attendance_dept ?></td>
														<td><?= $a->attendance_supervisor ?></td>
														<?php if(!($total_hours->hours_rendered >= $incident_report->violation_hours)):?>
															<td>
																<button data-toggle="modal" data-target="#edit_<?= sha1($a->attendance_id)?>" type="button" class="btn btn-warning">Edit</button>
															</td>
														<?php endif;?>
													</tr>
													<?php endforeach;?>
												</tbody>
											</table>
											<?php else:?>
											<div class="margin-bottom-lg">
												<center>
													<h3>No attendance record yet</h3>
												</center>
											</div>
											<?php endif;?>  
										</div>
									</div>
								</div>
							</div>
						<div class="col-xs-12">
							<div class="panel panel-primary">
								<div class="panel panel-heading">Attendance Progress</div>
								<?php if($attendance):?>
								<div class="panel panel-body">
									<div class="second circle">
										<strong></strong>
									</div>
									<br/><br/>
									<canvas id="attendanceChart"></canvas>
								</div>
								<?php else:?>
									<div class="margin-bottom-lg">
										<center>
											<h3>No attendance record yet</h3>
										</center>
									</div>
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

window.onload = function () {
	//Circle Progress Bar
	$('.second.circle').circleProgress({
		size:160,
		value: <?= $total_hours->hours_rendered/$incident_report->violation_hours?>,
		animation:{
			duration:3000,
			easing: "circleProgressEasing"
		},
		fill: { color: ["#037236"] }
	}).on('circle-animation-progress', function(event, progress) {
		$(this).find('strong').html((<?= $total_hours->hours_rendered ? $total_hours->hours_rendered : 0?> * progress).toFixed(2).replace(/[.,]00$/, "") + '<i>&nbsp;/&nbsp;</i>' + <?= $incident_report->violation_hours?> + '<br/>hrs');
	});
	//Bar Chart
	var labels = [' ', <?php get_labels($attendance)?>];
	var ctx = document.getElementById('attendanceChart').getContext('2d');
	var myBarChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [{
				label: "Hours Rendered",
				backgroundColor: 'rgba(0, 114, 54, 0.5)',
				borderColor: 'rgba(0, 114, 54, 1)',
				data: [0, <?php get_data($attendance)?>]
			}],
			options:{
				scales: {
					yAxes: [{
						ticks: {
							suggestedMax: 5,
							min: 0,
							stepSize: 1
						}
					}]
				}
			}
		}
	});
}
</script>