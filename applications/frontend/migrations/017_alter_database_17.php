<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge 
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_17 extends CI_Migration
{
	function up()
	{
		// tabel jenis perguruan tinggi
		echo "  > create table jenis_pt ... ";
		$this->dbforge->add_field('id VARCHAR(1) NOT NULL PRIMARY KEY'); // Primary Key
		$this->dbforge->add_field('jenis_pt VARCHAR(30) NOT NULL');
		$this->dbforge->create_table('jenis_pt', TRUE);
		echo "OK\n";
		
		// tabel jenis perguruan tinggi
		echo "  > create table kategori_pt ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('kategori_pt VARCHAR(30) NOT NULL');
		$this->dbforge->create_table('kategori_pt', TRUE);
		echo "OK\n";
		
		// alter perguruan tinggi
		echo "  > alter table perguruan_tinggi ... ";
		$this->dbforge->add_column('perguruan_tinggi', array(
			'jenis_pt_id VARCHAR(1) NULL AFTER nama_pt',
			'kategori_pt_id INT NULL AFTER jenis_pt_id',
			'CONSTRAINT fk_pt_jenis FOREIGN KEY (jenis_pt_id) REFERENCES jenis_pt (id)',
			'CONSTRAINT fk_pt_kategori FOREIGN KEY (kategori_pt_id) REFERENCES kategori_pt (id)'
		));
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > drop foreign key perguruan_tinggi (jenis_pt_id, kategori_pt_id) ... ";
		$this->db->query("alter table perguruan_tinggi drop foreign key fk_pt_jenis");
		$this->db->query("alter table perguruan_tinggi drop foreign key fk_pt_kategori");
		echo "OK\n";
		
		echo "  > drop column perguruan_tinggi (jenis_pt_id, kategori_pt_id) ... ";
		$this->dbforge->drop_column('perguruan_tinggi', 'jenis_pt_id');
		$this->dbforge->drop_column('perguruan_tinggi', 'kategori_pt_id');
		echo "OK\n";
		
		echo "  > drop table jenis_pt ... ";
		$this->dbforge->drop_table('jenis_pt');
		echo "OK\n";
		
		echo "  > drop table kategori_pt ... ";
		$this->dbforge->drop_table('kategori_pt');
		echo "OK\n";
	}
}