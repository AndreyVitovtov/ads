<?php


namespace App\Services\Contracts;


interface AdService {
    function create(array $ad): int;
    function edit(int $id, array $ad, $photo = null): void;
    function delete(int $id): void;
    function activate(int $id): void;
    function editTitle(int $id, $title): void;
    function editDescription(int $id, $description);
    function editPhoto(int $id, $photo);
    function get(int $id);
    function getOnModeration();
    function getActive();
    function getOnModerationPaginate(int $count);
    function getActivePaginate(int $count);
    function deletePhoto(int $id);
}
