<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;

class Admin extends BaseController
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
            'title' => 'Daftar Dosen',
            'dosen' => $this->dosenModel->getDosen()
        ];

        // dd($dosen);
        return view('admin/index', $data);
    }
    public function publikasi()
    {
        // $dosen = $this->dosenModel->findAll();


        // dd($dosen);
        return view('admin/manage-publikasi');
    }
    public function penelitian()
    {
        // $dosen = $this->dosenModel->findAll();


        // dd($dosen);
        return view('admin/manage-penelitian');
    }
    public function abdimas()
    {
        // $dosen = $this->dosenModel->findAll();


        // dd($dosen);
        return view('admin/manage-abdimas');
    }
    public function haki()
    {
        // $dosen = $this->dosenModel->findAll();


        // dd($dosen);
        return view('admin/manage-haki');
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
    //     return view('admin/detail', $data);
    // }
    // public function test($kode_dosen)
    // {
    //     $jumlah_publikasi = $this->publikasiModel->getJumlahPublikasi($kode_dosen);

    //     echo ($jumlah_publikasi);
    // }
}
