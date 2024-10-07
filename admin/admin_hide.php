<?php
session_start();

if(isset($_SESSION['loggedin']) || (isset($_SESSION['email']) && $_SESSION['email'] == true)){
    header("location: admin_dashbord.php");
    
}

?>