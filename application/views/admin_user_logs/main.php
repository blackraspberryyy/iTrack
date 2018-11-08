<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>AdminDashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">User Logs</li>
    </ol>
</div><!--/.row breadcrumb-->
<div class = "row">
    <div class = "col-md-12">
        <h1><?=$cms->user_logs_title?></h1>
        <h5><?=$cms->user_logs_text?></h5>
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Date &amp; Time<br><small class = "text-muted">[MM/DD/YYYY] - HH:mm:ss</small></th>
                        <th>User Number</th>
                        <th>User</th>
                        <th>Desc</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($logs): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><span class = "hidden"><?= $log->log_added_at?></span><?= date('[ m/d/Y ] - H:i:s',$log->log_added_at)?></td>
                                <td><?= $log->user_number?></td>
                                <td><?= $log->user_firstname." ".($log->user_middlename == '' ? '':  substr($log->user_middlename, 0, 1))." ".$log->user_lastname?></td>
                                <td><?= $log->log_desc?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>