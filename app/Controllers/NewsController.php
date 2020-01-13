<?php

namespace App\Controllers;

class NewsController extends BaseController {

    public function __construct() {
        $this->model = new \App\Models\NewsModel();
    }

    public function show($url) {
        $data = $this->model
                ->where('url', $url)
                ->first();
        return view('news/show', $data);
    }

}
