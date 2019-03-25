<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_DB_forge $dbforge 
 */
class Migration_Alter_database_26 extends CI_Migration
{
	function up()
	{
		echo "  > alter table perguruan_tinggi ... ";
		$this->dbforge->add_column('perguruan_tinggi', [
			'id_institusi VARCHAR(36) NULL COMMENT \'id institusi dari forlap p\'',
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP',
			'CONSTRAINT uc_npsn UNIQUE (npsn)'
		]);
		echo "OK\n";
		
		echo "  > create table program_studi ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('kode_prodi VARCHAR(6) NOT NULL');
		$this->dbforge->add_field('nama VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('id_pdpt VARCHAR(36) NULL COMMENT \'id prodi dari forlap p\'');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->create_table('program_studi', TRUE);
		echo "OK\n";
		
		echo "  > create table mahasiswa ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('nim VARCHAR(30) NOT NULL');
		$this->dbforge->add_field('nama VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('program_studi_id INT NOT NULL');
		$this->dbforge->add_field('angkatan INT(4) NOT NULL');
		$this->dbforge->add_field('email VARCHAR(254) NULL');
		$this->dbforge->add_field('no_hp VARCHAR(30) NULL');
		$this->dbforge->add_field('id_pdpt VARCHAR(36) NULL COMMENT \'id mahasiswa dari forlap p\'');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->add_field('FOREIGN KEY (program_studi_id) REFERENCES program_studi (id)');
		$this->dbforge->create_table('mahasiswa', TRUE);
		echo "OK\n";
		
		echo "  > create table dosen ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('nidn VARCHAR(30) NOT NULL');
		$this->dbforge->add_field('nama VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('gelar_depan VARCHAR(20) NULL');
		$this->dbforge->add_field('gelar_belakang VARCHAR(20) NULL');
		$this->dbforge->add_field('program_studi_id INT NOT NULL');
		$this->dbforge->add_field('id_pdpt VARCHAR(36) NULL COMMENT \'id mahasiswa dari forlap p\'');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->add_field('FOREIGN KEY (program_studi_id) REFERENCES program_studi (id)');
		$this->dbforge->create_table('dosen', TRUE);
		echo "OK\n";
	
		echo "  > alter table user ... ";
		$this->dbforge->modify_column('user', 'username VARCHAR(50) NOT NULL');
		$this->dbforge->modify_column('user', 'tipe_user INT(2) NOT NULL COMMENT \'99-Administrator; 1-User PT; 2-User Reviewer; 3-Verifikator; 4-Mahasiswa\'');
		$this->dbforge->add_column('user', [
			'mahasiswa_id INT NULL AFTER reviewer_id',
			'CONSTRAINT fk_user_mahasiswa FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa (id)'
		]);
		echo "OK\n";
		
		echo "  > alter table anggota_proposal ... ";
		$this->dbforge->add_column('anggota_proposal', [
			'mahasiswa_id INT NULL AFTER no_urut',
			'CONSTRAINT fk_anggota_prop_mahasiswa FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa (id)'
		]);
		echo "OK\n";
		
		echo "  > alter table proposal ... ";
		$this->dbforge->add_column('proposal', [
			'dosen_id INT NULL AFTER nama_anggota_5',
			'CONSTRAINT fk_proposal_dosen FOREIGN KEY (dosen_id) REFERENCES dosen (id)'
		]);
		$this->dbforge->modify_column('proposal', 'kategori_id INT NULL');
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > alter table proposal ... ";
		$this->dbforge->modify_column('proposal', 'kategori_id INT NOT NULL');
		$this->db->query('ALTER TABLE proposal DROP FOREIGN KEY fk_proposal_dosen');
		$this->dbforge->drop_column('proposal', 'dosen_id');
		echo "OK\n";
		
		echo "  > drop foreign key anggota_proposal (fk_anggota_prop_mahasiswa) ... ";
		$this->db->query('ALTER TABLE anggota_proposal DROP FOREIGN KEY fk_anggota_prop_mahasiswa');
		echo "OK\n";
		
		echo "  > drop column anggota_proposal (mahasiswa_id) ... ";
		$this->dbforge->drop_column('anggota_proposal', 'mahasiswa_id');
		echo "OK\n";
		
		echo "  > drop foreign key user (fk_user_mahasiswa) ... ";
		$this->db->query('ALTER TABLE user DROP FOREIGN KEY fk_user_mahasiswa');
		echo "OK\n";
		
		echo "  > drop column user (mahasiswa_id) ... ";
		$this->dbforge->drop_column('user', 'mahasiswa_id');
		echo "OK\n";
		
		echo "  > drop table mahasiswa ... ";
		$this->dbforge->drop_table('mahasiswa');
		echo "OK\n";
		
		echo "  > drop table dosen ... ";
		$this->dbforge->drop_table('dosen');
		echo "OK\n";
		
		echo "  > drop table program_studi ... ";
		$this->dbforge->drop_table('program_studi');
		echo "OK\n";
		
		echo "  > drop column perguruan_tinggi (id_institusi, created_at, updated_at) ... ";
		$this->dbforge->drop_column('perguruan_tinggi', 'id_institusi');
		$this->dbforge->drop_column('perguruan_tinggi', 'created_at');
		$this->dbforge->drop_column('perguruan_tinggi', 'updated_at');
		echo "OK\n";
		
		echo "  > drop unique constraint perguruan_tinggi (uc_npsn) ... ";
		$this->db->query("ALTER TABLE perguruan_tinggi DROP INDEX uc_npsn");
		echo "OK\n";
	}
}
