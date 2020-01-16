<?php

namespace App\Controllers;

class NewsController extends BaseController {

    public static $RETURN_PAGE = '/admin';
    public static $LOAD_DIR = 'upload/image/news';
    public static $DEFAULT_IMAGE = 'upload/image/news/def.png';

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
        if (!is_dir(self::$LOAD_DIR . '/' . $data['url'])) {
            mkdir(self::$LOAD_DIR . '/' . $data['url'], 0777, TRUE);
        }
        $data['pre_img'] = $this->file_load($data['url']);
        $data['gallery'] = $this->files_upload($data['url']);
        $this->model->insert($data);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }

    public function file_validate($form) {
        return $this->validate([
                    $form => [
                        'uploaded[' . $form . ']',
                        'mime_in[' . $form . ',image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[' . $form . ',4096]',
                    ],
        ]);
    }

    public function file_load($folder) {
        $name = self::$DEFAULT_IMAGE;
        if ($this->file_validate('pre_img')) {
            $file = $file = $this->request->getFile('pre_img');
            $file->move(self::$LOAD_DIR . '/' . $folder);
            $name = $file->getName();
        }
        return $name;
    }

    public function get_type_by_mime($mime) {
        return '.' . end(explode('/', $mime));
    }

    public function files_upload($folder) {
        $files = $this->request->getFiles();
        $i = 0;
        foreach ($files['gallery'] as $file) {
            $i++;
            if ($file->isValid() && !$file->hasMoved()) {
                $file->move(self::$LOAD_DIR . '/' . $folder, $i . $this->get_type_by_mime($file->getMimeType()));
            }else{
                return FALSE;
            }
        }
        return TRUE;
    }

}
