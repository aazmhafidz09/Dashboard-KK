<?php

namespace App\Models;

use CodeIgniter\Model;

class PenelitianModel extends Model
{
    protected $table = 'penelitian';

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

    public function getDataDosenTahunan()
    {
        $query = $this->db->query("SELECT
        dosen.kode_dosen,
        COUNT(CASE WHEN penelitian.tahun = 2000 THEN penelitian.kode_dosen END) AS THN_2000,
        COUNT(CASE WHEN penelitian.tahun = 2001 THEN penelitian.kode_dosen END) AS THN_2001,
        COUNT(CASE WHEN penelitian.tahun = 2002 THEN penelitian.kode_dosen END) AS THN_2002,
        COUNT(CASE WHEN penelitian.tahun = 2003 THEN penelitian.kode_dosen END) AS THN_2003,
        COUNT(CASE WHEN penelitian.tahun = 2004 THEN penelitian.kode_dosen END) AS THN_2004,
        COUNT(CASE WHEN penelitian.tahun = 2005 THEN penelitian.kode_dosen END) AS THN_2005,
        COUNT(CASE WHEN penelitian.tahun = 2006 THEN penelitian.kode_dosen END) AS THN_2006,
        COUNT(CASE WHEN penelitian.tahun = 2007 THEN penelitian.kode_dosen END) AS THN_2007,
        COUNT(CASE WHEN penelitian.tahun = 2008 THEN penelitian.kode_dosen END) AS THN_2008,
        COUNT(CASE WHEN penelitian.tahun = 2009 THEN penelitian.kode_dosen END) AS THN_2009,
        COUNT(CASE WHEN penelitian.tahun = 2010 THEN penelitian.kode_dosen END) AS THN_2010,
        COUNT(CASE WHEN penelitian.tahun = 2011 THEN penelitian.kode_dosen END) AS THN_2011,
        COUNT(CASE WHEN penelitian.tahun = 2012 THEN penelitian.kode_dosen END) AS THN_2012,
        COUNT(CASE WHEN penelitian.tahun = 2013 THEN penelitian.kode_dosen END) AS THN_2013,
        COUNT(CASE WHEN penelitian.tahun = 2014 THEN penelitian.kode_dosen END) AS THN_2014,
        COUNT(CASE WHEN penelitian.tahun = 2015 THEN penelitian.kode_dosen END) AS THN_2015,
        COUNT(CASE WHEN penelitian.tahun = 2016 THEN penelitian.kode_dosen END) AS THN_2016,
        COUNT(CASE WHEN penelitian.tahun = 2017 THEN penelitian.kode_dosen END) AS THN_2017,
        COUNT(CASE WHEN penelitian.tahun = 2018 THEN penelitian.kode_dosen END) AS THN_2018,
        COUNT(CASE WHEN penelitian.tahun = 2019 THEN penelitian.kode_dosen END) AS THN_2019,
        COUNT(CASE WHEN penelitian.tahun = 2020 THEN penelitian.kode_dosen END) AS THN_2020,
        COUNT(CASE WHEN penelitian.tahun = 2021 THEN penelitian.kode_dosen END) AS THN_2021,
        COUNT(CASE WHEN penelitian.tahun = 2022 THEN penelitian.kode_dosen END) AS THN_2022,
        COUNT(CASE WHEN penelitian.tahun = 2023 THEN penelitian.kode_dosen END) AS THN_2023,
        COUNT(CASE WHEN penelitian.tahun = 2024 THEN penelitian.kode_dosen END) AS THN_2024
    FROM
        dosen
    LEFT JOIN
        (
            SELECT ketua_peneliti AS kode_dosen, tahun FROM penelitian WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_peneliti_1, tahun FROM penelitian WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_peneliti_2, tahun FROM penelitian WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_peneliti_3, tahun FROM penelitian WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
            UNION ALL
            SELECT anggota_peneliti_4, tahun FROM penelitian WHERE tahun IN (2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024)
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
}
