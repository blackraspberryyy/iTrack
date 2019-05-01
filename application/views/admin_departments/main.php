
<script>
	$(document).ready(function () {
        <?php if (validation_errors()) : ?>
            <?php if ($modal_type == 'add') : ?>
                $('#add_dept').modal({
                    show: 'true'
                })
            <?php else: ?>
                $('<?= $modal_id?>').modal({
                    show: 'true'
                })
            <?php endif; ?>
        <?php endif; ?>
	});
</script>
<style>
    .has-error, .has-error p{
        color: red !important;
    }
</style>
<?php
    function determineStatus($status)
    {
        if ($status == 0) {
            echo '<span class = "badge badge-danger">Deleted</span>';
        } else {
            echo '<span class = "badge badge-success" style="background: #28a745;">Active</span>';
        }
    }
?>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>AdminDashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Departments</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class="row">
    <div class = "col-xs-12">
        <h1>Departments</h1>
        <h5>Add, Edit, and Delete departments</h5>

        <div class="text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#add_dept">+ Add Departments</button>
        </div>
        <br/>
        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Supervisor</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($departments): ?>
                        <?php foreach ($departments as $dept): ?>
                            <tr>
                                <td><?= $dept->dept_name?></td>
                                <td><?= $dept->dept_supervisor?></td>
                                <td><?= determineStatus($dept->dept_status); ?></td>
                                <td>
                                    <center>
                                        <div class="btn-group-vertical" role="group">
                                            <button type = "button" class="btn btn-primary" data-toggle="modal" data-target="#edit_<?= $dept->dept_id; ?>">Edit</button>
                                            <?php if ($dept->dept_status != 0): ?>
                                                <a href="<?= base_url().'AdminDepartments/delete_department/'.$dept->dept_id?>" class="btn btn-danger">Delete</a>
                                            <?php else: ?>
                                                <a href="<?= base_url().'AdminDepartments/restore_department/'.$dept->dept_id?>" class="btn btn-warning">Restore</a>
                                            <?php endif; ?>
                                        </div>
                                    </center>
                            </tr>

                            <!-- EDIT MODAL -->
                            <div class="modal fade text-left" id="edit_<?= $dept->dept_id; ?>" tabindex="-1" role="dialog" aria-labelledby="editTitle" aria-hidden="true">
								<form action="<?= base_url()?>AdminDepartments/edit_department_exec/<?= $dept->dept_id; ?>" method="POST">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h3 class="modal-title" id="editTitle">Edit Departments</h3>
											</div>
											<div class="modal-body">
												<div class="row">
                                                    <div class="col-xs-6">
                                                        <span class="control-label <?= !empty(form_error('name')) ? 'has-error' : ''; ?>">Department Name</span>
                                                        <input type="text" class="form-control" name = "name" placeholder="Type Here" value = "<?= set_value('name', $dept->dept_name); ?>">
                                                        <small class="has-error"><?= form_error('name'); ?></small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <span class="control-label <?= !empty(form_error('supervisor')) ? 'has-error' : ''; ?>">Supervisor Full Name</span>
                                                        <input type="text" class="form-control" name = "supervisor" placeholder="Type Here" value = "<?= set_value('supervisor', $dept->dept_supervisor); ?>">
                                                        <small class="has-error"><?= form_error('supervisor'); ?></small>
                                                    </div>
                                                </div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Edit</button>
											</div>
										</div>
									</div>
								</form>
							</div> <!--END DETAILS MODAL-->
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade text-left" id="add_dept" tabindex="-1" role="dialog" aria-labelledby="editTitle" aria-hidden="true">
    <form action="<?= base_url()?>AdminDepartments/add_department_exec" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="editTitle">Add Departments</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <span class="control-label <?= !empty(form_error('name')) ? 'has-error' : ''; ?>">Department Name</span>
                            <input type="text" class="form-control" name = "name" placeholder="Type Here" value = "<?= set_value('name'); ?>">
                            <small class="has-error"><?= form_error('name'); ?></small>
                        </div>
                        <div class="col-xs-6">
                            <span class="control-label <?= !empty(form_error('supervisor')) ? 'has-error' : ''; ?>">Supervisor Full Name</span>
                            <input type="text" class="form-control" name = "supervisor" placeholder="Type Here" value = "<?= set_value('supervisor'); ?>">
                            <small class="has-error"><?= form_error('supervisor'); ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </form>
</div> <!--END DETAILS MODAL-->

