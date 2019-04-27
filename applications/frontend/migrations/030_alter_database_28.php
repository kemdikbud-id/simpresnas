<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_database_28 extends CI_Migration
{
	function up()
	{
		echo "  > drop column perguruan_tinggi (jenis_pt_id, kategori_pt_id) ... ";
		$this->db->query('alter table perguruan_tinggi drop foreign key fk_pt_jenis');
		$this->db->query('alter table perguruan_tinggi drop foreign key fk_pt_kategori');
		$this->dbforge->drop_column('perguruan_tinggi', 'jenis_pt_id');
		$this->dbforge->drop_column('perguruan_tinggi', 'kategori_pt_id');
		echo "OK\n";
		
		echo "  > create table bentuk_pendidikan ... ";
		$this->dbforge->add_field('id INT PRIMARY KEY');
		$this->dbforge->add_field('bentuk_pendidikan VARCHAR(20) NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP');
		$this->dbforge->create_table('bentuk_pendidikan', TRUE);
		echo "OK\n";
		
		echo "  > seed data bentuk_pendidikan ... ";
		$this->db->insert_batch('bentuk_pendidikan', [
			['id' => 19, 'bentuk_pendidikan' => 'Akademi'],
			['id' => 20, 'bentuk_pendidikan' => 'Politeknik'],
			['id' => 21, 'bentuk_pendidikan' => 'Sekolah Tinggi'],
			['id' => 22, 'bentuk_pendidikan' => 'Institut'],
			['id' => 23, 'bentuk_pendidikan' => 'Universitas'],
			['id' => 34, 'bentuk_pendidikan' => 'Akademi Komunitas']
		]);
		echo "OK\n";
		
		echo "  > add column perguruan_tinggi (bentuk_pendidikan_id) ... ";
		$this->dbforge->add_column('perguruan_tinggi', 'bentuk_pendidikan_id INT NULL AFTER email_pt');
		$this->db->query('alter table perguruan_tinggi add constraint fk_pt_bentuk_pt foreign key (bentuk_pendidikan_id) references bentuk_pendidikan (id)');
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback column perguruan_tinggi (jenis_pt_id, kategori_pt_id) ... ";
		$this->dbforge->add_column('perguruan_tinggi', 'jenis_pt_id VARCHAR(1) NULL AFTER email_pt');
		$this->dbforge->add_column('perguruan_tinggi', 'kategori_pt_id INT NULL AFTER jenis_pt_id');
		$this->db->query('alter table perguruan_tinggi add constraint fk_pt_jenis foreign key (jenis_pt_id) references jenis_pt (id)');
		$this->db->query('alter table perguruan_tinggi add constraint fk_pt_kategori foreign key (kategori_pt_id) references kategori_pt (id)');
		echo "OK\n";
		
		echo "  > drop column perguruan_tinggi (bentuk_pendidikan_id) ... ";
		$this->db->query('alter table perguruan_tinggi drop foreign key fk_pt_bentuk_pt');
		$this->dbforge->drop_column('perguruan_tinggi', 'bentuk_pendidikan_id');
		echo "OK\n";
		
		echo "  > drop table bentuk_pendidikan ... ";
		$this->dbforge->drop_table('bentuk_pendidikan');
		echo "OK\n";
	}
}
