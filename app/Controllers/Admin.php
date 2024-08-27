<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;
use App\Models\LogPublikasi;
use App\Models\LogPenelitian;
use App\Models\LogAbdimas;
use App\Models\LogHaki;
use App\Models\Roadmap;

class Admin extends BaseController {
    protected $dosenModel;
    protected $publikasiModel;
    protected $penelitianModel;
    protected $abdimasModel;
    protected $hakiModel;

    public function __construct() {
        $this->dosenModel = new DosenModel();
        $this->publikasiModel = new PublikasiModel();
        $this->penelitianModel = new PenelitianModel();
        $this->abdimasModel = new AbdimasModel();
        $this->hakiModel = new HakiModel();

        // Should these be moved to respective models instead?
        $this->logPublikasi = new LogPublikasi();
        $this->logPenelitian = new LogPenelitian();
        $this->logAbdimas = new LogAbdimas();
        $this->logHaki = new LogHaki();
        $this->roadmap = new ROadmap();
    }

    private function isAdmin() { // Roles considered as Admin: admin, kk_seal, kk_citi, kk_dsis
        return in_groups(["admin", "kk_dsis", "kk_citi", "kk_seal"], user_id());
    }

    public function index() {
        return view('admin/index');
    }

    public function listManage($resourceName) {
        $data = null;
        if(in_groups("admin", user_id())) { // All
            switch($resourceName) {
                case "publikasi": $data = $this->publikasiModel->getAllPublikasi(); break;
                case "penelitian": $data = $this->penelitianModel->getAllPenelitian(); break;
                case "abdimas": $data = $this->abdimasModel->getAllAbdimas(); break;
                case "haki": $data = $this->hakiModel->getAllHaki(); break;
            }
        } else if (in_groups(["kk_dsis", "kk_seal", "kk_citi"], user_id())) { // KK specific
            $kk = (in_groups("kk_dsis", user_id())
                    ?  "DSIS"
                    : ( (in_groups("kk_seal", user_id()))
                        ? "SEAL" : "CITI"));
            switch($resourceName) {
                case "publikasi": $data = $this->publikasiModel->getAllByKK($kk); break;
                case "penelitian": $data = $this->penelitianModel->getAllByKK($kk); break;
                case "abdimas": $data = $this->abdimasModel->getAllByKK($kk); break;
                case "haki": $data = $this->hakiModel->getAllByKK($kk); break;
            }
        } else { // Dosen specific
            $kodeDosen = user()->kode_dosen;
            if($kodeDosen != null) {
                switch($resourceName) {
                    case "publikasi": $data = $this->publikasiModel->getPublikasi($kodeDosen); break;
                    case "penelitian": $data = $this->penelitianModel->getPenelitian($kodeDosen); break;
                    case "abdimas": $data = $this->abdimasModel->getAbdimas($kodeDosen); break;
                    case "haki": $data = $this->hakiModel->getHaki($kodeDosen); break;
                }
            }
        }

        header("Content-Type: application/json");
        return json_encode($data);
    }

    // ##### PUBLIKASI #############################################################################
    public function publikasi() {
        $data = [ 'listDosen' => $this->dosenModel->getAllKodeDosen(), ];
        return view('admin/input/publikasi', $data);
    }

