<?php
require_once 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add File</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://kit.fontawesome.com/18f5dc28c3.js" crossorigin="anonymous"></script>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f9;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
		}
		
		.form {
			background: #fff;
			padding: 30px;
			border-radius: 8px;
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
			width: 100%;
			max-width: 400px;
		}
		
		#drop-zone {
			border: 2px dashed #ddd;
			border-radius: 5px;
			padding: 20px;
			text-align: center;
			margin-bottom: 15px;
			cursor: pointer;
			color: #aaa;
			font-size: 14px;
			transition: border-color 0.3s ease;
		}
		
		#drop-zone.dragover {
			border-color: #4CAF50;
			color: #4CAF50;
		}
	</style>
</head>
<body onload="togglePassword()">
	<div class="form">
		<form action="saveAddFile.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
			<label for="file">Choose File</label>
			<div id="drop-zone">Drag & drop a file here or click to select a file</div>
			<input type="file" id="file" name="file" style="display:none;" required>
			
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" required>
			<br>
			<label for="privacy">Select Privacy:</label>
			<select id="privacy" name="privacy" onchange="togglePassword()" required>
				<option value="public">Public</option>
				<option value="private">Private</option>
			</select>
			
			<div id="passwordBox" style="display:none;">
				<label for="password">Enter Password:</label>
				<input type="password" id="password" name="password">
			</div>
			
			<br><br>
			<button type="submit">Submit</button>
			<button type="button" onclick="window.location.href='homepage.php'">Back to Homepage</button>
		</form>
	</div>
	
	<script>
		function togglePassword() {
			const privacy = document.getElementById("privacy").value;
			document.getElementById("passwordBox").style.display = (privacy === "private") ? "block" : "none";
		}

		function validateForm() {
			const privacy = document.getElementById("privacy").value;
			const password = document.getElementById("password").value;

			if (privacy === "private" && password.trim() === "") {
				alert("Please enter a password for private files.");
				return false;
			}
			return true;
		}

		const dropZone = document.getElementById("drop-zone");
		const fileInput = document.getElementById("file");
		
		dropZone.addEventListener("click", () => {
			fileInput.click();
		});

		dropZone.addEventListener("dragover", (e) => {
			e.preventDefault();
			dropZone.classList.add("dragover");
		});

		dropZone.addEventListener("dragleave", () => {
			dropZone.classList.remove("dragover");
		});

		dropZone.addEventListener("drop", (e) => {
			e.preventDefault();
			dropZone.classList.remove("dragover");

			const files = e.dataTransfer.files;
			if (files.length > 0) {
				fileInput.files = files;
				dropZone.textContent = files[0].name;
			}
		});

		fileInput.addEventListener("change", () => {
			if (fileInput.files.length > 0) {
				dropZone.textContent = fileInput.files[0].name;
			}
		});
	</script>
</body>
</html>
