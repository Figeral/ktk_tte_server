<?php
// Cron creation and  edition template
require 'authentication.php'; // admin authentication check 
require_once "api/service/StatsService.php";
// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}


$user_role = $_SESSION['user_role'];

$stat_id = $_GET['stat_id'];




$page_name = "Attendance";
include("include/sidebar.php");

$sql = "SELECT a.*,b.*,c.* FROM stats a INNER JOIN user b ON (a.id_user=b.id) INNER JOIN cron c ON (a.id_cron=c.id)    WHERE a.id=$stat_id;
 ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) as ref_count FROM user WHERE p_referral = :referral";
$stmt = $obj_admin->db->prepare($sql);
$stmt->execute(['referral' => $r]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$ref_count = $result['ref_count'];


?>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="row">

                <h3 class="" style="padding: 7px;">Confirm claims</h3><br>

                <div class="row">
                    <div class="col-md-12">
                        <form class="row" role="form" action="" method="post" autocomplete="off">

                            <div class="form-group col-md-6">
                                <label class="control-label">Mail</label>

                                <input type="text" name="mail" id="mail" class="form-control" value="<?php echo $row['mail']; ?>" readonly>

                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Wallet Address</label>

                                <input type="text" name="wallet" id="wallet" class="form-control" value="<?php echo $row['wallet']; ?>" readonly>

                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"># Referrals</label>

                                <input type="text" class="form-control" value="<?php echo $ref_count; ?>">

                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Game Score</label>

                                <input type="text" name="score" id="score" class="form-control" value="<?php echo $row['score']; ?>">

                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label"># Claims</label>

                                <input type="text" name="claims" id="claims" class="form-control" value="<?php echo $row['claims']; ?>">

                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"># Restarted</label>

                                <input type="text" name="restarted" id="restarted" class="form-control" value="<?php echo $row['restarted']; ?>">

                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Cron Schedule</label>

                                <input type="text" class="form-control" value="<?php echo $row['starts_at'] . "  ~  " . $row['ends_at']; ?>">

                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Creation Time</label>

                                <input type="text" name="created_at" id="created_at" class="form-control" value="<?php echo $row['created_at']; ?>">

                            </div>



                    </div>

                    <?php
                    if (isset($_POST['Claim_Confirm'])) {
                        $service = new StatsService(new Database());
                        $service->modifySpecific($stat_id, "is_claim", array(array(":is_claim", 0)));
                        $service->modifySpecific($stat_id, "claims", array(array(":claims", $row['claims'] + 1)));
                        $service->modifySpecific($stat_id, "restarted", array(array(":restarted", $row['restarted'] + 1)));
                    }
                    ?>

                    <div class="form-group col-md-12">
                        <?php if ($row['is_claim'] == 1) { ?>
                            <button type="submit" name='Claim_Confirm' class='btn btn-primary'>
                                Confirm Claim</button>
                        <?php } ?>
                    </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
</div>