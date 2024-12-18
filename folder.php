<?php
require_once 'db.php';
session_start();

$folderName = isset($_GET['folder']) ? $_GET['folder'] : '';
$parentFolder = isset($_GET['parent']) ? $_GET['parent'] : '';

// Determine the homepage link based on user password
$homepageLink = 'homepage.php'; // Default for staff
if (isset($_SESSION['password'])) {
    if ($_SESSION['password'] === 'admin') {
        $homepageLink = 'homepageAdmin.php'; // For admin
    } elseif ($_SESSION['password'] === 'jabatan') {
        $homepageLink = 'homepage.php'; // For staff
    }
}

if (empty($folderName)) {
    echo "<h1>Please select a folder to view its contents.</h1>";
    exit;
}

// Build the breadcrumb
$breadcrumb = "<h2><a href='{$homepageLink}'>HOMEPAGE</a></h2>";
if ($parentFolder) {
    $breadcrumb .= "<h2> > <a href='folder.php?folder=" . urlencode($parentFolder) . "'>" . htmlspecialchars($parentFolder) . "</a></h2>";
}
$breadcrumb .= "<h2> > " . htmlspecialchars($folderName) . "</h2>";
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
				margin: 0;
				padding: 0;
				background-color: #f9f9f9;
				color: #333;
			}

			.container {
				width: 80%;
				max-width: 1200px;
				margin: 30px auto;
				background: #fff;
				border-radius: 8px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				padding: 20px;
			}

			h1, h2 {
				font-weight: 600;
				color: #2c3e50;
			}

			h1 {
				text-align: center;
				color: #3498db;
				margin-bottom: 20px;
			}

			.actions {
				display: flex;
				flex-direction: row;
				gap: 20px;
				justify-content: flex-start;
				align-items: center;
				margin-bottom: 20px;
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

			input[type="text"] {
				width: 300px;
				padding: 10px;
				border: 1px solid #ccc;
				border-radius: 4px;
				font-size: 14px;
				box-sizing: border-box;
				transition: border 0.3s ease;
			}

			input[type="text"]:focus {
				border-color: #3498db;
				outline: none;
			}

			.actions .addbtn{
				padding: 10px 20px;
				background-color: #3498db;
				color: white;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				font-size: 16px;
				transition: background 0.3s ease;
			}

			.actions .addbtn:hover{
				background-color: #2980b9;
			}

			.sort-dropdown {
				padding: 10px;
				border: 1px solid #ccc;
				border-radius: 4px;
			}

			table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
			}

			table th, table td {
				padding: 15px;
				text-align: left;
				border-bottom: 1px solid #ddd;
			}

			table th {
				background-color: #f7f7f7;
				font-weight: 600;
				color: #34495e;
			}

			table tr:hover {
				background-color: #f1f1f1;
			}

			table td img {
				width: 20px;
				margin-right: 10px;
			}

			.options img {
				cursor: pointer;
			}

			.options-menu {
				display: none;
				position: absolute;
				background: #fff;
				border: 1px solid #ccc;
				box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
				border-radius: 5px;
				z-index: 10;
				padding: 10px;
				width: 120px;
			}

			.options:hover .options-menu {
				display: block;
			}

			.options-menu a {
				text-decoration: none;
				color: #34495e;
				display: block;
				padding: 8px 12px;
				font-size: 14px;
				border-radius: 4px;
			}

			.options-menu a:hover {
				background-color: #f7f7f7;
				color: #3498db;
			}

			.modal, .folder {
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background-color: rgba(0, 0, 0, 0.5);
				justify-content: center;
				align-items: center;
				z-index: 1000;
			}

			.modal-content, .folder-content {
				background-color: #fff;
				padding: 30px;
				border-radius: 8px;
				box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
				width: 100%;
				max-width: 450px;
				text-align: center;
			}

			.modal-content h2, .folder-content h2 {
				margin-bottom: 20px;
				color: #2c3e50;
				font-weight: 600;
			}

			.modal-content input, .modal-content button, .folder-content input, .folder-content button {
				width: 100%;
				padding: 12px;
				margin: 10px 0;
				border: 1px solid #ccc;
				border-radius: 4px;
				font-size: 14px;
			}

			.modal-content button, .folder-content button {
				background-color: #3498db;
				color: white;
				border: none;
				cursor: pointer;
				transition: background 0.3s ease;
			}

			.modal-content button:hover, .folder-content button:hover {
				background-color: #2980b9;
			}

			.close {
				position: absolute;
				top: 10px;
				right: 15px;
				font-size: 20px;
				font-weight: bold;
				color: #aaa;
				cursor: pointer;
			}

			.close:hover {
				color: #333;
			}

			.before {
				display: flex;
				align-items: center;
				gap: 15px;
				margin-bottom: 15px;
			}

			.before h2 {
				margin: 0;
				font-size: 18px;
				font-weight: 600;
			}

			.before a {
				text-decoration: none;
				color: #3498db;
			}

			.before a:hover {
				text-decoration: underline;
			}
        </style>
        <script>
            // Show the modal
            function showModal() {
                document.getElementById('fileModal').style.display = 'flex';
            }
			
			function showFolder() {
				document.getElementById('folderModal').style.display = 'flex';
			}

            // Hide the modal
            function closeModal() {
                document.getElementById('fileModal').style.display = 'none';
            }
			
			function closeFolder() {
				document.getElementById('folderModal').style.display = 'none';
			}
			
			window.addEventListener('click', function(event) {
				const modal = document.getElementById('fileModal');
				if (event.target === modal) {
					modal.style.display = 'none';
				}
			});
			
			window.addEventListener('click', function(event) {
				const modal = document.getElementById('folderModal');
				if (event.target === modal) {
					modal.style.display = 'none';
				}
			});
			
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
			
			function history_back(){
				window.history.back();
			}
			
			document.addEventListener('DOMContentLoaded', () => {
			document.querySelectorAll('.delete-btn').forEach(button => {
				button.addEventListener('click', function () {
					const fileName = this.getAttribute('data-id');
					console.log("Deleting file/folder: ", fileName); // Debugging

					// Confirm dialog
					if (confirm("Are you sure you want to delete this?")) {
						fetch('deleteFileFolder.php', {
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
        </script>
    </head>
    
    <body>
    <div class="container">
        <div class="before">
            <?php echo $breadcrumb; ?>
        </div>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for a file...">
        
        <div class="actions">
            <button class="addbtn" onclick="showModal()">Add New File</button> 
            <button class="addbtn" onclick="showFolder()">Add New Folder</button>
            
            <select id="sortDropdown" class="sort-dropdown" onchange="onSortChange()">
                <option value="name">Sort by Name</option>
                <option value="date">Sort by Date Added</option>
            </select>
        </div>
        
        <div>
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
                        $sql = "SELECT DISTINCT name, date_added, file, added_by, type, foldername 
                                FROM folder 
                                WHERE foldername = '" . $conn->real_escape_string($folderName) . "' 
                                ORDER BY name ASC";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $name = htmlspecialchars($row['name']);
                                $date_added = htmlspecialchars($row['date_added']);
                                $file = htmlspecialchars($row['file']);
                                $type = htmlspecialchars($row['type']);
                                $foldername = htmlspecialchars($row['foldername']);
                                
                                $ext = pathinfo($file, PATHINFO_EXTENSION);
                                
                                $icon_url = "unknown.png";
                                $icons = [
                                    'docx' => 'docx.png',
                                    'pdf' => 'pdf.png',
                                    'pptx' => 'pptx.png',
                                    'xlsx' => 'xlsx.png',
                                ];
                                $icon_url = $type === 'folder' ? 'folder.png' : ($icons[$ext] ?? $icon_url);
                                
                                echo "<tr data-url='" . (($type === 'folder') ? 'folder.php?folder=' . urlencode($name) . '&parent=' . urlencode($folderName) : $file) . "'>";
                                echo "<td><img src='{$icon_url}' alt='Icon'><a href='" . (($type === 'folder') ? 'folder.php?folder=' . urlencode($name) . '&parent=' . urlencode($folderName) : 'viewFile.php?file=' . urlencode($file)) . "' style='color: black; text-decoration: none;'>{$name}</a></td>";
                                echo "<td>{$date_added}</td>";
                                echo "<td>
									<div class='options'> 
										<img src='dots.webp' alt='Options'>
										<div class='options-menu'>
											<a href='javascript:void(0)' 
											   data-id='" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "' 
											   class='delete-btn'>Delete
											</a>
										</div>
									</div>
								  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' style='text-align:center;'>No files found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </center>
        </div>
    </div>

    <div id="fileModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add New File</h2>
            <form action="saveFileFolder.php?folder=<?php echo urlencode($folderName); ?>" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="File Name" required>
                <input type="file" name="file" required>
                <input type="hidden" name="foldername" value="<?php echo htmlspecialchars($folderName); ?>">
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
    
    <div id="folderModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeFolder()">&times;</span>
            <h2>Add New Folder</h2>
            <form action="saveFolderFolder.php?folder=<?php echo urlencode($folderName); ?>" method="POST">
                <input type="text" name="name" placeholder="Folder Name" required>
                <input type="hidden" name="foldername" value="<?php echo htmlspecialchars($folderName); ?>">
                <button type="submit">Create Folder</button>
            </form>
        </div>
    </div>
</body>
</html>
