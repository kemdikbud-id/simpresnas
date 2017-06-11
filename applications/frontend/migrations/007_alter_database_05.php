<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database_05 extends CI_Migration
{
	function up()
	{
		// -------------------------------
		// Tabel Proposal
		// -------------------------------
		// add column
		echo "  > alter table proposal ... ";
		$this->dbforge->add_column('proposal', array(
			"COLUMN lama_kegiatan SMALLINT NOT NULL DEFAULT '0' AFTER kategori_id",
			"COLUMN biaya_total INT NOT NULL DEFAULT '0' AFTER lama_kegiatan",
			"COLUMN biaya_diusulkan INT NOT NULL DEFAULT '0' AFTER biaya_total",
			"COLUMN biaya_kontribusi_pt INT NOT NULL DEFAULT '0' AFTER biaya_diusulkan",
			"COLUMN biaya_kontribusi_umkm INT NOT NULL DEFAULT '0' AFTER biaya_kontribusi_pt",
			"COLUMN biaya_rekomendasi INT NOT NULL DEFAULT '0' AFTER biaya_kontribusi_umkm"
		));
		echo "OK\n";
		
		// -------------------------------
		// Tabel Plot Reviewer
		// -------------------------------
		// add column
		echo "  > add column plot_reviewer.komentar ... ";
		$this->dbforge->add_column('plot_reviewer', array("COLUMN komentar TEXT NULL AFTER nilai_reviewer"));
		echo "OK\n";
		
		// -------------------------------
		// Tabel Master Skor
		// -------------------------------
		echo "  > create table skor ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('skor SMALLINT NOT NULL');
		$this->dbforge->add_field('keterangan VARCHAR(15) NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->create_table('skor', TRUE);
		echo "OK\n";
		
		echo "  > insert initial data skor ... ";
		$this->db->insert_batch('skor', array(
			['skor' => 1, 'keterangan' => 'Buruk'],
			['skor' => 2, 'keterangan' => 'Sangat Kurang'],
			['skor' => 3, 'keterangan' => 'Kurang'],
			['skor' => 5, 'keterangan' => 'Cukup'],
			['skor' => 6, 'keterangan' => 'Baik'],
			['skor' => 7, 'keterangan' => 'Sangat Baik']
		));
		echo "OK\n";
	}
	
	function down()
	{
		// drop column
		echo "  > alter table rollback proposal ... ";
		$this->dbforge->drop_column('proposal', 'lama_kegiatan');
		$this->dbforge->drop_column('proposal', 'biaya_total');
		$this->dbforge->drop_column('proposal', 'biaya_diusulkan');
		$this->dbforge->drop_column('proposal', 'biaya_kontribusi_pt');
		$this->dbforge->drop_column('proposal', 'biaya_kontribusi_umkm');
		$this->dbforge->drop_column('proposal', 'biaya_rekomendasi');
		echo "OK\n";
		
		// drop column
		echo "  > drop column plot_reviewer.komentar ... ";
		$this->dbforge->drop_column('plot_reviewer', 'komentar');
		echo "OK\n";
		
		// drop table
		echo "  > drop table skor ... ";
		$this->dbforge->drop_table('skor');
		echo "OK\n";
	}
}