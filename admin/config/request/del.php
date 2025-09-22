 <?php
  include_once('../conection.php');

  if(isset($_POST['del_id']) && !empty( db_sanitize($_POST['del_id']))){
     $del_id = db_sanitize($_POST['del_id']);
  }else{
    http_response_code(400);
     echo json_encode(array('status' => 400, 'message' => 'Something Went Wrong.'));
     return;
  }
  if(isset($_POST['table_name']) && !empty( db_sanitize($_POST['table_name']))){
     $table_name = db_sanitize($_POST['table_name']);
  }else{
    http_response_code(400);
     echo json_encode(array('status' => 400, 'message' => 'Something Went Wrong.'));
     return;
  }

  $db_table = get_table_name($table_name);
  
  
   try {
         $deleteQuery = "DELETE FROM `{$db_table}` WHERE id = '{$del_id}' ";

         $delete = $conn->query($deleteQuery);
         http_response_code(200);
         echo json_encode(array('status' => 200, 'message' => 'Data Deleted Successfully.'));
         return;
      } catch (mysqli_sql_exception $e) {
         http_response_code(500);
         echo json_encode(array('status' => 500, 'message' => 'Internal Server Error.'));
         return;
      }



    
 ?>



