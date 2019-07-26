<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_mysqli_driver $db
 */
class Migration_Alter_table_syarat extends CI_Migration
{
	function up()
	{
		echo "  > alter table syarat ... ";
		$this->db->query('alter table syarat add column is_upload bool not null default \'1\' after is_wajib');
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table syarat ... ";
		$this->dbforge->drop_column('syarat', 'is_upload');
		echo "OK\n";
	}
}
