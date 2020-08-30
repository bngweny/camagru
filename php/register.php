<?php
//trim() and stripslashes()
session_start();
if ($_POST["login"] && $_POST["name"] && $_POST["passwd"] && $_POST["email"] && $_POST["submit"] === "Register")
{
    $severname = "localhost";
    $username = "bngweny";
    $password = "1234567";
    try
    {
        $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $uname = $_POST["login"];
        $fname = $_POST["name"];
        $pass = hash("Whirlpool", $_POST["passwd"]);
        $email = $_POST["email"];

        $sql = "INSERT INTO USERS (Username, Names, passwd, email)
        VALUES ('$uname', '$fname', '$pass', '$email')";
        $con->exec($sql);
        echo "New record created successfully";
        $to = $email;
        $subject = "Complete registration to camagru";
        $from = "bngweny@student.wethinkcode.co.za";
        $message = "Hi\nComplete your registration by following this link to complete http://localhost:8080/camagru/php/auth.php?status=reg&uname=$uname registration";
        $headers = "FROM:".$from;
        mail($to, $subject, $message, $headers);
       header("location:home.php");
    }
    catch(PDOException $e)
    {
        echo $sql."<br>".$e->getMessage();
    }
    $con = null;
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
    height: 520px;
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
        <h1>Register Here</h1>
        <form method="post" action="register.php">
            <p>Username</p>
            <input type="text" name="login" autocomplete="username" placeholder="Enter Username" required>
            <p>Name</p>
            <input type="text" name="name" placeholder="Enter First Name" required>
            <!-- <p>Surname</p> -->
            <!-- <input type="text" name="surname" autocomplete="off" placeholder="Enter Surname" required> -->
            <p>Password</p>
            <input type="password" name="passwd" autocomplete="current-password" placeholder= "Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            <p>Email</p>
            <input type="email" name="email" placeholder="Enter Email Address" required>
            <input type="submit" name="submit" value="Register">
            <a href="/camagru/index.php">Already have an account?</a>
        </form>     
    </div>
</body>
</head>
</html>