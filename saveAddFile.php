<?php
require_once 'db.php';
session_start();

date_default_timezone_set('Asia/Kuala_Lumpur');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // File details
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        
        // Generate a unique file name
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = md5(time() . $fileName) . '.' . strtolower($fileExtension);

        // Upload directory
        $uploadFileDir = './uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }
        $dest_path = $uploadFileDir . $newFileName;

        // Move the file to the upload directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Collect user inputs
            $name = htmlspecialchars(trim($_POST['name']));
            $date_added = date("Y-m-d");
            $time = date("H:i:s");
            $added_by = $_SESSION['user'] ?? 'guest';
            $type = "file";

            // Insert into the database
            $stmt = $conn->prepare("INSERT INTO file (file, name, date_added, added_by, time, type) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $newFileName, $name, $date_added, $added_by, $time, $type);

            if ($stmt->execute()) {
                header("Location: homepage.php");
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error: Could not move the uploaded file.";
        }
    } else {
        echo "Error: File upload failed.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
