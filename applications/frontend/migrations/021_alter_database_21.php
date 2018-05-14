<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Migration_Alter_database_21 extends CI_Migration
{
	public function up()
	{
		// Tabel perguruan tinggi
		echo "  > alter table profil_kelompok_usaha ... ";
		$this->dbforge->add_column('profil_kelompok_usaha', [
			'kelompok_ke SMALLINT NOT NULL DEFAULT 1 AFTER perguruan_tinggi_id',
			'sumber_pendanaan TEXT NULL AFTER kategori_lain'
		]);
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > alter table profil_kelompok_usaha ... ";
		$this->dbforge->drop_column('profil_kelompok_usaha', 'kelompok_ke');
		$this->dbforge->drop_column('profil_kelompok_usaha', 'sumber_pendanaan');
		echo "OK\n";
	}
}
