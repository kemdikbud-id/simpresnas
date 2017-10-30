<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge 
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_15 extends CI_Migration
{
	function up()
	{
		// tabel proposal
		echo "  > alter table proposal ... ";
		$this->dbforge->add_column('proposal', array(
			'is_ditolak INT(1) NOT NULL DEFAULT 0 AFTER is_didanai',
			'is_kmi_award INT(1) NOT NULL DEFAULT 0 AFTER is_ditolak'
		));
		echo "OK\n";
		
		// tabel anggota_proposal
		echo "  > create table file_expo ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('kegiatan_id INT NOT NULL');
		$this->dbforge->add_field('perguruan_tinggi_id INT NOT NULL');
		$this->dbforge->add_field('nama_file VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('nama_asli VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (kegiatan_id) REFERENCES kegiatan (id)');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->create_table('file_expo', TRUE);
		echo "OK\n";
		
		$this->db->trans_begin();
		
		// ubah tahapan
		echo "  > update tahapan expo ... ";
		$this->db->update('tahapan', ['tahapan' => 'Seleksi Expo KMI'], ['id' => 3]);
		$this->db->update('tahapan', ['tahapan' => 'KMI Award'], ['id' => 4]);
		$this->db->update('tahapan', ['tahapan' => 'KMI Award Stan Terbaik'], ['id' => 5]);
		echo "OK\n";
		
		$this->db->trans_commit();
	}
	
	function down()
	{
		echo "  > drop table file_expo ... ";
		$this->dbforge->drop_table('file_expo', TRUE);
		echo "OK\n";
		
		echo "  > drop column proposal.is_ditolak, is_kmi_award ... ";
		$this->dbforge->drop_column('proposal', 'is_ditolak');
		$this->dbforge->drop_column('proposal', 'is_kmi_award');
		echo "OK\n";
		
		// ubah tahapan
		echo "  > update tahapan expo ... ";
		$this->db->trans_begin();
		$this->db->update('tahapan', ['tahapan' => 'Evaluasi Pelaksanaan Program'], ['id' => 3]);
		$this->db->update('tahapan', ['tahapan' => 'Evaluasi Hasil Monitoring'], ['id' => 4]);
		$this->db->update('tahapan', ['tahapan' => 'Rekomendasi EXPO'], ['id' => 5]);
		$this->db->trans_commit();
		echo "OK\n";
	}
}
