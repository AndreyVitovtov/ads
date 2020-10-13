<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\models\Admin;
use App\models\Permission;
use App\Services\Contracts\ModeratorsService;
use App\Services\Contracts\PermissionService;
use Illuminate\Http\Request;

class Moderators extends Controller {

    /**
     * @var ModeratorsService
     */
    private $moderatorsService;

    public function __construct(ModeratorsService $moderatorsService) {
        $this->moderatorsService = $moderatorsService;
    }


    public function permissions() {
        return view('admin.moderators.permissions', [
            'moderators' => Admin::all(),
            'permissions' => Permission::all(),
            'menuItem' => 'moderatorspermissions'
        ]);
    }

    public function add() {
        return view('admin.moderators.add', [
            'menuItem' => 'moderatorsadd'
        ]);
    }

    public function addSave(Request $request) {
        $this->moderatorsService->create($request->input());

        return redirect()->to(route('moderators-list'));
    }

    public function list() {
        return view('admin.moderators.list', [
            'moderators' => $this->moderatorsService->all(),
            'menuItem' => 'moderatorslist'
        ]);
    }

    public function edit(Request $request) {
        return view('admin.moderators.edit', [
            'moderator' => $this->moderatorsService->get($request->post('id')),
            'menuItem' => 'moderatorslist'
        ]);
    }

    public function editSave(Request $request) {
        $this->moderatorsService->edit($request->input());
        return redirect()->to(route('moderators-list'));
    }

    public function delete(Request $request) {
        $this->moderatorsService->delete($request->post('id'));
        return redirect()->to(route('moderators-list'));
    }

}
