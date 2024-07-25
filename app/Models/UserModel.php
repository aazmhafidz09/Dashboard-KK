<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';

    public function getByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $query = $this->db->query($sql, [$email]);

        return $query->getRow();
    }
}


?>