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
            'title' => 'Daftar Dosen',
            'dosen' => $this->dosenModel->getDosen(),
            'all_publikasi' => $this->publikasiModel->getAllPublikasi(),
            'all_penelitian' => $this->penelitianModel->getAllPenelitian(),
            'all_publikasi' => $this->publikasiModel->getAllPublikasi(),
            'all_abdimas' => $this->abdimasModel->getAllAbdimas(),
            'all_haki' => $this->hakiModel->getAllHaki(),
        ];
        return view('admin/index', $data);
    }

    // ========== PUBLIKASI ========== 

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
            'judul_publikasi' => 'required'
        ])) {
            $validation = \config\Services::validation();
            // dd($validation);

            return redirect()->to('/admin/publikasi')->withInput()->with('validation', $validation);
        }



        $this->publikasiModel->save([
            'judul_publikasi' => $this->request->getVar('judul'),
            'tahun' => $this->request->getVar('tahun'),
            'penulis_1' => $this->request->getVar('penulis_1'),
            'penulis_2' => $this->request->getVar('penulis_2'),
            'penulis_3' => $this->request->getVar('penulis_3'),
            'penulis_4' => $this->request->getVar('penulis_4'),
            'penulis_5' => $this->request->getVar('penulis_5'),
            'penulis_6' => $this->request->getVar('penulis_6'),
            'lab_riset' => $this->request->getVar('penulis_all'),
            'penulis_all' => $this->request->getVar('semua_penulis'),
            'institusi_mitra' => $this->request->getVar('mitra'),
            'jenis' => $this->request->getVar('jenis'),
            'nama_journal_conf' => $this->request->getVar('jurnal_konferensi'),
            'akreditasi_journal_conf' => $this->request->getVar('akreditasi'),
            'link_artikel' => $this->request->getVar('link'),
            'luaran_riset_abdimas' => $this->request->getVar('luaran')
        ]);
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin');
        // dd($this->request->getVar());
    }

    // ========== PENELITIAN ========== 

    public function penelitian()
    {

        return view('admin/manage-penelitian');
    }
    public function penelitian_save()
    {
        if (!$this->validate([
            'judul_penelitian' => 'required',
            'tahun' => 'required',
            'jenis' => 'required'
        ])) {
            return redirect()->to('/admin/penelitian');
        }

        $this->penelitianModel->save([
            'tahun' => $this->request->getVar('tahun'),
            'jenis' => $this->request->getVar('jenis'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'judul_penelitian' => $this->request->getVar('judul'),
            'status' => $this->request->getVar('status'),
            'ketua_peneliti' => $this->request->getVar('ketua'),
            'anggota_peneliti_1' => $this->request->getVar('anggota_1'),
            'anggota_peneliti_2' => $this->request->getVar('anggota_2'),
            'anggota_peneliti_3' => $this->request->getVar('anggota_3'),
            'anggota_peneliti_4' => $this->request->getVar('anggota_4'),
            'mitra' => $this->request->getVar('mitra'),
            'lab_riset' => $this->request->getVar('lab_riset'),
            'kesesuaian_roadmap' => $this->request->getVar('roadmap'),
            'catatan_rekomendasi' => $this->request->getVar('rekomendasi'),
            'luaran' => $this->request->getVar('riset'),
            'mk_relevan' => $this->request->getVar('mk_relevan'),
            'tgl_pengesahan' => $this->request->getVar('tgl_pengesahan')
        ]);

        // dd($this->request->getVar());
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin');
    }


    // ========== ABDIMAS ========== 

    public function abdimas()
    {
        return view('admin/manage-abdimas');
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
            'tahun' => $this->request->getVar('tahun'),
            'jenis' => $this->request->getVar('jenus'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'judul' => $this->request->getVar('judul'),
            'status' => $this->request->getVar('status'),
            'lab_riset' => $this->request->getVar('lab_riset'),
            'ketua' => $this->request->getVar('ketua'),
            'anggota_1' => $this->request->getVar('anggota_1'),
            'anggota_2' => $this->request->getVar('anggota_2'),
            'anggota_3' => $this->request->getVar('anggota_3'),
            'anggota_4' => $this->request->getVar('anggota_4'),
            'anggota_5' => $this->request->getVar('anggota_5'),
            // 'mitra' => $this->request->getVar('link'),
            'alamat_mitra' => $this->request->getVar('alamat_mitra'),
            'kesesuaian_roadmap' => $this->request->getVar('roadmp'),
            'permasalahan_masy' => $this->request->getVar('permasalahan_masyarakat'),
            'solusi' => $this->request->getVar('solusi'),
            'catatan' => $this->request->getVar('catatan'),
            'luaran' => $this->request->getVar('luaran'),
            'tgl_pengesahan' => $this->request->getVar('tgl_peengesahan')
        ]);


        // dd($this->request->getVar());
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin');
    }

    // ========== HAKI ========== 

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
            'tahun' => $this->request->getVar('tahun'),
            'ketua' => $this->request->getVar('ketua'),
            'anggota_1' => $this->request->getVar('anggota_1'),
            'anggota_2' => $this->request->getVar('anggota_2'),
            'anggota_3' => $this->request->getVar('anggota_3'),
            'anggota_4' => $this->request->getVar('anggota_4'),
            'anggota_5' => $this->request->getVar('anggota_5'),
            'anggota_6' => $this->request->getVar('anggota_6'),
            'anggota_7' => $this->request->getVar('anggota_7'),
            'anggota_8' => $this->request->getVar('anggota_8'),
            'anggota_9' => $this->request->getVar('anggota_9'),
            'jenis' => $this->request->getVar('jenis'),
            'jenis_ciptaan' => $this->request->getVar('ciptaan'),
            'judul' => $this->request->getVar('roadmp'),
            'jenis' => $this->request->getVar('judul_haki'),
            'abstrak' => $this->request->getVar('abstrak'),
            'no_pendaftaran' => $this->request->getVar('no_pendaftaran'),
            'no_sertifikat' => $this->request->getVar('no_sertifikat'),
            'catatan' => $this->request->getVar('catatan')
        ]);
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin');

        // dd($this->request->getVar());
    }
}
