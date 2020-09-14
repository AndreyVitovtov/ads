<?php


namespace App\Services\Contracts;


interface CountryService {
    function create($name): int;
    function rename($id, $name): void;
    function delete($id): void;
    function get($id);
    function getCities($country_id);
    function all();
    function paginate(int $count);
}
