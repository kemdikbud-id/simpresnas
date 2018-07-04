<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_result $result
 * @property CI_Input $input
 * @property Smarty_wrapper $smarty
 * @property Mpdf_wrapper $mpdf
 */
class Buku_profil extends CI_Controller
{
	const NAMA_FILE_1 = 'download/buku-profil-ristekdikti.pdf';
	const NAMA_FILE_2 = 'download/buku-profil-non-ristekdikti.pdf';
	const PROSES_GENERATE_PDF_1 = 'proses-generate-pdf-1';
	const PROSES_GENERATE_PDF_2 = 'proses-generate-pdf-2';
	
	public function index()
	{
		$sql = 
			"select
				pt.nama_pt, pt.status_pt, pt.jumlah_d1, pt.jumlah_d2, pt.jumlah_d3, pt.jumlah_d4s1,
				pt.ada_unit_kewirausahaan, uk.jumlah_binaan,
				uk.pernah_kbmi, uk.pernah_workshop, uk.pernah_pbbt, uk.pernah_expo, uk.pernah_pelatihan
			from perguruan_tinggi pt
			join unit_kewirausahaan uk on uk.perguruan_tinggi_id = pt.id
			join profil_kelompok_usaha pku on pku.perguruan_tinggi_id = pt.id";
		
		$data_set = $this->db->query($sql)->result();
		
		$this->smarty->assign('data_set', $data_set);
		$this->smarty->display();
	}
	
