<?php
// bot.php

require_once("config.php");
require_once("BotHandler.php");

function bot($method, $data = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// Read update from Telegram
$update = json_decode(file_get_contents("php://input"), true);

$handler = new BotHandler($update, $ADMINS);
$handler->handle();
