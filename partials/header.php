<?php 
session_start();
echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="/Forum">AKJ Panel</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categories
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
        
            $sql= "SELECT category_name , category_id FROM `categories` LIMIT 3";
            $result= mysqli_query($conn , $sql);
            while($row=mysqli_fetch_assoc($result)){
              echo '<a class="dropdown-item" href= "threadlist.php?catid='. $row['category_id'] .'"> '. $row['category_name'] .' </a> ';
            }
              
        echo '</div>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </li>
  </ul>
  <div class="row mx-2">';

  if(isset($_SESSION["loggedin"]) && $_SESSION['loggedin']==true){
echo ' <form class="form-inline my-2 my-lg-0" method="GET" action="search.php">
<input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
Welcome '. $_SESSION['useremail'] .'
</form>
 <a href="partials/_logout.php" class="btn btn-primary ml-2">
 Log Out</a>';
  }
  else{
    echo'
  <form class="form-inline my-2 my-lg-0" method="GET" action="search.php">
    <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  </form>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#LogInModal">
 Log In
</button>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#SignUpModal">
 Sign Up
</button>';
  }
  
 echo '</div>
</nav> ';

include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
if(isset($_GET['signupsuccess'])&&$_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success !</strong> Your account is created...You can Now Log In
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
  </div>';
}
if(isset($_GET['signupfail'])&&$_GET['signupfail']=="true"){
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Oops..!</strong> Password did not match
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
  </div>';
}
if(isset($_GET['login'])&&$_GET['login']=="false"){
  echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Oops..!</strong> Invalid Credentials
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
  </div> ';
}
?>