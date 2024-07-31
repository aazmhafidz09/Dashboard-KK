<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DosenModel;
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

    public function getPenelitian($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }

        $query = $this->db->query("SELECT * FROM penelitian WHERE (ketua_peneliti = '$kode_dosen' or anggota_peneliti_1 = '$kode_dosen' or anggota_peneliti_2 = '$kode_dosen' or anggota_peneliti_3 = '$kode_dosen'  or anggota_peneliti_4 = '$kode_dosen' or anggota_peneliti_5 = '$kode_dosen' or anggota_peneliti_6 = '$kode_dosen' or anggota_peneliti_7 = '$kode_dosen' or anggota_peneliti_8 = '$kode_dosen' or anggota_peneliti_9 = '$kode_dosen' or anggota_peneliti_10 = '$kode_dosen')");
        return $query->getResultArray();
    }
    public function getJumlahPenelitian($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_penelitian FROM penelitian WHERE (ketua_peneliti = '$kode_dosen' or anggota_peneliti_1 = '$kode_dosen' or anggota_peneliti_2 = '$kode_dosen' or anggota_peneliti_3 = '$kode_dosen' or anggota_peneliti_4 = '$kode_dosen'  or anggota_peneliti_5 = '$kode_dosen' or anggota_peneliti_6 = '$kode_dosen' or anggota_peneliti_7 = '$kode_dosen' or anggota_peneliti_8 = '$kode_dosen' or anggota_peneliti_9 = '$kode_dosen' or anggota_peneliti_10 = '$kode_dosen')");
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
        $query = $this->db->query("SELECT jenis AS jenis_pen, COUNT(*) AS jumlah_pen FROM penelitian GROUP BY jenis ORDER BY jumlah_pen DESC");
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
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM penelitian WHERE jenis = 'Kerjasama Perguruan Tinggi' GROUP BY tahun ORDER BY tahun ASC;");
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

    public function getAnnualPenelitianByType() {
        $sql = "   
            WITH 
                kk_penelitian AS (
                    SELECT DISTINCT
                        p.id,
                        p.tahun,
                        p.jenis,
                        d.kk
                    FROM penelitian AS p
                    JOIN dosen AS d
                        ON (
                            d.kode_dosen = p.ketua_peneliti
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
            GROUP BY kp.jenis, kp.tahun;
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function getAnnualPenelitianByTypeAndKK() {
        $sql = "   
            WITH 
                kk_penelitian AS (
                    SELECT DISTINCT
                        p.id,
                        d.kk,
                        p.tahun,
                        p.jenis
                    FROM penelitian AS p
                    JOIN dosen AS d
                        ON (
                            d.kode_dosen = p.ketua_peneliti
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
            GROUP BY kp.kk, kp.jenis, kp.tahun;
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function getAllByKK($kk) {
        $sql = "   
            SELECT DISTINCT p.*
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
                ORDER BY p.id DESC
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
