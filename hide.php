<?php
session_start();

if(isset($_SESSION['loggedin']) || (isset($_SESSION['email']) && $_SESSION['email'] == true)){
    header("location: dashbord.php");
}
// if(isset($_SESSION['loggedin']) || (isset($_SESSION['email']) && $_SESSION['email'] == true)){
//     header("location: profile.php");
// }
?>