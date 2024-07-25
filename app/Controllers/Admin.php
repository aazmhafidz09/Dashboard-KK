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

    // private function userHasPermission($groupList, $noPermissionMsg) {
    //     $isAllowed = in_groups($groupList, user_id());
    //     if(!$isAllowed) {
    //         session()->setFlashdata("warning", $noPermissionMsg);
    //         return redirect()->to(base_url());
    //     }
    //     return isAllowed;
    // }

    public function index()
    {
        // $dosen = $this->dosenModel->findAll();
        $data = [
            'all_publikasi' => $this->publikasiModel->getAllPublikasi(),
            'all_penelitian' => $this->penelitianModel->getAllPenelitian(),
            'all_abdimas' => $this->abdimasModel->getAllAbdimas(),
            'all_haki' => $this->hakiModel->getAllHaki(),
            'dosen' => $this->dosenModel->getDosen(),
            'title' => 'Daftar Dosen',
        ];
        return view('admin/index', $data);
    }

    // ****************************************************************************************************
    // ========== PUBLIKASI ========== 
    // ****************************************************************************************************

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

    public function publikasi()
    {
        $isAllowed = in_groups(["admin", "kk_dsis", "kk_seal", "kk_citi"], user_id());
        if(!$isAllowed) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

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
        if($publikasi == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKPublikasi($publikasi) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
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

    public function publikasi_save()
    {
        $isAllowed = in_groups(["admin", "kk_dsis", "kk_seal", "kk_citi"], user_id());
        if(!$isAllowed) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        if (!$this->validate([
            'judul_publikasi' => 'required',
            'tahun' => 'required'
        ])) {
            $validation = \config\Services::validation();
            return redirect()->to(base_url('/admin/publikasi'))->withInput()->with('validation', $validation);
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
            'penulis_all' => $this->request->getVar('semua_penulis'),
            'tahun' => $this->request->getVar('tahun'),
        ]);
        session()->setFlashdata('pesan', 'Publikasi berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_publikasi_edit($id) {
        $publikasi = $this->publikasiModel->where('id', $id)->first();
        if($publikasi == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKPublikasi($publikasi) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        if (!$this->validate([
            'judul_publikasi' => 'required',
            'tahun' => 'required'
        ])) {
            $validation = \config\Services::validation();
            return redirect()->to('/admin/publikasi')->withInput()->with('validation', $validation);
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
            'penulis_all' => $this->request->getVar('semua_penulis'),
            'tahun' => $this->request->getVar('tahun'),
        ]);
        session()->setFlashdata('pesan', 'Publikasi berhasil diperbarui');
        return redirect()->to(base_url('/admin'));
    }

    public function publikasi_delete($id){
        $isAllowed = in_groups(["admin"], user_id());
        if(!$isAllowed) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        $this->publikasiModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to(base_url('/admin'));
    }
    






    // ****************************************************************************************************
    // ========== PENELITIAN ========== 
    // ****************************************************************************************************

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

    public function penelitian()
    {
        $isAllowed = in_groups(["admin", "kk_dsis", "kk_seal", "kk_citi"], user_id());
        if(!$isAllowed) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

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
        if($penelitian == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Publikasi tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKPenelitian($penelitian) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        helper('form');
        if($penelitian == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

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

    public function penelitian_save()
    {
        $isAllowed = in_groups(["admin"], user_id());
        if(!$isAllowed) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk melakukan aksi tersebut");
            return redirect()->to(base_url());
        }

        if (!$this->validate([
            'jenis' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
        ])) {
            $validation = \config\Services::validation();
            return redirect()->to(base_url('/admin/penelitian'));
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

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_penelitian_edit($id) {
        $penelitian = $this->penelitianModel->where('id', $id)->first();
        if($penelitian == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKPenelitian($penelitian) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        if($penelitian == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $this->penelitianModel->update($id, [
            'anggota_peneliti_1' => $this->request->getVar('anggota_1'),
            'anggota_peneliti_2' => $this->request->getVar('anggota_2'),
            'anggota_peneliti_3' => $this->request->getVar('anggota_3'),
            'anggota_peneliti_4' => $this->request->getVar('anggota_4'),
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
        if($penelitian == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Penelitian tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKPenelitian($penelitian) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        $this->penelitianModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to(base_url('/admin'));
    }










    // ****************************************************************************************************
    // ========== ABDIMAS ========== 
    // ****************************************************************************************************
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

    public function abdimas()
    {
        $isAllowed = in_groups(["admin", "kk_dsis", "kk_seal", "kk_citi"], user_id());
        if(!$isAllowed) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        $data = [
            "listDosen" => $this->dosenModel->getAllKodeDosen(),
            'jenisAbdimas' => [
                "EKSTERNAL",
                "INTERNAL",
                "INTERNAL & EKSTERNAL",
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
        if($abdimas == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKAbdimas($abdimas) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        helper('form');
        $data = [
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'oldAbdimas' => $abdimas,
            'jenisAbdimas' => [
                "EKSTERNAL",
                "INTERNAL",
                "INTERNAL & EKSTERNAL",
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

    public function abdimas_save()
    {
        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            return redirect()->to(base_url('/admin/penelitian'));
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

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));
    }

    public function abdimas_delete($id){
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if($abdimas == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKAbdimas($abdimas) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        $this->abdimasModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_abdimas_edit($id) {
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if($abdimas == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Abdimas tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKAbdimas($abdimas) as $kk) {
            array_push($allowedGroups, $kk);
        }

        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        $this->abdimasModel->update($id, [
            'anggota_1' => $this->request->getVar('anggota_1'),
            'anggota_2' => $this->request->getVar('anggota_2'),
            'anggota_3' => $this->request->getVar('anggota_3'),
            'anggota_4' => $this->request->getVar('anggota_4'),
            'anggota_5' => $this->request->getVar('anggota_5'),
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







    // ******************************************************
    // ========== HAKI ========== 
    // ******************************************************
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

    public function haki()
    {
        $isAllowed = in_groups(["admin", "kk_dsis", "kk_seal", "kk_citi"], user_id());
        if(!$isAllowed) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        $data = [ 
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'jenisHaki' => [ "PATEN", "HAK CIPTA", "MEREK", "KARYA/BUKU" ] 
        ];
        return view('admin/manage-haki', $data);
    }
    
    public function haki_edit($id) {
        $haki = $this->hakiModel->where('id', $id)->first();
        if($haki == null) { // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'haki tidak ditemukan');
            return redirect()->to(base_url('/admin'));
        }

        $allowedGroups = ["admin"];
        foreach($this->getKKHaki($haki) as $kk) {
            array_push($allowedGroups, $kk);
        }

        dd($allowedGroups);
        if(!in_groups($allowedGroups, user_id())) {
            session()->setFlashdata("warning", "Anda tidak memiliki akses untuk halaman tersebut");
            return redirect()->to(base_url());
        }

        helper('form');
        $data = [
            'oldHaki' => $haki,
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'jenisHaki' => [ "PATEN", "HAK CIPTA", "MEREK", "KARYA/BUKU" ]
        ];
        session()->setFlashdata('pesan', 'haki berhasil diperbarui');
        return view("admin/update-haki", $data);
    }

    public function haki_save()
    {

        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            return redirect()->to(base_url('/admin/haki'));
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
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('/admin'));

    }
    public function haki_delete($id){
        $this->hakiModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to(base_url('/admin'));
    }

    public function handle_haki_edit($id) {
        if($this->hakiModel->where('id', $id)->first() == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Haki tidak ditemukan');
            return redirect()->to(base_url('/admin'));
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
}

/*
    INSERT INTO auth_permissions(name, description)
    VALUES
    ("update_publikasi_SEAL", "Update data publikasi KK SEAL"),
    ("update_publikasi_DSIS", "Update data publikasi KK DSIS"),
    ("update_publikasi_CITI", "Update data publikasi KK DSIS"),
    ("update_penelitian_SEAL", "Update data penelitian KK SEAL"),
    ("update_penelitian_DSIS", "Update data penelitian KK DSIS"),
    ("update_penelitian_CITI", "Update data penelitian KK CITI"),
    ("update_haki_SEAL", "Update data haki KK SEAL"),
    ("update_haki_DSIS", "Update data haki KK DSIS"),
    ("update_haki_CITI", "Update data haki KK CITI"),
    ("update_abdimas_SEAL", "Update data abdimas KK SEAL"),
    ("update_abdimas_DSIS", "Update data abdimas KK DSIS"),
    ("update_abdimas_CITI", "Update data abdimas KK CITI"),
    ("delete_publikasi_SEAL", "Delete data publikasi KK SEAL"),
    ("delete_publikasi_DSIS", "Delete data publikasi KK DSIS"),
    ("delete_publikasi_CITI", "Delete data publikasi KK CITI"),
    ("delete_penelitian_SEAL", "Delete data penelitian KK SEAL"),
    ("delete_penelitian_DSIS", "Delete data penelitian KK DSIS"),
    ("delete_penelitian_CITI", "Delete data penelitian KK CITI"),
    ("delete_haki_SEAL", "Delete data haki KK SEAL"),
    ("delete_haki_DSIS", "Delete data haki KK DSIS"),
    ("delete_haki_CITI", "Delete data haki KK CITI"),
    ("delete_abdimas_SEAL", "Delete data abdimas KK SEAL"),
    ("delete_abdimas_DSIS", "Delete data abdimas KK DSIS"),
    ("delete_abdimas_CITI", "Delete data abdimas KK CITI");
*/