<?php

namespace App\Models;

use CodeIgniter\Model;

class LogPublikasi extends Model {
    protected $table = 'LogPublikasi';
    protected $allowedFields = [
        "user_id",
        "publikasi_id",
        "date",
        "action",
        "value_before", 
        "value_after"
    ];

    public function getAll() {
        return $this->query("SELECT * FROM LogPublikasi")
                    ->getResultArray();
    }

    public function getByUserId($id) {
        $sql = "SELECT * FROM LogPublikasi WHERE user_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getByPublikasiId($id) {
        $sql = "SELECT * FROM LogPublikasi WHERE publikasi_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }
}
