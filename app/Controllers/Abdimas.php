<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;

class Abdimas extends BaseController
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
            'count_abdimas' => $this->abdimasModel->getAbdimasTotal(),
            // get total of the year
            'Abdimas_Inter' => $this->abdimasModel->getAbdimasInter(),
            'Abdimas_Ekster' => $this->abdimasModel->getAbdimasEkste(),
            'Abdimas_Inter_Ekster' => $this->abdimasModel->getAbdimasInterEkster(),

            'Abdimas_YearNow_Inter' => $this->abdimasModel->getAbdimasYearNowInter(),
            'Abdimas_YearNow_Ekster' => $this->abdimasModel->getAbdimasYearNowEkste(),
            'Abdimas_YearNow_Inter_Ekster' => $this->abdimasModel->getAbdimasYearNowInterEkster(),
            // get Peningkatan on the year
            'getPeningkatanAbdimasInter' => $this->abdimasModel->getPeningkatanAbdimasInter(),
            'getPeningkatanAbdimasEkste' => $this->abdimasModel->getPeningkatanAbdimasEkste(),
            'getPeningkatanAbdimasInterEkster' => $this->abdimasModel->getPeningkatanAbdimasInterEkster(),

            // Order Data Penelitian 
            'order_by_tahun' => $this->abdimasModel->getOrderByTahun(),

            // Get Data Tahunan
            'data_tahunan' => $this->abdimasModel->getDataDosenTahunan(),

            // Get All Data Abdimas
            'all_abdimas' => $this->abdimasModel->getAllAbdimas(),

            // Order Data Penelitian 
            'order_by_tahun_desc' => $this->abdimasModel->getOrderByTahunDesc(),

            // Order Data Penelitian 
            'order_jenis' => $this->abdimasModel->getOrderByTahunAllJenis(),

            // Order Penelitian 
            'top_abdimas_all' => $this->abdimasModel->getTopAbdimasAll(),

        ];
        // dd($dosen);
        return view('abdimas/index', $data);
    }
}
