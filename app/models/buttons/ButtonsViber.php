<?php

namespace App\models\buttons;

use App\models\Book;
use App\models\BotUsers;
use App\models\City;
use App\models\Country;
use App\models\Heading;
use App\models\Khatma;
use App\models\Page;
use App\models\Quran;
use App\models\Recipe;
use App\models\SettingsButtons;

class ButtonsViber {
    private $btnBg;
    private $btnSize;
    private $fontColor;

    public function __construct() {
        $viewButtons = SettingsButtons::getView();
        $this->btnBg = $viewButtons->background;
        $this->fontColor = $viewButtons->color_text;
        $this->btnSize = $viewButtons->size_text;
    }

    private function button($columns, $rows, $actionBody, $text, $silent = "false") {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => 'reply',
            'ActionBody' => $actionBody,
            'BgColor' => $this->btnBg,
            'Silent' => $silent,
            'Text' => '<font color="'.$this->fontColor.'" size="'.$this->btnSize.'">'.$text.'</font>',
            'TextSize' => 'large',
            'TextVAlign' => 'middle',
			'TextHAlign' => 'center',
        ];
    }

    private function button_url($columns, $rows, $url, $text, $silent = "true") {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => 'open-url',
            'ActionBody' => $url,
            'OpenURLType' => 'internal',
            'BgColor' => $this->btnBg,
            'Silent' => $silent,
            'Text' => '<font color="'.$this->fontColor.'" size="'.$this->btnSize.'">'.$text.'</font>',
            'TextSize' => 'large'
        ];
    }

    private function button_img($columns, $rows, $actionType, $actionBody, $image, $text = "") {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => $actionType,
            'ActionBody' => $actionBody,
            'Image' => $image,
            'Text' => $text,
            'TextVAlign' => 'middle',
			'TextHAlign' => 'center'
        ];
    }

    private function button_location($columns, $rows, $text, $silent = false) {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => 'location-picker',
            'ActionBody' => 'jhg',
            'BgColor' => $this->btnBg,
            'Silent' => $silent,
            'Text' => '<font color="'.$this->fontColor.'" size="'.$this->btnSize.'">'.$text.'</font>',
            'TextSize' => 'large',
            'TextVAlign' => 'middle',
            'TextHAlign' => 'center',
        ];
    }

    public function start() {
        return [
            $this->button(6, 1, 'start', '{start}')
        ];
    }

    public function main_menu($userId) {
//        $user = BotUsers::find($userId);

//        if($user->access == '1') {
           return [
               $this->button(3, 1, 'search_ads', '{search_ads}'),
               $this->button(3, 1, 'create_ad', '{create_ad}'),
               $this->button(3, 1, 'my_ads', '{my_ads}'),
               $this->button(3, 1, 'contacts', '{contacts}'),
               $this->button(6, 1, 'edit_country', '{edit_country}')
           ];
    }

    public function back() {
        return [
            $this->button(6, 1, 'back', '{back}')
        ];
    }

    public function contacts() {
        return [
            $this->button(6, 1, 'general', '{contacts_general}'),
            $this->button(6, 1, 'access', '{contacts_access}'),
            $this->button(6, 1, 'advertising', '{contacts_advertising}'),
            $this->button(6, 1, 'offers', '{contacts_offers}'),
        ];
    }

    private function pagesButtons($res, $method, $name = 'name', $page = '1') {
        $res = array_slice($res, (($page - 1) * 42), 42);
        $buttons = [];
        foreach($res as $r) {
            $buttons[] = $this->button(6, 1, $method.'__'.$r->id, $r->$name);
        }

        return $buttons;
    }


    public function countries($countries, $page) {
        $count = Country::count();
        $countPage = $count / 30;

        $np = $page + 1;
        $pp = $page - 1;

        $buttons = [];
        foreach($countries as $country) {
            $buttons[] = $this->button(
                6,
                1,
                'select_city__'.$country->id,
                $country->name
            );
        }

        if($page == 1 && $countPage > 1) {
            $buttons[] = $this->button(
                6,
                1,
                'select_country__'.$np,
                '{next_page}'
            );
        }
        elseif($page > 1 && $countPage == $page) {
            $buttons[] = $this->button(
                6,
                1,
                'select_country__'.$pp,
                '{prev_page}'
            );
        }
        elseif($page > 1 && $countPage > $page) {
            $buttons[] = $this->button(
                3,
                1,
                'select_country__'.$pp,
                '{prev_page}'
            );
            $buttons[] = $this->button(
                3,
                1,
                'select_country__'.$np,
                '{next_page}'
            );
        }

        return $buttons;
    }

    public function cities($cities, $countryId, $page) {
        $count = City::where('country_id', $countryId)->count();
        $countPage = $count / 30;

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
            $buttons[] = $this->button(
                6,
                1,
                'selected_city__'.$city->id,
                $city->name
            );
        }

        if($page == 1 && $countPage > 1) {
            $buttons[] = $this->button(
                6,
                1,
                'select_city__'.$countryId.'_'.$np,
                '{next_page}'
            );
        }
        elseif($page > 1 && $countPage == $page) {
            $buttons[] = $this->button(
                6,
                1,
                'select_city__'.$countryId.'_'.$pp,
                '{prev_page}'
            );
        }
        elseif($page > 1 && $countPage > $page) {
            $buttons[] = $this->button(
                3,
                1,
                'select_city__'.$countryId.'_'.$pp,
                '{prev_page}'
            );
            $buttons[] = $this->button(
                3,
                1,
                'select_city__'.$countryId.'_'.$np,
                '{next_page}'
            );
        }

        return $buttons;
    }

    public function search_ads() {
        return [
            $this->button(3, 1, 'by_title', '{by_title}'),
            $this->button(3, 1, 'by_rubric', '{by_rubric}'),
            $this->button_location(3, 1, '{closest_to_me}'),
            $this->button(3, 1, 'back', '{back}')
        ];
    }
}
