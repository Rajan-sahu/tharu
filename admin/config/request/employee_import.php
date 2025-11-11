<?php
include_once('../conection.php');

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(array('status' => 400, 'message' => "Please upload CSV file."));
    return;
}

$file_ext = strtolower(pathinfo($_FILES["csv_file"]["name"], PATHINFO_EXTENSION));

if ($file_ext !== "csv") {
    http_response_code(400);
    echo json_encode(array('status' => 400, 'message' => "Invalid file format, only CSV allowed."));
    return;
}

$csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');

// Skip header row
fgetcsv($csvFile);

while (($row = fgetcsv($csvFile)) !== false) {

    // Map CSV columns to DB fields
    $name        = db_sanitize($row[0]);
    $f_name      = db_sanitize($row[1]);
    $gender      = db_sanitize($row[2]);
    $dob         = db_sanitize($row[3]);
    $doj         = db_sanitize($row[4]);
    $doe         = db_sanitize($row[5]);
    $mobile_no   = db_sanitize($row[6]);
    $station     = db_sanitize($row[7]);
    $department  = db_sanitize($row[8]);
    $designation = db_sanitize($row[9]);
    $shift       = db_sanitize($row[10]);
    $device_sr   = db_sanitize($row[11]);
    $device_user = db_sanitize($row[12]);

    // Skip rows if required fields are missing
    if (empty($name) || empty($gender) || empty($station) || empty($department) || empty($designation) || empty($shift)) {
        continue;
    }

    // Check duplicate employee (same condition as your add code)
    $check_exist = "
        SELECT id FROM zuraud_employee 
        WHERE name='$name' AND f_name='$f_name' AND station='$station' 
        AND department='$department' AND designation='$designation' AND shift='$shift'
    ";
    $result = $conn->query($check_exist);
    if ($result && $result->num_rows > 0) {
        continue;
    }

    // Check attendance machine assignment
    if (!empty($device_sr) && !empty($device_user)) {
        $check_slot = "
            SELECT id FROM zuraud_employee 
            WHERE device_sr='$device_sr' AND device_user='$device_user'
        ";
        $slot = $conn->query($check_slot);
        if ($slot && $slot->num_rows > 0) {
            continue;
        }
    }

    // Insert new employee
    $insertquery = "
        INSERT INTO zuraud_employee
        (name, f_name, gender, dob, doj, doe, mobile_no, station, department, designation, shift, device_sr, device_user)
        VALUES ('$name', '$f_name', '$gender', '$dob', '$doj', '$doe', '$mobile_no', '$station', '$department', '$designation', '$shift', '$device_sr', '$device_user')
    ";

    $conn->query($insertquery);
}

fclose($csvFile);

http_response_code(201);
echo json_encode(array('status' => 201, 'message' => "CSV imported successfully."));
return;
?>
