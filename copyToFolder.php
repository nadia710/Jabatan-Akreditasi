<?php
require_once 'db.php';
session_start();

header('Content-Type: application/json');

// Validate input
if (!isset($_POST['file'], $_POST['name'])) {
    echo json_encode(["status" => "error", "message" => "File and folder name are required."]);
    exit;
}

$fileLink = trim($_POST['file']);
$folderName = trim($_POST['name']);

try {
    // Check if file exists
    $fileCheckStmt = $conn->prepare("SELECT * FROM file WHERE file = ?");
    if (!$fileCheckStmt) {
        throw new Exception("File query preparation failed: " . $conn->error);
    }
    $fileCheckStmt->bind_param("s", $fileLink);
    $fileCheckStmt->execute();
    $fileResult = $fileCheckStmt->get_result();

    if ($fileResult->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "The specified file does not exist."]);
        exit;
    }

    $fileData = $fileResult->fetch_assoc();
    $originalFileName = $fileData['name'];
    $addedBy = $_SESSION['username'] ?? 'unknown';

    // Check if folder exists
    $folderCheckStmt = $conn->prepare("SELECT * FROM file WHERE name = ?");
    if (!$folderCheckStmt) {
        throw new Exception("Folder query preparation failed: " . $conn->error);
    }
    $folderCheckStmt->bind_param("s", $folderName);
    $folderCheckStmt->execute();
    $folderResult = $folderCheckStmt->get_result();

    if ($folderResult->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "The specified folder does not exist."]);
        exit;
    }

    // Insert a copy of the file into the folder table
    $insertStmt = $conn->prepare(
        "INSERT INTO folder (folderName, file, name, date_added, added_by) 
         VALUES (?, ?, ?, NOW(), ?)"
    );
    if (!$insertStmt) {
        throw new Exception("Insert query preparation failed: " . $conn->error);
    }

    $insertStmt->bind_param("ssss", $folderName, $fileLink, $originalFileName, $addedBy);
    $insertStmt->execute();

    if ($insertStmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "File successfully copied to folder: " . htmlspecialchars($folderName)]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to copy the file into the folder."]);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
