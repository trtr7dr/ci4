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
        $this->captcha = new \App\Libraries\Captcha();
        $this->session->start();
    }
    
    public function recaptcha(){
        return $this->captcha->img_code( $this->captcha->generate_code() );
    }

    public function sign_up() {
        if ($this->session->sid) {
            return redirect()->to('/');
        }
        $data['captcha'] = $this->captcha->img_code( $this->captcha->generate_code() );
        return view(self::$reg_template, $data);
    }
    
    public function registration() {
        $data['name'] = $this->request->getPost('name');
        $data['email'] = $this->request->getPost('email');
        $data['password'] = $this->_password($this->request->getPost('pass'), $data['email']);
        $data['captcha'] = $this->request->getPost('captcha');

        $this->validation->setRules( $this->user->valid_rules() );
        
        $cap = $this->captcha->check($data['captcha']); 
        if($cap !== ''){
            $cap['captcha'] = $this->captcha->img_code( $this->captcha->generate_code() );
            return view(self::$reg_template, $cap);
        }
        
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
        $data['captcha'] = $this->captcha->img_code( $this->captcha->generate_code() );
        return view(self::$login_template, $data);
    }

    public function login(){
        $data = [];
        $data['email'] = $this->request->getPost('email');
        $data['password'] = $this->_password($this->request->getPost('pass'), $data['email']);
        $data['captcha'] = $this->request->getPost('captcha');
        
        $cap = $this->captcha->check($data['captcha']); 
        if($cap !== ''){
            $cap['captcha'] = $this->captcha->img_code( $this->captcha->generate_code() );
            return view(self::$login_template, $cap);
        }
        
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
