<?php
	require_once 'db.php';
	session_start();

	if (isset($_GET['file'], $_GET['name'], $_GET['date_added'], $_GET['added_by'],
	$_GET['time'], $_GET['privacy'], $_GET['password'])) {
		$file = $_GET['file'];
		$name = $_GET['name'];
		$date_added = $_GET['date_added'];
		$added_by = $_GET['added_by'];
		$time = $_GET['time'];
		$privacy = $_GET['privacy'];
		$password = $_GET['password'];

		$sql = $conn->query("SELECT * FROM file WHERE file = '$file' AND name = '$name' AND date_added = '$date_added' AND
		added_by = '$added_by' AND time = '$time' AND privacy = '$privacy' AND password = '$password'");
		$rows = $sql->fetch_assoc();

		if ($rows) {
			$file = $rows["file"];
			$name = $rows["name"];
			$date_added = $rows["date_added"];
			$added_by = $rows["added_by"];
			$time = $rows["time"];
			$privacy = $rows["privacy"];
			$password = $rows["password"];
		} else {
			echo '<script>alert("File not found."); window.location.href = "homepage.php";</script>';
			exit();
		}
	} else {
		echo '<script>alert("Invalid request. Missing parameters."); window.location.href = "homepage.php";</script>';
		exit();
	}

	if (isset($_POST['update'])) {
		$f = $_FILES['file']['name']; 
		$n = $_POST['n'];
		$date = $_POST['date'];
		$add = $_POST['add'];
		$t = $_POST['t'];
		$p = $_POST['p'];
		$pass = $_POST['pass'];

		if ($f) {
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($f);
			move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
		} else {
			$f = $file;
		}

		$result = $conn->query("UPDATE file SET file = '$f', name = '$n', date_added = '$date', added_by = '$add', time = '$t', privacy = '$p', password = '$pass' WHERE file = '$file' AND name = '$name' AND date_added = '$date_added'");

		if ($result) {
			echo '<script type="text/javascript">alert("Success! Your data has been updated!");</script>';
			echo '<script>window.location.assign("homepage.php");</script>';
		} else {
			echo '<script type="text/javascript">alert("Failed! Error updating data, please try again.");</script>';
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Update File</title>
	<style>
		.container { 
			max-width: 600px; 
			margin: 0 auto; 
		}
		
		label { 
			display: block; 
			margin-top: 10px; 
		}
		
		input[type="text"], input[type="date"], input[type="time"], input[type="password"] {
			width: 100%; 
			padding: 8px; 
			margin-top: 5px; 
			border: 1px solid #ccc; 
			border-radius: 4px;
		}
		.update-btn { 
			background-color: #4CAF50; 
			color: white; 
			padding: 10px 15px; 
			border: none; 
			border-radius: 4px; 
			cursor: pointer;
		}
		
		.update-btn:hover { 
			background-color: #45a049; 
		}
	</style>
	
	<script>
		function chooseFile() {
			document.getElementById("file").click();
		}
	</script>
</head>

<body>
	<div class="container">
		<h2>Update File</h2>
		<form method="post" enctype="multipart/form-data">
			<label for="file">Choose New File</label>
			<div id="drop-zone" onclick="chooseFile()" style="padding: 15px; border: 1px dashed #ccc; text-align: center; cursor: pointer;">
				Drag & drop a file here or click to select a file
			</div>
			<input type="file" id="file" name="file" style="display:none;">

			<label for="n">File Name</label>
			<input type="text" name="n" value="<?php echo htmlspecialchars($name); ?>" required>

			<label for="date">Date Added</label>
			<input type="date" name="date" value="<?php echo htmlspecialchars($date_added); ?>" required>

			<label for="add">Added By</label>
			<input type="text" name="add" value="<?php echo htmlspecialchars($added_by); ?>" required>

			<label for="t">Time</label>
			<input type="time" name="t" value="<?php echo htmlspecialchars($time); ?>" required>

			<label for="p">Privacy Setting</label>
			<input type="text" name="p" value="<?php echo htmlspecialchars($privacy); ?>" required>

			<label for="pass">Password</label>
			<input type="password" name="pass" value="<?php echo htmlspecialchars($password); ?>">

			<button type="submit" name="update" class="update-btn">Update</button>
		</form>
	</div>
</body>
</html>
