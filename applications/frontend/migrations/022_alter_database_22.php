<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db Description
 */
class Migration_Alter_database_22 extends CI_Migration
{
	public function up()
	{
		// Tabel download file
		echo "  > create table download ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('judul TEXT NOT NULL');
		$this->dbforge->add_field('is_external INT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('nama_file VARCHAR(250) NULL');
		$this->dbforge->add_field('link TEXT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->create_table('download', TRUE);
		echo "OK\n";
		
		echo "  > fill tabel download ... ";
		$this->db->insert_batch('download', [
			[
				'judul' => 'Panduan PKMI 2017', 
				'is_external' => 1, 
				'nama_file' => null,
				'link' => 'http://belmawa.ristekdikti.go.id/wp-content/uploads/2017/04/PANDUAN-PKMI-20171.pdf', 
				'created_at' => '2017-04-17 00:00:00'
			],
			[
				'judul' => 'Lembar Pengesahan Expo KMI', 
				'is_external' => 0,
				'nama_file' => 'Lembar_Pengesahan_Expo_KMI.docx', 
				'link' => null,
				'created_at' => '2017-10-26 00:00:00'
			],
			[
				'judul' => 'Format Usulan Kegiatan Expo KMI',
				'is_external' => 0,
				'nama_file' => 'Format_Usulan_Kegiatan_Expo_KMI.docx',
				'link' => null,
				'created_at' => '2017-10-26 00:00:00'
			],
			[
				'judul' => 'Panduan Expo KMI 2017 di Politeknik Negeri Pontianak ', 
				'is_external' => 1, 
				'nama_file' => null,
				'link' => 'http://belmawa.ristekdikti.go.id/wp-content/uploads/2017/10/Panduan-KMI-Expo-20171.pdf', 
				'created_at' => '2017-10-26 00:00:00'
			],
			[
				'judul' => 'Panduan Workshop Kewirausahaan 2018',
				'is_external' => 0,
				'nama_file' => 'panduan-workshop-kewirausahaan-2018.pdf',
				'link' => null,
				'created_at' => '2018-02-01 00:00:00'
			],
			[
				'judul' => 'Panduan Kompetisi Bisnis Mahasiswa Indonesia 2018',
				'is_external' => 0,
				'nama_file' => 'PANDUAN_KBMI_2018.pdf',
				'link' => null,
				'created_at' => '2018-03-01 00:00:00'
			],
			
		]);
		echo "OK\n";
	}
	
	public function down()
	{
		// Delete tabel download
		echo "  > drop table download ... ";
		$this->dbforge->drop_table('download', TRUE);
		echo "OK\n";
	}
}
