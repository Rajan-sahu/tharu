<?php

include_once('./config/conection.php');
// Read incoming data
$SN     = $_GET["SN"]     ?? null;
$table  = $_GET["table"]  ?? null;
$raw    = trim(file_get_contents("php://input"));

// Only process punch data coming from ATTLOG table OR if RAW contains data
if ($table === "ATTLOG" && !empty($raw)) {

    // RAW format sample:
    // 4    2025-11-10 15:03:54    0    1    0    0    0    0    0    0
    $parts = explode("\t", $raw);

    $UserID     = $parts[0] ?? "";
    $PunchTime  = $parts[1] ?? "";
    $punchType  = $parts[2] ?? "";  // 0 = Check-in, 1 = Check-out, varies by device

    $date = date("Y-m-d");
    $datetime= date("Y-m-d H:i:s");
        
    if($punchType=='0'){
        $userdata = $conn->query("SELECT id FROM `zuraud_employee` WHERE `device_sr`='$SN' AND `device_user` = '$UserID'");
        if($userdata && $userdata->num_rows>0){
            $user= $userdata->fetch_assoc();
            $uid=$user['id'];
            $punchindata= $conn->query("SELECT id FROM `zuraud_attendance` WHERE `user_id`='$uid' AND `date`='$date'");
            if($punchindata && $punchindata->num_rows>0){

            } 
            else{
                $punchin=$conn->query("INSERT INTO `zuraud_attendance`( `user_id`, `date`, `punch_in_date_time`) VALUES ('$uid','$date','$datetime')");
            }
        }
        
    }
    elseif($punchType=='1'){
        $userdata = $conn->query("SELECT id FROM `zuraud_employee` WHERE `device_sr`='$SN' AND `device_user` = '$UserID'");
        if($userdata && $userdata->num_rows>0){
            $user= $userdata->fetch_assoc();
            $uid=$user['id'];
            $punchindata= $conn->query("SELECT id FROM `zuraud_attendance` WHERE `user_id`='$uid' AND `date`='$date'");
            if($punchindata && $punchindata->num_rows>0){
                $att_data= $punchindata->fetch_assoc();
                $punchout=$conn->query("UPDATE `zuraud_attendance` SET `punch_out_date_time`='$datetime' WHERE `id`='{$att_data['id']}'");

            }
        }
        
    }
    
}

// Return OK to biometric machine
echo "OK";
?>