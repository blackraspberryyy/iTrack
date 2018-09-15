<script>
  function get_data($id){
    $ci = & get_instance();
    $month_stats = $ci->AdminIncidentReport_model->getIncidentReport(array('u.user_id' => $id));
    $month_count = array();
    if(!empty($month_stats)){
        $count = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
        );
        foreach ($month_stats as $mo) {
            $month = date("n", $mo->incident_report_added_at);
            if ($month == 1) {
                $count['1'] += 1;
            } else if ($month == 2) {
                $count['2'] += 1;
            } else if ($month == 3) {
                $count['3'] += 1;
            } else if ($month == 4) {
                $count['4'] += 1;
            } else if ($month == 5) {
                $count['5'] += 1;
            } else if ($month == 6) {
                $count['6'] += 1;
            } else if ($month == 7) {
                $count['7'] += 1;
            } else if ($month == 8) {
                $count['8'] += 1;
            } else if ($month == 9) {
                $count['9'] += 1;
            } else if ($month == 10) {
                $count['10'] += 1;
            } else if ($month == 11) {
                $count['11'] += 1;
            } else if ($month == 12) {
                $count['12'] += 1;
            }
        }
    }

    $loop = 0;
    foreach($count as $c){
        if($loop == (count($count) - 1)){
            //LAST ITERATION
            echo $c;
        }else{
            echo $c.', ';
        }
        $loop += 1;
    }
}
</script>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>admindashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Student Profile</li>
    </ol>
</div><!--/.row breadcrumb-->