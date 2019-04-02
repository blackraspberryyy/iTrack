<div class="row">
  <ol class="breadcrumb">
    <li><a href="<?= base_url() ?>AdminDashboard">
      <em class="fa fa-home"></em>
    </a></li>
    <li class="active">Minor Reports</li>
  </ol>
</div><!--/.row breadcrumb-->

<div class="row">
  <div class="col-xs-12">
    <h1><?= $cms->minor_reports_title?></h1>
    <h5><?= $cms->minor_reports_text?></h5>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <?php if(!$minor_reports):?>
    <center><h3>No minor reports so far...</h3></center>
    <?php else:?>
    <div class="table-responsive">
      <table class="table table-bordered datatable">
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Middlename</th>
            <th>Lastname</th>
            <th>Violation</th>
            <th>Tapped At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($minor_reports as $mr):?>
          <tr>
            <td><?= $mr->user_fname?></td>
            <td><?= $mr->user_mname?></td>
            <td><?= $mr->user_lname?></td>
            <td><?= $mr->violation_name?></td>
            <td><?= date("F d,Y - h:i A", $mr->tapped_at)?></td>
            <td>
              <button class ="btn btn-primary"type="button" data-toggle="modal" data-target="#mr_details_<?= $mr->mr_id?>">Details</button> 
            </td> 
          </tr>
          <div class="modal fade text-left" id="mr_details_<?= $mr->mr_id?>" tabindex="-1" role="dialog" aria-labelledby="detailsTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="detailsTitle">Details</h3>
                </div>
                <div class="modal-body" style="text-align:center;">
                  <div class="row">
                    <div class="col-xs-6">
                      <h3>User</h3>
                      <p><?= $mr->user_fname." ".$mr->user_mname." ".$mr->user_lname;?></p>
                      <h3>Reporter</h3>
                      <p><?= $mr->reporter_fname." ".$mr->reporter_mname." ".$mr->reporter_lname;?></p>
                      <h3>Violation</h3>
                      <p><?= $mr->violation_name;?></p>
                    </div>
                    <div class="col-xs-6">
                      <h3>Location</h3>
                      <p><?= $mr->location ? $mr->location : "None";?></p>
                      <h3>Message</h3>
                      <p><?= $mr->message ? $mr->message : "None";?></p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12">
                      <h3>Tapped At</h3>
                      <p><?= date("F d,Y - h:i A", $mr->tapped_at)?></p>
                    </div>
                    <div class="col-xs-12">
                      <?php if(isset($mr->img_src) && $mr->img_src):?>
                      <div class="col-xs-12">
                        <center>
                          <h5><strong>Image</strong></h5>
                          <img src="<?= base_url().'uploads/images/'.$mr->img_src?>" width="350" class="thumbnail"/>
                        </center>
                      </div>
                      <?php endif;?>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div> <!--END DETAILS MODAL-->
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    <?php endif;?>
  </div>
</div>
