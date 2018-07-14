<style>
    .image-cropper {
        width: 180px;
        height: 180px;
        overflow: hidden;
        border-radius: 50%;
        margin:20px auto;
    }

    .image-cropper img {
        display: inline;
        margin: 0 auto;
        height: 100%;
        width: auto;
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
        <li class="active"><?= ucfirst($this->session->userdata("useraccess")) ?> Profile</li>
    </ol>
</div><!--/.row breadcrumb-->

<form action = "<?= base_url() ?>userprofile/change_profile_exec" method="POST">
    <div class = "row">
        <div class = "col-xs-10 col-xs-offset-1 text-center">
            <div class="image-cropper">
                <img src = "<?= base_url() . $currentuser->user_picture ?>" alt="<?= $currentuser->user_firstname . " " . $currentuser->user_lastname ?>">
            </div>
            <button type = "button" class = "btn btn-primary" data-toggle="modal" data-target="#change_picture">Change Picture</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $(document).on('change', '.btn-file :file', function () {
            var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function (event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                    log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log)
                    alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });
    });
</script>

<!-- CHANGE PICTURE MODAL -->
<div class="modal fade" id="change_picture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action = "<?= base_url() ?>userprofile/change_picture_exec" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Picture</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse… <input type="file" id="imgInp" name = "picture">
                            </span>
                        </span>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <img id='img-upload'/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>