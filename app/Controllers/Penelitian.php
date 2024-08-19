<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;
use App\Models\Roadmap;

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
        $this->roadmap = new Roadmap();
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

            // Order Penelitian 
            'top_penelitian_all' => $this->penelitianModel->getTopPenelitianAll(),

            // Get Data Tahunan
            'data_tahunan' => $this->penelitianModel->getDataDosenTahunan(),

            // Get All Data Penelitian
            'all_penelitian' => $this->penelitianModel->getAllPenelitian(),


            // Get Order Data by Jenis
            'getOrderByTahunEksternal' => $this->penelitianModel->getOrderByTahunEksternal(),
            'getOrderByTahunInternal' => $this->penelitianModel->getOrderByTahunInternal(),
            'getOrderByTahunMandiri' => $this->penelitianModel->getOrderByTahunMandiri(),
            'getOrderByTahunKerjasamaPT' => $this->penelitianModel->getOrderByTahunKerjasamaPT(),
            'getOrderByTahunHilirisasi' => $this->penelitianModel->getOrderByTahunHilirisasi(),
            
            'annualPenelitianByTypeAndKK' => $this->penelitianModel->getAnnualPenelitianByTypeAndKK(),
            'annualPenelitianByType' => $this->penelitianModel->getAnnualPenelitianByType(),
        ];
        
        // dd($data['data_tahunan']);

        // dd($dosen);
        return view('penelitian/index', $data);
    }

    public function detail($id) {
        // Roadmap retrieved via separate call because this field previously
        // meant to be filled by user by typing, not by dropdown which its option
        // itself are gathered based on the authors (via table relation). 
        //
        // The authors themselves wasn't supposed to have roadmap too, so this 
        // workaround is meant to get the new things AND the old record working 
        //
        // TODO: Once everything is well-defined (no sudden changes), do what you think is the best
        $penelitian = $this->penelitianModel->getById($id);
        if(count($penelitian) == 0) {
            session()->setFlashData("error", "Penelitian tidak ditemukan");
            return redirect()->to(base_url());
        }

        $penelitian = $penelitian[0];
        $penelitianRoadmap = $this->roadmap->getById($penelitian["kesesuaian_roadmap"]);

        if(count($penelitianRoadmap) > 0) {
            $penelitian["kesesuaian_roadmap"] = $penelitianRoadmap[0]["topik"];
        }

        return view("penelitian/detail", ["penelitian" => $penelitian]);

    }

    public function list() { // TODO: manage read access?
        header("Content-Type: application/json");
        return json_encode(
            $this->penelitianModel->getAllPenelitian()
        );
    }
}
