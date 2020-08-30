<?php
session_start();
if (isset($_POST["login"]))
{
    $severname = "localhost";
    $username = "bngweny";
    $password = "1234567";
    $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $con->prepare('SELECT * from USERS where Username=:username');
    $stmt->execute(['username'=>$_POST["login"]]);
    
    $result = $stmt->fetch();
    $con = null;
        $to = $result["email"];
        $subject = "Reset password";
        $from = "admin@camagru.wethinkcode.co.za";
        $message = "Hi\nReset your password by following this link http://localhost:8080/camagru/php/auth.php?status=rst&uname=".$result["Username"]." registration";
        $headers = "FROM:".$from;
        mail($to, $subject, $message, $headers);
        header("location: home.php");
}

if (isset($_GET["status"]))
{
    if ($_GET["status"] == "rst" && isset($_GET["uname"]))
    {
        try{
            $severname = "localhost";
            $username = "bngweny";
            $password = "1234567";
            $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $new1 = hash("Whirlpool", "1Qt!pk32");
            $user = $_GET["uname"];
            $sql = "UPDATE USERS SET passwd='$new1' WHERE Username='$user'";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $con1 = null;

            $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $con->prepare('SELECT * from USERS where Username=:username');
            $stmt->execute(['username'=>$_GET["uname"]]);
    
            $result = $stmt->fetch();
            $con = null;
            $to = $result["email"];
            $subject = "Reset password";
            $from = "admin@camagru.wethinkcode.co.za";
            $message = "Hi\n Password has been reset to 1Qt!pk32 .You may now log in";
            $headers = "FROM:".$from;
            mail($to, $subject, $message, $headers);
            header("location: home.php");
            } 
            catch(PDOException $e)
            {
                echo $sql."<br>".$e->getMessage()."[ERROR]";
            }
    }

    if ($_GET["status"]== "fgt")
    {
        echo '
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
            height: 260px;
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
        
        .loginbox input[type="text"],input[type="email"], input[type="password"]
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
        }
        .loginbox a{
            text-decoration: none;
            font-size: 12px;
            line-height: 20px;
            color: black;
        }
        
        .loginbox a:hover
        {
            color: #ffc107;
        }
            </style>
        <title>Register</title>
            <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
        <body>
            <div class="loginbox">
            <img src="/camagru/img/avatar.png" class="avatar">
                <h1>Reset password</h1>
                <form method="post" action="auth.php">
                    <p>Username</p>
                    <input type="text" name="login" autocomplete="username" placeholder="Enter Username" required>
                    <input type="submit" name="reset" value="Reset">
                </form>     
            </div>
        </body>
        </head>
        </html>
        ';
    }

    if ($_GET["status"] == "reg" && isset($_GET["uname"]))
    {
        try
        {
            $severname = "localhost";
            $username = "bngweny";
            $password = "1234567";
            $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $user = $_GET["uname"];
            $sql = "UPDATE USERS SET valid='1' WHERE Username='$user'";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            echo "<script type=\"text/javascript\">alert(\"Registered:)\");</script>";
            header("location:home.php");
        } 
        catch(PDOException $e)
        {
            echo $sql."<br>".$e->getMessage()."[ERROR]";
        }
    }
    
    if ($_GET["status"] == "com" && isset($_GET["id"]) && isset($_GET["to"]))
    {
	        $to = $_GET["to"];
            $subject = "Someone commented on your image";
            $from = "admin@camagru.co.za";
            $message = $_SESSION["loggued_on_user"]." commented on your image. Log in to see what they said :)";
            $headers = "FROM:".$from;
            mail($to, $subject, $message, $headers);
	    header("location: feed.php?id=".$_GET["id"]);
    }

}
?>