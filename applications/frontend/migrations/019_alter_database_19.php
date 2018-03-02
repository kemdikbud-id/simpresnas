<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge 
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_19 extends CI_Migration
{
	function up()
	{
		// Tabel proposal workshop
		echo "  > create table proposal_workshop ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('judul TEXT NOT NULL');
		$this->dbforge->add_field('lokasi_workshop_id INT NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->add_field('FOREIGN KEY (lokasi_workshop_id) REFERENCES lokasi_workshop (id)');
		$this->dbforge->create_table('proposal_workshop', TRUE);
		echo "OK\n";
		
		// Tabel file proposal workshop
		echo "  > create table file_proposal_workshop ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('proposal_workshop_id INT NOT NULL');
		$this->dbforge->add_field('nama_file VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('nama_asli VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (proposal_workshop_id) REFERENCES proposal_workshop (id)');
		$this->dbforge->create_table('file_proposal_workshop', TRUE);
		echo "OK\n";
	}
	
	function down()
	{
		// Delete tabel file proposal workshop
		echo "  > drop table file_proposal_workshop ... ";
		$this->dbforge->drop_table('file_proposal_workshop', TRUE);
		echo "OK\n";
		
		// Delete tabel proposal workshop
		echo "  > drop table proposal_workshop ... ";
		$this->dbforge->drop_table('proposal_workshop', TRUE);
		echo "OK\n";
	}
}