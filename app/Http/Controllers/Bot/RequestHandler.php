<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Bot\Traits\RequestHandlerTrait;
use App\models\BotUsers;
use App\models\buttons\InlineButtons;
use App\models\City;
use App\models\Country;
use Exception;

class RequestHandler extends BaseRequestHandler {

    use RequestHandlerTrait;

    public function select_country($page = 1) {
        if(MESSENGER == 'Telegram') {
            $res = $this->send("{select_country}", [
                'inlineButtons' => InlineButtons::countries(
                    $this->botService->getCountries($page, 10),
                    $page
                ),
                'hideKeyboard' => true
            ]);

            $this->setInteraction('', [
                'messageId' => $this->getIdSendMessage($res)
            ]);
        }
        elseif(MESSENGER == 'Viber') {
            $this->send('{select_country}');
            $countries = $this->botService->getCountries($page, 30);
            $rows = count($countries) < 7 ? count($countries) : 7;
            if(Country::count() > count($countries) && $rows != 7) {
                $rows++;
            }
             $this->sendCarusel([
                'richMedia' => $this->buttons()->countries(
                    $countries,
                    $page
                ),
                'rows' => $rows
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
                    $this->botService->getCitiesByCountry($countryId, $page, 10),
                    $countryId,
                    $page
                ),
                'hideKeyboard' => true
            ]);

            $this->setInteraction('', [
                'messageId' => $this->getIdSendMessage($res)
            ]);
        }
        elseif(MESSENGER == 'Viber') {
            $this->send('{select_city}');
            $cities = $this->botService->getCitiesByCountry($countryId, $page, 30);
            $rows = count($cities) < 7 ? count($cities) : 7;
            if(City::count() > count($cities) && $rows != 7) {
                $rows++;
            }
            $this->sendCarusel([
                'richMedia' => $this->buttons()->cities(
                    $cities,
                    $countryId,
                    $page
                ),
                'rows' => $rows
            ]);
        }
    }

    public function selected_city($cityId) {
        if(MESSENGER == 'Telegram') {
            $params = json_decode($this->getInteraction()['params']);
            $this->deleteMessage($params->messageId);
        }

        $this->setCityId($cityId);

        $this->send('{city_saved}', [
            'buttons' => $this->buttons()->main_menu($this->getUserId())
        ]);
    }

    private function setCityId($cityId) {
        $user = BotUsers::find($this->getUserId());
        $user->cities_id = $cityId;
        $user->save();
    }

    private function getCityId() {
        return BotUsers::find($this->getUserId())->cities_id;
    }

    public function search_ads() {
        $this->setInteraction('search_ads_p');

        $this->send('{select_menu_item}', [
            'buttons' => $this->buttons()->search_ads()
        ]);
    }

    public function search_ads_p() {
        $location = $this->getLocation();
        if($location != null) {
            $this->send($location['lat']);
        }
        else {
            $this->search_ads();
        }
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

    public function by_rubric($page = 1) {
        $page = (int) $page;
        $this->delInteraction();

        $this->send('{select_rubric}', [
            'buttons' => $this->buttons()->back()
        ]);

        $this->send('{rubrics}', [
            'inlineButtons' => InlineButtons::searchAdsByRubric(
                $this->botService->getRubrics($page, 10),
                $page
            )
        ]);
    }

    public function by_rubric_subsection($data) {
        if(is_array($data)) {
            $rubricId = $data[0];
            $page = $data[1];
        }
        else {
            $rubricId = $data;
            $page = 1;
        }
        $this->send('{select_subsection}', [
            'inlineButtons' => InlineButtons::searchAdsByRubricSubsection(
                $this->botService->getSubsectionsByRubric($rubricId, $page, 10),
                $rubricId,
                $page
            )
        ]);
    }

    public function by_rubric_subsection_selected($subsectionId) {
        $this->send($subsectionId, [
            'buttons' => $this->buttons()->back()
        ]);
    }

    public function edit_country() {
        $this->send('{edit_country}', [
            'buttons' => $this->buttons()->back()
        ]);

        $this->select_country();
    }

    public function create_ad($page = 1) {
        $page = (int) $page;
        $this->send('{select_rubric}', [
            'buttons' => $this->buttons()->back()
        ]);
        $this->send('{rubrics}', [
            'inlineButtons' => InlineButtons::createAdRubric(
                $this->botService->getRubrics($page, 10),
                $page
            )
        ]);
    }

    public function create_ad_subsection($data) {
        if(is_array($data)) {
            $rubricId = $data[0];
            $page = $data[1];
        }
        else {
            $rubricId = $data;
            $page = 1;
        }
        $this->send('{select_subsection}', [
            'inlineButtons' => InlineButtons::createAdSubsection(
                $this->botService->getSubsectionsByRubric($rubricId, $page, 10),
                $rubricId,
                $page
            )
        ]);
    }

    public function create_ad_subsection_selected($subsectionId) {
        $this->setInteraction('create_ad_title', [
            'subsection_id' => $subsectionId
        ]);

        $this->send('{send_title_ad}', [
            'buttons' => $this->buttons()->back(),
            'input' => 'regular'
        ]);
    }

    public function create_ad_title($params) {
        $title = $this->getMessage();

        $params['title'] = $title;

        $this->setInteraction('create_ad_description', $params);

        $this->send('{send_description_ad}', [
            'buttons' => $this->buttons()->back(),
            'input' => 'regular'
        ]);
    }

    public function create_ad_description($params) {
        $description = $this->getMessage();

        $params['description'] = $description;

        $this->setInteraction('create_ad_photo', $params);

        $this->send('{send_photo}', [
            'buttons' => $this->buttons()->back(),
            'input' => 'regular'
        ]);
    }

    public function create_ad_photo($params) {
        if(MESSENGER == "Telegram") {
            if($this->getType() == 'photo') {
                $path = $this->getFilePath();
                $fn = $this->botService->savePhoto($path);
                if($fn) {
                    $params['photo'] = $fn;
                    $this->setInteraction('create_ad_phone', $params);

                    $this->send('{send_phone}', [
                        'buttons' => $this->buttons()->getPhone()
                    ]);
                }
                else {
                    $this->send('{error}', [
                        'buttons' => $this->buttons()->back()
                    ]);
                }
            }
            else {
                $this->send('{send_photo}', [
                    'buttons' => $this->buttons()->back()
                ]);
            }
        }
    }

    public function create_ad_phone($params) {
        if(MESSENGER == "Telegram") {
            if($this->getType() == "contact") {
                $phone = $this->getDataByType()['phone'];
                $params['phone'] = $phone;
                $this->setInteraction('create_ad_location', $params);

                $this->send('{send_location}', [
                    'buttons' => $this->buttons()->getLocation()
                ]);
            }
            else {
                $this->send('{send_phone}', [
                    'buttons' => $this->buttons()->getPhone()
                ]);
            }
        }
    }

    public function create_ad_location($params) {
        if(MESSENGER == "Telegram") {
            if($this->getType() == "location") {
                $location = $this->getDataByType();
                $lat = $location['lat'];
                $lon = $location['lon'];
                $params['lat'] = $lat;
                $params['lon'] = $lon;

                if($this->addAd($params)) {
                    $this->send('{create_ad_success}', [
                        'buttons' => $this->buttons()->main_menu($this->getUserId())
                    ]);
                }
                else {
                    $this->send('{error}', [
                        'buttons' => $this->buttons()->main_menu($this->getUserId())
                    ]);
                }

                $this->delInteraction();
            }
            else {
                $this->send('{send_location}', [
                    'buttons' => $this->buttons()->getLocation()
                ]);
            }
        }
    }

    private function addAd($params) {
        $params['cities_id'] = $this->getCityId();
        $params['user_id'] = $this->getUserId();
        try {
            $id = $this->botService->createAd($params);
            return $id;
        }
        catch (Exception $e) {
            return null;
        }
    }

    public function my_ads() {
        $ads = $this->botService->getMyAds($this->getUserId());
        if(empty($ads->toArray())) {
            $this->send('{you_have_no_ads}', [
                'buttons' => $this->buttons()->main_menu($this->getUserId())
            ]);
        }

        $this->send('{select_ad}', [
            'buttons' => $this->buttons()->back()
        ]);
    }

}
