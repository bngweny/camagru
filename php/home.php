<?php
session_start();
if (!$_SESSION["loggued_on_user"])
{
	header("location: /camagru/index.php");	
}
?>
<html>
<head>
	<style type="text/css">
		.navbar {
			overflow: hidden;
			background-color: #333;
			font-family: Arial;
		}

		.navbar a {
			float: left;
			font-size: 16px;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		.dropdown {
			float: left;
			overflow: hidden;
		}

		.dropdown .dropbtn {
			font-size: 16px;
			border: none;
			outline: none;
			color: white;
			padding: 14px 16px;
			background-color: inherit;
			font-family: inherit;
			margin: 0;
		}

		.navbar a:hover, .dropdown:hover .dropbtn {
			background-color: red;
		}

		.content {
			display: none;
			position: absolute;
			background-color: #f9f9f9;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 1;
		}

		.content a
		{
			float: none;
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
			text-align: left;
		}

		.content a:hover
		{
			background-color: #ddd;
		}

		.dropdown:hover .content
		{
			display: block;
		}
		/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

.row:after {
  content: "";
  display: table;
  clear: both;
  height: 20%;
}

/* Six columns side by side */
.column {
  float: left;
  width: 20%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}
img {
  height: 20%;
  width: 100%;
}
.active,
.demo:hover {
  opacity: 1;
}
body{
    margin: 0;
    padding: 0;
background: url(/camagru/img/pic1.jpg);
    background-size: cover;
    background-position: center;
    font-family: sans-serif;
}
.gallerysection{
	background: rgba(255,255,255,0.5);
	color: #fff;
}
.myframe {
    display: none;
    position:absolute;
    left:10%;
    /*top:  25%;*/
    width: 80%;
    height: 80%;
    /* z-index: 100; */
  }
	</style>
	<script type="text/javascript">

function currentSlide(n) {
  document.getElementById('frame1').src="feed.php?id="+n+"&home=edit";
  document.getElementById('frame1').style.display = "block";
//   document.getElementById('button').style.display = "block";
  document.getElementById('gal').style.display = "none";
}
function showorhide()
{
    document.getElementById('frame1').style.display = "none";
    // document.getElementById('button').style.display = "none";
    document.getElementById('gal').style.display = "block";
}
	</script>
</head>
<body>
	<div class="navbar">
		<a href="home.php">Home</a>
		<a href="gallery.php">Gallery</a>
		<a href="booth.php">Booth</a>
		<div class="dropdown">
			<button class="dropbtn">Menu
			<i class="fa fa-caret-down"></i>
			</button>
			<div id="mydropdown" class="content">
				<a href="profile.php?status=OK">Profile</a>
				<a href="change_password.php">Change Password</a>
				<a href="logout.php">Logout</a>
			</div>
		</div>
	</div>
	<h1 style="text-align: center;">CAMAGRU</h1>
	<h3 style="text-align: center;">Your Edits</h3>
	<iframe class="myframe" id="frame1" src="feed.php"></iframe>
	<div id="gal" class="gallerysection" style="width: 50%; position: relative; left: 25%; overflow: auto; height: 80%;">
				<?php
				include "../config/utilities.php";
				include "../config/database.php";
				$conn1 = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pictures= get_blobs($conn1);
				$i = 1;
				foreach ($pictures as $item)
				{
					while (!$pictures[$i])
					{
						$i++;
					}
					if ($item["username"] == $_SESSION["loggued_on_user"])
					{
						$pic = base64_encode($item["picture"]);
						echo '<div class="column"> <img class="demo cursor" src="data:image/png;base64,'.$pic.'" onclick="currentSlide('.$i.')"> </div>';
					}
					$i++;
				}
			$conn1 = null;
			?>
	</div>
	
</body>
</html>