<?php
session_start();
include 'db.php';
if(isset($_POST['resetpass'])){
    $email = mysqli_real_escape_string($con, $_POST['uemail']);

    $sql = "select * from user where email = '$email'";
    $res = mysqli_query($con, $sql);

    if($res){
        if(mysqli_num_rows($res) > 0){
            $data = mysqli_fetch_assoc($res);
            $_SESSION['forgetid'] = $data['userid'];
            header("location: resetpassword.php");
        }
        else{
            echo "<script>alert('Email does not exists');</script>";
        }
    }
    else{
        echo "<script>alert('Something wrong');</script>";
    }
    unset($_POST['resetpass']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Chat</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userloginsignup.css">
</head>
<body class="main-body">
    <form class="form" action="" method="POST">
        <h1 style="text-align: center;">Forget Password</h1>
        <div class="inputsec">
            <label>Email</label>
            <input class="inputbox" type="email" name="uemail" placeholder="Enter your email address." autofocus required>
        </div>
        <input id="loginbtn" type="submit" name="resetpass" value="Reset Password">
        <div style="text-align: center;"><a href="userlogin.php" id="createaccbtn">Back to Login</a></div>
    </form>
</body>
</html>