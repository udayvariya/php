<?php
$servername="localhost";
$uername="root";
$password="";
$database ="php_task";

$conn =  mysqli_connect($servername,$uername,$password,$database);
if (!$conn){
//     echo "success";
// }
// else{
die("Error". mysqli_connect_error());
}
?>
