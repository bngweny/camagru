<?php
function insert_image($uname, $mime, $path, $type, $conn1)
{
	try
	{
		// echo $_SERVER['DOCUMENT_ROOT'].$path;
    	$blob = fopen($_SERVER['DOCUMENT_ROOT'].$path, 'rb');
    	$sql = "INSERT INTO files (mime, picture, username, ptype, pname) VALUES (:mime, :data1, '$uname', '$type', 'upload')";
    	$stmt = $conn1->prepare($sql);
    	$stmt->bindParam(':mime', $mime);
    	$stmt->bindParam(':data1',$blob, PDO::PARAM_LOB);
    	$stmt->execute();
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
	}
}

function get_blobs($conn1)
{
	try
	{
		$sql = "SELECT * FROM files";
		$result = $conn1->query($sql)->fetchAll(PDO::FETCH_UNIQUE);
		return ($result);
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
	}
}
?>