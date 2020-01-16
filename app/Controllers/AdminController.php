<?php

namespace App\Controllers;

class AdminController extends BaseController {

    public function __construct() {
        $this->session = \Config\Services::session();
        $this->user = new \App\Models\UserModel();
        
        $user = $this->user->get_by_sid($this->session->sid);
        if(!$user || $user['admin'] == 0){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->page = new \App\Models\PageModel();
        $this->news = new \App\Models\NewsModel();
    }
    
    public function index(){
        $data = [
            'news' => $this->news->paginate(20),
            'pages' => $this->page->where('public', 1)->findAll(),
            'pager' => $this->news->pager
        ];

        return view('admin-panel/board', $data);
    }
}