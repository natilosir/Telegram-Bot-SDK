<?php
use natilosir\bot\bot; 
use natilosir\orm\db; 

$response = bot::row([
    bot::column('خرید', 'dd'),
])
    ->row([
        bot::column('فروش', 'dd'),
    ])
    ->row([
        bot::column('اطلاعات حساب کاربری', 'dd'),

    ])
    ->row([
        bot::column('راهنما', 'dd'),
        bot::column('تماس با ما', 'dd'),
    ]);

if ($text == 'بازگشت') {
    $text = 'به منو اصلی بازگشتید.
        
از بین گزینه های زیر یکی را انتخاب کنید.';
} else {
    $text = 'لطفا از منو زیر یک گزینه را انتخاب کنید.';
}

$response = bot::keyboard($chatID, $text, $message_id);

lg(db::table("users")->get());