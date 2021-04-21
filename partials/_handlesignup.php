<?php
include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
$showError= "false";
$exist="false";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $useremail = $_POST['signupEmail'];
    $password = $_POST['signuppassword'];
    $cpassword = $_POST['signupcpassword'];

    $existsql="SELECT * FROM `users`  WHERE `users`.`user_email` = '$useremail'";
    $result=mysqli_query($conn , $existsql);
    $num=mysqli_num_rows($result);
    echo $num;
    if($num>0)
    {
    $exist="username already Exists";
    echo "exist";
    header("Location: /Forum/index.php?signupsuccess=false");
    }
    else
    {
    if($password==$cpassword)
        { 
    $hash = password_hash($password , PASSWORD_DEFAULT);
    $sql="INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$useremail', '$hash', current_timestamp())";
    $result=mysqli_query($conn , $sql);
    if($result) 
                {
    $showAlert = true;
    header("Location: /Forum/index.php?signupsuccess=true");
    exit();
                }
        }
            else{
                header("Location: /Forum/index.php?signupfail=true");
                }
    }

}

?>