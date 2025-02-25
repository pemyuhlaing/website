<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["fullname"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $position = htmlspecialchars($_POST["position"]);
    $coverLetter = htmlspecialchars($_POST["coverletter"]);
    $availability = isset($_POST["availability"]) ? $_POST["availability"] : "";

    // Resume Upload
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $resume = $_FILES["resume"];
    $resumePath = $uploadDir . basename($resume["name"]);
    $fileType = strtolower(pathinfo($resumePath, PATHINFO_EXTENSION));

    if ($fileType !== "pdf") {
        die("Only PDF files are allowed.");
    }

    if (move_uploaded_file($resume["tmp_name"], $resumePath)) {
        // Save data to a file
        $file = fopen("applications.txt", "a");
        fwrite($file, "$name | $email | $phone | $position | $availability\n");
        fclose($file);
        echo "Application submitted successfully!";
    } else {
        echo "File upload failed.";
    }
}
?>