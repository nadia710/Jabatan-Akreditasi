<?php
require_once 'db.php';
session_start();

date_default_timezone_set('Asia/Kuala_Lumpur');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        
        // Validate and sanitize inputs
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'xlsx', 'pptx'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "<script>alert('Invalid file type. Allowed types: " . implode(", ", $allowedExtensions) . "');</script>";
            echo "<script>window.history.back();</script>";
            exit;
        }

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './uploads/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }
        
        $destPath = $uploadFileDir . $newFileName;
        
        // Attempt to move the uploaded file
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Handle folder name
            $foldername = isset($_GET['folder']) && !empty($_GET['folder']) ? $_GET['folder'] : 'root'; // Default to 'root'
            $foldername = htmlspecialchars($foldername, ENT_QUOTES, 'UTF-8'); // Sanitize folder name
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); // Sanitize file name input
            $date_added = date("Y-m-d");
            $added_by = isset($_SESSION['user']) ? $_SESSION['user'] : 'unknown'; // Default to 'unknown' if not logged in
            $time = date("H:i:s");
            $type = "file";

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO folder (file, foldername, name, date_added, added_by, time, type) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $newFileName, $foldername, $name, $date_added, $added_by, $time, $type);

            if ($stmt->execute()) {
                echo "<script>alert('File successfully added');</script>";
                echo "<script>window.location.assign('folder.php?folder=" . urlencode($foldername) . "');</script>";
            } else {
                echo "Error inserting into database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "<script>alert('Error moving the file to the upload directory. Please try again.');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        // Handle file upload error
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by a PHP extension.'
        ];

        $error = $_FILES['file']['error'];
        $errorMessage = isset($uploadErrors[$error]) ? $uploadErrors[$error] : 'Unknown error during file upload.';
        echo "<script>alert('File upload error: {$errorMessage}');</script>";
        echo "<script>window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method.');</script>";
    echo "<script>window.history.back();</script>";
}

$conn->close();
?>