<div class="row">
  <ol class="breadcrumb">
    <li><a href="<?= base_url() ?>AdminDashboard"><em class="fa fa-home"></em></a></li>
    <li class="active">Email</li>
  </ol>
</div><!--/.row breadcrumb-->

<div class="row">
  <div class="col-xs-12">
    <h1><?= $cms->email_title?></h1>
    <h5><?= $cms->email_text?></h5>
  </div>
</div>
<div class="row margin-top-lg">
  <div class = "col-xs-12 col-sm-8 col-sm-offset-2">
    <form action ="<?= base_url() ?>AdminEmail/send_email_exec" method="POST">
      <small style = "text-align: left;">Email Address</small>
      <div class="input-group margin-bottom-sm">
        <span class="input-group-addon"><i class = "fa fa-envelope" id="basic-addon1"></i></span>
        <input type="text" class="form-control" id="email" name = "email" placeholder="(e.g. johndoe@somemail.com)" autocomplete="off">
      </div>
      <small style = "text-align: left;">Subject</small>
      <input type="text" class="form-control" id="subject" name = "subject" placeholder="Subject" autocomplete="off">
      <br/>
      <textarea name = "message" id = "message" rows="5" class = "form-control" placeholder = "Message" style = "resize: none;"></textarea>
      <br/>
      <center>
        <button type ="submit" name ="submit" class = "btn btn-primary "><i class = "fa fa-paper-plane"></i> Send Email</button>
      </center>
    </form>
  </div>
</div>