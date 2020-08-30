<?php
session_start();
include "../config/utilities.php";

// Load the stamp and the photo to apply the watermark to

$im = imagecreatefrompng($_POST["base"]);
imagepng($im, "../img/current.png");

foreach ($_POST as $key => $value)
{
if ($key == "base")
{
    continue;
}
$im = imagecreatefrompng("../img/current.png");
$stamp = imagecreatefrompng("../img/stickers/".$value);

$stamp = imagescale($stamp, imagesx($im), imagesy($im));
// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 5;
$marge_bottom = 5;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
imagepng($im, "../img/current.png");
}
$target_file = "/camagru/img/current.png";
$severname = "localhost";
$username = "bngweny";
$password = "1234567";
$conn1 = new PDO("mysql:host=$severname;dbname=myDB", $username, $password);
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
insert_image($_SESSION["loggued_on_user"], "image/png", $target_file, "image", $conn1);
$conn1 = null;
imagedestroy($im);
if (file_exists("../img/current.png")){
    unlink("../img/current.png");
}	
header("location:home.php");
?>
