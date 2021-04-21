<?php
include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
$login= false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $password = $_POST['loginpassword'];

    $sql = "SELECT * FROM `users`  WHERE `users`.`user_email` = '$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        $row=mysqli_fetch_assoc($result);
            if (password_verify($password, $row['user_pass'])){ 
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['useremail'] = $email;
                $_SESSION['sno'] = $row['sno'];
                }
            header("location: /Forum/index.php");
        }
        else
        header("location: /Forum/index.php?login=false");
    }
?>