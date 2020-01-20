<?php

namespace App\Controllers;

class IndexController extends BaseController {

    public function index() {
        $model = new \App\Models\NewsModel();
        $data = [
            'news' => $model->orderBy('title', 'DESC')->paginate(1),
            'pager' => $model->pager
        ];
        return view('welcome_message', $data);
    }

}
