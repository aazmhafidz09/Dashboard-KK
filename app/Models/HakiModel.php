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


    // Semua Tahun 
    public function getHakiCipta()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_cipta FROM haki WHERE jenis = 'HAK CIPTA'");
        return $query->getRow()->haki_cipta;
    }
    public function getHakiPaten()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_paten FROM haki WHERE jenis = 'PATEN'");
        return $query->getRow()->haki_paten;
    }
    public function getHakiMerek()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_merek FROM haki WHERE jenis = 'MEREK'");
        return $query->getRow()->haki_merek;
    }
    public function getHakiBuku()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_buku FROM haki WHERE jenis = 'BUKU'");
        return $query->getRow()->haki_buku;
    }

    // Year Now 
    public function getHakiYearNowCipta()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_cipta FROM haki WHERE tahun = YEAR(NOW()) and jenis = 'HAK CIPTA'");
        return $query->getRow()->haki_cipta;
    }
    public function getHakiYearNowPaten()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_paten FROM haki WHERE tahun = YEAR(NOW()) and jenis = 'PATEN'");
        return $query->getRow()->haki_paten;
    }
    public function getHakiYearNowMerek()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_merek FROM haki WHERE tahun = YEAR(NOW()) and jenis = 'MEREK'");
        return $query->getRow()->haki_merek;
    }
    public function getHakiYearNowBuku()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_buku FROM haki WHERE tahun = YEAR(NOW()) and jenis = 'BUKU'");
        return $query->getRow()->haki_buku;
    }





    // Peningkatan HAKI

    public function getPeningkatanHakiCipta()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM HAKI WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM HAKI 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanHakiPaten()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'PATEN' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'PATEN' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'PATEN' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM HAKI WHERE jenis = 'PATEN' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM HAKI 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanHakiMerek()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'MEREK' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'MEREK' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'MEREK' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM HAKI WHERE jenis = 'MEREK' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM HAKI 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanHakiBuku()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'BUKU' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'BUKU' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM HAKI WHERE jenis = 'BUKU' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM HAKI WHERE jenis = 'BUKU' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM HAKI 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }



    public function getOrderByTahun()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_haki FROM haki GROUP BY tahun ORDER BY tahun DESC");
        return $query->getResultArray();
    }
    public function getCountHaki()
    {
        $query = $this->db->query("SELECT jenis AS jenis_haki, COUNT(*) AS jumlah_haki FROM haki GROUP BY jenis ORDER BY jenis ASC");
        return $query->getResultArray();
    }
}
