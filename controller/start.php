<?php

use natilosir\bot\bot;
use natilosir\orm\db;

$response = bot::row([
    bot::column('Account Information', 'dd'),

])
    ->row([
        bot::column('Help', 'dd'),
        bot::column('Contact Us', 'dd'),
    ]);

if ($text == 'Back') {
    $text = 'You have returned to the main menu.
        
Please select one of the options below.';
} else {
    $text = 'Please select an option from the menu below.';
}

$response = bot::keyboard($chatID, $text, $message_id);

lg(db::table('users')->get()); // please check log.txt
