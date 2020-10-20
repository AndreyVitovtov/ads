<?php

namespace App\Http\Controllers\Admin;

use App\Services\Contracts\RubricService;
use App\Services\Contracts\SubsectionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubsectionsController extends Controller {

    /**
     * @var SubsectionService
     */
    private $subsectionService;
    /**
     * @var RubricService
     */
    private $rubricService;

    public function __construct(SubsectionService $subsectionService, RubricService $rubricService) {
        $this->subsectionService = $subsectionService;
        $this->rubricService = $rubricService;
    }

    public function listSubsections($id) {
        return view('admin.subsections.listSubsections', [
            'rubric' => $this->rubricService->get($id),
            'subsections' => $this->rubricService->getSubsections($id),
            'menuItem' => 'subsectionslist'
        ]);
    }

    public function list() {
        return view('admin.subsections.list', [
            'rubrics' => $this->rubricService->all(),
            'menuItem' => 'subsectionslist'
        ]);
    }

    public function go(Request $request) {
        return redirect()->to(route('subsections-rubric', [
            'id' => $request->post('rubric')
        ]));
    }

    public function add($id = null) {
        return view('admin.subsections.add', [
            'rubrics' => $this->rubricService->all(),
            'menuItem' => 'subsectionsadd',
            'id' => $id
        ]);
    }

    public function addSave(Request $request) {
        $this->subsectionService->create($request->post('name'), $request->post('rubric_id'));

        if($request->post('add_more')) {
            return redirect()->to(route('subsections-add', [
                'id' => $request->post('rubric_id')
            ]));
        }
        else {
            return redirect()->to(route('subsections-rubric', [
                'id' => $request->post('rubric_id')
            ]));
        }
    }

    public function edit(Request $request) {
        return view('admin.subsections.edit', [
            'rubrics' => $this->rubricService->all(),
            'subsection' => $this->subsectionService->get($request->post('id')),
            'menuItem' => 'subsectionslist'
        ]);
    }

    public function editSave(Request $request) {
        $this->subsectionService->edit($request->post('id'), $request->post('name'), $request->post('rubric_id'));
        return redirect()->to(route('subsections-rubric', [
            'id' => $request->post('rubric_id')
        ]));
    }

    public function delete(Request $request) {
        $this->subsectionService->delete($request->post('id'));
        return redirect()->to(route('subsections-rubric', [
            'id' => $request->post('rubric_id')
        ]));
    }
}
