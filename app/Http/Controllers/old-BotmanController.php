<?php

use BotMan\BotMan\BotMan;

$botman->verifyServices('fontechbot_verify_token');

$botman = app('botman');

$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello yourself.');
});

// start listening
$botman->listen();
