<?php

namespace App\models\buttons;

use App\models\BotUsers;
use App\models\City;
use App\models\Country;
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

    public static function languages() {
        return "";
    }


    public static function countries($countries, $page) {
        $count = Country::count();
        $countPage = $count / 10;

        $np = $page + 1;
        $pp = $page - 1;

        $nextPage = [
            'text' => '{next_page}',
            'callback_data' => 'select_countries__'.$np
        ];

        $prevPage = [
            'text' => '{prev_page}',
            'callback_data' => 'select_countries__'.$pp
        ];

        $buttons = [];
        foreach($countries as $country) {
            $buttons[] = [[
                'text' => $country->name,
                'callback_data' => 'select_city__'.$country->id
            ]];
        }

        if($page == 1 && $countPage > 1) {
            $buttons[] = [$nextPage];
        }
        elseif($page > 1 && $countPage == $page) {
            $buttons[] = [$prevPage];
        }
        elseif($page > 1 && $countPage > $page) {
            $buttons[] = [$prevPage, $nextPage];
        }

        return $buttons;
    }

    public static function cities($cities, $countryId, $page) {
        $count = City::where('country_id', $countryId)->count();
        $countPage = $count / 10;

        $np = $page + 1;
        $pp = $page - 1;

        $nextPage = [
            'text' => '{next_page}',
            'callback_data' => 'select_city__'.$countryId.'_'.$np
        ];

        $prevPage = [
            'text' => '{prev_page}',
            'callback_data' => 'select_city__'.$countryId.'_'.$pp
        ];

        $buttons = [];
        foreach($cities as $city) {
            $buttons[] = [[
                'text' => $city->name,
                'callback_data' => 'selected_city__'.$city->id
            ]];
        }

        if($page == 1 && $countPage > 1) {
            $buttons[] = [$nextPage];
        }
        elseif($page > 1 && $countPage == $page) {
            $buttons[] = [$prevPage];
        }
        elseif($page > 1 && $countPage > $page) {
            $buttons[] = [$prevPage, $nextPage];
        }

        return $buttons;
    }

}
