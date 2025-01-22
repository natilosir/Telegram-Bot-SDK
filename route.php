<?php

use Natilosir\bot\Route; 

/*
|--------------------------------------------------------------
| Route Configuration
|--------------------------------------------------------------
| This section defines the routes.
*/

// Add routes for the start 
Route::add(['/start', 'بازگشت', 'انصراف'], 'start')
    // Add route for the purchase command
    ->add('خرید', 'buy')
    // Add route for the sale command
    ->add('فروش', 'sell');

// Define the default file to handle the start command
Route::def('start'); // Default file

// Handle the input text from the user
Route::handle($text); // Process the incoming text





/*
|--------------------------------------------------------------
| input Configuration
|--------------------------------------------------------------
| Retrieve the message from the input data
|   $text        Extract the text of the message
|   $chatID      Extract the chat ID
|   $fromID      Extract the sender's user ID
|   $firstName   Extract the sender's first name
|   $lastName    Extract the sender's last name
|   $username    Extract the sender's username
|   $date        Extract the date and time the message was sent
|   $message_id  Extract the message ID
|
| This section contains the configuration for the bot.
| You need to provide the token to connect to the bot API.
|
*/
