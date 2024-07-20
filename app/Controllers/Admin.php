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

    public function publikasi()
    {
        // session();
        $data = [
            'validation' => \config\Services::validation()
        ];
        // dd($data);
        return view('admin/manage-publikasi', $data);
    }
    public function publikasi_save()
    {
        if (!$this->validate([
            'judul_publikasi' => 'required',
            'tahun' => 'required'
        ])) {
            $validation = \config\Services::validation();
            dd($validation);

            return redirect()->to('/admin/publikasi')->withInput()->with('validation', $validation);
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
        return redirect()->to('/admin');
        // dd($this->request->getVar());
    }
    public function publikasi_delete($id){
        $this->publikasiModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin');
    }
    
    public function publikasi_edit($id) {
        helper('form');
        $publikasi = $this->publikasiModel->where('id', $id)->first();
        if($publikasi == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Publikasi tidak ditemukan');
            return redirect()->to('/admin');
        }

        $data = ['oldPublikasi' => $publikasi];
            session()->setFlashdata('pesan', 'Publikasi berhasil diperbarui');
        return view("admin/update-publikasi", $data);
    }

    public function handle_publikasi_edit($id) {
        if (!$this->validate([
            'judul_publikasi' => 'required',
            'tahun' => 'required'
        ])) {
            $validation = \config\Services::validation();
            dd($validation);

            return redirect()->to('/admin/publikasi')->withInput()->with('validation', $validation);
        }

        if($this->publikasiModel->where('id', $id)->first() == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Publikasi tidak ditemukan');
            return redirect()->to('/admin');
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
        return redirect()->to('/admin');
        // dd($this->request->getVar());
    }

    // ****************************************************************************************************
    // ========== PENELITIAN ========== 
    // ****************************************************************************************************

    public function penelitian()
    {

        return view('admin/manage-penelitian');
    }
    public function penelitian_save()
    {
        if (!$this->validate([
            'jenis' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
        ])) {
            $validation = \config\Services::validation();
            dd($validation);

            return redirect()->to('/admin/penelitian');
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

        // dd($this->request->getVar());
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin');
    }

    public function penelitian_delete($id) {
        $this->penelitianModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin');
    }

    public function penelitian_edit($id) {
        helper('form');
        $penelitian = $this->penelitianModel->where('id', $id)->first();
        if($penelitian == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Penelitian tidak ditemukan');
            return redirect()->to('/admin');
        }

        $data = ['oldPenelitian' => $penelitian];
        session()->setFlashdata('pesan', 'Penelitian berhasil diperbarui');
        return view("admin/update-penelitian", $data);
    }

    public function handle_penelitian_edit($id) {
        if($this->penelitianModel->where('id', $id)->first() == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Penelitian tidak ditemukan');
            return redirect()->to('/admin');
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
        return redirect()->to('/admin');
        // dd($this->request->getVar());
    }

    // ****************************************************************************************************
    // ========== ABDIMAS ========== 
    // ****************************************************************************************************

    public function abdimas()
    {
        $data = ["listDosen" => $this->dosenModel->getAllKodeDosen()];
        return view('admin/manage-abdimas', $data);
    }
    public function abdimas_save()
    {
        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            return redirect()->to('/admin/penelitian');
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


        // dd($this->request->getVar());
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin');
    }
    public function abdimas_delete($id){
        $this->abdimasModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin');
    }

    public function abdimas_edit($id) {
        helper('form');
        $abdimas = $this->abdimasModel->where('id', $id)->first();
        if($abdimas == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'abdimas tidak ditemukan');
            return redirect()->to('/admin');
        }

        $data = [
            'listDosen' => $this->dosenModel->getAllKodeDosen(),
            'oldAbdimas' => $abdimas,
            /* 'dosenIS' => [ 
                    "ABW", "ACK", "ADF", "AHY",
                    "BBD", "BDP",
                    "COK",
                    "DNH",
                    "EAR", "EDF", "ENY",
                    "FAR", "FSV",
                    "GIA", "GKL",
                    "HIW", "HII", "HUI",
                    "IAU", "IZA",
                    "JMT",
                    "KNR",
                    "LDS",
                    "MDS", "MZI",
                    "NDP",
                    "OGO",
                    "PEY",
                    "RMB", "RRD", "RSM",
                    "SLL", "SSD", "STZ", "SUO",
                    "UIN", "UNW",
                    "WKF",
                    "ZHH",
            ]*/
        ];
        session()->setFlashdata('pesan', 'abdimas berhasil diperbarui');
        return view("admin/update-abdimas", $data);
    }

    public function handle_abdimas_edit($id) {
        if($this->abdimasModel->where('id', $id)->first() == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'abdimas tidak ditemukan');
            return redirect()->to('/admin');
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
        return redirect()->to('/admin');
        // dd($this->request->getVar());
    }

    // ******************************************************
    // ========== HAKI ========== 
    // ******************************************************

    public function haki()
    {
        return view('admin/manage-haki');
    }
    public function haki_save()
    {

        if (!$this->validate([
            'judul' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            return redirect()->to('/admin/haki');
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
        return redirect()->to('/admin');

        // dd($this->request->getVar());
    }
    public function haki_delete($id){
        $this->hakiModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin');
    }
    
    public function haki_edit($id) {
        helper('form');
        $haki = $this->hakiModel->where('id', $id)->first();
        if($haki == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'haki tidak ditemukan');
            return redirect()->to('/admin');
        }

        $data = ['oldHaki' => $haki];
        session()->setFlashdata('pesan', 'haki berhasil diperbarui');
        return view("admin/update-haki", $data);
    }

    public function handle_haki_edit($id) {
        if($this->hakiModel->where('id', $id)->first() == null) {
            // TODO: Make the flash data red in UI
            session()->setFlashdata('pesan', 'Haki tidak ditemukan');
            return redirect()->to('/admin');
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
        return redirect()->to('/admin');
        // dd($this->request->getVar());
    }
}
