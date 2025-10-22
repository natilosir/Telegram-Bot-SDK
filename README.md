# Bot-SDK
A professional SDK for building Telegram Bots, designed with a Laravel-like structure for PHP.

## Requirements

- PHP >= 8.0
- Composer

## Installation

You can install this SDK package via Composer:

```bash
composer require natilosir/Telegram-Bot-SDK
php vendor/natilosir/bot/install.php
```

## ORM
For detailed documentation on the ORM, visit: [ORM Documentation](https://github.com/natilosir/ORM)

- [select](https://github.com/natilosir/ORM#select)
- [insert](https://github.com/natilosir/ORM#insert-array)
- [table](https://github.com/natilosir/ORM#select)
- [update](https://github.com/natilosir/ORM#update-array)
- [createOrFirst](https://github.com/natilosir/ORM#createorfirst)
- [createOrUpdate](https://github.com/natilosir/ORM#createorupdate)
- [delete](https://github.com/natilosir/ORM#delete)
- [eloquent](https://github.com/natilosir/ORM#update-model)
- [search](https://github.com/natilosir/ORM#search)
- [Count](https://github.com/natilosir/ORM#Count)
- [orderBy](https://github.com/natilosir/ORM#orderBy)
- [DISTINCT](https://github.com/natilosir/ORM#DISTINCT)
- [JSON](https://github.com/natilosir/ORM#JSON)
- [query](https://github.com/natilosir/ORM#query)
- [Model](https://github.com/natilosir/ORM#model)

## Log::Class

The `Log` class, along with global `lg()` and `dd()` functions in the `natilosir\bot` namespace, provides a robust logging system for PHP applications, particularly suited for debugging and monitoring in bot frameworks like Telegram bots.

### Features

#### AdvancedLogger Class
- **HTML Log Output**: Generates a visually appealing HTML log file (`log.html`) with a responsive design and custom styles.
- **Multiple Log Levels**: Supports PHP error levels (e.g., `ERROR`, `WARNING`, `NOTICE`) and custom levels (`INFO`, `DEBUG`).
- **Error and Exception Handling**: Captures PHP errors, exceptions, and fatal errors using custom handlers.
- **Contextual Logging**: Allows adding context data to logs for additional debugging information.
- **Data Formatting**: Formats various data types (objects, arrays, strings, etc.) into readable HTML with color-coded styling.
- **Singleton Pattern**: Ensures a single logger instance to avoid duplicate log files or handlers.
- **Automatic Initialization**: Sets up error reporting, handlers, and log file creation automatically.

#### Log Class
- **Convenient Logging Methods**: Provides static methods (`info`, `debug`, `error`, `warning`, `notice`) for logging at specific levels.
- **Stack Trace Support**: Automatically captures the file and line number where the log is called.

#### Global Functions
- **`lg()`**: A flexible function for logging data at any specified level with optional context, appending to the HTML log file.
- **`dd()`**: Logs data at the `DEBUG` level and terminates script execution, ideal for debugging.

### Usage

The `AdvancedLogger` is initialized automatically with a default log file (`log.html`) and sets up error and exception handlers. The `Log` class and global `lg()` and `dd()` functions provide easy ways to log messages or debug data.

#### Example

```php
<?php
use natilosir\bot\Log;

// Initialize the logger (done automatically)
AdvancedLogger::getInstance();

// Log messages using the Log class
Log::info('Application started');
Log::debug('User data', ['user_id' => 123, 'name' => 'John']);
Log::error('Database connection failed', ['error_code' => 500]);

// Log using the global lg function
lg('Processing request', 'INFO', ['request_id' => 'abc123']);
lg(['data' => ['key' => 'value']], 'DEBUG', ['context' => 'additional info']);

// Dump and die for debugging
dd(['variable' => 'test']);
```

## Editor.php

### Overview
`Editor.php` is an online code editor that allows users to edit files in a manner similar to Visual Studio Code (VSCode). It provides a user-friendly interface for managing and editing code files directly from your web browser.

### Opening Files
By default, the editor opens the file `route.php`. To open other files, append the file path to the URL, like this:

```bash
editor.php?file=app/Controllers/StartController.php
```

### Handling Unsaved Files
If you encounter an "Error opening file" message when trying to open a file that has not been saved previously, press `Ctrl + S`. This action will create a new file and automatically save it.

### Saving Files
To save changes, click the purple "Save" button in the top right corner of the editor (for mobile users) or use the keyboard shortcut `Ctrl + S`.

### Features
- User-friendly interface for `android` and `windows`
- Supports multiple file editing: `php`, `js`, `html`, `css`, etc.
- Keyboard shortcuts for efficiency (`Ctrl + S`)

## Route::Class

The `Route` class is used to define routes for handling user inputs in the bot.

### Example

```php
use natilosir\bot\Route;

Route::add(['/start', '🏠 Home', 'Cancel'], [StartController::class, 'hello']);
```

To use this class, ensure you include `use natilosir\bot\Route;` before calling the `Route` class.

### add Method Overview

```php
Route::add(['/start', 'Back'], 'start')
```

This method accepts two parameters: `patterns` and `action`.

1. **Patterns (Input 1)**:
  - Specify patterns as either an array or a string to define the command or phrase that triggers the route.
  - Example: If the user sends `/start`, specify this command in the patterns parameter.

2. **Action (Input 2)**:
  - The path to the file in the `controller` directory.
  - Example: For `app/Controllers/StartController.php`, specify `start`. The system will automatically locate `app/Controllers/StartController.php`.
  - To access files in other directories, use `.` notation, e.g., `StartController::class`.

### Usage

```php
use natilosir\bot\Route;
use Controllers\StartController;

// Define a route with multiple input patterns
Route::add(['start', '/start', '🏠 Home', 'Cancel'], [StartController::class, 'hello']);

// Define a route with a state
Route::add('/profile', [ProfileController::class, 'show'])->state('profile_state');

// Define a default route for unmatched inputs
Route::def([DefaultController::class, 'handle']);
```

### Key Methods

1. **`Route::add($uri, $action)`**
  - **Description**: Registers one or more input patterns to an action (controller method or callable).
  - **Parameters**:
    - `$uri`: A string or array of strings representing the input pattern(s) (e.g., `/start`, `['/start', 'begin']`).
    - `$action`: The action to execute, either:
      - An array `[Controller::class, 'method']` to call a specific controller method.
      - A string representing a controller class name (defaults to `__invoke` method).
      - A callable function.
  - **Returns**: A `Route` instance for method chaining.
  - **Example**:
    ```php
    Route::add('/start', [StartController::class, 'hello']);
    Route::add(['help', '/help'], [HelpController::class, 'show']);
    ```

2. **`Route::state($stateName)`**
  - **Description**: Associates a state with the most recently added route, enabling state persistence.
  - **Parameters**:
    - `$stateName`: A string representing the state identifier to persist.
  - **Returns**: A `Route` instance for method chaining.
  - **Example**:
    ```php
    Route::add('/profile', [ProfileController::class, 'show'])->state('profile_state');
    ```

3. **`Route::def($default)`**
  - **Description**: Sets a default action to handle inputs that do not match any defined routes.
  - **Parameters**:
    - `$default`: The default action, either an array `[Controller::class, 'method']`, a string (controller class name), or a callable.
  - **Returns**: A `Route` instance for method chaining.
  - **Example**:
    ```php
    Route::def([DefaultController::class, 'handle']);
    ```

### Example Controller

```php
namespace Controllers;

class StartController {
    public function hello(Request $request) {
        // Handle the request
        return "Welcome to the bot!";
    }
}
```

## State::Class

The `State` class allows associating a state with a route, useful for maintaining context in conversational applications (e.g., chatbots). When a route with a state is triggered, the state is set using `State::set($stateName)` and persists until cleared or overridden.

States are cleared automatically unless the route explicitly sets a state (controlled by the `$configclear` flag).

### Example

```php
use natilosir\bot\State;
use Controllers\ProfileController;

// Define a state with multiple input patterns
State::add(['profile', '/profile', '👤 Profile'], [ProfileState::class, 'show']);
```

In this example:
- The state accepts multiple input patterns (`profile`, `/profile`, `👤 Profile`) and maps them to the `show` method of `ProfileController`.
- A default action is set to handle unmatched inputs or states using `DefaultController::handle`.

## Request::Class

The `Request` class is a versatile utility for parsing and handling incoming webhook updates, particularly for Telegram bots, within the `natilosir\bot` namespace.

### Features

- **Dynamic Update Parsing**: Automatically detects and parses various Telegram update types (e.g., messages, callback queries, inline queries, polls, chat member updates).
- **Comprehensive Data Access**: Exposes update details (e.g., chat ID, user ID, message text, callback data) through public properties.
- **Input Normalization**: Provides a unified `getInput()` method to retrieve relevant input based on the update type.
- **Command Detection**: Identifies bot commands using `isCommand()` and `getCommand()` methods.
- **Data Serialization**: Supports converting request data to an array (`toArray()`) or JSON (`toJson()`).
- **Flexible Update Types**: Handles messages, edited messages, callback queries, polls, and more.
- **Error Handling**: Safely handles missing or invalid data with null checks and default values.

### Usage

The `Request` class is instantiated automatically to parse incoming webhook data from `php://input`. It processes the JSON payload and populates public properties based on the update type.

#### Example

```php
<?php
use natilosir\bot\Request;

class StartController {
    public function hello(Request $request) {
        // Access common properties
        $chatID = $request->chatID;
        $userID = $request->fromID;
        $text   = $request->text;

        // Check if the input is a command
        if ($request->isCommand()) {
            echo "Command received: " . $request->getCommand();
        }

        // Get the input (text, callback data, or query)
        $input = $request->getInput();

        // Convert request to array for processing
        $data = $request->toArray();
    }
}
```

### Public Properties

#### Common Properties
- `updateId`: The unique identifier for the update.
- `updateType`: The type of update (e.g., `message`, `callback_query`).
- `chatID`: The chat ID where the update originated.
- `fromID`: The user ID of the sender.
- `firstName`: The sender’s first name.
- `lastName`: The sender’s last name.
- `username`: The sender’s username.
- `date`: The timestamp of the update.
- `message_id`: The message ID (for message-related updates).
- `text`: The message text or callback data (for `callback_query`).

#### Message-Specific Properties
- `entities`: Message entities (e.g., bot commands, URLs).
- `caption`: Caption for media messages.
- `photo`, `audio`, `document`, `video`, `voice`, `contact`, `location`, `venue`, `sticker`, `animation`, `dice`: Media or content sent in the message.
- `new_chat_members`, `left_chat_member`, `new_chat_title`, `new_chat_photo`, `pinned_message`, `reply_to_message`: Chat-related updates.

#### Callback Query-Specific Properties
- `query_id`: The callback query ID.
- `callbackData`: The data associated with the callback query.

#### Inline Query-Specific Properties
- `inline_query_id`: The inline query ID.
- `query`: The inline query text.
- `offset`: The offset for paginated inline query results.

#### Shipping Query-Specific Properties
- `shipping_query_id`: The shipping query ID.
- `invoice_payload`: The payload for the invoice.
- `shipping_address`: The shipping address provided by the user.

#### Pre-Checkout Query-Specific Properties
- `pre_checkout_query_id`: The pre-checkout query ID.
- `currency`: The currency of the payment.
- `total_amount`: The total amount of the payment.
- `order_info`: Additional order information.

#### Poll-Specific Properties
- `poll_id`: The poll ID.
- `question`: The poll question.
- `options`: The poll options.
- `total_voter_count`: The number of voters.
- `is_closed`: Whether the poll is closed.
- `is_anonymous`: Whether the poll is anonymous.

#### Chat Member Update Properties
- `old_chat_member`: The previous chat member state.
- `new_chat_member`: The updated chat member state.
- `invite_link`: The invite link used for chat join requests.

## Sending a request via laravel to bot
To send a request using the bot endpoint, make a POST request to Webhook URL with a JSON payload
#### Request Format

Your request must include:

A `route` field specifying the action (e.g., `sendMessage`)
A `data` object containing the required parameters for that route
**Example (using Laravel `HTTP` client):**

```php
use Illuminate\Support\Facades\Http;

$response = Http::timeout(10)
        ->asJson()
        ->post("https://Webhook.com", [
            'route' => 'sendMessage',
            'data'  => [
                'chat_id' => 123456789,
                'text'    => 'Hello from your bot!',
            ],
        ]);
```
**Get data in bot**
```php
// in route.php
Route::add('sendMessage', [ HomeController::class, 'sendMessage' ]);

// in HomeController.php
public function sendMessage( Request $request ) {
    bot::sendMessage($request->request->chat_id, $request->request->text);
}
```
**Notes**
The request must be sent as JSON (`Content-Type: application/json`).
Replace `sendMessage` and `chat_id` and `text` with your actual values.



### Key Methods

1. **`getInput(): string`**
  - **Description**: Returns the primary input for the update (e.g., `callbackData` for `callback_query`, `query` for `inline_query`, or `text`).
  - **Example**:
    ```php
    $input = $request->getInput();
    ```

2. **`getUpdateType(): string`**
  - **Description**: Returns the type of the update (e.g., `message`, `callback_query`).
  - **Example**:
    ```php
    $type = $request->getUpdateType();
    ```

3. **`isCommand(): bool`**
  - **Description**: Checks if the message contains a bot command.
  - **Example**:
    ```php
    if ($request->isCommand()) {
        echo "This is a command!";
    }
    ```

4. **`getCommand(): string`**
  - **Description**: Retrieves the bot command from the message (e.g., `/start`).
  - **Example**:
    ```php
    $command = $request->getCommand();
    ```

5. **`toArray(): array`**
  - **Description**: Converts non-empty properties to an array, excluding internal `data` and `updateTypes` properties.
  - **Example**:
    ```php
    $data = $request->toArray();
    ```

6. **`toJson(): string`**
  - **Description**: Converts non-empty properties to a JSON string.
  - **Example**:
    ```php
    $json = $request->toJson();
    ```

7. **`getRawData(): array`**
  - **Description**: Returns the raw JSON data decoded from `php://input`.
  - **Example**:
    ```php
    $raw = $request->getRawData();
    ```

8. **`dd(): string` and `lg(): string`**
  - **Description**: Debugging methods that call external `dd` or `lg` functions with the request’s array representation.
- **Note**: Requires `dd` and `lg` functions to be defined.

## Http::Class

The `Http` and `HttpResponse` classes in the `natilosir\bot` namespace provide a simple and flexible way to make HTTP requests and handle responses, particularly for interacting with APIs like the Telegram Bot API.

### Features

#### Http Class
- **Multiple HTTP Methods**: Supports GET, POST, PUT, PATCH, and DELETE requests with static methods.
- **Base URL Support**: Allows setting a base URL for simplified endpoint construction.
- **Custom Headers and Options**: Configurable headers and cURL options for advanced customization.
- **Automatic Query and Form Handling**: Handles query parameters for GET and form/JSON data for other methods.
- **Error Handling**: Throws exceptions for cURL errors and handles JSON decoding gracefully.
- **Fluent Interface**: Chainable methods for setting base URLs, headers, and options.

### Usage

#### Example

```php
<?php
use natilosir\bot\Http;

class StartController {
    public function hello() {
        // Quick POST request
        $response = Http::post('https://api.example.com/endpoint', [
            'key' => 'value',
        ]);

        if ($response->successful()) {
            echo "Response: " . json_encode($response->body());
        } else {
            echo "Request failed with status: " . $response->status();
        }

        // GET request with query parameters
        $response = Http::get('https://api.example.com/search', [
            'q'    => 'example',
            'page' => 1,
        ]);

        // Check response
        if ($response->successful()) {
            $data = $response->json();
            echo "Data: " . json_encode($data);
        }
    }
}
```

### Key Methods

1. **`static post($url, array $data = []): HttpResponse`**
  - **Description**: Sends a POST request with form data.
  - **Example**:
    ```php
    $response = Http::post('https://api.example.com/submit', ['key' => 'value']);
    ```

2. **`static get($url, array $query = []): HttpResponse`**
  - **Description**: Sends a GET request with optional query parameters.
  - **Example**:
    ```php
    $response = Http::get('https://api.example.com/search', ['q' => 'test']);
    ```

3. **`static put($url, array $data = []): HttpResponse`**
  - **Description**: Sends a PUT request with form data.
  - **Example**:
    ```php
    $response = Http::put('https://api.example.com/update', ['id' => 1, 'value' => 'new']);
    ```

4. **`static patch($url, array $data = []): HttpResponse`**
  - **Description**: Sends a PATCH request with form data.
  - **Example**:
    ```php
    $response = Http::patch('https://api.example.com/patch', ['key' => 'updated']);
    ```

5. **`static delete($url, array $data = []): HttpResponse`**
  - **Description**: Sends a DELETE request with optional form data.
  - **Example**:
    ```php
    $response = Http::delete('https://api.example.com/delete', ['id' => 1]);
    ```

6. **`withHeaders(array $headers): Http`**
  - **Description**: Merges additional headers with existing ones.
  - **Example**:
    ```php
    $http = Http::new()->withHeaders(['Content-Type' => 'application/json']);
    ```

7. **`withOptions(array $options): Http`**
  - **Description**: Merges additional cURL options with existing ones.
  - **Example**:
    ```php
    $http = Http::new()->withOptions([CURLOPT_TIMEOUT => 30]);
    ```

8. **`send(string $method, string $url, array $options = []): HttpResponse`**
  - **Description**: Sends an HTTP request with the specified method, URL, and options.
  - **Example**:
    ```php
    $response = $http->send('POST', '/submit', ['form_params' => ['key' => 'value']]);
    ```

### HttpResponse Class Methods

1. **`status(): int`**
  - **Description**: Returns the HTTP status code.
  - **Example**:
    ```php
    $status = $response->status();
    ```

2. **`body(): stdClass`**
  - **Description**: Returns the response body as a `stdClass` object.
  - **Example**:
    ```php
    $body = $response->body();
    ```

3. **`json(): stdClass`**
  - **Description**: Alias for `body()`, returns the response body as a `stdClass` object.
  - **Example**:
    ```php
    $json = $response->json();
    ```

4. **`successful(): bool`**
  - **Description**: Checks if the request was successful (status code 200–299).
  - **Example**:
    ```php
    if ($response->successful()) {
        echo "Request succeeded!";
    }
    ```

5. **`failed(): bool`**
  - **Description**: Checks if the request failed (status code outside 200–299).
  - **Example**:
    ```php
    if ($response->failed()) {
        echo "Request failed!";
    }
    ```

6. **`dd(): string`**
  - **Description**: Debugging method that calls an external `dd` function with the response data.
  - **Note**: Requires a `dd` function to be defined.

## Bot::Class

### `deleteMessage` Method
The `deleteMessage` method allows you to delete a message from a chat.

#### Parameters
- **`$chatID`** (int): The unique identifier for the target chat.
- **`$message_id`** (int): The unique identifier for the message to be deleted.

#### Example
```php
// Define chat ID and message ID
$chatID     = 123456789;
$message_id = 42;

// Use the deleteMessage method
Bot::deleteMessage($chatID, $message_id);
```

### `forwardMessage` Method
The `forwardMessage` method forwards a message from one chat to another.

#### Parameters
- **`$chatID`** (int): The ID of the chat where the message will be forwarded.
- **`$from_chat_id`** (int): The ID of the chat from which the message is being forwarded.
- **`$message_id`** (int): The ID of the message to be forwarded.

#### Example
```php
// Define chat IDs and message ID
$chatID       = 123456789;
$from_chat_id = 987654321;
$message_id   = 42;

// Use the forwardMessage method
Bot::forwardMessage($chatID, $from_chat_id, $message_id);
```

### `sendMessage` Method
The `sendMessage` method sends a text message to a specified chat.

#### Parameters
- **`$chatID`** (int): The unique identifier for the target chat.
- **`$text`** (string): The text of the message to be sent.
- **`$reply_to_message_id`** (int, optional): If the message is a reply, ID of the original message.
- **`$reply_markup`** (array, optional): Additional interface options, such as inline keyboard.

#### Example
```php
// Define the chat ID and message text
$chatID      = 123456789;
$messageText = "Hello! How can I assist you today?";

// Send a message to the chat
Bot::sendMessage($chatID, $messageText);
```

### `copyMessage` Method
The `copyMessage` method copies a message from one chat to another.

#### Parameters
- **`$chatID`** (int): The ID of the chat where the message will be sent.
- **`$second_chat_id`** (int): The ID of the chat from which the message will be copied.
- **`$message_id`** (int): The ID of the message to be copied.
- **`$reply_markup`** (array|null, optional): Additional reply markup for the copied message.

#### Example
```php
<?php
namespace natilosir\bot;

// Define chat IDs and message ID
$chatID       = 123456789;
$from_chat_id = 987654321;
$message_id   = 42;

// Use the copyMessage method
Bot::copyMessage($chatID, $from_chat_id, $message_id);
```

### `inline` Method
The `inline` method creates inline keyboard buttons for the bot.

#### Parameters
- **`$text`** (string): The text displayed on the button.
- **`$callback_data`** (string|null): The data sent back when the button is pressed.
- **`$url`** (string|null, optional): A URL to be opened when the button is pressed (overrides `callback_data`).

#### Example
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

$text = "🔎 Just tap the desired button below👇🏻";
$response = Bot::inline($chatID, $text, $message_id);
```

### `keyboard` Method
The `keyboard` method creates a custom keyboard layout for bot messages.

#### Parameters
- **`$chatID`** (int): The unique identifier for the target chat.
- **`$text`** (string): The text message to accompany the keyboard.
- **`$reply_markup`** (array|null, optional): An array defining the keyboard layout.

#### Example
```php
$response = Bot::row([
    Bot::column('Account Information'),
])
->row([
    Bot::column('Help'),
    Bot::column('Contact Us'),
]);

if ($text == 'Back') {
    $text = 'You have returned to the main menu.\n\nPlease select one of the options below.';
} else {
    $text = 'Please select an option from the menu below.';
}

$response = Bot::keyboard($chatID, $text, $message_id);
```

### `editMessageReplyMarkup` Method
The `editMessageReplyMarkup` method edits the reply markup of a message sent by the bot.

#### Parameters
- **`$chat_id`** (integer|string): Unique identifier for the target chat or username of the target channel (`@channelusername`).
- **`$message_id`** (integer): Identifier of the message to edit.
- **`$reply_markup`** (array|null): A JSON-serialized object for inline/custom keyboard or instructions to remove the keyboard.

#### Example
```php
Bot::row([
    Bot::column('🔓 Unblock', 'unblock' . $message_id_from_callback),
    Bot::column('✍ Reply', 'reply' . $message_id_from_callback),
])
->row([
    Bot::column('🚫 Report User', 'report' . $message_id_from_callback),
]);

Bot::alert($query_id, '🚫 Blocked!');
Bot::inline($chatID, null, $message_id, 'edit');
```

### `answerCallbackQuery` Method
This method sends a response to a callback query received from a button press.

#### Parameters
- **`$query_id`** (string): The unique identifier for the callback query.
- **`$text`** (string): The text message to be sent as a response.
- **`$show_alert`** (bool, optional): Whether to show an alert instead of a notification (default: `false`).

#### Example
```php
Bot::answerCallbackQuery($query_id, "Your action was successful!", true);
```

### `alert` Method
The `alert` method sends an alert to the user in response to a callback query.

#### Parameters
- **`$query_id`** (string): The unique identifier for the callback query.
- **`$text`** (string): The text of the alert message.
- **`$show_alert`** (bool, optional): Whether to show the alert as a modal dialog (default: `false`).

#### Example
```php
$query_id     = '1234567890';
$message_text = 'This is an alert message!';
Bot::alert($query_id, $message_text, true);
```

### `sendChatAction` Method
The `sendChatAction` method sends a chat action (e.g., typing, uploading) to a specific chat.

#### Parameters
- **`$chatID`** (int|string): The unique identifier for the target chat or username of the target channel (`@channelusername`).
- **`$action`** (string): The action to be sent (e.g., `typing`, `upload_photo`, `record_video`, `upload_video`, `record_audio`, `upload_audio`, `upload_document`, `find_location`, `record_video_note`, `upload_video_note`).

#### Example
```php
$chatID = 123456789;
$action = 'typing';
Bot::sendChatAction($chatID, $action);
```