<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_table_captcha extends CI_Migration
{
	function up()
	{
		echo "  > alter table captcha ... ";
		$this->dbforge->modify_column('captcha', 'word VARCHAR(8) NOT NULL');
		$this->dbforge->modify_column('captcha', 'captcha_time INT NOT NULL');
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table captcha ... ";
		// No action needed
		echo "OK\n";
	}
}
