<?php

namespace App\Controllers;

class IndexController extends BaseController {

    public function index() {
        $model = new \App\Models\NewsModel();
        $data = [
            'news' => $model->paginate(1),
            'pager' => $model->pager
        ];
        return view('welcome_message', $data);
    }

}
