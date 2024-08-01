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
            'hakiYearNow_desain_industri' => $this->hakiModel->getHakiYearNowDesainIndustri(),

            // get total of the year
            'Haki_Cipta' => $this->hakiModel->getHakiCipta(),
            'Haki_Paten' => $this->hakiModel->getHakiPaten(),
            'Haki_Merek' => $this->hakiModel->getHakiMerek(),
            'Haki_Desain_Industri' => $this->hakiModel->getHakiDesainIndustri(),

            'peningkatan_haki_cipta' => $this->hakiModel->getPeningkatanHakiCipta(),
            'peningkatan_haki_paten' => $this->hakiModel->getPeningkatanHakiPaten(),
            'peningkatan_haki_merek' => $this->hakiModel->getPeningkatanHakiMerek(),
            'peningkatan_haki_desain_industri' => $this->hakiModel->getPeningkatanHakiDesainIndustri(),

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

            'data_tahunan' => $this->hakiModel->getDataDosenTahunan(),
            'annualHakiByTypeAndKK' => $this->hakiModel->getAnnualHakiByTypeAndKK(),
        ];
        // dd($dosen);
        return view('haki/index', $data);
    }

    public function detail($id) {
        $haki = $this->hakiModel->getById($id);
        if(count($haki) == 0) {
            session()->setFlashData("error", "Haki tidak ditemukan");
            return redirect()->to(base_url());
        }
        return view("haki/detail", ["haki" => $haki[0]]);
    }
}
