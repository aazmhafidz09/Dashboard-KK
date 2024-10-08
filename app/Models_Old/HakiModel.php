<?php

namespace App\Models;

use CodeIgniter\Model;

class HakiModel extends Model
{
    protected $table = 'haki';
    protected $allowedFields = [
        'tahun', 'ketua', 'anggota_1', 'anggota_2', 'anggota_3', 'anggota_4', 'anggota_5', 'anggota_6', 'anggota_7', 'anggota_8', 'anggota_9',
        'jenis', 'jenis_ciptaan', 'judul', 'jenis', 'abstrak', 'no_pendaftaran', 'no_sertifikat', 'catatan'
    ];

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
    public function getOrderByTahunAsc()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_haki FROM haki GROUP BY tahun ORDER BY tahun ASC");
        return $query->getResultArray();
    }
    public function getCountHaki()
    {
        $query = $this->db->query("SELECT jenis AS jenis_haki, COUNT(*) AS jumlah_haki FROM haki GROUP BY jenis ORDER BY jenis ASC");
        return $query->getResultArray();
    }


    public function getCountHakiAll()
    {
        $query = $this->db->query("SELECT jenis AS jenis_haki, COUNT(*) AS jumlah_haki FROM haki GROUP BY jenis ORDER BY jumlah_haki DESC LIMIT 4");
        return $query->getResultArray();
    }

    public function getOrderByTahunAllJenis()
    {
        $query = $this->db->query("SELECT
        tahun,
        SUM(CASE WHEN jenis = 'Hak Cipta' THEN 1 ELSE 0 END) AS Hak_Cipta,
        SUM(CASE WHEN jenis = 'Paten' THEN 1 ELSE 0 END) AS Paten,
        SUM(CASE WHEN jenis = 'Merek' THEN 1 ELSE 0 END) AS Merek,
        SUM(CASE WHEN jenis = 'Buku' THEN 1 ELSE 0 END) AS Buku
    FROM
        haki
    WHERE
        tahun BETWEEN 2010 AND YEAR(CURDATE())
    GROUP BY
        tahun;");
        return $query->getResultArray();
    }


    public function getTopHakiAll()
    {
        $query = $this->db->query("SELECT dosen.nama_dosen, dosen.kode_dosen, 
        COUNT(haki.kode_dosen) AS jumlah_haki FROM dosen dosen 
        JOIN 
            ( SELECT ketua AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_1 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_2 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_3 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_4 AS kode_dosen FROM haki UNION ALL
             SELECT anggota_5 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_6 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_7 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_8 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_9 AS kode_dosen FROM haki 
            ) 
             haki ON dosen.kode_dosen = haki.kode_dosen GROUP BY dosen.kode_dosen, dosen.nama_dosen ");
        return $query->getResultArray();
    }


    public function getAllHaki()
    {
        $query = $this->db->query("SELECT * FROM `haki` ORDER BY `tahun` DESC");
        return $query->getResultArray();
    }
    public function getAllHakiLimit5()
    {
        $query = $this->db->query("SELECT * FROM `haki` ORDER BY `tahun` DESC LIMIT 5");
        return $query->getResultArray();
    }

    public function getTopHaki()
    {
        $query = $this->db->query("SELECT dosen.nama_dosen, dosen.kode_dosen, 
        COUNT(haki.kode_dosen) AS jumlah_haki FROM dosen dosen 
        JOIN 
            ( SELECT ketua AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_1 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_2 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_3 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_4 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_5 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_6 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_7 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_8 AS kode_dosen FROM haki UNION ALL 
             SELECT anggota_9 AS kode_dosen FROM haki ) 
             haki ON dosen.kode_dosen = haki.kode_dosen GROUP BY dosen.kode_dosen, dosen.nama_dosen ORDER BY jumlah_haki DESC LIMIT 10");
        return $query->getResultArray();
    }
}
