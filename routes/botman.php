<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

// $botman->verifyServices('fontechbot_verify_token');
$config = [
    'facebook' => [
        'token' => 'EAAWQo5u3pt8BAJAiNL4dZCWdlyeZA20y8S4X8CKVxkpJOZAWF4oPv6F18xFyOhcblJSh2wHk3dQqyADFhHFdeLaImq0eAyaI3JqjCazxsVC9othRZCZBtB9ghAEltdmiJH5k7M4PpwZAcluIgTrEOlHxG8QfH3w8q0Yf2VKu9hnwZDZD',
        'app_secret' => '',
        'verification' => 'fontechbot_verify_token',
    ]
];
DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

// Create BotMan instance
BotManFactory::create($config);

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class . '@startConversation');
