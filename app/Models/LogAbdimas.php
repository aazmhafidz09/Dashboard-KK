<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAbdimas extends Model {
    protected $table = 'LogAbdimas';
    protected $allowedFields = [
        "user_id",
        "abdimas_id",
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

    public function getByAbdimasId($id) {
        $table = $this->table;
        $sql = "SELECT * FROM $table WHERE abdimas_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getRecentLogs($number = 30) {
        $table = $this->table;
        $sql = "SELECT 
                    la.id,
                    la.abdimas_id,
                    la.date,
                    la.action,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS la
                JOIN users AS u
                    ON la.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                ORDER BY la.date DESC
                LIMIT $number";

        return $this->query($sql)
                    ->getResultArray();
    }

    public function getWithUserInfo($id) {
        $table = $this->table;
        $sql = "SELECT 
                    la.*,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS la
                JOIN users AS u
                    ON la.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                WHERE la.id = ?";
        return $this->query($sql, [$id])
                    ->getRowArray();
    }

    public function export() {
        $table = $this->table;
        $sql = "SELECT 
                    la.id,
                    la.abdimas_id,
                    la.date,
                    la.action,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS la
                JOIN users AS u
                    ON la.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                ORDER BY la.date DESC";

        return $this->query($sql)
                    ->getResultArray();
    }

    public function getTableName() {return $this->table; }
}
