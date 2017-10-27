<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_alter_database_11 extends CI_Migration
{
	function up()
	{
		// add column
		echo "  > alter table hasil_penilaian ... ";
		$this->dbforge->add_column('hasil_penilaian', array(
			"COLUMN komentar TEXT NULL AFTER nilai",
		));
		echo "OK\n";
		
		// update data tahapan
		echo "  > update data tahapan ... ";
		$this->db->query("update tahapan set tahapan = 'Monitoring dan Evaluasi', updated_at = now() where tahapan = 'Didanai'");
		echo "OK\n";
		
		// insert data komponen penilaian monev
		echo "  > insert into komponen_penilaian (kegiatan tahun = 2017) ... ";
		// Penilaian KBMI 2017 Monev
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 2, 'urutan' => 1, 'kriteria' => "Keunggulan Produk", 'bobot' => 15]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 2, 'urutan' => 2, 'kriteria' => "Pelayanan pelanggan dan pemasaran", 'bobot' => 25]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 2, 'urutan' => 3, 'kriteria' => "Keuangan", 'bobot' => 25]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 2, 'urutan' => 4, 'kriteria' => "Manajemen Usaha", 'bobot' => 20]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 2, 'urutan' => 5, 'kriteria' => "Potensi Pengembangan Usaha", 'bobot' => 15]);
		echo "OK\n";
	}
	
	function down()
	{
		// drop column
		echo "  > alter table rollback hasil_penilaian ... ";
		$this->dbforge->drop_column('hasil_penilaian', 'komentar');
		echo "OK\n";
	}
}
