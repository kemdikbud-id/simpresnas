<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Buku_profil extends Admin_Controller
{
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
}
