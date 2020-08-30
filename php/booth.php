<?php
session_start();
if (!$_SESSION["loggued_on_user"])
{
	header("location:../index.php");
}
?>
<html>
<head>
	<title>Booth</title>
	<link rel="stylesheet" href="/camagru/css/cam.css">
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
		.left_pane {
			float: left;
			width: 75%;
			height: 80%;
			/*margin: 10px;*/
			/*background-color: green;*/
		}
		.right_pane {
			float: right;
			width: 25%;
			height: 80%;
			/*margin: 10px;*/
			/*background-color: green;*/
		}

		.cam {
			text-transform: uppercase;
			border: 2px solid #fff;
			display: inline-block;
			position: relative;
			overflow: hidden;
			width: 30%; height: 15%;
			top: 50%;
			left: 30%;
			text-transform: uppercase;
			font-size: 14px;
			transform: translate(-50%, -50%);
		}

		.cam a{
			color: white;
			font-size: 80%;
			display: block;
			text-decoration: none;
			font-weight: bold;
			letter-spacing: 1px;
			/*line-height: 26px;*/
			padding: 7px 13px 7px 13px;
		}

		.cam > a:after{
			font-family: FontAwesome;
			font-size: 14px;
			color: white;
			/*content: "\f064";*/
			margin-left: 10px;
		}

		.cam a:hover, .cam > a:hover:after{
			color: red;
		}

		.finish {
			text-transform: uppercase;
			border: 2px solid #fff;
			display: inline-block;
			position: relative;
			overflow: hidden;
			width: 30%; height: 15%;
			/* top: -15%; */
			right: -80%;
			text-transform: uppercase;
			font-size: 14px;
			transform: translate(-50%, -50%);
		}

		.finish a{
			color: white;
			font-size: 80%;
			display: block;
			text-decoration: none;
			font-weight: bold;
			text-align: center;
			letter-spacing: 1px;
			/*line-height: 26px;*/
			padding: 7px 13px 7px 13px;
		}

		.finish > a:after{
			font-family: FontAwesome;
			font-size: 14px;
			color: white;
			/*content: "\f064";*/
			margin-left: 10px;
		}

		.finish a:hover, .finish > a:hover:after{
			color: red;
		}
		.booth{
			width:50%;
			position: relative;
			left: 20%;
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
.cursor {
			cursor: pointer;
		}
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
	</style>
	<script>
	function stick(name)
	{
		// document.getElementById("sticks").src = name;
		var element = document.getElementById(name); //name = name of sticker
		var parent = document.getElementById('espace');// espace = div

		if (!element)
		{
			var newelem = document.createElement("img");
			newelem.src = "/camagru/img/stickers/"+name;
			newelem.style.position = "absolute";
			newelem.style.width = "100%";
			newelem.style.height = "100%";
			newelem.classList.add("stickclass");
			newelem.id = name;

			parent.appendChild(newelem);
		}
		else
		{
			parent.removeChild(element);
		}
	}
	</script>
</head>
<body style="background-color: lightblue;">
	<p id="urlp" style="display:none"></p>
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
	<h1 style="text-align: center;">Photo Booth</h1>
	<div id="options" style="position: relative; top:20%; left: 31%; background-color: #2D3847; width: 40%; height: 25%;   ">
		<div class="cam" id="takecambtn"><a href="#">Take new image</a></div>
		<div class="cam" id="userimgbtn"><a href="#">Upload Image</a></div>

	</div>
	<div id="updiv" style="position: relative; top:20%; left: 31%; background-color: #2D3847; width: 40%; height: 25%; display: none;">
		<form action="booth.php" method="post" enctype="multipart/form-data">
			Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload" required>
			<input type="submit" value="Upload Image" name="submit">
		</form>
	</div>
	<canvas id="canvas" style="position:absolute; left:0%; top:0%; width:100%; height:100%; z-index:-1; display:none;"></canvas>

	<div id="livecam" style="height:60%; width:100%;  display:none;">
		<div class="left_pane" style="float: left">
			<!-- <h3>This is probably where the video will be</h3> -->
			<div class="booth" style="height: 160%; width:40%">
				<video id="video" width="100%" height="50%"></video>
				<a href="#" id="capture" class="booth-capture-button">Take photo</a>
				<img id="photo" style="position: absolute; width:100%; height:50%;" src="http://via.digital.com/400x300" alt="photos">
			</div>	
			<script type="text/javascript">
			    var video = document.getElementById('video'),
            canvas = document.getElementById('canvas'),
            context = canvas.getContext('2d'),
            photo = document.getElementById('photo'),
            vendorUrl = window.URL || window.webkitURL;

    navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mediaDevices.getUserMedia|| navigator.msGetUserMedia);
    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream){
        video.src = vendorUrl.createObjectURL(stream);
        video.play();
    }, function(error){
    });
    document.getElementById('capture').addEventListener('click', function(){
        var xdim = video.offsetHeight;
        var ydim = video.offsetWidth;
        // console.log(xdim+"-"+ydim);
        context.drawImage(video, 0, 0, 300, 150);
        photo.setAttribute('src', canvas.toDataURL());
		photo.style.height = "40%";
		photo.style.width = "80%";
		photo.style.position = "relative";
		photo.style.left = "10%";
        document.getElementById('confimg').addEventListener('click', function(){
            document.getElementById('options').style.display = 'none'; document.getElementById('livecam').style.display = 'none'; document.getElementById('final').style.display = 'block'; document.getElementById('base').src=canvas.toDataURL();
            document.getElementById('urlp').innerHTML = canvas.toDataURL();
        });
    });
			</script>
		</div>
		<div class="right_pane" style="width:10%; float: right;">
			<div class="cam" id="confimg" style="background: rgba(255,255,255,0.5);"><a href="#">Confirm Image</a></div>
		</div>
	</div>
	<div id="final" style="background-color: beige; width: 100%; height: 80%; display:none;">
			<div class="editsection" style="width: 50%;position: relative; height: 80%; float:left; background-color: #2D3847; ">
				<div style="width: 100%; height: 50%;">
					<div id="espace" style="background-color:white; position: relative; top: 10%; height: 80%; width: 60%;">
						<img id="base" src="/camagru/img/bngweny/catmagru.png" style="position: absolute; width:100%; height:100%;">
						<!-- <img  id="sticks" class="stick" src="" style="position: absolute; width:100%; height:100%;" draggable> -->
					</div>
					<div class="finish" id="upld" style=""><a href="#">Finish up now</a></div>					
				</div>
				<div onmouseover="document.getElementById('stkt').style.display = 'none';" onmouseout="document.getElementById('stkt').style.display = 'block';" style="width: 100%; overflow: scroll; height: 50%; background-color: white;">
					<div class="column"><img class="demo cursor" src="/camagru/img/stickers/sticker1.png" onclick="stick('sticker1.png')"></div>
					<div class="column"><img class="demo cursor" src="/camagru/img/stickers/sticker2.png" onclick="stick('sticker2.png')"></div>
					<div class="column"><img class="demo cursor" src="/camagru/img/stickers/sticker3.png" onclick="stick('sticker3.png')"></div>
					<div class="column"><img class="demo cursor" src="/camagru/img/stickers/sticker4.png" onclick="stick('sticker4.png')"></div>
					<div class="column"><img class="demo cursor" src="/camagru/img/stickers/sticker5.png" onclick="stick('sticker5.png')"></div>

					<div id="stkt"  style="position:absolute; width:100%; height:51.5%; background:black; opacity:0.8; text-color:white;">
						<h1 style="text-align:center; font-size:72px; color:white; position:relative; top: 25%;">Stickers</h1>
					</div>
				</div>
			</div>
			<div class="gallerysection" onmouseover="document.getElementById('glrt').style.display = 'none';" onmouseout="document.getElementById('glrt').style.display = 'block';" style="width: 50%; overflow: auto; float: right; height: 80%; background-color: white;">
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
					$pic = base64_encode($item["picture"]);
					echo '<div class="column">
					<img class="demo cursor" src="data:image/png;base64,'.$pic.'">
				</div>';
				$i++;
				}
				$conn1 = null;
				?>
				<div id="glrt"  style="position:absolute; width:50%; height:65%; background:black; opacity:0.8; text-color:white;">
					<h1 style="text-align:center; font-size:72px; color:white; position:relative; top: 35%;">Gallery</h1>
				</div>
			</div>
		</div>


	<script type="text/javascript">
	function post(path, params, method) {
   		method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
  		var form = document.createElement("form");
    	form.setAttribute("method", method);
    	form.setAttribute("action", path);

    	for(var key in params) {
        	if(params.hasOwnProperty(key)) {
            	var hiddenField = document.createElement("input");
            	hiddenField.setAttribute("type", "hidden");
            	hiddenField.setAttribute("name", key);
	            hiddenField.setAttribute("value", params[key]);

            	form.appendChild(hiddenField);
        	}
    	}

    	document.body.appendChild(form);
    	form.submit();
	}
		document.getElementById('takecambtn').addEventListener('click', function(){
			document.getElementById('options').style.display = "none";
			document.getElementById('livecam').style.display = "block";
		});
		document.getElementById('userimgbtn').addEventListener('click', function(){
			document.getElementById('options').style.display = "none";
			document.getElementById('updiv').style.display = "block";
		});
		document.getElementById('upld').addEventListener('click', function(){
			var bs = document.getElementById('urlp').innerHTML;
			var x = document.getElementsByClassName("stickclass");
			var obj = new Object;
			obj.base = bs;
			var i;
			for (i = 0; i < x.length; i++) {
				obj["stick"+ (i+1)] = x[i].id;
			}
			post('merge.php', obj);
		});
	</script>
	<?php
	echo "<div style='position: relative; bottom:-50%;'><hr><p>logged in as ".$_SESSION["loggued_on_user"]."</p></div>";
	?>
</body>
</html>
<?php
if (isset($_POST["submit"]))
{
	session_start();
	$target_dir = "../img/".$_SESSION["loggued_on_user"]."/";
	if(!is_dir($target_dir)){
  //Directory does not exist, so lets create it.
		mkdir($target_dir);
	}
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		
	if (file_exists($target_file)) {
		unlink($target_file);
	}	
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if (file_exists("cur.png")) {
			unlink("cur.png");
		}	
		imagepng(imagecreatefromstring(file_get_contents($target_file)), "cur.png");
		$target_file = "cur.png";
		// $urlp = base64_encode();
		$urlp = base64_encode(file_get_contents($target_file));
		echo "<script>document.getElementById('options').style.display = 'none'; document.getElementById('updiv').style.display = 'none'; document.getElementById('final').style.display = 'block'; document.getElementById('base').src='$target_file';</script>";
		echo '<script>document.getElementById("urlp").innerHTML = "data:image/png;base64,'.$urlp.'";</script>';
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}
}
?>