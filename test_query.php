<?php

include '_dbconnect.php';

if (isset($_POST['click_edit_btn'])) {
    $qid = $_POST['qid'];
    // echo $qid;
    $array = [];

    $sql = "SELECT * FROM `query` WHERE `qid` = '$qid' ";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            array_push($array,$row);
            header('Content-Type: application/json');
            echo json_encode($array);
        }
    }
  }
?>