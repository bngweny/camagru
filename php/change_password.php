<?php
include "login.php";
session_start();
if (!$_SESSION["loggued_on_user"])
{
	header("location: /camagru/index.php");	
}
if (isset($_POST["oldpwd"]) && isset($_POST["confirm"]) && isset($_POST["newpwd"]))
{
    if (check_pass($_POST["oldpwd"], $_SESSION["loggued_on_user"]) == false)
    {
        echo "<script type=\"text/javascript\">alert(\"Incorrect Username/Password combination\");</script>";
    }
    else if ($_POST["newpwd"] != $_POST["confirm"])
    {
        echo "<script type=\"text/javascript\">alert(\"Please make the password match\");</script>";
    }
    else
    {
     try{
        $severname = "localhost";
        $username = "bngweny";
        $password = "1234567";
        $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $new1 = hash("Whirlpool", $_POST["newpwd"]);
        $user = $_SESSION["loggued_on_user"];
        $sql = "UPDATE USERS SET passwd='$new1' WHERE Username='$user'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        echo "<script type=\"text/javascript\">alert(\"Password Changed Successfully:)\");</script>";
        } 
        catch(PDOException $e)
        {
            echo $sql."<br>".$e->getMessage()."[ERROR]";
        }
    }
}
?>
<html>
<head>
    <style>
        body{
    margin: 0;
    padding: 0;
background: url(/camagru/img/pic1.jpg);
    background-size: cover;
    background-position: center;
    font-family: sans-serif;
}

.loginbox{
    width: 320px;
    height: 500px;
    background: rgba(255,255,255,0.5);
    color: #fff;
    top: 50%;
    left: 50%;
    position: absolute;
    transform: translate(-50%,-50%);
    box-sizing: border-box;
    padding: 70px 30px;
}

.avatar{
    width: 100px;
    height: 100px;
    border-radius: 50%;
    position: absolute;
    top: -50px;
    left: calc(50% - 50px);
}

h1{
    margin: 0;
    padding: 0 0 20px;
    text-align: center;
    font-size: 22px;
}

.loginbox p{
    margin: 0;
    padding: 0;
    font-weight: bold;
}

.loginbox input{
    width: 100%;
    margin-bottom: 20px;
}

.loginbox input[type="text"], input[type="password"]
{
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 16px;
}
.loginbox input[type="submit"]
{
    border: none;
    outline: none;
    height: 40px;
    background: #fb2525;
    color: #fff;
    font-size: 18px;
    border-radius: 20px;
}
.loginbox input[type="submit"]:hover
{
    cursor: pointer;
    background: #ffc107;
    color: #000;
    position:relative;
}
.cancel
{
	width: 100%;
    margin-bottom: 20px;
	border: none;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 18px;
    border-radius: 20px;
    position:relative;
}
.cancel:hover
{
    cursor: pointer;
    background: #ffc107;
    color: #000;
    position:relative;
}
    </style>
<title>Change Password</title>
<body>
    <div class="loginbox">
    <img src="/camagru/img/avatar.png" class="avatar">
        <h1>Change Password</h1>
        <form method="post" action="change_password.php">
            <input type="text" name="login" autocomplete="username" hidden>
            <p>Current Password</p>
            <input type="password" name="oldpwd" autocomplete="current-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Enter old password" required>
            <p>New Password</p>
            <input type="password" name="newpwd" autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Enter new password" required>
            <p>Confirm New Password</p>
            <input type="password" name="confirm" autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Re-enter new password" required>
            <input type="submit" name="submit" value="Change Password">
            <a class="cancel" href="/camagru/php/home.php">Cancel</a>
        </form>     
    </div>
</body>
</head>
</html>
