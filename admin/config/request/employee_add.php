 <?php
   include_once('../conection.php');

   if (isset($_POST['name']) && !empty(db_sanitize($_POST['name']))) {
      $name = db_sanitize($_POST['name']);
   } else {
      http_response_code(400);
      echo json_encode(array('status' => 400, 'message' => 'Shift Name is required.'));
      return;
   }

   if (isset($_POST['f_name']) && !empty(db_sanitize($_POST['f_name']))) {
      $f_name = db_sanitize($_POST['f_name']);
   } else {
      $f_name = '';
   }

   if (isset($_POST['gender']) && !empty(db_sanitize($_POST['gender']))) {
      $gender = db_sanitize($_POST['gender']);
   } else {
      http_response_code(400);
      echo json_encode(array('status' => 400, 'message' => 'Gender is required.'));
      return;
   } 

   if (isset($_POST['dob']) && !empty(db_sanitize($_POST['dob']))) {
      $dob = db_sanitize($_POST['dob']);
   } else {
      $dob = '';
   }

   if (isset($_POST['mobile_no']) && !empty(db_sanitize($_POST['mobile_no']))) {
      $mobile_no = db_sanitize($_POST['mobile_no']);
   } else {
      $mobile_no = '';
   }   

   if (isset($_POST['doj']) && !empty(db_sanitize($_POST['doj']))) {
      $doj = db_sanitize($_POST['doj']);
   } else {
      $doj = '';
   }   

   if (isset($_POST['doe']) && !empty(db_sanitize($_POST['doe']))) {
      $doe = db_sanitize($_POST['doe']);
   } else {
      $doe = '';
   }   

   if (isset($_POST['station']) && !empty(db_sanitize($_POST['station']))) {
      $station = db_sanitize($_POST['station']);
   } else {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Please Select a Station.'));
         return;
   }   

   if (isset($_POST['department']) && !empty(db_sanitize($_POST['department']))) {
      $department = db_sanitize($_POST['department']);
   } else {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Please Select a Department.'));
         return;
   }   

   if (isset($_POST['designation']) && !empty(db_sanitize($_POST['designation']))) {
      $designation = db_sanitize($_POST['designation']);
   } else {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Please Select a Designation.'));
         return;
   }   

   if (isset($_POST['shift']) && !empty(db_sanitize($_POST['shift']))) {
      $shift = db_sanitize($_POST['shift']);
   } else {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Please Select a Shift.'));
         return;
   } 

   if (isset($_POST['device_sr']) && !empty(db_sanitize($_POST['device_sr']))) {
      $device_sr = db_sanitize($_POST['device_sr']);
   } else {
      $device_sr = '';         
   }   

   if (isset($_POST['device_user']) && !empty(db_sanitize($_POST['device_user']))) {
      $device_user = db_sanitize($_POST['device_user']);
   } else {
      $device_user = '';         
   }   

   if (isset($_POST['update_id']) && !empty(db_sanitize($_POST['update_id']))) {
      $update_id = db_sanitize($_POST['update_id']);
   } else {
      $update_id = "";
   }

   if (!empty($update_id)) {
      $check_exist = "SELECT id FROM zuraud_employee WHERE name = '{$name}' AND f_name ='$f_name' AND station = '$station' AND department = '$department' AND designation = '$designation' AND shift = '$shift'  AND id != '{$update_id}'";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Employee already exists.'));
         return;
      }

      if(!empty($device_sr) && !empty($device_user)){
         $checkconfig= $conn->query("SELECT id FROM zuraud_employee WHERE  device_sr = '$device_sr' AND device_user = '$device_user'  AND id != '{$update_id}'");
         if($checkconfig && $checkconfig->num_rows>0){
            http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Attendance Machine slot already assigned to other employee.'));
         return;
         }
      }

      try {
         $updatequery = "UPDATE `zuraud_employee` SET `name` = '$name', `f_name` = '$f_name', `gender` = '$gender', `dob` = '$dob', `mobile_no` = '$mobile_no', `doj` = '$doj', `doe` = '$doe', `station` = '$station', `department` ='$department', `designation` = '$designation', `shift` = '$shift', `device_sr` = '$device_sr' , `device_user` = '$device_user'  WHERE `id` = '$update_id' ";

         $update = $conn->query($updatequery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Employee updated Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      }
   } else {
      $check_exist = "SELECT id FROM zuraud_employee WHERE name = '{$name}' AND f_name ='$f_name' AND station = '$station' AND department = '$department' AND designation = '$designation' AND shift = '$shift' ";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Employee already exists.'));
         return;
      }

      if(!empty($device_sr) && !empty($device_user)){
         $checkconfig= $conn->query("SELECT id FROM zuraud_employee WHERE  device_sr = '$device_sr' AND device_user = '$device_user' ");
         if($checkconfig && $checkconfig->num_rows>0){
            http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Attendance Machine slot already assigned to other employee.'));
         return;
         }
      }

      try {
         $insertquery = "INSERT INTO `zuraud_employee`( `name`, `f_name`,`gender`,`dob`,`doj`,`doe`,`mobile_no`,`station`,`department`,`designation`,`shift`,`device_sr`,`device_user`) VALUES ('$name', '$f_name','$gender','$dob','$doj','$doe','$mobile_no','$station','$department','$designation','$shift','$device_sr','$device_user')";

         $insert = $conn->query($insertquery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Employee added Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      } 
   }

   ?>



