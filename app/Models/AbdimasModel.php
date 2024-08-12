<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Models\DosenModel;
use App\Models\LogAbdimas;
use OpenSpout\Reader\Common\Creator\ReaderFactory;

class AbdimasModel extends Model
{
    protected $table = 'abdimas';

    protected $allowedFields =  [
        'alamat_mitra', 
        'anggota_1', 
        'anggota_2', 
        'anggota_3', 
        'anggota_4', 
        'anggota_5', 
        'anggota_6', 
        'anggota_7', 
        'anggota_8', 
        'catatan', 
        'jenis', 
        'judul', 
        'kesesuaian_roadmap',
        'ketua', 
        'lab_riset', 
        'luaran', 
        'mitra', 
        'nama_kegiatan', 
        'permasalahan_masy', 
        'solusi', 
        'status', 
        'tahun', 
        'tgl_pengesahan'
    ];

    public function getById($id) {
        return $this->db
                    ->query("SELECT * FROM abdimas WHERE id=?", [$id])
                    ->getResultArray();
    }

    public function getAbdimas($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll();
        $sql = "SELECT * 
                FROM abdimas 
                WHERE (ketua = ?
                    OR anggota_1 = ?
                    OR anggota_2 = ?
                    OR anggota_3 = ?
                    OR anggota_4 = ?
                    OR anggota_5 = ?
                    OR anggota_6 = ?
                    OR anggota_7 = ?
                    OR anggota_8 = ?);";
        $query = $this->db->query(
            $sql, array_map(function() use ($kode_dosen) {return $kode_dosen; } , range(1, 9))
        );
        return $query->getResultArray();
    }

    public function getJumlahAbdimas($kode_dosen = false) {
        if ($kode_dosen == false) return $this->findAll(); 
        $sql = "SELECT COUNT(*) AS jumlah_abdimas 
                FROM abdimas 
                WHERE (ketua = ? 
                        OR anggota_1 = ? 
                        OR anggota_2 = ? 
                        OR anggota_3 = ? 
                        OR anggota_4 = ? 
                        OR anggota_5 = ?  
                        OR anggota_6 = ?  
                        OR anggota_7 = ?  
                        OR anggota_8 = ?);";
        $query = $this->db->query(
            $sql, array_map(function() use ($kode_dosen) {return $kode_dosen; } , range(1, 9))
        );
        return $query->getRow()->jumlah_abdimas;
    }

    public function getJumlahKetua($kode_dosen = false) { 
        if ($kode_dosen == false) return $this->findAll();
        $sql = "SELECT COUNT(id) AS jumlah_ketua FROM abdimas WHERE (ketua = ?);";
        $query = $this->db->query($sql, [$kode_dosen]);
        return $query->getRow()->jumlah_ketua;
    }

    public function getAbdimasTotal() {
        $query = $this->db->query("SELECT COUNT(id) as count_abdimas FROM abdimas");
        return $query->getRow()->count_abdimas;
    }

    public function getPeningkatanAbdimas() {
        $sql = "SELECT 
                    tahun AS tahun_sekarang, (SELECT COUNT(*) FROM abdimas WHERE tahun = tahun_sekarang) AS jumlah_tahun_sekarang, 
                    (SELECT COUNT(*) FROM abdimas WHERE tahun = tahun_sekarang - 1) AS jumlah_tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM abdimas WHERE tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM abdimas WHERE tahun = YEAR(NOW()) - 1) AS peningkatan_data 
                FROM abdimas 
                WHERE tahun = YEAR(NOW()) OR tahun = YEAR(NOW()) - 1;";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    // Semua Tahun 
    public function getAbdimasInter() {
        $sql = "SELECT COUNT(*) AS abd_inter 
                FROM abdimas 
                WHERE jenis = 'internal' OR jenis='INTERNAL';";
        $query = $this->db->query($sql);
        return $query->getRow()->abd_inter;
    }

    public function getAbdimasEkste() {
        $sql = "SELECT COUNT(*) AS abd_ekster 
                FROM abdimas 
                WHERE jenis = 'eksternal' OR jenis='EKSTERNAL';";
        $query = $this->db->query($sql);
        return $query->getRow()->abd_ekster;
    }

    public function getAbdimasInterEkster() {
        $sql = "SELECT COUNT(*) AS abd_inter_ekster 
                FROM abdimas 
                WHERE jenis = 'INTERNAL & EKSTERNAL';";
        $query = $this->db->query($sql);
        return $query->getRow()->abd_inter_ekster;
    }

