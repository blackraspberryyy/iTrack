<style>
    .image-cropper {
        width: 180px;
        height: 180px;
        overflow: hidden;
        border-radius: 50%;
        margin:20px auto;
        box-shadow: 0px 0px 10px gray;
    }

    .image-cropper img {
        display: inline;
        margin: 0 auto;
        height: 100%;
        width: auto;
    }
    .form-control:read-only { 
        background-color: white;
    }
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    #img-upload{
        width: 100%;
    }
</style>
<div class="row">
    <ol class="breadcrumb">
        <li>
            <a href="<?= base_url() ?>userdashboard">
                <em class="fa fa-home"></em>
            </a>
        </li>
        <li class="active"><?= ucfirst($this->session->userdata("useraccess")) ?> Violation</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class = "row">
    <div class = "col-sm-3 text-center">
        <div class="image-cropper" >
            <img src = "<?= base_url() . $currentuser->user_picture ?>" alt="<?= $currentuser->user_firstname . " " . $currentuser->user_lastname ?>">
        </div>

    </div>
    <div class = "col-sm-9" style="padding:15px;">
        <h3><?= $currentuser->user_lastname . ", " . $currentuser->user_firstname . " " . $currentuser->user_middlename ?></h3>
        <h4><?= $currentuser->user_number ?></h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered datatable-class" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Violation Code</th>
                        <th>Violation</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <?php foreach ($violations as $violation): ?>
                    <tbody>
                        <tr>
                            <td><?= $violation->violation_id ?></td>
                            <td><?= $violation->violation_name ?></td>
                            <td><?= date('M j, Y', $violation->incident_report_datetime) ?></td>
                            <td><?= date('h: i A', $violation->incident_report_datetime) ?></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
