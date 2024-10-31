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

if (isset($_POST['create_cron'])) {
    $obj_cron = new CronService(new Database);
    $data = array();

    array_push($data, array(":starts_at", $_POST['starts_at']));
    array_push($data, array(":ends_at", $_POST['ends_at']));
    array_push($data, array(":is_active", $_POST['is_active']));

    try {
        $obj_cron->create($data);
    } catch (\Throwable $th) {
        throw $th;
    }
}


$page_name = "Cron";
include("include/sidebar.php");

?>

<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="row">

                <h3 class="" style="padding: 7px;">Create Cron</h3><br>

                <div class="row">
                    <div class="col-md-12">
                        <form class="row" role="form" action="" method="post" autocomplete="off">

                            <div class="form-group col-md-6">
                                <label class="control-label">Start Time</label>

                                <input type="text" name="starts_at" id="starts_at" class="form-control">

                            </div>
                            <div class=" form-group col-md-6">
                                <label class="control-label">End Time</label>

                                <input type="text" name="ends_at" id="ends_at" class="form-control">

                            </div>


                    </div>

                    <div class=" form-group col-md-6">
                        <label class="control-label">Status</label>

                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1" <?php if ($row['is_active'] == 1) { ?>selected <?php } ?>>Active</option>
                            <option value="0" <?php if ($row['is_active'] == 0) { ?><?php } ?>>InActive</option>


                        </select>
                    </div>


                    <div class="form-group col-md-12">



                        <button type="submit" name="create_cron" class="btn btn-primary">Create Now</button>

                    </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
    flatpickr('#starts_at', {
        enableTime: true
    });

    flatpickr('#ends_at', {
        enableTime: true
    });
</script>


<?php

include("include/footer.php");
//   
//  
//
?>