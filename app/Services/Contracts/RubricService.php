<?php


namespace App\Services\Contracts;


interface RubricService {
    function create($name): int;
    function rename($id, $name): void;
    function delete($id): void;
    function getSubsections($rubric_id);
    function all();
    function paginate(int $count);
    function get(int $id);
}