	public function download_excel()
	{
		$perguruan_tinggi_set = $this->db
			->select('pt.*')
			->from('perguruan_tinggi pt')
			->join('unit_kewirausahaan uk', 'uk.perguruan_tinggi_id = pt.id')
			->get()->result();
		
		$unit_kewirausahaan_set = $this->db
			->select('uk.*')
			->from('perguruan_tinggi pt')
			->join('unit_kewirausahaan uk', 'uk.perguruan_tinggi_id = pt.id')
			->get()->result();
		
		$profil_kelompok_usaha_set = $this->db
			->select('pku.*, k.nama_kategori')
			->from('perguruan_tinggi pt')
			->join('profil_kelompok_usaha pku', 'pku.perguruan_tinggi_id = pt.id')
			->join('kategori k', 'k.id = pku.kategori_id', 'LEFT')
			->get()->result();
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="data-buku-profil.xlsx"');
		
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		
		$sheet = $spreadsheet->getActiveSheet();
		
		// Daftar Kolom
		$sheet->setCellValue("A1", "Perguruan Tinggi");
		$sheet->setCellValue("B1", "Status");
		
		$sheet->setCellValue("C1", "Alamat"); $sheet->mergeCells("C1:F1");
		$sheet->setCellValue("C2", "Jalan");
		$sheet->setCellValue("D2", "Kecamatan");
		$sheet->setCellValue("E2", "Kabupaten");
		$sheet->setCellValue("F2", "Provinsi");
		
		$sheet->setCellValue("G1", "Jumlah Mahasiswa"); $sheet->mergeCells("G1:J1");
		$sheet->setCellValue("G2", "D1");
		$sheet->setCellValue("H2", "D2");
		$sheet->setCellValue("I2", "D3");
		$sheet->setCellValue("J2", "D4 / S1");
		$sheet->setCellValue("K1", "Unit Kwu");
		
		$sheet->setCellValue("L1", "Direktorat Kemahasiswaan");	$sheet->mergeCells("L1:N1");
		$sheet->setCellValue("L2", "Nama Unit");
		$sheet->setCellValue("M2", "Tahun Berdiri");
		$sheet->setCellValue("N2", "Alamat Unit / Telp / Email");
		
		$sheet->setCellValue("O1", "LPPM"); $sheet->mergeCells("O1:Q1");
		$sheet->setCellValue("O2", "Nama Unit");
		$sheet->setCellValue("P2", "Tahun Berdiri");
		$sheet->setCellValue("Q2", "Alamat Unit / Telp / Email");
		
		$sheet->setCellValue("R1", "Lainnya"); $sheet->mergeCells("R1:T1");
		$sheet->setCellValue("R2", "Nama Unit");
		$sheet->setCellValue("S2", "Tahun Berdiri");
		$sheet->setCellValue("T2", "Alamat Unit / Telp / Email");
		
		$sheet->setCellValue("U1", "Jml Mentor");
		$sheet->setCellValue("V1", "Jml Mhs Binaan (2016/2017)");
		
		$sheet->setCellValue("W1", "Kegiatan Kewirausahaan Belmawa"); $sheet->mergeCells("W1:AA1");
		$sheet->setCellValue("W2", "KBMI / PMW");
		$sheet->setCellValue("X2", "Workshop / Stadium Generale");
		$sheet->setCellValue("Y2", "PBBT / Co-OP");
		$sheet->setCellValue("Z2", "KMI Expo");
		$sheet->setCellValue("AA2", "Pelatihan Dosen");
		
		$sheet->setCellValue("AB1", "Pembinaan Lewat Adhoc");
		$sheet->setCellValue("AC1", "Bentuk Unit Usaha");
		$sheet->setCellValue("AD1", "Kapan Bentuk");
		$sheet->setCellValue("AE1", "MK Kwu");
		$sheet->setCellValue("AF1", "SKS MK");
		
		$sheet->setCellValue("AG1", "Ketua"); $sheet->mergeCells("AG1:AK1");
		$sheet->setCellValue("AG2", "Nama");
		$sheet->setCellValue("AH2", "NIM");
		$sheet->setCellValue("AI2", "Jurusan");
		$sheet->setCellValue("AJ2", "Email");
		$sheet->setCellValue("AK2", "HP");
		
		$sheet->setCellValue("AL1", "Anggota 1"); $sheet->mergeCells("AL1:AP1");
		$sheet->setCellValue("AL2", "Nama");
		$sheet->setCellValue("AM2", "NIM");
		$sheet->setCellValue("AN2", "Jurusan");
		$sheet->setCellValue("AO2", "Email");
		$sheet->setCellValue("AP2", "HP");
		
		$sheet->setCellValue("AQ1", "Anggota 2"); $sheet->mergeCells("AQ1:AU1");
		$sheet->setCellValue("AQ2", "Nama");
		$sheet->setCellValue("AR2", "NIM");
		$sheet->setCellValue("AS2", "Jurusan");
		$sheet->setCellValue("AT2", "Email");
		$sheet->setCellValue("AU2", "HP");
		
		$sheet->setCellValue("AV1", "Anggota 3"); $sheet->mergeCells("AV1:AZ1");
		$sheet->setCellValue("AV2", "Nama");
		$sheet->setCellValue("AW2", "NIM");
		$sheet->setCellValue("AX2", "Jurusan");
		$sheet->setCellValue("AY2", "Email");
		$sheet->setCellValue("AZ2", "HP");
		
		$sheet->setCellValue("BA1", "Anggota 4"); $sheet->mergeCells("BA1:BE1");
		$sheet->setCellValue("BA2", "Nama");
		$sheet->setCellValue("BB2", "NIM");
		$sheet->setCellValue("BC2", "Jurusan");
		$sheet->setCellValue("BD2", "Email");
		$sheet->setCellValue("BE2", "HP");
		
		$sheet->setCellValue("BF1", "Anggota 5"); $sheet->mergeCells("BF1:BJ1");
		$sheet->setCellValue("BF2", "Nama");
		$sheet->setCellValue("BG2", "NIM");
		$sheet->setCellValue("BH2", "Jurusan");
		$sheet->setCellValue("BI2", "Email");
		$sheet->setCellValue("BJ2", "HP");
		
		$sheet->setCellValue("BK1", "Bidang Bisnis");
		$sheet->setCellValue("BL1", "Nama Produk");
		$sheet->setCellValue("BM1", "Gambaran Bisnis");
		$sheet->setCellValue("BN1", "Capaian Bisnis");
		$sheet->setCellValue("BO1", "Rencana Kedepan");
		$sheet->setCellValue("BP1", "Prestasi Bisnis");
		
		// Data source
		for ($index = 0; $index < count($perguruan_tinggi_set); $index++)
		{
			$pt = $perguruan_tinggi_set[$index];
			$uk = $unit_kewirausahaan_set[$index];
			$pku = $profil_kelompok_usaha_set[$index];
			
			$i_cell = $index + 3;
			$sheet->setCellValue('A'.$i_cell, $pt->nama_pt);
			$sheet->setCellValue('B'.$i_cell, $pt->status_pt);
			$sheet->setCellValue('C'.$i_cell, $pt->alamat_jalan);
			$sheet->setCellValue('D'.$i_cell, $pt->alamat_kecamatan);
			$sheet->setCellValue('E'.$i_cell, $pt->alamat_kota);
			$sheet->setCellValue('F'.$i_cell, $pt->alamat_provinsi);
			$sheet->setCellValue('G'.$i_cell, $pt->jumlah_d1);
			$sheet->setCellValue('H'.$i_cell, $pt->jumlah_d2);
			$sheet->setCellValue('I'.$i_cell, $pt->jumlah_d3);
			$sheet->setCellValue('J'.$i_cell, $pt->jumlah_d4s1);
			$sheet->setCellValue('K'.$i_cell, $pt->ada_unit_kewirausahaan ? 'Ya' : 'Tidak');
			
			$sheet->setCellValue('L'.$i_cell, $uk->nama_unit_1);
			$sheet->setCellValue('M'.$i_cell, $uk->tahun_berdiri_1);
			$sheet->setCellValue('N'.$i_cell, $uk->alamat_1);
			
			$sheet->setCellValue('O'.$i_cell, $uk->nama_unit_2);
			$sheet->setCellValue('P'.$i_cell, $uk->tahun_berdiri_2);
			$sheet->setCellValue('Q'.$i_cell, $uk->alamat_2);
			
			$sheet->setCellValue('R'.$i_cell, $uk->nama_unit_3);
			$sheet->setCellValue('S'.$i_cell, $uk->tahun_berdiri_3);
			$sheet->setCellValue('T'.$i_cell, $uk->alamat_3);
			
			$sheet->setCellValue('U'.$i_cell, $uk->jumlah_mentor);
			$sheet->setCellValue('V'.$i_cell, $uk->jumlah_binaan);
			$sheet->setCellValue('W'.$i_cell, $uk->pernah_kbmi ? 'Ya' : 'Tidak');
			$sheet->setCellValue('X'.$i_cell, $uk->pernah_workshop ? 'Ya' : 'Tidak');
			$sheet->setCellValue('Y'.$i_cell, $uk->pernah_pbbt ? 'Ya' : 'Tidak');
			$sheet->setCellValue('Z'.$i_cell, $uk->pernah_expo ? 'Ya' : 'Tidak');
			$sheet->setCellValue('AA'.$i_cell, $uk->pernah_pelatihan ? 'Ya' : 'Tidak');
			
			$sheet->setCellValue('AB'.$i_cell, $uk->bina_via_adhoc ? 'Ya' : 'Tidak');
			$sheet->setCellValue('AC'.$i_cell, $uk->bentuk_unit ? 'Ya' : 'Tidak');
			$sheet->setCellValue('AD'.$i_cell, $uk->bentuk_unit_ket);
			$sheet->setCellValue('AE'.$i_cell, $uk->ada_mk_kwu ? 'Ya' : 'Tidak');
			$sheet->setCellValue('AF'.$i_cell, $uk->sks_mk_kwu);
			
			$sheet->setCellValue('AG'.$i_cell, $pku->nama_ketua);
			$sheet->setCellValue('AH'.$i_cell, $pku->nim_ketua);
			$sheet->setCellValue('AI'.$i_cell, $pku->prodi_ketua);
			$sheet->setCellValue('AJ'.$i_cell, $pku->email_ketua);
			$sheet->setCellValue('AK'.$i_cell, $pku->hp_ketua);
			
			$sheet->setCellValue('AL'.$i_cell, $pku->nama_anggota_1);
			$sheet->setCellValue('AM'.$i_cell, $pku->nim_anggota_1);
			$sheet->setCellValue('AN'.$i_cell, $pku->prodi_anggota_1);
			$sheet->setCellValue('AO'.$i_cell, $pku->email_anggota_1);
			$sheet->setCellValue('AP'.$i_cell, $pku->hp_anggota_1);
			
			$sheet->setCellValue('AQ'.$i_cell, $pku->nama_anggota_2);
			$sheet->setCellValue('AR'.$i_cell, $pku->nim_anggota_2);
			$sheet->setCellValue('AS'.$i_cell, $pku->prodi_anggota_2);
			$sheet->setCellValue('AT'.$i_cell, $pku->email_anggota_2);
			$sheet->setCellValue('AU'.$i_cell, $pku->hp_anggota_2);
			
			$sheet->setCellValue('AV'.$i_cell, $pku->nama_anggota_3);
			$sheet->setCellValue('AW'.$i_cell, $pku->nim_anggota_3);
			$sheet->setCellValue('AX'.$i_cell, $pku->prodi_anggota_3);
			$sheet->setCellValue('AY'.$i_cell, $pku->email_anggota_3);
			$sheet->setCellValue('AZ'.$i_cell, $pku->hp_anggota_3);
			
			$sheet->setCellValue('BA'.$i_cell, $pku->nama_anggota_4);
			$sheet->setCellValue('BB'.$i_cell, $pku->nim_anggota_4);
			$sheet->setCellValue('BC'.$i_cell, $pku->prodi_anggota_4);
			$sheet->setCellValue('BD'.$i_cell, $pku->email_anggota_4);
			$sheet->setCellValue('BE'.$i_cell, $pku->hp_anggota_4);
			
			$sheet->setCellValue('BF'.$i_cell, $pku->nama_anggota_5);
			$sheet->setCellValue('BG'.$i_cell, $pku->nim_anggota_5);
			$sheet->setCellValue('BH'.$i_cell, $pku->prodi_anggota_5);
			$sheet->setCellValue('BI'.$i_cell, $pku->email_anggota_5);
			$sheet->setCellValue('BJ'.$i_cell, $pku->hp_anggota_5);
			
			$sheet->setCellValue('BK'.$i_cell, $pku->nama_kategori);
			$sheet->setCellValue('BL'.$i_cell, $pku->nama_produk);
			$sheet->setCellValue('BM'.$i_cell, $pku->gambaran_bisnis);
			$sheet->setCellValue('BN'.$i_cell, $pku->capaian_bisnis);
			$sheet->setCellValue('BO'.$i_cell, $pku->rencana_kedepan);
			$sheet->setCellValue('BP'.$i_cell, $pku->prestasi_bisnis);
		}
		
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		
		// Output to client
		$writer->save("php://output");;
	}

