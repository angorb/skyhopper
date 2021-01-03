<?php
// ** SETTINGS ** //
session_start();
date_default_timezone_set('MST'); // TODO
require_once __DIR__ . "/../vendor/autoload.php";
$filesDir = __DIR__ . "/../uploads/";

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