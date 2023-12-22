<?php

namespace App\Models;

use CodeIgniter\Model;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';

    public function getPublikasi($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }

        $query = $this->db->query("SELECT * FROM publikasi WHERE penulis_1 = '$kode_dosen'");
        return $query->getResultArray();
    }
    public function getJumlahPublikasi($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_publikasi FROM publikasi WHERE (penulis_1 = '$kode_dosen' or penulis_2 = '$kode_dosen' or penulis_3 = '$kode_dosen' or penulis_4 = '$kode_dosen' or penulis_5 = '$kode_dosen' or penulias_6 = '$kode_dosen')");
        return $query->getRow()->jumlah_publikasi;
        // return $query->row()->average_score;
    }
    public function getJumlahPublikasi_1($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_publikasi_1 FROM publikasi WHERE (penulis_1 = '$kode_dosen')");
        return $query->getRow()->jumlah_publikasi_1;
        // return $query->row()->average_score;
    }
}
