<?php
require_once __DIR__ . "/../config.php";
session_destroy();
setSessionMessage(
    "<strong>SUCCESS:</strong>Your current session has been destroyed.",
    "success"
);
header("Location: ../index.php");
die();