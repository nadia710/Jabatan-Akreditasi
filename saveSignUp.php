<?php
	require_once 'db.php';
	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if (!isset($_POST['user'], $_POST['password'], $_POST['confirm'])) {
			echo "<script>alert('Please fill in all required fields.');</script>";
			echo "<script>window.location.assign('signUp.php');</script>";
			exit;
		}

		$user = $_POST['user'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];

		if ($password !== $confirm) {
			echo "<script>alert('Passwords do not match!');</script>";
			echo "<script>window.location.assign('signUp.php');</script>";
		} 
		else if ($password !== "jabatan" && $password !== "admin") {
			echo "<script>alert('You are not authorized to sign up!');</script>";
			echo "<script>window.location.assign('signUp.php');</script>";
		}
		else if ($password === "admin") {
			$stmt = $conn->prepare("SELECT * FROM users WHERE user = ?");
			$stmt->bind_param("s", $user);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				echo "<script>alert('Username already exists!');</script>";
				echo "<script>window.location.assign('signUp.php');</script>";
			} 
			else {
				$stmt = $conn->prepare("INSERT INTO users (user, password) VALUES (?, ?)");
				$stmt->bind_param("ss", $user, $password);

				if ($stmt->execute()) {
					echo "<script>alert('Sign up successful!');</script>";
					echo "<script>window.location.assign('login.php');</script>";
				} 
				else {
					echo "<script>alert('There was an error signing up.');</script>";
				}
			}
		}
		else {
			$stmt = $conn->prepare("SELECT * FROM users WHERE user = ?");
			$stmt->bind_param("s", $user);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				echo "<script>alert('Username already exists!');</script>";
				echo "<script>window.location.assign('signUp.php');</script>";
			} 
			else {
				$stmt = $conn->prepare("INSERT INTO users (user, password) VALUES (?, ?)");
				$stmt->bind_param("ss", $user, $password);

				if ($stmt->execute()) {
					echo "<script>alert('Sign up successful!');</script>";
					echo "<script>window.location.assign('login.php');</script>";
				} 
				else {
					echo "<script>alert('There was an error signing up.');</script>";
				}
			}

			$stmt->close();
		}
		$conn->close();
	}
?>
