<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Migration_Alter_database_23 extends CI_Migration
{
	public function up()
	{
		// Tabel download file
		echo "  > create table kelas_presentasi ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('kegiatan_id INT NOT NULL');
		$this->dbforge->add_field('nama_kelas VARCHAR(250) NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (kegiatan_id) REFERENCES kegiatan (id)');
		$this->dbforge->create_table('kelas_presentasi', TRUE);
		echo "OK\n";
		
		// Tabel proposal
		echo "  > alter table proposal ... ";
		$this->dbforge->add_column('proposal', [
			'kelas_presentasi_id INT NULL AFTER keterangan_ditolak',
			'CONSTRAINT fk_proposal_kelas FOREIGN KEY (kelas_presentasi_id) REFERENCES kelas_presentasi (id)'
		]);
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > drop foreign key proposal (kelas_presentasi_id) ... ";
		$this->db->query("alter table perguruan_tinggi drop foreign key fk_proposal_kelas");
		echo "OK\n";
		
		echo "  > drop column perguruan_tinggi (kelas_presentasi_id) ... ";
		$this->dbforge->drop_column('perguruan_tinggi', 'kelas_presentasi_id');
		echo "OK\n";
		
		echo "  > drop table kelas_presentasi ... ";
		$this->dbforge->drop_table('kelas_presentasi');
		echo "OK\n";
	}
}
