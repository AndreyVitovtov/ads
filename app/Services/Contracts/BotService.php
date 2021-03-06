<?php


namespace App\Services\Contracts;


interface BotService {
    function getCountries(int $page, int $count);
    function getCitiesByCountry(int $countryId, int $page, int $count);
    function getAdsByTitle(string $str, int $cityId);
    function getRubrics(int $page, int $count);
    function getSubsectionsByRubric(int $rubricId, int $page, int $count);
    function getAdsBySubsection(int $subsectionId, int $cityId);
    function getMyAds(int $userId, int $page, int $count);
    function getAdById(int $adId);
    function createAd(array $ad): int;
    function editTitleAd(int $adId, string $title): void;
    function editDescriptionAd(int $adId, string $description): void;
    function editPhotoAd(int $adId, string $photo): void;
    function deleteAd(int $adId): void;
    function savePhoto($path): ? string;
}
