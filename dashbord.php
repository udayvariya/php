<?php  
$msg = false;

session_start();
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("location:javascript://history.go(-1)");   
      }    
$insert = false;
$update = false;
$delete = false;

include '_dbconnect.php';

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `query` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset( $_POST['snoEdit'])){
    $sno = $_POST["snoEdit"];   
    $date = $_POST["date"];
    $pagename = $_POST["pagename"];
    $lineno = $_POST["lineno"];
    $query = $_POST["query"];
  $sql = "UPDATE `query` SET `date` = '$date' , `pagename` = '$pagename' , `lineno` = '$lineno' ,`query` = '$query' WHERE `query`.`sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
  }
else{
    echo "We could not update the record successfully";
}
}
else{
    $date = $_POST["date"];
    $pagename = $_POST["pagename"];
    $lineno = $_POST["lineno"];
    $query = $_POST["query"];

  $sql = "INSERT INTO `query` (`sno`, `date`, `pagename`, `lineno`, `query`) VALUES ('', '$date', '$pagename', '$lineno', '$query')";
  $result = mysqli_query($conn, $sql);

   
  if($result){ 
      $insert = true;
  }
  else{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
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
  <title>USER</title>
  
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
?>

<div class="navbar">
            <div class="icon">
                <h3 class="logo">PHP</h2>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="/project/logout.php">logout</a></li>
                    <li><a href="profile.php">Profile</a></li>
                </ul>
            </div>

           
        </div>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="dashbord.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label>Date :</label>
              <input type="date" class="form-control" id="date" name="date">
            </div>
            <div class="form-group">
              <label>Pagename :</label>
              <input type="text" class="form-control" id="pagename" name="pagename">
            </div>
            <div class="form-group">
              <label>Lineno :</label>
              <input type="text" class="form-control" id="lineno" name="lineno">
            </div>
            <div class="form-group">
              <label>Query :</label>
              <textarea id="query" class="form-control" name="query" rows="3"></textarea>
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
          <th>date</th>
          <th>pagename</th>
          <th>lineno</th>
          <th>query</th>
          <th> admin comment</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="myTable">
        <?php 
          $sql = "SELECT * FROM `query`";
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

            <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button>  </td>
          </tr>";
        } 
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
// console.log(edits);
Array.from(edits).forEach((element) => {
element.addEventListener("click", (e) => {
  // console.log("edit ");
  tr = e.target.parentNode.parentNode;
  date1 = tr.getElementsByTagName("td")[0].innerText;
  pagename1 = tr.getElementsByTagName("td")[1].innerText;
  lineno1 = tr.getElementsByTagName("td")[2].innerText;
  query1 = tr.getElementsByTagName("td")[3].innerText;
  console.log(date1,pagename1,lineno1,query1);
  date.value = date1;
  pagename.value = pagename1;
  lineno.value = lineno1;
  query.value = query1;
  snoEdit.value = e.target.id;
  console.log(e.target.id)
  $('#editModal').modal('toggle');
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
