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
            <a href="<?= base_url() ?>UserDashboard">
                <em class="fa fa-home"></em>
            </a>
        </li>
        <li class="active"><?= ucfirst($this->session->userdata("useraccess")) ?> Profile</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class = "row">
    <div class = "col-sm-3 text-center">
        <div class="image-cropper" >
            <img src = "<?= base_url() . $currentuser->user_picture ?>" alt="<?= $currentuser->user_firstname . " " . $currentuser->user_lastname ?>">
        </div>
        <button type = "button" class = "btn btn-primary" data-toggle="modal" data-target="#change_picture"><i class="fa fa-images"></i> Change Picture</button>
    </div>
    <div class = "col-sm-9" style="padding:15px;">
        <div class ="row">
            <div class ="col-md-4">
                <span>Firstname</span>
                <input type = "text" class = "form-control" value = "<?= $currentuser->user_firstname ?>" readonly="">
            </div>
            <div class ="col-md-4">
                <span>Middlename</span>
                <input type = "text" class = "form-control" value = "<?= $currentuser->user_middlename ?>" readonly="">
            </div>
            <div class ="col-md-4">
                <span>Lastname</span>
                <input type = "text" class = "form-control" value = "<?= $currentuser->user_lastname ?>" readonly="">
            </div>
        </div>
        <div class="row" style = "margin-top:10px">
            <div class ="col-md-4">
                <span><?= ucfirst($currentuser->user_access) ?> Number</span>
                <input type = "text" class = "form-control" value = "<?= $currentuser->user_number ?>" readonly="">
            </div>
            <div class ="col-md-4">
                <span>Course</span>
                <input type = "text" class = "form-control" value = "<?= $currentuser->user_course ?>" readonly="">
            </div>
        </div>
        <br/>
        <center>
            <button class = "btn btn-primary" data-toggle="modal" data-target="#change_password"><i class="fa fa-pen"></i> Change Password</button>
        </center>
    </div>

</div>

<!-- TENTATIVE IDEA HERE: Display Audit Logs of this user -->


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
        <form action = "<?= base_url() ?>UserProfile/change_picture_exec" method="POST" enctype="multipart/form-data">
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

<!-- CHANGE PASSWORD MODAL -->
<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action = "<?= base_url() ?>UserProfile/change_password_exec" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-xs-6">
                            <div class="form-group <?= !empty(form_error("password")) ? "has-error" : ""; ?>">
                                <span class="control-label">Password</span>
                                <input type="password" class="form-control" name = "password" placeholder="Password">
                                <small><?= form_error("password") ?></small>
                            </div>
                        </div>
                        <div class = "col-xs-6">
                            <div class="form-group">
                                <span class="control-label">Confirm Password</span>
                                <input type="password" class="form-control" name = "confpassword" placeholder="Confirm Password" >
                                <small><?= form_error("confpassword") ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>