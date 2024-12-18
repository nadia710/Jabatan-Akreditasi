<?php
require_once 'db.php';

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = "uploads/" . $file;
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    if (file_exists($filePath)) {
        if (in_array($extension, ['docx', 'xlsx', 'pptx'])) {
            // Replace 'localhost' with a publicly accessible domain if possible
            $fileUrl = "http://localhost/uploads/" . rawurlencode($file);
            echo "
            <html>
            <body style='margin: 0; padding: 0;'>
                <iframe 
                    src='https://docs.google.com/gview?url=$fileUrl&embedded=true' 
                    style='width: 100%; height: 100vh; border: none;'>
                </iframe>
            </body>
            </html>";
            exit;
        } elseif (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'html'])) {
            $mimeType = mime_content_type($filePath);
            header("Content-Type: $mimeType");
            header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
            header("Content-Length: " . filesize($filePath));
            readfile($filePath);
        }
		} else {
        http_response_code(404);
        echo "File not found.";
    }
} else {
    http_response_code(400);
    echo "No file specified.";
}
?>