	public function export_pdf()
	{
		// Generate Buku Profil Ristek dikti
		if (isset($_GET['generate-pdf-1']))
		{
			// Uncomment untuk mengaktifkan
			//exec("php " . FCPATH . "admin/index.php buku-profil generate-pdf 1 /dev/null 2>&1 &");
			
			redirect('buku-profil/export-pdf');
			return;
		}
		
		// Generate Buku Profil Ristek dikti
		if (isset($_GET['generate-pdf-2']))
		{
			// Uncomment untuk mengaktifkan
			//exec("php " . FCPATH . "admin/index.php buku-profil generate-pdf 2 /dev/null 2>&1 &");
			
			redirect('buku-profil/export-pdf');
			return;
		}
		
		$status_file_1 = FALSE;
		$status_file_2 = FALSE;
		$status_generate_1 = FALSE;
		$status_generate_2 = FALSE;
		
		if (file_exists(FCPATH . Buku_profil::NAMA_FILE_1))
		{
			$status_file_1 = TRUE;
		}
		
		if (file_exists(FCPATH . Buku_profil::NAMA_FILE_2))
		{
			$status_file_2 = TRUE;
		}
		
		if (file_exists(FCPATH . Buku_profil::PROSES_GENERATE_PDF_1))
		{
			$status_generate_1 = TRUE;
		}
		
		if (file_exists(FCPATH . Buku_profil::PROSES_GENERATE_PDF_2))
		{
			$status_generate_2 = TRUE;
		}
		
		$this->smarty->assign('status_file_1', $status_file_1);
		$this->smarty->assign('status_file_2', $status_file_2);
		$this->smarty->assign('status_generate_1', $status_generate_1);
		$this->smarty->assign('status_generate_2', $status_generate_2);
		$this->smarty->display();
	}
	
