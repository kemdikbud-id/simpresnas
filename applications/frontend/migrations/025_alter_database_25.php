<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge 
 */
class Migration_Alter_database_25 extends CI_Migration
{
	public function up()
	{
		// Tabel peserta_workshop
		echo "  > alter table peserta_workshop ... ";
		$this->dbforge->add_column('peserta_workshop', [
			'ikut_seminar INT(1) DEFAULT \'0\'',
			'ikut_pelatihan INT(1) DEFAULT \'0\'',
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP'
		]);
		echo "OK\n";
		
		echo "  > create table plot_reviewer_workshop ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('peserta_workshop_id INT NOT NULL');
		$this->dbforge->add_field('reviewer_id INT NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP');
		$this->dbforge->add_field('FOREIGN KEY (peserta_workshop_id) REFERENCES peserta_workshop (id)');
		$this->dbforge->add_field('FOREIGN KEY (reviewer_id) REFERENCES reviewer (id)');
		$this->dbforge->create_table('plot_reviewer_workshop', TRUE);
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > drop column peserta_workshop (ikut_seminar, ikut_pelatihan, created_at, updated_at) ... ";
		$this->dbforge->drop_column('peserta_workshop', 'ikut_seminar');
		$this->dbforge->drop_column('peserta_workshop', 'ikut_pelatihan');
		$this->dbforge->drop_column('peserta_workshop', 'created_at');
		$this->dbforge->drop_column('peserta_workshop', 'updated_at');
		echo "OK\n";
		
		echo "  > drop table plot_reviewer_workshop ... ";
		$this->dbforge->drop_table('plot_reviewer_workshop');
		echo "OK\n";
	}
}
