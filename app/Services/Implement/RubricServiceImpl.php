<?php


namespace App\Services\Implement;


use App\models\Rubric;
use App\Services\Contracts\RubricService;

class RubricServiceImpl implements RubricService {

    function create($name): int {
        $rubric = new Rubric();
        $rubric->name = $name;
        $rubric->save();

        return $rubric->id;
    }

    function rename($id, $name): void {
        $rubric = Rubric::find($id);
        $rubric->name = $name;
        $rubric->save();
    }

    function delete($id): void {
        Rubric::where('id', $id)->delete();
    }

    function getSubsections($rubric_id) {
        $rubric = Rubric::find($rubric_id);
        return $rubric->subsections;
    }

    function all() {
        return Rubric::all();
    }

    function paginate(int $count) {
        return Rubric::paginate($count);
    }

    function get(int $id) {
        return Rubric::find($id);
    }
}
