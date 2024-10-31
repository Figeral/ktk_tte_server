<?php
require 'authentication.php';
$user_name = $_SESSION['name'];
$user_id = $_SESSION['admin_id'];
if (isset($_POST['add_task_post'])) {
    $obj_admin->add_new_task($_POST, $user_id);
}

$page_name = "Task_Info";
include("include/sidebar.php");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Modal -->

<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="row">

                <h3 class="" style="padding: 7px;">Create Task </h3><br>
                <form role="form" action="" method="post" autocomplete="off">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Task Title</label>

                            <input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control" id="default" required>

                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label ">Task Description</label>

                            <textarea name="task_description" id="task_description" placeholder="Text Deskcription" class="form-control" rows="5" cols="5"></textarea>

                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label ">Task Link</label>

                            <input placeholder="Task Link" type=" text" name="task_link" id="task_link" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label ">Image Link</label>

                            <input placeholder="Image Link" type="text" name="image_link" id="image_link" class="form-control">

                        </div>


                        <div class="form-group col-md-6">
                            <label class="control-label ">Created By</label>

                            <select name="user_id" id="user_id" class="form-control" disabled>
                                <option value="<?php echo $user_id ?>">
                                    <?php echo $user_name ?> </option>
                            </select>

                        </div>
                        <div class=" form-group col-md-6">

                        </div>

                    </div>
                    <div class=" form-group col-md-6">
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-sm-offset-3 col-sm-3">
                            <button type="submit" name="add_task_post" class="btn btn-success-custom">Assign Task</button>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-danger-custom" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>

    </div>
</div>
</div>