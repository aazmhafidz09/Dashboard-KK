<?php

namespace App\Models;

use CodeIgniter\Model;

class PenelitianModel extends Model
{
    protected $table = 'penelitian';
    protected $allowedFields = [
        'anggota_peneliti_1', 
        'anggota_peneliti_2', 
        'anggota_peneliti_3', 
        'anggota_peneliti_4', 
        'anggota_peneliti_5',
        'anggota_peneliti_6',
        'anggota_peneliti_7',
        'anggota_peneliti_8',
        'anggota_peneliti_9',
        'anggota_peneliti_10',
        'catatan_rekomendasi', 
        'jenis', 
        'judul_penelitian', 
        'kesesuaian_roadmap',
        'ketua_peneliti', 
        'lab_riset', 
        'luaran', 
        'mitra', 
        'mk_relevan', 
        'nama_kegiatan', 
        'status',
        'tahun', 
        'tgl_pengesahan'
    ];

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
    public function getPenelitianTotal()
    {
        $query = $this->db->query("SELECT COUNT(id) as count_penelitian FROM penelitian");
        return $query->getRow()->count_penelitian;
    }
    public function getPeningkatanPenelitian()
    {
        $query = $this->db->query("SELECT tahun AS tahun_sekarang, (SELECT COUNT(*) FROM penelitian 
        WHERE tahun = tahun_sekarang) AS jumlah_tahun_sekarang, (SELECT COUNT(*) FROM penelitian WHERE tahun = tahun_sekarang - 1) 
        AS jumlah_tahun_sebelumnya, (SELECT COUNT(*) FROM penelitian WHERE tahun = tahun_sekarang) - (SELECT COUNT(*) 
        FROM penelitian WHERE tahun = tahun_sekarang - 1) AS peningkatan_data FROM penelitian WHERE tahun = YEAR(NOW()) OR tahun = YEAR(NOW()) - 1");
        return $query->getRow()->peningkatan_data;
    }

