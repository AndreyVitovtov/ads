<?php


namespace App\Services\Contracts;


interface CityService {
    function create(string $name, int $country_id): int;
    function getByCountryId(int $country_id);
    function edit(int $id, string $name, int $country_id): void;
    function delete(int $id): void;
    function get(int $id);
    function paginate(int $country_id, int $count);
}
