<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;
use App\Models\Roadmap;

class Dosen extends BaseController
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
            'title' => 'Daftar Dosen',
            'dosen' => $this->dosenModel->getDosen()
        ];

        // dd($dosen);
        return view('dosen/index', $data);
    }

    public function detail($kode_dosen)
    {
        if(is_null($this->dosenModel->getDosen($kode_dosen))) {
            session()->setFlashData("error", "Dosen dengan kode $kode_dosen tidak ditemukan");
            return redirect()->back();
        }

        $data = [
            'title' => 'Detail Dosen',
            'dosen' => $this->dosenModel->getDosen($kode_dosen),
            'publikasi' => $this->publikasiModel->getPublikasi($kode_dosen),
            'jumlah_publikasi' => $this->publikasiModel->getJumlahPublikasi($kode_dosen),
            'jumlah_publikasi_1' => $this->publikasiModel->getJumlahPublikasi_1($kode_dosen),
            'penelitian' => $this->penelitianModel->getPenelitian($kode_dosen),
            'jumlah_penelitian' => $this->penelitianModel->getJumlahPenelitian($kode_dosen),
            'jumlah_ketua_peneliti' => $this->penelitianModel->getJumlahKetuaPeneliti($kode_dosen),
            'abdimas' => $this->abdimasModel->getAbdimas($kode_dosen),
            'jumlah_abdimas' => $this->abdimasModel->getJumlahAbdimas($kode_dosen),
            'jumlah_ketua' => $this->abdimasModel->getJumlahKetua($kode_dosen),
            'haki' => $this->hakiModel->getHaki($kode_dosen),
            'jumlah_haki' => $this->hakiModel->getJumlahHaki($kode_dosen),
            'jumlah_ketua_haki' => $this->hakiModel->getJumlahKetuaHaki($kode_dosen)

        ];
        // echo $data['jumlah_publikasi'];
        return view('dosen/detail', $data);
    }

    public function profile() {
        if(!logged_in()) return redirect()->to(base_url("login"));

        if(!isset(user()->kode_dosen)) {
            session()->setFlashData("error", "Halaman ini ditujukan khusus ke akun dosen");
            return redirect()->to(base_url());
        }

        $kodeDosen = user()->kode_dosen;
        return view("dosen/profile", [
            'dosen' => $this->dosenModel->getDosen($kodeDosen),
            'roadmap' => $this->roadmap->getByKodeDosen($kodeDosen)
        ]);
    }

    public function editRoadmap($id) {
        if(!isset(user()->kode_dosen)) {
            session()->setFlashData("error", "Aksi ini hanya bisa diakses oleh dosen");
            return redirect()->to(base_url());
        }

        $kodeDosen = user()->kode_dosen;
        $oldRoadmap = $this->roadmap->getById($id);
        if(count($oldRoadmap) == 0) {
            session()->setFlashData("error", "Roadmap tidak ditemukan");
            return redirect()->back();
        }
        if($oldRoadmap[0]["kode_dosen"] != $kodeDosen) {
            session()->setFlashData("error", "Anda tidak bisa mengubah roadmap dosen lain");
            return redirect()->back();
        }

        $newRoadmap = $this->request->getVar();
        $this->roadmap->update($id, $newRoadmap);
        session()->setFlashData("pesan", "Roadmap berhasil diperbarui");
            return redirect()->back();
    }

    public function deleteRoadmap($id) {
        if(!isset(user()->kode_dosen)) {
            session()->setFlashData("error", "Aksi ini hanya bisa diakses oleh dosen");
            return redirect()->to(base_url());
        }

        $kodeDosen = user()->kode_dosen;
        $oldRoadmap = $this->roadmap->getById($id);
        if(count($oldRoadmap) == 0) {
            session()->setFlashData("error", "Roadmap tidak ditemukan");
            return redirect()->back();
        }

        // Should've exploit the relationship instead, but for now it can't due to the
        // old data has roadmap which its owner (`Dosen`) hasn't known yet, thus the actual
        // data still stored in `kesesuaian_roadmap` column of `Penelitian`. Furthermore,
        // the old data seems to have type of VARCHAR which had become a problem too when
        // making a relation in DBMS.
        $relatedPenelitian = $this->penelitianModel->getByRoadmapId($id);
        if(count($relatedPenelitian) > 0) {
            session()->setFlashData("error", "Terdapat penelitian dengan roadmap yang sama dengan yang ingin dihapus. Harap hapus atau ubah data tersebut dahulu sebelum menghapus roadmap anda.");
            return redirect()->back();
        }

        if($oldRoadmap[0]["kode_dosen"] != $kodeDosen) {
            session()->setFlashData("error", "Anda tidak bisa menghapus roadmap dosen lain");
            return redirect()->back();
        }

        $this->roadmap->delete($id,);
        session()->setFlashData("pesan", "Roadmap berhasil dihapus");
        return redirect()->back();
    }

    public function addRoadmap() {
        if(!isset(user()->kode_dosen)) {
            session()->setFlashData("error", "Aksi ini hanya bisa diakses oleh dosen");
            return redirect()->to(base_url());
        }

        $kodeDosen = user()->kode_dosen;
        $newRoadmap = $this->request->getVar();
        $newRoadmap["kode_dosen"] = $kodeDosen;
        $this->roadmap->save($newRoadmap);
        session()->setFlashData("pesan", "Roadmap berhasil ditambah");
        return redirect()->back();
    }

    // public function test($kode_dosen)
    // {
    //     $jumlah_publikasi = $this->publikasiModel->getJumlahPublikasi($kode_dosen);

    //     echo ($jumlah_publikasi);
    // }
}