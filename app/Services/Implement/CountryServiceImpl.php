<?php


namespace App\Services\Implement;


use App\models\City;
use App\models\Country;
use App\Services\Contracts\CountryService;
use Exception;
use Illuminate\Support\Facades\DB;

class CountryServiceImpl implements CountryService {

    function create($name): int {
        try {
            DB::beginTransaction();
            $country = new Country();
            $country->name = $name;
            $country->save();

            $city = new City();
            $city->name = ANY_CITY;
            $city->country_id = $country->id;
            $city->save();

            DB::commit();

            return $country->id;
        }
        catch (Exception $e) {
            DB::rollBack();
            return null;
        }
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
