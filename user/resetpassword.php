<!DOCTYPE html>
<html>
<head>
    <title>Online Chat</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userloginsignup.css">
</head>
<body class="main-body">
    <form class="form" action="" method="POST">
        <h1 style="text-align: center;">Reset Password</h1>
        <div class="inputsec">
            <label>New Password</label>
            <input class="inputbox" type="password" name="pswd" placeholder="Enter your password" maxlength="16" minlength="8" required>
        </div>
        <div class="inputsec">
            <label>Confirm New Password</label>
            <input class="inputbox" type="password" name="cpswd" placeholder="Confirm your password" maxlength="16" minlength="8" required>
        </div>
        <?php
        session_start();
        include 'db.php';

        if(isset($_POST["newpass"])){
            $uid = $_SESSION['forgetid'];
            $password = trim(mysqli_real_escape_string($con, $_POST['pswd']));
            $cpassword = trim(mysqli_real_escape_string($con, $_POST['cpswd']));

            if($password == $cpassword){
                $updtsql = "update user set password = '$password' where userid = $uid";
                if(mysqli_query($con,$updtsql)){
                    unset($_SESSION['forgetid']);
                    header("location: userlogin.php");
                }
                else{
                    echo "<p style='color:red;'>Password not updated. Try again</p>";
                }
            }
            else
            {
                echo "<p style='color:red;'>Passwords are not matching</p>";
            }
        }
        ?>
        <input id="loginbtn" type="submit" name="newpass" value="Set New Password">
        <div style="text-align: center;"><a href="userlogin.php" id="createaccbtn">Back to Login</a></div>
    </form>
</body>
</html>