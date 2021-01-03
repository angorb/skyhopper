<?php
// ** SETTINGS ** //

use Angorb\BetaflightProfiler\Reader;

session_start();
date_default_timezone_set('MST'); // TODO
require_once __DIR__ . "/../vendor/autoload.php";
$filesDir = __DIR__ . "/../uploads/";

$allowedFileExtensions = [
    "txt",
];

// ** INIT ** //

// save the active file set by form requests to session
if (!empty($_REQUEST['activeFile'])) {
    $_SESSION['activeFile'] = $filesDir . $_REQUEST['activeFile'] . ".txt";
}

// set display flag for detailed views of file data
$renderDetailView = false;
if (!empty($_SESSION['activeFile']) && file_exists($_SESSION['activeFile'])) {
    $activeFile = Reader::fromFile($_SESSION['activeFile']);
    $renderDetailView = true;
}

// ** STRINGS ** //

// ** FUNCTIONS ** //
function setSessionMessage($text, $class)
{
    $_SESSION['message'][] = [
        'text' => $text,
        'class' => $class,
    ];
}

function getSessionMessage()
{
    $string = '';
    foreach ($_SESSION['message'] ?? [] as &$message) {
        $string .= "<div class='alert alert-{$message['class']}' role='alert'>{$message['text']}</div>";
    }
    unset($_SESSION['message']);
    return $string;
}