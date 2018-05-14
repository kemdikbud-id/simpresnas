<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $perguruan_tinggi_model 
 * @property Unit_kewirausahaan_model $unit_kewirausahaan_model
 * @property Profil_kelompok_model $profil_kelompok_model 
 * @property CI_Upload $upload 
 */
class Profil extends Frontend_Controller
{

	/**
	 * Max File Size : 5 MB
	 */
	const MAX_FILE_SIZE = 5242880;
	
	public function __construct()
	{
		parent::__construct();

		$this->check_credentials();

		$this->load->model(MODEL_PERGURUAN_TINGGI, 'perguruan_tinggi_model');
		$this->load->model(MODEL_UNIT_KEWIRAUSAHAAN, 'unit_kewirausahaan_model');
		$this->load->model(MODEL_PROFIL_KELOMPOK, 'profil_kelompok_model');
	}

	public function index()
	{
		// Ambil data perguruan tinggi
		$perguruan_tinggi = $this->perguruan_tinggi_model->get_single($this->session->perguruan_tinggi->id);
		
		// Build string alamat
		$alamat_array = [
			$perguruan_tinggi->alamat_jalan,
			$perguruan_tinggi->alamat_kecamatan,
			$perguruan_tinggi->alamat_kota,
			$perguruan_tinggi->alamat_provinsi
		];
		
		$alamat_pt = implode(', ', $alamat_array);
		
		// Ambil data unit kewirausahaan
		$unit_kewirausahaan = $this->unit_kewirausahaan_model->get_single_by_pt($perguruan_tinggi->id);
		
		// Ambil data profil kelompok usaha
		$pku_ristek_1 = $this->profil_kelompok_model->get_single_by_pt($perguruan_tinggi->id, 1, 1);
		$pku_ristek_2 = $this->profil_kelompok_model->get_single_by_pt($perguruan_tinggi->id, 1, 2);
		$pku_ristek_3 = $this->profil_kelompok_model->get_single_by_pt($perguruan_tinggi->id, 1, 3);
		$pku_nonristek_1 = $this->profil_kelompok_model->get_single_by_pt($perguruan_tinggi->id, 0, 1);
		$pku_nonristek_2 = $this->profil_kelompok_model->get_single_by_pt($perguruan_tinggi->id, 0, 2);
		$pku_nonristek_3 = $this->profil_kelompok_model->get_single_by_pt($perguruan_tinggi->id, 0, 3);
		
		// Assign ke template
		$this->smarty->assign('pt', $perguruan_tinggi);
		$this->smarty->assign('alamat_pt', $alamat_pt);
		$this->smarty->assign('uk', $unit_kewirausahaan);
		
		$this->smarty->assign('pku_ristek_1', $pku_ristek_1);
		$this->smarty->assign('pku_ristek_2', $pku_ristek_2);
		$this->smarty->assign('pku_ristek_3', $pku_ristek_3);
		$this->smarty->assign('pku_nonristek_1', $pku_nonristek_1);
		$this->smarty->assign('pku_nonristek_2', $pku_nonristek_2);
		$this->smarty->assign('pku_nonristek_3', $pku_nonristek_3);
		
		$this->smarty->display();
	}

