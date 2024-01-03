<?php

namespace App\Models;

use CodeIgniter\Model;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';
    public function getPublikasi_all()
    {
        return $this->findAll();
    }

    public function getPublikasi($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }

        $query = $this->db->query("SELECT * FROM publikasi WHERE penulis_1 = '$kode_dosen'");
        return $query->getResultArray();
    }
    public function getJumlahPublikasi($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_publikasi FROM publikasi WHERE (penulis_1 = '$kode_dosen' or penulis_2 = '$kode_dosen' or penulis_3 = '$kode_dosen' or penulis_4 = '$kode_dosen' or penulis_5 = '$kode_dosen' or penulias_6 = '$kode_dosen')");
        return $query->getRow()->jumlah_publikasi;
        // return $query->row()->average_score;
    }
    public function getJumlahPublikasi_1($kode_dosen = false)
    {
        if ($kode_dosen == false) {
            return $this->findAll();
        }
        $query = $this->db->query("SELECT COUNT(id) as jumlah_publikasi_1 FROM publikasi WHERE (penulis_1 = '$kode_dosen')");
        return $query->getRow()->jumlah_publikasi_1;
        // return $query->row()->average_score;
    }
    public function getPublikasiTotal()
    {
        $query = $this->db->query("SELECT COUNT(id) as count_publikasi FROM publikasi");
        return $query->getRow()->count_publikasi;
    }
    public function getPeningkatanPublikasi()
    {
        $query = $this->db->query("SELECT tahun AS tahun_sekarang, (SELECT COUNT(*) FROM publikasi 
        WHERE tahun = tahun_sekarang) AS jumlah_tahun_sekarang, (SELECT COUNT(*) FROM publikasi WHERE tahun = tahun_sekarang - 1) 
        AS jumlah_tahun_sebelumnya, (SELECT COUNT(*) FROM publikasi WHERE tahun = tahun_sekarang) - (SELECT COUNT(*) 
        FROM publikasi WHERE tahun = tahun_sekarang - 1) AS peningkatan_data FROM publikasi WHERE tahun = YEAR(NOW()) OR tahun = YEAR(NOW()) - 1");
        return $query->getRow()->peningkatan_data;
    }


    // Year Now 

    public function getPeningkatanPublikasiInter()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Internasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM publikasi 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPublikasiNas()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Jurnal Nasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM publikasi 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPublikasiPros()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Internasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM publikasi 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }
    public function getPeningkatanPublikasiProsNas()
    {
        $query = $this->db->query("SELECT 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW())) AS tahun_sekarang, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW()) - 1) AS tahun_sebelumnya, 
        (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW())) - (SELECT COUNT(*) FROM publikasi WHERE jenis = 'Prosiding Nasional' AND tahun = YEAR(NOW()) - 1) AS peningkatan_data
        FROM publikasi 
        LIMIT 1
        ");
        return $query->getRow()->peningkatan_data;
    }




    // Year Now 
    public function getPublikasiYearNowInter()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_inter FROM publikasi WHERE tahun = YEAR(NOW()) and jenis = 'Jurnal Internasional'");
        return $query->getRow()->pub_inter;
    }
    public function getPublikasiYearNowNas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_nas FROM publikasi WHERE tahun = YEAR(NOW()) and jenis = 'Jurnal Nasional'");
        return $query->getRow()->pub_nas;
    }
    public function getPublikasiYearNowPros()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_pros FROM publikasi WHERE tahun = YEAR(NOW()) and jenis = 'Prosiding Internasional'");
        return $query->getRow()->pub_pros;
    }
    public function getPublikasiYearNowProsNas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_pros_nas FROM publikasi WHERE tahun = YEAR(NOW()) and jenis = 'Prosiding Nasional'");
        return $query->getRow()->pub_pros_nas;
    }

    // Semua Tahun 
    public function getPublikasiInter()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_inter FROM publikasi WHERE jenis = 'Jurnal Internasional'");
        return $query->getRow()->pub_inter;
    }
    public function getPublikasiNas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_nas FROM publikasi WHERE jenis = 'Jurnal Nasional'");
        return $query->getRow()->pub_nas;
    }
    public function getPublikasiPros()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_pros FROM publikasi WHERE jenis = 'Prosiding Internasional'");
        return $query->getRow()->pub_pros;
    }
    public function getPublikasiProsNas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_pros_nas FROM publikasi WHERE jenis = 'Prosiding Nasional'");
        return $query->getRow()->pub_pros_nas;
    }


    public function getOrderByTahun()
    {
        $query = $this->db->query("SELECT tahun AS thn, COUNT(*) AS jumlah_pen FROM publikasi GROUP BY tahun ORDER BY tahun DESC");
        return $query->getResultArray();
    }
    public function getAkreditasi()
    {
        $query = $this->db->query("SELECT akreditasi_journal_conf AS akreditasi, COUNT(*) AS jumlah_akr FROM publikasi WHERE akreditasi_journal_conf != '-' AND akreditasi_journal_conf != '' AND akreditasi_journal_conf != 'not accredited yet' AND akreditasi_journal_conf != 'unidentified' AND akreditasi_journal_conf != 'scopus' AND akreditasi_journal_conf != 'not Scopus' AND akreditasi_journal_conf != 'riset' AND akreditasi_journal_conf != 'undefined' GROUP BY akreditasi_journal_conf ORDER BY akreditasi_journal_conf ASC");
        return $query->getResultArray();
    }

    public function getTopPublikasi()
    {
        $query = $this->db->query("SELECT dosen.nama_dosen, dosen.kode_dosen, 
        COUNT(publikasi.kode_dosen) AS jumlah_publikasi FROM dosen dosen 
        JOIN 
            ( SELECT penulis_1 AS kode_dosen FROM publikasi UNION ALL 
             SELECT penulis_2 AS kode_dosen FROM publikasi UNION ALL 
             SELECT penulis_3 AS kode_dosen FROM publikasi UNION ALL 
             SELECT penulis_4 AS kode_dosen FROM publikasi UNION ALL 
             SELECT penulis_5 AS kode_dosen FROM publikasi UNION ALL 
             SELECT penulis_6 AS kode_dosen FROM publikasi ) 
             publikasi ON dosen.kode_dosen = publikasi.kode_dosen GROUP BY dosen.kode_dosen, dosen.nama_dosen ORDER BY jumlah_publikasi DESC LIMIT 10");
        return $query->getResultArray();
    }
}
