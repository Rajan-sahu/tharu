 <?php
   include_once('../conection.php');

   if (isset($_POST['title']) && !empty(db_sanitize($_POST['title']))) {
      $title = db_sanitize($_POST['title']);
   } else {
      http_response_code(400);
      echo json_encode(array('status' => 400, 'message' => 'Department Name is required.'));
      return;
   }

   

   if (isset($_POST['update_id']) && !empty(db_sanitize($_POST['update_id']))) {
      $update_id = db_sanitize($_POST['update_id']);
   } else {
      $update_id = "";
   }

   if (!empty($update_id)) {
      $check_exist = "SELECT id FROM zuraud_department WHERE title = '{$title}'  AND id != '{$update_id}'";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Department already exists with same name.'));
         return;
      }

      try {
         $updatequery = "UPDATE `zuraud_department` SET `title` = '$title' WHERE id = '$update_id' ";

         $update = $conn->query($updatequery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Department updated Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      }
   } else {
      $check_exist = "SELECT id FROM zuraud_department WHERE title = '{$title}'  ";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Department already exists with same name.'));
         return;
      }

      try {
         $insertquery = "INSERT INTO `zuraud_department`( `title`) VALUES ('$title')";

         $insert = $conn->query($insertquery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Department added Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      }
   }

   ?>



