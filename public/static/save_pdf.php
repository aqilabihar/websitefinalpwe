<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a PDF file is uploaded
    if (isset($_FILES['pdfFile'])) {
        $targetDir = "uploads/"; // Folder to save the file
        $targetFile = $targetDir . basename($_FILES["pdfFile"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is a PDF
        if ($fileType != "pdf") {
            echo "Only PDF files are allowed.";
            $uploadOk = 0;
        }

        // Check if everything is okay before uploading
        if ($uploadOk == 1) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
                echo "The PDF file has been uploaded successfully.";
            } else {
                echo "There was an error uploading the file.";
            }
        }
    } else {
        echo "No file was uploaded.";
    }
} else {
    echo "Invalid request.";
}
