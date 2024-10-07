<?php

include "admin_hide.php";

$login = false;
$showError = false;
$logout = true; 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST["email"];
    $password = $_POST["password"]; 
  
     
    $sql = "Select * from admin_data where email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num >0 ){
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        

        header("location: admin_home.php");
    } 
    else{
        $showError = "Invalid Credentials";
    }
}
    
?>
    
    
   

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <title>ADMIN</title>
    <link rel="stylesheet" href="/project/style/admin_login.css">    
</head>
<body>
<?php
if($login){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    if($showError){
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '. $showError.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    ?>
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">PHP</h2>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="/project/home.php">HOME</a></li>
                    <li><a href="admin_login.php">LOGIN</a></li>
                    <li><a href="admin_dashbord.php">DASHBORD</a></li>

            
                </ul>
            </div>

           
        </div> 
        <div class="content">
            <h1>PROJECT <br><span>MANAGEMENT</span> <br>SYSTEM</h1>
            <p class="par">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt neque 
                 expedita atque eveniet <br> quis nesciunt. Quos nulla vero consequuntur, fugit nemo ad delectus 
                <br> a quae totam ipsa illum minus laudantium?</p>


                <form action="admin_login.php" method="post">
                <div class="form">
                    <h2>Login Admin</h2>
                    <input type="text" name="email" placeholder="Enter email Here">
                    <input type="password" name="password" placeholder="Enter Password Here">
                    <button class="btnn">Login</a></button>

                    <p class="link">Change Password</p><br>
                    <p class="liw2"><a href="/project/admin/admin_forget.php">Forget Password ?</a></p>

                    
                </div>
            </form>

        </div>
    </div>
</body>
</html>