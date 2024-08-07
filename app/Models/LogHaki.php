<?php

namespace App\Models;

use CodeIgniter\Model;

class LogHaki extends Model {
    protected $table = 'LogHaki';
    protected $allowedFields = [
        "user_id",
        "haki_id",
        "action",
        "value_before", 
        "value_after"
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

    public function getByUserId($id) {
        $table = $this->table;
        $sql = "SELECT * FROM $table WHERE user_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getByHakiId($id) {
        $table = $this->table;
        $sql = "SELECT * FROM $table WHERE haki_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getRecentLogs($limit = null) {
        $table = $this->table;
        $sql = "SELECT 
                    lh.*,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lh
                JOIN users AS u
                    ON lh.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                ORDER BY lh.date DESC";
        
        if(!is_null($limit)) $sql .= " LIMIT $limit";
        return $this->query($sql)
                    ->getResultArray();
    }

    public function getWithUserInfo($id) {
        $table = $this->table;
        $sql = "SELECT 
                    lh.*,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lh
                JOIN users AS u
                    ON lh.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                WHERE lh.id = ?";
        return $this->query($sql, [$id])
                    ->getRowArray();
    }

    public function export() {
        $table = $this->table;
        $sql = "SELECT 
                    lh.id,
                    lh.haki_id,
                    lh.date,
                    lh.action,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lh
                JOIN users AS u
                    ON lh.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                ORDER BY lh.date DESC";
        return $this->query($sql)->getResultArray();
    }

    public function getTableName() {return $this->table; }
}
