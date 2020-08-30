<?php
include "../config/database.php";
session_start();
if (isset($_POST["like"]))
{
	echo "<script>console.log('122332434324');</script>";
    $con = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE files SET likes=:likes WHERE id=:pid";
        // VALUES ('$uname', '$fname', '$pass', '$email', '$recmail')";
		$num = intval($_SESSION["likes"]);
		$num = $num + 1;
		echo "[".$num."]".$_SESSION["cp_id"];	
    $stmt = $con->prepare($sql);
	$stmt->bindParam(':pid', $_SESSION["cp_id"]);
    $stmt->bindParam(':likes', $num);
	$stmt->execute();
	
	$con = null;

	header("location: feed.php?id=".$_SESSION["cp_id"]);
}

if (isset($_POST["delete"]))
{
    $con = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo '<script>console.log();</script>';
	$sql = "DELETE FROM files WHERE id=".$_SESSION["cp_id"];
	$con->exec($sql);
	$con = null;
	echo '<script>window.parent.document.getElementById("frame1").style.display = "none";</script>';
	echo '<script>window.parent.document.getElementById("gal").style.display = "block";</script>';
	echo '<script>window.parent.location.reload();</script>';
}
if (isset($_POST["comment"]))
{
	$txt = htmlspecialchars($_POST["comment"]);//inser comment with quotes
	$conn1 = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$uname = $_SESSION["loggued_on_user"];
	$txtcol = "text";
	$pid = $_SESSION["cp_id"];
	$sql = "INSERT INTO comments (username, p_id, $txtcol)
	VALUES (?,?,?)";
	$stmt = $conn1->prepare($sql);
	$stmt->execute([$uname, $pid, $txt]);

	$sql = "SELECT * from files where id=:pid";
	$stmt = $conn1->prepare($sql);
	$stmt->execute(['pid'=>$pid]);
	$result = $stmt->fetch();
	
	$to = $result["username"];

	$sql = "SELECT * from users where Username=:user";
	$stmt = $conn1->prepare($sql);
	$stmt->execute(['user'=>$to]);
	$result = $stmt->fetch();

	$to = $result["email"];
	$conn1 = null;

	if ($result["receive_emails"])
	{
		header("location: auth.php?status=com&id=".$pid."&to=$to");
	}
	else
	{
		header("location: feed.php?id=".$_SESSION["cp_id"]);
	}
}
?>
<html>
<head>
	<style type="text/css">
		.gallery {
			width:40%;
			height: 80%;
			position: relative;
			/*left: 10%;*/
			/*top: 10%;*/
			float:left;
			/* background-color: gray; */
		}
		.comments {
			width: 60%;
			height: 80%;
			/*position: relative;*/
			float: right;
			/* background-color: gray; */
		}

		.comment {
			/* background-color: white; */
		}
		
	</style>
	<script type="text/javascript">
		
	</script>
</head>
<body style="background: rgba(255,255,255,0.5);">
	<div>
		<div class="gallery">
			<div class="mySlides">
				<div id="uname">1 / 6</div>
				<img id="campic" src="/camagru/img/pic3.jpg" style="top: 50%; height:65%; width: 100% ; position: relative;">
			</div>
  			<div class="caption-container">
    			<p id="caption">cap</p>
    		</div>
    	</div>
    	<div class="comments">
    		<h1 style="text-align: center;">Comments</h1>
    		<hr>
    		<div class="content" style = "height: 80%; overflow-y:auto; word-wrap:break-word">
				<!-- <div class="comment"><p>The email asd dsadsasad fsa ffsafasfsafdsafsfas safh sfag safk gsfusaka sf</p></div>
				<div class="comment"><p style="text-align: right">bngweny-2018-june</p><p>The email</p></div> -->
				<?php
				include "../config/database.php";
				session_start();
				if (isset($_GET["id"]))
				{
					$_SESSION["cp_id"] = $_GET["id"];
					include "../config/utilities.php";
					$conn1 = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
					$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$pictures= get_blobs($conn1);
					$id = $_GET["id"];
					$pic = base64_encode($pictures["$id"]["picture"]);
					$_SESSION["likes"] = $pictures["$id"]["likes"];
					echo sprintf('<script>document.getElementById("uname").innerHTML = "posted by %s"; </script>', $pictures["$id"]["username"]);
					echo sprintf('<script>document.getElementById("caption").innerHTML = "%d like(s)"; </script>', $pictures["$id"]["likes"]);
					echo '<script>document.getElementById("campic").src="data:image/png;base64,'.$pic.'";</script>';
					$conn1 = null;
					$conn1 = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
					$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $conn1->prepare('SELECT * FROM comments where p_id=:picid');
					$stmt->execute(['picid'=>$id]); 
					$result = $stmt->fetchAll();
					foreach ($result as $key) {
						echo sprintf("<div class='comment'><p>%s</p></div>",$key["text"]);
					}
					$conn1 = null;
				}
				?>
			</div>
			<?php
			if ($_SESSION["loggued_on_user"] && !isset($_GET["home"]))
			{
			echo '
			<div style="height: 20%;">
				<form action="feed.php" method="post">
					<textarea name="comment" placeholder="Enter your Comment" required></textarea>
					<input type="submit" name="cmnt" value="putitin">
				</form >		
				<form action="feed.php" method="post">
					<input type="submit" name="like" value="like">
				</form>
			</div>';
			}
			if (isset($_GET["home"]))
			{
				echo '
				<div id="button" style="position:relative; bottom:0%; left:5%;">
					<form method="post" action="feed.php">
						<input type="submit" value="delete" name="delete">
					</form>
				</div>
				';
			}
			?>
		</div>
	</div>
</body>
</html>