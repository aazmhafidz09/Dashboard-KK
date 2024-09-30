<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dosen';

    public function getDosen($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            $sql = "SELECT 
                        *,
                        IF(program_studi LIKE '%ITTS%',
                            'Surabaya',
                            IF(program_studi LIKE '%TUKJ%',
                                'Jakarta',
                                'Bandung'
                            )
                        ) AS lokasi_kerja
                    FROM dosen";
            return $this->query($sql)->getResultArray();
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

    public function getAllKodeDosen() {
        $query = $this->select("kode_dosen")->findAll();
        $result = [];
        foreach($query as $q) {
            array_push($result, $q["kode_dosen"]);
        }

        return $result;

    }
}
