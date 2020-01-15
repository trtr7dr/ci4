<?php

namespace App\Controllers;

class PageController extends BaseController {

    public static $RETURN_PAGE = '/admin';

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
        return view('page/template/' . $data['templates'], $data);
    }
    
    public function edit($id){
        $data['page'] = $this->model->find(intval($id));
        return view('page/edit' . $data['url'], $data);
    }
    
    public function update($id){
        $data = [
            'title' => $this->request->getPost('title'),
            'url' => $this->request->getPost('url'),
            'templates' => $this->request->getPost('template'),
            'content' => $this->request->getPost('content')
        ];
        $this->model->update(intval($id), $data);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }
    
    public function delete($id){
        $this->model->delete(['id' => intval($id)]);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }
    
    public function create(){
        return view('page/create');
    }
    
    public function addPage(){
        $data = [
            'title' => $this->request->getPost('title'),
            'url' => $this->request->getPost('url'),
            'templates' => $this->request->getPost('template'),
            'content' => $this->request->getPost('content')
        ];
        $this->model->insert($data);
        return redirect()->to(base_url() . self::$RETURN_PAGE);
    }
    
}