<style>
    .file {
        visibility: hidden;
        position: absolute;
    }
</style>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>AdminDashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Main</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class="row">
    <div class="col-xs-12">
        <h1>Import Students</h1>
        <h5>Import Students that are saved in an excel file.</h5>
    </div>
</div>
<div class="row">
    <div class = "col-xs-10 col-xs-offset-1">
        <form action="<?= base_url('AdminImport/importExcel')?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="xlsx_file" class="file">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-paperclip"></i></span>
                    <input type="text" class="form-control" disabled placeholder="Upload File" aria-label="Upload File" aria-describedby="basic-addon1">
                    <div class="input-group-btn">
                        <button class="browse input-group-text btn btn-primary" type="button"><i class="fas fa-search"></i>  Browse</button>
                    </div>
                </div>
            </div>
            <center>
                <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-download"></i> Import</button>
            </center>
        </form>
    </div>
</div>

<script>
    $(document).on("click", ".browse", function() {
        var file = $(this)
            .parent()
            .parent()
            .parent()
            .find(".file");
        file.trigger("click");
    });
    $(document).on("change", ".file", function() {
        $(this)
            .parent()
            .find(".form-control")
            .val($(this)
                .val()
                .replace(/C:\\fakepath\\/i, "")
        );
    });
</script>