	/**
	 * Update Unit Kewirausahaan
	 */
	public function update_uk()
	{
		// Ambil data perguruan tinggi
		$perguruan_tinggi = $this->perguruan_tinggi_model->get_single($this->session->perguruan_tinggi->id);
		
		// Ambil data unit kewirausahaan
		$unit_kewirausahaan = $this->unit_kewirausahaan_model->get_single_by_pt($perguruan_tinggi->id);

		if ($this->input->method() == 'post')
		{
			$upload_config = [
				'upload_path'	=> './upload/buku-profil/' . $perguruan_tinggi->npsn . '/',
				'allowed_types'	=> 'jpeg|jpg|bmp|png',
				'max_size'		=> $this::MAX_FILE_SIZE
			];

			$this->load->library('upload', $upload_config);

			// Create folder if not exist
			if ( ! file_exists($upload_config['upload_path'])) { mkdir($upload_config['upload_path']); }
			
			// Get $_POST variabel
			$post = $this->input->post();

			// Perguruan Tinggi
			$perguruan_tinggi->alamat_jalan				 = $post['alamat_jalan'];
			$perguruan_tinggi->alamat_kecamatan			 = $post['alamat_kecamatan'];
			$perguruan_tinggi->alamat_kota				 = $post['alamat_kota'];
			$perguruan_tinggi->alamat_provinsi			 = $post['alamat_provinsi'];
			$perguruan_tinggi->status_pt				 = isset($post['status_pt']) ? $post['status_pt'] : '';
			$perguruan_tinggi->jumlah_d1				 = $post['jumlah_d1'];
			$perguruan_tinggi->jumlah_d2				 = $post['jumlah_d2'];
			$perguruan_tinggi->jumlah_d3				 = $post['jumlah_d3'];
			$perguruan_tinggi->jumlah_d4s1				 = $post['jumlah_d4s1'];
			$perguruan_tinggi->ada_unit_kewirausahaan	 = isset($post['ada_unit_kewirausahaan']) ? $post['ada_unit_kewirausahaan'] : 0;

			// Unit Kewirausahaan
			$unit_kewirausahaan->perguruan_tinggi_id = $perguruan_tinggi->id;
			$unit_kewirausahaan->nama_unit_1		 = $post['nama_unit_1'];
			$unit_kewirausahaan->tahun_berdiri_1	 = !empty($post['tahun_berdiri_1']) ? $post['tahun_berdiri_1'] : NULL;
			$unit_kewirausahaan->alamat_1			 = $post['alamat_1'];
			$unit_kewirausahaan->nama_unit_2		 = $post['nama_unit_2'];
			$unit_kewirausahaan->tahun_berdiri_2	 = !empty($post['tahun_berdiri_2']) ? $post['tahun_berdiri_2'] : NULL;
			$unit_kewirausahaan->alamat_2			 = $post['alamat_2'];
			$unit_kewirausahaan->nama_unit_3		 = $post['nama_unit_3'];
			$unit_kewirausahaan->tahun_berdiri_3	 = !empty($post['tahun_berdiri_3']) ? $post['tahun_berdiri_3'] : NULL;
			$unit_kewirausahaan->alamat_3			 = $post['alamat_3'];
			$unit_kewirausahaan->jumlah_mentor		 = !empty($post['jumlah_mentor']) ? $post['jumlah_mentor'] : NULL;
			$unit_kewirausahaan->jumlah_binaan		 = !empty($post['jumlah_binaan']) ? $post['jumlah_binaan'] : NULL;
			$unit_kewirausahaan->pernah_kbmi		 = isset($post['pernah_kbmi']) ? $post['pernah_kbmi'] : NULL;
			$unit_kewirausahaan->pernah_workshop	 = isset($post['pernah_workshop']) ? $post['pernah_workshop'] : NULL;
			$unit_kewirausahaan->pernah_expo		 = isset($post['pernah_expo']) ? $post['pernah_expo'] : NULL;
			$unit_kewirausahaan->pernah_pbbt		 = isset($post['pernah_pbbt']) ? $post['pernah_pbbt'] : NULL;
			$unit_kewirausahaan->pernah_pelatihan	 = isset($post['pernah_pelatihan']) ? $post['pernah_pelatihan'] : NULL;
			$unit_kewirausahaan->bina_via_adhoc		 = isset($post['bina_via_adhoc']) ? $post['bina_via_adhoc'] : NULL;
			$unit_kewirausahaan->bentuk_unit		 = isset($post['bentuk_unit']) ? $post['bentuk_unit'] : NULL;
			$unit_kewirausahaan->bentuk_unit_ket	 = $post['bentuk_unit_ket'];
			$unit_kewirausahaan->ada_mk_kwu			 = isset($post['ada_mk_kwu']) ? $post['ada_mk_kwu'] : NULL;
			$unit_kewirausahaan->sks_mk_kwu			 = !empty($post['sks_mk_kwu']) ? $post['sks_mk_kwu'] : NULL;
			$unit_kewirausahaan->updated_at			 = date('Y-m-d H:i:s');
			
			// File unit wirausaha
			$file_upload_set = [
				'file_papan_nama_1', 'file_papan_nama_2', 'file_kegiatan_1', 'file_kegiatan_2',
			];
			
			foreach ($file_upload_set as $file_upload)
			{
				// Jika filenya ada
				if ( ! empty($_FILES[$file_upload]['name']))
				{
					// Proses upload
					if ($this->upload->do_upload($file_upload))
					{
						$upload_data = $this->upload->data();
						// Set nama file
						$unit_kewirausahaan->{$file_upload} = $upload_data['file_name'];
					}
					else
					{
						// tampilkan pesan gagal
						$this->fail_upload($this->upload->display_errors(), 'Pengisian Buku Profil Kewirausahaan', anchor('profil/update-uk', 'Kembali ke halaman update profil'));
					}	
				}
				
				// Jika terdeteksi perintah hapus
				if (isset($post[$file_upload.'_remove']))
				{
					if ($post[$file_upload.'_remove'] == '1')
					{
						// Hapus file
						@unlink('./upload/buku-profil/'.$perguruan_tinggi->npsn.'/'.$unit_kewirausahaan->{$file_upload});
						// Set nama file null
						$unit_kewirausahaan->{$file_upload} = NULL;
					}
				}
			}			
			
			// Start db transaction
			$this->db->trans_begin();
			
			$this->perguruan_tinggi_model->update($perguruan_tinggi, $perguruan_tinggi->id);
			$this->unit_kewirausahaan_model->update($unit_kewirausahaan, $unit_kewirausahaan->id);
			
			if ($this->db->trans_status() === TRUE)
			{
				$this->db->trans_commit();
				
				$this->session->set_flashdata('result', [
					'page_title' => 'Pengisian Buku Profil Kewirausahaan',
					'message' => 'Data berhasil disimpan',
					'link_1' => anchor('profil', 'Kembali ke halaman profil')
				]);
				
				redirect('alert/success');
				
				exit();
			}
		}
		
		
		
		$this->smarty->assign('pt', $perguruan_tinggi);
		$this->smarty->assign('uk', $unit_kewirausahaan);
		
		$this->smarty->display();
	}
	