    // Year Now 
    public function getAbdimasYearNowInter() {
        $sql = "SELECT COUNT(*) AS abd_inter 
                FROM abdimas 
                WHERE tahun = YEAR(NOW()) AND jenis = 'INTERNAL';";
        $query = $this->db->query($sql);
        return $query->getRow()->abd_inter;
    }

    public function getAbdimasYearNowEkste() {
        $sql = "SELECT COUNT(*) AS abd_ekster 
                FROM abdimas 
                WHERE tahun = YEAR(NOW()) and jenis = 'Eksternal';";
        $query = $this->db->query($sql);
        return $query->getRow()->abd_ekster;
    }

    public function getAbdimasYearNowInterEkster() {
        $sql = "SELECT COUNT(*) AS abd_inter_ekster 
                FROM abdimas 
                WHERE tahun = YEAR(NOW()) and jenis = 'INTERNAL & EKSTERNAL';";
        $query = $this->db->query($sql);
        return $query->getRow()->abd_inter_ekster;
    }

    // Peningkatan Penelitian
    public function getPeningkatanAbdimasInter() {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM abdimas WHERE jenis = 'internal' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM abdimas 
                LIMIT 1; ";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanAbdimasEkste()
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM abdimas WHERE jenis = 'EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM abdimas 
                LIMIT 1; ";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanAbdimasInterEkster()
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
                    (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM abdimas WHERE jenis = 'INTERNAL & EKSTERNAL' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
                FROM abdimas 
                LIMIT 1; ";
        $query = $this->db->query($sql);
        return $query->getRow()->peningkatan_data;
    }

    public function getOrderByTahun() {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_abd FROM abdimas GROUP BY tahun ORDER BY tahun DESC");
        return $query->getResultArray();
    }

    public function getOrderByTahunDesc() {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_abd FROM abdimas GROUP BY tahun ORDER BY tahun ASC");
        return $query->getResultArray();
    }

    public function getDataDosenTahunan() {
        $sql = "SELECT
                    d.kode_dosen,
                    a.tahun,
                    COUNT(*) AS nAbdimas
                FROM abdimas AS a
                RIGHT JOIN dosen AS d
                    ON (
                        a.ketua = d.kode_dosen
                        OR a.anggota_1 = d.kode_dosen
                        OR a.anggota_2 = d.kode_dosen
                        OR a.anggota_3 = d.kode_dosen
                        OR a.anggota_4 = d.kode_dosen
                        OR a.anggota_5 = d.kode_dosen
                        OR a.anggota_6 = d.kode_dosen
                        OR a.anggota_7 = d.kode_dosen
                        OR a.anggota_8 = d.kode_dosen
                    )
                GROUP BY d.kode_dosen, a.tahun; ";
        $result = $this->db->query($sql)->getResultArray();

        $data = [];
        foreach($result as $value) {
            $kodeDosen = $value["kode_dosen"];
            if(!isset($data[$kodeDosen])) {
                $data[$kodeDosen] = ["kode_dosen" => $kodeDosen];
            }

            if(!is_null($value["tahun"])) {
                $yearString = "THN_" .$value["tahun"];
                $data[$kodeDosen][$yearString] = $value["nAbdimas"];
            }
        }

        return $data;

        // $sql2 = "SELECT
        //             dosen.kode_dosen,
        //             COUNT(CASE WHEN abdimas.tahun = 2000 THEN abdimas.kode_dosen END) AS THN_2000,
        //             COUNT(CASE WHEN abdimas.tahun = 2001 THEN abdimas.kode_dosen END) AS THN_2001,
        //             COUNT(CASE WHEN abdimas.tahun = 2002 THEN abdimas.kode_dosen END) AS THN_2002,
        //             COUNT(CASE WHEN abdimas.tahun = 2003 THEN abdimas.kode_dosen END) AS THN_2003,
        //             COUNT(CASE WHEN abdimas.tahun = 2004 THEN abdimas.kode_dosen END) AS THN_2004,
        //             COUNT(CASE WHEN abdimas.tahun = 2005 THEN abdimas.kode_dosen END) AS THN_2005,
        //             COUNT(CASE WHEN abdimas.tahun = 2006 THEN abdimas.kode_dosen END) AS THN_2006,
        //             COUNT(CASE WHEN abdimas.tahun = 2007 THEN abdimas.kode_dosen END) AS THN_2007,
        //             COUNT(CASE WHEN abdimas.tahun = 2008 THEN abdimas.kode_dosen END) AS THN_2008,
        //             COUNT(CASE WHEN abdimas.tahun = 2009 THEN abdimas.kode_dosen END) AS THN_2009,
        //             COUNT(CASE WHEN abdimas.tahun = 2010 THEN abdimas.kode_dosen END) AS THN_2010,
        //             COUNT(CASE WHEN abdimas.tahun = 2011 THEN abdimas.kode_dosen END) AS THN_2011,
        //             COUNT(CASE WHEN abdimas.tahun = 2012 THEN abdimas.kode_dosen END) AS THN_2012,
        //             COUNT(CASE WHEN abdimas.tahun = 2013 THEN abdimas.kode_dosen END) AS THN_2013,
        //             COUNT(CASE WHEN abdimas.tahun = 2014 THEN abdimas.kode_dosen END) AS THN_2014,
        //             COUNT(CASE WHEN abdimas.tahun = 2015 THEN abdimas.kode_dosen END) AS THN_2015,
        //             COUNT(CASE WHEN abdimas.tahun = 2016 THEN abdimas.kode_dosen END) AS THN_2016,
        //             COUNT(CASE WHEN abdimas.tahun = 2017 THEN abdimas.kode_dosen END) AS THN_2017,
        //             COUNT(CASE WHEN abdimas.tahun = 2018 THEN abdimas.kode_dosen END) AS THN_2018,
        //             COUNT(CASE WHEN abdimas.tahun = 2019 THEN abdimas.kode_dosen END) AS THN_2019,
        //             COUNT(CASE WHEN abdimas.tahun = 2020 THEN abdimas.kode_dosen END) AS THN_2020,
        //             COUNT(CASE WHEN abdimas.tahun = 2021 THEN abdimas.kode_dosen END) AS THN_2021,
        //             COUNT(CASE WHEN abdimas.tahun = 2022 THEN abdimas.kode_dosen END) AS THN_2022,
        //             COUNT(CASE WHEN abdimas.tahun = 2023 THEN abdimas.kode_dosen END) AS THN_2023,
        //             COUNT(CASE WHEN abdimas.tahun = 2024 THEN abdimas.kode_dosen END) AS THN_2024
        //         FROM dosen
        //         LEFT JOIN
        //             (
        //                 SELECT ketua AS kode_dosen, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_1, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_2, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_3, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_4, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_5, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_6, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_7, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //                 UNION ALL
        //                 SELECT anggota_8, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        //             ) AS abdimas ON dosen.kode_dosen = abdimas.kode_dosen
        //         GROUP BY dosen.kode_dosen;";
        // $query = $this->db->query($sql);
        // dd($query);
        // return $query->getResultArray();
    }

    public function getAllAbdimas() {
        $query = $this->db->query("SELECT * FROM `abdimas` ORDER BY `tahun` DESC");
        return $query->getResultArray();
    }

    public function getAllAbdimasLimit5() {
        $query = $this->db->query("SELECT * FROM `abdimas` ORDER BY `tahun` DESC LIMIT 5");
        return $query->getResultArray();
    }

    public function getOrderByTahunAllJenis() {
        $sql = "SELECT
                    tahun,
                    SUM(CASE WHEN jenis = 'Internal' THEN 1 ELSE 0 END) AS jumlah_Internal,
                    SUM(CASE WHEN jenis = 'Eksternal' THEN 1 ELSE 0 END) AS jumlah_Eksternal,
                    SUM(CASE WHEN jenis = 'Internal dan Eksternal' THEN 1 ELSE 0 END) AS jumlah_Internal_Eksternal
                FROM abdimas
                WHERE tahun BETWEEN 2010 AND YEAR(CURDATE())
                GROUP BY tahun;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getTopAbdimasAll() {
        $sql = "SELECT 
                    dosen.nama_dosen, 
                    dosen.kode_dosen, 
                COUNT(abdimas.kode_dosen) AS jumlah_abdimas FROM dosen dosen 
                JOIN 
                    ( SELECT ketua AS kode_dosen FROM abdimas UNION ALL 
                    SELECT anggota_1 AS kode_dosen FROM abdimas UNION ALL 
                    SELECT anggota_2 AS kode_dosen FROM abdimas UNION ALL 
                    SELECT anggota_3 AS kode_dosen FROM abdimas UNION ALL 
                    SELECT anggota_4 AS kode_dosen FROM abdimas UNION ALL 
                    SELECT anggota_5 AS kode_dosen FROM abdimas UNION ALL
                    SELECT anggota_6 AS kode_dosen FROM abdimas UNION ALL
                    SELECT anggota_7 AS kode_dosen FROM abdimas UNION ALL
                    SELECT anggota_8 AS kode_dosen FROM abdimas
                    ) abdimas 
                ON dosen.kode_dosen = abdimas.kode_dosen 
                GROUP BY dosen.kode_dosen, dosen.nama_dosen; ";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_table_fields() {
        return $this->db->getFieldNames('abdimas');
    }

    public function getAnnualAbdimasByTypeAndKK() {
        $sql = "WITH 
                    kk_abdimas AS (
                        SELECT DISTINCT
                            a.id,
                            d.kk,
                            a.tahun,
                            a.jenis
                        FROM abdimas AS a
                        JOIN dosen AS d
                            ON (
                                d.kode_dosen = a.ketua
                                OR d.kode_dosen = a.anggota_1
                                OR d.kode_dosen = a.anggota_2
                                OR d.kode_dosen = a.anggota_3
                                OR d.kode_dosen = a.anggota_4
                                OR d.kode_dosen = a.anggota_5
                                OR d.kode_dosen = a.anggota_6
                                OR d.kode_dosen = a.anggota_7
                                OR d.kode_dosen = a.anggota_8
                            )
                    )
                SELECT
                    ka.kk AS kk,
                    ka.jenis AS jenis,
                    ka.tahun AS tahun, 
                    COUNT(*) AS nAbdimas
                FROM kk_abdimas AS ka
                GROUP BY ka.kk, ka.jenis, ka.tahun; ";
        return $this->db->query($sql)->getResultArray();
    }

    public function getAllByKK($kk) {
        $sql = "SELECT DISTINCT a.*
                    FROM abdimas AS a
                    JOIN dosen AS d
                        ON d.kode_dosen = a.ketua
                            OR d.kode_dosen = a.anggota_1
                            OR d.kode_dosen = a.anggota_2
                            OR d.kode_dosen = a.anggota_3
                            OR d.kode_dosen = a.anggota_4
                            OR d.kode_dosen = a.anggota_5
                            OR d.kode_dosen = a.anggota_6
                            OR d.kode_dosen = a.anggota_7
                            OR d.kode_dosen = a.anggota_8
                    WHERE d.kk = ?
                    ORDER BY a.id DESC ";
        return $this->db->query($sql, [$kk])->getResultArray();
    }

    public function countAllEachDosen() {
        $sql = "WITH 
                    abdimasDosen AS (
                        SELECT DISTINCT
                            d.kode_dosen,
                            d.nama_dosen,
                            a.id
                        FROM abdimas AS a
                        JOIN dosen AS d
                            ON (
                                d.kode_dosen = a.ketua
                                OR d.kode_dosen = a.anggota_1
                                OR d.kode_dosen = a.anggota_2
                                OR d.kode_dosen = a.anggota_3
                                OR d.kode_dosen = a.anggota_4
                                OR d.kode_dosen = a.anggota_5
                                OR d.kode_dosen = a.anggota_6
                                OR d.kode_dosen = a.anggota_7
                                OR d.kode_dosen = a.anggota_8
                            )
                    )
                SELECT
                    kode_dosen,
                    nama_dosen,
                    COUNT(*) AS nAbdimas
                FROM abdimasDosen
                GROUP BY kode_dosen
                ORDER BY nAbdimas DESC";
        return $this->db->query($sql)->getResultArray();
    }

    public function import($filePath) {
        // Validation purpose variables
        $dosenList = (new DosenModel())->getAllKodeDosen();
        $insertFields = [ 
            // Excel format as of 24/07/29: (Please always adjust it to current format)
            // id | tahun | jenis | nama_kegiatan | judul | status | lab_riset | ketua | anggota_1 |  anggota_2 |  anggota_3 |  anggota_4 |  anggota_5 |  anggota_6 |  anggota_7 |  anggota_8 | mitra | alamat_mitra | kesesuaian_roadmap | permasalahan_masy | solusi | catatan | luaran | tgl_pengesahan
            'tahun', 'jenis', 'nama_kegiatan', 
            'judul', 'status', 'lab_riset',
            'ketua', 'anggota_1', 'anggota_2',
            'anggota_3', 'anggota_4', 'anggota_5',
            'anggota_6', 'anggota_7', 'anggota_8',
            'mitra', 'alamat_mitra', 'kesesuaian_roadmap',
            'permasalahan_masy', 'solusi', 'catatan',
            'luaran', 'tgl_pengesahan',
        ];
        $ALLOWED_JENIS = ["internal", "eksternal"];
        $ALLOWED_STATUS = ["didanai", "tidak didanai", "closed"];
        $WRITER_FIELDS = array_slice($insertFields, 6, 9);

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
                            && strlen($currentRow["status"]) > 0
                            && strlen($currentRow["jenis"]) > 0
                            && strlen($currentRow["judul"]) > 0);
                if(!$isValid) throw new \Exception("`judul`, `status`, `jenis`, dan `tahun` harus diisi");

                $hasWriter = false;
                foreach($WRITER_FIELDS as $wf) {
                    $writer = $currentRow[$wf];
                    $isValid = strlen($writer) == 0 || in_array($writer, $dosenList);
                    $hasWriter = $hasWriter || strlen($writer) > 0;
                    if(!$isValid) throw new \Exception("`kode_dosen` " . $writer . " tidak terdaftar sebagai dosen di database");
                }

                $isValid = $hasWriter;
                if(!$isValid) throw new \Exception("Sertakan setidaknya salah satu ketua atau anggota yang terlibat");

                $isValid = (
                    strlen($currentRow["jenis"]) == 0 
                    || in_array(strtolower($currentRow["jenis"]), $ALLOWED_JENIS));
                if(!$isValid) throw new \Exception("Jika diisi, `jenis` harus merupakan salah satu dari {'internal', 'eksternal'}");

                $isValid = (
                    strlen($currentRow["status"]) == 0
                    || in_array(strtolower($currentRow["status"]), $ALLOWED_STATUS));
                if(!$isValid) throw new \Exception("Jika diisi, `status` harus merupakan salah satu dari {'didanai', 'tidak didanai', 'closed'}");

                array_push($rowData, $currentRow);
            }

            $reader->close();
            if(count($rowData) == 0) throw new \Exception("Tidak ada data yang perlu dimasukkan");

            $this->db->transStart();
            $insertedRow = $this->db->table($this->table)->insertBatch($rowData);
            $firstInsertId = $this->db->insertId();
            $insertedIDs = range($firstInsertId, $firstInsertId + $insertedRow - 1);

            $logAbdimas = new LogAbdimas();
            $logAbdimas->db->table($logAbdimas->getTableName())->insertBatch(
                array_map(
                    function($idx) use($insertedIDs, $rowData) { 
                        return [
                            "user_id" => user_id(),
                            "abdimas_id" => $insertedIDs[$idx],
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

    public function isPermitted($abdimas) {
        if(is_null(user())) return false;

        // Does current user is involved?
        $kodeDosen = user()->kode_dosen;
        $isInvolved = in_array($kodeDosen, [
            $abdimas["ketua"], $abdimas["anggota_1"],
            $abdimas["anggota_2"], $abdimas["anggota_3"],
            $abdimas["anggota_4"], $abdimas["anggota_5"],
            $abdimas["anggota_6"], $abdimas["anggota_7"],
            $abdimas["anggota_8"],
        ]);
        if($isInvolved) return true;

        // Is current user came from `KK` that involved here?
        $dosenModel = new DosenModel();
        $listAnggota = [];
        if(!is_null($abdimas["ketua"]) && $abdimas["ketua"] != "") {
            array_push($listAnggota, $abdimas["ketua"]);
        }

        foreach(range(1, 8) as $nAnggota) {
            $anggota = $abdimas["anggota_$nAnggota"];
            if(!is_null($anggota) && $anggota != "") {
                array_push($listAnggota, $anggota);
            }
        }

        $placeholder = implode(',', array_fill(0, count($listAnggota), '?'));
        $sql = "SELECT DISTINCT CONCAT('kk_', LOWER(kk)) AS kk 
                FROM dosen 
                WHERE kode_dosen IN ($placeholder)";
        $kkAbdimas = array_map(
            function($val) {return $val["kk"]; },
            $this->db->query($sql, $listAnggota)->getResultArray()
        );
        $allowedGroups = array_merge(["admin"], $kkAbdimas);

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
