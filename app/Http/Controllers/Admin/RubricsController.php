<?php

namespace App\Http\Controllers\Admin;

use App\Services\Contracts\RubricService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RubricsController extends Controller {

    /**
     * @var RubricService
     */
    private $rubricService;

    public function __construct(RubricService $rubricService) {
        $this->rubricService = $rubricService;
    }

    public function list() {
        return view('admin.rubrics.list', [
            'rubrics' => $this->rubricService->paginate(15),
            'menuItem' => 'rubricslist'
        ]);
    }

    public function add() {
        return view('admin.rubrics.add', [
            'menuItem' => 'rubricsadd'
        ]);
    }

    public function addSave(Request $request) {
        $this->rubricService->create($request->post('name'));
        if($request->post('add_more')) {
            return redirect()->to(route('rubrics-add'));
        }
        else {
            return redirect()->to(route('rubrics-list'));
        }
    }

    public function edit(Request $request) {
        return view('admin.rubrics.edit', [
            'rubric' => $this->rubricService->get($request->post('id')),
            'menuItem' => 'rubricslist'
        ]);
    }

    public function editSave(Request $request) {
        $this->rubricService->rename($request->post('id'), $request->post('name'));
        return redirect()->to(route('rubrics-list'));
    }

    public function delete(Request $request) {
        $this->rubricService->delete($request->post('id'));
        return redirect()->to(route('rubrics-list'));
    }
}
