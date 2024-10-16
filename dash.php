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

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `query` WHERE `qid` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  // $qid = $_GET[""];
  $sno = $_POST['qid'] or die("Query Failed.");
  $date = $_POST["date"];
  $pagename = $_POST["pagename"];
  $lineno = $_POST["lineno"];
  $query = $_POST["query"];
if(!empty(($_POST['date']) && ($_POST['pagename']) && ($_POST['lineno']) && ($_POST['query']))){
$sql = "UPDATE `query` SET `date` = '$date' , `pagename` = '$pagename' , `lineno` = '$lineno' ,`query` = '$query' WHERE `query`.`qid` = '$sno'";
$result = mysqli_query($conn, $sql) or die("Query Failed.");
if($result){   

  $update = true;
}
else{
  echo "We could not update the record successfully";
}

}
else{
$showmsg = true;
}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $sql = "SELECT * FROM `data` where email = '$_SESSION[email]'";
  $result = mysqli_query($conn, $sql) or die("Query Failed.");
  while($row = mysqli_fetch_assoc($result)){
    $sno = $row['sno'];
    $username = $row['firstname'];
  }
    $date = $_POST["date"];
    // $uid = $_SESSION['sno'];
    $pagename = $_POST["pagename"];
    $lineno = $_POST["lineno"];
    $query = $_POST["query"];
    // $username = $_SESSION["username"]; 
  if(!empty(($_POST['date']) && ($_POST['pagename']) && ($_POST['lineno']) && ($_POST['query']))){
  $sql = "INSERT INTO `query` (`qid`,`sno`, `date`,`pagename`, `lineno`, `query`) VALUES ('','$sno','$date', '$pagename', '$lineno', '$query')";
  $result = mysqli_query($conn, $sql);
    if($result){ 
        $insert = true;
      }
      else{
        echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
      } 
  }
  else{
    $showmsg = true;
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
 
  if($msg){
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error! logout First </strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    </div> ';
  }
  
if($insert){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been inserted successfully
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span>
  </button>
</div>";
}
if($delete){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been deleted successfully
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span>
  </button>
</div>";
}
if($update){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been updated successfully
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span>
  </button>
</div>";
}
// if($showmsg){
//   echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
//     <strong>Error! Please Fill All Filed </strong> 
//     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//     <span aria-hidden="true">×</span>
//         </button>
//     </div> ';
//   }

      // if(isset($_GET['edit'])){
        // $up_qid = $_GET['GET'];
        // $up_date = $_GET['DATE'];
        // $up_pagename = $_GET['PAGENAME'];
        // $up_lineno = $_GET['LINENO'];
        // $up_query = $_GET['QUERY'];

      // }
?>

<div class="navbar">
            <div class="icon">
                <h3 class="logo">PHP</h2>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="/project/logout.php">LOGOUT</a></li>
                    <li><a href="profile.php">PROFILE</a></li>
                </ul>
            </div>

           
        </div>
  <!-- Edit Modal -->
  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <?php 
      if($showmsg){
          echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! Please Fill All Filed </strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
                </button>
            </div> ';
          }
          
        $up_qid = $_POST['qid'];
        $up_date = $_POST['date'];
        $up_pagename = $_POST['pagename'];
        $up_lineno = $_POST['lineno'];
        $up_query = $_POST['query'];
        ?>
        <form action="dashbord.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="qid" value="<?php echo"$up_qid";?>">
            <div class="form-group">
              <label>Date :</label>
              <input type="date" class="form-control" id="date" name="date" value="<?php echo"$up_date";?>">
            </div>
            <div class="form-group">
              <label>Pagename :</label>
              <input type="text" class="form-control" id="pagename" name="pagename" value="<?php echo"$up_pagename";?>">
            </div>
            <div class="form-group">
              <label>Lineno :</label>
              <input type="text" class="form-control" id="lineno" name="lineno" value="<?php echo"$up_lineno";?>"  >
            </div>
            <div class="form-group">
              <label>Query :</label>
              <textarea id="query" class="form-control" name="query" rows="3" value="<?php echo"$up_query";?>"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
          
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container my-4">
    <h2>Add a Note to Query</h2>
    <form action="dashbord.php" method="POST">
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
      <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
  </div>
  <div class="search">
  <label><b>  Start Date : </b></label>
    <input id="startDate" type="date" name = "date1">
  <label><b>  End Date : </b></label>
    <input id="endDate" type="date" name="date2">
    <button id="filterData" >Search</button>
    </div>
    
  <div class="container my-4">

    <table class="table" >
      <thead>
        <tr>
          <th>S.No</th>
          <th>Date</th>
          <th>Pagename</th>
          <th>Lineno</th>
          <th>Query</th>
          <th>Admin comment</th>
          <th>Actions</th>
        </tr>
      </thead>  
      <tbody id="myTable">
        <?php 
        
          $sql = "SELECT * FROM `data` where email = '$_SESSION[email]'";
          $result = mysqli_query($conn, $sql) or die("Query Failed.");
          while($row = mysqli_fetch_assoc($result)){
          $sno = $row['sno'];
            }
          $sql = "SELECT * FROM `query` WHERE `sno` = '$sno' ORDER BY `query`.`sno` desc";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr data-date = ". $row['date'] .">
            <th scope='row'>". $sno . "</th>
            <td>". $row['date'] . "</td>
            <td>". $row['pagename'] . "</td>
            <td>". $row['lineno'] . "</td>
            <td>". $row['query'] . "</td>
            <td>". $row['comment'] . "</td>

                  
            <td><a href = '#edit?QID=".$row['qid']."&DATE=".$row['date']."&PAGENAME=".$row['pagename']."&LINENO=".$row['lineno']."&QUERY=".$row['query']."'><button class='edit btn btn-sm btn-primary'>edit</button></a>
            <button class='delete btn btn-sm btn-primary' id=d".$row['qid'].">Delete</button>  </td>
          </tr>";
        } 
        // <button class='edit btn btn-sm btn-primary' id=".$row['qid'].">Edit</button>
            // <td> <a href = '#editModal?qid=".$row['qid']."'><button class='edit btn btn-sm btn-primary' qid=".$row['qid'].">Edit</button> </a>

          ?>
      </tbody>
    </table>
  </div>
  <hr>

<!-- Search date -->
<script>
  $(document).ready(function() {
    $('#filterData').click(function() {
        var startText = $('#startDate').val();
        var endText = $('#endDate').val();
        $('#myTable tr').each(function() {
            var itemDateText = $(this).data('date');
            if (itemDateText >= startText && itemDateText <= endText) {
              //  10-10-2024 >= 01-09-2024  &&   29-09-2024 <= 01-10-2024 (true)
                $(this).show();
            } else {
                $(this).hide(); 
            }
        });
    });
  });

</script>
<!-- edit Query -->
<script>
edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element) => {
element.addEventListener("click", (e) => {
  qid = e.target.id.substr(1);
  $('#edit').modal('toggle');
      })
    })

// delete model 
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);
          Swal.fire({
            title: "Do you want to Delete?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Delete",
            denyButtonText: `can't Delete `
          }).then((result) => {
            if (result.isConfirmed) {
              window.location = `dashbord.php?delete=${sno}`;
              Swal.fire("Delete!", "", "success");
        } else if (result.isDenied) {
        Swal.fire("Can Not Deleted!", "", "info");
      }
      });
      })
    })
  </script>
</body>

</html>
