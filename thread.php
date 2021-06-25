<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forums</title>
    <style>
    .main {
        background-color: lightgray;
    }

    .dp {
        width: 80px;
        padding: 0 0 4em 0;
        display: inline-block;
    }

    .media-body {
        width: 80%;
        display: inline-block;

    }

    .media {
        /* border: 2px solid gray;
            border-radius: 10px; */
        padding: 0 0 0 0;
    }

    .c-media {
        padding: 0 0 0 0;
    }

    .c-media-body {
        width: 70%;
        display: inline-block;
        padding: 0 0 0 0;
    }

    .dp {
        display: inline-block;
        width: 50px;
        padding: 0 0 2em 0;
    }

    #ques {
        min-height: 400px;
    }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php

    $id = $_GET['threadid'];

    $sql = "SELECT * FROM `threads` WHERE `thread_id`='$id'";    
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $tuid = $row['thread_user_id'];
        $sql2 = "SELECT `email` FROM `users` WHERE `sno`='$tuid'";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['email'];
    }

    ?>




    <?php
    $showAlert = false;

    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        $comment = $_POST['comment'];
        $comment = str_replace("<","&lt;",$comment);
        $comment = str_replace(">","&gt;",$comment);
        $sno = $_POST['sno'];

        $sql = "INSERT INTO `comments` (`comment_content`,`thread_id`,`comment_by`,`comment_time`) VALUES ('$comment','$id','$sno',current_timestamp())";   
        
        $result = mysqli_query($conn,$sql);
        if($result)
        $showAlert = true;

        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Comment has been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    }


    ?>









    <div class="container my-3 p-5 main w-75">
        <h1 class="display-4"><?php echo $title; ?></h1>
        <p class="lead"><?php echo $desc; ?></p>
        <hr class="my-4">
        <p>It uses classes</p>
        <p>posted by <b>
                <?php echo $posted_by;?>
            </b></p>
        <!-- <a href="#" class="btn btn-primary btn-lg" role="button">Learn more</a> -->
    </div>




    <?php
    if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)
    {
echo '
    <div class="container w-75">
        <h1 class="py-4">Post a comment</h1>

        <form action='.$_SERVER['REQUEST_URI'] .' method="post">

    <div class="mb-3">
        <label for="comment" class="form-label">Type your comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        <input type="hidden" name="sno" value="'.$_SESSION['sno'].'"/>
    </div>

    <button type="submit" class="btn btn-success">Post comment</button>
    </form>
    </div>';
    }
    else{
        echo '<div class="container mx-auto w-75"><h1 class="">Post a comment</h1><p class="lead">You are not logged in!, Login to post comments.</p></div>';
    }

    ?>




    <div class="container w-75 mx-auto" id="ques">

        <h1 class="py-4">Comments</h1>

        <?php

        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult=false;
            $cid = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];  
            $uid = $row['comment_by'];
            $sql2 = "SELECT `email` FROM `users` WHERE `sno`='$uid'";
            $result2 = mysqli_query($conn, $sql2);
            $row2=mysqli_fetch_assoc($result2);
            

        echo '<div class="c-media">
            <img src="images/default_user.jpeg" alt="" class="dp">
            <div class="c-media-body" my-5>'.$content.'
            <div> <p class="my-0">answered by <b>'.$row2['email'].'</b> at '.$comment_time.'</p></div></div>
        </div>';
        }

        if($noResult){
            echo '<div class="container my-3 p-5 main w-100">
            <p class="display-6"> No comments</p>
            <hr class="my-4">
            <p class="lead">Be the first person to answer the  question</p>
            
            
        </div>';
            
            
        }

        ?>



    </div>





















    <?php include 'partials/_footer.php'; ?>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>