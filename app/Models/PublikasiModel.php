<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DosenModel;
use App\Models\LogPublikasi;
use OpenSpout\Reader\Common\Creator\ReaderFactory;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';
    protected $allowedFields = [
        'akreditasi_journal_conf', 
        'institusi_mitra', 
        'jenis', 
        'judul_publikasi', 
        'lab_riset', 
        'link_artikel',
        'nama_journal_conf', 
        'penulis_1', 
        'penulis_2', 
        'penulis_3', 
        'penulis_4', 
        'penulis_5', 
        'penulis_6', 
        'penulis_7', 
        'penulis_8', 
        'penulis_9', 
        'penulis_10', 
        'penulis_11', 
        'penulis_all', 
        'tahun'
    ];

    public function getById($id) {
        return $this->db
                    ->query("SELECT * FROM publikasi WHERE id=?", [$id])
                    ->getResultArray();
    }

    public function getPublikasi_all() {
        return $this->findAll();
    }

    public function getPublikasi($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll();
        $sql = "SELECT * 
                FROM publikasi 
                WHERE 
                    penulis_1 = ? 
                    OR penulis_2 = ? 
                    OR penulis_3 = ? 
                    OR penulis_4 = ? 
                    OR penulis_5 = ? 
                    OR penulis_6 = ? 
                    OR penulis_7 = ? 
                    OR penulis_8 = ? 
                    OR penulis_9 = ? 
                    OR penulis_10 = ? 
                    OR penulis_11 = ? 
                ORDER BY tahun DESC;";
        $query = $this->db->query(
            $sql, array_map(function() use ($kode_dosen) {return $kode_dosen; } , range(1, 11))
        );
        return $query->getResultArray();
    }

    public function getJumlahPublikasi($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll();
        $sql = "SELECT COUNT(id) AS jumlah_publikasi 
                FROM publikasi 
                WHERE (penulis_1 = ? 
                        OR penulis_2 = ? 
                        OR penulis_3 = ? 
                        OR penulis_4 = ? 
                        OR penulis_5 = ? 
                        OR penulis_6 = ? 
                        OR penulis_7 = ? 
                        OR penulis_8 = ? 
                        OR penulis_9 = ? 
                        OR penulis_10 = ? 
                        OR penulis_11 = ?);";
        $query = $this->db->query(
            $sql, array_map(function() use ($kode_dosen) {return $kode_dosen; } , range(1, 11))
        );
        return $query->getRow()->jumlah_publikasi;
    }

    public function getJumlahPublikasi_1($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll();
        $sql = "SELECT COUNT(id) AS jumlah_publikasi_1 FROM publikasi WHERE penulis_1 = ?";
        $query = $this->db->query($sql, [$kode_dosen]);
        return $query->getRow()->jumlah_publikasi_1;
    }
    public function getPublikasiTotal() {
        $query = $this->db->query("SELECT COUNT(id) as count_publikasi FROM publikasi");
        return $query->getRow()->count_publikasi;
    }

    public function getPeningkatanPublikasi()
    {
        $sql = " SELECT 
                    tahun AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM publikasi WHERE tahun = tahun_sekarang) AS jumlah_tahun_sekarang, 
                    (SELECT COUNT(*) FROM publikasi WHERE tahun = tahun_sekarang - 1) AS jumlah_tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM publikasi WHERE tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE tahun = YEAR(NOW()) - 1) AS peningkatan_data 
                FROM publikasi 
                WHERE (tahun = YEAR(NOW()) 
                        OR tahun = YEAR(NOW()) - 1);";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }


    // Year Now 
    public function getPeningkatanPublikasiInter()
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM publikasi 
                LIMIT 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPublikasiNas()
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM publikasi 
                LIMIT 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPublikasiPros()
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM publikasi 
                LIMIT 1; ";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPublikasiProsNas()
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM publikasi 
                LIMIT 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    // Year Now 
    public function getPublikasiYearNowInter() {
        $sql = "SELECT COUNT(*) AS pub_inter 
                FROM publikasi 
                WHERE tahun = YEAR(NOW()) and jenis = 'Jurnal Internasional';";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_inter;
    }

    public function getPublikasiYearNowNas() {
        $sql = "SELECT COUNT(*) AS pub_nas 
                FROM publikasi 
                WHERE tahun = YEAR(NOW()) and jenis = 'Jurnal Nasional';";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_nas;
    }

    public function getPublikasiYearNowPros() {
        $sql = "SELECT COUNT(*) AS pub_pros 
                FROM publikasi 
                WHERE tahun = YEAR(NOW()) and jenis = 'Prosiding Internasional';";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_pros;
    }

    public function getPublikasiYearNowProsNas() {
        $sql = "SELECT COUNT(*) AS pub_pros_nas 
                FROM publikasi 
                WHERE tahun = YEAR(NOW()) and jenis = 'Prosiding Nasional'; ";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_pros_nas;
    }

    // Semua Tahun 
    public function getPublikasiInter() {
        $sql = "SELECT COUNT(*) AS pub_inter 
                FROM publikasi 
                WHERE jenis = 'Jurnal Internasional';";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_inter;
    }

    public function getPublikasiNas() {
        $sql = "SELECT COUNT(*) AS pub_nas 
                FROM publikasi 
                WHERE jenis = 'Jurnal Nasional';";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_nas;
    }

    public function getPublikasiPros() {
        $sql = "SELECT COUNT(*) AS pub_pros 
                FROM publikasi 
                WHERE jenis = 'Prosiding Internasional';";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_pros;
    }

    public function getPublikasiProsNas() {
        $sql = "SELECT COUNT(*) AS pub_pros_nas 
                FROM publikasi 
                WHERE jenis = 'Prosiding Nasional';";
        $query = $this->db->query($sql);
        return $query->getRow()->pub_pros_nas;
    }

    public function getOrderByTahun() {
        $sql = "SELECT 
                    tahun AS thn, 
                    COUNT(*) AS jumlah_pen 
                FROM publikasi 
                GROUP BY tahun 
                ORDER BY tahun DESC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getOrderByTahun_asc() {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM publikasi GROUP BY tahun ORDER BY tahun ASC");
        return $query->getResultArray();
    }

    public function getAkreditasi() {
        $sql = "SELECT 
                    akreditasi_journal_conf AS akreditasi, 
                    COUNT(*) AS jumlah_akr 
                FROM publikasi 
                WHERE (akreditasi_journal_conf != '-' 
                        AND akreditasi_journal_conf != '' 
                        AND akreditasi_journal_conf != 'not accredited yet' 
                        AND akreditasi_journal_conf != 'unidentified' 
                        AND akreditasi_journal_conf != 'scopus' 
                        AND akreditasi_journal_conf != 'not Scopus' 
                        AND akreditasi_journal_conf != 'riset' 
                        AND akreditasi_journal_conf != 'undefined')
                GROUP BY akreditasi_journal_conf 
                ORDER BY akreditasi_journal_conf ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getTopPublikasi() {
        return array_slice($this->countAllEachDosen(), 0, 10);
        // $sql = "SELECT 
        //             dosen.nama_dosen, 
        //             dosen.kode_dosen, 
        //         COUNT(publikasi.kode_dosen) AS jumlah_publikasi FROM dosen dosen
        //         JOIN 
        //             ( SELECT penulis_1 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_2 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_3 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_4 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_5 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_6 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_7 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_8 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_9 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_10 AS kode_dosen FROM publikasi UNION ALL 
        //             SELECT penulis_11 AS kode_dosen FROM publikasi ) publikasi 
        //         ON dosen.kode_dosen = publikasi.kode_dosen 
        //         GROUP BY dosen.kode_dosen, dosen.nama_dosen 
        //         ORDER BY jumlah_publikasi DESC LIMIT 10";
        // $query = $this->db->query($sql);
        // return $query->getResultArray();
    }

    public function getDataDosenTahunan() {
        $sql = "SELECT
                    d.kode_dosen,
                    p.tahun,
                    COUNT(*) AS nPublikasi
                FROM publikasi AS p
                RIGHT JOIN dosen AS d
                    ON (
                        p.penulis_1 = d.kode_dosen
                        OR p.penulis_2 = d.kode_dosen
                        OR p.penulis_3 = d.kode_dosen
                        OR p.penulis_4 = d.kode_dosen
                        OR p.penulis_5 = d.kode_dosen
                        OR p.penulis_6 = d.kode_dosen
                        OR p.penulis_7 = d.kode_dosen
                        OR p.penulis_8 = d.kode_dosen
                        OR p.penulis_9 = d.kode_dosen
                        OR p.penulis_10 = d.kode_dosen
                        OR p.penulis_11 = d.kode_dosen)
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
                $data[$kodeDosen][$yearString] = $value["nPublikasi"];
            }
        }

        return $data;
    //     $sql = "SELECT
    //                 dosen.kode_dosen,
    //                 COUNT(CASE WHEN publikasi.tahun = 2000 THEN publikasi.kode_dosen END) AS THN_2000,
    //                 COUNT(CASE WHEN publikasi.tahun = 2001 THEN publikasi.kode_dosen END) AS THN_2001,
    //                 COUNT(CASE WHEN publikasi.tahun = 2002 THEN publikasi.kode_dosen END) AS THN_2002,
    //                 COUNT(CASE WHEN publikasi.tahun = 2003 THEN publikasi.kode_dosen END) AS THN_2003,
    //                 COUNT(CASE WHEN publikasi.tahun = 2004 THEN publikasi.kode_dosen END) AS THN_2004,
    //                 COUNT(CASE WHEN publikasi.tahun = 2005 THEN publikasi.kode_dosen END) AS THN_2005,
    //                 COUNT(CASE WHEN publikasi.tahun = 2006 THEN publikasi.kode_dosen END) AS THN_2006,
    //                 COUNT(CASE WHEN publikasi.tahun = 2007 THEN publikasi.kode_dosen END) AS THN_2007,
    //                 COUNT(CASE WHEN publikasi.tahun = 2008 THEN publikasi.kode_dosen END) AS THN_2008,
    //                 COUNT(CASE WHEN publikasi.tahun = 2009 THEN publikasi.kode_dosen END) AS THN_2009,
    //                 COUNT(CASE WHEN publikasi.tahun = 2010 THEN publikasi.kode_dosen END) AS THN_2010,
    //                 COUNT(CASE WHEN publikasi.tahun = 2011 THEN publikasi.kode_dosen END) AS THN_2011,
    //                 COUNT(CASE WHEN publikasi.tahun = 2012 THEN publikasi.kode_dosen END) AS THN_2012,
    //                 COUNT(CASE WHEN publikasi.tahun = 2013 THEN publikasi.kode_dosen END) AS THN_2013,
    //                 COUNT(CASE WHEN publikasi.tahun = 2014 THEN publikasi.kode_dosen END) AS THN_2014,
    //                 COUNT(CASE WHEN publikasi.tahun = 2015 THEN publikasi.kode_dosen END) AS THN_2015,
    //                 COUNT(CASE WHEN publikasi.tahun = 2016 THEN publikasi.kode_dosen END) AS THN_2016,
    //                 COUNT(CASE WHEN publikasi.tahun = 2017 THEN publikasi.kode_dosen END) AS THN_2017,
    //                 COUNT(CASE WHEN publikasi.tahun = 2018 THEN publikasi.kode_dosen END) AS THN_2018,
    //                 COUNT(CASE WHEN publikasi.tahun = 2019 THEN publikasi.kode_dosen END) AS THN_2019,
    //                 COUNT(CASE WHEN publikasi.tahun = 2020 THEN publikasi.kode_dosen END) AS THN_2020,
    //                 COUNT(CASE WHEN publikasi.tahun = 2021 THEN publikasi.kode_dosen END) AS THN_2021,
    //                 COUNT(CASE WHEN publikasi.tahun = 2022 THEN publikasi.kode_dosen END) AS THN_2022,
    //                 COUNT(CASE WHEN publikasi.tahun = 2023 THEN publikasi.kode_dosen END) AS THN_2023,
    //                 COUNT(CASE WHEN publikasi.tahun = 2024 THEN publikasi.kode_dosen END) AS THN_2024
    //             FROM dosen
    //             LEFT JOIN
    //                 (
    //                     SELECT penulis_1 AS kode_dosen, tahun FROM publikasi WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
    //                     UNION ALL
    //                     SELECT penulis_2, tahun FROM publikasi WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
    //                     UNION ALL
    //                     SELECT penulis_3, tahun FROM publikasi WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
    //                     UNION ALL
    //                     SELECT penulis_4, tahun FROM publikasi WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
    //                     UNION ALL
    //                     SELECT penulis_5, tahun FROM publikasi WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
    //                     UNION ALL
    //                     SELECT penulis_6, tahun FROM publikasi WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
    //                 ) AS publikasi ON dosen.kode_dosen = publikasi.kode_dosen
    //             GROUP BY dosen.kode_dosen;";
    //     $query = $this->db->query($sql);
    //     return $query->getResultArray();
    }

    public function getAllPublikasi() {
        $query = $this->db->query("SELECT * FROM `publikasi` ORDER BY `tahun` DESC");
        return $query->getResultArray();
    }

    public function getAllPublikasiLimit5() {
        $query = $this->db->query("SELECT * FROM `publikasi` ORDER BY `tahun` DESC LIMIT 5");
        return $query->getResultArray();
    }

    public function getCountPublikasiAll() {
        $sql = "SELECT 
                    jenis AS jenis_pen, 
                    COUNT(*) AS jumlah_pen 
                FROM publikasi 
                WHERE jenis IN ('Prosiding Internasional', 'Prosiding Nasional', 'Jurnal Internasional', 'Jurnal Nasional') 
                GROUP BY jenis 
                ORDER BY jumlah_pen DESC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getOrderByTahunAllJenis()
    {
        $sql = "SELECT
                    tahun,
                    SUM(CASE WHEN jenis = 'Jurnal Internasional' THEN 1 ELSE 0 END) AS jumlah_jurnal_internasional,
                    SUM(CASE WHEN jenis = 'Jurnal Nasional' THEN 1 ELSE 0 END) AS jumlah_jurnal_nasional,
                    SUM(CASE WHEN jenis = 'Prosiding Internasional' THEN 1 ELSE 0 END) AS jumlah_prosiding_internasional,
                    SUM(CASE WHEN jenis = 'Prosiding Nasional' THEN 1 ELSE 0 END) AS jumlah_prosiding_nasional
                FROM publikasi
                WHERE tahun BETWEEN 2010 AND YEAR(CURDATE())
                GROUP BY tahun
                ORDER BY tahun;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getTopPublikasiAll() {
        $sql = "SELECT 
                    dosen.nama_dosen, 
                    dosen.kode_dosen, 
                    COUNT(publikasi.kode_dosen) AS jumlah_publikasi 
                FROM dosen dosen 
                JOIN 
                    ( SELECT penulis_1 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_2 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_3 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_4 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_5 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_6 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_7 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_8 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_9 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_10 AS kode_dosen FROM publikasi UNION ALL 
                    SELECT penulis_11 AS kode_dosen FROM publikasi ) publikasi 
                ON dosen.kode_dosen = publikasi.kode_dosen 
                GROUP BY dosen.kode_dosen, dosen.nama_dosen; ";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_table_fields() {
        return $this->db->getFieldNames('publikasi');
    }

    public function getAnnualHakiByTypeAndKK() {
        // A 'Publikasi' belongs to the first writer's KK
        $sql = "WITH 
                    kk_publikasi AS (
                        SELECT DISTINCT
                            d.kk,
                            p.id,
                            p.tahun,
                            p.jenis
                        FROM publikasi AS p
                        JOIN dosen AS d
                            ON ( d.kode_dosen = p.penulis_1)
                    )
                SELECT
                    kp.kk AS kk,
                    kp.jenis AS jenis,
                    kp.tahun AS tahun, 
                    COUNT(*) AS nPublikasi
                FROM kk_publikasi AS kp
                GROUP BY kp.kk, kp.jenis, kp.tahun; ";
        return $this->db->query($sql)->getResultArray();
    }

    public function getAllByKK($kk) {
        // A 'Publikasi' belongs to the first writer's KK
        $sql = "SELECT DISTINCT p.*
                    FROM publikasi AS p
                    JOIN dosen AS d
                        ON d.kode_dosen = p.penulis_1
                            -- OR d.kode_dosen = p.penulis_2
                            -- OR d.kode_dosen = p.penulis_3
                            -- OR d.kode_dosen = p.penulis_4
                            -- OR d.kode_dosen = p.penulis_5
                            -- OR d.kode_dosen = p.penulis_6
                            -- OR d.kode_dosen = p.penulis_7
                            -- OR d.kode_dosen = p.penulis_8
                            -- OR d.kode_dosen = p.penulis_9
                            -- OR d.kode_dosen = p.penulis_10
                            -- OR d.kode_dosen = p.penulis_11
                    WHERE d.kk = ?
                    ORDER BY p.id DESC ";
        return $this->db->query($sql, [$kk])->getResultArray();
    }

    public function countAllEachDosen() {
        $sql = "WITH 
                    publikasiDosen AS (
                        SELECT DISTINCT
                            d.kode_dosen,
                            d.nama_dosen,
                            p.id
                        FROM publikasi AS p
                        JOIN dosen AS d
                            ON ( 
                                d.kode_dosen = p.penulis_1
                                OR d.kode_dosen = p.penulis_2
                                OR d.kode_dosen = p.penulis_3
                                OR d.kode_dosen = p.penulis_4
                                OR d.kode_dosen = p.penulis_5
                                OR d.kode_dosen = p.penulis_6
                                OR d.kode_dosen = p.penulis_7
                                OR d.kode_dosen = p.penulis_8
                                OR d.kode_dosen = p.penulis_9
                                OR d.kode_dosen = p.penulis_10
                                OR d.kode_dosen = p.penulis_11
                            )
                    )
                SELECT
                    kode_dosen,
                    nama_dosen,
                    COUNT(*) AS nPublikasi
                FROM publikasiDosen
                GROUP BY kode_dosen
                ORDER BY nPublikasi DESC";
        return $this->db->query($sql)->getResultArray();
    }

    public function import($filePath) {
        // Validation purpose variables
        $dosenList = (new DosenModel())->getAllKodeDosen();
        $publikasiTitles = array_map(function($v) { 
            return strtolower($v["judul_publikasi"]); },
            $this->getPublikasi()
        );
        $newPublikasiTitles = [];

        $insertFields = [ 
            // Excel format as of 24/07/29: (Please always adjust it to current format)
            // id | title | year | PENULIS1 | PENULIS2 | PENULIS3 | PENULIS4 | PENULIS5 | PENULIS6 |  PENULIS7 |  PENULIS8 |  PENULIS9 |  PENULIS10 |  PENULIS11 |  LABRISET |  authors | INSTITUSI | JENIS | JOURNAL | AKREDITASI | LINK
            'judul_publikasi', 'tahun', 'penulis_1', 
            'penulis_2', 'penulis_3', 'penulis_4',
            'penulis_5', 'penulis_6', 'penulis_7',
            'penulis_8', 'penulis_9', 'penulis_10',
            'penulis_11', 'lab_riset', 'penulis_all',
            'institusi_mitra', 'jenis', 'nama_journal_conf',
            'akreditasi_journal_conf', 'link_artikel'
        ];
        $ALLOWED_JENIS = ["jurnal internasional", "jurnal nasional", 
                        "prosiding internasional", "prosiding nasional", ];
        $ALLOWED_AKREDITASI = [ "not accredited yet", "q1", "q2", "q3", "q4",
                        "s1", "s2", "s3", "s4", "s5", "s6", "scopus"];
        $WRITER_FIELDS = array_slice($insertFields, 2, 11);

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
                    throw new \Exception("Banyak kolom tidak sesuai kriteria, yakni sebanyak " . (count($insertFields)));
                }

                $currentRow = [];
                for($idx = 0; $idx < count($insertFields); $idx++) {
                    $field = $insertFields[$idx];
                    $value = $rowCells[$idx + 1]->getValue();
                    $currentRow[$field] = $value;
                }

                // Some mandatory fields
                $isValid = ( is_numeric($currentRow["tahun"])
                            && strlen($currentRow["judul_publikasi"]) > 0
                            && strlen($currentRow["jenis"]) > 0
                            && strlen($currentRow["penulis_all"]) > 0);
                if(!$isValid) throw new \Exception("`judul_publikasi`, `tahun`, `jenis`, dan `penulis_all` harus diisi");

                // Prohibit duplicate titles 
                $isValid = !in_array(strtolower($currentRow["judul_publikasi"]), $publikasiTitles);
                if(!$isValid) { 
                    throw new \Exception("Terdapat judul publikasi serupa yang sudah terdaftar, silakan gunakan judul yang lainnya");
                }

                $isValid = !in_array(strtolower($currentRow["judul_publikasi"]), $newPublikasiTitles);
                if(!$isValid) { 
                    throw new \Exception("Terdapat judul publikasi serupa yang sama pada data input anda, silakan gunakan judul yang lainnya");
                }

                $hasWriter = false;
                foreach($WRITER_FIELDS as $wf) {
                    $writer = $currentRow[$wf];
                    $isValid = strlen($writer) == 0 || in_array($writer, $dosenList);
                    $hasWriter = $hasWriter || strlen($writer) > 0;
                    if(!$isValid) throw new \Exception("`kode_dosen` " . $writer . " tidak terdaftar sebagai dosen di database");
                }

                $isValid = $hasWriter;
                if(!$isValid) throw new \Exception("Sertakan setidaknya salah satu ketua atau anggota yang terlibat");

                $isValid = in_array(strtolower($currentRow["jenis"]), $ALLOWED_JENIS);
                if(!$isValid) throw new \Exception("Jika diisi, `jenis` harus merupakan salah satu dari {'jurnal internasional', 'jurnal nasional', 'prosiding internasional', 'prosiding nasional'}");

                $isValid = ( strlen($currentRow["akreditasi_journal_conf"]) == 0
                            || in_array(strtolower($currentRow["akreditasi_journal_conf"]), $ALLOWED_AKREDITASI));
                if(!$isValid) throw new \Exception("Jika diisi, `akreditasi_journal_conf` harus merupakan salah satu dari {'not accredited yet', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'Q1', 'Q2', 'Q3', 'Q4', 'Scopus'}");

                $isValid = ( strlen($currentRow["link_artikel"]) == 0
                            || filter_var($currentRow["link_artikel"], FILTER_VALIDATE_URL));
                if(!$isValid) throw new \Exception("Pastikan `link_artikel` merupakan URL yang valid (contoh: https://www.google.com)");

                array_push($newPublikasiTitles, strtolower($currentRow["judul_publikasi"]));
                array_push($rowData, $currentRow);
            }

            $reader->close();
            if(count($rowData) == 0) throw new \Exception("Tidak ada data yang perlu dimasukkan");

            $this->db->transStart();
            $insertedRow = $this->db->table($this->table)->insertBatch($rowData);
            $firstInsertId = $this->db->insertId();
            $insertedIDs = range($firstInsertId, $firstInsertId + $insertedRow - 1);

            $logPublikasi = new LogPublikasi();
            $logPublikasi->db->table($logPublikasi->getTableName())->insertBatch(
                array_map(
                    function($idx) use($insertedIDs, $rowData) { 
                        return [
                            "user_id" => user_id(),
                            "publikasi_id" => $insertedIDs[$idx],
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
    
    public function isPermitted($publikasi) {
        if(is_null(user())) return false;

        // Does current user is involved?
        $kodeDosen = user()->kode_dosen;
        $isInvolved = in_array($kodeDosen, [
            $publikasi["penulis_1"], $publikasi["penulis_2"],
            $publikasi["penulis_3"], $publikasi["penulis_4"], 
            $publikasi["penulis_5"], $publikasi["penulis_6"], 
            $publikasi["penulis_7"], $publikasi["penulis_8"], 
            $publikasi["penulis_9"], $publikasi["penulis_10"], 
            $publikasi["penulis_11"],
        ]);
        if($isInvolved) return true;

        // Is current user came from `KK` that involved here?
        $dosenModel = new DosenModel();
        $listAnggota = [];
        foreach(range(1, 11) as $nAnggota) {
            $anggota = $publikasi["penulis_$nAnggota"];
            if(!is_null($anggota) && $anggota != "") {
                array_push($listAnggota, $anggota);
            }
        }

        $placeholder = implode(',', array_fill(0, count($listAnggota), '?'));
        $sql = "SELECT DISTINCT CONCAT('kk_', LOWER(kk)) AS kk 
                FROM dosen 
                WHERE kode_dosen IN ($placeholder)";
        $kkPublikasi = array_map(
            function($val) {return $val["kk"]; },
            $this->db->query($sql, $listAnggota)->getResultArray()
        );
        $allowedGroups = array_merge(["admin"], $kkPublikasi);

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
