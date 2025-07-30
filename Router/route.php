<?php

use app\Controllers\StartController;
use natilosir\bot\Route;

Route::add([ '/start', '🏠 بازگشت', 'انصراف' ], [ StartController::class, 'hello' ]);