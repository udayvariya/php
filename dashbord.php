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
  if ($result) {
    $delete = true;
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
              <input type="date" class="form-control" id="date" name="date"><span class="error"><?php echo $dateErr; ?></span>
            </div>
            <div class="form-group">
              <label>Pagename :</label>
              <input type="text" class="form-control" id="pagename" name="pagename"><span class="error"><?php echo $pagenameErr; ?></span>
            </div>
            <div class="form-group">
              <label>Lineno :</label>
              <input type="text" class="form-control" id="lineno" name="lineno"><span class="error"><?php echo $linenoErr; ?></span>
            </div>
            <div class="form-group">
              <label>Query :</label>
              <textarea id="query" class="form-control" id="query" name="query" rows="3"></textarea><span class="error"><?php echo $queryErr; ?></span>
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
          <th>Q.No</th>
          <th>Date</th>
          <th>Pagename</th>
          <th>Lineno</th>
          <th>Query</th>
          <th>Admin Comment</th>
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
          <td class='hidden'>" . $row['qid'] . "</td>
            <th>" . $sno . "</th>
            <td>" . $row['date'] . "</td>
            <td>" . $row['pagename'] . "</td>
            <td>" . $row['lineno'] . "</td>
            <td>" . $row['query'] . "</td>
            <td>" . $row['comment'] . "</td>
            <td>      
              <button class='btn btn-sm btn-primary edit' id='.$row[qid].'>Edit</button>    
              <button class='delete btn btn-sm btn-primary delete'>Delete</button> 
            </td>
            </tr>";
        }

        ?>
      </tbody>
    </table>
  </div>
  <hr>

  <script>
    // Search date
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


    // edit model
    $(document).ready(function() {
      $('.edit').click(function() {
        var qid = $(this).closest('tr').find('.hidden').text();
        // var qid = $(this).val();
        console.log(qid);
        $.ajax({
          method: 'POST',
          url: 'test_query.php',
          data: {
            'click_edit_btn': true,
            'qid': qid,
          },
          success: function(response) {
            console.log(response);
            $.each(response, function(Key, value) {
              // console.log(value['qid']);
              $('#qid').val(value['qid']);
              $('#date').val(value['date']);
              $('#pagename').val(value['pagename']);
              $('#lineno').val(value['lineno']);
              $('#query').val(value['query']);
   
            });
            $('#editmodel').modal('show');
          }
        });
      });
    });


    // delete model 
    $(document).ready(function() {
      $('.delete').click(function() {
        var sno = $(this).closest('tr').find('.hidden').text();
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