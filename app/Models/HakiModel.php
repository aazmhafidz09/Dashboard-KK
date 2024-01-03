<?php

namespace App\Models;

use CodeIgniter\Model;

class HakiModel extends Model
{
    protected $table = 'haki';

    public function getHaki($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }

        $query = $this->db->query("SELECT * FROM haki WHERE (ketua = '$kode_dosen' or anggota_1 = '$kode_dosen' or anggota_2 = '$kode_dosen' or anggota_3 = '$kode_dosen' or anggota_4 = '$kode_dosen' or anggota_5 = '$kode_dosen' or anggota_6 = '$kode_dosen' or anggota_7 = '$kode_dosen' or anggota_8 = '$kode_dosen' or anggota_9 = '$kode_dosen')");
        return $query->getResultArray();
    }
    public function getJumlahHaki($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_haki FROM haki WHERE (ketua = '$kode_dosen' or anggota_1 = '$kode_dosen' or anggota_2 = '$kode_dosen' or anggota_3 = '$kode_dosen' or anggota_4 = '$kode_dosen' or anggota_5 = '$kode_dosen' or anggota_6 = '$kode_dosen' or anggota_7 = '$kode_dosen' or anggota_8 = '$kode_dosen' or anggota_9 = '$kode_dosen')");
        return $query->getRow()->jumlah_haki;
        // return $query->row()->average_score;
    }
    public function getJumlahKetuaHaki($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_ketua FROM haki WHERE (ketua = '$kode_dosen')");
        return $query->getRow()->jumlah_ketua;
        // return $query->row()->average_score;

    }
    public function getHakiTotal()
    {
        $query = $this->db->query("SELECT COUNT(id) as count_haki FROM haki");
        return $query->getRow()->count_haki;
    }
    public function getPeningkatanHaki()
    {
        $query = $this->db->query("SELECT tahun AS tahun_sekarang, (SELECT COUNT(*) FROM haki 
        WHERE tahun = tahun_sekarang) AS jumlah_tahun_sekarang, (SELECT COUNT(*) FROM haki WHERE tahun = tahun_sekarang - 1) 
        AS jumlah_tahun_sebelumnya, (SELECT COUNT(*) FROM haki WHERE tahun = tahun_sekarang) - (SELECT COUNT(*) 
        FROM haki WHERE tahun = tahun_sekarang - 1) AS peningkatan_data FROM haki WHERE tahun = 2023 OR tahun = 2023 - 1");
        return $query->getRow()->peningkatan_data;
    }
}
