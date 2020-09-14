<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Services\Contracts\CountryService;
use Illuminate\Http\Request;

class CountriesController extends Controller {

    /**
     * @var CountryService
     */
    private $countryService;

    public function __construct(CountryService $countryService) {
        $this->countryService = $countryService;
    }

    public function list() {
        return view('admin.countries.list', [
            'countries' => $this->countryService->paginate(15),
            'menuItem' => 'countrieslist'
        ]);
    }

    public function add() {
        return view('admin.countries.add', [
            'menuItem' => 'countriesadd'
        ]);
    }

    public function save(Request $request) {
        $this->countryService->create($request->post('name'));

        if($request->post('add_more')) {
            return redirect()->to(route('countries-add'));
        }
        else {
            return redirect()->to(route('countries-list'));
        }
    }

    public function edit(Request $request) {
        return view('admin/countries.edit', [
            'country' => $this->countryService->get($request->post('id')),
            'menuItem' => 'countrieslist',
        ]);
    }

    public function editSave(Request $request) {
        $this->countryService->rename($request->post('id'), $request->post('name'));
        return redirect()->to(route('countries-list'));
    }

    public function delete(Request $request) {
        $this->countryService->delete($request->post('id'));
        return redirect()->to(route('countries-list'));
    }
}
