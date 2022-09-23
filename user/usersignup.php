<!DOCTYPE html>
<html>
<head>
    <title>Online Chat</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userloginsignup.css">
</head>
<body class="main-body">
    <a id="backuloginbtn" href="../index.html">Back to Index</a>
    <form class="form" action="" method="post" enctype="multipart/form-data">
        <h1 style="text-align: center;">Create Account</h1>
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
            <input class="inputbox" type="password" name="pswd" placeholder="Enter your password" maxlength="16" minlength="8" required>
        </div>
        <div class="inputsec">
            <label>Confirm Password</label>
            <input class="inputbox" type="password" name="cpswd" placeholder="Confirm your password" maxlength="16" minlength="8" required>
        </div>
        <div class="inputsec">
            <label>Profile Image</label>
            <input type="file" name="profileimg" accept="image/png,image/jpeg">
        </div>
        <?php 
        session_start();
        include 'db.php';

        if(isset($_POST['signup'])){
            $name = trim(mysqli_real_escape_string($con, $_POST['uname']));
            $email = trim(mysqli_real_escape_string($con, $_POST['uemail']));
            $password = trim(mysqli_real_escape_string($con, $_POST['pswd']));
            $cpassword = trim(mysqli_real_escape_string($con, $_POST['cpswd']));

            if($password == $cpassword){
                $sql = "select * from user where email = '$email'";
                $res = mysqli_query($con, $sql);

                if(!mysqli_num_rows($res) > 0)
                {
                    $signupsql = "";

                    if(isset($_FILES['profileimg']) && !empty($_FILES['profileimg']['name'])){
                        $img_name = $_FILES['profileimg']['name'];
                        $tmp_name = $_FILES['profileimg']['tmp_name'];

                        $img_ext = end(explode('.',$img_name));

                        if(in_array($img_ext,['png','jpeg','jpg']) === true){
                            $newimgname = time().$img_name;
                            if(move_uploaded_file($tmp_name, "../image/profileimg/".$newimgname))
                            {
                                $signupsql = "insert into user(name,email,password,image,status) values('$name','$email','$password','image/profileimg/$newimgname','online')";
                            }
                        }
                        else{
                            echo "<p style='color:red;'>Please select an image file - jpg, png, jpeg</p>";
                        }
                    }
                    else{
						$signupsql = "insert into user(name,email,password,status) values('$name','$email','$password','online')";
                    }
					
					if($signupsql != ""){
                        $res = mysqli_query($con, $signupsql);
                        if($res){
                            $res2 = mysqli_query($con, "select * from user where email = '$email'");
                            $data = mysqli_fetch_assoc($res2);
                            $_SESSION['uid'] = $data['userid'];
							$_SESSION['uname'] = $data['name'];

                            header("location: userhome.php");
                        }
                        else{
                            echo "<p style='color:red;'>Something went wrong</p>";
                        }
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
        <div style="text-align: center;"><a href="userlogin.php" id="createaccbtn">Already have an account?</a></div>
    </form>
</body>
</html>