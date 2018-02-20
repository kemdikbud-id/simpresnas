<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge 
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_18 extends CI_Migration
{
	function up()
	{
		// Insert program workshop
		echo '  > insert into program ... ';
		$this->db->insert('program', ['id' => PROGRAM_WORKSHOP, 'nama_program' => 'Workshop Kewirausahaan', 'nama_program_singkat' => 'Workshop']);
		echo "OK\n";
		
		// Tabel lokasi workshop
		echo "  > create table lokasi_workshop ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('kegiatan_id INT NOT NULL');
		$this->dbforge->add_field('kota VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('tempat VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('waktu_pelaksanaan DATETIME NOT NULL');
		$this->dbforge->add_field('tgl_awal_registrasi DATETIME NOT NULL');
		$this->dbforge->add_field('tgl_akhir_registrasi DATETIME NOT NULL');
		$this->dbforge->add_field('FOREIGN KEY (kegiatan_id) REFERENCES kegiatan (id)');
		$this->dbforge->create_table('lokasi_workshop', TRUE);
		echo "OK\n";
		
		// Tabel peserta workshop
		echo "  > create table peserta_workshop ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('lokasi_workshop_id INT NOT NULL');
		$this->dbforge->add_field('nim VARCHAR(30) NOT NULL');
		$this->dbforge->add_field('nama VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('angkatan INT(4) NOT NULL');
		$this->dbforge->add_field('program_studi VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->add_field('FOREIGN KEY (lokasi_workshop_id) REFERENCES lokasi_workshop (id)');
		$this->dbforge->create_table('peserta_workshop', TRUE);
		echo "OK\n";
		
		// Tabel kegiatan
		echo "  > add column kegiatan (peserta_per_pt) ... ";
		$this->dbforge->add_column('kegiatan', array(
			'peserta_per_pt INT(4) NULL AFTER proposal_per_pt',
		));
		echo "OK\n";
	}
	
	function down()
	{
		// Delete program workshop
		echo '  > delete from program ... ';
		$this->db->delete('user', ['program_id' => PROGRAM_WORKSHOP]);
		$this->db->delete('request_user', ['program_id' => PROGRAM_WORKSHOP]);
		$this->db->query(
			"DELETE FROM peserta_workshop WHERE lokasi_workshop_id IN ( "
			. "SELECT id FROM lokasi_workshop WHERE kegiatan_id IN (SELECT id FROM kegiatan WHERE program_id = ".PROGRAM_WORKSHOP.") "
			. ")");
		$this->db->query("DELETE FROM lokasi_workshop WHERE kegiatan_id IN (SELECT id FROM kegiatan WHERE program_id = ".PROGRAM_WORKSHOP.")");
		$this->db->delete('kegiatan', ['program_id' => PROGRAM_WORKSHOP]);
		$this->db->delete('program', ['id' => PROGRAM_WORKSHOP]);
		echo "OK\n";
		
		// Delete tabel lokasi_workshop
		echo "  > drop table peserta_workshop ... ";
		$this->dbforge->drop_table('peserta_workshop', TRUE);
		echo "OK\n";
		
		// Delete tabel lokasi_workshop
		echo "  > drop table lokasi_workshop ... ";
		$this->dbforge->drop_table('lokasi_workshop', TRUE);
		echo "OK\n";
		
		// Delete column
		echo "  > drop column kegiatan (peserta_per_pt) ... ";
		$this->dbforge->drop_column('kegiatan', 'peserta_per_pt');
		echo "OK\n";
	}
}