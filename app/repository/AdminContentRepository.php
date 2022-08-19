<?php

namespace Repository;

use Region;
use Input;
use DB;
use Territory;
use Category;
use Transportation;
use Facility;
use Feature;

class AdminContentRepository {

    public function loadContent($whatToLoad = null) {
        if ($whatToLoad == 'territory') {
            $list = Territory::all();
        } elseif ($whatToLoad == 'region') {
            $list = Region::all();
        } elseif ($whatToLoad == 'category') {
            $list = Category::all();
        } elseif ($whatToLoad == 'feature') {
            $list = Feature::all();
        } elseif ($whatToLoad == 'transportation') {
            $list = Transportation::all();
        } elseif ($whatToLoad == 'facility') {
            $list = Facility::all();
        }
        return $list;
    }

    public function loadTerritory($whatToLoad = null) {
        $list = DB::table('territory')->where('active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');
        return $list;
    }

    public function editContent($id = null, $toEdit = null, $data = null, $active = null) {
        if ($toEdit == 'territory') {
            $content = Territory::find($id);
        } elseif ($toEdit == 'region') {
            $content = Region::find($id);
            $content->territory_id = Input::get('territoryId');
        } elseif ($toEdit == 'category') {
            $content = Category::find($id);
        } elseif ($toEdit == 'feature') {
            $content = Feature::find($id);
        } elseif ($toEdit == 'transportation') {
            $content = Transporation::find($id);
        } elseif ($toEdit == 'facility') {
            $content = Facility::find($id);
        }
        $content->name = $data;
        $content->active = $active;
        $content->save();
        return 'success';
    }

    public function createContent($toCreate = null, $data = null) {
        if ($toCreate == 'territory') {
            $content = new Territory;
        } elseif ($toCreate == 'region') {
            $content = new Region;
            $content->territory_id = Input::get('territoryId');
        } elseif ($toCreate == 'category') {
            $content = new Category;
        } elseif ($toCreate == 'feature') {
            $content = new Feature;
        } elseif ($toCreate == 'transportation') {
            $content = new Transporation;
        } elseif ($toCreate == 'facility') {
            $content = new Facility;
        }
        $content->name = $data;
        $content->active = 1;
        $content->save();
        return 'success';
    }

    public function deleteContent($id = null, $toEdit = null) {
        if ($toEdit == 'territory') {
            $content = Territory::find($id);
        } elseif ($toEdit == 'region') {
            $content = Region::find($id);
        } elseif ($toEdit == 'category') {
            $content = Category::find($id);
        } elseif ($toEdit == 'feature') {
            $content = Feature::find($id);
        } elseif ($toEdit == 'transportation') {
            $content = Transporation::find($id);
        } elseif ($toEdit == 'facility') {
            $content = Facility::find($id);
        }
        $content->delete();
        return 'success';
    }


}
