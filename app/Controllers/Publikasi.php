<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;

class Publikasi extends BaseController
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
            'publikasi' => $this->publikasiModel->getPublikasi_all(),
            'count_publikasi' => $this->publikasiModel->getPublikasiTotal(),
            'count_abdimas' => $this->abdimasModel->getAbdimasTotal(),
            'count_penelitian' => $this->penelitianModel->getPenelitianTotal(),
            'count_haki' => $this->hakiModel->getHakiTotal(),
            'peningkatan_penelitian' => $this->penelitianModel->getPeningkatanPenelitian(),
            'peningkatan_publikasi' => $this->publikasiModel->getPeningkatanPublikasi(),
            'peningkatan_haki' => $this->hakiModel->getPeningkatanHaki(),
            'peningkatan_abdimas' => $this->hakiModel->getPeningkatanHaki(),
            'PublikasiYearNow_Inter' => $this->publikasiModel->getPublikasiYearNowInter(),
            'PublikasiYearNow_Nas' => $this->publikasiModel->getPublikasiYearNowNas(),
            'PublikasiYearNow_Pros' => $this->publikasiModel->getPublikasiYearNowPros(),
            'PublikasiYearNow_Pros_Nas' => $this->publikasiModel->getPublikasiYearNowProsNas(),
        ];
        // dd($dosen);
        return view('publikasi/index', $data);
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
