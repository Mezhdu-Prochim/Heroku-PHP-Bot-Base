<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Use this file for webhook. It will reply any command from users
 * 
 */

require_once "ShepherdKozyBot.php";
require_once "config.php";

$bot = new ShepherdKozyBot($token,$bot_name,$squadIds,$admins,$playersIds,$url,$gm_id,$ali_admins);
$bot->replyCommand();
$bot->api->sendMessage([
            'text' => "Ты автстралийская водяная крыса! Вот ты кто",
        ]);

?>
