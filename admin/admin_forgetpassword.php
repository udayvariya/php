<?php
    include "_dbconnect.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email,$reset_token){
        echo $email;
        echo $reset_token;
        echo "<br>";
        require('/project/phpmaier/PHPMailer.php');
        require('/project/phpmaier/SMTP.php');
        require('/project/phpmaier/Exception.php');

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'udayvariya302@gmail.com';                //SMTP username
            $mail->Password   = 'Uday@2757';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('udayvariya302@gmail.com', 'UDAY PASS');
            $mail->addAddress($email);     //Add a recipient
        
            
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Password Reset Link from uday';
            $mail->Body    = "we got request the reset password link <br>
            click the link below : <br>
            <a href='http://localhost/php/updatepassword.php?email=$email&reset_token=$reset_token'>Reset Password</a>";
        
            $mail->send();
            return true;
        }
        catch (Exception $e) {
            // return false;
            echo "not completed";
            echo "<br>";
        }

    }
    if(isset($_POST['send-email-link'])){
    $sql = "SELECT * FROM `admin_data` WHERE email = '$_POST[email]'";
    $result = mysqli_query($conn,$sql);
    if($result){
        if(mysqli_num_rows($result) == 1){
            
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/kolkata');
            $date=date('y-m-d');
            $sql = "UPDATE `admin_data` SET `resettoken`='$reset_token',`resettokenexp`='$date' WHERE email='$_POST[email]'";
            if(mysqli_query($conn,$sql) && sendMail($_POST['email'],$reset_token)){
                echo "complete to send mail";
            
        
            }
            else{
                echo "server dwon try again leter";
                
            }

        }
        else{
            echo '
            <script>
            alert("email not found");
            </script>
        ';
        }

    }
    else{
        echo '  
            <script>
            alert("can not send email");
            </script>
        ';
    }
    }
?>
