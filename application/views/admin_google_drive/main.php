<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>AdminDashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Google Drive</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class="row">
    <div class="col-xs-12">
        <h1><?= $cms->google_drive_title?></h1>
        <h5><?= $cms->google_drive_text?></h5>
    </div>
</div>
<div class="row">
    <div class = "col-xs-10 col-xs-offset-1">
        <iframe src="https://drive.google.com/embeddedfolderview?id=1BjrnzCLpa9jKfJBoXsKqcoqNws47PCi7#list" style="width:100%; height:100%; border-radius: 3px; border:none; box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important;" ></iframe>
    </div>
</div>