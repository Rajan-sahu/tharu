<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tharuattendance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    // echo "Connected successfully";
}


// Sanitize input string
function db_sanitize($string)
{
    global $conn;
    if (!empty($string)) {
        $string = trim($string);
        $string = strip_tags($string);
        $string = $conn->real_escape_string($string);
        $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        return $string;
        $string = trim($string);
    }
    return '';
}

function get_table_name($id){
    $tables=[
        '1' => 'zuraud_department',
        '2' => 'zuraud_designation',
        '3' => 'zuraud_employee',
        '4' => 'zuraud_shift',
        '5' => 'zuraud_station',
    ];

    return($tables[$id]);
}
