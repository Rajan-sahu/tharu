 <?php
   include_once('../conection.php');

   if (isset($_POST['station_name']) && !empty(db_sanitize($_POST['station_name']))) {
      $station_name = db_sanitize($_POST['station_name']);
   } else {
      http_response_code(400);
      echo json_encode(array('status' => 400, 'message' => 'Station Name is required.'));
      return;
   }

   if (isset($_POST['address']) && !empty(db_sanitize($_POST['address']))) {
      $address = db_sanitize($_POST['address']);
   } else {
      $address = "";
   }

   if (isset($_POST['latitude']) && !empty(db_sanitize($_POST['latitude']))) {
      $latitude = db_sanitize($_POST['latitude']);
   } else {
      $latitude = "";
   }

   if (isset($_POST['longitude']) && !empty(db_sanitize($_POST['longitude']))) {
      $longitude = db_sanitize($_POST['longitude']);
   } else {
      $longitude = "";
   }

   if (isset($_POST['state']) && !empty(db_sanitize($_POST['state']))) {
      $state = db_sanitize($_POST['state']);
   } else {
      $state = "";
   }

   if (isset($_POST['city']) && !empty(db_sanitize($_POST['city']))) {
      $city = db_sanitize($_POST['city']);
   } else {
      $city = "";
   }

   if (isset($_POST['update_id']) && !empty(db_sanitize($_POST['update_id']))) {
      $update_id = db_sanitize($_POST['update_id']);
   } else {
      $update_id = "";
   }

   if (!empty($update_id)) {
      $check_exist = "SELECT id FROM zuraud_station WHERE station_name = '{$station_name}' AND state = '{$state}' AND city = '{$city}' AND id != '{$update_id}'";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Station already exists with same name.'));
         return;
      }

      try {
         $updatequery = "UPDATE `zuraud_station` SET `station_name` = '$station_name', `address`='$address', `latitude`='$latitude', `longitude`='$longitude',`state`='$state',  `city`='$city' WHERE id = '$update_id' ";

         // print_r($updatequery);die;

         $update = $conn->query($updatequery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Station updated Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      }
   } else {
      $check_exist = "SELECT id FROM zuraud_station WHERE station_name = '{$station_name}' AND state = '{$state}' AND city = '{$city}' ";
      $result = $conn->query($check_exist);

      if ($result && $result->num_rows > 0) {
         http_response_code(400);
         echo json_encode(array('status' => 400, 'message' => 'Station already exists with same name.'));
         return;
      }

      try {
         $insertquery = "INSERT INTO `zuraud_station`( `station_name`, `address`, `latitude`, `longitude`, `state`, `city`) VALUES ('$station_name','$address','$latitude','$longitude','$state','$city')";

         $insert = $conn->query($insertquery);
         http_response_code(201);
         echo json_encode(array('status' => 201, 'message' => 'Station added Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      }
   }

   ?>



