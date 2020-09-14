<?php

namespace App\models\buttons;

use App\models\BotUsers;
use App\models\Heading;
use App\models\Khatma;
use App\models\Language;
use App\models\Page;
use App\models\Quran;
use App\models\Recipe;
use Illuminate\Database\Eloquent\Collection;

class InlineButtons {
    public static function termsOfUse() {
        return [
            [
                [
                    "text" => "Условия использования",
                    "callback_data" => "termsOfUse"
                ]
            ],
            [
                [
                    "text" => "Принимаю",
                    "callback_data" => "confirming"
                ]
            ]
        ];
    }

    public static function contacts() {
        return [
            [
                [
                    "text" => "{contacts_general}",
                    "callback_data" => "general"
                ], [
                    "text" => "{contacts_access}",
                    "callback_data" => "access"
                ]
            ], [
                [
                    "text" => "{contacts_advertising}",
                    "callback_data" => "advertising"
                ], [
                    "text" => "{contacts_offers}",
                    "callback_data" => "offers"
                ]
            ]
        ];
    }

    private static function pagesButtons($model, $methodPages, $method, $name = 'name', $page = '1') {
        $count = $model::count();

        $obj = $model::offset(($page - 1) * COUNT_BTN_PAGE_TGM)->limit(COUNT_BTN_PAGE_TGM)->get();

        $buttons = [];

        foreach($obj as $o) {
            $buttons[] = [
                'text' => $o->$name,
                'callback_data' => $method.'__'.$o->id
            ];
        }

        $countPage = ceil($count / COUNT_BTN_PAGE_TGM);

        $nextPage = (int) $page+1;
        $prewPage = (int) $page-1;

        $buttons = array_chunk($buttons, COUNT_BTN_STR_TGM);

        if($countPage > 1) {
            if($page == 1) {
                $buttons[] = [[
                    'text' => '{next_buttons}',
                    'callback_data' => $methodPages.'__'.$nextPage
                ]];
            }
            elseif($page == $countPage) {
                $buttons[] = [[
                    'text' => '{prew_buttons}',
                    'callback_data' => $methodPages.'__'.$prewPage
                ]];
            }
            else {
                $buttons[] = [[
                    'text' => '{prew_buttons}',
                    'callback_data' => $methodPages.'__'.$prewPage
                ],
                [
                    'text' => '{next_buttons}',
                    'callback_data' => $methodPages.'__'.$nextPage
                ]];
            }
        }

        return $buttons;
    }
}
