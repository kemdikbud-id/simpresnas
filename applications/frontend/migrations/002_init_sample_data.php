<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * 
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 */
class Migration_Init_Sample_Data extends CI_Migration
{
	public function up()
	{
		$this->load->helper('string');
		
		$this->db->trans_begin();
		
		// Insert default program
		echo '  > insert into program ... ';
		$this->db->insert('program', ['id' => 1, 'nama_program' => 'PBBT (Program Belajar Bekerja Terpadu)']);
		$this->db->insert('program', ['id' => 2, 'nama_program' => 'KBMI (Program Kompetisi Bisnis Mahasiswa Indonesia)']);
		echo "OK\n";
		
		// Insert default kategori
		echo '  > insert into kategori ... ';
		$this->db->insert('kategori', ['id' => 1, 'program_id' => 1, 'nama_kategori' => 'Umum']);
		$this->db->insert('kategori', ['id' => 2, 'program_id' => 2, 'nama_kategori' => 'Makanan Minuman']);
		$this->db->insert('kategori', ['id' => 3, 'program_id' => 2, 'nama_kategori' => 'Jasa dan Perdagangan']);
		$this->db->insert('kategori', ['id' => 4, 'program_id' => 2, 'nama_kategori' => 'Industri Kreatif']);
		$this->db->insert('kategori', ['id' => 5, 'program_id' => 2, 'nama_kategori' => 'Teknologi']);
		$this->db->insert('kategori', ['id' => 6, 'program_id' => 2, 'nama_kategori' => 'Produksi / Budidaya']);
		echo "OK\n";
		
		// Insert master syarat proposal sample
		echo '  > insert into syarat ... ';
		$this->db->insert('syarat', ['program_id' => 1, 'syarat' => 'Lembar Pengesahan', 'keterangan' => 'Lembar pengesahan dalam bentuk PDF', 'urutan' => 1]);
		$this->db->insert('syarat', ['program_id' => 1, 'syarat' => 'Proposal', 'keterangan' => 'File proposal dalam bentuk PDF tidak lebih dari 5 MB', 'is_wajib' => 0, 'urutan' => 2]);
		$this->db->insert('syarat', ['program_id' => 2, 'syarat' => 'Lembar Pengesahan', 'keterangan' => 'Lembar pengesahan dalam bentuk PDF', 'urutan' => 1]);
		$this->db->insert('syarat', ['program_id' => 2, 'syarat' => 'Proposal', 'keterangan' => 'File proposal dalam bentuk PDF tidak lebih dari 5 MB', 'is_wajib' => 0, 'urutan' => 2]);
		echo "OK\n";
		
		// Insert default kegiatan
		echo '  > insert into kegiatan ... ';
		$this->db->insert('kegiatan', [
			'program_id' => 1, 'tahun' => date('Y'), 'proposal_per_pt' => 1,
			'tgl_awal_upload' => date('Y').'-03-01', 'tgl_akhir_upload' => date('Y').'-03-31 23:59:59',
			'tgl_awal_review' => date('Y').'-04-01', 'tgl_akhir_review' => date('Y').'-04-15 23:59:59',
			'tgl_pengumuman' => date('Y').'-05-01'
		]);
		$this->db->insert('kegiatan', [
			'program_id' => 2, 'tahun' => date('Y'), 'proposal_per_pt' => 25,
			'tgl_awal_upload' => date('Y').'-03-01', 'tgl_akhir_upload' => date('Y').'-03-31 23:59:59',
			'tgl_awal_review' => date('Y').'-04-01', 'tgl_akhir_review' => date('Y').'-04-15 23:59:59',
			'tgl_pengumuman' => date('Y').'-05-01'
		]);
		echo "OK\n";
		
		// Insert perguruan tinggi percobaan
		echo '  > insert into perguruan_tinggi ... ';
		$this->db->insert('perguruan_tinggi', [
			'npsn' => '000001',
			'nama_pt' => 'Universitas Ujicoba',
			'email_pt' => 'email@pt.ac.id'
		]);
		echo "OK\n";
		
		// Insert default admin user
		echo '  > insert into user ... ';
		$this->db->insert('user', [
			'username' => 'admin', 
			'password_hash' => sha1('password'), 
			'auth_key' => random_string('alnum', 16), 
			'password_reset_token' => random_string('alnum', 16),
			'program_id' => PROGRAM_PBBT,
			'tipe_user' => 99
		]);

		
		// Tambah user user PT : format npsn+xx
		// xx = 01 pbbt, 02 kbmi
		$this->db->insert('user', [
			'username' => '00000101', 
			'password_hash' => sha1('password'), 
			'auth_key' => random_string('alnum', 16), 
			'password_reset_token' => random_string('alnum', 16),
			'program_id' => PROGRAM_PBBT,
			'tipe_user' => TIPE_USER_NORMAL,
			'perguruan_tinggi_id' => 1
		]);
		
		// Tambah user reviewer : username = nidn
		$this->db->insert('user', [
			'username' => 'nidn01', 
			'password_hash' => sha1('password'), 
			'auth_key' => random_string('alnum', 16), 
			'password_reset_token' => random_string('alnum', 16),
			'program_id' => PROGRAM_PBBT,
			'tipe_user' => TIPE_USER_REVIEWER,
			'perguruan_tinggi_id' => 1
		]);
		
		// Tambah user user PT : format npsn+xx
		// xx = 01 pbbt, 02 kbmi
		$this->db->insert('user', [
			'username' => '00000102', 
			'password_hash' => sha1('password'), 
			'auth_key' => random_string('alnum', 16), 
			'password_reset_token' => random_string('alnum', 16),
			'program_id' => PROGRAM_KBMI,
			'tipe_user' => TIPE_USER_NORMAL,
			'perguruan_tinggi_id' => 1
		]);
		
		// Tambah user reviewer : username = nidn
		$this->db->insert('user', [
			'username' => 'nidn01', 
			'password_hash' => sha1('password'), 
			'auth_key' => random_string('alnum', 16), 
			'password_reset_token' => random_string('alnum', 16),
			'program_id' => PROGRAM_KBMI,
			'tipe_user' => TIPE_USER_REVIEWER,
			'perguruan_tinggi_id' => 1
		]);
		echo "OK\n";
		
		$this->db->trans_commit();
	}
	
	public function down()
	{
		$table_set = array('user', 'perguruan_tinggi', 'kegiatan','syarat','kategori','program');
		
		foreach ($table_set as $table)
		{
			echo "  > delete from {$table} ... ";
			$this->db->query("DELETE FROM {$table}");
			echo "OK\n";
		}
	}
}
