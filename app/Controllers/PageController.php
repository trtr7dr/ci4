<?php

namespace App\Controllers;

class PageController extends BaseController {

    public static $RETURN_PAGE = '/admin';

    public function __construct() {
        $this->model = new \App\Models\PageModel();
    }

    public function show(string $url) : string{ 
        $data = $this->model
                ->where('url', $url)
                ->first();
        
        if (empty($data)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('page/template/' . $data['templates'], $data);
    }
    
    public function edit(int $id) : string{
        $data['page'] = $this->model->find(intval($id));
        return view('page/edit' . $data['url'], $data);
    }
    
    public function update(int $id) : object{
        $data = [
            'title' => $this->request->getPost('title'),
            'url' => $this->request->getPost('url'),
            'templates' => $this->request->getPost('template'),
            'content' => $this->request->getPost('content'),
            'description' => $this->request->getPost('description'),
            'keywords' => $this->request->getPost('keywords')
        ];
        $this->model->update(intval($id), $data);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }
    
    public function delete(int $id) : object{
        $this->model->delete(['id' => intval($id)]);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }
    
    public function create() : string{
        return view('page/create');
    }
    
    public function addPage() : object{
        $data = [
            'title' => $this->request->getPost('title'),
            'url' => $this->request->getPost('url'),
            'templates' => $this->request->getPost('template'),
            'content' => $this->request->getPost('content'),
            'description' => $this->request->getPost('description'),
            'keywords' => $this->request->getPost('keywords')
        ];
        $this->model->insert($data);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }
    
}