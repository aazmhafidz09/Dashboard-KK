<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAbdimas extends Model {
    protected $table = 'LogAbdimas';
    protected $allowedFields = [
        "user_id",
        "abdimas_id",
        "date",
        "action",
        "value_before", 
        "value_after"
    ];

    public function getAll() {
        return $this->query("SELECT * FROM LogAbdimas")
                    ->getResultArray();
    }

    public function getByUserId($id) {
        $sql = "SELECT * FROM LogAbdimas WHERE user_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getByAbdimasId($id) {
        $sql = "SELECT * FROM LogAbdimas WHERE abdimas_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }
}
