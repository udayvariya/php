
<?php  

session_start();
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("location: admin_login.php");

        }
$insert = false;
$update = false;
$delete = false;
$login  = false;
$showAlert = false;
$showError = false;

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
    $comment = $_POST["comment"];
  $sql = "UPDATE `query` SET `date` = '$date' , `pagename` = '$pagename' , `lineno` = '$lineno' ,`query` = '$query' ,`comment` = '$comment' WHERE `query`.`sno` = $sno";
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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="/project/style/admin_dashbord.css">
  <title>ADMIN</title>
  
</head>

<body>
 
<div class="navbar">
            <div class="icon">
                <h3 class="logo">PHP</h2>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="admin_home.php">HOME</a></li>
                    <li><a href="admin_logout.php">logout</a></li>
                    <li><a href="admin_profile.php">Profile Update</a></li>
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
        <form action="/project/admin/admin_dashbord.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label>date</label>
              <input type="date" class="form-control" id="date" name="date">
            </div>
            <div class="form-group">
              <label>pagename</label>
              <input type="text" class="form-control" id="pagename" name="pagename">
            </div>
            <div class="form-group">
              <label>lineno</label>
              <input type="text" class="form-control" id="lineno" name="lineno">
            </div>
            <div class="form-group">
              <label>query</label>
              <textarea id="query" class="form-control" name="query" rows="3"></textarea>
            </div> 
            <div class="form-group">
              <label>comment</label>
              <textarea id="comment" class="form-control" name="comment" rows="5"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <!-- <button type="button" class="btn btn-secondary">Close</button> -->
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
// include "alert.php";

if($login){
  echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> You are logged in
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span>
  </button>
  </div> ';
  
}
if($showError){
echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> '. $showError.'
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span>
      </button>
  </div> ';
}
if($showAlert){
  echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your account is now created and you can login
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
      </button>
      </div> ';
}
?>
  <div class="container my-4">
  <div class="search">
  <label><b>  Search Date : </b></label>
    <input id="myInput" type="text" placeholder="Search..">
  </div>
<br>  
    <table class="table">
      <thead>
        <tr>
          <th>S.No</th>
          <th>date</th>
          <th>pagename</th>
          <th>lineno</th>
          <th>query</th>
          <th>comment</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody  id="myTable">
        <?php 
          $sql = "SELECT * FROM `query`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
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
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
  
  
  <script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        date1 = tr.getElementsByTagName("td")[0].innerText;
        pagename1 = tr.getElementsByTagName("td")[1].innerText;
        lineno1 = tr.getElementsByTagName("td")[2].innerText;
        query1 = tr.getElementsByTagName("td")[3].innerText;
        comment1 = tr.getElementsByTagName("td")[4].innerText;
        console.log(date1,pagename1,lineno1,query1,comment1);
        date.value = date1;
        pagename.value = pagename1;
        lineno.value = lineno1;
        query.value = query1;
        comment = comment1;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `contect.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>
