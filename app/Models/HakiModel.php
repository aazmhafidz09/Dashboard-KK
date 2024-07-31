<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DosenModel;
use OpenSpout\Reader\Common\Creator\ReaderFactory;

class HakiModel extends Model
{
    protected $table = 'haki';
    protected $allowedFields = [
        'abstrak', 
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
        'jenis_ciptaan', 
        'judul', 
        'ketua', 
        'no_pendaftaran', 
        'no_sertifikat',
        'tahun'
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
        FROM haki WHERE tahun = tahun_sekarang - 1) AS peningkatan_data FROM haki WHERE tahun = YEAR(NOW()) OR tahun = YEAR(NOW()) - 1");
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
    public function getHakiDesainIndustri()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_buku FROM haki WHERE jenis = 'DESAIN INDUSTRI'");
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
    public function getHakiYearNowDesainIndustri()
    {
        $query = $this->db->query("SELECT COUNT(*) AS haki_buku FROM haki WHERE tahun = YEAR(NOW()) and jenis = 'DESAIN INDUSTRI'");
        return $query->getRow()->haki_buku;
    }

    // Peningkatan HAKI

    public function getPeningkatanHakiCipta()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM haki WHERE jenis = 'HAK CIPTA' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM haki 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanHakiPaten()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'PATEN' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'PATEN' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'PATEN' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM haki WHERE jenis = 'PATEN' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM haki 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanHakiMerek()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'MEREK' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'MEREK' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'MEREK' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM haki WHERE jenis = 'MEREK' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM haki 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanHakiDesainIndustri()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'DESAIN INDUSTRI' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'DESAIN INDUSTRI' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM haki WHERE jenis = 'DESAIN INDUSTRI' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM haki WHERE jenis = 'DESAIN INDUSTRI' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM haki 
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
        SUM(CASE WHEN jenis = 'Desain Industri' THEN 1 ELSE 0 END) AS Desain_Industri
    FROM
        haki
    WHERE
        tahun BETWEEN 2000 AND YEAR(CURDATE())
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
    public function get_table_fields()
    {
        return $this->db->getFieldNames('haki');
    }
    
    public function getDataDosenTahunan() {
        $sql = "
            SELECT 
                kode_dosen,
                haki.tahun, 
                COUNT(*) AS banyak_haki 
            FROM dosen 
            LEFT JOIN haki 
                ON ( haki.anggota_1 = kode_dosen 
                    OR haki.anggota_2 = kode_dosen 
                    OR haki.anggota_3 = kode_dosen 
                    OR haki.anggota_4 = kode_dosen 
                    OR haki.anggota_5 = kode_dosen 
                    OR haki.anggota_6 = kode_dosen 
                    OR haki.anggota_7 = kode_dosen 
                    OR haki.anggota_8 = kode_dosen 
                    OR haki.ketua = kode_dosen) 
            GROUP BY haki.tahun, kode_dosen
            ORDER BY kode_dosen, haki.tahun
            ;
        ";

        $data = [];
        $results = $this->db->query($sql)->getResultArray();
        $yearRange = range(2008, date("Y")); // Tel-U was found around 2013, so this should be okay
        foreach($results as $result) {
            $year = $result["tahun"];
            $kode_dosen = $result["kode_dosen"];
            $yearCount = $result["banyak_haki"];
            if(!isset($data[$kode_dosen])) {
                $data[$kode_dosen] = [ "kode_dosen" => $kode_dosen ]; // Unnecessary, but for the sake of pertaining uniformity, let it slide
                foreach($yearRange as $y) {
                    $data[$kode_dosen]['THN_' . $y] = 0;
                }
            }

            if(!is_null($year)) $data[$kode_dosen]['THN_' . $year] = $yearCount;
        }

        return $data;
    }

