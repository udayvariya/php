<?php

include '_dbconnect.php';

if (isset($_POST['click_edit_btn'])) {
    $sno = $_POST['sno'];
    // echo $qid;
    $arrayresult = [];

    $sql = "SELECT * FROM `data` WHERE `sno` = '$sno' ";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            array_push($arrayresult,$row);
            header('Content-Type: application/json');
            echo json_encode($arrayresult);
        }
    }
  }
  

?>

