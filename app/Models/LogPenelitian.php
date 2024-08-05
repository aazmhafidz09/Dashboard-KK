<?php

namespace App\Models;

use CodeIgniter\Model;

class LogPenelitian extends Model {
    protected $table = 'LogPenelitian';
    protected $allowedFields = [
        "user_id",
        "penelitian_id",
        "action",
        "value_before", 
        "value_after"
    ];

    public function getAll() {
        return $this->query("SELECT * FROM LogPenelitian")
                    ->getResultArray();
    }

    public function getByUserId($id) {
        $sql = "SELECT * FROM LogPenelitian WHERE user_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getByPenelitianId($id) {
        $sql = "SELECT * FROM LogPenelitian WHERE penelitian_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getTableName() {return $this->table; }
}
