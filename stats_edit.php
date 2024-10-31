<?php
// Cron creation and  edition template
require 'authentication.php'; // admin authentication check 
require_once "api/service/CronService.php";
// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}
//   
//  
//
// check admin
$user_role = $_SESSION['user_role'];

$cron_id = $_GET['cron_id'];

if (isset($_POST['update_cron_info'])) {
    $obj_admin->updateCron($cron_id, $_POST);
}


$page_name = "Attendance";
include("include/sidebar.php");

$sql = "SELECT * FROM cron WHERE id='$cron_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="row">

                <h3 class="" style="padding: 7px;">Confirm claim</h3><br>

                <div class="row">
                    <div class="col-md-12">
                        <form class="row" role="form" action="" method="post" autocomplete="off">

                            <div class="form-group col-md-6">
                                <label class="control-label">Start Time</label>

                                <input type="text" name="starts_at" id="starts_at" class="form-control" value="<?php echo $row['starts_at']; ?>">

                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">End Time</label>

                                <input type="text" name="ends_at" id="ends_at" class="form-control" value="<?php echo $row['ends_at']; ?>">

                            </div>


                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label">Status</label>

                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1" <?php if ($row['is_active'] == 1) { ?>selected <?php } ?>>Active</option>
                            <option value="0" <?php if ($row['is_active'] == 0) { ?><?php } ?>>InActive</option>


                        </select>
                    </div>


                    <div class="form-group col-md-12">



                        <button type="submit" name="update_cron_info" class="btn btn-primary">Update Now</button>

                    </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
</div>