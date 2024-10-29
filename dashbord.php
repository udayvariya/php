<?php
$msg = false;
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
  // header("location:javascript://history.go(-1)");   
  header("location: login.php");
}


$insert = false;
$update = false;
$delete = false;
$showmsg = false;
$msg = false;
$showAlert = false;
$showError = false;

include '_dbconnect.php';

$dateErr = $pagenameErr = $linenoErr = $queryErr = $dateErr1 = $pagenameErr1 = $linenoErr1 = $queryErr1 = "";

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `query` WHERE `qid` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $delete = true;
  }
}

if(isset($_POST['click_edit_btn'])){
  $qid = $_POST['qid'];
  $arrayreult = [];

  $fetch_query = "SELECT * FROM `query` WHERE qid = '$qid'";
  $fetch_query_run = mysqli_query($conn,$fetch_query);

  if(mysqli_num_rows($fetch_query_run) > 0){
    while($row = mysqli_fetch_array($fetch_query_run)){
        array_push($arrayreult,$row);
        header('content-type: application/json');
        echo json_encode($arrayreult);

    }
  }
}

if (isset($_REQUEST["edit"])) {
  $sno = $_POST['qid'];
  if (empty($_POST["date"])) {
    $dateErr = " * Date is required";
  } else {
    $date = ($_POST["date"]);
  }

  if (empty($_POST["pagename"])) {
    $pagenameErr = " * Pagename is required";
  } else {
    $pagename = ($_POST["pagename"]);
  }

  if (empty($_POST["lineno"])) {
    $linenoErr = " * Lineno is required";
  } else {
    $lineno = ($_POST["lineno"]);
  }

  if (empty($_POST["query"])) {
    $queryErr = " * Query is required";
  } else {
    $query = ($_POST["query"]);
  }

  if (!empty(($_POST['date']) && ($_POST['pagename']) && ($_POST['lineno']) && ($_POST['query']))) {
    $sql = "UPDATE `query` SET `date` = '$date' , `pagename` = '$pagename' , `lineno` = '$lineno' ,`query` = '$query' WHERE `query`.`qid` = '$sno'";
    $result = mysqli_query($conn, $sql) or die("Query Failed.");
    if ($result) {
      $update = true;
    } else {
      echo "We could not update the record successfully";
    }
  } else {
    $showmsg = true;
  }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $sql = "SELECT * FROM `data` where email = '$_SESSION[email]'";
  $result = mysqli_query($conn, $sql) or die("Query Failed.");
  while ($row = mysqli_fetch_assoc($result)) {
    $sno = $row['sno'];
    $username = $row['firstname'];
  }
  if (empty($_POST["date"])) {
    $dateErr1 = " * Date is required";
  } else {
    $date = ($_POST["date"]);
  }

  if (empty($_POST["pagename"])) {
    $pagenameErr1 = " * Pagename is required";
  } else {
    $pagename = ($_POST["pagename"]);
  }

  if (empty($_POST["lineno"])) {
    $linenoErr1 = " * Lineno is required";
  } else {
    $lineno = ($_POST["lineno"]);
  }

  if (empty($_POST["query"])) {
    $queryErr1 = " * Query is required";
  } else {
    $query = ($_POST["query"]);
  }
  if (!empty(($_POST['date']) && ($_POST['pagename']) && ($_POST['lineno']) && ($_POST['query']))) {
    $sql = "INSERT INTO `query` (`qid`,`sno`, `date`,`pagename`, `lineno`, `query`) VALUES ('','$sno','$date', '$pagename', '$lineno', '$query')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $insert = true;
    } else {
      echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
    }
  } else {
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
include "alert.php";
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
<div class="modal fade" id="editmodel" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
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
            <input type="hidden" name="qid" id="qid">
            <div class="form-group">
              <label>Date :</label>
              <input type="date" class="form-control" id = "date" name="date" ><span class="error"><?php echo $dateErr; ?></span><br>
            </div>
            <div class="form-group">
              <label>Pagename :</label>
              <input type="text" class="form-control" id = "pagename" name="pagename" ><span class="error"><?php echo $pagenameErr; ?></span><br>
            </div>
            <div class="form-group">
              <label>Lineno :</label>
              <input type="text" class="form-control"  id = "lineno" name="lineno" ><span class="error"><?php echo $linenoErr; ?></span><br>
            </div>
            <div class="form-group">
              <label>Query :</label>
              <textarea id="query" class="form-control" id = "query" name="query" rows="3" ></textarea><span class="error"><?php echo $queryErr; ?></span><br>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
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
      <input type="date" class="form-control" name="date"><span class="error"><?php echo $dateErr1; ?></span> 
    </div>
    <div class="form-group">
        <label>Pagename :</label>
        <input type="text" class="form-control" name="pagename"><span class="error"><?php echo $pagenameErr1; ?></span>
    </div>
    <div class="form-group">
        <label>Lineno :</label>
        <input type="text" class="form-control" name="lineno"><span class="error"><?php echo $linenoErr1; ?></span>
    </div>
    <div class="form-group">
        <label>Query :</label>
        <textarea class="form-control" name="query" rows="3"></textarea><span class="error"><?php echo $queryErr1; ?></span>
    </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
  </form>
</div>


<div class="search">
  <label><b> Start Date : </b></label>
  <input id="startDate" type="date" name="date1">
  <label><b> End Date : </b></label>
  <input id="endDate" type="date" name="date2">
  <button id="filterData">Search</button>
</div>


<div class="container my-4">
  <table class="table">
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
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $row['sno'];
        }
        $sql = "SELECT * FROM `query` WHERE `sno` = '$sno' ORDER BY `query`.`sno` desc";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $sno + 1;
          echo "<tr data-date = " . $row['date'] . ">
            <td class='qid'>" . $row['qid'] . "</td>
            <td class='date'>" . $row['date'] . "</td>
            <td class='pagename'>" . $row['pagename'] . "</td>
            <td class='lineno'>" . $row['lineno'] . "</td>
            <td class='query'>" . $row['query'] . "</td>
            <td>" . $row['comment'] . "</td>
            <td>      
            <button class='btn btn-sm btn-primary edit'>Edit</button>
            
            <button class='delete btn btn-sm btn-primary delete'>Delete</button>  </td>
            </tr>";
          }
          // <a href='dashbord.php?QID=".$row['qid']."&DATE=".$row['date']."&PAGENAME=".$row['pagename']."&LINENO=".$row['lineno']."&QUERY=".$row['query']."'><button class='edit btn btn-sm btn-primary' id='.$row[qid].'>Edit</button></a>

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
<!-- $(document).ready(function() {
  $(".edit").click(function() {
    $("#editmodel").modal('show');
    sno = e.target.id.substr(1);
    window.location = `dashbord.php?qid=${sno}`;
    });
    }); -->
    
    <!-- deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
              sno = e.target.id.substr(1); -->

<script>

  $(document).ready(function() {
      $('.edit').click(function() {
        
          var qid = $(this).closest('tr').find('.qid').text();
          var date = $(this).closest('tr').find('.date').text();
          var pagename = $(this).closest('tr').find('.pagename').text();
          var lineno = $(this).closest('tr').find('.lineno').text();
          var query = $(this).closest('tr').find('.query').text();

          console.log(qid,date,pagename,lineno,query);
      
          $('#editmodel').modal('show');
            
            $('#qid').val(qid);
            $('#date').val(date);
            $('#pagename').val(pagename);
            $('#lineno').val(lineno);
            $('#query').val(query);

      });
  });

  // delete model 
  $(document).ready(function() {
      $('.delete').click(function() {
        var sno = $(this).closest('tr').find('.qid').text();
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