    public function getAnnualHakiByTypeAndKK() {
        $sql = "   
            WITH 
                kk_haki AS (
                    SELECT DISTINCT
                        h.id,
                        d.kk,
                        h.tahun,
                        h.jenis
                    FROM haki AS h
                    JOIN dosen AS d
                        ON (
                            d.kode_dosen = h.ketua
                            OR d.kode_dosen = h.anggota_1
                            OR d.kode_dosen = h.anggota_2
                            OR d.kode_dosen = h.anggota_3
                            OR d.kode_dosen = h.anggota_4
                            OR d.kode_dosen = h.anggota_5
                            OR d.kode_dosen = h.anggota_6
                            OR d.kode_dosen = h.anggota_7
                            OR d.kode_dosen = h.anggota_8
                            OR d.kode_dosen = h.anggota_9
                        )
                )
            SELECT
                kh.kk AS kk,
                kh.jenis AS jenis,
                kh.tahun AS tahun, 
                COUNT(*) AS nHaki
            FROM kk_haki AS kh
            GROUP BY kh.kk, kh.jenis, kh.tahun;
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function getAllByKK($kk) {
        $sql = "   
            SELECT DISTINCT h.*
                FROM haki AS h
                JOIN dosen AS d
                    ON d.kode_dosen = h.ketua
                        OR d.kode_dosen = h.anggota_1
                        OR d.kode_dosen = h.anggota_2
                        OR d.kode_dosen = h.anggota_3
                        OR d.kode_dosen = h.anggota_4
                        OR d.kode_dosen = h.anggota_5
                        OR d.kode_dosen = h.anggota_6
                        OR d.kode_dosen = h.anggota_7
                        OR d.kode_dosen = h.anggota_8
                        OR d.kode_dosen = h.anggota_9
                WHERE d.kk = ?
                ORDER BY h.id DESC
        ";
        return $this->db->query($sql, [$kk])->getResultArray();
    }

    public function import($filePath) {
        // Validation purpose variables
        $dosenList = (new DosenModel())->getAllKodeDosen();
        $insertFields = [ 
            // Excel format as of 24/07/29: (Please always adjust it to current format)
            // id | tahun | ketua | anggota_1 | anggota_2 |  anggota_3 |  anggota_4 |  anggota_5 | anggota_6 |  anggota_7 |  anggota_8 |  anggota_9 | jenis | jenis_ciptaan | judul | abstrak | no_pendaftaran | no_sertifikat | catatan
            'tahun', 'ketua', 'anggota_1', 
            'anggota_2', 'anggota_3', 'anggota_4', 
            'anggota_5', 'anggota_6', 'anggota_7', 
            'anggota_8', 'anggota_9', 'jenis',
            'jenis_ciptaan', 'judul', 'abstrak',
            'no_pendaftaran', 'no_sertifikat', 'catatan'
        ];
        $WRITER_FIELDS = array_slice($insertFields, 1, 10);
        $ALLOWED_JENIS = ["paten", "hak cipta", "merek", "desain industri"];

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
                    $currentRow[$field] = $value;
                }

                // Some mandatory fields
                $isValid = ( is_numeric($currentRow["tahun"])
                            && strlen($currentRow["jenis"]) > 0
                            && strlen($currentRow["judul"]) > 0);
                if(!$isValid) throw new \Exception("`judul`, `jenis`, dan `tahun` harus diisi");

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
                if(!$isValid) throw new \Exception("Jika diisi, `jenis` harus merupakan salah satu dari {'paten', 'hak cipta', 'merek', 'desain industri'}");

                array_push($rowData, $currentRow);
            }

            $reader->close();
            if(count($rowData) == 0) throw new \Exception("Tidak ada data yang perlu dimasukkan");
            $this->db->table($this->table)->insertBatch($rowData);
        } catch(DatabaseException $e) {
            return [-1, $e->getMessage()];
        } catch(\Exception $e) {
            return [-1, "(Baris ${nRow}) " . $e->getMessage()];
        } catch(\Throwable $e) {
            return [-1, "Maaf, suatu kesalahan yang tidak diketahui terjadi, pastikan anda telah mengikuti seluruh panduan. Apabila merasa sudah, silakan kontak tim pengembang"];
        }
        return [0, null];
    }
}
