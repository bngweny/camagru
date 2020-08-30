<?php
include "database.php";
include "utilities.php";
$severname = "localhost";
$username = "bngweny";
$password = "1234567";
try
{
    $conn = new PDO("mysql:host=$severname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS myDB";
    $conn->exec($sql);
    // echo "DB created successfully";
    $conn = null;

    $conn1 = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = "CREATE TABLE IF NOT EXISTS USERS (
        Username VARCHAR(30) PRIMARY KEY,
        Names VARCHAR(30) NOT NULL,
        passwd VARCHAR(128) NOT NULL,
        email VARCHAR(128) NOT NULL,
        valid BOOLEAN DEFAULT 0,
        receive_emails BOOLEAN DEFAULT 1,
        reg_date TIMESTAMP)";
        //
    $conn1->exec($sql1);
    // echo "Table created";
    $conn1 = null;

    $conn1 = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = "CREATE TABLE IF NOT EXISTS files (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30), FOREIGN KEY (username) REFERENCES USERS(username) ON DELETE CASCADE,
        pname VARCHAR (255) NOT NULL,
        mime VARCHAR (255)  NOT NULL,
        ptype VARCHAR (25)  NOT NULL,
        picture LONGBLOB    NOT NULL,
        likes INT DEFAULT 0)";
    $conn1->exec($sql1);
    $conn1 = null;

    // $conn1 = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
    // $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // insert_image("bngweny", "image/png", "/camagru/img/bngweny/catmagru.png", "image", $conn1);
    // insert_image("bngweny", "image/png", "/camagru/img/bngweny/an_image.png", "image", $conn1);
    // insert_image("bngweny", "image/png", "/camagru/img/bngweny/jailb.png", "image", $conn1);
    // $conn1 = null;

    $conn1 = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = "CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30), FOREIGN KEY (username) REFERENCES USERS(username) ON DELETE CASCADE,
        p_id INT, FOREIGN KEY (p_id) REFERENCES files(id) ON DELETE CASCADE,
        text VARCHAR (512))";
    $conn1->exec($sql1);
    $conn1 = null;

    // $conn1 = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
    // $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // get_blobs($conn1);
    // $conn1 = null;
}
catch(PDOException $e)
{
    echo $sql1."<br>".$e->getMessage();
}

?>