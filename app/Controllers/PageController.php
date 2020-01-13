<?php

namespace App\Controllers;

class PageController extends BaseController {

    public function __construct() {
        $this->model = new \App\Models\PageModel();
    }

    public function show($url) {

        $data = $this->model
                ->where('url', $url)
                ->firstOrFail();
        
        if(empty($data)){
           set_status_header('404');
        }
      
        return view('page/template/' . $data['url'], $data);
    }

}
