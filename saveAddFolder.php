<?php
	require_once 'db.php';
	session_start();

	date_default_timezone_set('Asia/Kuala_Lumpur');

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
		$name = $conn->real_escape_string($_POST['name']);
		$date_added = date("Y-m-d");
		$added_by = isset($_SESSION['user']) ? $_SESSION['user'] : "Guest"; // Fallback to Guest if user session is missing
		$time = date("H:i:s");
		$type = "folder";

		$sql = "INSERT INTO file (name, date_added, added_by, time, type) 
				VALUES ('$name', '$date_added', '$added_by', '$time', '$type')";

		if ($conn->query($sql) === TRUE) {
			echo "<script>alert('Folder successfully added');</script>";
			echo "<script>window.location.assign('homepage.php');</script>";
		} else {
			echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
		}
	} else {
		echo json_encode(["status" => "error", "message" => "Invalid request."]);
	}

	$conn->close();
?>
