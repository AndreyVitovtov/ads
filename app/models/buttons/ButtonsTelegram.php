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
            [[
                'text' => '{closest_to_me}',
                'request_location' => true
            ], "{back}"]
        ];
    }

    public function getPhone() {
        return [
            [[
                'text' => '{send_phone}',
                'request_contact' => true
            ], "{back}"]
        ];
    }

    public function getLocation() {
        return [
            [[
                'text' => '{send_location}',
                'request_location' => true
            ], "{back}"]
        ];
    }

    public function settingsAd() {
        return [
            ['{edit_title}', '{edit_description}'],
            ['{edit_photo}', '{edit_location}'],
            ['{read_ad}', '{delete_ad}'],
            ['{back}']
        ];
    }

    public function backToSettingsAd() {
        return [
            ['{back_to_settings_ad}'],
            ['{back}']
        ];
    }

    public function sendLocationBackToSettingsAd() {
        return [
            [[
                'text' => '{send_location}',
                'request_location' => true
            ]],
            ['{back_to_settings_ad}'],
            ['{back}']
        ];
    }
}
