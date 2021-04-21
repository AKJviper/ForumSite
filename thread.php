<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>AKJ'sForum</title>
</head>

<body>
    <h1 class="text-center">Welcome to iDiscuss!</h1>
    <?php include 'partials/_dbconnect.php';
    include 'partials/header.php'; 
    include 'partials/_loginmodal.php';
    include 'partials/_signupmodal.php';
     ?>
    

    <?php
            $id= $_GET['threadid'];
            $sql= "SELECT * FROM `threads` WHERE `threads`.`thread_id` = $id";
            $result= mysqli_query($conn , $sql);
            
            while($row= mysqli_fetch_assoc($result)){
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_user_id = $row['thread_user_id'];


                $sql2= "SELECT user_email FROM `users` WHERE sno= '$thread_user_id'";
                $result2= mysqli_query($conn , $sql2);
                $row2= mysqli_fetch_assoc($result2);
                $posted_by=$row2['user_email'];

            }
    ?>
    <?php
            $showalert=false;
            $method = $_SERVER['REQUEST_METHOD'];
                if($method == 'POST'){
                    $comment = $_POST['comment'];
                    $comment = str_replace("<", "&lt;", $comment);
                    $comment = str_replace(">", "&gt;", $comment); 
                    $sno=$_POST['sno'];
                    $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comment', '$id', current_timestamp(), '$sno');";
                    $result = mysqli_query($conn , $sql);
                    $showalert=true;
                    if($showalert){
                       echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success !</strong> Your comment has been added...
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div> ';
                    }
                }

    ?>
    <div class="container">
     <div class="jumbotron">
        <h1 class="display-4"><?php echo $title  ?> </h1>
        <p class="lead"><?php echo $desc  ?></p>
        <h4 class = "my-3">Forum Rules </h4>
        <p>1. No Spam / Advertising / Self-promote in the forums.<br>
        2. Do not post copyright-infringing material<br>
        3. Do not post “offensive” posts, links or images<br>
        </p>
        <p><b>Posted By <?php echo $posted_by ; ?></b></p>
        <a class="btn btn-primary btn-lg" href="#" role="button">View more</a>
    </div>
    </div>

    <?php
    if(isset($_SESSION["loggedin"]) && $_SESSION['loggedin']==true){

    echo '<div class="container">
        <h1 class="py-3">Comments Section</h1>
        <form action="'. $_SERVER['REQUEST_URI'] .'" method="POST">
        
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Post a Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">You are not logged in</h1>
          <p class="lead">Please, log in to post a comment.</p>
        </div>
      </div>';
    }

    ?>

        <div class="container" id="ques">
                <h1 class ="py-3">Discussion </h1>
    <?php
            $id= $_GET['threadid'];
            $sql= "SELECT * FROM `comments` WHERE `comments`.`thread_id` = $id";
            $result= mysqli_query($conn , $sql);
            $noResult=true;
            
            while($row= mysqli_fetch_assoc($result)){
                $noResult=false;
                $com_id = $row['comment_id'];
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $thread_user_id = $row['comment_by'];

                $sql2= "SELECT * FROM `users` WHERE sno= '$thread_user_id'";
                $result2= mysqli_query($conn , $sql2);
                $row2= mysqli_fetch_assoc($result2);
                $str1 = $row2['user_email'];

           
        echo '<div class="media my-3">
            <img src="img/userdefault.jpg" width="54px" class="mr-3" alt="...">
            <div class="media-body">
            <p class="font-weight-bold my=0">'. substr("$str1" , 0 , strpos($str1 ,'@')) .'<p class="my -0 py-0 font-weight-bold text-right">'.$comment_time.'</p></p>
        
                '. $content .'
            </div>
            </div>';

    }

    if($noResult)
        {
           echo  '<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">No Threads found</h1>
    <p class="lead">Be the First Person to Ask.</p>
  </div>
</div>';
        }
    ?>
    


    <?php include 'partials/footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>