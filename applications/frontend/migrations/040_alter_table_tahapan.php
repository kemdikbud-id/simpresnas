<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_DB_mysqli_driver $db
 */
class Migration_Alter_table_tahapan extends CI_Migration
{
	function up()
	{
		echo "  > alter table tahapan ... ";
		$this->db->query('alter table tahapan add column is_aktif bool not null default \'1\' after tahapan');
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table tahapan ... ";
		$this->dbforge->drop_column('skor', 'is_aktif');
		echo "OK\n";
	}
}