<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DosenModel;
use App\Models\LogPenelitian;
use OpenSpout\Reader\Common\Creator\ReaderFactory;

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

    public function getById($id) {
        return $this->db
                    ->query("SELECT * FROM penelitian WHERE id=?", [$id])
                    ->getResultArray();
    }

    public function getPenelitian($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll();

        $sql = "SELECT * 
                FROM penelitian 
                WHERE (ketua_peneliti = ?
                        OR anggota_peneliti_1 = ?
                        OR anggota_peneliti_2 = ?
                        OR anggota_peneliti_3 = ?
                        OR anggota_peneliti_4 = ?
                        OR anggota_peneliti_5 = ?
                        OR anggota_peneliti_6 = ?
                        OR anggota_peneliti_7 = ?
                        OR anggota_peneliti_8 = ?
                        OR anggota_peneliti_9 = ?
                        OR anggota_peneliti_10 = ?);";
        $query = $this->db->query(
            $sql, array_map(function() use ($kode_dosen) {return $kode_dosen; } , range(1, 11))
        );
        return $query->getResultArray();
    }

    public function getJumlahPenelitian($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll();
        $sql = "SELECT COUNT(id) AS jumlah_penelitian 
                FROM penelitian 
                WHERE (ketua_peneliti = ?
                        OR anggota_peneliti_1 = ?
                        OR anggota_peneliti_2 = ?
                        OR anggota_peneliti_3 = ?
                        OR anggota_peneliti_4 = ?
                        OR anggota_peneliti_5 = ?
                        OR anggota_peneliti_6 = ?
                        OR anggota_peneliti_7 = ?
                        OR anggota_peneliti_8 = ?
                        OR anggota_peneliti_9 = ?
                        OR anggota_peneliti_10 = ?);";
        $query = $this->db->query(
            $sql, array_map(function() use ($kode_dosen) {return $kode_dosen; } , range(1, 11))
        );
        return $query->getRow()->jumlah_penelitian;
    }

    public function getJumlahKetuaPeneliti($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll();
        $sql = "SELECT COUNT(id) AS jumlah_ketua_peneliti 
                FROM penelitian 
                WHERE (ketua_peneliti = ?);";
        $query = $this->db->query($sql, [$kode_dosen]);
        return $query->getRow()->jumlah_ketua_peneliti;
        // return $query->row()->average_score;
    }

    public function getPenelitianTotal() {
        $query = $this->db->query("SELECT COUNT(id) as count_penelitian FROM penelitian");
        return $query->getRow()->count_penelitian;
    }

    public function getPeningkatanPenelitian() {
        $sql = "SELECT 
                    tahun AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM penelitian WHERE tahun = tahun_sekarang) AS jumlah_tahun_sekarang, 
                    (SELECT COUNT(*) FROM penelitian WHERE tahun = tahun_sekarang - 1) AS jumlah_tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM penelitian WHERE tahun = tahun_sekarang) - (SELECT COUNT(*) FROM penelitian WHERE tahun = tahun_sekarang - 1) AS peningkatan_data 
                FROM penelitian 
                WHERE tahun = YEAR(NOW()) OR tahun = YEAR(NOW()) - 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    // Year Now 
    public function getPenelitianYearNowInter() {
        $sql = "SELECT COUNT(*) AS pen_inter 
                FROM penelitian 
                WHERE tahun = YEAR(NOW()) and jenis = 'Internal';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_inter;
    }

    public function getPenelitianYearNowEkste() {
        $sql = "SELECT COUNT(*) AS pen_ekste 
                FROM penelitian 
                WHERE tahun = YEAR(NOW()) and jenis = 'Eksternal';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_ekste;
    }

    public function getPenelitianYearNowMand() {
        $sql = "SELECT COUNT(*) AS pen_mand 
                FROM penelitian 
                WHERE tahun = YEAR(NOW()) and jenis = 'Mandiri';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_mand;
    }

    public function getPenelitianYearNowKerjaSamaPT() {
        $sql = "SELECT COUNT(*) AS pen_kerja_sama_PT 
                FROM penelitian 
                WHERE tahun = YEAR(NOW()) and jenis = 'Kerjasama Perguruan Tinggi'";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_kerja_sama_PT;
    }
    public function getPenelitianYearNowHilir()
    {
        $sql = "SELECT COUNT(*) AS pen_Hilir 
                FROM penelitian 
                WHERE tahun = YEAR(NOW()) and jenis = 'Hilirisasi';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_Hilir;
    }

    // Semua Tahun 
    public function getPenelitianInter() {
        $sql = "SELECT COUNT(*) AS pen_inter 
                FROM penelitian 
                WHERE jenis = 'Internal';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_inter;
    }

    public function getPenelitianEkste() {
        $sql = "SELECT COUNT(*) AS pen_ekste 
                FROM penelitian 
                WHERE jenis = 'Eksternal';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_ekste;
    }

    public function getPenelitianMand() {
        $sql = "SELECT COUNT(*) AS pen_mand 
                FROM penelitian 
                WHERE jenis = 'Mandiri';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_mand;
    }

    public function getPenelitianKerjaSamaPT() {
        $sql = "SELECT COUNT(*) AS pen_kerja_sama_PT 
                FROM penelitian 
                WHERE jenis = 'Kerjasama Perguruan Tinggi'; ";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_kerja_sama_PT;
    }

    public function getPenelitianHilir() {
        $sql = "SELECT COUNT(*) AS pen_Hilir 
                FROM penelitian 
                WHERE jenis = 'Hilirisasi';";
        $query = $this->db->query($sql);
        return $query->getRow()->pen_Hilir;
    }

    // Peningkatan Penelitian
    public function getPeningkatanPenelitianInter() {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Eksternal' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM penelitian 
                LIMIT 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    public function getPeningkatanPenelitianEkste() {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Internal' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM penelitian 
                LIMIT 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    public function getPeningkatanPenelitianMand() {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Mandiri' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM penelitian 
                LIMIT 1; ";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    public function getPeningkatanPenelitianKerjaSamaPT() {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM penelitian 
                LIMIT 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    public function getPeningkatanPenelitianHilir() {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM penelitian WHERE jenis = 'Hilirisasi' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM penelitian 
                LIMIT 1; ";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    public function getOrderByTahun() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                GROUP BY tahun 
                ORDER BY tahun DESC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getOrderByTahunAsc() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                GROUP BY tahun 
                ORDER BY tahun ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getCountPublikasi() {
        $sql = "SELECT 
                    jenis AS jenis_pen, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                GROUP BY jenis 
                ORDER BY jumlah_pen DESC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getCountPublikasiASC() {
        $sql = "SELECT 
                    jenis AS jenis_pen, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                GROUP BY jenis 
                ORDER BY jenis ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getTopPenelitian() {
        $sql = "SELECT 
                    dosen.nama_dosen, 
                    dosen.kode_dosen, 
                    COUNT(penelitian.kode_dosen) AS jumlah_penelitian 
                FROM dosen dosen 
                JOIN ( SELECT ketua_peneliti AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_1 AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_2 AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_3 AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_4 AS kode_dosen FROM penelitian ) penelitian 
                ON dosen.kode_dosen = penelitian.kode_dosen 
                GROUP BY dosen.kode_dosen, dosen.nama_dosen 
                ORDER BY jumlah_penelitian DESC LIMIT 10;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getTopPenelitianAll() {
        $sql = "SELECT 
                    dosen.nama_dosen, 
                    dosen.kode_dosen, 
                    COUNT(penelitian.kode_dosen) AS jumlah_penelitian 
                FROM dosen dosen 
                JOIN ( SELECT ketua_peneliti AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_1 AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_2 AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_3 AS kode_dosen FROM penelitian UNION ALL 
                        SELECT anggota_peneliti_4 AS kode_dosen FROM penelitian ) penelitian 
                ON dosen.kode_dosen = penelitian.kode_dosen 
                GROUP BY dosen.kode_dosen, dosen.nama_dosen;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getYearMinMax() {
        $str ="SELECT MIN(tahun), MAX(tahun) FROM penelitian";
        $query = $this->db->query($str);
        return $query->getResultArray();
    }
    
    public function getDataDosenTahunan() {
        $sql = "SELECT
                    d.kode_dosen,
                    p.tahun,
                    COUNT(*) AS nPenelitian
                FROM penelitian AS p
                RIGHT JOIN dosen AS d
                    ON (
                        p.ketua_peneliti = d.kode_dosen
                        OR p.anggota_peneliti_1 = d.kode_dosen
                        OR p.anggota_peneliti_2 = d.kode_dosen
                        OR p.anggota_peneliti_3 = d.kode_dosen
                        OR p.anggota_peneliti_4 = d.kode_dosen
                        OR p.anggota_peneliti_5 = d.kode_dosen
                        OR p.anggota_peneliti_6 = d.kode_dosen
                        OR p.anggota_peneliti_7 = d.kode_dosen
                        OR p.anggota_peneliti_8 = d.kode_dosen
                        OR p.anggota_peneliti_9 = d.kode_dosen
                        OR p.anggota_peneliti_10 = d.kode_dosen
                    )
                GROUP BY d.kode_dosen, p.tahun; ";
        $result = $this->db->query($sql)->getResultArray();

        $data = [];
        foreach($result as $value) {
            $kodeDosen = $value["kode_dosen"];
            if(!isset($data[$kodeDosen])) {
                $data[$kodeDosen] = ["kode_dosen" => $kodeDosen];
            }

            if(!is_null($value["tahun"])) {
                $yearString = "THN_" .$value["tahun"];
                $data[$kodeDosen][$yearString] = $value["nPenelitian"];
            }
        }

        return $data;

        // $minMax = getYearMinMax();
    //     $str1 ="COUNT(CASE WHEN penelitian.tahun = ";
    //     $str2 =" THEN penelitian.kode_dosen END) AS THN_";
    //     $yearList = "";
    //     $result = "";
    //     for($x = 2000; $x < 2024; $x++){            
    //         $result = $result.$str1 . $x  . $str2 . $x . ", ";
    //         $yearList = $yearList.$x . ", ";
    //     }


    //     $result = $result . $str1 . 2024 . $str2 . 2024;
    //     $yearList = $yearList . 2024;

    //     $query = $this->db->query("SELECT
    //     dosen.kode_dosen,
    //     $result 

    // FROM
    //     dosen
    // LEFT JOIN
    //     (
    //         SELECT ketua_peneliti AS kode_dosen, tahun FROM penelitian WHERE tahun IN ($yearList)
    //         UNION ALL
    //         SELECT anggota_peneliti_1, tahun FROM penelitian WHERE tahun IN ($yearList)
    //         UNION ALL
    //         SELECT anggota_peneliti_2, tahun FROM penelitian WHERE tahun IN ($yearList)
    //         UNION ALL
    //         SELECT anggota_peneliti_3, tahun FROM penelitian WHERE tahun IN ($yearList)
    //         UNION ALL
    //         SELECT anggota_peneliti_4, tahun FROM penelitian WHERE tahun IN ($yearList)
    //     ) AS penelitian ON dosen.kode_dosen = penelitian.kode_dosen
    // GROUP BY
    //     dosen.kode_dosen;");
    //     return $query->getResultArray();
    }

    public function getAllPenelitian() {
        $query = $this->db->query("SELECT * FROM `penelitian` ORDER BY `tahun` DESC;");
        return $query->getResultArray();
    }

    public function getAllPenelitianLIMIT5() {
        $query = $this->db->query("SELECT * FROM `penelitian` ORDER BY `tahun` DESC LIMIT 5;");
        return $query->getResultArray();
    }


    public function getOrderByTahunEksternal() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                WHERE jenis = 'Eksternal' 
                GROUP BY tahun 
                ORDER BY tahun ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getOrderByTahunInternal() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                WHERE jenis = 'Internal' 
                GROUP BY tahun 
                ORDER BY tahun ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getOrderByTahunMandiri() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                WHERE jenis = 'Mandiri' 
                GROUP BY tahun 
                ORDER BY tahun ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getOrderByTahunKerjasamaPT() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian 
                WHERE jenis = 'Kerjasama Perguruan Tinggi' 
                GROUP BY tahun 
                ORDER BY tahun ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getOrderByTahunHilirisasi() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM penelitian
                WHERE jenis = 'Hilirisasi' 
                GROUP BY tahun ORDER BY tahun ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_table_fields() {
        return $this->db->getFieldNames('penelitian');
    }

    public function getAnnualPenelitianByType() {
        $sql = "WITH 
                    kk_penelitian AS (
                        SELECT DISTINCT
                            p.id,
                            p.tahun,
                            p.jenis
                        FROM penelitian AS p
                        JOIN dosen AS d
                            ON ( d.kode_dosen = p.ketua_peneliti
                                OR d.kode_dosen = p.anggota_peneliti_1
                                OR d.kode_dosen = p.anggota_peneliti_2
                                OR d.kode_dosen = p.anggota_peneliti_3
                                OR d.kode_dosen = p.anggota_peneliti_4
                                OR d.kode_dosen = p.anggota_peneliti_5
                                OR d.kode_dosen = p.anggota_peneliti_6
                                OR d.kode_dosen = p.anggota_peneliti_7
                                OR d.kode_dosen = p.anggota_peneliti_8
                                OR d.kode_dosen = p.anggota_peneliti_9
                                OR d.kode_dosen = p.anggota_peneliti_10
                            )
                    )
                SELECT
                    kp.jenis AS jenis,
                    kp.tahun AS tahun, 
                    COUNT(*) AS nPenelitian
                FROM kk_penelitian AS kp
                GROUP BY kp.jenis, kp.tahun;
                ";
        return $this->db->query($sql)->getResultArray();
    }

    public function getAnnualPenelitianByTypeAndKK() {
        $sql = "WITH 
                    kk_penelitian AS (
                        SELECT DISTINCT
                            p.id,
                            d.kk,
                            p.tahun,
                            p.jenis
                        FROM penelitian AS p
                        JOIN dosen AS d
                            ON ( d.kode_dosen = p.ketua_peneliti
                                OR d.kode_dosen = p.anggota_peneliti_1
                                OR d.kode_dosen = p.anggota_peneliti_2
                                OR d.kode_dosen = p.anggota_peneliti_3
                                OR d.kode_dosen = p.anggota_peneliti_4
                                OR d.kode_dosen = p.anggota_peneliti_5
                                OR d.kode_dosen = p.anggota_peneliti_6
                                OR d.kode_dosen = p.anggota_peneliti_7
                                OR d.kode_dosen = p.anggota_peneliti_8
                                OR d.kode_dosen = p.anggota_peneliti_9
                                OR d.kode_dosen = p.anggota_peneliti_10
                            )
                    )
                SELECT
                    kp.kk AS kk,
                    kp.jenis AS jenis,
                    kp.tahun AS tahun, 
                    COUNT(*) AS nPenelitian
                FROM kk_penelitian AS kp
                GROUP BY kp.kk, kp.jenis, kp.tahun; ";

        return $this->db->query($sql)->getResultArray();
    }

    public function getAllByKK($kk) {
        $sql = "SELECT DISTINCT p.*
                    FROM penelitian AS p
                    JOIN dosen AS d
                        ON d.kode_dosen = p.ketua_peneliti
                            OR d.kode_dosen = p.anggota_peneliti_1
                            OR d.kode_dosen = p.anggota_peneliti_2
                            OR d.kode_dosen = p.anggota_peneliti_3
                            OR d.kode_dosen = p.anggota_peneliti_4
                            OR d.kode_dosen = p.anggota_peneliti_5
                            OR d.kode_dosen = p.anggota_peneliti_6
                            OR d.kode_dosen = p.anggota_peneliti_7
                            OR d.kode_dosen = p.anggota_peneliti_8
                            OR d.kode_dosen = p.anggota_peneliti_9
                            OR d.kode_dosen = p.anggota_peneliti_10
                    WHERE d.kk = ?
                    ORDER BY p.id DESC";

        return $this->db->query($sql, [$kk])->getResultArray();
    }

    public function countAllEachDosen() {
        $sql = "WITH 
                    penelitianDosen AS (
                        SELECT DISTINCT 
                            p.id, 
                            d.nama_dosen,
                            d.kode_dosen
                        FROM penelitian AS p
                        JOIN dosen AS d
                            ON d.kode_dosen = p.ketua_peneliti
                                OR d.kode_dosen = p.anggota_peneliti_1
                                OR d.kode_dosen = p.anggota_peneliti_2
                                OR d.kode_dosen = p.anggota_peneliti_3
                                OR d.kode_dosen = p.anggota_peneliti_4
                                OR d.kode_dosen = p.anggota_peneliti_5
                                OR d.kode_dosen = p.anggota_peneliti_6
                                OR d.kode_dosen = p.anggota_peneliti_7
                                OR d.kode_dosen = p.anggota_peneliti_8
                                OR d.kode_dosen = p.anggota_peneliti_9
                                OR d.kode_dosen = p.anggota_peneliti_10
                    )
                SELECT
                    nama_dosen,
                    kode_dosen,
                    COUNT(*) AS nPenelitian
                FROM penelitianDosen
                GROUP BY kode_dosen
                ORDER BY nPenelitian DESC";
        return $this->db->query($sql)->getResultArray();
    }

    public function import($filePath) {
        // Validation purpose variables
        $dosenList = (new DosenModel())->getAllKodeDosen();
        $insertFields = [ 
            // Excel format as of 24/07/29: (Please always adjust it to current format)
            // id | tahun | jenis | nama_kegiatan | judul | status | lab_riset | ketua | anggota_1 |  anggota_2 |  anggota_3 |  anggota_4 |  anggota_5 |  anggota_6 |  anggota_7 |  anggota_8 | mitra | alamat_mitra | kesesuaian_roadmap | permasalahan_masy | solusi | catatan | luaran | tgl_pengesahan
            'tahun', 'jenis', 'nama_kegiatan', 
            'judul_penelitian', 'status', 'ketua_peneliti', 
            'anggota_peneliti_1', 'anggota_peneliti_2', 'anggota_peneliti_3', 
            'anggota_peneliti_4', 'anggota_peneliti_5', 'anggota_peneliti_6', 
            'anggota_peneliti_7', 'anggota_peneliti_8', 'anggota_peneliti_9', 
            'anggota_peneliti_10', 'mitra', 'lab_riset', 
            'kesesuaian_roadmap', 'catatan_rekomendasi', 'luaran', 
            'mk_relevan', 'tgl_pengesahan',
        ];
        $WRITER_FIELDS = array_slice($insertFields, 5, 11);
        $ALLOWED_JENIS = ["internal", "eksternal", "mandiri", "kerjasama perguruan tinggi", "kemitraan", "hilirisasi"];
        $ALLOWED_STATUS = ["didanai", "submit proposal"];

        $rowData = [];
        $isTableHeader = true;
        $nRow = 0;
        try {
            $reader = ReaderFactory::createFromFileByMimeType($filePath); // TODO (Security): mime type can be unreliable as it could be spoofed
            $reader->open($filePath);
            $sheet = $reader->getSheetIterator()->current(); // Assuming only the first sheet would be used
            foreach($sheet->getRowIterator() as $row) {
                $nRow++;
                if($isTableHeader) {$isTableHeader = false; continue;}

                $rowCells = $row->getCells();
                if(count($rowCells) - 1 != count($insertFields)) { // Excluding id which exists in template
                    throw new \Exception("Banyak kolom tidak sesuai kriteria, yakni sebanyak " . (count($insertFields) - 1));
                }

                $currentRow = [];
                for($idx = 0; $idx < count($insertFields); $idx++) {
                    $field = $insertFields[$idx];
                    $value = $rowCells[$idx + 1]->getValue();

                    if($field != "tgl_pengesahan") {
                        $currentRow[$field] = $value;
                    } else if($value instanceof \DateTimeImmutable) {
                        $currentRow[$field] = date_format($value, 'd-m-Y');
                    } else {
                        throw new \Exception("`tgl_pengesahan` tidak valid. Pastikan tanggal valid dan menggunakan format yang sesuai");
                    }
                }

                // Some mandatory fields
                $isValid = ( is_numeric($currentRow["tahun"])
                            && strlen($currentRow["judul_penelitian"]) > 0
                            && strlen($currentRow["status"]) > 0
                            && strlen($currentRow["jenis"]) > 0);
                if(!$isValid) throw new \Exception("`judul_peneliti`, `tahun`, `status`, dan `jenis` harus diisi");

                $hasWriter = false;
                foreach($WRITER_FIELDS as $wf) {
                    $writer = $currentRow[$wf];
                    $isValid = strlen($writer) == 0 || in_array($writer, $dosenList);
                    $hasWriter = $hasWriter || strlen($writer) > 0;
                    if(!$isValid) throw new \Exception("`kode_dosen` " . $writer . " tidak terdaftar sebagai dosen di database");
                }

                $isValid = $hasWriter;
                if(!$isValid) throw new \Exception("Sertakan setidaknya salah satu anggota yang terlibat");

                $isValid = ( strlen($currentRow["jenis"]) == 0 
                            || in_array(strtolower($currentRow["jenis"]), $ALLOWED_JENIS));
                if(!$isValid) throw new \Exception("Jika diisi, `jenis` harus merupakan salah satu dari {'internal', 'eksternal', 'mandiri', 'kerjasama perguruan tinggi', 'kemitraan', 'hilirisasi'}");

                $isValid = ( strlen($currentRow["status"]) == 0
                            || in_array(strtolower($currentRow["status"]), $ALLOWED_STATUS));
                if(!$isValid) throw new \Exception("Jika diisi, `status` harus merupakan salah satu dari {'didanai', 'submit proposal'}");

                array_push($rowData, $currentRow);
            }

            $reader->close();
            if(count($rowData) == 0) throw new \Exception("Tidak ada data yang perlu dimasukkan");

            $this->db->transStart();
            $insertedRow = $this->db->table($this->table)->insertBatch($rowData);
            $firstInsertId = $this->db->insertId();
            $insertedIDs = range($firstInsertId, $firstInsertId + $insertedRow - 1);

            $logPenelitian = new LogPenelitian();
            $logPenelitian->db->table($logPenelitian->getTableName())->insertBatch(
                array_map(
                    function($idx) use($insertedIDs, $rowData) { 
                        return [
                            "user_id" => user_id(),
                            "penelitian_id" => $insertedIDs[$idx],
                            "action" => "C",
                            "value_after" => json_encode(
                                array_merge(["id" => "" . $insertedIDs[$idx]], $rowData[$idx]))
                        ]; 
                    },
                    range(0, count($insertedIDs) - 1)
                )
            );

            if($this->db->transStatus() == false) {
                $this->db->transRollback();
                throw new DatabaseException("Maaf, sebuah kesalahan terjadi ketika transaksi data");
            }
            $this->db->transCommit();
        } catch(DatabaseException $e) {
            return [-1, $e->getMessage()];
        } catch(\Exception $e) {
            return [-1, "(Baris ${nRow}) " . $e->getMessage()];
        } catch(\Throwable $e) {
            return [-1, "Maaf, suatu kesalahan yang tidak diketahui terjadi, pastikan anda telah mengikuti seluruh panduan. Apabila merasa sudah, silakan kontak tim pengembang"];
        }
        return [0, null];
    }

    public function isPermitted($penelitian) {
        if(is_null(user())) return false;

        // Does current user is involved?
        $kodeDosen = user()->kode_dosen;
        $isInvolved = in_array($kodeDosen, [
            $penelitian["ketua_peneliti"], $penelitian["anggota_peneliti_1"],
            $penelitian["anggota_peneliti_2"], $penelitian["anggota_peneliti_3"],
            $penelitian["anggota_peneliti_4"], $penelitian["anggota_peneliti_5"],
            $penelitian["anggota_peneliti_6"], $penelitian["anggota_peneliti_7"],
            $penelitian["anggota_peneliti_8"], $penelitian["anggota_peneliti_9"],
            $penelitian["anggota_peneliti_10"],
        ]);
        if($isInvolved) return true;

        // Is current user came from `KK` that involved here?
        $dosenModel = new DosenModel();
        $listAnggota = [];
        if(!is_null($penelitian["ketua_peneliti"]) 
            && $penelitian["ketua_peneliti"] != "") 
        {
            array_push($listAnggota, $penelitian["ketua_peneliti"]);
        }

        foreach(range(1, 10) as $nAnggota) {
            $anggota = $penelitian["anggota_peneliti_$nAnggota"];
            if(!is_null($anggota) && $anggota != "") {
                array_push($listAnggota, $anggota);
            }
        }

        $placeholder = implode(',', array_fill(0, count($listAnggota), '?'));
        $sql = "SELECT DISTINCT CONCAT('kk_', LOWER(kk)) AS kk 
                FROM dosen 
                WHERE kode_dosen IN ($placeholder)";
        $kkPenelitian = array_map(
            function($val) {return $val["kk"]; },
            $this->db->query($sql, $listAnggota)->getResultArray()
        );
        $allowedGroups = array_merge(["admin"], $kkPenelitian);

        if(in_groups($allowedGroups, user_id())) return true;
        return false;

    }

    public function getAllByYear($year = null) {
        $table = $this->table;

        if(is_null($year)) {
            return $this->db->query("SELECT * FROM $table")
                            ->getResultArray();
        }

        $sql = "SELECT * FROM $table WHERE tahun = ?";
        return $this->query($sql, [$year])
                    ->getResultArray();
    }
}
