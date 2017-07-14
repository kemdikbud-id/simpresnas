<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database_10 extends CI_Migration
{
	function up()
	{
		// -------------------------------
		// Tabel Proposal
		// -------------------------------
		// add column
		echo "  > alter table proposal ... ";
		$this->dbforge->add_column('proposal', array(
			"COLUMN is_didanai INT(1) NOT NULL DEFAULT '0' AFTER is_reviewed",
		));
		echo "OK\n";
	}
	
	function down()
	{
		// drop column
		echo "  > alter table rollback proposal ... ";
		$this->dbforge->drop_column('proposal', 'is_didanai');
		echo "OK\n";
	}
}