    // Year Now 
    public function getPenelitianYearNowInter()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_inter FROM penelitian WHERE tahun = YEAR(NOW()) and jenis = 'Internal'");
        return $query->getRow()->pen_inter;
    }
    public function getPenelitianYearNowEkste()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_ekste FROM penelitian WHERE tahun = YEAR(NOW()) and jenis = 'Eksternal'");
        return $query->getRow()->pen_ekste;
    }
    public function getPenelitianYearNowMand()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_mand FROM penelitian WHERE tahun = YEAR(NOW()) and jenis = 'Mandiri'");
        return $query->getRow()->pen_mand;
    }
    public function getPenelitianYearNowKerjaSamaPT()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_kerja_sama_PT FROM penelitian WHERE tahun = YEAR(NOW()) and jenis = 'Kerjasama Perguruan Tinggi'");
        return $query->getRow()->pen_kerja_sama_PT;
    }
    public function getPenelitianYearNowHilir()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_Hilir FROM penelitian WHERE tahun = YEAR(NOW()) and jenis = 'Hilirisasi'");
        return $query->getRow()->pen_Hilir;
    }

    // Semua Tahun 
    public function getPenelitianInter()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_inter FROM penelitian WHERE jenis = 'Internal'");
        return $query->getRow()->pen_inter;
    }
    public function getPenelitianEkste()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_ekste FROM penelitian WHERE jenis = 'Eksternal'");
        return $query->getRow()->pen_ekste;
    }
    public function getPenelitianMand()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_mand FROM penelitian WHERE jenis = 'Mandiri'");
        return $query->getRow()->pen_mand;
    }
    public function getPenelitianKerjaSamaPT()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_kerja_sama_PT FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi'");
        return $query->getRow()->pen_kerja_sama_PT;
    }
    public function getPenelitianHilir()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pen_Hilir FROM penelitian WHERE jenis = 'Hilirisasi'");
        return $query->getRow()->pen_Hilir;
    }

    // Peningkatan Penelitian

    public function getPeningkatanPenelitianInter()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM penelitian 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPenelitianEkste()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM penelitian 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPenelitianMand()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM penelitian 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPenelitianKerjaSamaPT()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM penelitian 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPenelitianHilir()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM penelitian 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }

    public function getOrderByTahun()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian GROUP BY tahun ORDER BY tahun DESC");
        return $query->getResultArray();
    }
    public function getOrderByTahunAsc()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian GROUP BY tahun ORDER BY tahun ASC");
        return $query->getResultArray();
    }
    public function getCountPublikasi()
    {
        $query = $this->db->query("SELECT jenis AS jenis_pen, COUNT(*) AS jumlah_pen FROM penelitian GROUP BY jenis ORDER BY jumlah_pen ASC");
        return $query->getResultArray();
    }
    public function getCountPublikasiASC()
    {
        $query = $this->db->query("SELECT jenis AS jenis_pen, COUNT(*) AS jumlah_pen FROM penelitian GROUP BY jenis ORDER BY jenis ASC");
        return $query->getResultArray();
    }

    public function getTopPenelitian()
    {
        $query = $this->db->query("SELECT dosen.nama_dosen, dosen.kode_dosen, COUNT(penelitian.kode_dosen) AS jumlah_penelitian FROM dosen dosen JOIN ( SELECT ketua_peneliti AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_1 AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_2 AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_3 AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_4 AS kode_dosen FROM penelitian ) penelitian ON dosen.kode_dosen = penelitian.kode_dosen GROUP BY dosen.kode_dosen, dosen.nama_dosen ORDER BY jumlah_penelitian DESC LIMIT 10");
        return $query->getResultArray();
    }
    public function getTopPenelitianAll()
    {
        $query = $this->db->query("SELECT dosen.nama_dosen, dosen.kode_dosen, COUNT(penelitian.kode_dosen) AS jumlah_penelitian FROM dosen dosen JOIN ( SELECT ketua_peneliti AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_1 AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_2 AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_3 AS kode_dosen FROM penelitian UNION ALL SELECT anggota_peneliti_4 AS kode_dosen FROM penelitian ) penelitian ON dosen.kode_dosen = penelitian.kode_dosen GROUP BY dosen.kode_dosen, dosen.nama_dosen");
        return $query->getResultArray();
    }


    public function getYearMinMax(){
        $str ="SELECT MIN(tahun), MAX(tahun) FROM penelitian";
        $query = $this->db->query($str);
        return $query->getResultArray();
    }
    
    public function getDataDosenTahunan()
    {

        // $minMax = getYearMinMax();
        $str1 ="COUNT(CASE WHEN penelitian.tahun = ";
        $str2 =" THEN penelitian.kode_dosen END) AS THN_";
        $yearList = "";
        $result = "";
        for($x = 2000; $x < 2024; $x++){            
            $result = $result.$str1 . $x  . $str2 . $x . ", ";
            $yearList = $yearList.$x . ", ";
        }


        $result = $result . $str1 . 2024 . $str2 . 2024;
        $yearList = $yearList . 2024;

        $query = $this->db->query("SELECT
        dosen.kode_dosen,
        $result 

    FROM
        dosen
    LEFT JOIN
        (
            SELECT ketua_peneliti AS kode_dosen, tahun FROM penelitian WHERE tahun IN ($yearList)
            UNION ALL
            SELECT anggota_peneliti_1, tahun FROM penelitian WHERE tahun IN ($yearList)
            UNION ALL
            SELECT anggota_peneliti_2, tahun FROM penelitian WHERE tahun IN ($yearList)
            UNION ALL
            SELECT anggota_peneliti_3, tahun FROM penelitian WHERE tahun IN ($yearList)
            UNION ALL
            SELECT anggota_peneliti_4, tahun FROM penelitian WHERE tahun IN ($yearList)
        ) AS penelitian ON dosen.kode_dosen = penelitian.kode_dosen
    GROUP BY
        dosen.kode_dosen;");
        return $query->getResultArray();
    }

    public function getAllPenelitian()
    {
        $query = $this->db->query("SELECT * FROM `penelitian` ORDER BY `tahun` DESC;");
        return $query->getResultArray();
    }
    public function getAllPenelitianLIMIT5()
    {
        $query = $this->db->query("SELECT * FROM `penelitian` ORDER BY `tahun` DESC LIMIT 5;");
        return $query->getResultArray();
    }


    public function getOrderByTahunEksternal()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian WHERE jenis = 'Eksternal' GROUP BY tahun ORDER BY tahun ASC;");
        return $query->getResultArray();
    }
    public function getOrderByTahunInternal()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian WHERE jenis = 'Internal' GROUP BY tahun ORDER BY tahun ASC;");
        return $query->getResultArray();
    }
    public function getOrderByTahunMandiri()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian WHERE jenis = 'Mandiri' GROUP BY tahun ORDER BY tahun ASC;");
        return $query->getResultArray();
    }
    public function getOrderByTahunKerjasamaPT()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian WHERE jenis = 'Kerja Sama PT' GROUP BY tahun ORDER BY tahun ASC;");
        return $query->getResultArray();
    }
    public function getOrderByTahunHilirisasi()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian WHERE jenis = 'Hilirisasi' GROUP BY tahun ORDER BY tahun ASC;");
        return $query->getResultArray();
    }
    public function get_table_fields()
    {
        return $this->db->getFieldNames('penelitian');
    }
}
