<?php
include "hide.php";
$showAlert = false;
$showError = false;
$msg = false;
$insert = false;
$update = false;
$delete = false;
$showmsg = false;

$fname = true;
$lname = true;
$mail = true;
$mno = true;
$pass = true;
$file_nameErr = $firstnameErr = $lastnameErr = $emailErr = $mobilenoErr = $passwordErr = $cpasswordErr = "";
$firstname = $lastname = $email = $mobileno = $password = $cpassword = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    if(isset($_FILES['image'])){
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        move_uploaded_file($file_tmp,"images/" . $file_name);
    
        if (empty($_POST["firstname"])) {
            $firstnameErr = " * Firstname is required";
          } else {
            $firstname = ($_POST["firstname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
                $firstnameErr = "Only letters and white space allowed";
                $fname = false;
              }
          }
        
          if (empty($_POST["lastname"])) {
            $lastnameErr = " * Lastname is required";

          } else {
            $lastname = ($_POST["lastname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
                $lastnameErr = "Only letters and white space allowed";
                $lname = false;
              }
          }

          if (empty($_POST["email"])) {
            $emailErr = " * email is required";

          } else {
            $email = ($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    $mail = false;
                }
          }
        
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
            $passwordErr = " * password is required";
            $pass = false;

          } 
          else {
            $password = ($_POST["password"]);
                $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
                if (!preg_match($pattern, $password)) {
                  // echo "Invalid Password";
                  $pass = false;
                }
          }

          if (empty($_POST["cpassword"])) {
            $cpasswordErr = " * cpassword is required";
          } else {
            $cpassword = $_POST["cpassword"];
          }

        $exists=false;
        $sql = "SELECT * FROM `data` WHERE email = '$_POST[email]'";
        $result = mysqli_query($conn,$sql);
        if($result){
            if(mysqli_num_rows($result) == 0){
              if($pass==true && $fname==true && $lname==true && $mail==true && $mno==true){
                if(($password == $cpassword) && $exists==false){
                  $status = "Active";
                // $sql = "INSERT INTO `data` (`sno`, `profile_image`, `firstname`, `lastname`, `email`, `mobileno`, `password`, `status`) VALUES ('', '$file_name', '$firstname', '$lastname', '$email', '$mobileno', '$password','')";
                $sql = "INSERT INTO `data`(`sno`, `profile_image`, `firstname`, `lastname`, `email`, `mobileno`, `password`, `status`, `resettoken`, `resettokenexp`) VALUES ('','$file_name','$firstname','$lastname','$email','$mobileno','$password','$status','','')";
                $result = mysqli_query($conn, $sql);
                if ($result){
                    // echo "sucessfull";
                    $showAlert = true;
                }
                else{
                  echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Error! Not proper signup please try again</strong> '. $showError.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
                  </div> ';
                  $mobilenoErr = "Invalid mobile no format";
                }
                // header("location: login.php");
                }
                else{
                     echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! Password does not match</strong> '. $showError.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div> ';
                }
              }
              else{
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! Not proper signup please try again</strong> '. $showError.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div> ';

              }
            }
            else{
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! Email Is already Exits.</strong> '. $showError.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    </div> ';
    
            }
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
    <link rel="stylesheet" href="/project/style/signup.css">
    <title>Signup</title>

  </head>
<body>
<?php
include "alert.php";
?> 
  <div class="main">
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">PHP</h2>
        </div>         
    </div> 
    
    <div class="form">
        <form action="signup1.php" method="post" enctype="multipart/form-data">
            <h2>Signup Here</h2>
            <label>Select image:</label>
            <input type="file" name="image" id=""><br>
            <label>first name:</label>
            <input type="text" name="firstname" placeholder="Enter firstname Here"><br><span class="error"><?php echo $firstnameErr;?></span><br>
            <label>Last name:</label>
            <input type="text" name="lastname" placeholder="Enter lastname Here"><br><span class="error"><?php echo $lastnameErr;?></span><br>
            <label>Email:</label>
            <input type="text" name="email" placeholder="Enter email Here"><br><span class="error"><?php echo $emailErr;?></span><br>
            <label>Mobile No:</label>
            <input type="text" name="mobileno" maxlength="10" placeholder="Enter mobileno Here"><br><span class="error"><?php echo $mobilenoErr;?></span><br>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter Password Here"><br><span class="error"><?php echo $passwordErr;?></span><br>
            <label>Confirm Password:</label>
            <input type="password" name="cpassword" placeholder="Enter Confirm Password Here"><br><span class="error"><?php echo $cpasswordErr;?></span><br>
            <button class="btnn">Signup</button>
            <p class="par">if you are already <a href="login.php">login</a></p>
        </form>
     </div>
  </div>
</body>
</html>
