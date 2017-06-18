<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database_08 extends CI_Migration
{
	function up()
	{
		// -------------------------------
		// Tabel Plot Reviewer
		// -------------------------------
		// add column
		echo "  > alter table plot_reviewer ... ";
		$this->dbforge->add_column('plot_reviewer', array(
			"COLUMN biaya_diusulkan INT NOT NULL DEFAULT '0' AFTER nilai_reviewer",
			"COLUMN biaya_kontribusi_pt INT NOT NULL DEFAULT '0' AFTER biaya_diusulkan",
			"COLUMN biaya_kontribusi_umkm INT NOT NULL DEFAULT '0' AFTER biaya_kontribusi_pt",
			"COLUMN biaya_total INT NOT NULL DEFAULT '0' AFTER biaya_kontribusi_umkm"
		));
		echo "OK\n";
		
		// update data biaya-biaya dari proposal
		echo "  > copy data proposal.biaya_diusulkan, biaya_kontribusi_pt, biaya_kontribusi_umkm, biaya_total to plot_reviewer ... ";
		$this->db->query(
			"UPDATE plot_reviewer pr
			JOIN tahapan_proposal tp on tp.id = pr.tahapan_proposal_id
			JOIN proposal p on p.id = tp.proposal_id
			SET
				pr.biaya_diusulkan = p.biaya_diusulkan,
				pr.biaya_kontribusi_pt = p.biaya_kontribusi_pt,
				pr.biaya_kontribusi_umkm = p.biaya_kontribusi_umkm,
				pr.biaya_total = p.biaya_total");
		echo "OK\n";
	}
	
	function down()
	{
		// drop column
		echo "  > alter table rollback plot reviewer ... ";
		$this->dbforge->drop_column('plot_reviewer', 'biaya_diusulkan');
		$this->dbforge->drop_column('plot_reviewer', 'biaya_kontribusi_pt');
		$this->dbforge->drop_column('plot_reviewer', 'biaya_kontribusi_umkm');
		echo "OK\n";
	}
}