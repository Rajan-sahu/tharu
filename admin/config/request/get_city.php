 <?php
   include_once('../conection.php');

   if (isset($_POST['state']) && !empty(db_sanitize($_POST['state']))) {
      $state = db_sanitize($_POST['state']);
   } else {
      $state = '';
   }

   if (!empty($state)) {
      $state_sql = $conn->query("SELECT `id`,`city` FROM `tbl_cities` WHERE `state_id`='{$state}'");

      if ($state_sql && $state_sql->num_rows > 0) {
         while ($row = $state_sql->fetch_assoc()) {
            $cities[] = $row;
         }

         http_response_code(200);
         echo json_encode(array('status' => 200, 'data' => $cities));
         return;
      }
   }
   http_response_code(200);
   echo json_encode(array('status' => 200, 'data' => []));
   return;
   ?>