	/**
	 * Update Kelompok Kewirausahaan didanai
	 * @param int $is_ristek
	 * @param int $kelompok_ke
	 */
	public function update_kelompok()
	{
		$get = $this->input->get();
		
		$is_kemenristek	= isset($get['kemenristek']) ? $get['kemenristek'] : 1;
		$kelompok_ke	= isset($get['kelompok']) ? $get['kelompok'] : 1;
		
		// Ambil data perguruan tinggi
		$perguruan_tinggi = $this->perguruan_tinggi_model->get_single($this->session->perguruan_tinggi->id);
		
		// Ambil data profil unit usaha
		$profil_kelompok_usaha = $this->profil_kelompok_model->get_single_by_pt($this->session->perguruan_tinggi->id, $is_kemenristek, $kelompok_ke);

		if ($this->input->method() == 'post')
		{
			$upload_config = [
				'upload_path'	=> './upload/buku-profil/' . $perguruan_tinggi->npsn . '/',
				'allowed_types'	=> 'jpeg|jpg|bmp|png',
				'max_size'		=> $this::MAX_FILE_SIZE
			];

			$this->load->library('upload', $upload_config);

			// Create folder if not exist
			if ( ! file_exists($upload_config['upload_path'])) { mkdir($upload_config['upload_path']); }
			
			// Get $_POST variabel
			$post = $this->input->post();
			
			// Profil Kelompok Usaha
			$profil_kelompok_usaha->perguruan_tinggi_id	 = $perguruan_tinggi->id;
			$profil_kelompok_usaha->is_kemenristek		 = $is_kemenristek;
			$profil_kelompok_usaha->kelompok_ke			 = $kelompok_ke;
			$profil_kelompok_usaha->nim_ketua			 = $post['nim_ketua'];
			$profil_kelompok_usaha->nama_ketua			 = $post['nama_ketua'];
			$profil_kelompok_usaha->prodi_ketua			 = $post['prodi_ketua'];
			$profil_kelompok_usaha->hp_ketua			 = $post['hp_ketua'];
			$profil_kelompok_usaha->email_ketua			 = $post['email_ketua'];
			$profil_kelompok_usaha->nim_anggota_1		 = $post['nim_anggota_1'];
			$profil_kelompok_usaha->nama_anggota_1		 = $post['nama_anggota_1'];
			$profil_kelompok_usaha->prodi_anggota_1		 = $post['prodi_anggota_1'];
			$profil_kelompok_usaha->hp_anggota_1		 = $post['hp_anggota_1'];
			$profil_kelompok_usaha->email_anggota_1		 = $post['email_anggota_1'];
			$profil_kelompok_usaha->nim_anggota_2		 = $post['nim_anggota_2'];
			$profil_kelompok_usaha->nama_anggota_2		 = $post['nama_anggota_2'];
			$profil_kelompok_usaha->prodi_anggota_2		 = $post['prodi_anggota_2'];
			$profil_kelompok_usaha->hp_anggota_2		 = $post['hp_anggota_2'];
			$profil_kelompok_usaha->email_anggota_2		 = $post['email_anggota_2'];
			$profil_kelompok_usaha->nim_anggota_3		 = $post['nim_anggota_3'];
			$profil_kelompok_usaha->nama_anggota_3		 = $post['nama_anggota_3'];
			$profil_kelompok_usaha->prodi_anggota_3		 = $post['prodi_anggota_3'];
			$profil_kelompok_usaha->hp_anggota_3		 = $post['hp_anggota_3'];
			$profil_kelompok_usaha->email_anggota_3		 = $post['email_anggota_3'];
			$profil_kelompok_usaha->nim_anggota_4		 = $post['nim_anggota_4'];
			$profil_kelompok_usaha->nama_anggota_4		 = $post['nama_anggota_4'];
			$profil_kelompok_usaha->prodi_anggota_4		 = $post['prodi_anggota_4'];
			$profil_kelompok_usaha->hp_anggota_4		 = $post['hp_anggota_4'];
			$profil_kelompok_usaha->email_anggota_4		 = $post['email_anggota_4'];
			$profil_kelompok_usaha->nim_anggota_5		 = $post['nim_anggota_5'];
			$profil_kelompok_usaha->nama_anggota_5		 = $post['nama_anggota_5'];
			$profil_kelompok_usaha->prodi_anggota_5		 = $post['prodi_anggota_5'];
			$profil_kelompok_usaha->hp_anggota_5		 = $post['hp_anggota_5'];
			$profil_kelompok_usaha->email_anggota_5		 = $post['email_anggota_5'];
			$profil_kelompok_usaha->kategori_id			 = $post['kategori_id'];
			$profil_kelompok_usaha->sumber_pendanaan	 = $post['sumber_pendanaan'];
			$profil_kelompok_usaha->nama_produk			 = $post['nama_produk'];
			$profil_kelompok_usaha->gambaran_bisnis		 = $post['gambaran_bisnis'];
			$profil_kelompok_usaha->capaian_bisnis		 = $post['capaian_bisnis'];
			$profil_kelompok_usaha->rencana_kedepan		 = $post['rencana_kedepan'];
			$profil_kelompok_usaha->prestasi_bisnis		 = $post['prestasi_bisnis'];
			$profil_kelompok_usaha->updated_at			 = date('Y-m-d H:i:s');
			
			// File profil kelompok usaha
			$file_upload2_set = [
				'file_anggota', 'file_produk'
			];
			
			foreach ($file_upload2_set as $file_upload)
			{
				// Jika filenya ada
				if ( ! empty($_FILES[$file_upload]['name']))
				{
					// File papan nama 1
					if ($this->upload->do_upload($file_upload))
					{
						$upload_data = $this->upload->data();						
						$profil_kelompok_usaha->{$file_upload} = $upload_data['file_name'];
					}
					else
					{
						$this->fail_upload($this->upload->display_errors(), 
							'Update Kelompok Mahasiswa Wirausaha yang didanai ' . ($is_kemenristek ? 'Ristekdikti' : 'Non-Ristekdikti') . ' - Kelompok ' . $kelompok_ke, 
							anchor('profil/update-kelompok?'.$_SERVER['QUERY_STRING'], 'Kembali ke halaman update kelompok'));
					}	
				}
				
				// Jika terdeteksi perintah hapus
				if (isset($post[$file_upload.'_remove']))
				{
					if ($post[$file_upload.'_remove'] == '1')
					{
						// Hapus file
						@unlink('./upload/buku-profil/'.$perguruan_tinggi->npsn.'/'.$profil_kelompok_usaha->{$file_upload});					
						// Set nama file null
						$profil_kelompok_usaha->{$file_upload} = NULL;
					}
				}
			}
			
			// Start db transaction
			$this->db->trans_begin();
			
			$this->perguruan_tinggi_model->update($perguruan_tinggi, $perguruan_tinggi->id);
			$this->profil_kelompok_model->update($profil_kelompok_usaha, $profil_kelompok_usaha->id);
			
			if ($this->db->trans_status() === TRUE)
			{
				$this->db->trans_commit();
				
				$this->session->set_flashdata('result', [
					'page_title' => 'Update Kelompok Mahasiswa Wirausaha yang didanai ' . ($is_kemenristek ? 'Ristekdikti' : 'Non-Ristekdikti') . ' - Kelompok ' . $kelompok_ke,
					'message' => 'Data berhasil disimpan',
					'link_1' => anchor('profil', 'Kembali ke halaman profil')
				]);
				
				redirect('alert/success');
				
				exit();
			}
		}
		
		// Assign ke template
		$this->smarty->assign('pt', $perguruan_tinggi);
		$this->smarty->assign('is_kemenristek', $is_kemenristek);
		$this->smarty->assign('kelompok', $kelompok_ke);
		$this->smarty->assign('pku', $profil_kelompok_usaha);
		
		// Jenis Kategori
		$kategori_set = $this->db->get_where('kategori', ['program_id' => PROGRAM_KBMI])->result();
		$this->smarty->assignForCombo('kategori_set', $kategori_set, 'id', 'nama_kategori');
		
		$this->smarty->display();
	}
	
	private function fail_upload($message, $page_title, $link_1)
	{
		$this->session->set_flashdata('result', [
			'page_title'	=> $page_title,
			'message'		=> 'Data gagal disimpan. ' . $message,
			'link_1'		=> $link_1
		]);

		redirect('alert/error');
		
		exit();
	}
	
}
