 <?php
  include_once('../conection.php');

  if(isset($_POST['email']) && !empty( db_sanitize($_POST['email']))){
     $email = db_sanitize($_POST['email']);
  }else{
    http_response_code(400);
     echo json_encode(array('status' => 400, 'message' => 'Email is required.'));
     return;
  }

  if(isset($_POST['password']) && !empty( db_sanitize($_POST['password']))){
     $password = sha1(db_sanitize($_POST['password'])); // Using sha1 for password hashing
  }else{
     http_response_code(400);
        echo json_encode(array('status' => 400, 'message' => 'Password is required.'));
        return;
  }

    $log = "SELECT * FROM sh_admin WHERE email = '{$email}' AND password = '{$password}'";
    $result = $conn->query($log);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];
         http_response_code(200);
        echo json_encode(array('status' => 200, 'message' => 'Login successful'));
    }else{
        http_response_code(401);
        echo json_encode(array('status' => 401, 'message' => 'Invalid email or password.'));
}
 ?>



