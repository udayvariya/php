<?php
session_start();

if(isset($_SESSION['loggedin1']) || (isset($_SESSION['email1']) && $_SESSION['email1'] == true)){
    // header("location: admin_dashbord.php");
    header("location:javascript://history.go(-1)");

    
}

?>