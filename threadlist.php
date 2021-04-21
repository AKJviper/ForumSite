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
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/header.php'; ?>

    <?php
            $id= $_GET['catid'];
            $sql= "SELECT * FROM `categories` WHERE `categories`.`category_id` = $id";
            $result= mysqli_query($conn , $sql);
            
            while($row= mysqli_fetch_assoc($result)){
                $cat = $row['category_name'];
                $desc = $row['category_description'];

            }
            $showalert=false;
            $method = $_SERVER['REQUEST_METHOD'];
                if($method == 'POST'){
                    
                    $th_title = $_POST['title'];
                    $th_desc = $_POST['desc'];

                    $th_title = str_replace("<", "&lt;", $th_title);
                    $th_title = str_replace(">", "&gt;", $th_title); 

                    $th_desc = str_replace("<", "&lt;", $th_desc);
                    $th_desc = str_replace(">", "&gt;", $th_desc);
                    $sno=$_POST['sno'];
                    $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
                    $result = mysqli_query($conn , $sql);
                    $showalert=true;
                    if($showalert){
                       echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success !</strong> You started a Discussion...Please wait for community to respond
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div> ';
                    }
                }

    echo '<div class="jumbotron">
        <h1 class="display-4">Welcome to '.$cat .' Forum</h1>
        <p class="lead">'.$desc .'</p>
        <hr class="my-4">
        <h4 class = "my=3">Forum Rules </h4>
        <p>1. No Spam / Advertising / Self-promote in the forums.<br>
        2. Do not post copyright-infringing material<br>
        3. Do not post “offensive” posts, links or images<br>
        </p>
        <a class="btn btn-primary btn-lg" href="#" role="button">View more</a>
    </div>';
    ?>

    <?php
 if(isset($_SESSION["loggedin"]) && $_SESSION['loggedin']==true){

    echo '<div class="container">
        <h1 class="py-3">Start a Discussion </h1>
        <form action="'. $_SERVER["REQUEST_URI"] .'" method="POST">
    <div class="form-group">
        <label for="title">Problem Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">Keep Your title as short and crisp as
            possible</small>
        <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Example textarea</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>';
 }
   else{
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">You are not logged in</h1>
          <p class="lead">Please, log in to start a discussion.</p>
        </div>
      </div>';
    }
    ?>

    <div class="container">

        <?php
            $id= $_GET['catid'];
            $sql= "SELECT * FROM `threads` WHERE `threads`.`thread_cat_id` = $id";
            $result= mysqli_query($conn , $sql);
            $noResult=true;
            
            while($row= mysqli_fetch_assoc($result)){
                $noResult=false;
                $id =  $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $threadtime = $row['timestamp'];
                $thread_user_id =  $row['thread_user_id'];

                $sql2= "SELECT * FROM `users` WHERE sno= '$thread_user_id'";
                $result2= mysqli_query($conn , $sql2);
                $row2= mysqli_fetch_assoc($result2);
                $str1 = $row2['user_email'];


           
        echo '<div class="media my-3 mb-0">
            <img src="img/userdefault.jpg" width="54px" class="mr-3" alt="...">
            <div class="media-body">
            <p class="font-weight-bold my-0 mb-0">'. substr("$str1" , 0 , strpos($str1 ,'@')) .'<p class="my -0 py-0 font-weight-bold text-right">'.$threadtime.'</p></p>
                <h5 class="mt-0"> <a href="thread.php?threadid='. $id .'" >'. $title .'</a></h5>
                '. $desc .'
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