<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Migration_Add_unique_nidn_dosen extends CI_Migration
{
	function up()
	{
		echo "  > alter table dosen ... ";
		$this->dbforge->add_column('dosen', [
			'CONSTRAINT uc_nidn UNIQUE (nidn)',
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > drop unique constraint dosen (uc_nidn) ... ";
		$this->db->query("ALTER TABLE dosen DROP INDEX uc_nidn");
		echo "OK\n";
	}
}
