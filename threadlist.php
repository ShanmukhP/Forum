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

    #ques {
        min-height: 400px;
    }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php

    $id = $_GET['catid'];

    $sql = "SELECT * FROM `categories` WHERE `category_id`='$id'";    
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['description'];
    }

    ?>


    <?php
    $showAlert = false;

    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        $th_title = $_POST['title'];

        $th_title = str_replace("<","&lt;",$th_title);
        $th_title = str_replace(">","&gt;",$th_title);

        $th_desc = $_POST['desc'];

        $th_desc = str_replace("<","&lt;",$th_desc);
        $th_desc = str_replace(">","&gt;",$th_desc);

        $sno = $_POST['sno'];

        $sql = "INSERT INTO `threads` (`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`,`timestamp`) VALUES ('$th_title','$th_desc','$id','$sno',current_timestamp())";   
        
        $result = mysqli_query($conn,$sql);
        if($result)
        $showAlert = true;

        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your question has been added, please wait for someone to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    }


    ?>











    <div class="container my-3 p-5 main w-75">
        <h1 class="display-4">Welcome to <?php echo $catname; ?> forums!</h1>
        <p class="lead"><?php echo $catdesc; ?></p>
        <hr class="my-4">
        <p>It uses classes</p>
        <!-- <a href="#" class="btn btn-primary btn-lg" role="button">Learn more</a> -->
    </div>





    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container w-75">
        <h1 class="py-4">Start a discussion</h1>

        <form action='. $_SERVER["REQUEST_URI"].' method="post">
    <div class="mb-3">
        <label for="title" class="form-label">Question</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Keep your title short and concise</div>
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Elaborate your concern</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'"/>


    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    }
    else{
    echo '<div class="container mx-auto w-75"><h1 class="">Start a discussion</h1><p class="lead">You are not logged in!, Login to start a discussion</p></div>';
    }

    ?>










    <div class="container w-75 mx-auto" id="ques">

        <h1 class="py-4">Browse Questions</h1>

        <?php

        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $timestamp = $row['timestamp'];
            $uid = $row['thread_user_id'];
            $sql2 = "SELECT `email` FROM `users` WHERE `sno`='$uid'";
            $result2 = mysqli_query($conn, $sql2);
            $row2=mysqli_fetch_assoc($result2);
            

        echo '<div class="media">
            <img src="images/default_user.jpeg" alt="" class="mr-3 dp">
            <div class="media-body">
                <h5 class="mt-0"><a class="text-dark text-decoration-none" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>'.$desc.'
                <div><p class="my-0">Asked by : <b>'.$row2['email'].'</b> at '.$timestamp.'</p></div></div>
                
        </div>';
        }

        if($noResult){
            echo '<div class="container my-3 p-5 main w-100">
            <p class="display-6"> No Questions</p>
            <hr class="my-4">
            <p class="lead">Be the first person to ask a question</p>
            
            
        </div>';
            
            
        }

        ?>



        <!-- <div class="media">
            <img src="images/default_user.jpeg" alt="" class="mr-3 dp">
            <div class="media-body">
                <h5 class="mt-0">Unable to install pyaudio error in windows</h5>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam laborum quis ab itaque beatae unde maiores omnis tempora est? Iure at atque autem tenetur veniam enim fugiat harum est odit.
            </div>
        </div> -->



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