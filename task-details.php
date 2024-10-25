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

$sql = "SELECT a.*, b.fullname 
FROM task a
LEFT JOIN tbl_admin b ON(a.id = b.user_id)
WHERE a.id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



<div class="row">
	<div class="col-md-12">
		<div class="well well-custom">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="well">
						<h3 class="text-center bg-primary" style="padding: 7px;">Task Details </h3><br>

						<div class="row">
							<div class="col-md-12">

								<div class="table-responsive">
									<table class="table table-codensed  display" id="detail_page" style="width:100%">
										<thead>
											<tr>
												<th>Field</th>
												<th>Value</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Task Title</td>
												<td><?php echo $row['slug']; ?></td>
											</tr>
											<tr>
												<td>Description</td>
												<td><?php echo $row['description']; ?></td>
											</tr>

											<tr>
												<td>Created By</td>
												<td><?php echo $row['fullname']; ?></td>
											</tr>
											<tr>
												<td>Task Link</td>
												<td><?php echo $row['link']; ?></td>
											</tr>
											<tr>
												<td>Task image</td>
												<td> <img src="<?php echo $row['image_link'];
																?>" alt="" height="150"></td>
											</tr>
											<tr>
												<td>Status</td>
												<td><?php if ($row['status'] == 1) {
														echo "Pending";
													} elseif ($row['status'] == 2) {
														echo "Active";
													} else {
														echo "Archived";
													} ?></td>
											</tr>
											<tr>
												<td>Creation Time</td>
												<td><?php echo $row['created_at']; ?></td>
											</tr>
											<tr>
												<td>Update Time</td>
												<td><?php echo $row['updated_at'] == NULL ? "" : $row['updated_at']; ?></td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="form-group">

									<div class="col-sm-3">
										<a title="Update Task" href="task-info.php"><span class="btn btn-success-custom btn-xs">Go Back</span></a>
									</div>
								</div>
								</form>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
</div>


<?php


include("include/footer.php");

?>