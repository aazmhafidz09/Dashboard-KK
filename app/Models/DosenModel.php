<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dosen';

    public function getDosen($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        return $this->where(['kode_dosen' => $kode_dosen])->first();
    }
    public function getPublikasi($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
