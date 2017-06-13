<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database_07 extends CI_Migration
{
	function up()
	{
		// -------------------------------
		// Tabel Proposal
		// -------------------------------
		// add column
		echo "  > add column proposal.lama_kegiatan_bln ... ";
		$this->dbforge->add_column('proposal', array("COLUMN lama_kegiatan_bln SMALLINT NOT NULL DEFAULT '0' AFTER lama_kegiatan"));
		echo "OK\n";
		
		// rename column
		echo "  > rename column proposal.lama_kegiatan -> proposal.lama_kegiatan_thn ... ";
		$this->db->query("ALTER TABLE proposal CHANGE lama_kegiatan lama_kegiatan_thn SMALLINT");
		echo "OK\n";

		// -------------------------------
		// Tabel Hasil Penilaian
		// -------------------------------
		// add column
		echo "  > add column hasil_penilaian.plot_reviewer_id ... ";
		$this->dbforge->add_column('hasil_penilaian', array("COLUMN plot_reviewer_id INT NOT NULL DEFAULT '0' AFTER id"));
		echo "OK\n";
		
		// update data
		echo "  > update hasil_penilaian.plot_reviewer_id data ... ";
		$this->db
			->set('plot_reviewer_id', '(select id from plot_reviewer pr where pr.tahapan_proposal_id = hp.tahapan_proposal_id and pr.reviewer_id = hp.reviewer_id)', FALSE)
			->update('hasil_penilaian hp');
		echo "OK\n";
		
		// add foreign key
		echo "  > add foreign key hasil_penilaian.plot_reviewer_id to plot_reviewer.id ... ";
		$this->dbforge->add_column('hasil_penilaian', array("FOREIGN KEY (plot_reviewer_id) REFERENCES plot_reviewer (id)"));
		echo "OK\n";
		
		// drop foreign key
		echo "  > drop foreign key hasil_penilaian.tahapan_proposal_id ... ";
		$this->db->query("alter table hasil_penilaian drop foreign key hasil_penilaian_ibfk_1");
		echo "OK\n";
		
		// drop column
		echo "  > drop column hasil_penilaian.tahapan_proposal_id ... ";
		$this->dbforge->drop_column('hasil_penilaian', 'tahapan_proposal_id');
		echo "OK\n";
		
		// drop foreign key
		echo "  > drop foreign key hasil_penilaian.reviewer_id ... ";
		$this->db->query("alter table hasil_penilaian drop foreign key hasil_penilaian_ibfk_3");
		echo "OK\n";
		
		// drop column
		echo "  > drop column hasil_penilaian.reviewer_id ... ";
		$this->dbforge->drop_column('hasil_penilaian', 'reviewer_id');
		echo "OK\n";
	}
	
	function down()
	{
		
	}
}