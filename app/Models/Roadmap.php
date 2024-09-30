<?php

namespace App\Models;

use CodeIgniter\Model;

class Roadmap extends Model {
    protected $table = 'roadmap';
    protected $allowedFields = [
        "kode_dosen",
        "tahun",
        "topik"
    ];

    public function getAll() {
        $table = $this->table;
        return $this->query("SELECT * FROM $table")
                    ->getResultArray();
    }

    public function getById($id) {
        $table = $this->table;
        $sql = "SELECT * FROM $table WHERE id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getByKodeDosen($kodeDosen) {
        $table = $this->table;
        $sql = "SELECT *
                FROM roadmap AS r
                WHERE r.kode_dosen = ?
                ORDER BY r.tahun DESC";
        return $this->query($sql, [$kodeDosen])
                    ->getResultArray();
    }

    public function getTableName() {return $this->table; }
}