	/**
	 * @return PerguruanTinggi_model[] 
	 */
	private function get_all_pt($jenis)
	{
		// Ambil perguruan tinggi yg kelompok usaha dibiayai ristekdikti
		if ($jenis == 1)
		{
			return $this->db->query(
				"select pt.id, pt.npsn, pt.nama_pt, pt.alamat_jalan, pt.alamat_kecamatan, pt.alamat_kota, pt.alamat_provinsi
				from perguruan_tinggi pt
				where pt.id in (select perguruan_tinggi_id from profil_kelompok_usaha where nama_produk <> '' and is_kemenristek = 1)
				order by 2 asc")->result();
		}
		
		// Ambil perguruan tinggi yg kelompok usaha dibiayai non ristekdikti
		if ($jenis == 2)
		{
			return $this->db->query(
				"select pt.id, pt.npsn, pt.nama_pt, pt.alamat_jalan, pt.alamat_kecamatan, pt.alamat_kota, pt.alamat_provinsi
				from perguruan_tinggi pt
				where pt.id in (select perguruan_tinggi_id from profil_kelompok_usaha where nama_produk <> '' and is_kemenristek = 0)
				order by 2 asc")->result();
		}
	}
	
	/**
	 * @return Profil_kelompok_model[]
	 */
	private function get_all_pku_ristek()
	{
		return $this->db->query(
			"select pku.*, k.nama_kategori
			from profil_kelompok_usaha pku
			left join kategori k on k.id = pku.kategori_id
			where pku.is_kemenristek = 1
			order by perguruan_tinggi_id asc, is_kemenristek desc, kelompok_ke asc")->result();
	}
	
	/**
	 * @return Profil_kelompok_model[]
	 */
	private function get_all_pku_nonristek()
	{
		return $this->db->query(
			"select pku.*, k.nama_kategori
			from profil_kelompok_usaha pku
			left join kategori k on k.id = pku.kategori_id
			where pku.is_kemenristek = 0
			order by perguruan_tinggi_id asc, is_kemenristek desc, kelompok_ke asc")->result();
	}

	public function generate_pdf($jenis)
	{
		$pt_set = $this->get_all_pt($jenis);
		
		if ($jenis == 1)
		{
			$handle = fopen(FCPATH . Buku_profil::PROSES_GENERATE_PDF_1, 'w');
			fclose($handle);
			
			$pku_ristek_set = $this->get_all_pku_ristek();
		}
		
		if ($jenis == 2)
		{
			$handle = fopen(FCPATH . Buku_profil::PROSES_GENERATE_PDF_2, 'w');
			fclose($handle);
			
			$pku_ristek_set = $this->get_all_pku_nonristek();
		}
		
		$css = file_get_contents(APPPATH . 'views/buku_profil/download_pdf.css');
		$this->mpdf->WriteHTML($css, 1);
		
		$n = 0;
		foreach ($pt_set as $pt)
		{	
			$this->mpdf->AddPage('', '', '', '', '', 25, 20, 20, 20);
			
			$this->mpdf->WriteHTML("<bookmark content=\"{$pt->nama_pt}\" level=\"0\"/><h1>{$pt->nama_pt}</h1>");
			$this->mpdf->WriteHTML("<h4>{$pt->alamat_jalan}, {$pt->alamat_kecamatan}, {$pt->alamat_kota}, {$pt->alamat_provinsi}</h4>");
			
			$this->mpdf->WriteHTML("<h3>WIRAUSAHA YANG DIDANAI RISTEKDIKTI</h3>");
						
			foreach ($pku_ristek_set as $pku)
			{
				// Skip jika tidak sama
				if ($pku->perguruan_tinggi_id != $pt->id)
				{
					continue;
				}
				
				// Halaman baru
				if ($pku->kelompok_ke > 1)
				{
					$this->mpdf->AddPage();
				}
				
				$html = '<table>';
				$html .= '	<tbody>';
				$html .= '		<tr>';
				$html .= '			<td style="width: 50%; border: 1px solid black">';
				$html .= '				<b>Bidang Bisnis</b><br/>' . htmlentities($pku->nama_kategori) . '<br/><br/>';
				$html .= '				<b>Nama Produk</b><br/>' . htmlentities($pku->nama_produk) . '<br/><br/>';
				$html .= '				<b>Sumber Pendanaan</b><br/>' . htmlentities($pku->sumber_pendanaan) . '<br/><br/>';
				$html .= '			</td>';
				$html .= '			<td style="width: 50%; border: 1px solid black">';
				$html .= '				<b>Owner</b>';
				
				$html .= '				<table><tbody>';
				
				$html .= '					<tr><td style="width: 15px">1.</td><td>';
				$html .=
					htmlentities($pku->nama_ketua) . '<br/>' . htmlentities($pku->nim_ketua) . 
					($pku->prodi_ketua != '' ? '<br/>' . htmlentities($pku->prodi_ketua) : '') . 
					($pku->email_ketua != '' ? '<br/>' . '<a href="'.$pku->email_ketua.'">' . htmlentities($pku->email_ketua) . '</a>' : '') .
					($pku->hp_ketua != '' ? '<br/>' . htmlentities($pku->hp_ketua) : '');
				$html .= '					</td></tr>';
				
				if ($pku->nama_anggota_1 != '')
				{
					$html .= '					<tr><td style="width: 15px">2.</td><td>';
					$html .=
						htmlentities($pku->nama_anggota_1) . '<br/>' . htmlentities($pku->nim_anggota_1) . 
						($pku->prodi_anggota_1 != '' ? '<br/>' . htmlentities($pku->prodi_anggota_1) : '') . 
						($pku->email_anggota_1 != '' ? '<br/>' . '<a href="'.$pku->email_anggota_1.'">' . htmlentities($pku->email_anggota_1) . '</a>' : '') .
						($pku->hp_anggota_1 != '' ? '<br/>' . htmlentities($pku->hp_anggota_1) : '');
					$html .= '					</td></tr>';
				}
				
				if ($pku->nama_anggota_2 != '')
				{
					$html .= '					<tr><td style="width: 15px">3.</td><td>';
					$html .=
						htmlentities($pku->nama_anggota_2) . '<br/>' . htmlentities($pku->nim_anggota_2) . 
						($pku->prodi_anggota_2 != '' ? '<br/>' . htmlentities($pku->prodi_anggota_2) : '') . 
						($pku->email_anggota_2 != '' ? '<br/>' . '<a href="'.$pku->email_anggota_2.'">' . htmlentities($pku->email_anggota_2) . '</a>' : '') .
						($pku->hp_anggota_2 != '' ? '<br/>' . htmlentities($pku->hp_anggota_2) : '');
					$html .= '					</td></tr>';
				}
				
				if ($pku->nama_anggota_3 != '')
				{
					$html .= '					<tr><td style="width: 15px">4.</td><td>';
					$html .=
						htmlentities($pku->nama_anggota_3) . '<br/>' . htmlentities($pku->nim_anggota_3) . 
						($pku->prodi_anggota_3 != '' ? '<br/>' . htmlentities($pku->prodi_anggota_3) : '') . 
						($pku->email_anggota_3 != '' ? '<br/>' . '<a href="'.$pku->email_anggota_3.'">' . htmlentities($pku->email_anggota_3) . '</a>' : '') .
						($pku->hp_anggota_3 != '' ? '<br/>' . htmlentities($pku->hp_anggota_3) : '');
					$html .= '					</td></tr>';
				}
				
				if ($pku->nama_anggota_4 != '')
				{
					$html .= '					<tr><td style="width: 15px">5.</td><td>';
					$html .=
						htmlentities($pku->nama_anggota_4) . '<br/>' . htmlentities($pku->nim_anggota_4) . 
						($pku->prodi_anggota_4 != '' ? '<br/>' . htmlentities($pku->prodi_anggota_4) : '') . 
						($pku->email_anggota_4 != '' ? '<br/>' . '<a href="'.$pku->email_anggota_4.'">' . htmlentities($pku->email_anggota_4) . '</a>' : '') .
						($pku->hp_anggota_4 != '' ? '<br/>' . htmlentities($pku->hp_anggota_4) : '');
					$html .= '					</td></tr>';
				}
				
				$html .= '				</tbody></table>';
				
				$html .= '			</td>';
				$html .= '		</tr>';
				$html .= '	</tbody>';
				$html .= '</table><br/>';
				
				$this->mpdf->WriteHTML($html);
				
				$html = '<table>';
				$html .= '	<tbody>';
				$html .= '		<tr>';
				$html .= '			<td class="deskripsi" style="border: 1px solid orange">';
				$html .= '				<b>Gambaran Bisnis</b>';
				$html .= '				<p>' . htmlentities($pku->gambaran_bisnis) . '</p>';
				$html .= '			</td>';
				$html .= '		</tr>';
				$html .= '	</tbody>';
				$html .= '</table><br/>';
				$html .= '<table>';
				$html .= '	<tbody>';
				$html .= '		<tr>';
				$html .= '			<td class="deskripsi" style="border: 1px solid blue">';
				$html .= '				<b>Capaian Bisnis</b>';
				$html .= '				<p>' . htmlentities($pku->capaian_bisnis) . '</p>';
				$html .= '			</td>';
				$html .= '		</tr>';
				$html .= '	</tbody>';
				$html .= '</table><br/>';
				$html .= '<table>';
				$html .= '	<tbody>';
				$html .= '		<tr>';
				$html .= '			<td class="deskripsi" style="border: 1px solid blue">';
				$html .= '				<b>Rencana Kedepan</b>';
				$html .= '				<p>' . htmlentities($pku->rencana_kedepan) . '</p>';
				$html .= '			</td>';
				$html .= '		</tr>';
				$html .= '	</tbody>';
				$html .= '</table><br/>';
				$html .= '<table>';
				$html .= '	<tbody>';
				$html .= '		<tr>';
				$html .= '			<td class="deskripsi" style="border: 1px solid orange">';
				$html .= '				<b>Prestasi Bisnis</b>';
				$html .= '				<p>' . htmlentities($pku->prestasi_bisnis) . '</p>';
				$html .= '			</td>';
				$html .= '		</tr>';
				$html .= '	</tbody>';
				$html .= '</table><br/>';
				$html .= '<table>';
				$html .= '	<tbody>';
				$html .= '		<tr>';
				$html .= '			<td class="deskripsi" style="border: 1px solid green">';
				$html .= '				<p><b>Foto Usaha / Produk</b></p>';
				
				if (file_exists('../upload/buku-profil/'.$pt->npsn.'/'.$pku->file_produk))
				{
					$html .= '			<p><img src="'.'../upload/buku-profil/'.$pt->npsn.'/'.$pku->file_produk.'" alt="" /></p>';
				}
				
				$html .= '				<p><b>Foto Anggota</b></p>';
				
				if (file_exists('../upload/buku-profil/'.$pt->npsn.'/'.$pku->file_anggota))
				{
					$html .= '			<p><img src="'.'../upload/buku-profil/'.$pt->npsn.'/'.$pku->file_anggota.'" alt="" /></p>';
				}
				
				$html .= '			</td>';
				$html .= '		</tr>';
				$html .= '	</tbody>';
				$html .= '</table>';
				
				$this->mpdf->WriteHTML($html);
			}
			
			$n++;
			
		}
		
		if ( ! file_exists(FCPATH . 'download/'))
		{
			mkdir(FCPATH . 'download/');
		}
		
		if ($jenis == 1)
		{
			$this->mpdf->Output(FCPATH . Buku_profil::NAMA_FILE_1);

			unlink(FCPATH . Buku_profil::PROSES_GENERATE_PDF_1);
		}
		
		if ($jenis == 2)
		{
			$this->mpdf->Output(FCPATH . Buku_profil::NAMA_FILE_2);
			
			unlink(FCPATH . Buku_profil::PROSES_GENERATE_PDF_2);
		}
	}
}
