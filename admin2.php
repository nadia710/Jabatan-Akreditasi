<?php	
	require_once 'db.php';
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://kit.fontawesome.com/18f5dc28c3.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<title>Admin Dashboard</title>
	<style>
		/* General Styling */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			display: flex;
			background-color: #f4f4f9; /* Matches dashboard background */
			height: 100vh;
			overflow: hidden;
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

		/* Content Section */
		.content {
			flex: 1;
			padding: 20px;
			overflow-y: auto;
			background-color: #f4f4f9;
		}

		.content h1 {
			color: #333;
			margin-bottom: 20px;
			text-align: center;
			font-size: 2rem;
		}

		/* Table Styling */
		table {
			width: 100%;
			border-collapse: collapse;
			background-color: #fff;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			border-radius: 8px;
			overflow: hidden;
		}

		th, td {
			padding: 12px;
			text-align: center;
			border-bottom: 1px solid #ddd;
		}

		th {
			background-color: #c9c7c7;
			color: white;
			font-weight: bold;
		}

		tr:nth-child(even) {
			background-color: #f9f9f9;
		}

		tr:hover {
			background-color: #f1f1f1;
		}

		a.table-link {
			color: #007BFF;
			text-decoration: none;
			font-weight: bold;
			transition: color 0.3s;
		}

		a.table-link:hover {
			color: #0056b3;
		}
	</style>
</head>
<body>
	<div class="sidebar" id="sidebar">
        <h2>My File Manager</h2>
        <ul>
            <li><a href="homepageAdmin.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="admin.php"><i class="fa fa-clock-o"></i> Last Update</a></li>
            <li><a href="admin2.php"><i class="fa fa-user"></i> Last Login</a></li>
            <li onclick="confirmLogout()"><i class="fa fa-sign-out">Logout</a></li>
        </ul>
    </div>

    <!-- Sidebar Toggle Button -->
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </div>

	<!-- Main Content -->
	<div class="content">
		<h1>Admin Dashboard</h1>
		
		<table>
			<thead>
				<tr>
					<th>USERNAME</th>
					<th>LAST LOGIN</th>
				</tr>
			</thead>
			<tbody>
				<?php	
					$sql = "SELECT user, last_login FROM users ORDER BY last_login DESC";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$user = $row['user'];
							$last_login = $row['last_login'];
							$last_login_display = $last_login ? $last_login : "Never";
							?>
							<tr>
								<td><?php echo htmlspecialchars($user); ?></td>
								<td><?php echo htmlspecialchars($last_login_display); ?></td>
							</tr>
							<?php
						}
					} 
					else {
						?>
						<tr>
							<td colspan="2">No users found.</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</div>

	<script>
		// Sidebar toggle function
		const sidebar = document.getElementById('sidebar');
		function toggleSidebar() {
			sidebar.classList.toggle('open');
		}
		
		function confirmLogout() {
			if (confirm("Are you sure you want to log out?")) {
				window.location.href = "login.php";
			}
		}
	</script>
</body>
</html>
