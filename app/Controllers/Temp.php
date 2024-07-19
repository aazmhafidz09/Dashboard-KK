<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;
use App\Models\DatabaseModel;

class Temp extends BaseController
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

    public function Haki()
    {
        $data = [

            // Get All Data Abdimas
            'data' => $this->hakiModel->getAllHaki(),
            'fields'=>$this->hakiModel->get_table_fields(),
        ];
        // dd($dosen);
        return view('temp/haki', $data);
    }
    public function Abdimas()
    {
        $data = [

            // Get All Data Abdimas
            'data' => $this->abdimasModel->getAllAbdimas(),
            'fields'=>$this->abdimasModel->get_table_fields(),
        ];
        // dd($dosen);
        return view('temp/abdimas', $data);
    }
    public function Publikasi()
    {
        $data = [

            // Get All Data Abdimas
            'data' => $this->publikasiModel->getAllPublikasi(),
            'fields'=>$this->publikasiModel->get_table_fields(),
        ];
        // dd($dosen);
        return view('temp/publikasi', $data);
    }
    public function Penelitian()
    {
        $data = [

            // Get All Data Abdimas
            'data' => $this->penelitianModel->getAllPenelitian(),
            'fields'=>$this->penelitianModel->get_table_fields(),
        ];
        // dd($dosen);
        return view('temp/penelitian', $data);
    }

}
