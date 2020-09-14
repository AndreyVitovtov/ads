<?php

namespace App\Http\Controllers\Admin;

use App\Services\Contracts\AdService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdsController extends Controller {
    /**
     * @var AdService
     */
    private $adService;

    public function __construct(AdService $adService) {
        $this->adService = $adService;
    }

    public function active() {
        return view('admin.ads.moderation', [
            'ads' => $this->adService->getActivePaginate(15),
            'menuItem' => 'ads'
        ]);
    }

    public function moderation() {
        return view('admin.ads.moderation', [
            'ads' => $this->adService->getOnModerationPaginate(15),
            'menuItem' => 'adsmoderation'
        ]);
    }

    public function activeRubric() {

    }

    public function activeSubsection() {

    }

}
