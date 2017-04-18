<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * 
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database extends CI_Migration
{
	function up()
	{
		// tabel lembaga pengusul
		echo "  > create table lembaga_pengusul ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('lembaga_pengusul VARCHAR(50) NOT NULL');
		$this->dbforge->create_table('lembaga_pengusul', TRUE);
		echo "OK\n";
		
		// init data lembaga pengusul
		echo "  > insert into lembaga_pengusul ... ";
		$this->db->insert('lembaga_pengusul', ['id' => 1, 'lembaga_pengusul' => 'LPPM']);
		$this->db->insert('lembaga_pengusul', ['id' => 2, 'lembaga_pengusul' => 'Pusat Karir']);
		$this->db->insert('lembaga_pengusul', ['id' => 3, 'lembaga_pengusul' => 'Pusat Kewirausahaan / Inkubasi Bisnis']);
		echo "OK\n";
		
		// tabel reject message : kumpulan template message penolakan akun
		echo "  > create table reject_message ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('message TEXT NOT NULL');
		$this->dbforge->create_table('reject_message');
		echo "OK\n";
		
		// init data reject message
		echo "  > insert into reject_message ... ";
		$this->db->insert('reject_message', ['id' => 1, 'message' => 'Format surat tidak standar. Silahkan download template surat di halaman download.']);
		$this->db->insert('reject_message', ['id' => 2, 'message' => 'Scan tidak jelas. Mohon di unggah kembali dengan resolusi yang cukup untuk bisa dibaca']);
		$this->db->insert('reject_message', ['id' => 3, 'message' => 'Email penerima akun bukan email resmi atau merupakan email pribadi, mohon gunakan email lembaga.']);
		echo "OK\n";
		
		// add column
		echo "  > add column lembaga_pengusul_id, reject_message to request_user ... ";
		$this->dbforge->add_column('request_user', array(
			"COLUMN lembaga_pengusul_id INT NOT NULL DEFAULT '1' AFTER kontak_pengusul",
			'COLUMN reject_message VARCHAR(250) NULL AFTER rejected_at',
			'FOREIGN KEY (lembaga_pengusul_id) REFERENCES lembaga_pengusul (id)'
		));
		echo "OK\n";
		
		// add full-text index
		echo "  > add full-text index to perguruan_tinggi ... ";
		$this->db->query("CREATE FULLTEXT INDEX perguruan_tinggi_fti_1 ON perguruan_tinggi (nama_pt)");
		echo "OK\n";
	}
	
	function down()
	{
		// Alter table request_user
		echo "  > drop column lembaga_pengusul_id, reject_message from request_user ... ";
		$this->db->query("ALTER TABLE request_user DROP FOREIGN KEY request_user_ibfk_2");
		$this->dbforge->drop_column('request_user', 'reject_message');
		$this->dbforge->drop_column('request_user', 'lembaga_pengusul_id');
		echo "OK\n";
		
		// Drop table
		echo "  > drop table lembaga_pengusul ... ";
		$this->dbforge->drop_table('lembaga_pengusul');
		echo "OK\n";
		
		// Drop full-text index
		echo "  > drop full-text index from perguruan_tinggi ... ";
		$this->db->query("DROP INDEX perguruan_tinggi_fti_1 ON perguruan_tinggi");
		echo "OK\n";
	}
}
