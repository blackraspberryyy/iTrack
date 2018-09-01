<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>admindashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Audit Trail</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class="row">
    <div class = "col-xs-12">
        <h1 class="text-center">Audit Trail</h1>
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Date &amp; Time<br><small class = "text-muted">[MM/DD/YYYY] - HH:mm:ss</small></th>
                        <th>User Number</th>
                        <th>Type</th>
                        <th>Desc</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($audits): ?>
                        <?php foreach ($audits as $audit): ?>
                            <tr>
                                <td><span class = "hidden"><?= $audit->log_added_at?></span><?= date('[ m/d/Y ] - H:i:s',$audit->log_added_at)?></td>
                                <td><?= $audit->user_id?></td>
                                <td><?= $audit->log_type?></td>
                                <td><?= $audit->log_desc?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

