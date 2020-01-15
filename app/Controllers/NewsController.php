<?php

namespace App\Controllers;

class NewsController extends BaseController {

    public static $RETURN_PAGE = '/admin';

    public function __construct() {
        $this->model = new \App\Models\NewsModel();
    }

    public function show($url) {
        $data = $this->model
                ->where('url', $url)
                ->first();
        if (empty($data)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('news/show', $data);
    }

    public function create() {
        
        return view('news/create');
    }

    public function addNews() {
        $data = [
            'title' => $this->request->getPost('title'),
            'url' => $this->request->getPost('url'),
            'text' => $this->request->getPost('text')
        ];

        $file = $this->request->getPost('pre_img');
        $file = $this->request->getFile('pre_img');
        $file->move('/upload/image/news/', '1');
        print_r($file);
        

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move('/upload/image/news/tst');
        }
        exit();
        if ($file) {
            $file = $file->getFile('pre_img');
            if ($file->getType() === "image/jpg") {
                $name = 'prew-' . date("Y-m-d_H:i:s");
                $file->move('/upload/image/news', $name);
            }
            $data['pre_img'] = '/upload/image/news' . $name;
        }

        print_r($name);


        $this->model->insert($data);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }

}
