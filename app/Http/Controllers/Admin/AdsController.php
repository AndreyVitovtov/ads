<?php

namespace App\Http\Controllers\Admin;

use App\models\Ad;
use App\models\City;
use App\models\Country;
use App\models\Rubric;
use App\models\Subsection;
use App\Services\Contracts\AdService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdsController extends Controller {
    /**
     * @var AdService
     */
    private $adService;

    public function __construct(AdService $adService) {
        $this->adService = $adService;
    }

    public function active() {
        return view('admin.ads.active', [
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

    public function activate(Request $request) {
        $this->adService->activate($request->post('id'));
        return redirect()->to(route('ads-moderation'));
    }

    public function delete(Request $request) {
        $this->adService->delete($request->post('id'));

        $input = $request->input();
        if(isset($input['moderation'])) {
            return redirect()->to(route('ads-moderation'));
        }
        else {
            return redirect()->to(route('ads-active'));
        }
    }

    public function read($id) {
        $ad = $this->adService->get($id);
        $menuItem = $ad->active == 0 ? 'adsmoderation' : 'ads';
        return view('admin.ads.read', [
            'ad' => $ad,
            'menuItem' => $menuItem
        ]);
    }

    public function edit(Request $request) {
        $ad = $this->adService->get($request->post('id'));
        $menuItem = $ad->active == 0 ? 'adsmoderation' : 'ads';
        return view('admin.ads.edit', [
            'ad' => $ad,
            'menuItem' => $menuItem,
            'rubrics' => Rubric::all(),
            'subsections' => Subsection::where('rubrics_id', $ad->subsection->rubric->id)->get(),
            'countries' => Country::all(),
            'cities' => City::where('country_id', $ad->city->country->id)->get()
        ]);
    }

    public function editSave(Request $request) {
        $ad = $request->input();

        if($request->hasFile('photo')) {
            $ext = Input::file('photo')->getClientOriginalExtension();
            $fileName = md5(md5(time().rand(0, 100000).time())).".".$ext;
            $request->photo->move(public_path()."/photo_ad", $fileName);

            $this->adService->deletePhoto($ad['id']);
        }

        $this->adService->edit($ad['id'], $ad, isset($fileName) ? $fileName : null);

        $ad = Ad::find($ad['id']);
        if($ad->active == 1) {
            return redirect()->to(route('ads-active'));
        }
        else {
            return redirect()->to(route('ads-moderation'));
        }
    }

}
