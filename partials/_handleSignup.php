<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $useremail = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];

    $existSql = "SELECT * FROM `users` WHERE `email` = '$useremail'";
    $result = mysqli_query($conn,$existSql);
    $numRows = mysqli_num_rows($result);
    
    if($numRows>0){
    $showError="Email already in use";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`email`,`pass`) VALUES ('$useremail','$hash')";
            $result = mysqli_query($conn, $sql);
                if($result){
                 $showAlert = true;
                 header("Location: /forum/index.php?signupsuccess=true");
                 exit();
                }
         

        }
        else{
            $showError = "passwords do not match";
        

        }
    }
    header("Location: /forum/index.php?signupsuccess=false&error=$showError");

}