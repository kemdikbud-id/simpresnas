<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge 
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_20 extends CI_Migration
{

	public function up()
	{
		// Tabel perguruan tinggi
		echo "  > alter table perguruan_tinggi ... ";
		$this->dbforge->add_column('perguruan_tinggi', [
			'alamat_jalan TEXT NULL',
			'alamat_kecamatan VARCHAR(100) NULL',
			'alamat_kota VARCHAR(100) NULL',
			'alamat_provinsi VARCHAR(50) NULL',
			'status_pt VARCHAR(6) NULL',
			'jumlah_d1 INT DEFAULT 0',
			'jumlah_d2 INT DEFAULT 0',
			'jumlah_d3 INT DEFAULT 0',
			'jumlah_d4s1 INT DEFAULT 0',
			'jumlah_prodi INT DEFAULT 0',
			'daftar_prodi TEXT NULL',
			'ada_unit_kewirausahaan TINYINT(1) NULL DEFAULT 0'
		]);
		echo "OK\n";
		
		// Tabel proposal workshop
		echo "  > create table unit_kewirausahaan ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('nama_unit_1 VARCHAR(100) NULL');
		$this->dbforge->add_field('tahun_berdiri_1 INT NULL');
		$this->dbforge->add_field('alamat_1 TEXT NULL');
		$this->dbforge->add_field('nama_unit_2 VARCHAR(100) NULL');
		$this->dbforge->add_field('tahun_berdiri_2 INT NULL');
		$this->dbforge->add_field('alamat_2 TEXT NULL');
		$this->dbforge->add_field('nama_unit_3 VARCHAR(100) NULL');
		$this->dbforge->add_field('tahun_berdiri_3 INT NULL');
		$this->dbforge->add_field('alamat_3 TEXT NULL');
		$this->dbforge->add_field('jumlah_mentor INT NULL');
		$this->dbforge->add_field('jumlah_binaan INT NULL');
		$this->dbforge->add_field('pernah_kbmi TINYINT(1) NULL');
		$this->dbforge->add_field('pernah_workshop TINYINT(1) NULL');
		$this->dbforge->add_field('pernah_pbbt TINYINT(1) NULL');
		$this->dbforge->add_field('pernah_expo TINYINT(1) NULL');
		$this->dbforge->add_field('pernah_pelatihan TINYINT(1) NULL');
		$this->dbforge->add_field('bina_via_adhoc TINYINT(1) NULL');
		$this->dbforge->add_field('bentuk_unit TINYINT(1) NULL');
		$this->dbforge->add_field('bentuk_unit_ket VARCHAR(100) NULL');
		$this->dbforge->add_field('ada_mk_kwu TINYINT(1) NULL');
		$this->dbforge->add_field('sks_mk_kwu TINYINT NULL');
		$this->dbforge->add_field('file_papan_nama_1 VARCHAR(255) NULL');
		$this->dbforge->add_field('file_papan_nama_2 VARCHAR(255) NULL');
		$this->dbforge->add_field('file_kegiatan_1 VARCHAR(255) NULL');
		$this->dbforge->add_field('file_kegiatan_2 VARCHAR(255) NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->create_table('unit_kewirausahaan', TRUE);
		echo "OK\n";
		
		echo "  > create table profil_kelompok_usaha ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('is_kemenristek TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_field('nim_ketua VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_ketua VARCHAR(100) NULL');
		$this->dbforge->add_field('prodi_ketua VARCHAR(100) NULL');
		$this->dbforge->add_field('hp_ketua VARCHAR(100) NULL');
		$this->dbforge->add_field('email_ketua VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_1 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_1 VARCHAR(100) NULL');
		$this->dbforge->add_field('prodi_anggota_1 VARCHAR(100) NULL');
		$this->dbforge->add_field('hp_anggota_1 VARCHAR(100) NULL');
		$this->dbforge->add_field('email_anggota_1 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_2 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_2 VARCHAR(100) NULL');
		$this->dbforge->add_field('prodi_anggota_2 VARCHAR(100) NULL');
		$this->dbforge->add_field('hp_anggota_2 VARCHAR(100) NULL');
		$this->dbforge->add_field('email_anggota_2 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_3 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_3 VARCHAR(100) NULL');
		$this->dbforge->add_field('prodi_anggota_3 VARCHAR(100) NULL');
		$this->dbforge->add_field('hp_anggota_3 VARCHAR(100) NULL');
		$this->dbforge->add_field('email_anggota_3 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_4 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_4 VARCHAR(100) NULL');
		$this->dbforge->add_field('prodi_anggota_4 VARCHAR(100) NULL');
		$this->dbforge->add_field('hp_anggota_4 VARCHAR(100) NULL');
		$this->dbforge->add_field('email_anggota_4 VARCHAR(100) NULL');
		$this->dbforge->add_field('nim_anggota_5 VARCHAR(20) NULL');
		$this->dbforge->add_field('nama_anggota_5 VARCHAR(100) NULL');
		$this->dbforge->add_field('prodi_anggota_5 VARCHAR(100) NULL');
		$this->dbforge->add_field('hp_anggota_5 VARCHAR(100) NULL');
		$this->dbforge->add_field('email_anggota_5 VARCHAR(100) NULL');
		$this->dbforge->add_field('kategori_id INT NULL');
		$this->dbforge->add_field('kategori_lain VARCHAR(50) NULL'); // non kemenristek pakai ini
		$this->dbforge->add_field('nama_produk TEXT NULL');
		$this->dbforge->add_field('gambaran_bisnis TEXT NULL');
		$this->dbforge->add_field('capaian_bisnis TEXT NULL');
		$this->dbforge->add_field('rencana_kedepan TEXT NULL');
		$this->dbforge->add_field('prestasi_bisnis TEXT NULL');
		$this->dbforge->add_field('file_anggota VARCHAR(255) NULL');
		$this->dbforge->add_field('file_produk VARCHAR(255) NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->create_table('profil_kelompok_usaha', TRUE);
		echo "OK\n";
	}

	public function down()
	{
		echo "  > alter table perguruan_tinggi ... ";
		$column_set = [
			'alamat_jalan', 'alamat_kecamatan', 'alamat_kota', 'alamat_provinsi',
			'status_pt', 'jumlah_d1', 'jumlah_d2', 'jumlah_d3', 'jumlah_d4s1',
			'jumlah_prodi', 'daftar_prodi', 'ada_unit_kewirausahaan'
		];
		
		foreach ($column_set as $column)
		{
			$this->dbforge->drop_column('perguruan_tinggi', $column);
		}
		echo "OK\n";
		
		// Delete tabel unit_kewirausahaan
		echo "  > drop table unit_kewirausahaan ... ";
		$this->dbforge->drop_table('unit_kewirausahaan', TRUE);
		echo "OK\n";
		
		// Delete tabel unit_kewirausahaan
		echo "  > drop table profil_kelompok_usaha ... ";
		$this->dbforge->drop_table('profil_kelompok_usaha', TRUE);
		echo "OK\n";
	}

}
