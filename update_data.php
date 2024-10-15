<?php  
$msg = false;
session_start();
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        // header("location:javascript://history.go(-1)");   
        header("location: login.php");
      }    

$insert = false;
$update = false;
$delete = false;
$showmsg = false;

include '_dbconnect.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
// if (isset( $_POST['snoEdit'])){    
    $id = $_POST['id'];
    $date = $_POST["date"];
    $pagename = $_POST["pagename"];
    $lineno = $_POST["lineno"];
    $query = $_POST["query"];
  if(!empty(($_POST['date']) && ($_POST['pagename']) && ($_POST['lineno']) && ($_POST['query']))){
  $sql = "UPDATE `query` SET `date` = '$date' , `pagename` = '$pagename' , `lineno` = '$lineno' ,`query` = '$query' WHERE `qid` = '$id'";
    // $sql = "UPDATE `query` SET `date`='$date',`pagename`='$pagename',`lineno`='',`query`='[value-6]',`comment`='[value-7]' WHERE 1";
$result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
  }
  else{
    echo "We could not update the record successfully";
  }
  }

}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="sweetalert2.min.js"></script>
  <link rel="stylesheet" href="sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.0/sweetalert2.min.js" integrity="sha512-OlF0YFB8FRtvtNaGojDXbPT7LgcsSB3hj0IZKaVjzFix+BReDmTWhntaXBup8qwwoHrTHvwTxhLeoUqrYY9SEw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <link rel="stylesheet" href="/project/style/dashbord.css">
  <title>User_dashbord</title>
  
</head>

<body>
 <?php
 
if($update){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been updated successfully
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span>
  </button>
</div>";
}
?>
  <div class="container my-4">
    <h2>update to Query</h2>
    <form action="update_data.php" method="POST">
        <input type="hidden" name="id">
      <div class="form-group">
        <label>Date :</label>
        <input type="date" class="form-control" id="date" name="date">
      </div>
      <div class="form-group">
        <label>Pagename :</label>
        <input type="text" class="form-control" name="pagename">
      </div>
      <div class="form-group">
        <label>Lineno :</label>
        <input type="text" class="form-control" name="lineno">
      </div>
      <div class="form-group">
        <label>Query :</label>
        <textarea class="form-control" name="query" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">update</button>
      </form>
  </div>
  
</body>

</html>
