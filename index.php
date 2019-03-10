<!doctype html>

<?php
include("connectdb.php");
include("email_exist.php");
session_start();
if(isset($_SESSION['user_id'])){
    header("location: profile.php");
}
$error = "";
if (isset($_POST["singup"])){
    $fullname = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $re_password = $_POST['repass'];


    if (strlen($fullname) < 3) {
        $error = "Your name is too short";
    }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter valid email address";
    } else if (strlen($password) < 5) {
        $error = "Password must be greater than 5 characters";
    } else if ($password !== $re_password) {
        $error = "Password does not match";
    } else{
        $password = md5($password);
        $insertQry = "INSERT INTO `userinfo`(`fullname`, `email`, `password`) VALUES ('$fullname', '$email', '$password')";

        if (mysqli_query($con, $insertQry)){
            $error = "You have successfully registered !!";
        }
    }
}

if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($con, $_POST['userName']);
    $password = md5($_POST['userPass']);

    if (email_exist($email, $con)){

        $result = mysqli_query($con, "select * from userinfo where email='$email'");
        $row = $result -> fetch_assoc();
        $user_name = $row['fullname'];
        $user_email = $row['email'];
        $user_id = $row['userID'];
        $user_pass = $row['password'];

        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['user_id'] = $user_id;

        if ($user_pass !== $password){
            $error = "Incorrect Password";

        }
        else{
            header("location: profile.php");
        }

    } else {
        $error = "email not Exist";
    }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Registration System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login_back">

<div class="login-page">
    <div class="form">
        <?php if ($error){ ?>
        <div class="response">
            <h4><?php echo $error; ?></h4>
        </div>
        <?php } ?>
        <form class="register-form" method="post">
            <input type="text" placeholder="Full name" name="name"/>
            <input type="password" placeholder="password" name="password"/>
            <input type="password" placeholder="retype password" name="repass"/>
            <input type="text" placeholder="email address" name="email"/>
            <button name="singup">create</button>
            <p class="message">Already registered? <a href="javascript:void(0)">Sign In</a></p>
        </form>
        <form class="login-form" method="post">
            <input type="text" placeholder="Email" name="userName"/>
            <input type="password" placeholder="Password" name="userPass"/>
            <button name="login">login</button>
            <p class="message">Not registered? <a href="javascript:void(0)">Create an account</a></p>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>

