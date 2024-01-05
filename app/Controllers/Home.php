<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\PublikasiModel;
use App\Models\AbdimasModel;
use App\Models\PenelitianModel;
use App\Models\HakiModel;

class Home extends BaseController
{
	protected $dosenModel;
	protected $publikasiModel;
	protected $abdimasModel;
	protected $penelitianModel;
	protected $hakiModel;
	public function __construct()
	{
		$this->dosenModel = new DosenModel();
		$this->publikasiModel = new PublikasiModel();
		$this->abdimasModel = new AbdimasModel();
		$this->penelitianModel = new PenelitianModel();
		$this->hakiModel = new HakiModel();
	}


	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
			'page_title' => view('partials/page-title', ['title' => 'Dashboard', 'pagetitle' => 'Minible']),
			'title' => 'Daftar Dosen',
			'dosen' => $this->dosenModel->getDosen(),
			'count_publikasi' => $this->publikasiModel->getPublikasiTotal(),
			'count_abdimas' => $this->abdimasModel->getAbdimasTotal(),
			'count_penelitian' => $this->penelitianModel->getPenelitianTotal(),
			'count_haki' => $this->hakiModel->getHakiTotal(),
			'peningkatan_penelitian' => $this->penelitianModel->getPeningkatanPenelitian(),
			'peningkatan_publikasi' => $this->publikasiModel->getPeningkatanPublikasi(),
			'peningkatan_haki' => $this->hakiModel->getPeningkatanHaki(),
			'peningkatan_abdimas' => $this->hakiModel->getPeningkatanHaki(),
			'PublikasiYearNow_Inter' => $this->publikasiModel->getPublikasiYearNowInter(),
			'PublikasiYearNow_Nas' => $this->publikasiModel->getPublikasiYearNowNas(),
			'PublikasiYearNow_Pros' => $this->publikasiModel->getPublikasiYearNowPros(),
			'PublikasiYearNow_Pros_Nas' => $this->publikasiModel->getPublikasiYearNowProsNas(),
			// get total of the year
			'Publikasi_Inter' => $this->publikasiModel->getPublikasiInter(),
			'Publikasi_Nas' => $this->publikasiModel->getPublikasiNas(),
			'Publikasi_Pros' => $this->publikasiModel->getPublikasiPros(),
			'Publikasi_Pros_Nas' => $this->publikasiModel->getPublikasiProsNas(),
			// Penelitian 
			'Penelitian_Inter' => $this->penelitianModel->getPenelitianInter(),
			'Penelitian_Ekster' => $this->penelitianModel->getPenelitianEkste(),
			'Penelitian_Mand' => $this->penelitianModel->getPenelitianMand(),
			'Penelitian_kerjasamaPT' => $this->penelitianModel->getPenelitianKerjaSamaPT(),
			'Penelitian_Hilir' => $this->penelitianModel->getPenelitianHilir(),
			// // Top Publikasi 
			'top_publikasi' => $this->publikasiModel->getTopPublikasi(),

			'order_by_tahun_Asc' => $this->penelitianModel->getOrderByTahunAsc(),
			// Get Order Data by Jenis
			'getOrderByTahunAllJenis' => $this->publikasiModel->getOrderByTahunAllJenis(),
			// Top Penelitian 
			'top_penelitian' => $this->penelitianModel->getTopPenelitian(),
			// Order Data Penelitian 
			'order_by_tahun' => $this->abdimasModel->getOrderByTahun(),
			// Order Data Penelitian 
			'order_by_tahun_desc' => $this->abdimasModel->getOrderByTahunDesc(),
			'order_by_tahun_haki' => $this->hakiModel->getOrderByTahun(),
			'order_by_tahun_Asc_haki' => $this->hakiModel->getOrderByTahunAsc(),

		];
		return view('index', $data);
	}

	public function show_layouts_horizontal()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Horizontal']),
			'page_title' => view('partials/page-title', ['title' => 'Horizontal', 'pagetitle' => 'Layouts'])
		];
		return view('layouts-horizontal', $data);
	}

	public function show_layouts_vertical()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Vertical Layout']),
			'page_title' => view('partials/page-title', ['title' => 'Vertical', 'pagetitle' => 'Layouts'])
		];
		return view('layouts-vertical', $data);
	}

	public function show_layouts_dark_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dark Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Dark Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-dark-sidebar', $data);
	}

	public function show_layouts_hori_topbar_dark()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dark Topbar']),
			'page_title' => view('partials/page-title', ['title' => 'Dark Topbar', 'pagetitle' => 'Horizontal'])
		];
		return view('layouts-hori-topbar-dark', $data);
	}

	public function show_layouts_hori_boxed_width()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Boxed Width']),
			'page_title' => view('partials/page-title', ['title' => 'Boxed Width', 'pagetitle' => 'Horizontal'])
		];
		return view('layouts-hori-boxed-width', $data);
	}

	public function show_layouts_hori_preloader()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Preloader']),
			'page_title' => view('partials/page-title', ['title' => 'Preloader', 'pagetitle' => 'Horizontal'])
		];
		return view('layouts-hori-preloader', $data);
	}

	public function show_layouts_compact_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Compact Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Compact Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-compact-sidebar', $data);
	}

	public function show_layouts_icon_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Icon Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Icon Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-icon-sidebar', $data);
	}

	public function show_layouts_boxed()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Boxed Width']),
			'page_title' => view('partials/page-title', ['title' => 'Boxed Width', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-boxed', $data);
	}

	public function show_layouts_preloader()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Preloader']),
			'page_title' => view('partials/page-title', ['title' => 'Preloader', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-preloader', $data);
	}

	public function show_layouts_colored_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Colored Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Colored Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-colored-sidebar', $data);
	}
}
