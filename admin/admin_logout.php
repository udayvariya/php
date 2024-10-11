<?php
session_start();
if (isset($_SESSION['email1'])) {
  // echo "uday";  
    session_unset();
    session_destroy();
    header("Location: admin_login.php");  
  }
  
?>