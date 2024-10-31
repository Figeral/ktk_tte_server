<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == NULL || $security_key == NULL) {
  header('Location: index.php');
}




if (isset($_GET['delete_attendance'])) {
  $action_id = $_GET['aten_id'];

  $sql = "DELETE FROM attendance_info WHERE aten_id = :id";
  $sent_po = "attendance-info.php";
  $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}


if (isset($_POST['add_punch_in'])) {
  $info = $obj_admin->add_punch_in($_POST);
}

if (isset($_POST['add_punch_out'])) {
  $obj_admin->add_punch_out($_POST);
}


$page_name = "Attendance";
include("include/sidebar.php");

//$info = "Hello World";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <div class="row">
        <div class="col-md-8 ">
          <div class="btn-group">
            <?php

            $sql = "SELECT * FROM stats";


            $info = $obj_admin->manage_all_info($sql);
            $num_row = $info->rowCount();
            if ($num_row == 0) {
            ?>

              <div class="btn-group">
                <form method="post" role="form" action="">
                  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                  <button type="submit" name="add_punch_in" class="btn btn-primary btn-lg rounded">Clock In</button>
                </form>

              </div>

            <?php } ?>

          </div>
        </div>

      </div>

      <center>
        <h3>Manage Statistics</h3>
      </center>
      <div class="gap"></div>

      <div class="gap"></div>

      <div class="table-responsive">
        <table class="table table-codensed  display" id="example" style="width:100%">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>User Mail</th>
              <th>Score</th>
              <th># Claims</th>
              <th># Restarted</th>
              <th># Has Claim</th>
              <?php if ($user_role == 1) { ?>
                <th>Action</th>
              <?php } ?>
            </tr>
          </thead>

          <tbody>

            <?php
            if ($user_role == 1) {
              $sql = "SELECT a.*, b.* 
                  FROM stats a
                  LEFT JOIN user b ON(a.id_user = b.id)
                  ORDER BY a.id DESC";
            } else {
              echo '<tr><td colspan="7">No Data found</td></tr>';
            }


            $info = $obj_admin->manage_all_info($sql);
            $serial  = 1;
            $num_row = $info->rowCount();
            if ($num_row == 0) {
              echo '<tr><td colspan="7">No Data found</td></tr>';
            }
            while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <tr>
                <td><?php echo $row['id'];
                    ?></td>
                <td><?php echo $row['mail']; ?></td>
                <td><?php echo $row['score']; ?></td>
                <td><?php echo $row['claims']; ?></td>
                <td><?php echo $row['restarted']; ?></td>
                <td><?php echo $row['is_claim'] == 1 ?  "True" : "False";    ?></td>
                <?php if ($user_role == 1) { ?>
                  <td>
                    <a title="" href="stats-edit.php?stat_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                    <a class="btn btn-danger btn-sm" title="Delete" href="?delete_stats=delete_stats&stat_id=<?php echo $row['id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>&nbsp;&nbsp;

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