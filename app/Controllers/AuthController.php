<?php

namespace App\Controllers;


class AuthController extends BaseController {

    protected $validation;
    protected $user;
    public static $reg_template = 'auth/reg';
    public static $login_template = 'auth/login';

    public function __construct() {
        $this->user = new \App\Models\UserModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        //$this->session->start();
    }
    

    public function sign_up() {
        if ($this->session->sid) {
            return redirect()->to('/');
        }
        return view(self::$reg_template);
    }

    public function registration() {
        $data = [];
        $data['name'] = $this->request->getPost('name');
        $data['email'] = $this->request->getPost('email');
        $data['password'] = $this->_password($this->request->getPost('pass'), $data['email']);
        $this->validation->setRules([
            'name' => 'required',
            'password' => 'required|min_length[6]',
            'email' => 'required|valid_email'
        ]);
        if ($this->validation->run($data) == FALSE) {
            $msg['error'] = 'Ошибка валидации. Проверьте данные.';
            return view(self::$reg_template, $msg);
        }
        if (!$this->add_new_user($data)) {
            $msg['error'] = 'Ошибка добавления. Дублирование имени или почты.';
            return view(self::$reg_template, $msg);
        }
        return redirect()->to('/login');
    }

    public function add_new_user(array $user) : bool{
        if ($this->user->find_user($user) !== NULL) {
            return FALSE;
        }
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password']
        ];
        $this->user->insert($data);
        return TRUE;
    }

    private function _password(string $pass, string $email) : string{
        return crypt($pass, $email);
    }

    public function sign_in() {
        if ($this->session->sid) {
            return redirect()->to('/');
        }
        return view(self::$login_template);
    }

    public function login(){
        $data = [];
        $data['email'] = $this->request->getPost('email');
        $data['password'] = $this->_password($this->request->getPost('pass'), $data['email']);
        
        $user = $this->_check_auth($data);
        if(!$user){
            $msg['error'] = 'Ошибка. Неверный логин или пароль.';
            return view(self::$login_template, $msg);
        }
        $this->auth($user);
        return redirect()->to('/');
        
    }

    private function _check_auth(array $user){
        $u = $this->user->get_pass_by_email($user['email']);
        $u_pass = (string)$u['password'];
        if ( !hash_equals($u_pass, $user['password']) || $u['password'] == NULL){
            return FALSE;
        }
        return $u;
    }
    
    public function auth(array $u) : bool{
        $this->session->sid = md5($u['email'] . $u['password'] . rand(0, PHP_INT_MAX));
        $this->user->set('sid', $this->session->sid)
                ->set('logged_at', time())
                ->where('id', $u['id'])
                ->update();
        return true;
    }
    
    public function logout() : object{
        $user = $this->user->get_by_sid($this->session->sid);
        $this->user->set('sid', '')
                ->where('id', $user['id'])
                ->update();
        $this->session->destroy();
        return redirect()->to('/');
    }
}
