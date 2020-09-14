<?php


namespace App\Services\Implement;


use App\models\Subsection;
use App\Services\Contracts\SubsectionService;

class SubsectionServiceImpl implements SubsectionService {

    function create($name, $rubrics_id): int {
        $subsection = new Subsection();
        $subsection->name = $name;
        $subsection->rubrics_id = $rubrics_id;
        $subsection->save();

        return $subsection->id;
    }

    function rename($id, $name) {
        $subsection = Subsection::find($id);
        $subsection->name = $name;
        $subsection->save();
    }

    function delete($id) {
        Subsection::where('id', $id)->delete();
    }

    function getAds($subsection_id) {
        $subsection = Subsection::find($subsection_id);
        return $subsection->ads;
    }

    function get(int $id) {
        return Subsection::find($id);
    }

    function edit(int $id, string $name, int $rubric_id): void {
        $subsection = Subsection::find($id);
        $subsection->name = $name;
        $subsection->rubrics_id = $rubric_id;
        $subsection->save();
    }
}
