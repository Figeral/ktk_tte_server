<?php
require     "authentication.php";
require_once   "api/service/CronService.php";

$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == Null || $security_key == Null) {
    header('Location:index.php');
}
if ($user_role != 1) {
    header('Location:cron-manage.php');
}

if (isset($_GET['delete_cron'])) {
    $cron_id = $_GET['cron_id'];
    $sql = "DELETE FROM cron WHERE id = :id";
    $sent_po = "cron-manage.php";
    $obj_admin->delete_data_by_this_method($sql, $cron_id, $sent_po);
}
$page_name = "Cron";
include("include/sidebar.php");

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Modal -->






<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-8">
                    <div class="btn-group">
                        <?php if ($user_role == 1) { ?>
                            <div class="btn-group">
                                <a title="Create Task" href="cron-create.php"> <button class=" btn btn-primary btn-menu">Create New Cron</button></a>
                            </div>
                        <?php } ?>

                    </div>

                </div>


            </div>
            <center>
                <h3>Cron Management Section</h3>
            </center>
            <div class="gap"></div>

            <div class="gap"></div>

            <div class="table-responsive">
                <table class="table table-codensed  display" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $sql = "SELECT * FROM cron";
                        $data = $obj_admin->manage_all_info($sql);
                        $serial  = 1;
                        $num_row = $data->rowCount();
                        if ($num_row == 0) {
                            echo '<tr><td colspan="7">No Data found</td></tr>';
                        }

                        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?php
                                    echo $row['id']; ?></td>

                                <td><?php echo $row['starts_at']; ?></td>
                                <td><?php echo $row['ends_at']; ?></td>
                                <td>
                                    <?php if ($row['is_active'] == 1) {
                                        echo " <span class='label label-success' ><i class=' glyphicon glyphicon-ok'></i> Active</span>";
                                    } elseif ($row['is_active'] == 0) {
                                        echo " <span class='label label-default'><i class='glyphicon glyphicon-remove'></i> InActive </span>";
                                    }  ?>

                                </td>

                                <td><a title="Update Task" href="cron-edit.php?cron_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;

                                    <?php if ($user_role == 1) { ?>
                                        <a class="btn btn-danger btn-sm" title="Delete" href="?delete_cron=delete_cron&cron_id=<?php echo $row['id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            <?php } ?>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php

include("include/footer.php");



?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
    flatpickr('#t_start_time', {
        enableTime: true
    });

    flatpickr('#t_end_time', {
        enableTime: true
    });
</script>