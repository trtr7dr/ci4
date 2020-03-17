<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'email', 'verificate', 'password', 'admin', 'sid', 'logged_at'];
    protected $useTimestamps = false;

    public function find_user($data) {
        return $this->where('name', $data['name'])->orWhere('email', $data['email'])->first();
    }
    
    public function get_pass_by_email($mail){
        return $this->where('email', $mail)->first();
    }
    
    public function get_by_sid($sid){
        return $this->where('sid', $sid)->first();
    }
    public function valid_rules(){
        return ['name' => 'required',
                'password' => 'required|min_length[6]',
                'email' => 'required|valid_email',
                'captcha' => 'required|min_length[4]'
            ];
    }

}
