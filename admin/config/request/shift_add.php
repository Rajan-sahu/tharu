 <?php
   include_once('../conection.php');

   if (isset($_POST['name']) && !empty(db_sanitize($_POST['name']))) {
      $name = db_sanitize($_POST['name']);
   } else {
      http_response_code(400);
      echo json_encode(array('status' => 400, 'message' => 'Shift Name is required.'));
      return;
   }

   if (isset($_POST['start_time']) && !empty(db_sanitize($_POST['start_time']))) {
      $start_time = db_sanitize($_POST['start_time']);
   } else {
      http_response_code(400);
      echo json_encode(array('status' => 400, 'message' => 'Shift Start Time is required.'));
      return;
   }

   if (isset($_POST['end_time']) && !empty(db_sanitize($_POST['end_time']))) {
      $end_time = db_sanitize($_POST['end_time']);
   } else {
      http_response_code(400);
      echo json_encode(array('status' => 400, 'message' => 'Shift End Time is required.'));
      return;
   }   

   if (isset($_POST['update_id']) && !empty(db_sanitize($_POST['update_id']))) {
      $update_id = db_sanitize($_POST['update_id']);
   } else {
      $update_id = "";
   }

   if (!empty($update_id)) {
      $check_exist = "SELECT id FROM zuraud_shift WHERE name = '{$name}'  AND id != '{$update_id}'";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Shift already exists with same name.'));
         return;
      }

      try {
         $updatequery = "UPDATE `zuraud_shift` SET `name` = '$name', `start_time` = '$start_time', `end_time` = '$end_time' WHERE id = '$update_id' ";

         $update = $conn->query($updatequery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Shift updated Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      }
   } else {
      $check_exist = "SELECT id FROM zuraud_shift WHERE name = '{$name}'  ";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Shift already exists with same name.'));
         return;
      }

      try {
         $insertquery = "INSERT INTO `zuraud_shift`( `name`, `start_time`, `end_time`) VALUES ('$name', '$start_time', '$end_time')";

         $insert = $conn->query($insertquery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Shift added Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      } 
   }

   ?>



