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
    }

    private function isAdmin() { // Roles considered as Admin: admin, kk_seal, kk_citi, kk_dsis
        return in_groups(["admin", "kk_dsis", "kk_citi", "kk_seal"], user_id());
    }

    public function index() {
        $data = null;
        if(in_groups("admin", user_id())) { // All
            $data = [
                'all_publikasi' => $this->publikasiModel->getAllPublikasi(),
                'all_penelitian' => $this->penelitianModel->getAllPenelitian(),
                'all_abdimas' => $this->abdimasModel->getAllAbdimas(),
                'all_haki' => $this->hakiModel->getAllHaki(),
                'title' => 'Daftar Dosen',
            ];
        } else if (in_groups(["kk_dsis", "kk_seal", "kk_citi"], user_id())) { // KK specific
            $kk = (in_groups("kk_dsis", user_id())
                    ?  "DSIS"
                    : ( (in_groups("kk_seal", user_id()))
                        ? "SEAL" : "CITI"));
            $data = [
                'all_publikasi' => $this->publikasiModel->getAllByKK($kk),
                'all_penelitian' => $this->penelitianModel->getAllByKK($kk),
                'all_abdimas' => $this->abdimasModel->getAllByKK($kk),
                'all_haki' => $this->hakiModel->getAllByKK($kk),
                'title' => 'Daftar Dosen',
            ];
        } else { // Dosen specific
            $kodeDosen = user()->kode_dosen;
            $data = [
                'all_publikasi' => $this->publikasiModel->getPublikasi($kodeDosen),
                'all_penelitian' => $this->penelitianModel->getPenelitian($kodeDosen),
                'all_abdimas' => $this->abdimasModel->getAbdimas($kodeDosen),
                'all_haki' => $this->hakiModel->getHaki($kodeDosen),
                'title' => 'Daftar Dosen',
            ];
        }

        $data["isAdmin"] = $this->isAdmin();
        return view('admin/index', $data);
    }

    // ##### PUBLIKASI #############################################################################
    public function publikasi() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

        $data = [
            'validation' => \config\Services::validation(),
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'akreditasiPublikasi' => [ 
                "Q1", "Q2", "Q3", "Q4", 
                "S1", "S2", "S3", "S4", "S5", "S6",
                "Scopus"
            ],
            'jenisPublikasi' => [
                "Jurnal Internasional",
                "Jurnal Nasional",
                "Prosiding Internasional",
                "Prosiding Nasional"
            ]
        ];
        return view('admin/manage-publikasi', $data);
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
        $data = [
            'oldPublikasi' => $publikasi,
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'akreditasiPublikasi' => [ 
                "Q1", "Q2", "Q3", "Q4", 
                "S1", "S2", "S3", "S4", "S5", "S6",
                "Scopus"
            ],
            'jenisPublikasi' => [
                "Jurnal Internasional",
                "Jurnal Nasional",
                "Prosiding Internasional",
                "Prosiding Nasional"
            ]
        ];
        session()->setFlashdata('pesan', 'Publikasi berhasil diperbarui');
        return view("admin/update-publikasi", $data);
    }

    public function publikasi_save() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

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

        $this->logPublikasi->transBegin();
        unset($newPublikasi["csrf_test_name"]);
        $this->publikasiModel->save($newPublikasi);
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
        return redirect()->to(base_url('/admin'));
    }

    public function handle_publikasi_edit($id) {
        $publikasi = $this->publikasiModel->where('id', $id)->first();
        if(is_null($publikasi)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        if(!$this->publikasiModel->isPermitted($publikasi)) {
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

        $this->logPublikasi->transBegin();
        unset($publikasi["id"], $newPublikasi["csrf_test_name"]);
        $this->publikasiModel->update($id, $newPublikasi);
        $this->logPublikasi->save([ 
            "user_id" => user_id(),
            "publikasi_id" => $id,
            "action" => "U",
            "value_before" => json_encode($publikasi),
            "value_after" => json_encode($newPublikasi) ]);
        if($this->logPublikasi->transStatus() === false) {
            $this->logPublikasi->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logPenelitian->transCommit();
            session()->setFlashdata('pesan', 'Publikasi berhasil diperbarui');
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

        $this->logPublikasi->transBegin();
        $this->publikasiModel->delete($id);
        $this->logPublikasi->save([ 
            "user_id" => user_id(),
            "publikasi_id" => $id,
            "action" => "D",
            "value_before" => json_encode($publikasi) ]);
        if($this->logPublikasi->transStatus() === false) {
            $this->logPublikasi->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logPublikasi->transCommit();
            session()->setFlashdata('pesan', 'Publikasi berhasil dihapus');
        }
        return redirect()->to(base_url('/admin'));
    }

    // ###### PENELITIAN ###########################################################################
    public function penelitian() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

        $data = [
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'jenisPenelitian' => [
                "Internal",
                "Eksternal",
                "Mandiri",
                "Kerjasama Perguruan Tinggi",
                "Kemitraan",
                "Hilirisasi"
            ],
            'statusPenelitian' => ["Didanai", "Submit Proposal"],
            'luaranPenelitian' => ["Riset", "Abdimas"]
        ];

        return view( 'admin/manage-penelitian', $data);
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
        $data = [
            'oldPenelitian' => $penelitian,
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'jenisPenelitian' => [
                "Internal",
                "Eksternal",
                "Mandiri",
                "Kerjasama Perguruan Tinggi",
                "Kemitraan",
                "Hilirisasi"
            ],
            'statusPenelitian' => ["Didanai", "Submit Proposal"],
            'luaranPenelitian' => ["Riset", "Abdimas"]
        ];
        session()->setFlashdata('pesan', 'Penelitian berhasil diperbarui');
        return view("admin/update-penelitian", $data);
    }

    public function penelitian_save() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

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

        $this->logPenelitian->transBegin();
        unset($newPenelitian["csrf_test_name"]);
        $this->penelitianModel->save($newPenelitian);
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

        $this->logPenelitian->transBegin();
        unset($penelitian["id"], $newPenelitian["csrf_test_name"]);
        $this->penelitianModel->update($id, $newPenelitian);
        $this->logPenelitian->save([ 
            "user_id" => user_id(),
            "penelitian_id" => $id,
            "action" => "U",
            "value_before" => json_encode($penelitian),
            "value_after" => json_encode($newPenelitian) ]);
        if($this->logPenelitian->transStatus() === false) {
            $this->logPenelitian->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logPenelitian->transCommit();
            session()->setFlashdata('pesan', 'Penelitian berhasil diperbarui');
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

        $this->logPenelitian->transBegin();
        $this->penelitianModel->delete($id);
        $this->logPenelitian->save([ 
            "user_id" => user_id(),
            "penelitian_id" => $id,
            "action" => "D",
            "value_before" => json_encode($penelitian) ]);
        if($this->logPenelitian->transStatus() === false) {
            $this->logPenelitian->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logPenelitian->transCommit();
            session()->setFlashdata('pesan', 'Penelitian berhasil dihapus');
        }
        return redirect()->to(base_url('/admin'));
    }

    // ###### ABDIMAS ##############################################################################
    public function abdimas() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

        $data = [
            "listDosen" => $this->dosenModel->getAllKodeDosen(),
            'jenisAbdimas' => [
                "EKSTERNAL",
                "INTERNAL",
            ],
            'statusAbdimas' => [
                "Didanai",
                "Tidak didanai",
                "Closed",
            ]
        ];
        return view('admin/manage-abdimas', $data);
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
        $data = [
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'oldAbdimas' => $abdimas,
            'jenisAbdimas' => [
                "EKSTERNAL",
                "INTERNAL",
            ],
            'statusAbdimas' => [
                "Didanai",
                "Tidak didanai",
                "Closed",
            ]
        ];
        session()->setFlashdata('pesan', 'abdimas berhasil diperbarui');
        return view("admin/update-abdimas", $data);
    }

    public function abdimas_save() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

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

        $this->logAbdimas->transBegin();
        unset($newAbdimas["csrf_test_name"]);
        $this->abdimasModel->save($newAbdimas);
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

        $this->logAbdimas->transBegin();
        $this->abdimasModel->delete($id);
        $this->logAbdimas->save([ 
            "user_id" => user_id(),
            "abdimas_id" => $id,
            "action" => "D",
            "value_before" => json_encode($abdimas) ]);
        if($this->logAbdimas->transStatus() === false) {
            $this->logAbdimas->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logAbdimas->transCommit();
            session()->setFlashdata('pesan', 'Abdimas berhasil dihapus');
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

        $this->logAbdimas->transBegin();
        unset($abdimas["id"], $newAbdimas["csrf_test_name"]);
        $this->abdimasModel->update($id, $newAbdimas);
        $this->logAbdimas->save([ 
            "user_id" => user_id(),
            "abdimas_id" => $id,
            "action" => "U",
            "value_before" => json_encode($abdimas),
            "value_after" => json_encode($newAbdimas) ]);
        if($this->logAbdimas->transStatus() === false) {
            $this->logAbdimas->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logAbdimas->transCommit();
            session()->setFlashdata('pesan', 'Abdimas berhasil diperbarui');
        }
        return redirect()->to(base_url('/admin'));
    }

    // ###### HAKI #################################################################################
    public function haki() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
            return redirect()->to(base_url());
        };

        $data = [ 
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'jenisHaki' => [ "PATEN", "HAK CIPTA", "MEREK", "DESAIN INDUSTRI" ] 
        ];
        return view('admin/manage-haki', $data);
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
        $data = [
            'oldHaki' => $haki,
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'jenisHaki' => [ "PATEN", "HAK CIPTA", "MEREK", "DESAIN INDUSTRI" ]
        ];
        session()->setFlashdata('pesan', 'haki berhasil diperbarui');
        return view("admin/update-haki", $data);
    }

    public function haki_save() {
        if(!$this->isAdmin()) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan hal tersebut");
            return redirect()->to(base_url());
        };

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

        $this->logHaki->transBegin();
        unset($newHaki["csrf_test_name"]);
        $this->hakiModel->save($newHaki);
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

        $this->logHaki->transBegin();
        $this->hakiModel->delete($id);
        $this->logHaki->save([ 
            "user_id" => user_id(),
            "haki_id" => $id,
            "action" => "D",
            "value_before" => json_encode($haki) ]);
        if($this->logHaki->transStatus() === false) {
            $this->logHaki->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logHaki->transCommit();
            session()->setFlashdata('pesan', 'Haki berhasil dihapus');
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

        $this->logHaki->transBegin();
        unset($haki["id"], $newHaki["csrf_test_name"]);
        $this->hakiModel->update($id, $newHaki);
        $this->logHaki->save([ 
            "user_id" => user_id(),
            "haki_id" => $id,
            "action" => "U",
            "value_before" => json_encode($haki),
            "value_after" => json_encode($newHaki) ]);
        if($this->logHaki->transStatus() === false) {
            $this->logHaki->transRollback();
            session()->setFlashdata('error', 'Suatu kesalahan terjadi ketika menyimpan data');
        } else {
            $this->logHaki->transCommit();
            session()->setFlashdata('pesan', 'Haki berhasil diperbarui');
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
            case "publikasi":
                return $this->response->download(("$BASE_DIR/tPublikasiEXAMPLE.xlsx"), null);
            case "penelitian":
                return $this->response->download(("$BASE_DIR/tPenelitianEXAMPLE.xlsx"), null);
            case "abdimas":
                return $this->response->download(("$BASE_DIR/tAbdimasEXAMPLE.xlsx"), null);
            case "haki":
                return $this->response->download(("$BASE_DIR/tHakiEXAMPLE.xlsx"), null);
            default:
                session()->setFlashData("error", "Template `$filename` tidak ditemukan");
                return redirect()->to(base_url("/admin/import"));
        }
    }
}