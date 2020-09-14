<?php


namespace App\Services\Implement;


use App\models\Country;
use App\Services\Contracts\CountryService;

class CountryServiceImpl implements CountryService {

    function create($name): int {
        $country = new Country();
        $country->name = $name;
        $country->save();

        return $country->id;
    }

    function rename($id, $name): void {
        $country = Country::find($id);
        $country->name = $name;
        $country->save();
    }

    function delete($id): void {
        Country::where('id', $id)->delete();
    }

    function get($id) {
        return Country::find($id);
    }

    function getCities($country_id) {
        return Country::find($country_id)->cities;
    }

    function all() {
        return Country::all();
    }

    function paginate(int $count) {
        return Country::paginate($count);
    }
}
