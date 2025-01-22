# Bot-SDK
A professional SDK BOT Telegram for PHP

## Requirements

- PHP >= 5.4
- Composer

## Installation

You can install this SDK package via Composer:

```bash
composer require natilosir/Telegram-Bot-SDK
php vendor/natilosir/bot/install.php
```

### [ORM](https://github.com/natilosir/orm)
  - [select](https://github.com/natilosir/ORM#select)
  - [insert](https://github.com/natilosir/ORM#insert-array)
  - [table](https://github.com/natilosir/ORM#select)
  - [update](https://github.com/natilosir/ORM#update-array)
  - [delete](https://github.com/natilosir/ORM#delete)
  - [eloquent](https://github.com/natilosir/ORM#update-model)
  - [search](https://github.com/natilosir/ORM#search)
  - [Count](https://github.com/natilosir/ORM#Count)
  - [orderBy](https://github.com/natilosir/ORM#orderBy)
  - [DISTINCT](https://github.com/natilosir/ORM#DISTINCT)
  - [JSON](https://github.com/natilosir/ORM#JSON)
  - [query](https://github.com/natilosir/ORM#query)

### [Error log](https://github.com/natilosir/BOT/blob/main/log.txt) 
- Advanced error management and storing logs in a separate file `log.txt` for every request to the server.
# Route Class
Please provide the code you would like me to review.
```php
use natilosir\bot\Route; 
Route::add(['/start', 'بازگشت', 'انصراف'], 'start')
    // Add route for the purchase command
    ->add('خرید', 'buy')
    // Add route for the sale command
    ->add('فروش', 'sell');

// Define the default file to handle the start command
Route::def('start'); // Default file

// Handle the input text from the user
Route::handle($text); // Process the incoming text
```
Now we will review all sections of the code. To use this class, make sure to include `use natilosir\bot\Route;` before calling the Route class.

### add Method Overview

```php
Route::add(['/start', 'بازگشت', 'انصراف'], 'start')
```

This method accepts two parameters: `patterns` and `action`.

1. **Patterns (Input 1)**: 
   - You can specify the patterns as either an array or a string. This defines the command or phrase that, when triggered by the user, will determine which file to open.
   - For example, if the user types and sends the command `/start`, you would specify this command in the patterns parameter.

2. **Action (Input 2)**: 
   - The second input is the path to the file located within the `controller` directory.
   - For instance, if there is a file named `start.php` in the `controller` folder, you should provide the second input simply as `start`. The system will automatically understand that it needs to open the file located at `controller/start.php`.

3. **Accessing Files from Other Directories**: 
   - If you want to open a file from a different folder, you can use the `.` notation.
   - For example, if you want to open the file `controller/user/send.php`, you would specify the second input as `user/send`.

### Example Usage add methods

```php
Route::add('/start', 'start');        // This will open controller/start.php when /start is triggered.
Route::add('/send', 'user/send');     // This will open controller/user/send.php when /send is triggered.
```

## Default Method Overview

```php
// Define the default file to handle the start command
Route::def('start'); // Default file
```

Using the `def` method, you can specify a default file to be opened. This is particularly useful when a user sends a command that does not match any of the patterns defined in the `add` method.

### How It Works

- If the user sends a command that does not match any of the patterns specified in the `add` method, the `def` method allows you to display a default message or response.
- This can help guide users or provide them with additional options when they input an unrecognized command.

### Example Usage
```php
Route::def('default_message');        // Opens controller/default_message.php if no patterns match
```


## Handle Method Overview

The `handle` method is designed to process user input. It allows the system to receive a specific string or command sent by the user.

### How It Works

- You can use the `Route::handle($text);` method to capture the `$text` input from the user.
- This method is essential for handling commands or messages that users send to your bot.

### Example Usage

```php
// Assuming you have set up your routes
Route::add('/start', 'start');        // This will open controller/start.php when /start is triggered.
Route::add('/send', 'user/send');     // This will open controller/user/send.php when /send is triggered.

Route::def('default_message');        // Opens controller/default_message.php if no patterns match
Route::handle($text); // Processes the user input
```
---
## Bot Class
### HTTP request
```php     
     $data = [
    'chat_id'    => $chatID,
    'text'       => $text,
];
http('sendMessage', $data);
```
---
## `deleteMessage` Method

The `deleteMessage` method allows you to delete a message from a chat.

### Parameters

- **`$chatID`** (int): The unique identifier for the target chat.
- **`$message_id`** (int): The unique identifier for the message to be deleted.

### Example

```php
// Define chat ID and message ID
$chatID = 123456789; // Target chat ID
$message_id = 42; // Message ID to be deleted

// Use the deleteMessage method
$bot::deleteMessage($chatID, $message_id);
```
---
## `forwardMessage` Method

The `forwardMessage` method allows you to forward a message from one chat to another.

### Parameters

- **`$chatID`** (int): The ID of the chat where the message will be forwarded.
- **`$from_chat_id`** (int): The ID of the chat from which the message is being forwarded.
- **`$message_id`** (int): The ID of the message to be forwarded.

### Example Usage

```php
// Define chat IDs and message ID
$chatID = 123456789; // Destination chat ID
$from_chat_id = 987654321; // Source chat ID
$message_id = 42; // Message ID to be forwarded

// Use the forwardMessage method
$bot::forwardMessage($chatID, $from_chat_id, $message_id);
```
---
## `sendMessage` Method

The `sendMessage` method sends a text message to a specified chat.

### Parameters

- **`$chatID`** (int): The unique identifier for the target chat.
- **`$text`** (string): The text of the message to be sent.
- **`$reply_to_message_id`** (int, optional): If the message is a reply, ID of the original message.
- **`$reply_markup`** (array, optional): Additional interface options, such as inline keyboard.

### Example

```php
// Define the chat ID and message text
$chatID = 123456789; // The target chat ID
$messageText = "Hello! How can I assist you today?";

// Send a message to the chat
$bot::sendMessage($chatID, $messageText);
```
---
## `copyMessage` Method

The `copyMessage` method allows you to copy a message from one chat to another in a Telegram bot.

### Parameters

- **`$chatID`** (int): The ID of the chat where the message will be sent.
- **`$second_chat_id`** (int): The ID of the chat from which the message will be copied.
- **`$message_id`** (int): The ID of the message that needs to be copied.
- **`$reply_markup`** (array|null, optional): Optional. Additional reply markup for the copied message.

### Example

```php
<?php
namespace natilosir\bot;

require_once "http.php"; // Load the http.php file

// Create an instance of the bot class
$bot = new bot();

// Define chat IDs and message ID
$chatID = 123456789; // Destination chat ID
$from_chat_id = 987654321; // Source chat ID
$message_id = 42; // ID of the message to be copied

// Use the copyMessage method
bot::copyMessage($chatID, $from_chat_id, $message_id);
```
---
## `inline` Method

The `inline` method allows you to create inline keyboard buttons for your bot.

### Parameters

- **$text** (string): The text displayed on the button.
- **$callback_data** (string|null): The data sent back to the bot when the button is pressed. This can be used to identify the button action.
- **$url** (string|null): (Optional) A URL to be opened when the button is pressed. If this is provided, `callback_data` will be ignored.

### Example

Here is an example of how to use the `inline` method to create an inline keyboard with a button:

```php
$response = Bot::row([
    Bot::column('❓ What is this bot? What is it used for?', 'option_1'),
    ])
    ->row([
        Bot::column('🔗 How do I connect to a random stranger?', 'option_2'),
    ])
    ->row([
        Bot::column('💌 How do I connect to a specific contact?', 'option_3'),
    ]);

// Display the inline keyboard with the given helper text

// Main message text with the quote formatted
$text = "🔎just tap the desired button below👇🏻";

// Send the message with reply
$response = Bot::inline($chatID, $text, $message_id);
```
---
## `keyboard` Method

The `keyboard` method allows you to create a custom keyboard layout for your bot's messages.

### Parameters

- **$chatID** (int): The unique identifier for the target chat where the keyboard will be sent.
- **$text** (string): The text message to accompany the keyboard.
- **$reply_markup** (array|null): (Optional) An array defining the keyboard layout. If not provided, a default keyboard will be used.

### Example

```php
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
```
---
## `editMessageReplyMarkup` Method

The `editMessageReplyMarkup` method is used to edit the reply markup of a message sent by the bot.

### Parameters

- **`chat_id`**: (integer|string) Unique identifier for the target chat or username of the target channel (in the format `@channelusername`).
- **`message_id`**: (integer) Identifier of the message to edit.
- **`reply_markup`**: (array|null) A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard, or to force a reply from the user.

### Example

```php
Bot::row([
    Bot::column('🔓 Unblock', 'unblock' . $message_id_from_callback),
    Bot::column('✍ Reply', 'reply' . $message_id_from_callback),
])->row([
    Bot::column('🚫 Report User', 'report' . $message_id_from_callback),
]);

Bot::alert($query_id, '🚫 Blocked!');

Bot::inline($chatID, null, $message_id, 'edit');
```
---
### `answerCallbackQuery` Method

This method is used to send a response to a callback query received from a button press in a Telegram bot.

#### Parameters

- **`$query_id`**: The unique identifier for the callback query.
- **`$text`**: The text message to be sent as a response.
- **`$show_alert`**: (Optional) A boolean value indicating whether to show an alert instead of a notification. Default is `false`.

#### Example Usage

```php
bot::answerCallbackQuery($query_id, "Your action was successful!", true);
```
---
## `alert` Method

The `alert` method is used to send an alert to the user in response to a callback query.

### Parameters

- **`$query_id`**: (string) The unique identifier for the callback query.
- **`$text`**: (string) The text of the alert message to be displayed.
- **`$show_alert`**: (bool, optional) Determines whether to show the alert as a modal dialog. Default is `false`.

### Example

```php
// Define the query ID and the message text
$query_id = '1234567890';
$message_text = 'This is an alert message!';

// Send an alert to the user
$bot::alert($query_id, $message_text, true);
```
---
## `sendChatAction` Method

The `sendChatAction` method is used to send a chat action (like typing, uploading, etc.) to a specific chat.

### Parameters

- **`$chatID`** (int|string): The unique identifier for the target chat or username of the target channel (in the format `@channelusername`).
- **`$action`** (string): The action to be sent. Possible values are:
  - `typing`
  - `upload_photo`
  - `record_video`
  - `upload_video`
  - `record_audio`
  - `upload_audio`
  - `upload_document`
  - `find_location`
  - `record_video_note`
  - `upload_video_note`

### Example

```php
// Define the chat ID and action
$chatID = 123456789; // Target chat ID
$action = 'typing'; // Action to be sent

// Send the chat action
$bot::sendChatAction($chatID, $action);
```
