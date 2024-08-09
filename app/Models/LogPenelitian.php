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

    public function getByPenelitianId($id) {
        $table = $this->table;
        $sql = "SELECT * FROM $table WHERE penelitian_id=?";
        return $this->query($sql, [$id])
                    ->getResultArray();
    }

    public function getRecentLogs($limit = null) {
        $table = $this->table;
        $sql = "SELECT 
                    lp.*,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lp
                JOIN users AS u
                    ON lp.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                ORDER BY lp.date DESC";
        
        if(!is_null($limit)) $sql .= " LIMIT $limit";
        return $this->query($sql)
                    ->getResultArray();
    }

    public function getWithUserInfo($id) {
        $table = $this->table;
        $sql = "SELECT 
                    lp.*,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lp
                JOIN users AS u
                    ON lp.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                WHERE lp.id = ?";
        return $this->query($sql, [$id])
                    ->getRowArray();
    }

    public function export() {
        $table = $this->table;
        $sql = "SELECT 
                    lp.id,
                    lp.penelitian_id,
                    lp.date,
                    lp.action,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lp
                JOIN users AS u
                    ON lp.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                ORDER BY lp.date DESC";
        return $this->query($sql)->getResultArray();
    }

    public function getAllByYear($year = null) {
        $table = $this->table;

        if(is_null($year)) {
        $sql = "SELECT 
                    lp.*,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lp
                JOIN users AS u
                    ON lp.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                ORDER BY lp.date DESC";

            return $this->query($sql)
                        ->getResultArray();
        }

        $sql = "SELECT 
                    lp.*,
                    u.username,
                    u.email,
                    d.kode_dosen
                FROM $table AS lp
                JOIN users AS u
                    ON lp.user_id = u.id
                LEFT JOIN dosen AS d
                    ON d.kode_dosen = u.kode_dosen
                WHERE YEAR(lp.date) = ?
                ORDER BY lp.date DESC";
        
        return $this->query($sql, [$year])
                    ->getResultArray();
    }

    public function getTableName() {return $this->table; }
}
