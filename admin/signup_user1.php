<?php
include '_dbconnect.php';
include "page_hide.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email,$reset_token){
require('C:\xampp2\htdocs\project\phpmailer\PHPMailer.php');
require('C:\xampp2\htdocs\project\phpmailer\SMTP.php');
require('C:\xampp2\htdocs\project\phpmailer\Exception.php');

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'udayvariya302@gmail.com';                     //SMTP username
    $mail->Password   = 'cdmzvuphceldiyia';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('udayvariya302@gmail.com', 'UDAY PASS');
    $mail->addAddress($email);     //Add a recipient

    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Set Your New Password';
    $mail->Body    = "we got request the reset password link <br>
    click the link below : <br>
    <a href='http://localhost/project/updatepassword.php?email=$email&reset_token=$reset_token'>Create Password</a>";

    $mail->send();
    return true;
} 
catch (Exception $e) {
    return false;
}

}

$showAlert = false;
$showError = false;
$fname = true;
$lname = true;
$mail = true;
$mno = true;
$file_nameErr = $firstnameErr = $lastnameErr = $emailErr = $mobilenoErr =  "";
$firstname = $lastname = $email = $mobileno = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_FILES['image'])){
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        // move_uploaded_file($file_tmp,"/project/images2/" . $file_name);
    
        if (empty($_POST["firstname"])) {
            $firstnameErr = " * Firstname is required";
            $fname = false;

          } else {
            $firstname = ($_POST["firstname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
                $firstnameErr = "Only letters and white space allowed";
                $fname = false;
              }
          }
        
          if (empty($_POST["lastname"])) {
            $lastnameErr = " * Lastname is required";
            $lname = false;

          } else {
            $lastname = ($_POST["lastname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
                $lastnameErr = "Only letters and white space allowed";
                $lname = false;
              }
          }

          if (empty($_POST["email"])) {
            $emailErr = " * email is required";
            $mail = false;


          } else {
            $email = ($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    $mail = false;
                }
          } 
          // if (empty($_POST["mobileno"])) {
          //   $mobilenoErr = " * mobileno is required";
          //   $mno = false;
          // } else {
          //   if ($mobileno>10) {
          //     $passwordErr = "Invalid mobileno format";
          //     $mno = false;
          //   }else{
          //   $mobileno = ($_POST['mobileno']);
          // }}

          if (empty($_POST["mobileno"])) {
            $mobilenoErr = " * mobileno is required";
          } else {
            $mono = $_POST['mobileno'];
            if(preg_match("/[^a-zA-Z-' ]*$/", $mono)){
            // if ($mobileno>11) {
              $mobileno = ($_POST['mobileno']);
          
            }else{
            $mobilenoErr = "Invalid mobile no format";
            $mno = false;
          }}

          if (empty($_POST["password"])) {
            $pass = "12345678";
            $password = password_hash($pass,PASSWORD_DEFAULT);
         } 
        
        $exists=false;
        $sql = "SELECT * FROM `data` WHERE email = '$_POST[email]'";
        $result = mysqli_query($conn,$sql);
        if($result){
            if(mysqli_num_rows($result) == 0){
              if($fname==true && $lname==true && $mail==true && $mno==true){
                $status= "inactive";
                $sql = "INSERT INTO `data` (`sno`, `profile_image`, `firstname`, `lastname`, `email`, `mobileno`,`password`,`status`) VALUES ('', '$file_name', '$firstname', '$lastname', '$email', '$mobileno','$password', '$status')";
                $result = mysqli_query($conn, $sql);
                if ($result){
                    // $showAlert = true;
                    // header("location: /project/forgetpassword.php");
                                
                    $reset_token = bin2hex(random_bytes(16));
                    date_default_timezone_set('Asia/kolkata');
                    $date=date('y-m-d');

                    $sql = "UPDATE `data` SET `resettoken`='$reset_token',`resettokenexp`='$date' WHERE email='$_POST[email]'";
                    if(mysqli_query($conn,$sql)  && sendMail($_POST['email'],$reset_token)){
                      echo '
                        <script>
                        alert("Resent password link send to email address");
                        </script>
                      ';
                      // header("location: login.php");
                    }
                    else{
                      echo '
                      <script>
                      alert("server dwon try again leter");
                      </script>
                      ';
                    }
                }
                else{
                    echo "error!";
                    $showError = true;
                }
                // header("location: login.php");
                }else
                {
                    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! Invalid Formate please fill all</strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div> ';
                
                }

                
              }
              else{
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! Email Is Already Exits.</strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div> ';

              }
            }
            else{
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! Email Is already Exits.</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    </div> ';
    
            }
        }
    }


    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script> -->
    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/project/style/signup_user.css">
    <title>User_signup</title>

  </head>
<body>
<?php

if($showAlert == true){
  echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your account is now created and you can login
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
        </div> 
                 <div class="form">
                    <form action="signup_user1.php" method="post" enctype="multipart/form-data">
                        <h2>Signup Here</h2>
                        <label>Select Image:</label>
                        <input type="file" name="image"><br>
                        <label>First Name:</label>
                        <input type="text" name="firstname" placeholder="Enter firstname Here"><br><span class="error"><?php echo $firstnameErr;?></span><br>
                        <label>Last Name:</label>
                        <input type="text" name="lastname" placeholder="Enter lastname Here"><br><span class="error"><?php echo $lastnameErr;?></span><br>
                        <label>Email:</label>
                        <input type="text" name="email" placeholder="Enter email Here"><br><span class="error"><?php echo $emailErr;?></span><br>
                        <label>Mobile No:</label>
                        <input type="text" name="mobileno" maxlength="10" placeholder="Enter mobileno Here"><br><span class="error"><?php echo $mobilenoErr;?></span><br>
                        <button class="btnn" name="send-email-link">Signup</button>
                    </form>
               </div>
    </div>
</body>
</html>
