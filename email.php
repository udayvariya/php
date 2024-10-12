<?php
$to = "harshadvariya302@gmail.com";
$subject = "UDAY TEST";
$message = "this is uday vaiya demo msg";
$from = "udayvariya302@gmail.com";
$headers = "From : $from";

if(mail($to ,$subject ,$message ,$headers)){
    echo "mail send";
}
else{
    echo "mail not send";
}

?>
