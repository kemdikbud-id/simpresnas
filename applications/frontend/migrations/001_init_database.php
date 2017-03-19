<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * 
 * @property CI_DB_forge $dbforge
 */
class Migration_Init_database extends CI_Migration
{
	public function up()
	{
		$table_options = array('ENGINE' => 'InnoDB');
		
		// Tabel Program
		echo "  > create table program ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('nama_program VARCHAR(60) NOT NULL');
		$this->dbforge->create_table('program', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel Jadwal Kegiatan Program
		echo "  > create table kegiatan ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('program_id INT NOT NULL');
		$this->dbforge->add_field('tahun INT(4) NOT NULL');
		$this->dbforge->add_field('proposal_per_pt INT(2) NOT NULL COMMENT \'Jatah maksimal proposal di upload tiap PT\'');
		$this->dbforge->add_field('tgl_awal_upload DATETIME NOT NULL');
		$this->dbforge->add_field('tgl_akhir_upload DATETIME NOT NULL');
		$this->dbforge->add_field('tgl_awal_review DATETIME NOT NULL');
		$this->dbforge->add_field('tgl_akhir_review DATETIME NOT NULL');
		$this->dbforge->add_field('tgl_pengumuman DATETIME NOT NULL');
		// Unique Key
		$this->dbforge->add_field('UNIQUE KEY idx_uq_kegiatan (program_id, tahun)');
		// Foreign Key
		$this->dbforge->add_field('FOREIGN KEY fk_kegiatan_program (program_id) REFERENCES program (id)');
		$this->dbforge->create_table('kegiatan', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel Perguruan Tinggi
		echo "  > create table perguruan tinggi ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('npsn VARCHAR(6) NOT NULL');
		$this->dbforge->add_field('nama_pt VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('email_pt VARCHAR(100) NOT NULL');
		$this->dbforge->create_table('perguruan_tinggi', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel Request user
		echo "  > create table request_user ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('program_id INT NOT NULL');
		$this->dbforge->add_field('nama_pengusul VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('jabatan_pengusul VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('kontak_pengusul VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('unit_lembaga VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('email VARCHAR(100) NOT NULL');
		$this->dbforge->add_field("nama_file VARCHAR(100) NOT NULL COMMENT 'Nama file (encrypted) surat permintaan user'");
		$this->dbforge->add_field("is_approved INT(1) NOT NULL DEFAULT '0'");
		$this->dbforge->add_field("is_rejected INT(1) NOT NULL DEFAULT '0'");
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('FOREIGN KEY fk_req_user_pt (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->add_field('FOREIGN KEY fk_req_user_program (program_id) REFERENCES program (id)');
		$this->dbforge->create_table('request_user', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel User
		echo "  > create table user ... ";
		$this->dbforge->add_field('id'); // primary key
		$this->dbforge->add_field('username VARCHAR(10) NOT NULL');
		$this->dbforge->add_field('auth_key VARCHAR(32) NOT NULL');
		$this->dbforge->add_field('password_hash VARCHAR(60) NOT NULL');  // sha1(password)
		$this->dbforge->add_field('password_reset_token VARCHAR(100) NULL');
		$this->dbforge->add_field('email VARCHAR(250) NULL');
		$this->dbforge->add_field('tipe_user SMALLINT NOT NULL DEFAULT \'1\' COMMENT \'99-Administrator; 1-User PT; 2-User Reviewer; 3-Verifikator\'');
		$this->dbforge->add_field('program_id INT NOT NULL');
		$this->dbforge->add_field('perguruan_tinggi_id INT NULL');
		$this->dbforge->add_field('latest_login DATETIME NULL');
		$this->dbforge->add_field('status INT(1) NOT NULL DEFAULT \'1\'');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('UNIQUE KEY idx_uq_username (username,program_id,tipe_user)');
		$this->dbforge->add_field('FOREIGN KEY fk_user_pt (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->add_field('FOREIGN KEY fk_user_program (program_id) REFERENCES program (id)');
		$this->dbforge->create_table('user', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel Kategori Proposal
		echo "  > create table kategori ... ";
		$this->dbforge->add_field('id'); // primary key
		$this->dbforge->add_field('program_id INT NOT NULL');
		$this->dbforge->add_field('nama_kategori VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('FOREIGN KEY fk_kategori_program (program_id) REFERENCES program (id)');
		$this->dbforge->create_table('kategori', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel Kategori Proposal
		echo "  > create table syarat ... ";
		$this->dbforge->add_field('id'); // primary key
		$this->dbforge->add_field('program_id INT NOT NULL');
		$this->dbforge->add_field('syarat VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('keterangan VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('is_wajib INT(1) NOT NULL DEFAULT \'1\'');
		$this->dbforge->add_field('urutan INT(2) NOT NULL');
		$this->dbforge->add_field('is_aktif INT(1) NOT NULL DEFAULT \'1\'');
		$this->dbforge->add_field('FOREIGN KEY fk_syarat_program (program_id) REFERENCES program (id)');
		$this->dbforge->create_table('syarat', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel Kategori Proposal
		echo "  > create table proposal ... ";
		$this->dbforge->add_field('id'); // primary key
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('judul TEXT NOT NULL');
		$this->dbforge->add_field('program_id INT NOT NULL');
		$this->dbforge->add_field('kategori_id INT NOT NULL');
		$this->dbforge->add_field('nim_ketua VARCHAR(20) NOT NULL');
		$this->dbforge->add_field('nama_ketua VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('nim_anggota_1 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_1 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_2 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_2 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_3 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_3 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_4 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_4 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_5 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_6 VARCHAR(100) NULL');
		$this->dbforge->add_field('is_submited INT(1) NOT NULL DEFAULT \'0\' COMMENT \'Status submit, Jika sudah submit tidak bisa edit, kecuali oleh admin\'');
		$this->dbforge->add_field('is_reviewed INT(1) NOT NULL DEFAULT \'0\' COMMENT \'Status telah direview, Jika sudah disubmit review tidak bisa di edit, kecuali oleh admin\'');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY fk_proposal_pt (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->add_field('FOREIGN KEY fk_proposal_program (program_id) REFERENCES program (id)');
		$this->dbforge->add_field('FOREIGN KEY fk_proposal_kategori (kategori_id) REFERENCES kategori (id)');
		$this->dbforge->create_table('proposal', TRUE, $table_options);
		echo "OK\n";
		
		// Tabel File Proposal
		echo "  > create table file_proposal ... ";
		$this->dbforge->add_field('id'); // Primary key
		$this->dbforge->add_field('proposal_id INT NOT NULL');
		$this->dbforge->add_field('syarat_id INT NOT NULL');
		$this->dbforge->add_field('nama_file VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('nama_asli VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY fk_file_proposal (proposal_id) REFERENCES proposal (id)');
		$this->dbforge->add_field('FOREIGN KEY fk_file_syarat (syarat_id) REFERENCES syarat (id)');
		$this->dbforge->create_table('file_proposal', TRUE, $table_options);
		echo "OK\n";
	}
	
	public function down()
	{
		$tables_to_del = array(
			'file_proposal', 
			'proposal', 
			'syarat', 
			'kategori',
			'user',
			'request_user',
			'perguruan_tinggi',
			'kegiatan',
			'program'
		);
		
		foreach ($tables_to_del as $table)
		{
			echo "  > drop table {$table} ... ";
			$this->dbforge->drop_table($table, TRUE);
			echo "OK\n";
		}
	}
}
