<?php

namespace App\Controllers;

class IndexController extends BaseController {

    public function index() : string{
        $model = new \App\Models\NewsModel();
        $data = [
            'news' => $model->orderBy('id', 'DESC')->paginate(2),
            'pager' => $model->pager
        ];
        return view('welcome_message', $data);
    }

}
