<style>
    .box-shadow{
        box-shadow:2px 2px 4px rgba(0,0,0,0.2);
    }
    .dashboard.item .panel:hover{
        transform:scale(1.05);
    }
    .dashboard.item a:hover{
        text-decoration:none;
    }
</style>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>AdminDashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Home</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class = "row margin-top-lg">
    <div class = "col-sm-3 dashboard item ">
        <a href="<?= base_url().'AdminViolations/student_profile'?>">
            <div class="panel panel-primary box-shadow">
                <div class="panel panel-body text-center">
                    <h1><?= $students_count?></h1>
                    <h4>Students<br/>&nbsp;</h4>
                </div>
            </div>
        </a>
    </div>
    <div class = "col-sm-3  dashboard item">
        <a href="<?= base_url().'AdminViolations/student_profile'?>">
            <div class="panel panel-primary box-shadow">
                <div class="panel panel-body text-center">
                    <h1><?= $teacher_count?></h1>
                    <h4>Teacher<br/>&nbsp;</h4>
                </div>
            </div>
        </a>
    </div>
    <div class = "col-sm-3  dashboard item">
        <a href="<?= base_url().'AdminIncidentReport'?>">
            <div class="panel panel-primary box-shadow">
                <div class="panel panel-body text-center">
                    <h1><?= $ongoing_incident_reports_count?></h1>
                    <h4>Ongoing Incident Reports</h4>
                </div>
            </div>
        </a>
    </div>
    <div class = "col-sm-3 dashboard item">
        <a href="<?= base_url().'AdminIncidentReport'?>">
            <div class="panel panel-primary box-shadow">
                <div class="panel panel-body text-center">
                    <h1><?= $finished_incident_reports_count?></h1>
                    <h4>Finished Incident Reports</h4>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <div class="panel panel-primary box-shadow" style="padding:24px;">
            <canvas id="incident_reports"></canvas>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="panel panel-primary box-shadow" style="padding: 4px 24px 16px 24px;">
            <div class="panel pane-body">
                <h2><?= $cms->announcement_title?></h2>
                <?= $cms->announcement_text?>
            </div>
        </div>
    </div>
</div>


<?php
    $wma = 0;
    $agd = 0;
    $da = 0;
    $emc = 0;
    $smba = 0;
    $cs = 0;
    $ece = 0;
    $ce = 0;
    $ee = 0;
    $cpe = 0;
    $me = 0;

    foreach($users as $user){
        if(strpos(strtolower($user->user_course), 'wma') !== false){
            $wma++;
        }else if(strpos(strtolower($user->user_course), 'agd') !== false){
            $agd++;
        }else if(strpos(strtolower($user->user_course), 'da') !== false){
            $da++;
        }else if(strpos(strtolower($user->user_course), 'emc') !== false){
            $emc++;
        }else if(strpos(strtolower($user->user_course), 'smba') !== false){
            $smba++;
        }else if(strpos(strtolower($user->user_course), 'cs') !== false){
            $cs++;
        }else if(strpos(strtolower($user->user_course), 'ece') !== false){
            $ece++;
        }else if(strpos(strtolower($user->user_course), 'ce') !== false){
            $ce++;
        }else if(strpos(strtolower($user->user_course), 'ee') !== false){
            $ee++;
        }else if(strpos(strtolower($user->user_course), 'cpe') !== false){
            $cpe++;
        }else if(strpos(strtolower($user->user_course), 'me') !== false){
            $me++;
        }
    }

    $data = $wma.",".$agd.",".$da.",".$emc.",".$smba.",".$cs.",".$ece.",".$ce.",".$ee.",".$cpe.",".$me;
?>
<script>
window.onload = function () {
    var labels = ['WMA', 'AGD', 'DA', 'EMC', 'SMBA', 'CS', 'ECE', 'CE', 'EE', 'CPE', 'ME'];
    var ctx = document.getElementById('incident_reports').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Incident Reports",
                backgroundColor: 'rgba(0, 114, 54, 0.5)',
                borderColor: 'rgba(0, 114, 54, 1)',
                data: [<?=$data?>]
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