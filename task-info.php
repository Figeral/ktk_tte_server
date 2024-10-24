<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// check admin
$user_role = $_SESSION['user_role'];


if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}

$page_name="Task_Info";
include("include/sidebar.php");
// include('ems_header.php');


?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog add-category-modal">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title text-center">Assign New Task</h3>
        </div>
        <div class="modal-body">
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
                    <label class="control-label ">Start Time</label>
                    
                      <input type="text" name="t_start_time" id="t_start_time" class="form-control">
                    </div>
                 
                  <div class="form-group col-md-6">
                    <label class="control-label ">End Time</label>
                    
                      <input type="text" name="t_end_time" id="t_end_time" class="form-control">
                    
                  </div>
                  <div class="form-group col-md-6">
                    <label class="control-label ">Assign To</label>
                    
                      <?php 
                        $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                        $info = $obj_admin->manage_all_info($sql);   
                      ?>
                      <select class="form-control" name="assign_to" id="aassign_to" required>
                        <option value="">Select Employee...</option>

                        <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                        <?php } ?>
                      </select>
                    
                   
                  </div>
                  <div class="form-group col-md-6">
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





    <div class="row">
      <div class="col-md-12">
        <div class="well well-custom">
          <div class="gap"></div>
          <div class="row">
            <div class="col-md-8">
              <div class="btn-group">
                <?php if($user_role == 1){ ?>
                <div class="btn-group">
                  <button class="btn btn-primary btn-menu" data-toggle="modal" data-target="#myModal">Assign New Task</button>
                </div>
              <?php } ?>

              </div>

            </div>

            
          </div>
          <center ><h3>Task Management Section</h3></center>
          <div class="gap"></div>

          <div class="gap"></div>

          <div class="table-responsive">
            <table class="table table-codensed  display" id="example" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Task Title</th>
                  <th>Assigned To</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              <?php 
                if($user_role == 1){
                  $sql = "SELECT a.*, b.fullname 
                        FROM task_info a
                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                        ORDER BY a.task_id DESC";
                }else{
                  $sql = "SELECT a.*, b.fullname 
                  FROM task_info a
                  INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                  WHERE a.t_user_id = $user_id
                  ORDER BY a.task_id DESC";
                } 
                
                  $info = $obj_admin->manage_all_info($sql);
                  $serial  = 1;
                  $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7">No Data found</td></tr>';
                  }
                      while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                <tr>
                  <td><?php echo $serial; $serial++; ?></td>
                  <td><?php echo $row['t_title']; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td><?php echo $row['t_start_time']; ?></td>
                  <td><?php echo $row['t_end_time']; ?></td>
                  <td>
                    <?php  if($row['status'] == 1){
                        echo " <span class='label label-warning' ><i class=' glyphicon glyphicon-refresh'></i> In Progress</span>";
                    }elseif($row['status'] == 2){
                       echo " <span class='label label-success'><i class='glyphicon glyphicon-ok'></i> Completed </span>";
                    }else{
                      echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove'></i> Incomplete </span>";
                    } ?>
                    
                  </td>
  
                 <td><a title="Update Task"  href="edit-task.php?task_id=<?php echo $row['task_id'];?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                  <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-folder-open"></span></a>&nbsp;&nbsp;
                  <?php if($user_role == 1){ ?>
                  <a class="btn btn-danger btn-sm" title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td>
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
