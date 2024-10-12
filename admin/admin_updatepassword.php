<?php
include "_dbconnect.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $password = $_POST['password'];
    $email = $_POST['email'];
    $sql = "UPDATE `admin_data` SET `password`='$password' WHERE `email` = '$email'";
    $query = mysqli_query($conn,$sql);
    if($query){
        echo "    <script>
                    alert('Password updated sucessfully');
                    </script>
            ";
        }
    else{
        echo '
        <script>
            alert("server dwon try again leter");
        </script>
    ';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/project/style/updatepassword.css">
    <title>Update_password</title>
</head>
<body>
    <?php
        if(isset($_GET['email']) && isset($_GET['reset_token'])){
        date_default_timezone_set('Asia/kolkata');
        $date=date('y-m-d');
        $sql = "SELECT * FROM `admin_data` where `email`= '$_GET[email]' AND `resettoken`='$_GET[reset_token]' AND `resettokenexp`='$date'";
        $result = mysqli_query($conn,$sql);
        if($result){
            if(mysqli_num_rows($result) == 1){
                echo "
                    <div class='container'>
                    <form action='admin_updatepassword.php' method = 'POST'>
                    <label>Create New Password</label><br>
                    <input type='password' name='password' placeholder='Enter New Password'>
                    <button type='submit' name 'updatepassword'>UPDATE</button>
                    <input type='hidden' name='email' value ='$_GET[email]'>
                    </form>
                    </div>
                ";
            }
            else{
                echo "Invalid & Expire";
            }
        }else{
            echo "server down";
        }
        }
    ?>
</body>
</html>