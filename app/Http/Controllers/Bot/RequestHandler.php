<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Bot\Traits\RequestHandlerTrait;
use App\models\buttons\InlineButtons;

class RequestHandler extends BaseRequestHandler {

    use RequestHandlerTrait;

    public function select_country($page = 1) {
        if(MESSENGER == 'Telegram') {
            $res = $this->send("{select_country}", [
                'inlineButtons' => InlineButtons::countries($this->botService->getCountries($page), $page),
                'hideKeyboard' => true
            ]);

            $this->setInteraction('', [
                'messageId' => $this->getIdSendMessage($res)
            ]);
        }
        elseif(MESSENGER == 'Viber') {
            $this->send('{select_country}');
            $this->sendCarusel([
                ''
            ]);
        }
    }

    public function select_city($data) {
        if(is_array($data)) {
            $countryId = $data[0];
            $page = $data[1];
        }
        else {
            $countryId = $data;
            $page = 1;
        }

        if(MESSENGER == 'Telegram') {
            $params = json_decode($this->getInteraction()['params']);
            $this->deleteMessage($params->messageId);

            $res = $this->send("{select_city}", [
                'inlineButtons' => InlineButtons::cities(
                    $this->botService->getCitiesByCountry($countryId, $page),
                    $countryId, $page
                ),
                'hideKeyboard' => true
            ]);

            $this->setInteraction('', [
                'messageId' => $this->getIdSendMessage($res)
            ]);
        }
        elseif(MESSENGER == 'Viber') {
            $this->send('{select_country}');
            $this->sendCarusel([
                ''
            ]);
        }
    }

    public function selected_city($cityId) {
        $params = json_decode($this->getInteraction()['params']);
        $this->deleteMessage($params->messageId);

        $this->setInteraction('', [
            'city_id' => $cityId
        ]);

        $this->send('{city_saved}', [
            'buttons' => $this->buttons()->main_menu($this->getUserId())
        ]);
    }

    private function getCityId(): ? int {
        $params = json_decode($this->getInteraction()['params']);
        if(isset($params->city_id)) {
            return $params->city_id;
        }
        return null;
    }

    public function search_ads() {
        $this->send('{select_menu_item}', [
            'buttons' => $this->buttons()->search_ads()
        ]);
    }

    public function by_title() {
        $this->send('{send_search_title}', [
            'buttons' => $this->buttons()->back()
        ]);
        $cityId = $this->getCityId();
        $this->setInteraction('search_ads_title', [
            'city_id' => $cityId
        ]);
    }

    public function search_ads_title() {
        $str = $this->getMessage();
        $this->send($str, [
            'buttons' => $this->buttons()->back()
        ]);
    }

    public function by_rubric() {
        $this->send('{select_rubric}', [
            'buttons' => $this->buttons()->back()
        ]);
    }

    public function edit_country() {
        $this->send('{edit_country}', [
            'buttons' => $this->buttons()->back()
        ]);

        $this->select_country();
    }

    public function create_ad() {
        $this->send('{select_rubric}', [
            'buttons' => $this->buttons()->back()
        ]);
    }

    public function my_ads() {
        $ads = $this->botService->getMyAds($this->getUserId());
        if($ads == null) {
            return $this->send('{you_have_no_ads}', [
                'buttons' => $this->buttons()->main_menu($this->getUserId())
            ]);
        }

        $this->send('{select_ad}', [
            'buttons' => $this->buttons()->back()
        ]);
    }
}
