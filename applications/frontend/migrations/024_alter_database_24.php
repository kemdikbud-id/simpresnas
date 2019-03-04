<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Migration_Alter_database_24 extends CI_Migration
{
	public function up()
	{
		// Tabel peserta_workshop
		echo "  > alter table peserta_workshop ... ";
		$this->dbforge->add_column('peserta_workshop', [
			'email VARCHAR(254) NULL',
			'no_hp VARCHAR(20) NULL',
			'username_ig VARCHAR(30) NULL COMMENT \'Username Instagram\'',
			'noble_purpose TEXT NULL',
			'tujuan_mulia TEXT NULL'
		]);
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > drop column peserta_workshop (email, no_hp, username_ig) ... ";
		$this->dbforge->drop_column('peserta_workshop', 'email');
		$this->dbforge->drop_column('peserta_workshop', 'no_hp');
		$this->dbforge->drop_column('peserta_workshop', 'username_ig');
		$this->dbforge->drop_column('peserta_workshop', 'noble_purpose');
		$this->dbforge->drop_column('peserta_workshop', 'tujuan_mulia');
		echo "OK\n";
	}
}
