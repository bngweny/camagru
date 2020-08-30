<?php
session_start();
if (!$_SESSION["loggued_on_user"])
{
	header("location: /camagru/index.php");	
}
if ($_POST["login"] && $_POST["name"] && $_POST["email"] && $_POST["update"] === "Update")
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
        if (!$_POST["notif"])
        {
            $recmail = 0;
        }
        else
        {
            $recmail = 1;
        }
        $_SESSION["mail"] = $recmail;
        $_SESSION["mailad"] = $email;
        $cur = $_SESSION["loggued_on_user"];
        $sql = "UPDATE users SET Username=:uname, Names=:names, email=:mail, receive_emails=:notif WHERE Username=:cur";
        // VALUES ('$uname', '$fname', '$pass', '$email', '$recmail')";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(':cur', $cur);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':names', $fname);
        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':notif', $recmail);
        $stmt->execute();
        echo "New record created successfully";
        $_SESSION["loggued_on_user"] = $_POST['login'];

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
<title>Profile</title>
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
<body>
    <div class="loginbox">
    <img src="/camagru/img/avatar.png" class="avatar">
        <h1>Profile</h1>
        <form method="post" action="profile.php">
            <p>Username</p>
            <input type="text" id="un" name="login" placeholder="Enter Username" required>
            <p>Name</p>
            <input type="text" id="nm" name="name" placeholder="Enter First Name" required>
            <!-- <p>Surname</p> -->
            <!-- <input type="text" id="sn" name="surname" placeholder="Enter Surname" required> -->
            <!-- <p>change_password</p> -->
            <!-- <input type="password" id="psw" name="passwd" placeholder= "Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required> -->
            <p>Email</p>
            <input type="email" id="eml" name="email" placeholder="Enter Email Address" required>
            <input type="checkbox" id="notifcheck" name="notif" value="notifications" checked> Receive Notifications
            <input type="submit" name="update" value="Update">
            <a href="change_password.php">Change Your Password?</a>
            <br>
            <a href="home.php">Cancel</a>            
        </form>     
    </div>
</body>
</head>
</html>
<?php
session_start();
if (isset($_GET["status"]))
{
    $severname = "localhost";
    $username = "bngweny";
    $password = "1234567";
    try
    {
        $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $con->prepare('SELECT * from USERS where Username=:username');
        $stmt->execute(['username'=>$_SESSION["loggued_on_user"]]);
        $result = $stmt->fetch();
        echo "<script>document.getElementById('un').value = '".$result["Username"]."';</script>";
        echo "<script>document.getElementById('nm').value = '".$result["Names"]."';</script>";
        echo "<script>document.getElementById('eml').value = '".$result["email"]."';</script>";
        if (!$result["receive_emails"])
        {
            echo "<script>document.getElementById('notifcheck').checked = false;</script>";
        }
        //document.getElementById("checkbox").checked = true;
        $con = null;
    }
    catch(PDOException $e)
    {
        echo $sql."<br>".$e->getMessage();
    }
    $con = null;
}
?>