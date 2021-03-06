<?php


namespace App\Services\Implement;


use App\models\Ad;
use App\Services\Contracts\AdService;

class AdServiceImpl implements AdService {

    function create(array $a): int {
        $ad = new Ad();
        $ad->title = $a['title'];
        $ad->description = $a['description'];
        $ad->photo = $a['photo'];
        $ad->phone = $a['phone'];
        $ad->cities_id = $a['cities_id'];
        $ad->users_id = $a['users_id'];
        $ad->subsection_id = $a['subsection_id'];
        $ad->lat = $a['lat'];
        $ad->lon = $a['lon'];
        $ad->date = date("Y-m-d");
        $ad->time = date("H:i:s");

        if(isset($a['active'])) {
            $ad->active = $a['active'];
        }

        if(isset($a['grabber'])) {
            $ad->grabber = $a['grabber'];
        }

        $ad->save();

        return $ad->id;
    }

    function edit(int $id, array $a, $photo = null): void {
        $ad = Ad::find($id);
        $ad->title = $a['title'];
        $ad->description = $a['description'];
        $ad->phone = $a['phone'];
        $ad->cities_id = $a['city'];
        $ad->subsection_id = $a['subsection'];
        if($photo != null) {
            $ad->photo = $photo;
        }

        $location = explode(', ', $a['location']);
        $ad->lat = $location[0];
        $ad->lon = $location[1];

        $ad->save();
    }

    function delete(int $id): void {
        $this->deletePhoto($id);
        Ad::where('id', $id)->delete();
    }

    function activate(int $id): void {
        $ad = Ad::find($id);
        $ad->active = '1';
        $ad->save();
    }

    function editTitle(int $id, $title): void {
        $ad = Ad::find($id);
        $ad->title = $title;
        $ad->save();
    }

    function editDescription(int $id, $description) {
        $ad = Ad::find($id);
        $ad->description = $description;
        $ad->save();
    }

    function editPhoto(int $id, $photo) {
        $ad = Ad::find($id);
        if(file_exists(public_path('/img/img_ads/'.$ad->photo))) {
            unlink(public_path('/img/img_ads/'.$ad->photo));
        }
        $ad->photo = $photo;
        $ad->save();
    }

    function get(int $id) {
        return Ad::find($id);
    }

    function getOnModeration() {
        return Ad::where('active', '0')->get();
    }

    function getActive() {
        return Ad::where('active', '1')->get();
    }

    function getOnModerationPaginate(int $count) {
        return Ad::with('subsection')->where('active', '0')->paginate($count);
    }

    function getActivePaginate(int $count) {
        return Ad::where('active', '1')->paginate($count);
    }

    function deletePhoto(int $id) {
        $ad = Ad::find($id);
        $path = public_path()."/photo_ad/".$ad->photo;
        if(file_exists($path)) {
            unlink($path);
        }
    }
}
