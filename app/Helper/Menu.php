<?php

namespace app\Helper;

use natilosir\bot\bot;
use natilosir\bot\Request;

class Menu {
    public static function BackMenu( $text ) {
        $request = new Request();
        bot::row([
            bot::column('🏠 بازگشت'),
        ]);

        return bot::keyboard($request->chatID, $text, $request->message_id);
    }
}