    public function publikasi_edit($id) {
        $publikasi = $this->publikasiModel->where('id', $id)->first();
        if(is_null($publikasi)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->publikasiModel->isPermitted($publikasi)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        helper('form');
        $data = [ 'oldPublikasi' => $publikasi,
                    'listDosen' => $this->dosenModel->getAllKodeDosen(), ];
        session()->setFlashdata('pesan', 'Publikasi berhasil diperbarui');
        return view("admin/update/publikasi", $data);
    }

    public function publikasi_save() {
        if (!$this->validate([
            'judul_publikasi' => 'required',
            'tahun' => 'required'
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/publikasi'))->withInput()->with('error', $firstError);
        }

        // Check for "duplicate" record
        $newPublikasi = $this->request->getVar();
        $sql = " SELECT id FROM publikasi WHERE judul_publikasi = ?";
        $result = $this->publikasiModel->db->query($sql, [$newPublikasi["judul_publikasi"]])->getResultArray();
        if(count($result) > 0) {
            session()->setFlashdata('warning', 'Publikasi serupa ditemukan');
            return redirect()->to(base_url('/admin/publikasi/update/' . $result[0]["id"]));
        }

        unset($newPublikasi["csrf_test_name"]);
        try {
            $this->logPublikasi->transBegin();
            $this->publikasiModel->save($newPublikasi);
            $newPublikasi["id"] = array_merge( ["id" => "" . $this->publikasiModel->db->insertID()], $newPublikasi);
            $this->logPublikasi->save([ 
                "user_id" => user_id(),
                "publikasi_id" => $this->publikasiModel->db->insertID(),
                "action" => "C",
                "value_after" => json_encode($newPublikasi) ]);
            if($this->logPublikasi->transStatus() === false) {
                $this->logPublikasi->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            } else {
                $this->logPublikasi->transCommit();
                session()->setFlashdata('pesan', 'Publikasi berhasil ditambahkan');
            }
        } catch (\Exception $e) { 
            $this->logPublikasi->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function handle_publikasi_edit($id) {
        $oldPublikasi = $this->publikasiModel->where('id', $id)->first();
        if(is_null($oldPublikasi)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->publikasiModel->isPermitted($oldPublikasi)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        if (!$this->validate([
            'judul_publikasi' => 'required',
            'tahun' => 'required'
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/publikasi'))->withInput()->with('error', $firstError);
        }

        $newPublikasi = $this->request->getVar();
        $sql = " SELECT id FROM publikasi WHERE judul_publikasi = ?";
        $result = $this->publikasiModel->db->query($sql, [$newPublikasi["judul_publikasi"]])->getResultArray();
        if(count($result) > 0) {
            $duplicate = $result[0]["id"];
            if($duplicate != $id) {
                session()->setFlashdata('warning', 'Publikasi serupa ditemukan');
                return redirect()->to(base_url("/admin/publikasi/update/$duplicate"));
            }
        }

        // Restrict several fields for role "dosen" by overwriting it with old value
        if(!in_groups(["admin", "kk_citi", "kk_seal", "kk_dsis"])) {
            $restrictedFields = ["jenis", "akreditasi_journal_conf", "nama_journal_conf"];
            foreach($restrictedFields as $field) {
                $newPublikasi[$field] = $oldPublikasi[$field];
            }
        }

        unset($newPublikasi["csrf_test_name"]);
        try {
            $this->logPublikasi->transBegin();
            $newPublikasi = array_merge(["id" => "$id"], $newPublikasi);
            $this->publikasiModel->update($id, $newPublikasi);
            $this->logPublikasi->save([ 
                "user_id" => user_id(),
                "publikasi_id" => $id,
                "action" => "U",
                "value_before" => json_encode($oldPublikasi),
                "value_after" => json_encode($newPublikasi) ]);
            if($this->logPublikasi->transStatus() === false) {
                $this->logPublikasi->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            } else {
                $this->logPenelitian->transCommit();
                session()->setFlashdata('pesan', 'Publikasi berhasil diperbarui');
            }
        } catch (\Exception $e) { 
            $this->logPublikasi->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function publikasi_delete($id){
        $publikasi = $this->publikasiModel->where('id', $id)->first();
        if(is_null($publikasi)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->publikasiModel->isPermitted($publikasi)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        try {
            $this->logPublikasi->transBegin();
            $this->logPublikasi->save([ 
                "user_id" => user_id(),
                "publikasi_id" => $id,
                "action" => "D",
                "value_before" => json_encode($publikasi) ]);
            $this->publikasiModel->delete($id);
            if($this->logPublikasi->transStatus() === false) {
                $this->logPublikasi->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menghapus data');
            } else {
                $this->logPublikasi->transCommit();
                session()->setFlashdata('pesan', 'Publikasi berhasil dihapus');
            }
        } catch (\Exception $e) { 
            $this->logPublikasi->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memghapus data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    // ###### PENELITIAN ###########################################################################
    public function penelitian() {
        $data = [ 
            'listDosen' => $this->dosenModel->getAllKodeDosen(), 
            'roadmap' => $this->roadmap->getByKodeDosen(user()->kode_dosen)
        ];
        return view( 'admin/input/penelitian', $data);
    }

    public function penelitian_edit($id) {
        $penelitian = $this->penelitianModel->where('id', $id)->first();
        if(is_null($penelitian)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->penelitianModel->isPermitted($penelitian)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        helper('form');

        $roadmap = $this->roadmap->getByKodeDosen($penelitian["ketua_peneliti"]);
        // // Combine current user's roadmap with `ketua_peneliti`'s
        // if($penelitian["ketua_peneliti"] != user()->kode_dosen) { 
        //     $roadmap = array_merge(
        //         $this->roadmap->getByKodeDosen(),
        //         $roadmap);
        // }

        // Attempt to find old roadmap if it's owned neither by `ketua_penelitian` 
        // nor somebody that's currently editing (e.g. admin). This handles old
        // records too so that its original value won't be written into something else
        // (Refer to comment on: '/App/Models/Penelitian::detail')
        $oldRoadmap = $penelitian["kesesuaian_roadmap"];
        if(!in_array(
                $oldRoadmap,
                array_map(function($r) {return $r["id"];}, $roadmap))
        ) { 
            $roadmapPenelitian = $this->roadmap->getById($oldRoadmap);
            if(count($roadmapPenelitian) > 0) {
                $roadmap = array_merge($roadmapPenelitian, $roadmap);
            } else if(strlen($oldRoadmap) > 0){
                $roadmap = array_merge(
                            [["id" => $oldRoadmap, "topik" => $oldRoadmap]],
                            $roadmap);
            }
        }

        $data = [ 'oldPenelitian' => $penelitian,
                    'listDosen' => $this->dosenModel->getAllKodeDosen(),
                    'roadmap' => $roadmap];
        session()->setFlashdata('pesan', 'Penelitian berhasil diperbarui');
        return view("admin/update/penelitian", $data);
    }

    public function penelitian_save() {
        if (!$this->validate([
            'jenis' => 'required',
            'judul_penelitian' => 'required',
            'tahun' => 'required',
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/penelitian'))->withInput()->with('error', $firstError);
        }

        // Check for "similar" record
        $newPenelitian = $this->request->getVar();
        $sql = " SELECT id FROM penelitian WHERE judul_penelitian = ?";
        $result = $this->penelitianModel->db->query($sql, [$newPenelitian["judul_penelitian"]])->getResultArray();
        if(count($result) > 0) {
            session()->setFlashdata('warning', 'Penelitian serupa ditemukan');
            return redirect()->to(base_url('/admin/penelitian/update/' . $result[0]["id"]));
        }

        unset($newPenelitian["csrf_test_name"]);
        try {
            $this->logPenelitian->transBegin();
            $this->penelitianModel->save($newPenelitian);
            $newPenelitian = array_merge( ["id" => "" . $this->penelitianModel->db->insertID()], $newPenelitian);
            $this->logPenelitian->save([ 
                "user_id" => user_id(),
                "penelitian_id" => $this->penelitianModel->db->insertID(),
                "action" => "C",
                "value_after" => json_encode($newPenelitian) ]);
            if($this->logPenelitian->transStatus() === false) {
                $this->logPenelitian->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            } else {
                $this->logPenelitian->transCommit();
                session()->setFlashdata('pesan', 'Penelitian berhasil ditambahkan');
            }
        } catch (\Exception $e) { 
            $this->logPenelitian->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function handle_penelitian_edit($id) {
        $penelitian = $this->penelitianModel->where('id', $id)->first();
        if(is_null($penelitian)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->penelitianModel->isPermitted($penelitian)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        if (!$this->validate([
            'jenis' => 'required',
            'judul_penelitian' => 'required',
            'tahun' => 'required',
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/penelitian'))->withInput()->with('error', $firstError);
        }

        $newPenelitian = $this->request->getVar();
        $sql = " SELECT id FROM penelitian WHERE judul_penelitian = ?";
        $result = $this->penelitianModel->db->query($sql, [$newPenelitian["judul_penelitian"]])->getResultArray();
        if(count($result) > 0) {
            $duplicate = $result[0]["id"];
            if($duplicate != $id) {
                session()->setFlashdata('warning', 'Penelitian serupa ditemukan');
                return redirect()->to(base_url("/admin/penelitian/update/$duplicate"));
            }
        }

        unset($newPenelitian["csrf_test_name"]);
        try {
            $this->logPenelitian->transBegin();
            $this->penelitianModel->update($id, $newPenelitian);
            $newPenelitian = array_merge(["id" => "$id"], $newPenelitian);
            $this->logPenelitian->save([ 
                "user_id" => user_id(),
                "penelitian_id" => $id,
                "action" => "U",
                "value_before" => json_encode($penelitian),
                "value_after" => json_encode($newPenelitian) ]);
            if($this->logPenelitian->transStatus() === false) {
                $this->logPenelitian->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            } else {
                $this->logPenelitian->transCommit();
                session()->setFlashdata('pesan', 'Penelitian berhasil diperbarui');
            }
        } catch (\Exception $e) { 
            $this->logPenelitian->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function penelitian_delete($id) {
        $penelitian = $this->penelitianModel->where('id', $id)->first();
        if(is_null($penelitian)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->penelitianModel->isPermitted($penelitian)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        try {
            $this->logPenelitian->transBegin();
            $this->logPenelitian->save([ 
                "user_id" => user_id(),
                "penelitian_id" => $id,
                "action" => "D",
                "value_before" => json_encode($penelitian) ]);
            $this->penelitianModel->delete($id);
            if($this->logPenelitian->transStatus() === false) {
                $this->logPenelitian->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menghapus data');
            } else {
                $this->logPenelitian->transCommit();
                session()->setFlashdata('pesan', 'Penelitian berhasil dihapus');
            }
        } catch (\Exception $e) { 
            $this->logPenelitian->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menghapus data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    // ###### ABDIMAS ##############################################################################
    public function abdimas() {
        $data = [ "listDosen" => $this->dosenModel->getAllKodeDosen()];
        return view('admin/input/abdimas', $data);
    }

    public function abdimas_edit($id) {
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if(is_null($abdimas)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->abdimasModel->isPermitted($abdimas)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        helper('form');
        $data = [ 'listDosen' => $this->dosenModel->getAllKodeDosen(),
                    'oldAbdimas' => $abdimas, ];
        session()->setFlashdata('pesan', 'abdimas berhasil diperbarui');
        return view("admin/update/abdimas", $data);
    }

    public function abdimas_save() {
        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/abdimas'))->withInput()->with('error', $firstError);
        }

        // Check for "duplicate" record
        $newAbdimas = $this->request->getVar();
        $sql = " SELECT id FROM abdimas WHERE judul = ?";
        $result = $this->abdimasModel->db->query($sql, [$newAbdimas["judul"]])->getResultArray();
        if(count($result) > 0) {
            session()->setFlashdata('warning', 'Abdimas serupa ditemukan');
            return redirect()->to(base_url('/admin/abdimas/update/' . $result[0]["id"]));
        }

        unset($newAbdimas["csrf_test_name"]);
        try {
            $this->logAbdimas->transBegin();
            $this->abdimasModel->save($newAbdimas);
            $newAbdimas = array_merge( ["id" => "" . $this->abdimasModel->db->insertID()], $newAbdimas);
            $this->logAbdimas->save([ 
                "user_id" => user_id(),
                "abdimas_id" => $this->abdimasModel->db->insertID(),
                "action" => "C",
                "value_after" => json_encode($newAbdimas) ]);
            if($this->logAbdimas->transStatus() === false) {
                $this->logAbdimas->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            } else {
                $this->logAbdimas->transCommit();
                session()->setFlashdata('pesan', 'Abdimas berhasil ditambahkan');
            }
        } catch (\Exception $e) { 
            $this->logAbdimas->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function abdimas_delete($id) {
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if(is_null($abdimas)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->abdimasModel->isPermitted($abdimas)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        try {
            $this->logAbdimas->transBegin();
            $this->logAbdimas->save([ 
                "user_id" => user_id(),
                "abdimas_id" => $id,
                "action" => "D",
                "value_before" => json_encode($abdimas) ]);
            $this->abdimasModel->delete($id);
            if($this->logAbdimas->transStatus() === false) {
                $this->logAbdimas->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menghapus data');
            } else {
                $this->logAbdimas->transCommit();
                session()->setFlashdata('pesan', 'Abdimas berhasil dihapus');
            }
        } catch (\Exception $e) { 
            $this->logAbdimas->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menghapus data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function handle_abdimas_edit($id) {
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if(is_null($abdimas)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->abdimasModel->isPermitted($abdimas)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/abdimas'))->withInput()->with('error', $firstError);
        }

        $newAbdimas = $this->request->getVar();
        $sql = " SELECT id FROM abdimas WHERE judul = ?";
        $result = $this->hakiModel->db->query($sql, [$newAbdimas["judul"]])->getResultArray();
        if(count($result) > 0) {
            $duplicate = $result[0]["id"];
            if($duplicate != $id) {
                session()->setFlashdata('warning', 'Abdimas serupa ditemukan');
                return redirect()->to(base_url("/admin/abdimas/update/$duplicate"));
            }
        }

        unset($newAbdimas["csrf_test_name"]);
        try {
            $this->logAbdimas->transBegin();
            $this->abdimasModel->update($id, $newAbdimas);

            $newAbdimas = array_merge(["id" => "$id"], $newAbdimas);
            $this->logAbdimas->save([
                "user_id" => user_id(),
                "abdimas_id" => $id,
                "action" => "U",
                "value_before" => json_encode($abdimas),
                "value_after" => json_encode($newAbdimas)
            ]);

            if ($this->logAbdimas->transStatus() === false) {
                $this->logAbdimas->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            } else {
                $this->logAbdimas->transCommit();
                session()->setFlashdata('pesan', 'Abdimas berhasil diperbarui');
            }
        } catch (\Exception $e) { 
            $this->logAbdimas->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to(base_url('/admin'));
    }

    // ###### HAKI #################################################################################
    public function haki() {
        $data = [ 'listDosen' => $this->dosenModel->getAllKodeDosen()];
        return view('admin/input/haki', $data);
    }
    
    public function haki_edit($id) {
        $haki = $this->hakiModel->where('id', $id)->first();
        if(is_null($haki)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Haki tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->hakiModel->isPermitted($haki)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        helper('form');
        $data = [ 'oldHaki' => $haki,
                    'listDosen' => $this->dosenModel->getAllKodeDosen()];
        session()->setFlashdata('pesan', 'haki berhasil diperbarui');
        return view("admin/update/haki", $data);
    }

    public function haki_save() {
        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/haki'))->withInput()->with('error', $firstError);
        }

        // Check "duplicate" record
        $newHaki = $this->request->getVar();
        $sql = " SELECT id FROM haki WHERE judul = ?";
        $result = $this->hakiModel->db->query($sql, [$newHaki["judul"]])->getResultArray();
        if(count($result) > 0) {
            session()->setFlashdata('warning', 'Haki serupa ditemukan');
            return redirect()->to(base_url('/admin/haki/update/' . $result[0]["id"]));
        }

        unset($newHaki["csrf_test_name"]);
        try {
            $this->logHaki->transBegin();
            $this->hakiModel->save($newHaki);
            $newHaki = array_merge( ["id" => "" . $this->hakiModel->db->insertID()], $newHaki);
            $this->logHaki->save([ 
                "user_id" => user_id(),
                "haki_id" => $this->hakiModel->db->insertID(),
                "action" => "C",
                "value_after" => json_encode($newHaki) ]);
            if($this->logHaki->transStatus() === false) {
                $this->logHaki->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            } else {
                $this->logHaki->transCommit();
                session()->setFlashdata('pesan', 'Haki berhasil ditambahkan');
            }
        } catch (\Exception $e) { 
            $this->logHaki->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to(base_url('/admin'));
    }

    public function haki_delete($id) {
        $haki = $this->hakiModel->where('id', $id)->first();
        if(is_null($haki)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Haki tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->hakiModel->isPermitted($haki)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        try {
            $this->logHaki->transBegin();
            $this->logHaki->save([ 
                "user_id" => user_id(),
                "haki_id" => $id,
                "action" => "D",
                "value_before" => json_encode($haki) ]);
            $this->hakiModel->delete($id);
            if($this->logHaki->transStatus() === false) {
                $this->logHaki->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menghapus data');
            } else {
                $this->logHaki->transCommit();
                session()->setFlashdata('pesan', 'Haki berhasil dihapus');
            }
        } catch (\Exception $e) { 
            $this->logHaki->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menghapus data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function handle_haki_edit($id) {
        $haki = $this->hakiModel->where('id', $id)->first();
        if(is_null($haki)) { 
            session()->setFlashdata('error', 'Haki tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->hakiModel->isPermitted($haki)) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/haki'))->withInput()->with('error', $firstError);
        }

        $newHaki = $this->request->getVar();
        $sql = " SELECT id FROM haki WHERE judul = ?";
        $result = $this->hakiModel->db->query($sql, [$newHaki["judul"]])->getResultArray();
        if(count($result) > 0) {
            $duplicate = $result[0]["id"];
            if($duplicate != $id) {
                session()->setFlashdata('warning', 'Haki serupa ditemukan');
                return redirect()->to(base_url("/admin/haki/update/$duplicate"));
            }
        }

        unset($newHaki["csrf_test_name"]);
        try {
            $this->logHaki->transBegin();
            $this->hakiModel->update($id, $newHaki);
            $newHaki = array_merge(["id" => "$id"], $newHaki);
            $this->logHaki->save([ 
                "user_id" => user_id(),
                "haki_id" => $id,
                "action" => "U",
                "value_before" => json_encode($haki),
                "value_after" => json_encode($newHaki) ]);
            if($this->logHaki->transStatus() === false) {
                $this->logHaki->transRollback();
                session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            } else {
                $this->logHaki->transCommit();
                session()->setFlashdata('pesan', 'Haki berhasil diperbarui');
            }
        } catch (\Exception $e) { 
            $this->logHaki->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika memperbarui data');
            // session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to(base_url('/admin'));
    }

    public function import(){
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };
        return view("admin/import");
    }

    public function handle_import() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan hal tersebut");
            return redirect()->to(base_url());
        };

        $files = [
           "publikasi" => !isset($_FILES['filePublikasi'])? null: $_FILES['filePublikasi'],
           "abdimas" => !isset($_FILES['fileAbdimas'])? null: $_FILES['fileAbdimas'],
           "penelitian" => !isset($_FILES['filePenelitian'])? null: $_FILES['filePenelitian'],
           "haki" => !isset($_FILES['fileHaki'])? null: $_FILES['fileHaki'],
        ];

        $importResults = [];
        $errorResultMessages = [];
        foreach($files as $nFile => $file) {
            array_push($errorResultMessages, null);

            $filePath = is_null($file)? "": $file["tmp_name"];
            if(strlen($filePath) > 0) {
                $result = null;
                switch($nFile) {
                    case "publikasi": $result = $this->publikasiModel->import($filePath); break;
                    case "abdimas": $result = $this->abdimasModel->import($filePath); break;
                    case "penelitian": $result = $this->penelitianModel->import($filePath); break;
                    case "haki": $result = $this->hakiModel->import($filePath); break;
                }
                if(!is_null($result[1])) {
                    $errorResultMessages[count($errorResultMessages) - 1] = $result[1];
                }
                array_push($importResults, $result[0]);
            } else array_push($importResults, -1);
        }

        $successMessage = "";
        for($idx = 0; $idx < count($importResults); $idx++) {
            if($importResults[$idx] == 0) {
                $successMessage .= ( ($successMessage == "")
                                    ? ucwords(array_keys($files)[$idx])
                                    : "," . ucwords(array_keys($files)[$idx]));
            }
        }

        $errorMessage = "";
        for($idx = 0; $idx < count($files); $idx++) {
            if(!is_null($errorResultMessages[$idx])) {
                $errorMessage .= ("<strong>" . ucwords(array_keys($files)[$idx]) . "</strong>"
                                . ": " . $errorResultMessages[$idx] 
                                . "<br/>");
            }
        }

        if(strlen($successMessage) == 0 && strlen($errorMessage) == 0) {
            session()->setFlashData("error", "Tidak ada file yang diimpor");
            return redirect()->to(base_url("/admin/import"));
        }

        if($errorMessage != "") {
            session()->setFlashData("error", "Import gagal untuk:\n" . "<br/>" . $errorMessage);
        }

        if($successMessage != "") {
            session()->setFlashData("pesan", "Impor berhasil untuk: $successMessage");
        }
        return redirect()->to(base_url("/admin/import"));
    }

    public function download_template($filename) {
        $BASE_DIR = "assets/xlsxTemplates";
        switch($filename) {
            case "publikasi": return $this->response->download(("$BASE_DIR/tPublikasiEXAMPLE.xlsx"), null);
            case "penelitian": return $this->response->download(("$BASE_DIR/tPenelitianEXAMPLE.xlsx"), null);
            case "abdimas": return $this->response->download(("$BASE_DIR/tAbdimasEXAMPLE.xlsx"), null);
            case "haki": return $this->response->download(("$BASE_DIR/tHakiEXAMPLE.xlsx"), null);
            default:
                session()->setFlashData("error", "Template <b>$filename</b> tidak ditemukan");
                return redirect()->to(base_url("/admin/import"));
        }
    }

    public function log() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

        $MAX_N_LOG = 30;
        return view('admin/log/index', [
            "logAbdimas" => $this->logAbdimas->getRecentLogs($MAX_N_LOG),
            "logHaki" => $this->logHaki->getRecentLogs($MAX_N_LOG),
            "logPenelitian" => $this->logPenelitian->getRecentLogs($MAX_N_LOG),
            "logPublikasi" => $this->logPublikasi->getRecentLogs($MAX_N_LOG)
        ]);
    }

    public function export() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

        return view('admin/export');
    }

    public function download($resourceName) {
        $data = null;
        $year = $this->request->getVar("tahun");
        $year = strlen($year) == 0 || !is_numeric($year)? null: $year;

        switch($resourceName) {
            case "logPublikasi": $data = $this->logPublikasi->getAllByYear($year); break;
            case "logPenelitian": $data = $this->logPenelitian->getAllByYear($year); break;
            case "logAbdimas": $data = $this->logAbdimas->getAllByYear($year); break;
            case "logHaki": $data = $this->logHaki->getAllByYear($year); break;
            case "publikasi": $data = $this->publikasiModel->getAllByYear($year); break;
            case "penelitian": $data = $this->penelitianModel->getAllByYear($year); break;
            case "abdimas": $data = $this->abdimasModel->getAllByYear($year); break;
            case "haki": $data = $this->hakiModel->getAllByYear($year); break;
        }

        if(is_null($data) || count($data) == 0) {
            session()->setFlashData("error", "Data untuk `$resourceName` kosong");
            return redirect()->back();
        }

        $exportDate = date("Y_m_d-H_m_s");
        $prefixName = ($year == null)? "ALL_": "$year" . "_";
        $filename = "db_export_data-$prefixName$resourceName" . "-$exportDate.csv" ;
        
        $stream = fopen("php://output", "w");
        fputcsv($stream, array_keys($data[0]));
        foreach($data as $l) {
            fputcsv($stream, array_values($l));
        }

        fclose($stream);
        header('Content-type: text/csv');
        header("Content-disposition: attachment; filename= $filename;");

        // when development mode on, somehow debug thingy shows up in the CSV 
        // As of time of writing, the following reference is used to remove them
        // https://forum.codeigniter.com/showthread.php?tid=82555
        exit; 
    }

    public function show_log($resourceName, $id) {
        $logData = null;
        switch($resourceName) {
            case "publikasi": $logData = $this->logPublikasi->getWithUserInfo($id); break;
            case "penelitian": $logData = $this->logPenelitian->getWithUserInfo($id); break;
            case "abdimas": $logData = $this->logAbdimas->getWithUserInfo($id); break;
            case "haki": $logData = $this->logHaki->getWithUserInfo($id); break;
        }

        if(is_null($logData)) {
            session()->setFlashData("error", "Log <b>$resourceName</b> dengan id <b>$id</b> tidak ditemukan");
            return redirect()->to(base_url("/admin/log"));
        }
        return view("admin/log/$resourceName", ["log" => $logData]);
    }
}