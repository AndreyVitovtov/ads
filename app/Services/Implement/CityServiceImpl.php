<?php


namespace App\Services\Implement;


use App\models\City;
use App\models\Country;
use App\Services\Contracts\CityService;

class CityServiceImpl implements CityService {

    function create(string $name, int $country_id): int {
        $city = new City();
        $city->name = $name;
        $city->country_id = $country_id;
        $city->save();

        return $city->id;
    }

    function getByCountryId(int $country_id) {
        $country = Country::find($country_id);
        return $country->cities;
    }

    function edit(int $id, string $name, int $country_id): void {
        $city = City::find($id);
        $city->name = $name;
        $city->country_id = $country_id;
        $city->save();
    }

    function delete(int $id): void {
        City::where('id', $id)->delete();
    }

    function get(int $id) {
        return City::find($id);
    }

    function paginate(int $country_id, int $count) {
        return City::where('country_id', $country_id)->paginate($count);
    }
}
