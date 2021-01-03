<pre>
<?php
require_once __DIR__ . "/../config.php";
print_r($_REQUEST);

print_r($_FILES);

// prevent uploaded files from stomping out existing files
$uploadedFiles = array_map('basename', glob($filesDir . "/*.txt"));
print_r($uploadedFiles);
if (in_array($_FILES['file']['name'], $uploadedFiles)) {
    setSessionMessage(
        "<strong>ERROR:</strong> Could not upload. A file named {$_FILES['file']['name']} alreday exists.",
        "danger"
    );
    header("Location: " . $_SERVER['HTTP_REFERER'] ?? "../index.php");
    die();
}