<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\PenelitianModel;
use App\Models\AbdimasModel;
use App\Models\HakiModel;

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
    }

    private function getKKPublikasi($publikasi) {
        $kkPublikasi = [];
        foreach(range(1, 11) as $nPenulis) {
            $penulis = $publikasi["penulis_" . $nPenulis];
            if(!(is_null($penulis)) && $penulis != "") {
                $result = $this->dosenModel->getDosen($penulis);
                
                if(!is_null($result)) {
                    $kk = "kk_" . strtolower($result["KK"]);
                    if(!in_array($kk, $kkPublikasi)) {
                        array_push($kkPublikasi, $kk);
                    }
                }
            }
        }
        return $kkPublikasi;
    }

    private function getKKPenelitian($penelitian) {
        $kkPenelitian = [];
        $penulis = $penelitian["ketua_peneliti"];
        if(!(is_null($penulis)) && $penulis != "") {
            $result = $this->dosenModel->getDosen($penulis);
            if(!is_null($result)) {
                $kk = "kk_" . strtolower($result["KK"]);
                array_push($kkPenelitian, $kk);
            }
        }

        foreach(range(1, 10) as $nPenulis) {
            $penulis = $penelitian["anggota_peneliti_" . $nPenulis];
            if(!(is_null($penulis)) && $penulis != "") {
                $result = $this->dosenModel->getDosen($penulis);
                
                if(!is_null($result)) {
                    $kk = "kk_" . strtolower($result["KK"]);
                    if(!in_array($kk, $kkPenelitian)) {
                        array_push($kkPenelitian, $kk);
                    }
                }
            }
        }
        return $kkPenelitian;
    }

    private function getKKAbdimas($abdimas) {
        $kkAbdimas = [];
        $anggota = $abdimas["ketua"];
        if(!(is_null($anggota)) && $anggota != "") {
            $result = $this->dosenModel->getDosen($anggota);
            if(!is_null($result)) {
                $kk = "kk_" . strtolower($result["KK"]);
                array_push($kkAbdimas, $kk);
            }
        }

        foreach(range(1, 8) as $nAnggota) {
            $anggota = $abdimas["anggota_" . $nAnggota];
            if(!(is_null($anggota)) && $anggota != "") {
                $result = $this->dosenModel->getDosen($anggota);
                
                if(!is_null($result)) {
                    $kk = "kk_" . strtolower($result["KK"]);
                    if(!in_array($kk, $kkAbdimas)) {
                        array_push($kkAbdimas, $kk);
                    }
                }
            }
        }
        return $kkAbdimas;
    }

    private function getKKHaki($haki) {
        $kkHaki = [];
        $anggota = $haki["ketua"];
        if(!(is_null($anggota)) && $anggota != "") {
            $result = $this->dosenModel->getDosen($anggota);
            if(!is_null($result)) {
                $kk = "kk_" . strtolower($result["KK"]);
                array_push($kkHaki, $kk);
            }
        }

        foreach(range(1, 9) as $nAnggota) {
            $anggota = $haki["anggota_" . $nAnggota];
            if(!(is_null($anggota)) && $anggota != "") {
                $result = $this->dosenModel->getDosen($anggota);
                
                if(!is_null($result)) {
                    $kk = "kk_" . strtolower($result["KK"]);
                    if(!in_array($kk, $kkHaki)) {
                        array_push($kkHaki, $kk);
                    }
                }
            }
        }
        return $kkHaki;
    }

    private function hasResourcePermission($resourceType, $resource) {
        $resourceType = strtolower($resourceType);
        $kkResource = [];
        switch ($resourceType) {
            case "penelitian": $kkResource = $this->getKKPenelitian($resource); break;
            case "publikasi": $kkResource = $this->getKKPublikasi($resource); break;
            case "abdimas": $kkResource = $this->getKKAbdimas($resource); break;
            case "haki": $kkResource = $this->getKKHaki($resource); break;
        }

        $allowedGroups = ["admin"];
        foreach($kkResource as $kk) array_push($allowedGroups, $kk);
        return in_groups($allowedGroups, user_id());
    }

    private function isInvolvedIn($resourceType, $resource) {
        if(is_null(user())) return false;

        $resourceType = strtolower($resourceType);
        $isInvolved = false;
        $kodeDosen = user()->kode_dosen;
        switch ($resourceType) {
            case "penelitian": 
                $isInvolved = in_array($kodeDosen, [
                    $resource["ketua_peneliti"], $resource["anggota_peneliti_1"],
                    $resource["anggota_peneliti_2"], $resource["anggota_peneliti_3"],
                    $resource["anggota_peneliti_4"], $resource["anggota_peneliti_5"],
                    $resource["anggota_peneliti_6"], $resource["anggota_peneliti_7"],
                    $resource["anggota_peneliti_8"], $resource["anggota_peneliti_9"],
                    $resource["anggota_peneliti_10"]
                ]); break;
            case "publikasi": 
                $isInvolved = in_array($kodeDosen, [
                    $resource["penulis_1"], $resource["penulis_2"], $resource["penulis_3"], 
                    $resource["penulis_4"], $resource["penulis_5"], $resource["penulis_6"], 
                    $resource["penulis_7"], $resource["penulis_8"], $resource["penulis_9"], 
                    $resource["penulis_10"], $resource["penulis_11"]
                ]); break;
            case "abdimas": 
                $isInvolved = in_array($kodeDosen, [
                    $resource["ketua"], $resource["anggota_1"], $resource["anggota_2"], 
                    $resource["anggota_3"], $resource["anggota_4"], $resource["anggota_5"],
                    $resource["anggota_6"], $resource["anggota_7"], $resource["anggota_8"],
                ]); break;
            case "haki":
                $isInvolved = in_array($kodeDosen, [
                    $resource["ketua"], $resource["anggota_1"],
                    $resource["anggota_2"], $resource["anggota_3"],
                    $resource["anggota_4"], $resource["anggota_5"],
                    $resource["anggota_6"], $resource["anggota_7"],
                    $resource["anggota_8"], $resource["anggota_9"],
                ]); break;
        }
        return $isInvolved;
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
                    : (
                        (in_groups("kk_seal", user_id()))
                        ? "SEAL" : "CITI"
                    ));

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

        $isProhibited = ( !$this->hasResourcePermission( 'publikasi', $publikasi)
                        && !$this->isInvolvedIn('publikasi', $publikasi));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses ke halaman tersebut");
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

        // Check for "similar" record
        $sql = " SELECT id, judul_publikasi FROM publikasi ";
        $results = $this->publikasiModel->db->query($sql)->getResultArray();
        foreach($results as $result) {
            $isSame = (
                strtolower($this->request->getVar("judul_publikasi")) == 
                strtolower($result["judul_publikasi"])
            );

            if($isSame) {
                session()->setFlashdata('warning', 'Publikasi serupa ditemukan');
                return redirect()->to(base_url('/admin/publikasi/update/' . $result["id"]));
            }
        }

        // $duplicateID = $this->hasDuplicateResource();
        // if($duplicateID > -1) {
        //     session()->setFlashdata('warning', 'Publikasi serupa ditemukan');
        //     return redirect()->to(base_url('/admin/publikasi/update/' . $result["id"]));
        // }

        $this->publikasiModel->save([
            'akreditasi_journal_conf' => $this->request->getVar('akreditasi'),
            'institusi_mitra' => $this->request->getVar('mitra'),
            'jenis' => $this->request->getVar('jenis'),
            'judul_publikasi' => $this->request->getVar('judul_publikasi'),
            'lab_riset' => $this->request->getVar('penulis_all'),
            'link_artikel' => $this->request->getVar('link'),
            // 'luaran_riset_abdimas' => $this->request->getVar('luaran'),
            'nama_journal_conf' => $this->request->getVar('jurnal_konferensi'),
            'penulis_1' => $this->request->getVar('penulis_1'),
            'penulis_2' => $this->request->getVar('penulis_2'),
            'penulis_3' => $this->request->getVar('penulis_3'),
            'penulis_4' => $this->request->getVar('penulis_4'),
            'penulis_5' => $this->request->getVar('penulis_5'),
            'penulis_6' => $this->request->getVar('penulis_6'),
            'penulis_7' => $this->request->getVar('penulis_7'),
            'penulis_8' => $this->request->getVar('penulis_8'),
            'penulis_9' => $this->request->getVar('penulis_9'),
            'penulis_10' => $this->request->getVar('penulis_10'),
            'penulis_11' => $this->request->getVar('penulis_11'),
            'penulis_all' => $this->request->getVar('semua_penulis'),
            'tahun' => $this->request->getVar('tahun'),
        ]);
        session()->setFlashdata('pesan', 'Publikasi berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_publikasi_edit($id) {
        $publikasi = $this->publikasiModel->where('id', $id)->first();
        if(is_null($publikasi)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'publikasi', $publikasi)
                        && !$this->isInvolvedIn('publikasi', $publikasi));
        if($isProhibited) {
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

        $this->publikasiModel->update($id, [
            'akreditasi_journal_conf' => $this->request->getVar('akreditasi'),
            'institusi_mitra' => $this->request->getVar('mitra'),
            'jenis' => $this->request->getVar('jenis'),
            'judul_publikasi' => $this->request->getVar('judul_publikasi'),
            'lab_riset' => $this->request->getVar('penulis_all'),
            'link_artikel' => $this->request->getVar('link'),
            // 'luaran_riset_abdimas' => $this->request->getVar('luaran'),
            'nama_journal_conf' => $this->request->getVar('jurnal_konferensi'),
            'penulis_1' => $this->request->getVar('penulis_1'),
            'penulis_2' => $this->request->getVar('penulis_2'),
            'penulis_3' => $this->request->getVar('penulis_3'),
            'penulis_4' => $this->request->getVar('penulis_4'),
            'penulis_5' => $this->request->getVar('penulis_5'),
            'penulis_6' => $this->request->getVar('penulis_6'),
            'penulis_7' => $this->request->getVar('penulis_7'),
            'penulis_8' => $this->request->getVar('penulis_8'),
            'penulis_9' => $this->request->getVar('penulis_9'),
            'penulis_10' => $this->request->getVar('penulis_10'),
            'penulis_11' => $this->request->getVar('penulis_11'),
            'penulis_all' => $this->request->getVar('semua_penulis'),
            'tahun' => $this->request->getVar('tahun'),
        ]);
        session()->setFlashdata('pesan', 'Publikasi berhasil diperbarui');
        return redirect()->to(base_url('/admin'));
    }

    public function publikasi_delete($id){
        $publikasi = $this->publikasiModel->where('id', $id)->first();
        if(is_null($publikasi)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'publikasi', $publikasi)
                        && !$this->isInvolvedIn('publikasi', $publikasi));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        $this->publikasiModel->delete($id);
        session()->setFlashdata('pesan', 'Publikasi berhasil dihapus');
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

        $isProhibited = ( !$this->hasResourcePermission( 'penelitian', $penelitian)
                        && !$this->isInvolvedIn('penelitian', $penelitian));
        if($isProhibited) {
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
            'judul' => 'required',
            'tahun' => 'required',
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/penelitian'))->withInput()->with('error', $firstError);
        }

        // Check for "similar" record
        $sql = " SELECT id, judul_penelitian FROM penelitian ";
        $results = $this->penelitianModel->db->query($sql)->getResultArray();
        foreach($results as $result) {
            $isSame = (
                strtolower($this->request->getVar("judul")) == 
                strtolower($result["judul_penelitian"])
            );

            if($isSame) {
                session()->setFlashdata('warning', 'Penelitian serupa ditemukan');
                return redirect()->to(base_url('/admin/penelitian/update/' . $result["id"]));
            }
        }

        $this->penelitianModel->save([
            'anggota_peneliti_1' => $this->request->getVar('anggota_1'),
            'anggota_peneliti_2' => $this->request->getVar('anggota_2'),
            'anggota_peneliti_3' => $this->request->getVar('anggota_3'),
            'anggota_peneliti_4' => $this->request->getVar('anggota_4'),
            'anggota_peneliti_5' => $this->request->getVar('anggota_5'),
            'anggota_peneliti_6' => $this->request->getVar('anggota_6'),
            'anggota_peneliti_7' => $this->request->getVar('anggota_7'),
            'anggota_peneliti_8' => $this->request->getVar('anggota_8'),
            'anggota_peneliti_9' => $this->request->getVar('anggota_9'),
            'anggota_peneliti_10' => $this->request->getVar('anggota_10'),
            'catatan_rekomendasi' => $this->request->getVar('rekomendasi'),
            'jenis' => $this->request->getVar('jenis'),
            'judul_penelitian' => $this->request->getVar('judul'),
            'kesesuaian_roadmap' => $this->request->getVar('roadmap'),
            'ketua_peneliti' => $this->request->getVar('ketua'),
            'lab_riset' => $this->request->getVar('lab_riset'),
            'luaran' => $this->request->getVar('luaran'),
            'mitra' => $this->request->getVar('mitra'),
            'mk_relevan' => $this->request->getVar('mk_relevan'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'status' => $this->request->getVar('status'),
            'tahun' => $this->request->getVar('tahun'),
            'tgl_pengesahan' => $this->request->getVar('tgl_pengesahan')
        ]);

        session()->setFlashdata('pesan', 'Penelitian berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_penelitian_edit($id) {
        $penelitian = $this->penelitianModel->where('id', $id)->first();
        if(is_null($penelitian)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'penelitian', $penelitian)
                        && !$this->isInvolvedIn('penelitian', $penelitian));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }


        if (!$this->validate([
            'jenis' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
        ])) {
            $validation = \config\Services::validation()->getErrors();
            $firstError = reset($validation);
            return redirect()->to(base_url('/admin/penelitian'))->withInput()->with('error', $firstError);
        }

        $this->penelitianModel->update($id, [
            'anggota_peneliti_1' => $this->request->getVar('anggota_1'),
            'anggota_peneliti_2' => $this->request->getVar('anggota_2'),
            'anggota_peneliti_3' => $this->request->getVar('anggota_3'),
            'anggota_peneliti_4' => $this->request->getVar('anggota_4'),
            'anggota_peneliti_5' => $this->request->getVar('anggota_5'),
            'anggota_peneliti_6' => $this->request->getVar('anggota_6'),
            'anggota_peneliti_7' => $this->request->getVar('anggota_7'),
            'anggota_peneliti_8' => $this->request->getVar('anggota_8'),
            'anggota_peneliti_9' => $this->request->getVar('anggota_9'),
            'anggota_peneliti_10' => $this->request->getVar('anggota_10'),
            'catatan_rekomendasi' => $this->request->getVar('rekomendasi'),
            'jenis' => $this->request->getVar('jenis'),
            'judul_penelitian' => $this->request->getVar('judul'),
            'kesesuaian_roadmap' => $this->request->getVar('roadmap'),
            'ketua_peneliti' => $this->request->getVar('ketua'),
            'lab_riset' => $this->request->getVar('lab_riset'),
            'luaran' => $this->request->getVar('luaran'),
            'mitra' => $this->request->getVar('mitra'),
            'mk_relevan' => $this->request->getVar('mk_relevan'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'status' => $this->request->getVar('status'),
            'tahun' => $this->request->getVar('tahun'),
            'tgl_pengesahan' => $this->request->getVar('tgl_pengesahan')
        ]);
        session()->setFlashdata('pesan', 'Penelitian berhasil diperbarui');
        return redirect()->to(base_url('/admin'));
    }

    public function penelitian_delete($id) {
        $penelitian = $this->penelitianModel->where('id', $id)->first();
        if(is_null($penelitian)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'penelitian', $penelitian)
                        && !$this->isInvolvedIn('penelitian', $penelitian));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        $this->penelitianModel->delete($id);
        session()->setFlashdata('pesan', 'Penelitian berhasil dihapus');
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

        $isProhibited = ( !$this->hasResourcePermission( 'abdimas', $abdimas)
                        && !$this->isInvolvedIn('abdimas', $abdimas));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
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

        // Check for "similar" record
        $sql = " SELECT id, judul FROM abdimas ";
        $results = $this->abdimasModel->db->query($sql)->getResultArray();
        foreach($results as $result) {
            $isSame = (
                strtolower($this->request->getVar("judul")) == 
                strtolower($result["judul"])
            );

            if($isSame) {
                session()->setFlashdata('warning', 'Abdimas serupa ditemukan');
                return redirect()->to(base_url('/admin/abdimas/update/' . $result["id"]));
            }
        }

        $this->abdimasModel->save([
            'anggota_1' => $this->request->getVar('anggota_1'),
            'anggota_2' => $this->request->getVar('anggota_2'),
            'anggota_3' => $this->request->getVar('anggota_3'),
            'anggota_4' => $this->request->getVar('anggota_4'),
            'anggota_5' => $this->request->getVar('anggota_5'),
            'anggota_6' => $this->request->getVar('anggota_6'),
            'anggota_7' => $this->request->getVar('anggota_7'),
            'anggota_8' => $this->request->getVar('anggota_8'),
            'alamat_mitra' => $this->request->getVar('alamat_mitra'),
            'catatan' => $this->request->getVar('catatan'),
            'jenis' => $this->request->getVar('jenis'),
            'judul' => $this->request->getVar('judul'),
            'kesesuaian_roadmap' => $this->request->getVar('kesesuaian_roadmap'),
            'ketua' => $this->request->getVar('ketua'),
            'lab_riset' => $this->request->getVar('lab_riset'),
            'luaran' => $this->request->getVar('luaran'),
            'mitra' => $this->request->getVar('institusi_mitra'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'permasalahan_masy' => $this->request->getVar('permasalahan_masyarakat'),
            'solusi' => $this->request->getVar('solusi'),
            'status' => $this->request->getVar('status'),
            'tahun' => $this->request->getVar('tahun'),
            'tgl_pengesahan' => $this->request->getVar('tgl_pengesahan')
        ]);

        session()->setFlashdata('pesan', 'Abdimas berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));
    }

    public function abdimas_delete($id) {
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if(is_null($abdimas)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'abdimas', $abdimas)
                        && !$this->isInvolvedIn('abdimas', $abdimas));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        $this->abdimasModel->delete($id);
        session()->setFlashdata('pesan', 'Abdimas berhasil dihapus');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_abdimas_edit($id) {
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if(is_null($abdimas)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'abdimas', $abdimas)
                        && !$this->isInvolvedIn('abdimas', $abdimas));
        if($isProhibited) {
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

        $this->abdimasModel->update($id, [
            'anggota_1' => $this->request->getVar('anggota_1'),
            'anggota_2' => $this->request->getVar('anggota_2'),
            'anggota_3' => $this->request->getVar('anggota_3'),
            'anggota_4' => $this->request->getVar('anggota_4'),
            'anggota_5' => $this->request->getVar('anggota_5'),
            'anggota_6' => $this->request->getVar('anggota_6'),
            'anggota_7' => $this->request->getVar('anggota_7'),
            'anggota_8' => $this->request->getVar('anggota_8'),
            'alamat_mitra' => $this->request->getVar('alamat_mitra'),
            'catatan' => $this->request->getVar('catatan'),
            'jenis' => $this->request->getVar('jenis'),
            'judul' => $this->request->getVar('judul'),
            'kesesuaian_roadmap' => $this->request->getVar('kesesuaian_roadmap'),
            'ketua' => $this->request->getVar('ketua'),
            'lab_riset' => $this->request->getVar('lab_riset'),
            'luaran' => $this->request->getVar('luaran'),
            'mitra' => $this->request->getVar('institusi_mitra'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'permasalahan_masy' => $this->request->getVar('permasalahan_masyarakat'),
            'solusi' => $this->request->getVar('solusi'),
            'status' => $this->request->getVar('status'),
            'tahun' => $this->request->getVar('tahun'),
            'tgl_pengesahan' => $this->request->getVar('tgl_pengesahan')
        ]);
        session()->setFlashdata('pesan', 'Abdimas berhasil diperbarui');
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

        $isProhibited = ( !$this->hasResourcePermission( 'haki', $haki)
                        && !$this->isInvolvedIn('haki', $haki));
        if($isProhibited) {
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

        // Check for "similar" record
        $sql = " SELECT id, judul FROM haki";
        $results = $this->hakiModel->db->query($sql)->getResultArray();
        foreach($results as $result) {
            $isSame = (
                strtolower($this->request->getVar("judul")) == 
                strtolower($result["judul"])
            );

            if($isSame) {
                session()->setFlashdata('warning', 'Haki serupa ditemukan');
                return redirect()->to(base_url('/admin/haki/update/' . $result["id"]));
            }
        }

        $this->hakiModel->save([
            'abstrak' => $this->request->getVar('abstrak'),
            'anggota_1' => $this->request->getVar('anggota_1'),
            'anggota_2' => $this->request->getVar('anggota_2'),
            'anggota_3' => $this->request->getVar('anggota_3'),
            'anggota_4' => $this->request->getVar('anggota_4'),
            'anggota_5' => $this->request->getVar('anggota_5'),
            'anggota_6' => $this->request->getVar('anggota_6'),
            'anggota_7' => $this->request->getVar('anggota_7'),
            'anggota_8' => $this->request->getVar('anggota_8'),
            'anggota_9' => $this->request->getVar('anggota_9'),
            'catatan' => $this->request->getVar('catatan'),
            'jenis' => $this->request->getVar('jenis'),
            'jenis_ciptaan' => $this->request->getVar('jenis_ciptaan'),
            'judul' => $this->request->getVar('judul'),
            'ketua' => $this->request->getVar('ketua'),
            'no_pendaftaran' => $this->request->getVar('no_pendaftaran'),
            'no_sertifikat' => $this->request->getVar('no_sertifikat'),
            'tahun' => $this->request->getVar('tahun'),
        ]);
        session()->setFlashdata('pesan', 'Haki berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));
    }

    public function haki_delete($id) {
        $haki = $this->hakiModel->where('id', $id)->first();
        if(is_null($haki)) { // TODO: Make the flash data red in UI
            session()->setFlashdata('error', 'Haki tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'haki', $haki)
                        && !$this->isInvolvedIn('haki', $haki));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        $this->hakiModel->delete($id);
        session()->setFlashdata('pesan', 'Haki berhasil dihapus');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_haki_edit($id) {
        $haki = $this->hakiModel->where('id', $id)->first();
        if(is_null($haki)) { // TODO: Make the flash data red in UI
            sessAon()->setFlashdata('error', 'Haki tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $isProhibited = ( !$this->hasResourcePermission( 'haki', $haki)
                        && !$this->isInvolvedIn('haki', $haki));
        if($isProhibited) {
            session()->setFlashdata("error", "Anda tidak memiliki akses untuk malakukan aksi tersebut");
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

        $this->hakiModel->update($id, [
            'abstrak' => $this->request->getVar('abstrak'),
            'anggota_1' => $this->request->getVar('anggota_1'),
            'anggota_2' => $this->request->getVar('anggota_2'),
            'anggota_3' => $this->request->getVar('anggota_3'),
            'anggota_4' => $this->request->getVar('anggota_4'),
            'anggota_5' => $this->request->getVar('anggota_5'),
            'anggota_6' => $this->request->getVar('anggota_6'),
            'anggota_7' => $this->request->getVar('anggota_7'),
            'anggota_8' => $this->request->getVar('anggota_8'),
            'anggota_9' => $this->request->getVar('anggota_9'),
            'catatan' => $this->request->getVar('catatan'),
            'jenis' => $this->request->getVar('jenis'),
            'jenis_ciptaan' => $this->request->getVar('jenis_ciptaan'),
            'judul' => $this->request->getVar('judul'),
            'ketua' => $this->request->getVar('ketua'),
            'no_pendaftaran' => $this->request->getVar('no_pendaftaran'),
            'no_sertifikat' => $this->request->getVar('no_sertifikat'),
            'tahun' => $this->request->getVar('tahun'),
        ]);
        session()->setFlashdata('pesan', 'Haki berhasil diperbarui');
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
                $errorMessage .= (ucwords(array_keys($files)[$idx])
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