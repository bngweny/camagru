<?php
session_start();
function check_pass($mine, $login)
{
    $severname = "localhost";
    $username = "bngweny";
    $password = "1234567";
    $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $con->prepare('SELECT * from USERS where Username=:username');
    $stmt->execute(['username'=>$login]);
    
    $result = $stmt->fetch();
    $pass = hash("Whirlpool",$mine);
    if ($pass == $result["passwd"])
    {
        $_SESSION["mail"] = $result["receive_emails"];
        $_SESSION["mailad"] = $result["email"];
        return(true);
    } 
    else
    {
        return(false);
    }
}

function check_valid($login)
{
    $severname = "localhost";
    $username = "bngweny";
    $password = "1234567";
    $con = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $con->prepare('SELECT * from USERS where Username=:username');
    $stmt->execute(['username'=>$login]);
    $result = $stmt->fetch();

    if ($result["valid"] == 0)
    {
        return(false);
    } 
    else
    {
        return(true);
    }
}


if ($_POST["login"] && $_POST["passwd"] && $_POST["submit"] === "Login")
{
    try{
        if (check_valid($_POST["login"]) == false)
        {
            header("location:/camagru/index.php?msg=err");
        }
        else if (check_pass($_POST["passwd"], $_POST["login"]))
        {
            $_SESSION["loggued_on_user"] = $_POST['login'];
            echo "OK\n";
            header("location:home.php?msg=1");
        } 
        else
        {
            header("location:/camagru/index.php?msg=passwdincorrect");
        }
        $con = null;
    }
    catch(PDOException $e)
    {
        echo $sql."<br>".$e->getMessage()."[ERROR]";
    }
}