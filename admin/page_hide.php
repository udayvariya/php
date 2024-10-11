<?php

session_start();
        if(!isset($_SESSION['loggedin1']) || $_SESSION['loggedin1'] == false){
        header("location: admin_login.php");
        }
?>