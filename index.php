<?php
include "config/setup.php";
session_start();
if ($_SESSION["loggued_on_user"])
{
    echo "<script type=\"text/javascript\">alert(\"You're already logged in fam\");</script>";
    header("location:./php/home.php");
}
if (isset($_GET["msg"]))
{
    if ($_GET["msg"] == "err")
    {
        echo "<script type=\"text/javascript\">alert(\"User Registration not complete. Please Check your email\");</script>";
    }
    if ($_GET["msg"] == "passwdincorrect")
    {
        echo "<script type=\"text/javascript\">alert(\"Incorrect Username/Password combination\");</script>";
    }
}
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <div class="loginbox">
    <img src="./img/avatar.png" class="avatar">
        <h1>Login Here</h1>
        <form method="post" action="./php/login.php">
            <p>Username</p>
            <input type="text" name="login" autocomplete="username" placeholder="Enter Username" required>
            <p>Password</p>
            <input type="password" name="passwd" autocomplete="current-password" placeholder="Enter Password" required>
            <input type="submit" name="submit" value="Login" required>
            <!-- <a href="#">Lost your password?</a><br> -->
            <a href="./php/register.php">Don't have an account?</a>
            <br>
            <a href="./php/auth.php?status=fgt">Forgot your password?</a>
            <br>
            <a href="./php/gallery.php">Browse Gallery?</a>
        </form>     
    </div>
</body>
</html>