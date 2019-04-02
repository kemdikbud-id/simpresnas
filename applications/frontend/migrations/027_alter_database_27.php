<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_27 extends CI_Migration
{
	function up()
	{
		echo "  > create table isian_proposal ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('proposal_id INT NOT NULL');
		$this->dbforge->add_field('isian_ke INT NOT NULL');
		$this->dbforge->add_field('isian TEXT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP');
		$this->dbforge->add_field('FOREIGN KEY fk_form_proposal (proposal_id) REFERENCES proposal (id)');
		$this->dbforge->add_field('UNIQUE KEY proposal_isian_ke (proposal_id, isian_ke)');
		$this->dbforge->create_table('isian_proposal', TRUE);
		echo "OK\n";
		
		echo "  > alter table syarat ... ";
		$this->dbforge->add_column('syarat', [
			'allowed_types VARCHAR(50) NULL DEFAULT \'pdf\'',
			'max_size INT NOT NULL DEFAULT 5'
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > drop table isian_proposal ... ";
		$this->dbforge->drop_table('isian_proposal');
		echo "OK\n";
		
		echo "  > drop column syarat (allowed_types, max_size) ... ";
		$this->dbforge->drop_column('syarat', 'allowed_types');
		$this->dbforge->drop_column('syarat', 'max_size');
		echo "OK\n";
	}
}
