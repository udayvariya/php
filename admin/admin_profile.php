<?php

include "page_hide.php";
include "_dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset( $_POST['snoEdit'])){
        $sno = $_POST["snoEdit"];   
        $profile_image = $_POST["profile_image"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $mobileno = $_POST["mobileno"];
      $sql = "UPDATE `admin_data` SET `profile_image` = '$profile_image' ,`firstname` = '$firstname', `lastname` = '$lastname', `email` = '$email', `mobileno` ='$mobileno' WHERE `admin_data`.`sno` = $sno";
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
    <title>Admin_profile</title>
    <link rel="stylesheet" href="/project/style/admin_profile.css">
</head>
<body>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit student profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="admin_profile.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label>Profile_image</label>
              <input type="file" class="form-control" id="profile_image" name="profile_image">
            </div>
            <div class="form-group">
              <label>Firstname</label>
              <input type="text" class="form-control" id="firstname" name="firstname">
            </div>
            <div class="form-group">
              <label>Lastname</label>
              <input type="text" class="form-control" id="lastname" name="lastname">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" id="email" name="email">
            </div> 
            <div class="form-group">
              <label>Mobileno</label>
              <input type="text" class="form-control" id="mobileno" name="mobileno">
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

  <a href="admin_home.php">
    <i class="fa-solid fa-chevron-left"></i>
  </a>
  <h2> Your Details</h2>
    
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th>No</th>
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
          $sql = "SELECT * FROM `admin_data` where email = '$_SESSION[email1]'";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
            echo "

            <tr>
            <th>1</th>
            <td>
              <img height='130px' width='160px' src='/project/images/" . htmlspecialchars($row['profile_image']) . "' alt='Image' class='rounded' style='max-width: 100%; cursor: pointer;'>
            </td>
            <td>".$row['firstname']."</td>
            <td>".$row['lastname']."</td>
            <td>".$row['email']."</td>
            <td>".$row['mobileno']."</td>
            <td> <button class='edit btn btn-md btn-primary' id=".$row['A_id'].">Edit</button>
            </tr>
            <br><br>";
          } 
        ?>
      </tbody>
    </table>
    <p class="liw2"><a href="/project/admin/admin_forget.php">Forget Password</a></p>
</div>
  
<script>
  edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit");
        tr = e.target.parentNode.parentNode;
          // sno1 = tr.getElementsbyTagname("td")[0].innerText;
          profile_image1 = tr.getElementsByTagName("td")[0].innerText;
          firstname1 = tr.getElementsByTagName("td")[1].innerText;
          lastname1 = tr.getElementsByTagName("td")[2].innerText;
          email1 = tr.getElementsByTagName("td")[3].innerText;
          mobileno1 = tr.getElementsByTagName("td")[4].innerText;
          console.log(profile_image1,firstname1,lastname1,email1,mobileno1);
          profile_image.value = profile_image1;
          firstname.value = firstname1;
          lastname.value = lastname1;
          email.value = email1;
          mobileno.value = mobileno1
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
    });
  });    
</script>
</body>
</html>