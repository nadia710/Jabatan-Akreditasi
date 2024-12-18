<?php
require_once 'db.php';
session_start();

header('Content-Type: application/json');

// Validate POST parameters
if (!isset($_POST['file'], $_POST['name'])) {
    echo json_encode([
        "status" => "error",
        "message" => "File and folder name are required."
    ]);
    exit;
}

$fileLink = $_POST['file'];
$folderName = $_POST['name'];

try {
    // 1. Check if the file exists in 'file' table
    $fileCheckStmt = $conn->prepare("SELECT * FROM file WHERE file = ?");
    $fileCheckStmt->bind_param("s", $fileLink);
    $fileCheckStmt->execute();
    $fileResult = $fileCheckStmt->get_result();

    if ($fileResult->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "The specified file does not exist."
        ]);
        exit;
    }

    $fileData = $fileResult->fetch_assoc();
    $originalFileName = $fileData['name']; // Original file name
    $addedBy = $_SESSION['username'] ?? 'unknown'; // User who moved the file

    // 2. Check if the folder exists in the 'folder' table
    $folderCheckStmt = $conn->prepare("SELECT * FROM file WHERE name = ?");
    $folderCheckStmt->bind_param("s", $folderName);
    $folderCheckStmt->execute();
    $folderResult = $folderCheckStmt->get_result();

    if ($folderResult->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "The specified folder does not exist."
        ]);
        exit;
    }

    // 3. Insert the file into the 'folder' table with its original name
    $insertStmt = $conn->prepare("INSERT INTO folder (foldername, name, file, date_added, added_by, time, type) 
                                  VALUES (?, ?, ?, NOW(), ?, NOW(), 'file')");
    $insertStmt->bind_param("ssss", $folderName, $originalFileName, $fileLink, $addedBy);
    $insertStmt->execute();

    // 4. Check if insertion was successful
    if ($insertStmt->affected_rows > 0) {
        // 5. Delete the file from the 'file' table
        $deleteStmt = $conn->prepare("DELETE FROM file WHERE file = ?");
        $deleteStmt->bind_param("s", $fileLink);
        $deleteStmt->execute();

        if ($deleteStmt->affected_rows > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "File successfully moved to folder: " . htmlspecialchars($folderName)
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "File moved but could not be deleted from the original table."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to move the file into the folder."
        ]);
    }

    // Close statements
    $fileCheckStmt->close();
    $folderCheckStmt->close();
    $insertStmt->close();
    $deleteStmt->close();

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred: " . $e->getMessage()
    ]);
}

// Close database connection
$conn->close();
?>
