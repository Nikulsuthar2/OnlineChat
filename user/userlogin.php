<!DOCTYPE html>
<html>
<head>
    <title>Online Chat</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userloginsignup.css">
</head>
<body class="main-body">
    <a id="backuloginbtn" href="../index.html">Back to Index</a>
    <form class="form" action="" method="post">
        <h1 style="text-align: center;">Login</h1>
        <div class="inputsec">
            <label>Email</label>
            <input class="inputbox" type="email" name="uemail" placeholder="Enter your email address." autofocus required>
        </div>
        <div class="inputsec">
            <label>Password</label>
            <input class="inputbox" type="password" name="pswd" placeholder="Enter your password" maxlength="16" minlength="8" required>
        </div>
        <div style="text-align: end;"><a id="forgotpassbtn" href="forgotpassword.php" >Forgot password?</a></div>
        <?php 
        include 'db.php';
        if(isset($_POST['login'])){
            session_start();
            $email = trim(mysqli_real_escape_string($con, $_POST['uemail']));
            $password = trim(mysqli_real_escape_string($con, $_POST['pswd']));

            $sql = "select * from user where email = '$email' and password = '$password'";
            $res = mysqli_query($con, $sql);

            if(mysqli_num_rows($res) > 0){
                $data = mysqli_fetch_assoc($res);
                $_SESSION['uid'] = $data['userid'];
				$_SESSION['uname'] = $data['name'];

                $statq = "update user set status = 'online' where userid = $data[userid]";
                $res2 = mysqli_query($con, $statq);

                if($res2){
                    header("location: userhome.php");
                }
            }
            else{
                echo "<p style='color:red;'>Email or password are incorrect</p>";
            }

        }
        ?>
        <input id="loginbtn" type="submit" name="login" value="Login">
        <div style="text-align: center;"><a href="usersignup.php" id="createaccbtn">Don't have an account?</a></div>
    </form>
</body>
</html>