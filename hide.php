<?php
session_start();

if(isset($_SESSION['loggedin']) || (isset($_SESSION['email']) && $_SESSION['email'] == true)){
    header("location: /project/dashbord.php");
    $msg = true;
}
// if(isset($_SESSION['loggedin']) || (isset($_SESSION['email']) && $_SESSION['email'] == true)){
//     header("location: profile.php");
// }
?>