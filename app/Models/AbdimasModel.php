<?php

namespace App\Models;

use CodeIgniter\Model;

class AbdimasModel extends Model
{
    protected $table = 'abdimas';

    public function getAbdimas($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }

        $query = $this->db->query("SELECT * FROM abdimas WHERE (ketua = '$kode_dosen' or anggota_1 = '$kode_dosen' or anggota_2 = '$kode_dosen' or anggota_3 = '$kode_dosen' or anggota_4 = '$kode_dosen' or anggota_5 = '$kode_dosen')");
        return $query->getResultArray();
    }
    public function getJumlahAbdimas($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_abdimas FROM abdimas WHERE (ketua = '$kode_dosen' or anggota_1 = '$kode_dosen' or anggota_2 = '$kode_dosen' or anggota_3 = '$kode_dosen' or anggota_4 = '$kode_dosen' or anggota_5 = '$kode_dosen')");
        return $query->getRow()->jumlah_abdimas;
        // return $query->row()->average_score;
    }
    public function getJumlahKetua($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_ketua FROM abdimas WHERE (ketua = '$kode_dosen')");
        return $query->getRow()->jumlah_ketua;
        // return $query->row()->average_score;
    }
    public function getAbdimasTotal()
    {
        $query = $this->db->query("SELECT COUNT(id) as count_abdimas FROM abdimas");
        return $query->getRow()->count_abdimas;
    }
    public function getPeningkatanAbdimas()
    {
        $query = $this->db->query("SELECT tahun AS tahun_sekarang, (SELECT COUNT(*) FROM abdimas 
        WHERE tahun = tahun_sekarang) AS jumlah_tahun_sekarang, (SELECT COUNT(*) FROM abdimas WHERE tahun = tahun_sekarang - 1) 
        AS jumlah_tahun_sebelumnya, (SELECT COUNT(*) FROM abdimas WHERE tahun = tahun_sekarang) - (SELECT COUNT(*) 
        FROM abdimas WHERE tahun = tahun_sekarang - 1) AS peningkatan_data FROM abdimas WHERE tahun = YEAR(NOW()) OR tahun = YEAR(NOW()) - 1");
        return $query->getRow()->peningkatan_data;
    }

    // Semua Tahun 
    public function getAbdimasInter()
    {
        $query = $this->db->query("SELECT COUNT(*) AS abd_inter FROM abdimas WHERE jenis = 'internal' OR jenis='INTERNAL'");
        return $query->getRow()->abd_inter;
    }
    public function getAbdimasEkste()
    {
        $query = $this->db->query("SELECT COUNT(*) AS abd_ekster FROM abdimas WHERE jenis = 'eksternal' OR jenis='EKSTERNAL'");
        return $query->getRow()->abd_ekster;
    }
    public function getAbdimasInterEkster()
    {
        $query = $this->db->query("SELECT COUNT(*) AS abd_inter_ekster FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL'");
        return $query->getRow()->abd_inter_ekster;
    }


    // Year Now 
    public function getAbdimasYearNowInter()
    {
        $query = $this->db->query("SELECT COUNT(*) AS abd_inter FROM abdimas WHERE tahun = YEAR(NOW()) and jenis = 'INTERNAL'");
        return $query->getRow()->abd_inter;
    }
    public function getAbdimasYearNowEkste()
    {
        $query = $this->db->query("SELECT COUNT(*) AS abd_ekster FROM abdimas WHERE tahun = YEAR(NOW()) and jenis = 'Eksternal'");
        return $query->getRow()->abd_ekster;
    }
    public function getAbdimasYearNowInterEkster()
    {
        $query = $this->db->query("SELECT COUNT(*) AS abd_inter_ekster FROM abdimas WHERE tahun = YEAR(NOW()) and jenis = 'INTERNAL & EKSTERNAL'");
        return $query->getRow()->abd_inter_ekster;
    }

    // Peningkatan Penelitian

    public function getPeningkatanAbdimasInter()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM abdimas 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanAbdimasEkste()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM abdimas 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanAbdimasInterEkster()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM abdimas 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }

    public function getOrderByTahun()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_abd FROM abdimas GROUP BY tahun ORDER BY tahun DESC");
        return $query->getResultArray();
    }
}
