<!DOCTYPE html>
<html>
<head>
    <title>Online Chat</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userloginsignup.css">
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body class="main-body">
    <a id="backuloginbtn" href="../index.html">Back to Index</a>
    <form class="form" action="" method="post">
        <h1 style="text-align: center;">Admin Login</h1>
        <div class="inputsec">
            <label>Email ID</label>
            <input class="inputbox" type="email" name="uemail" placeholder="Enter your email address." autofocus required>
        </div>
        <div class="inputsec">
            <label>Password</label>
            <input class="inputbox" type="password" name="pswd" placeholder="Enter your password" required>
        </div>
        <?php 
        session_start();
        include 'db.php';
        if(isset($_POST['login'])){
            $email = mysqli_real_escape_string($con, $_POST['uemail']);
            $password = mysqli_real_escape_string($con, $_POST['pswd']);

            $sql = "select * from admin where email = '$email' and password = '$password'";
            $res = mysqli_query($con, $sql);

            if(mysqli_num_rows($res) > 0){
                $data = mysqli_fetch_assoc($res);
                $_SESSION['aid'] = $data['adminid'];
				$_SESSION['aname'] = $data['name'];

                header("location: adminhome.php");
            }
            else{
                echo "<p style='color:red;'>Email or password are incorrect</p>";
            }

        }
        ?>
        <input id="loginbtn" type="submit" name="login" value="Login">
        <div style="text-align: center;"><a href="adminsignup.php" id="createaccbtn">Create Admin Account</a></div>
    </form>
</body>
</html>