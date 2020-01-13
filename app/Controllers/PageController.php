<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController {

    use ResponseTrait;

    public function __construct() {

        $this->model = new \App\Models\PageModel();
    }

    public function show($url) {

        $data = $this->model
                ->where('url', $url)
                ->first();
        
        if (empty($data)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('page/template/' . $data['url'], $data);
    }

}
