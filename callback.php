<?php

use natilosir\bot\Route;

/*
|--------------------------------------------------------------
| CallBack Configuration
|--------------------------------------------------------------
| This section defines the callbacks.
*/

// Add callbacks for the start
Route::add(['dd', 'بازگشت', 'انصراف'], 'start');

// Define the default file to handle the start command
Route::def('start'); // Default file

// Handle the input text from the user
Route::handle($callbackData); // Process the incoming text

/*
|--------------------------------------------------------------
| Input Configuration
|--------------------------------------------------------------
| Retrieve the message from the input data
|   $callbackQuery  Get the entire callback query data
|   $query_id       Extract the query ID
|   $callbackData   Extract the data related to the button
|   $chatID         Extract the chat ID
|   $message_id     Extract the original message ID
|   $fromID         Extract the sender's user ID
|   $firstName      Extract the sender's first name
|   $lastName       Extract the sender's last name
|   $username       Extract the sender's username
|
| This section contains the configuration for the bot.
| You need to provide the token to connect to the bot API.
|
*/
