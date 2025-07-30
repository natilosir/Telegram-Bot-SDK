<?php

namespace app\Controllers;

use app\Models\User;
use natilosir\bot\bot;
use natilosir\bot\Request;
use function natilosir\bot\dd;
use function natilosir\bot\lg;

class StartController {
    public function hello( Request $request ) {
        bot::row([
            bot::column('📥 بررسی عضویت'),
        ]);

//        $lg = User::createOrFirst([ 'user_id' => $request->fromID, ], [
//            'first_name' => $request->firstName,
//            'last_name'  => $request->lastName,
//        ]);
        lg($lg);
        if ( $lg->is_updated ) {
            $text = 'hello';
        }
        else {
            $text = 'Natilos.ir';
        }

        return bot::keyboard($request->chatID, $text, $request->message_id);
    }
}