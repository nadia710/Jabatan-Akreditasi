<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['name'])) {
        $fileName = $input['name']; // Directly use the name without sanitizing for this case

        // Check if the file exists in the database using the name
        $stmt = $conn->prepare("SELECT * FROM folder WHERE name = ?");
        if ($stmt) {
            $stmt->bind_param("s", $fileName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Record exists, proceed to delete it from the database
                $deleteStmt = $conn->prepare("DELETE FROM folder WHERE name = ?");
                if ($deleteStmt) {
                    $deleteStmt->bind_param("s", $fileName);
                    $deleteStmt->execute();
                    $response = ['status' => 'success', 'message' => 'Successfully deleted from database.'];
                    $deleteStmt->close();
                }
			}
		}
	}
}

header('Content-Type: application/json');
echo json_encode($response);
?>
