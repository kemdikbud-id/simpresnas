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
		$this->dbforge->create_table('lembaga_pengusul');
		echo "OK\n";
		
		// init data lembaga pengusul
		echo "  > insert into lembaga_pengusul ... ";
		$this->db->insert('lembaga_pengusul', ['id' => 1, 'lembaga_pengusul' => 'LPPM']);
		$this->db->insert('lembaga_pengusul', ['id' => 2, 'lembaga_pengusul' => 'Pusat Karir']);
		$this->db->insert('lembaga_pengusul', ['id' => 3, 'lembaga_pengusul' => 'Pusat Kewirausahaan / Inkubasi Bisnis']);
		echo "OK\n";
		
		// add column
		echo "  > add column lembaga_pengusul_id, reject_message to request_user ... ";
		$this->dbforge->add_column('request_user', array(
			"COLUMN lembaga_pengusul_id INT NOT NULL DEFAULT '1' AFTER kontak_pengusul",
			'COLUMN reject_message VARCHAR(250) NULL AFTER rejected_at',
			'FOREIGN KEY (lembaga_pengusul_id) REFERENCES lembaga_pengusul (id)'
		));
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
	}
}
