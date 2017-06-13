<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database_06 extends CI_Migration
{
	function up()
	{
		echo "  > add column plot_reviewer.biaya_rekomendasi ... ";
		$this->dbforge->add_column('plot_reviewer', array("COLUMN biaya_rekomendasi INT NOT NULL DEFAULT '0' AFTER nilai_reviewer"));
		echo "OK\n";
		
		echo "  > move data proposal.biaya_rekomendasi to plot_reviewer.biaya_rekomendasi ... ";
		$this->db->set("biaya_rekomendasi", "(select p.biaya_rekomendasi from tahapan_proposal tp join proposal p on p.id = tp.proposal_id where tp.id = pr.tahapan_proposal_id)", FALSE)
			->where(['no_urut' => 1])
			->update('plot_reviewer pr');
		echo "OK\n";
		
		// drop column
		echo "  > drop column proposal.biaya_rekomendasi ... ";
		$this->dbforge->drop_column('proposal', 'biaya_rekomendasi');
		echo "OK\n";
	}
	
	// Tidak boleh di rollback dari sini, versi minimal migration, perubahan buat file baru
}