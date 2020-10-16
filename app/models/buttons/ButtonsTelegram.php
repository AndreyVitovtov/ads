<?php


namespace App\models\buttons;


use App\models\BotUsers;

class ButtonsTelegram {

    public static function main_menu($userId) {
//        $user = BotUsers::find($userId);

        return [
            ["{search_ads}", "{create_ad}"],
            ["{my_ads}", "{contacts}"],
            ["{edit_country}"]
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

    public function search_ads() {
        return [
            ["{by_title}", "{by_rubric}"],
            ["{closest_to_me}", "{back}"]
        ];
    }
}
