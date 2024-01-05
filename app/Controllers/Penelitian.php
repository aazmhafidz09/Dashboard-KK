<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;

class Penelitian extends BaseController
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
        // $dosen = $this->dosenModel->findAll();
        $data = [
            'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
            'page_title' => view('partials/page-title', ['title' => 'Dashboard', 'pagetitle' => 'Minible']),
            'title' => 'Daftar Dosen',
            'dosen' => $this->dosenModel->getDosen(),
            'count_penelitian' => $this->penelitianModel->getPenelitianTotal(),
            'peningkatan_penelitian' => $this->penelitianModel->getPeningkatanPenelitian(),

            'Penelitian_YearNow_Inter' => $this->penelitianModel->getPenelitianYearNowInter(),
            'Penelitian_YearNow_Ekster' => $this->penelitianModel->getPenelitianYearNowEkste(),
            'Penelitian_YearNow_Mand' => $this->penelitianModel->getPenelitianYearNowMand(),
            'Penelitian_YearNow_Kerjasama_PT' => $this->penelitianModel->getPenelitianYearNowKerjaSamaPT(),
            'Penelitian_YearNow_Hilir' => $this->penelitianModel->getPenelitianYearNowHilir(),
            // get total of the year
            'Penelitian_Inter' => $this->penelitianModel->getPenelitianInter(),
            'Penelitian_Ekster' => $this->penelitianModel->getPenelitianEkste(),
            'Penelitian_Mand' => $this->penelitianModel->getPenelitianMand(),
            'Penelitian_Kerjasama_PT' => $this->penelitianModel->getPenelitianKerjaSamaPT(),
            'Penelitian_Hilir' => $this->penelitianModel->getPenelitianHilir(),

            // get Peningkatan on the year
            'peningkatan_Penelitian_Inter' => $this->penelitianModel->getPeningkatanPenelitianInter(),
            'peningkatan_Penelitian_Ekster' => $this->penelitianModel->getPeningkatanPenelitianEkste(),
            'peningkatan_Penelitian_Mand' => $this->penelitianModel->getPeningkatanPenelitianMand(),
            'peningkatan_Penelitian_Kerjasama_PT' => $this->penelitianModel->getPeningkatanPenelitianKerjaSamaPT(),
            'peningkatan_Penelitian_Hilir' => $this->penelitianModel->getPeningkatanPenelitianHilir(),

            // Order Data Penelitian 
            'order_by_tahun' => $this->penelitianModel->getOrderByTahun(),
            'order_by_tahun_Asc' => $this->penelitianModel->getOrderByTahunAsc(),
            'count_publikasi' => $this->penelitianModel->getCountPublikasi(),

            // Top Penelitian 
            'top_penelitian' => $this->penelitianModel->getTopPenelitian(),

            // Get Data Tahunan
            'data_tahunan' => $this->penelitianModel->getDataDosenTahunan(),

            // Get All Data Penelitian
            'all_penelitian' => $this->penelitianModel->getAllPenelitian(),


        ];

        // dd($dosen);
        return view('penelitian/index', $data);
    }



    // public function getDataDosenTahunan($tahun){
    // 'top_penelitian' => $this->penelitianModel->getDataDosenTahunan($tahun),






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
