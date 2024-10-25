<?php

require 'authentication.php'; // admin authentication check 

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

$task_id = $_GET['task_id'];



if (isset($_POST['update_task_info'])) {
	$obj_admin->update_task_info($_POST, $task_id, $user_role);
}

$page_name = "Edit Task";
include("include/sidebar.php");

$sql = "SELECT * FROM task WHERE id='$task_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="row">
	<div class="col-md-12">
		<div class="well well-custom">
			<div class="row">

				<h3 class="" style="padding: 7px;">Edit Task </h3><br>

				<div class="row">
					<div class="col-md-12">
						<form class="row" role="form" action="" method="post" autocomplete="off">
							<div class="form-group col-md-6">
								<label class="control-label">Task Title</label>

								<input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control" value="<?php echo $row['slug']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?> val required>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Task Description</label>

								<textarea name="task_description" id="task_description" placeholder="Text Deskcription" class="form-control" rows="5" cols="5"><?php echo $row['description']; ?></textarea>

							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Task Link</label>

								<input type="text" placeholder="Task Link" id="task_link" name="task_link" list="expense" class="form-control" value="<?php echo $row['link']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?> val required>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Image Link</label>

								<textarea name="image_link" id="image_link" placeholder="Image Link" class="form-control" rows="5" cols="5"><?php echo $row['image_link']; ?></textarea>

							</div>

							<div class="form-group col-md-6">
								<label class="control-label">Created By</label>

								<select class="form-control" name="created_by" id="created_by" disabled="true">
									<option value="">
										<?php echo $user_name ?> </option>


								</select>

							</div>

							<div class="form-group col-md-6">
								<label class="control-label">Status</label>

								<select class="form-control" name="status" id="status">
									<option value="1" <?php if ($row['status'] == 1) { ?>selected <?php } ?>>Pending</option>
									<option value="2" <?php if ($row['status'] == 2) { ?>selected <?php } ?>>Active</option>
									<option value="0" <?php if ($row['status'] == 0) { ?>selected <?php } ?>>Archived</option>
								</select>
							</div>


							<div class="form-group col-md-12">



								<button type="submit" name="update_task_info" class="btn btn-primary">Update Now</button>

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
	flatpickr('#t_start_time', {
		enableTime: true
	});

	flatpickr('#t_end_time', {
		enableTime: true
	});
</script>


<?php

include("include/footer.php");
//   
//  
//
?>