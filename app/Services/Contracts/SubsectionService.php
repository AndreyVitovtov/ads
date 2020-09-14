<?php


namespace App\Services\Contracts;


interface SubsectionService {
    function create($name, $rubrics_id): int;
    function rename($id, $name);
    function delete($id);
    function getAds($subsection_id);
    function get(int $id);
    function edit(int $id, string $name, int $rubric_id): void;
}
