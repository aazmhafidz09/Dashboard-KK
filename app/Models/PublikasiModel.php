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
    public function getPublikasiYearNowInter()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_inter FROM publikasi WHERE tahun = YEAR(NOW()) and nama_journal_conf = 'Jurnal Internasional'");
        return $query->getRow()->pub_inter;
    }
    public function getPublikasiYearNowNas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_nas FROM publikasi WHERE tahun = YEAR(NOW()) and nama_journal_conf = 'Jurnal Nasional'");
        return $query->getRow()->pub_nas;
    }
    public function getPublikasiYearNowPros()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_pros FROM publikasi WHERE tahun = YEAR(NOW()) and nama_journal_conf = 'Prosiding Internasional'");
        return $query->getRow()->pub_pros;
    }
    public function getPublikasiYearNowProsNas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS pub_pros_nas FROM publikasi WHERE tahun = YEAR(NOW()) and nama_journal_conf = 'Prosiding Nasional'");
        return $query->getRow()->pub_pros_nas;
    }
}
