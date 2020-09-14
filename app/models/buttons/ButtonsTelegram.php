<?php


namespace App\models\buttons;


use App\models\BotUsers;

class ButtonsTelegram {

    public static function main_menu($userId) {
//        $user = BotUsers::find($userId);

        return [
            ["{contacts}"],
            ["{languages}"]
        ];
    }

    public static function start()
    {
        return [
            ["start"]
        ];
    }

    public function back() {
        return [
            ["{back}"]
        ];
    }
}
