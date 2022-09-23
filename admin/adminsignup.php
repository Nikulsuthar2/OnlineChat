<!DOCTYPE html>
<html>
<head>
    <title>Online Chat</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userloginsignup.css">
</head>
<body class="main-body">
    <form class="form" action="" method="post" enctype="multipart/form-data">
        <h1 style="text-align: center;">Create Admin Account</h1>
        <div class="inputsec">
            <label>Name</label>
            <input class="inputbox" type="text" name="uname" placeholder="Enter your name." autofocus required>
        </div>
        <div class="inputsec">
            <label>Email</label>
            <input class="inputbox" type="email" name="uemail" placeholder="Enter your email address." required>
        </div>
        <div class="inputsec">
            <label>Password</label>
            <input class="inputbox" type="password" name="pswd" placeholder="Enter your password" required>
        </div>
        <div class="inputsec">
            <label>Confirm Password</label>
            <input class="inputbox" type="password" name="cpswd" placeholder="Confirm your password" required>
        </div>
        <?php 
        session_start();
        include 'db.php';

        if(isset($_POST['signup'])){
            $name = mysqli_real_escape_string($con, $_POST['uname']);
            $email = mysqli_real_escape_string($con, $_POST['uemail']);
            $password = mysqli_real_escape_string($con, $_POST['pswd']);
            $cpassword = mysqli_real_escape_string($con, $_POST['cpswd']);

            if($password == $cpassword){
                $sql = "select * from admin where email = '$email'";
                $res = mysqli_query($con, $sql);

                if(!(mysqli_num_rows($res) > 0))
                {
                    $signupsql = "insert into admin(name,email,password) values('$name','$email','$password')";
					$res = mysqli_query($con, $signupsql);
                    if($res){
                        $res2 = mysqli_query($con, "select * from admin where email = '$email'");
                        $data = mysqli_fetch_assoc($res2);
                        $_SESSION['aid'] = $data['adminid'];
                        $_SESSION['aname'] = $data['name'];

                        header("location: adminhome.php");
                    }
                    else{
                        echo "<p style='color:red;'>Something went wrong</p>";
                    }
                }
                else{
                    echo "<p style='color:red;'>This email already exist</p>";
                }
            }
            else{
                echo "<p style='color:red;'>Password not matching.</p>";
            }
        }
        ?>
        <input id="loginbtn" type="submit" name="signup" value="Signup">
        <div style="text-align: center;"><a href="adminlogin.php" id="createaccbtn">Admin Login</a></div>
    </form>
</body>
</html>