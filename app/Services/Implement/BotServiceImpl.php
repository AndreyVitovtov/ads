<?php


namespace App\Services\Implement;


use App\models\Ad;
use App\models\City;
use App\models\Country;
use App\models\Rubric;
use App\models\Subsection;
use App\Services\Contracts\BotService;

class BotServiceImpl implements BotService {

    function getCountries(int $page, int $count) {
        $offset = $count * ($page - 1);
        return Country::offset($offset)->limit($count)->get();
    }

    function getCitiesByCountry(int $countryId, int $page, int $count) {
        $offset = $count * ($page - 1);
        return City::where('country_id', $countryId)->offset($offset)->limit($count)->get();
    }

    function getAdsByTitle(string $str) {
        return Ad::where('title', 'LIKE', '%'.$str.'%')->get();
    }

    function getRubrics() {
        return Rubric::all();
    }

    function getSubsectionsByRubric(int $rubricId) {
        return Subsection::where('rubrics_id', $rubricId)->get();
    }

    function getAdsBySubsection(int $subsectionId) {
        return Ad::where('subsection_id', $subsectionId)->get();
    }

    function getMyAds(int $userId) {
        Ad::where('users_id', $userId)->get();
    }

    function getAdById(int $adId) {
        return Ad::find($adId);
    }

    function createAd(array $a): int {
        $ad = new Ad();

        $ad->title = $a['title'];
        $ad->description = $a['description'];
        $ad->photo = $a['photo'];
        $ad->phone = $a['photo'];
        $ad->cities_id = $a['cities_id'];
        $ad->users_id = $a['user_id'];
        $ad->subsection_id = $a['subsection_id'];
        $ad->active = 0;
        $ad->date = date('Y-m-d');
        $ad->time = date('H:i:s');

        $ad->save();

        return $ad->id;
    }

    function editTitleAd(int $adId, string $title): void {
        Ad::where('id', $adId)->update('title', $title);
    }

    function editDescriptionAd(int $adId, string $description): void {
        Ad::where('id', $adId)->update('description', $description);
    }

    function editPhotoAd(int $adId, string $photo): void {
        $ad = Ad::find($adId);
        unlink(public_path()."/photo_ad/".$ad->photo);
        $ad->photo = $photo;
        $ad->save();
    }

    function deleteAd(int $adId): void {
        Ad::where('id', $adId)->delete();
    }
}
