<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Models\DosenModel;
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
        'anggota_9', 
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

    public function getAbdimas($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }

        $query = $this->db->query("SELECT * FROM abdimas WHERE (ketua = '$kode_dosen' or anggota_1 = '$kode_dosen' or anggota_2 = '$kode_dosen' or anggota_3 = '$kode_dosen' or anggota_4 = '$kode_dosen' or anggota_5 = '$kode_dosen'  or anggota_6 = '$kode_dosen'  or anggota_7 = '$kode_dosen'  or anggota_8 = '$kode_dosen')");
        return $query->getResultArray();
    }
    public function getJumlahAbdimas($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_abdimas FROM abdimas WHERE (ketua = '$kode_dosen' or anggota_1 = '$kode_dosen' or anggota_2 = '$kode_dosen' or anggota_3 = '$kode_dosen' or anggota_4 = '$kode_dosen' or anggota_5 = '$kode_dosen'  or anggota_6 = '$kode_dosen'  or anggota_7 = '$kode_dosen'  or anggota_8 = '$kode_dosen')");
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
        AS jumlah_tahun_sebelumnya, (SELECT COUNT(*) FROM abdimas WHERE tahun = YEAR(NOW())) - (SELECT COUNT(*) 
        FROM abdimas WHERE tahun = YEAR(NOW()) - 1) AS peningkatan_data FROM abdimas WHERE tahun = YEAR(NOW()) OR tahun = YEAR(NOW()) - 1");
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
    public function getOrderByTahunDesc()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_abd FROM abdimas GROUP BY tahun ORDER BY tahun ASC");
        return $query->getResultArray();
    }

    public function getDataDosenTahunan()
    {
        $query = $this->db->query("SELECT
        dosen.kode_dosen,
        COUNT(CASE WHEN abdimas.tahun = 2000 THEN abdimas.kode_dosen END) AS THN_2000,
        COUNT(CASE WHEN abdimas.tahun = 2001 THEN abdimas.kode_dosen END) AS THN_2001,
        COUNT(CASE WHEN abdimas.tahun = 2002 THEN abdimas.kode_dosen END) AS THN_2002,
        COUNT(CASE WHEN abdimas.tahun = 2003 THEN abdimas.kode_dosen END) AS THN_2003,
        COUNT(CASE WHEN abdimas.tahun = 2004 THEN abdimas.kode_dosen END) AS THN_2004,
        COUNT(CASE WHEN abdimas.tahun = 2005 THEN abdimas.kode_dosen END) AS THN_2005,
        COUNT(CASE WHEN abdimas.tahun = 2006 THEN abdimas.kode_dosen END) AS THN_2006,
        COUNT(CASE WHEN abdimas.tahun = 2007 THEN abdimas.kode_dosen END) AS THN_2007,
        COUNT(CASE WHEN abdimas.tahun = 2008 THEN abdimas.kode_dosen END) AS THN_2008,
        COUNT(CASE WHEN abdimas.tahun = 2009 THEN abdimas.kode_dosen END) AS THN_2009,
        COUNT(CASE WHEN abdimas.tahun = 2010 THEN abdimas.kode_dosen END) AS THN_2010,
        COUNT(CASE WHEN abdimas.tahun = 2011 THEN abdimas.kode_dosen END) AS THN_2011,
        COUNT(CASE WHEN abdimas.tahun = 2012 THEN abdimas.kode_dosen END) AS THN_2012,
        COUNT(CASE WHEN abdimas.tahun = 2013 THEN abdimas.kode_dosen END) AS THN_2013,
        COUNT(CASE WHEN abdimas.tahun = 2014 THEN abdimas.kode_dosen END) AS THN_2014,
        COUNT(CASE WHEN abdimas.tahun = 2015 THEN abdimas.kode_dosen END) AS THN_2015,
        COUNT(CASE WHEN abdimas.tahun = 2016 THEN abdimas.kode_dosen END) AS THN_2016,
        COUNT(CASE WHEN abdimas.tahun = 2017 THEN abdimas.kode_dosen END) AS THN_2017,
        COUNT(CASE WHEN abdimas.tahun = 2018 THEN abdimas.kode_dosen END) AS THN_2018,
        COUNT(CASE WHEN abdimas.tahun = 2019 THEN abdimas.kode_dosen END) AS THN_2019,
        COUNT(CASE WHEN abdimas.tahun = 2020 THEN abdimas.kode_dosen END) AS THN_2020,
        COUNT(CASE WHEN abdimas.tahun = 2021 THEN abdimas.kode_dosen END) AS THN_2021,
        COUNT(CASE WHEN abdimas.tahun = 2022 THEN abdimas.kode_dosen END) AS THN_2022,
        COUNT(CASE WHEN abdimas.tahun = 2023 THEN abdimas.kode_dosen END) AS THN_2023,
        COUNT(CASE WHEN abdimas.tahun = 2024 THEN abdimas.kode_dosen END) AS THN_2024
    FROM
        dosen
    LEFT JOIN
        (
            SELECT ketua AS kode_dosen, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_1, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_2, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_3, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_4, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_5, tahun FROM abdimas WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
        ) AS abdimas ON dosen.kode_dosen = abdimas.kode_dosen
    GROUP BY
        dosen.kode_dosen;");
        return $query->getResultArray();
    }

    public function getAllAbdimas()
    {
        $query = $this->db->query("SELECT * FROM `abdimas` ORDER BY `tahun` DESC");
        return $query->getResultArray();
    }
    public function getAllAbdimasLimit5()
    {
        $query = $this->db->query("SELECT * FROM `abdimas` ORDER BY `tahun` DESC LIMIT 5");
        return $query->getResultArray();
    }

    public function getOrderByTahunAllJenis()
    {
        $query = $this->db->query("SELECT
        tahun,
        SUM(CASE WHEN jenis = 'Internal' THEN 1 ELSE 0 END) AS jumlah_Internal,
        SUM(CASE WHEN jenis = 'Eksternal' THEN 1 ELSE 0 END) AS jumlah_Eksternal,
        SUM(CASE WHEN jenis = 'Internal dan Eksternal' THEN 1 ELSE 0 END) AS jumlah_Internal_Eksternal
    FROM
        abdimas
    WHERE
        tahun BETWEEN 2010 AND YEAR(CURDATE())
    GROUP BY
        tahun;");
        return $query->getResultArray();
    }

    public function getTopAbdimasAll()
    {
        $query = $this->db->query("SELECT dosen.nama_dosen, dosen.kode_dosen, 
        COUNT(abdimas.kode_dosen) AS jumlah_abdimas FROM dosen dosen 
        JOIN 
            ( SELECT ketua AS kode_dosen FROM abdimas UNION ALL 
             SELECT anggota_1 AS kode_dosen FROM abdimas UNION ALL 
             SELECT anggota_2 AS kode_dosen FROM abdimas UNION ALL 
             SELECT anggota_3 AS kode_dosen FROM abdimas UNION ALL 
             SELECT anggota_4 AS kode_dosen FROM abdimas UNION ALL 
             SELECT anggota_5 AS kode_dosen FROM abdimas ) 
             abdimas ON dosen.kode_dosen = abdimas.kode_dosen GROUP BY dosen.kode_dosen, dosen.nama_dosen ");
        return $query->getResultArray();
    }
    public function get_table_fields()
    {
        return $this->db->getFieldNames('abdimas');
    }

    public function getAnnualAbdimasByTypeAndKK() {
        $sql = "   
            WITH 
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
            GROUP BY ka.kk, ka.jenis, ka.tahun;
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function getAllByKK($kk) {
        $sql = "   
            SELECT DISTINCT a.*
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
                ORDER BY a.id DESC
        ";

        return $this->db->query($sql, [$kk])->getResultArray();
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

        $rowData = [];
        $isTableHeader = true;
        try {
            $reader = ReaderFactory::createFromFileByMimeType($filePath); // TODO (Security): mime type can be unreliable as it could be spoofed
            $reader->open($filePath);
            $sheet = $reader->getSheetIterator()->current(); // Assuming only the first sheet would be used
            foreach($sheet->getRowIterator() as $row) {
                if($isTableHeader) {$isTableHeader = false; continue;}

                $rowCells = $row->getCells();
                if(count($rowCells) - 1 != count($insertFields)) { // Excluding id which exists in template
                    throw new \Exception("Banyak kolom tidak sesuai kriteria, yakni sebanyak " . (count($insertFields) - 1));
                }

                $currentRow = [];
                for($idx = 0; $idx < count($insertFields); $idx++) {
                    $field = $insertFields[$idx];
                    $value = $rowCells[$idx + 1]->getValue();
                    $currentRow[$field] = (
                        ($field == "tgl_pengesahan" && !is_string($value))
                        ? date_format($value, 'Y-m-d H:i:s')
                        : $value
                    );
                }

                // Validate
                $isValid = ( // Mandatory fields
                    is_numeric($currentRow["tahun"])
                    && strlen($currentRow["judul"]) > 0
                );
                if(!$isValid) throw new \Exception("`judul` and `tahun` harus diisi");

                $WRITER_FIELDS = array_slice($insertFields, 6, 9);
                foreach($WRITER_FIELDS as $wf) {
                    $writer = $currentRow[$wf];
                    $isValid = ( strlen($writer) == 0 || in_array($writer, $dosenList));
                    if(!$isValid) throw new \Exception("`kode_dosen` " . $writer . " tidak terdaftar sebagai dosen di database");
                }

                $isValid = (
                    strlen($currentRow["jenis"]) == 0 
                    || in_array(strtolower($currentRow["jenis"]), $ALLOWED_JENIS)
                );
                if(!$isValid) throw new \Exception("Jika diisi, `jenis` harus merupakan salah satu dari {'internal', 'eksternal'}");

                $isValid = (
                    strlen($currentRow["status"]) == 0
                    || in_array(strtolower($currentRow["status"]), $ALLOWED_STATUS)
                );
                if(!$isValid) throw new \Exception("Jika diisi, `status` harus merupakan salah satu dari {'didanai', 'tidak didanai', 'closed'}");

                // TODO: validate 'tgl_pengesahan'
                array_push($rowData, $currentRow);
            }

            $reader->close();
            if(count($rowData) == 0) throw new \Exception("Tidak ada data yang perlu dimasukkan");
            $this->db->table($this->table)->insertBatch($rowData);
        } catch(DatabaseException $e) { // TODO: For better UX, return the message too // 
            return [-1, $e->getMessage()];
        } catch(\Exception $e) { // TODO: For better UX, return the message too // 
            return [-1, $e->getMessage()];
        }
        return [0, null];
    }
}
