<?php

use Repository\AdminContentRepository;

class AdminContentController extends BaseController {

    protected $layout = "layout.backoffice";
    protected $adminContent;

    public function __construct(AdminContentRepository $adminContent) {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('on' => array('post', 'get')));
        $this->adminContent = $adminContent;
    }

    public function getIndex() {

        $this->layout->content = View::make('backoffice.content')
            ->with('toShow', 'index');
    }

    public function getContent($whatToLoad) {

        $elements = $this->adminContent->loadContent($whatToLoad);
        $territories = False;
        if ($whatToLoad == 'region') {
            $territories = $this->adminContent->loadTerritory('territory');
        }
        $this->layout->content = View::make('backoffice.content')
            ->with('territories', $territories)
            ->with('toShow', $whatToLoad)
            ->with('elements', $elements);
    }

    public function postEdit() {
        $data = Input::get('data');
        $toEdit = Input::get('toEdit');
        if ($data == '') {
            return Redirect::to('adminContent/content/' . $toEdit)->with('flash_message', 'nothing inputed');
        } else {
            $id = Input::get('id');
            $active = Input::get('active');
            $edit = $this->adminContent->editContent($id, $toEdit, $data, $active);
            if ($edit == 'success') {
                return Redirect::to('adminContent/content/' . $toEdit);
            } else {
                return Redirect::to('adminContent/content/' . $toEdit)->with('flash_message', $toEdit . ' cant edit, some error');
            }
        }
    }

    public function postCreate() {
        $data = Input::get('data');
        $toCreate = Input::get('toCreate');
        if ($data == '') {
            return Redirect::to('adminContent/content/' . $toCreate)->with('flash_message', 'nothing inputed');
        } else {
            $create = $this->adminContent->createContent($toCreate, $data);
            if ($create == 'success') {
                return Redirect::to('adminContent/content/' . $toCreate);
            } else {
                return Redirect::to('adminContent/content/' . $toCreate)->with('flash_message', $toCreate . ' cant edit, some error');
            }
        }
    }

    public function postDelete() {

        $toEdit = Input::get('toEdit');
        $id = Input::get('id');
        $delete = $this->adminContent->deleteContent($id, $toEdit);
        if ($delete == 'success') {
            return Redirect::to('adminContent/content/' . $toEdit);
        } else {
            return Redirect::to('adminContent/content/' . $toEdit)->with('flash_message', $toEdit . ' cant delete, some error');
        }
    }

   

}
