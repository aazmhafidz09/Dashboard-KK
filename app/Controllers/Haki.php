<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;

class Haki extends BaseController
{
    protected $dosenModel;
    protected $publikasiModel;
    protected $penelitianModel;
    protected $abdimasModel;
    protected $hakiModel;
    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->publikasiModel = new PublikasiModel();
        $this->penelitianModel = new PenelitianModel();
        $this->abdimasModel = new AbdimasModel();
        $this->hakiModel = new HakiModel();
    }
    public function index()
    {

        $data = [
            'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
            'page_title' => view('partials/page-title', ['title' => 'Dashboard', 'pagetitle' => 'Minible']),
            'title' => 'Daftar Dosen',
            'dosen' => $this->dosenModel->getDosen(),
            'count_haki' => $this->hakiModel->getHakiTotal(),
            'peningkatan_haki' => $this->hakiModel->getPeningkatanHaki(),
            'HakiYearNow_Cipta' => $this->hakiModel->getHakiYearNowCipta(),
            'HakiYearNow_Paten' => $this->hakiModel->getHakiYearNowPaten(),
            'hakiYearNow_Merek' => $this->hakiModel->getHakiYearNowMerek(),
            'hakiYearNow_Buku' => $this->hakiModel->getHakiYearNowBuku(),

            // get total of the year
            'Haki_Cipta' => $this->hakiModel->getHakiCipta(),
            'Haki_Paten' => $this->hakiModel->getHakiPaten(),
            'Haki_Merek' => $this->hakiModel->getHakiMerek(),
            'Haki_Buku' => $this->hakiModel->getHakiBuku(),

            'peningkatan_haki_cipta' => $this->hakiModel->getPeningkatanHakiCipta(),
            'peningkatan_haki_paten' => $this->hakiModel->getPeningkatanHakiPaten(),
            'peningkatan_haki_merek' => $this->hakiModel->getPeningkatanHakiMerek(),
            'peningkatan_haki_buku' => $this->hakiModel->getPeningkatanHakiBuku(),

            // Order Data Penelitian 
            'order_by_tahun' => $this->hakiModel->getOrderByTahun(),
            'order_by_tahun_Asc' => $this->hakiModel->getOrderByTahunAsc(),
            'jenis' => $this->hakiModel->getCountHaki(),

            // Get Order Data by Jenis
            'getOrderByTahunAllJenis' => $this->hakiModel->getOrderByTahunAllJenis(),

            // Order Haki 
            'top_haki_all' => $this->hakiModel->getTopHakiAll(),

            // Get All Data Abdimas
            'all_haki' => $this->hakiModel->getAllHaki(),

            // // Top Publikasi 
            'top_haki' => $this->hakiModel->getTopHaki(),

            'count_haki_all' => $this->hakiModel->getCountHakiAll(),


        ];
        // dd($dosen);
        return view('haki/index', $data);
    }

    // public function detail($kode_dosen)
    // {
    //     $data = [
    //         'title' => 'Detail Dosen',
    //         'dosen' => $this->dosenModel->getDosen($kode_dosen),
    //         'publikasi' => $this->publikasiModel->getPublikasi($kode_dosen),
    //         'jumlah_publikasi' => $this->publikasiModel->getJumlahPublikasi($kode_dosen),
    //         'jumlah_publikasi_1' => $this->publikasiModel->getJumlahPublikasi_1($kode_dosen),
    //         'penelitian' => $this->penelitianModel->getPenelitian($kode_dosen),
    //         'jumlah_penelitian' => $this->penelitianModel->getJumlahPenelitian($kode_dosen),
    //         'jumlah_ketua_peneliti' => $this->penelitianModel->getJumlahKetuaPeneliti($kode_dosen),
    //         'abdimas' => $this->abdimasModel->getAbdimas($kode_dosen),
    //         'jumlah_abdimas' => $this->abdimasModel->getJumlahAbdimas($kode_dosen),
    //         'jumlah_ketua' => $this->abdimasModel->getJumlahKetua($kode_dosen),
    //         'haki' => $this->hakiModel->getHaki($kode_dosen),
    //         'jumlah_haki' => $this->hakiModel->getJumlahHaki($kode_dosen),
    //         'jumlah_ketua_haki' => $this->hakiModel->getJumlahKetuaHaki($kode_dosen)

    //     ];
    //     // echo $data['jumlah_publikasi'];
    //     return view('dosen/detail', $data);
    // }
    // public function test($kode_dosen)
    // {
    //     $jumlah_publikasi = $this->publikasiModel->getJumlahPublikasi($kode_dosen);

    //     echo ($jumlah_publikasi);
    // }
}
