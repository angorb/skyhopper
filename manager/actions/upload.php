<?php
require_once __DIR__ . "/../config.php";

$targetFile = $filesDir . $_FILES['profileTxtFile']['name'];
$targetFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// prevent uploaded files from stomping out existing files
if (file_exists($targetFile)) {
    setSessionMessage(
        "<strong>ERROR:</strong> Could not upload. A file named {$_FILES['profileTxtFile']['name']} already exists.",
        "danger"
    );
    header("Location: " . $_SERVER['HTTP_REFERER'] ?? "../index.php");
    die();
}

// ensure only files we want can be uploaded
if (!in_array($targetFileType, $allowedFileExtensions)) {
    setSessionMessage(
        "<strong>ERROR:</strong> Could not upload. '.{$targetFileType}' files may not be uploaded.",
        "danger"
    );
    header("Location: " . $_SERVER['HTTP_REFERER'] ?? "../index.php");
    die();
}

if (!move_uploaded_file($_FILES["profileTxtFile"]["tmp_name"], $targetFile)) {
    setSessionMessage(
        "<strong>ERROR:</strong> Could not upload. An unexpected error occured.",
        "danger"
    );
    header("Location: " . $_SERVER['HTTP_REFERER'] ?? "../index.php");
    die();
}

// SUCCESS //

$displayFilename = htmlspecialchars(basename($_FILES["profileTxtFile"]["name"]));
setSessionMessage(
    "<strong>SUCCESS:</strong>The file {$displayFilename} has been uploaded.",
    "success"
);
header("Location: " . $_SERVER['HTTP_REFERER'] ?? "../index.php");
die();