<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge 
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_16 extends CI_Migration
{
	function up()
	{
		// tabel proposal
		echo "  > alter table proposal ... ";
		$this->dbforge->add_column('proposal', array(
			'keterangan_ditolak varchar(200) NULL AFTER is_kmi_award'
		));
		echo "OK\n";
	}
	
	function down()
	{
		// tabel proposal
		echo "  > alter table proposal ... ";
		$this->dbforge->drop_column('proposal', 'keterangan_ditolak');
		echo "OK\n";
	}
}
