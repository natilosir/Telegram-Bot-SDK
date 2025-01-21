<?php

require __DIR__ . '/vendor/autoload.php';

use natilosir\orm\db;
require __DIR__ . '/vendor/natilosir/bot/src/log.php';
setupErrorHandling();
db::Table("user");
$data = json_decode(file_get_contents('php://input'));
$message = $data->message;
if ($message) {
    $text       = $message->text;
    $chatID     = $message->chat->id;
    $fromID     = $message->from->id;
    $firstName  = $message->from->first_name;
    $lastName   = $message->from->last_name;
    $username   = $message->from->username;
    $date       = $message->date;
    $message_id = $message->message_id;
}

use Natilosir\bot\Route; 


Route::add(['/restart', '/start', 'لغو جستوجو', 'بازگشت', 'انصراف'], 'includes/start.php')
    ->add('خرید', 'includes/buy.php')
    ->add('فروش', 'includes/sell.php')
    ->add('اطلاعات حساب کاربری', 'includes/info.php')
    ->add('راهنما', 'includes/help.php')
    ->add('تماس با ما', 'includes/contactus.php')
    ->add(['جستجوی املاک', 'علاقمندی ها'], 'includes/buy_responses.php');

Route::def('includes/start.php');
Route::handle($text);



if ($result) {
    echo "Message copied successfully.";
} else {
    echo "Failed to copy message.";
}

processLogFile();
