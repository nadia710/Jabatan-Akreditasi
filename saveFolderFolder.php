<?php
	require_once 'db.php';
	session_start();

	date_default_timezone_set('Asia/Kuala_Lumpur');

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
		$foldername = isset($_GET['folder']) && !empty($_GET['folder']) ? $_GET['folder'] : 'root'; // Default to 'root'
        $foldername = htmlspecialchars($foldername, ENT_QUOTES, 'UTF-8'); // Sanitize folder name
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); // Sanitize file name input
        $date_added = date("Y-m-d");
        $added_by = isset($_SESSION['user']) ? $_SESSION['user'] : 'unknown'; // Default to 'unknown' if not logged in
        $time = date("H:i:s");
        $type = "folder";

		$sql = "INSERT INTO folder (foldername, name, date_added, added_by, time, type) 
				VALUES ('$foldername', '$name', '$date_added', '$added_by', '$time', '$type')";

		if ($conn->query($sql) === TRUE) {
			echo "<script>alert('Folder successfully added');</script>";
			echo "<script>window.location.assign('folder.php');</script>";
		} else {
			echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
		}
	} else {
		echo json_encode(["status" => "error", "message" => "Invalid request."]);
	}

	$conn->close();
?>
