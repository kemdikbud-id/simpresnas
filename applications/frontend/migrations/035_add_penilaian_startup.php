<?php

/**
 * @author Fathoni
 * @property CI_DB_mysqli_driver $db
 */
class Migration_Add_penilaian_startup extends CI_Migration
{
	function up()
	{
		// insert data komponen penilaian
		echo "  > insert into komponen_penilaian (program startup 2019) ... ";
		$kegiatan = $this->db->select('id')->from('kegiatan')->where(['program_id' => PROGRAM_STARTUP, 'tahun' => 2019])->get()->first_row();
		$this->db->insert('komponen_penilaian', [
			'kegiatan_id' => $kegiatan->id, 
			'tahapan_id' => TAHAPAN_EVALUASI, 
			'urutan' => 1, 
			'kriteria' => "<b>VIDEO</b>\n"
			. "1. Menginformasikan dengan jelas mengenai produk/jasa dan bisnisnya.\n"
			. "2. Kecakapan penyampaian penyampaian Informasi.\n3. Visualisasi Video",
			'bobot' => 15
		]);
		$this->db->insert('komponen_penilaian', [
			'kegiatan_id' => $kegiatan->id, 
			'tahapan_id' => TAHAPAN_EVALUASI, 
			'urutan' => 2, 
			'kriteria' => "<b>ISU YANG DIANGKAT / KEBUTUHAN PASAR DAN SOLUSI YANG DITAWARKAN PRODUK ATAU JASA</b>\n"
			. "1. Menjelaskan tentang isu/masalah yang diangkat, solusi yang saat ini sudah ada, mengapa solusi yang sudah ada belum menyelesaikan masalah.\n"
			. "2. Menjelaskan solusi yang ditawarkan benar-benar menyelesaikan isu/masalah, dan menjelaskan value proposition yang  unik dari produk  atau jasa tersebut",
			'bobot' => 25
		]);
		$this->db->insert('komponen_penilaian', [
			'kegiatan_id' => $kegiatan->id, 
			'tahapan_id' => TAHAPAN_EVALUASI, 
			'urutan' => 3, 
			'kriteria' => "<b>TARGET CUSTOMER & STAKHOLDER, MARKET SIZING, KOMPETISI DAN POSISI PESAING</b>\n"
			. "1. Menjelaskan siapa target customer anda (ada pengkategorian missal usia, dan berapa perkiraan jumlah customernya). Siapa saja stakeholder dalam bisnis anda\n"
			. "2. Menjelaskan berapa populasi keseluruhan, populasi yang berada di pasar yang dituju, populasi yang masuk di segmen target, populasi yang menjadi market share yang bisa dikuasai. Menjelaskan siapa pesaing langsung dan tidak langsung, posisi anda dengan pesaing, dan bagaimana anda memenangkan persaingan.",
			'bobot' => 20
		]);
		$this->db->insert('komponen_penilaian', [
			'kegiatan_id' => $kegiatan->id, 
			'tahapan_id' => TAHAPAN_EVALUASI, 
			'urutan' => 4, 
			'kriteria' => "<b>STRATEGI, TARGET DAN PEMASARAN</b>\n"
			. "1. Menjelaskan strategi yang akan dijalankan dalam kurun waktu tertentu missal periode bulanan/triwulan/semester\n"
			. "2. Menjelaskan target yang ingin dicapai (2-3 tahun kedepan), milestone bulanan/triwulan\n"
			. "3.	Menjelaskan strategi untuk menarik konsumen yang belum mengenal, menjadikan potensial konsumen menjadi konsumen tetap, dan mempertahankan konsumen tetap",
			'bobot' => 10
		]);
		$this->db->insert('komponen_penilaian', [
			'kegiatan_id' => $kegiatan->id, 
			'tahapan_id' => TAHAPAN_EVALUASI, 
			'urutan' => 5, 
			'kriteria' => "<b>KEBUTUHAN DAN ALOKASI DANA, SUMBER PENDAPATAN, DAN PROYEKSI KEUANGAN</b>\n"
			. "1.	Menjelaskan apa saja kebutuhan dana (missal Pemasaran, Modal Kerja, Rekruitmen, Pengembangan Produk, dll) dan berapa nilanya. Berapa modal yang sudah dikeluarkan sendiri.\n"
			. "2.	Menjelaskan Proyeksi Pendapatan, COGS/HPP, Total Beban Operasional dan Laba Bersih (2-5 tahun YAD)\n"
			. "3.	Menjelaskan proyeksi produk/jasa yang akan terjual, berapa pendapatannya, laba kotor, beban-beban dan Laba bersih (3-5 tahun)",
			'bobot' => 15
		]);
		$this->db->insert('komponen_penilaian', [
			'kegiatan_id' => $kegiatan->id, 
			'tahapan_id' => TAHAPAN_EVALUASI, 
			'urutan' => 6, 
			'kriteria' => "<b>SDM/TEAM</b>\n"
			. "Menjelaskan keahlian masing-masing anggota tim yang saling melengkapi sesuai dengan kebutuhan pelaksanaan bisnis.",
			'bobot' => 15
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > delete komponen_penilaian (program startup 2019) ... ";
		$kegiatan = $this->db->select('id')->from('kegiatan')->where(['program_id' => PROGRAM_STARTUP, 'tahun' => 2019])->get()->first_row();
		$this->db->delete('komponen_penilaian', ['kegiatan_id' => $kegiatan->id, 'tahapan_id' => TAHAPAN_EVALUASI]);
		echo "OK\n";
	}
}
