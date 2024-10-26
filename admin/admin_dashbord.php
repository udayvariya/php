
<?php  
include "page_hide.php";

$insert = false;
$update = false;
$delete = false;
$login  = false;
$showAlert = false;
$showError = false;
$showmsg = false;
$msg = false;

include '_dbconnect.php';

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `query` WHERE `qid` = $sno";
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
  if(!empty(($_POST['date']) && ($_POST['pagename']) && ($_POST['lineno']) && ($_POST['query']))){
  $sql = "UPDATE `query` SET `date` = '$date' , `pagename` = '$pagename' , `lineno` = '$lineno' ,`query` = '$query' ,`comment` = '$comment' WHERE `query`.`qid` = $sno";
  $result = mysqli_query($conn, $sql);
    if($result){
      $update = true;
      }
      else{
      echo "We could not update the record successfully";
      $showError = true;
      }
    }
    else{
      $showmsg = true;
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
  <!-- import sweet alert -->
  <script src="sweetalert2.min.js"></script>
  <link rel="stylesheet" href="sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- <link rel="stylesheet" href="/project/style/admin_dashbord.css"> -->
  <link rel="stylesheet" href="/project/style/admin_dashbord1.css">
  <title>Admin_dashbord</title>
</head>
<body>
<?php
include "alert.php";
?>

<div class="navbar">
  <div class="icon">
    <h3 class="logo">PHP</h3>
  </div>
  <div class="menu">
    <ul>
      <li><a href="admin_home.php">HOME</a></li>
      <li><a href="admin_logout.php">LOGOUT</a></li>
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
              <label>Date</label>
              <input type="date" class="form-control" id="date" name="date">
            </div>
            <div class="form-group">
              <label>Pagename</label>
              <input type="text" class="form-control" id="pagename" name="pagename">
            </div>
            <div class="form-group">
              <label>Lineno</label>
              <input type="text" class="form-control" id="lineno" name="lineno">
            </div>
            <div class="form-group">
              <label>Query</label>
              <textarea id="query" class="form-control" name="query" rows="3"></textarea>
            </div> 
            <div class="form-group">
              <label>Comment</label>
              <textarea id="comment" class="form-control" name="comment" rows="5"></textarea>
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
  <div class="search">
    <label><b>  Start Date : </b></label>
    <input id="startDate" type="date" name = "date1">
    <label><b>  End Date : </b></label>
    <input id="endDate" type="date" name="date2">
    <button id="filterData">Search</button>
  </div>
  <br>  
    <table class="table">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Date</th>
          <th>Firstname</th>
          <th>Pagename</th>
          <th>Lineno</th>
          <th>Query</th>
          <th>Comment</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody  id="myTable"  >
        <?php 
          $recordsPerPage = 5; // Number of records to show per page
          if(isset($_GET['page'])){
          $page  = $_GET['page'];
          }
          else{
            $page = 1;
          }
          $offset = ($page-1) * $recordsPerPage;
                    // 1-1 *5 =0  record no starting to diplay 
                    // 2-1 *5 = 5
        
          $sql = "SELECT `data`.firstname, `query`.* FROM `data` INNER JOIN `query` ON `data`.sno = query.sno ORDER BY `query`.`qid` DESC LIMIT {$offset},{$recordsPerPage} "; // {0}{3}  , 
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr data-date = ". $row['date'] .">
            <th scope='row'>". $sno . "</th>
            <td>". $row['date'] . "</td>
            <td>". $row['firstname'] . "</td>
            <td>". $row['pagename'] . "</td>
            <td>". $row['lineno'] . "</td>
            <td>". $row['query'] . "</td>
            <td>". $row['comment'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary' id=".$row['qid'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['qid'].">Delete</button>  </td>
          </tr>";
        }
          ?>
      </tbody>
    </table>
    <?php
    $sql1 = "SELECT * FROM query";
    $result = mysqli_query($conn,$sql1);
    
    if(mysqli_num_rows($result) > 0){
      $total_record = mysqli_num_rows($result);
      $totalPages = ceil($total_record / $recordsPerPage);
      echo '<ul class="pagination">';
      if($page >1){
        echo '<a href="?page='.($page-1).'"><li>Previous</li></a>';
      }
      if($i = $page){
        $active = "active";
      }
      else{
        $active = "";
      }
      for ($i=1; $i <= 3; $i++) { 
        
        echo '<a href="?page='.$i.'" ><li class = ".$active.">'.$i.'</li></a>';
        
      } 
      if($totalPages > $page){
        if($page <= 3)
      echo '<a href="?page='.($page+1).'"><li>Next</li></a>';
    else{
      echo '<a href="?page='.($page+1).'"><li>Next</li></a>';
    }
      }  
      echo '</ul>';
    } 
    ?>
</div>
<hr>
    
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

<script>
  edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        date1 = tr.getElementsByTagName("td")[0].innerText;
        username1 = tr.getElementsByTagName("td")[1].innerText
        pagename1 = tr.getElementsByTagName("td")[2].innerText;
        lineno1 = tr.getElementsByTagName("td")[3].innerText;
        query1 = tr.getElementsByTagName("td")[4].innerText;
        comment1 = tr.getElementsByTagName("td")[5].innerText;
        console.log(date1,username1,pagename1,lineno1,query1,comment1);
        date.value = date1;
        pagename.value = pagename1;
        lineno.value = lineno1;
        query.value = query1;
        comment.value = comment1;
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
        Swal.fire({
            title: "Do you want to Delete?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Delete",
            denyButtonText: `can't Delete `
          }).then((result) => {
            if (result.isConfirmed) {
              window.location = `admin_dashbord.php?delete=${sno}`;
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
