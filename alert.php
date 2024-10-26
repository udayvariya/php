<?php

if ($msg) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error! logout First </strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    </div> ';
}

if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span>
    </button>
    </div>";
}

if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span>
    </button>
    </div>";
}

if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Data has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span>
    </button>
    </div>";
}
  
if ($showmsg) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error! Please Fill All Filed </strong> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    </div> ';
}

if($showError){
    echo ' <div class="alert alert-danger" role="alert">
    <strong>incrrect password!</strong>   
    </div>';
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
