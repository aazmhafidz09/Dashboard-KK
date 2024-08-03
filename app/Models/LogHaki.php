<?php

namespace App\Models;

use CodeIgniter\Model;

class LogHaki extends Model {
    protected $table = 'LogHaki';
    protected $allowedFields = [
        "user_id",
        "haki_id",
        "date",
        "action",
        "value_before", 
        "value_after"
    ];

    public function getAll() {
        return $this->query("SELECT * FROM LogHaki")
                    ->getResultArray();
    }

    public function getByUserId($id) {
        $sql = "SELECT * FROM LogHaki WHERE user_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getByHakiId($id) {
        $sql = "SELECT * FROM LogHaki WHERE haki_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }
}
