<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Bot\Traits\RequestHandlerTrait;
use App\models\Ad;
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
             $this->sendCarusel([
                'richMedia' => $this->buttons()->countries(
                    $countries,
                    $page
                ),
                'rows' => count($countries) < 7 ? count($countries) : 7
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

            $this->sendCarusel([
                'richMedia' => $this->buttons()->cities(
                    $cities,
                    $countryId,
                    $page
                ),
                'rows' => count($cities) < 7 ? count($cities) : 7

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
            'buttons' => $this->buttons()->back(),
            'input' => 'regular'
        ]);
        $cityId = $this->getCityId();
        $this->setInteraction('search_ads_title', [
            'city_id' => $cityId
        ]);
    }

    public function search_ads_title() {
        $str = $this->getMessage();
        $ads = $this->botService->getAdsByTitle($str, $this->getUser()->cities_id);

        if(empty($ads->toArray())) {
            $this->send('{no_ads_found}', [
                'buttons' => $this->buttons()->search_ads()
            ]);
        }
        else {
            if(MESSENGER == 'Telegram') {

            }
            else {
                $this->sendCarusel([
                    'richMedia' => $this->buttons()->ads($ads),
                    'buttons' => $this->buttons()->search_ads()
                ]);
            }
        }
        $this->delInteraction();
    }

    public function open_ad($id) {
        $ad = Ad::find($id);
        $this->sendImage(url('photo_ad/'.$ad->photo), $ad->title, [
            'buttons' => $this->buttons()->back()
        ]);

        $this->send('{ad_viber}', [
            'buttons' => $this->buttons()->back()
        ], [
            'description' => $ad->description,
            'phone' => $ad->phone,
            'city' => $ad->city->name,
            'rubric' => $ad->subsection->rubric->name,
            'subsection' => $ad->subsection->name,
            'date' => $ad->date
        ]);
    }

    public function by_rubric($page = 1) {
        $page = (int) $page;
        $this->delInteraction();

        $this->send('{select_rubric}', [
            'buttons' => $this->buttons()->back()
        ]);

        if(MESSENGER == "Telegram") {
            $this->send('{rubrics}', [
                'inlineButtons' => InlineButtons::searchAdsByRubric(
                    $this->botService->getRubrics($page, 10),
                    $page
                )
            ]);
        }
        else {
            $rubrics = $this->botService->getRubrics($page, 30);
            $this->sendCarusel([
                'richMedia' => $this->buttons()->searchAdsByRurric(
                    $rubrics,
                    $page
                ),
                'rows' => count($rubrics) < 7 ? count($rubrics) : 7,
                'buttons' => $this->buttons()->back()
            ]);
        }
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

        if(MESSENGER == "Telegram") {
            $this->send('{select_subsection}', [
                'inlineButtons' => InlineButtons::searchAdsByRubricSubsection(
                    $this->botService->getSubsectionsByRubric($rubricId, $page, 10),
                    $rubricId,
                    $page
                )
            ]);
        }
        else {
            $subsections = $this->botService->getSubsectionsByRubric($rubricId, $page, 30);
            $this->sendCarusel([
                'richMedia' => $this->buttons()->searchAdsByRubricSubsection(
                    $subsections,
                    $rubricId,
                    $page
                ),
                'rows' => count($subsections) < 7 ? count($subsections) : 7,
                'buttons' => $this->buttons()->back()
            ]);
        }
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

        if(MESSENGER == "Telegram") {
            $this->send('{rubrics}', [
                'inlineButtons' => InlineButtons::createAdRubric(
                    $this->botService->getRubrics($page, 10),
                    $page
                )
            ]);
        }
        else {
            $rubrics = $this->botService->getRubrics($page, 30);
            $this->sendCarusel([
                'richMedia' => $this->buttons()->createAdRubric(
                    $rubrics,
                    $page
                ),
                'rows' => count($rubrics) < 7 ? count($rubrics) : 7,
                'buttons' => $this->buttons()->back()
            ]);
        }
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

        if(MESSENGER == "Telegram") {
            $this->send('{select_subsection}', [
                'inlineButtons' => InlineButtons::createAdSubsection(
                    $this->botService->getSubsectionsByRubric($rubricId, $page, 10),
                    $rubricId,
                    $page
                )
            ]);
        }
        else {
            $subsections = $this->botService->getSubsectionsByRubric($rubricId, $page, 30);
            $this->sendCarusel([
                'richMedia' => $this->buttons()->createAdSubsection(
                    $subsections,
                    $rubricId,
                    $page
                ),
                'rows' => count($subsections) < 7 ? count($subsections) : 7,
                'buttons' => $this->buttons()->back()
            ]);
        }
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
        else {
            if($this->getType() == 'picture') {
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
                    'buttons' => $this->buttons()->back(),
                    'input' => 'regular'
                ]);
            }
        }
    }

    public function create_ad_phone($params) {
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

    public function create_ad_location($params) {
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

    public function my_ads($page = 1) {
        $page = (int) $page;
        $ads = $this->botService->getMyAds($this->getUserId(), $page, MESSENGER == 'Telegram' ? 10 : 30);
        if(empty($ads->toArray())) {
            return $this->send('{you_have_no_ads}', [
                'buttons' => $this->buttons()->main_menu($this->getUserId())
            ]);
        }

        if(MESSENGER == "Telegram") {
            $this->send('{you_ads}', [
                'inlineButtons' => InlineButtons::myAds(
                    $ads,
                    $this->getUserId(),
                    $page
                )
            ]);
        }
        else {
            $myAds = $this->buttons()->myAds(
                $ads,
                $this->getUserId(),
                $page
            );
            $this->sendCarusel([
                'richMedia' => $myAds,
                'buttons' => $this->buttons()->back(),
                'rows' => count($myAds) < 7 ? count($myAds) : 7
            ]);
        }
    }

    public function settings_my_ad($id) {
        if(!is_array($id)) {
            $this->setInteraction('settings_my_ad', [
                'id' => $id
            ]);
        }
        else {
            $id = $id['id'];
        }

        $this->send('{settings_ad}', [
            'buttons' => $this->buttons()->settingsAd()
        ]);
    }

    public function delete_ad() {
        $params = $this->getParams();
        $ad = Ad::find($params->id);
        if($ad->users_id == $this->getUserId()) {
            $ad->delete();

            $this->send('{ad_deleted}', [
                'buttons' => $this->buttons()->main_menu($this->getUserId())
            ]);
        }
        else {
            $this->send('{error}', [
                'buttons' => $this->buttons()->main_menu($this->getUserId())
            ]);
        }
    }

    public function edit_title() {
        $this->send('{send_new_title}', [
            'buttons' => $this->buttons()->backToSettingsAd(),
            'input' => 'regular'
        ]);

        $params = $this->getParams(true);
        $this->setInteraction('edit_title_send_text', $params);
    }

    public function edit_title_send_text() {
        $title = $this->getMessage();
        $params = $this->getParams();
        $ad = Ad::find($params->id);
        $ad->title = $title;
        $ad->save();

        $this->send('{title_edited}', [
            'buttons' => $this->buttons()->settingsAd()
        ]);
    }

    public function edit_description() {
        $this->send('{send_new_description}', [
            'buttons' => $this->buttons()->backToSettingsAd(),
            'input' => 'regular'
        ]);

        $params = $this->getParams(true);
        $this->setInteraction('edit_description_send_text', $params);
    }

    public function edit_description_send_text() {
        $description = $this->getMessage();
        $params = $this->getParams();
        $ad = Ad::find($params->id);
        $ad->description = $description;
        $ad->save();

        $this->send('{description_edited}', [
            'buttons' => $this->buttons()->settingsAd()
        ]);
    }

    public function edit_location() {
        $this->send('{send_location}', [
            'buttons' => $this->buttons()->sendLocationBackToSettingsAd()
        ]);

        $params = $this->getParams(true);
        $this->setInteraction('edit_location_send_location', $params);
    }

    public function edit_location_send_location() {
        if($this->getType() == 'location') {
            $location = $this->getDataByType();
            $params = $this->getParams();
            $ad = Ad::find($params->id);
            $ad->lat = $location['lat'];
            $ad->lon = $location['lon'];
            $ad->save();

            $this->send('{location_edited}', [
                'buttons' => $this->buttons()->settingsAd()
            ]);
        }
        else {
            $this->edit_location();
        }
    }

    public function edit_photo() {
        $this->send('{send_photo}', [
            'buttons' => $this->buttons()->backToSettingsAd(),
            'input' => 'regular'
        ]);

        $params = $this->getParams(true);
        $this->setInteraction('edit_photo_send_photo', $params);
    }

    public function edit_photo_send_photo() {
        if($this->getType() == 'photo' || $this->getType() == 'picture') {
            $path = $this->getFilePath();
            $fn = $this->botService->savePhoto($path);
            if($fn) {
                $params = $this->getParams();
                $this->botService->editPhotoAd($params->id, $fn);

                $this->send('{photo_edited}', [
                    'buttons' => $this->buttons()->settingsAd()
                ]);
            }
        }
        else {
            $this->edit_photo();
        }
    }

    public function read_ad() {
        $params = $this->getParams();
        $ad = Ad::find($params->id);
        if(MESSENGER == 'Telegram') {
            $this->sendPhoto(url('photo_ad/'.$ad->photo), '{ad_telegram}', [
                'buttons' => $this->buttons()->settingsAd()
            ], [
                'title' => $ad->title,
                'description' => $ad->description,
                'phone' => $ad->phone,
                'city' => $ad->city->name,
                'rubric' => $ad->subsection->rubric->name,
                'subsection' => $ad->subsection->name,
                'date' => $ad->date
            ]);
        }
        else {
            $this->sendImage(url('photo_ad/'.$ad->photo), $ad->title, [
                'buttons' => $this->buttons()->settingsAd()
            ]);

            $this->send('{ad_viber}', [
                'buttons' => $this->buttons()->settingsAd()
            ], [
                'description' => $ad->description,
                'phone' => $ad->phone,
                'city' => $ad->city->name,
                'rubric' => $ad->subsection->rubric->name,
                'subsection' => $ad->subsection->name,
                'date' => $ad->date
            ]);
        }
    }

    public function back_to_settings_ad() {
        $params = $this->getParams(true);
        $this->setInteraction('settings_my_ad', $params);

        $this->send('{settings_ad}', [
            'buttons' => $this->buttons()->settingsAd()
        ]);
    }

}
