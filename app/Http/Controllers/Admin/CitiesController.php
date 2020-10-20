<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Services\Contracts\CityService;
use App\Services\Contracts\CountryService;
use Illuminate\Http\Request;

class CitiesController extends Controller {
    /**
     * @var CityService
     */
    private $cityService;
    /**
     * @var CountryService
     */
    private $countryService;

    public function __construct(CityService $cityService, CountryService $countryService) {
        $this->cityService = $cityService;
        $this->countryService = $countryService;
    }

    public function list() {
        return view('admin.cities.list', [
           'countries' => $this->countryService->all(),
            'menuItem' => 'citieslist'
        ]);
    }

    public function go(Request $request) {
        return redirect()->to(route('cities-country', [
            'id' => $request->post('country')
        ]));
    }

    public function listCities($id) {
        return view('admin.cities.listCities', [
            'country' => $this->countryService->get($id),
            'cities' => $this->cityService->paginate($id, 15),
            'menuItem' => 'citieslist'
        ]);
    }

    public function add($id = null) {
        return view('admin.cities.add', [
            'countries' => $this->countryService->all(),
            'menuItem' => 'citiesadd',
            'id' => $id
        ]);
    }

    public function addSave(Request $request) {
        $this->cityService->create($request->post('name'), $request->post('country_id'));

        if($request->post('add_more')) {
            return redirect()->to(route('cities-add', [
                'id' => $request->post('country_id')
            ]));
        }
        else {
            return redirect()->to(route('cities-country', [
                'id' => $request->post('country_id')
            ]));
        }
    }

    public function edit(Request $request) {
        return view('admin.cities.edit', [
            'city' => $this->cityService->get($request->post('id')),
            'countries' => $this->countryService->all(),
            'menuItem' => 'citieslist'
        ]);
    }

    public function editSave(Request $request) {
        $this->cityService->edit($request->post('id'), $request->post('name'), $request->post('country_id'));
        return redirect()->to(route('cities-country', [
            'id' => $request->post('country_id')
        ]));
    }

    public function delete(Request $request) {
        $this->cityService->delete($request->post('id'));
        return redirect()->to(route('cities-country', [
            'id' => $request->post('country_id')
        ]));
    }
}
