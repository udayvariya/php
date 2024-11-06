<?php
// session_name('session7');
session_start();
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("location: login.php");
        // header("location:javascript://history.go(-1)");

        }
include "_dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (isset( $_POST['sno'])){
      $sno = $_POST["sno"];   
      $profile_image = $_POST["profile_image"];
      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $email = $_POST["email"];
      $mobileno = $_POST["mobileno"];
    $sql = "UPDATE `data` SET `profile_image` = '$profile_image' ,`firstname` = '$firstname', `lastname` = '$lastname', `email` = '$email', `mobileno` ='$mobileno' WHERE `data`.`sno` = $sno";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
  <title>User_profile</title>
    <style>
        i{
            height: 100px;
            width: 100px;
            align-items: center;
            justify-content: center;
            padding : 50px 50px;
            text-decoration: none;
            color: black;
        
        }
        h2{
            margin-left: 500px;
        }
        body{
          background-color: #e28e4a;
        }
    </style>
</head>
<body>
<div class="modal fade" id="editmodel" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit student profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="profile.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="sno">
            <div class="form-group">
              <label>Profile_image</label>
              <input type="file" class="form-control"  name="profile_image" id="profile_image">
            </div>
            <div class="form-group">
              <label>Firstname</label>
              <input type="text" class="form-control"  name="firstname" id="firstname">
            </div>
            <div class="form-group">
              <label>Lastname</label>
              <input type="text" class="form-control"  name="lastname" id="lastname">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" id="email">
            </div> 
            <div class="form-group">
              <label>Mobileno</label>
              <input type="text" class="form-control"  name="mobileno" id="mobileno">
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

    <a href="dashbord.php">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <h2> Your Details</h2>
    <div class="container my-2">


    <table class="table" id="myTable">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Profile_image</th>
          <th>First name</th>
          <th>Lastname</th>
          <th>Email</th>
          <th>Moblie no</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 

          $sql = "SELECT * FROM `data` where email = '$_SESSION[email]'";
          $result = mysqli_query($conn, $sql) or die("Query Failed.");
          while($row = mysqli_fetch_assoc($result)){
            echo "
            
            <tr>
            <td class='hidden'>" . $row['sno'] . "</td>
            <td>".$row['sno']."</td>
            <td>
              <img height='125px' width='150px' src='/project/images/" . ($row['profile_image']) . "' alt='Image' class='rounded' style='max-width: 100%;  cursor: pointer;'>
            </td>
            <td>".$row['firstname']."</td>
            <td>".$row['lastname']."</td>
            <td>".$row['email']."</td>
            <td>".$row['mobileno']."</td>
            <td> <button class='edit btn btn-md btn-primary' id=".$row['sno'].">Edit</button>
            </tr>
            <br><br>";
          }
          ?>
      </tbody>
    </table>
    <p><a href="/project/forget.php">Forget Password</a></p>
  </div>
<script>
$(document).ready(function() {
      $('.edit').click(function() {
        var sno = $(this).closest('tr').find('.hidden').text();
        console.log(sno);
        $.ajax({
          method: 'POST',
          url: 'test_data.php',
          data: {
            'click_edit_btn': true,
            'sno': sno,
          },
          success: function(response) {
            // console.log(response);
            $.each(response, function(Key, value) {
              // console.log(value['sno']);
              $('#sno').val(value['sno']);
              $('#profile_image').val(value['profile_image']);
              $('#firstname').val(value['firstname']);
              $('#lastname').val(value['lastname']);
              $('#email').val(value['email']);
              $('#mobileno').val(value['mobileno']);

            });
            $('#editmodel').modal('show');
          }
        });
      });
    });

</script>
</body>
</html> 