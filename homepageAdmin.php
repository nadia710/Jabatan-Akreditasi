<?php
	require_once 'db.php';
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Jabatan Akreditasi</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://kit.fontawesome.com/18f5dc28c3.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<style>
		*{
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}
		
		body {
			font-family: 'Open Sans', sans-serif;
			background-color: #f7f8fc;
			margin: 0;
			padding: 20px;
			color: #333;
		}
		.topbar {
			display: flex;
			justify-content: flex-end;
			margin-bottom: 20px;
		}
		.signout {
			cursor: pointer;
			font-size: 18px;
			color: #555;
			padding: 10px;
			transition: color 0.3s ease;
		}
		.signout:hover {
			color: #e74c3c;
		}
		hr {
			border: none;
			height: 1px;
			background-color: #ddd;
			margin: 20px 0;
		}
		#myInput {
			width: 100%;
			padding: 12px 20px;
			margin: 10px 0;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			font-size: 16px;
			background-color: white;
			transition: border-color 0.3s;
		}
		#myInput:focus {
			border-color: #444;
			outline: none;
		}
		.folderbtn, .addbtn, .sort-dropdown {
			margin-top: 10px;
		}
		.addbtn {
			background-color: #3498db;
			color: white;
			padding: 10px 15px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			transition: background 0.3s ease;
		}
		
		.folderbtn {
			background-color: #3498db;
			color: white;
			padding: 10px 15px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			transition: background 0.3s ease;
		}
		
		.folderbtn:hover, .addbtn:hover {
			background-color: #a0b8ad;
		} 
		.sort-dropdown {
			padding: 10px;
			font-size: 16px;
		}
		table {
			width: 80%;
			justify-content : center;
			align-items : center;
			border-collapse: collapse;
			margin-top: 20px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			background-color: #fff;
			border-radius: 8px;
			overflow: visible;
		}
		th, td {
			padding: 12px 15px;
			text-align: left;
			border-bottom: 1px solid #ddd;
			color: #333;
			position: relative;
		}
		thead th {
			background-color: #f7f7f7;
			color: #34495;
			text-transform: uppercase;
			font-size: 14px;
		}
		tbody tr {
			transition: background 0.3s;
			cursor: pointer;
		}
		tbody tr:hover {
			background-color: #f1f1f1;
		}
		tbody tr:nth-child(even) {
			background-color: #f9f9f9;
		}
		.center-text {
			text-align: center;
			color: #999;
		}
		
		.options {
			position: relative;
		}

		.options-menu {
			display: none;
			position: absolute;
			top: 25px;
			right: 0;
			background-color: #fff;
			border: 1px solid #ddd;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			z-index: 10;
			border-radius: 4px;
			min-width: 120px;
		}

		.options:hover .options-menu {
			display: block;
		}

		.move-wrapper {
			position: relative;
		}

		.move {
			display: none;
			position: absolute;
			top: 0;
			left: 130px;
			background-color: #fff;
			border: 1px solid #ddd;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			z-index: 15;
			border-radius: 4px;
			min-width: 150px;
		}

		.move-wrapper:hover .move {
			display: block;
		}

		.move ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.move ul li {
			padding: 10px 15px;
			background-color: #fff;
			border-bottom: 1px solid #ddd;
			cursor: pointer;
			font-size: 14px;
			color: #555;
		}

		.move ul li:last-child {
			border-bottom: none;
		}

		.move ul li:hover {
			background-color: #f5f5f5;
			color: #333;
		}
		
		.copy-wrapper{
			position: relative;
		}

		.copy{
			display: none;
			position: absolute;
			top: 0;
			left: 130px;
			background-color: #fff;
			border: 1px solid #ddd;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			z-index: 15;
			border-radius: 4px;
			min-width: 150px;
		}

		.copy-wrapper:hover .copy{
			display: block;
		}

		.copy ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.copy ul li{
			padding: 10px 15px;
			background-color: #fff;
			border-bottom: 1px solid #ddd;
			cursor: pointer;
			font-size: 14px;
			color: #555;
		}

		.copy ul li:last-child {
			border-bottom: none;
		}

		.copy ul li:hover {
			background-color: #f5f5f5;
			color: #333;
		}

		.options-menu a {
			display: block;
			padding: 10px 15px;
			color: #555;
			text-decoration: none;
			font-size: 14px;
			transition: background-color 0.3s;
		}

		.options-menu a:hover {
			background-color: #f5f5f5;
			color: #333;
		}

		.tooltip {
			display: none;
			background-color: #555;
			color: #fff;
			padding: 5px;
			border-radius: 5px;
			position: absolute;
			bottom: 130%;
			left: 0;
			z-index: 10;
			font-size: 12px;
			white-space: nowrap;
		}
		td:hover .tooltip {
			display: block;
		}
		
		td a{
			text-decoration : none;
			color : black;
		}
		
		.folderbtn, .addbtn, .sort-dropdown {
			margin-top: 10px;
		}
		.addbtn, .folderbtn {
			background-color: #3498db;
			color: white;
			padding: 10px 15px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			transition: background 0.3s ease;
		}
		.folderbtn:hover, .addbtn:hover {
			background-color: #a0b8ad;
		}
		#folderForm {
			display: none; /* Hide initially */
			margin-top: 20px;
			padding: 15px;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			width: 80%;
			margin-left: auto;
			margin-right: auto;
		}
		#folderForm input[type="text"], #folderForm input[type="submit"] {
			padding: 10px;
			margin: 5px 0;
			width: calc(100% - 22px);
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 16px;
		}
		#folderForm input[type="submit"] {
			background-color: #4c5953;
			color: white;
			cursor: pointer;
			transition: background 0.3s ease;
		}
		#folderForm input[type="submit"]:hover {
			background-color: #a0b8ad;
		}
		
		.file-icon {
			width: 20px;
			height: 20px;
			margin-right: 10px;
			vertical-align: middle;
		}

		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			padding-top: 10%;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0,0,0,0.4);
		}

		.modal-content {
			background-color: #fff;
			margin: auto;
			padding: 20px;
			border: 1px solid #888;
			width: 300px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			text-align: center;
		}

		.close {
			color: #aaa;
			float: right;
			font-size: 20px;
			font-weight: bold;
			cursor: pointer;
		}

		.close:hover,
		.close:focus {
			color: black;
			text-decoration: none;
		}
		
		#drop-zone {
			border: 2px dashed #ccc;
			border-radius: 5px;
			padding: 20px;
			text-align: center;
			margin: 15px 0;
			cursor: pointer;
			color: #aaa;
			font-size: 14px;
			transition: border-color 0.3s ease;
		}

		#drop-zone.dragover {
			border-color: #4CAF50;
			color: #4CAF50;
		}

		label {
			display: block;
			margin-top: 10px;
			font-weight: bold;
		}

		button {
			background-color: #3498db;
			color: white;
			padding: 10px 15px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			font-size: 16px;
			margin-top: 10px;
			transition: background 0.3s ease;
		}

		button:hover {
			background-color: #45a049;
		}

		/* Sidebar */
		.sidebar {
			background: #34495e; /* Darker background for better contrast */
			width: 250px;
			height: 100vh;
			position: fixed;
			left: -250px; /* Sidebar is closed by default */
			top: 0;
			color: #ecf0f1; /* Light text color */
			padding-top: 20px;
			box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
			transition: left 0.3s ease; /* Smooth slide-in effect */
			z-index: 1000; /* Ensure it stays above other content */
		}

		.sidebar.open {
			left: 0; /* Sidebar is visible */
		}

		.sidebar h2 {
			text-align: center;
			margin-bottom: 20px;
			font-size: 24px;
			color: #ecf0f1;
			font-weight: 600; /* Bold font for headings */
		}

		.sidebar ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.sidebar ul li {
			padding: 15px;
			text-align: left;
			transition: background 0.3s ease;
		}

		.sidebar ul li a {
			text-decoration: none;
			color: #ecf0f1; /* Light text color */
			display: block;
			font-size: 18px;
			transition: color 0.3s;
		}

		.sidebar ul li i {
			margin-right: 10px;
		}

		.sidebar ul li:hover {
			background: #1abc9c; /* Highlight background on hover */
		}

		.sidebar ul li a:hover {
			color: #fff; /* Change text color on hover */
		}

		/* Sidebar Toggle Button */
		.sidebar-toggle {
			position: fixed;
			top: 15px;
			left: 15px;
			background: #2c3e50; /* Consistent with sidebar */
			color: #fff;
			border-radius: 50%;
			width: 40px;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
			z-index: 1001; /* Above everything */
			transition: background 0.3s;
		}

		.sidebar-toggle:hover {
			background: #1abc9c; /* Highlight on hover */
		}

		/* Main Content */
		.main-content {
			margin-left: 0; /* Content shifts when sidebar opens */
			padding: 20px;
			background-color: #f4f4f4;
			min-height: 100vh;
			transition: margin-left 0.3s ease;
		}

		.main-content.shifted {
			margin-left: 250px; /* Adjust content margin when sidebar is open */
		}

		/* Topbar */
		.topbar {
			background: #fff;
			padding: 10px;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
			display: flex;
			justify-content: flex-end;
			align-items: center;
		}

		.topbar .signout {
			cursor: pointer;
			color: #333;
			font-weight: bold;
			padding: 10px 15px; /* Add padding for better click area */
			border-radius: 4px; /* Rounded corners */
			transition: background 0.3s, color 0.3s; /* Smooth transitions */
		}

		.topbar .signout:hover {
			background: #e74c3c; /* Highlight background on hover */
			color: #fff; /* Change text color on hover */
		}
	</style>

	<script>
		function confirmLogout() {
			if (confirm("Are you sure you want to log out?")) {
				window.location.href = "login.php";
			}
		}
		
		function myFunction() {
			let input, filter, table, tr, td, i, txtValue;
			input = document.getElementById("myInput");
			filter = input.value.toUpperCase();
			table = document.getElementById("fileTable");
			tr = table.getElementsByTagName("tr");
			
			for (i = 1; i < tr.length; i++){
				td = tr[i].getElementsByTagName("td")[0];
				if(td) {
					txtValue = td.textContent || td.innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = "";
					}
					else {
						tr[i].style.display = "none";
					}
				}
			}
		}

		function sortTable(columnIndex, isDate = false) {
			let table, rows, switching, i, x, y, shouldSwitch, switchCount = 0;
			table = document.getElementById("fileTable");
			switching = true;
			let dir = "asc"; 

			while (switching) {
				switching = false;
				rows = table.rows;
				for (i = 1; i < (rows.length - 1); i++) {
					shouldSwitch = false;
					x = rows[i].getElementsByTagName("TD")[columnIndex];
					y = rows[i + 1].getElementsByTagName("TD")[columnIndex];

					if (isDate) {
						let dateX = new Date(x.innerText.trim());
						let dateY = new Date(y.innerText.trim());

						if (dir === "asc" && dateX > dateY) {
							shouldSwitch = true;
							break;
						} else if (dir === "desc" && dateX < dateY) {
							shouldSwitch = true;
							break;
						}
					} else {
						if (dir === "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
							shouldSwitch = true;
							break;
						} else if (dir === "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
							shouldSwitch = true;
							break;
						}
					}
				}
				if (shouldSwitch) {
					rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					switching = true;
					switchCount++;
				} else {
					if (switchCount === 0 && dir === "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
		}

		function onSortChange() {
			const sortOption = document.getElementById("sortDropdown").value;
			if (sortOption === "name") {
				sortTable(0, false);
			} else if (sortOption === "date") {
				sortTable(1, true);
			}
		}

		document.addEventListener("click", function (e) {
			if (!e.target.closest(".options")) { 
				const row = e.target.closest("tr");
				if (row) {
					const fileUrl = row.getAttribute("data-url");
					if (fileUrl) window.open(fileUrl, "_blank");
				}
			}
		});
		
		function RunFile() {
			WshShell = new ActiveXObject("WScript.Shell");
			WshShell.Run("c:/windows/system32/notepad.exe", 1, false);
		}

		function toggleFolderForm() {
			const folderForm = document.getElementById("folderForm");
			folderForm.style.display = folderForm.style.display === "none" ? "block" : "none";
			
			const privacy = document.getElementById("privacy").value;
			document.getElementById("passwordBox").style.display = (privacy === "private") ? "block" : "none";
		}
		
		document.addEventListener("DOMContentLoaded", () => {
			const deleteButtons = document.querySelectorAll(".delete-btn");

			deleteButtons.forEach(button => {
				button.addEventListener("click", (e) => {
					const fileId = e.target.getAttribute("data-id");
					
					if (confirm("Are you sure you want to delete this file?")) {
						fetch(`deleteFile.php?id=${fileId}`, {
							method: "GET"
						})
						.then(response => response.json())
						.then(data => {
							if (data.status === "success") {
								alert(data.message);
								// Remove the file row dynamically
								const row = e.target.closest("tr");
								row.parentNode.removeChild(row);
							} else {
								alert(data.message);
							}
						})
						.catch(error => {
							console.error("Error:", error);
							alert("Failed to delete the file.");
						});
					}
				});
			});
		});
	
		document.addEventListener("DOMContentLoaded", () => {
			const optionElements = document.querySelectorAll(".options");

			optionElements.forEach(option => {
				option.addEventListener("mouseover", () => {
					const menu = option.querySelector(".options-menu");
					const menuRect = menu.getBoundingClientRect();
					const tableRect = option.closest("table").getBoundingClientRect();

					// Check if the menu goes outside the table bounds
					if (menuRect.right > tableRect.right) {
						option.setAttribute("data-adjust-left", "true");
					} else {
						option.removeAttribute("data-adjust-left");
					}
				});
			});
		});
		
		function showAddFolderPopup() {
			document.getElementById("addFolderModal").style.display = "flex";
		}

		function closeAddFolderPopup() {
			document.getElementById("addFolderModal").style.display = "none";
		}

		// Close modal if clicked outside of it
		window.onclick = function (event) {
			const modal = document.getElementById("addFolderModal");
			if (event.target === modal) {
				closeAddFolderPopup();
			}
		};
		
		function openModal() {
			document.getElementById("addFileModal").style.display = "flex";
		}

		// Close the modal
		function closeModal() {
			document.getElementById("addFileModal").style.display = "none";
		}

		function togglePassword() {
			const privacy = document.getElementById("privacy").value;
			document.getElementById("passwordBox").style.display = (privacy === "private") ? "block" : "none";
		}

		// Form validation before submission
		function validateForm() {
			const privacy = document.getElementById("privacy").value;
			const password = document.getElementById("password").value;

			if (privacy === "private" && password.trim() === "") {
				alert("Please enter a password for private files.");
				return false;
			}
			return true;
		}

		// Drag-and-drop file handling
		document.addEventListener("DOMContentLoaded", function () {
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
		});
		
		function moveFileToFolder(file, folderName) {
			if (!file || !folderName) {
				alert("Invalid file or folder.");
				return;
			}

			fetch('moveToFolder.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: `file=${encodeURIComponent(file)}&name=${encodeURIComponent(folderName)}`
			})
			.then(response => response.json())
			.then(data => {
				if (data.status === "success") {
					alert(data.message);
					location.reload();
				} else {
					alert(data.message);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('An error occurred while moving the file.');
			});
		}
		
		function copyFileToFolder(file, folderName) {
			if (!file || !folderName) {
				alert("Invalid file or folder.");
				return;
			}

			fetch('copyToFolder.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: `file=${encodeURIComponent(file)}&name=${encodeURIComponent(folderName)}`
			})
			.then(response => response.json())
			.then(data => {
				if (data.status === "success") {
					alert(data.message);
					location.reload();
				} else {
					alert(data.message);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('An error occurred while moving the file.');
			});
		}

		document.querySelectorAll('.move-to-folder').forEach((element) => {
			element.addEventListener('mouseover', (e) => {
				const moveMenu = e.target.nextElementSibling;
				if (moveMenu) moveMenu.style.display = 'block';
			});

			element.addEventListener('mouseout', (e) => {
				const moveMenu = e.target.nextElementSibling;
				if (moveMenu) moveMenu.style.display = 'none';
			});
		});

		document.addEventListener('DOMContentLoaded', () => {
			document.querySelectorAll('.delete-btn').forEach(button => {
				button.addEventListener('click', function () {
					const fileName = this.getAttribute('data-id');
					console.log("Deleting file/folder: ", fileName); // Debugging

					// Confirm dialog
					if (confirm("Are you sure you want to delete this?")) {
						fetch('deleteFile.php', {
							method: 'POST',
							headers: { 'Content-Type': 'application/json' },
							body: JSON.stringify({ name: fileName })
						})
						.then(response => response.json())
						.then(data => {
							alert(data.message); // Display success or failure message
							if (data.status === 'success') {
								location.reload(); // Refresh the page on success
							}
						})
					} else {
						console.log("Deletion canceled");
						// Optionally, you can add an alert or log message for cancellation here if needed
					}
				});
			});
		});
		
		function toggleSidebar() {
			const sidebar = document.getElementById("sidebar");
			const mainContent = document.getElementById("mainContent");
			
			// Toggle the "open" class for the sidebar
			sidebar.classList.toggle("open");
			
			// Adjust main content margin
			mainContent.classList.toggle("shifted");
		}
	</script>
</head>

<body>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for a file...">
    <center>
        <button class="addbtn" onclick="openModal()">Add New File</button>
		<button class = "folderbtn" onclick = "showAddFolderPopup()">Add New Folder</button>
        <select id="sortDropdown" class="sort-dropdown" onchange="onSortChange()">
            <option value="name">Sort by Name</option>
            <option value="date">Sort by Date Added</option>
        </select>
    </center>
	
	<div id="addFileModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 1000;">
		<div class="form" style="position: relative; width: 100%; max-width: 400px; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
			<span onclick="closeModal()" style="position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 20px; color: #888;">&times;</span>
			<form action="saveAddFile.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
				<label for="file">Choose File</label>
				<div id="drop-zone">Drag & drop a file here or click to select a file</div>
				<input type="file" id="file" name="file" style="display:none;" required>
				
				<label for="name">Name:</label>
				<input type="text" id="name" name="name" required>

				<button type="submit">Submit</button>
			</form>
		</div>
	</div>

	<div id="addFolderModal" class="modal" style="display: none;">
		<div class="modal-content">
			<span class="close" onclick="closeAddFolderPopup()">&times;</span>
			<form action="saveAddFolder.php" method="POST" id="addFolderForm">
				<h3>Create New Folder</h3>
				<label for="folderName">Folder Name:</label>
				<input type="text" id="folderName" name="name" required>
				
				<button type="submit" class="addbtn">Create Folder</button>
			</form>
		</div>
	</div>
	
	<!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>My File Manager</h2>
        <ul>
            <li><a href="homepageAdmin.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="admin.php"><i class="fa fa-clock-o"></i> Last Update</a></li>
            <li><a href="admin2.php"><i class="fa fa-user"></i> Last Login</a></li>
            <li onclick="confirmLogout()"><i class="fa fa-sign-out"></i> Logout</li>
        </ul>
    </div>

    <!-- Sidebar Toggle Button -->
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </div>

    <div class="table">
        <center>
            <table id="fileTable">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>DATE ADDED</th>
						<th> </th>
                    </tr>
                </thead>
                <tbody>
					<?php
					$sql = "SELECT DISTINCT * FROM file ORDER BY name ASC";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$name = htmlspecialchars($row['name']);
							$date_added = htmlspecialchars($row['date_added']);
							$file = htmlspecialchars($row['file']);
							$type = $row['type'];
							$file_path = "uploads/" . htmlspecialchars($file);
							$added_by = htmlspecialchars($row['added_by']);
							$time = htmlspecialchars($row['time']);
							
							// Determine icon
							$ext = pathinfo($file, PATHINFO_EXTENSION);
							$icon_url = "unknown.png";
							$icons = [
								'docx' => 'docx.png',
								'pdf' => 'pdf.png',
								'pptx' => 'pptx.png',
								'xlsx' => 'xlsx.png',
							];
							$icon_url = $type === 'folder' ? 'folder.png' : ($icons[$ext] ?? $icon_url);
							?>
							<tr 
								data-url="<?php echo ($type === 'folder') ? 'folder.php?folder=' . urlencode($name) : $file_path; ?>" 
								class="file-row"
								data-added-by="<?php echo $added_by; ?>" 
								data-time="<?php echo $time; ?>">
								<td>
									<img src="<?php echo htmlspecialchars($icon_url); ?>" alt="File Icon" class="file-icon">
									<a href="javascript:void(0)" 
									   onclick="handleFileClick('<?php echo $file_path; ?>', '<?php echo $privacy; ?>', '<?php echo addslashes($password); ?>')">
										<?php echo htmlspecialchars($name); ?>
									</a>
								</td>
								<td><?php echo $date_added; ?></td>
								<td>
									<div class="options">
										<img src="dots.webp" style="width: 18px; height: 18px">
										<div class="options-menu">
											<a href="javascript:void(0)" 
											   data-id="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" 
											   class="delete-btn">Delete
											</a>
											<div class="move-wrapper">
												<a href="javascript:void(0)" class="move-to-folder">Move To Folder</a>
												<div class="move">
													<ul>
														<?php
														$sql2 = "SELECT DISTINCT name FROM file WHERE type = 'folder'";
														$result2 = $conn->query($sql2);

														if ($result2 && $result2->num_rows > 0) {
															while ($row2 = $result2->fetch_assoc()) {
																$folderName = htmlspecialchars($row2['name']);
																echo '<li><a href="javascript:void(0);" onclick="moveFileToFolder(\'' . addslashes($file) . '\', \'' . addslashes($folderName) . '\')">' . $folderName . '</a></li>';
															}
														} else {
															echo '<li>No Folders Available</li>';
														}
														?>
													</ul>
												</div>
											</div>
											<div class="copy-wrapper">
												<a href="javascript:void(0)" class="copy-to-folder">Copy To Folder</a>
												<div class="copy">
													<ul>
														<?php
														$sql3 = "SELECT DISTINCT name FROM file WHERE type = 'folder'";
														$result3 = $conn->query($sql3);

														if ($result3 && $result3->num_rows > 0) {
															while ($row3 = $result3->fetch_assoc()) {
																$folderName = htmlspecialchars($row3['name']);
																echo '<li><a href="javascript:void(0);" onclick="copyFileToFolder(\'' . addslashes($file) . '\', \'' . addslashes($folderName) . '\')">' . $folderName . '</a></li>';
															}
														} else {
															echo '<li>No Folders Available</li>';
														}
														?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<?php
						}
					} else {
						echo "<tr><td colspan='3' class='center-text'>No files found</td></tr>";
					}
					?>
				</tbody>

				<script>
					// Display additional details on hover
					document.querySelectorAll('.file-row').forEach(row => {
						row.addEventListener('mouseover', function () {
							const addedBy = this.getAttribute('data-added-by');
							const time = this.getAttribute('data-time');
							this.setAttribute('title', `Added by ${addedBy} at ${time}`);
						});
					});
				</script>
			</table>
        </center>
    </div>
</body>
</html>