<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model {

    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['url', 'type', 'title', 'text', 'created', 'pre_img', 'gallery', 'description', 'keywords'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    public function more($id, $lim = 2) {
        return $this->where('id <', $id)->orderBy('id', 'DESC')->findAll($lim);
    }
    
}
