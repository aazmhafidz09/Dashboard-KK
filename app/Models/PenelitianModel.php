<?php

namespace App\Models;

use CodeIgniter\Model;

class PenelitianModel extends Model
{
    protected $table = 'penelitian';

    public function getPenelitian($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }

        $query = $this->db->query("SELECT * FROM penelitian WHERE (ketua_peneliti = '$kode_dosen' or anggota_peneliti_1 = '$kode_dosen' or anggota_peneliti_2 = '$kode_dosen' or anggota_peneliti_3 = '$kode_dosen' or anggota_peneliti_4 = '$kode_dosen')");
        return $query->getResultArray();
    }
    public function getJumlahPenelitian($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_penelitian FROM penelitian WHERE (ketua_peneliti = '$kode_dosen' or anggota_peneliti_1 = '$kode_dosen' or anggota_peneliti_2 = '$kode_dosen' or anggota_peneliti_3 = '$kode_dosen' or anggota_peneliti_4 = '$kode_dosen')");
        return $query->getRow()->jumlah_penelitian;
        // return $query->row()->average_score;
    }
    public function getJumlahKetuaPeneliti($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_ketua_peneliti FROM penelitian WHERE (ketua_peneliti = '$kode_dosen')");
        return $query->getRow()->jumlah_ketua_peneliti;
        // return $query->row()->average_score;
    }
}
