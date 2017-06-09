<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database_04 extends CI_Migration
{
	function up()
	{
		// -------------------------------
		// Tabel Kegiatan
		// -------------------------------
		// add column
		echo "  > add column kegiatan.is_aktif ... ";
		$this->dbforge->add_column('kegiatan', array("COLUMN is_aktif INT(1) NOT NULL DEFAULT '0'"));
		echo "OK\n";
		
		echo "  > update kegiatan.is_aktif data (kegiatan = 2017) ... ";
		$this->db->query("update kegiatan set is_aktif = 1 where tahun = 2017");
		echo "OK\n";
		
		// -------------------------------
		// Tabel Proposal
		// -------------------------------
		// add column
		echo "  > add column proposal.kegiatan_id ... ";
		$this->dbforge->add_column('proposal', array("COLUMN kegiatan_id INT(11) NOT NULL DEFAULT '0' AFTER judul"));
		echo "OK\n";
		
		// update data
		echo "  > update proposal.kegiatan_id data ... ";
		$this->db->query("update proposal p set kegiatan_id = (select id from kegiatan k where k.tahun = year(p.created_at) and k.program_id = p.program_id)");
		echo "OK\n";
		
		// add foreign key
		echo "  > add foreign key proposal.kegiatan_id to kegiatan.id ... ";
		$this->dbforge->add_column('proposal', array("FOREIGN KEY (kegiatan_id) REFERENCES kegiatan (id)"));
		echo "OK\n";
		
		// drop foreign key
		echo "  > drop foreign key proposal.program_id ... ";
		$this->db->query("alter table proposal drop foreign key proposal_ibfk_2");
		echo "OK\n";
		
		// drop column
		echo "  > drop column proposal.program_id ... ";
		$this->dbforge->drop_column('proposal', 'program_id');
		echo "OK\n";
		
		// -------------------------------
		// Tabel Syarat
		// -------------------------------
		// add column
		echo "  > add column syarat.kegiatan_id ... ";
		$this->dbforge->add_column('syarat', array("COLUMN kegiatan_id INT(11) NOT NULL DEFAULT '0' AFTER program_id"));
		echo "OK\n";
		
		// update data
		echo "  > update syarat.kegiatan_id data ... ";
		$this->db->query("update syarat s set kegiatan_id = (select id from kegiatan k where k.tahun = 2017 and k.program_id = s.program_id)");
		echo "OK\n";
		
		// add foreign key
		echo "  > add foreign key syarat.kegiatan_id to kegiatan.id ... ";
		$this->dbforge->add_column('syarat', array("FOREIGN KEY (kegiatan_id) REFERENCES kegiatan (id)"));
		echo "OK\n";
		
		// drop foreign key
		echo "  > drop foreign key syarat.program_id ... ";
		$this->db->query("alter table syarat drop foreign key syarat_ibfk_1");
		echo "OK\n";
		
		// drop column
		echo "  > drop column syarat.program_id ... ";
		$this->dbforge->drop_column('syarat', 'program_id');
		echo "OK\n";
		
		// -------------------------------
		// Tabel Tahapan
		// -------------------------------
		echo "  > create table tahapan ... ";
		$this->dbforge->add_field('id INT PRIMARY KEY'); // Primary Key (not auto increment)
		$this->dbforge->add_field('tahapan varchar(50) NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->create_table('tahapan', TRUE);
		echo "OK\n";
		
		// -------------------------------
		// Tabel Tahapan Proposal
		// -------------------------------
		echo "  > create table tahapan_proposal ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('kegiatan_id INT NOT NULL');
		$this->dbforge->add_field('proposal_id INT NOT NULL');
		$this->dbforge->add_field('tahapan_id INT NOT NULL');
		$this->dbforge->add_field('nilai_akhir INT NOT NULL COMMENT \'Total nilai akhir proposal per tahap\'');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('FOREIGN KEY (kegiatan_id) REFERENCES kegiatan (id)');
		$this->dbforge->add_field('FOREIGN KEY (proposal_id) REFERENCES proposal (id)');
		$this->dbforge->add_field('FOREIGN KEY (tahapan_id) REFERENCES tahapan (id)');
		$this->dbforge->create_table('tahapan_proposal', TRUE);
		echo "OK\n";
		
		// -------------------------------
		// Tabel Reviewer
		// -------------------------------
		echo "  > create table reviewer ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('nama varchar(50) NOT NULL');
		$this->dbforge->add_field('gelar_depan varchar(10) NULL');
		$this->dbforge->add_field('gelar_belakang varchar(10) NULL');
		$this->dbforge->add_field('kompetensi varchar(100) NULL');
		$this->dbforge->add_field('no_kontak varchar(20) NULL');
		$this->dbforge->add_field('asal_institusi varchar(100) NULL');
		$this->dbforge->add_field('perguruan_tinggi_id INT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (perguruan_tinggi_id) REFERENCES perguruan_tinggi (id)');
		$this->dbforge->create_table('reviewer', TRUE);
		echo "OK\n";
		
		// -------------------------------
		// Tabel Plot Reviewer
		// -------------------------------
		echo "  > create table plot_reviewer ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('tahapan_proposal_id INT NOT NULL');
		$this->dbforge->add_field('reviewer_id INT NOT NULL');
		$this->dbforge->add_field('no_urut TINYINT NOT NULL DEFAULT 1');
		$this->dbforge->add_field('nilai_reviewer FLOAT NOT NULL DEFAULT 0 COMMENT \'Total nilai proposal per reviewer\'');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (tahapan_proposal_id) REFERENCES tahapan_proposal (id)');
		$this->dbforge->add_field('FOREIGN KEY (reviewer_id) REFERENCES reviewer (id)');
		$this->dbforge->create_table('plot_reviewer', TRUE);
		echo "OK\n";
		
		// add column
		echo "  > add column user.reviewer_id ... ";
		$this->dbforge->add_column('user', array(
			"COLUMN reviewer_id INT(11) NULL AFTER perguruan_tinggi_id",
			"FOREIGN KEY (reviewer_id) REFERENCES reviewer (id)"
		));
		echo "OK\n";
		
		// -------------------------------
		// Tabel Komponen Penilaian
		// -------------------------------
		echo "  > create table komponen_penilaian ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('kegiatan_id INT NOT NULL');
		$this->dbforge->add_field('tahapan_id INT NOT NULL');
		$this->dbforge->add_field('urutan TINYINT NOT NULL');
		$this->dbforge->add_field('kriteria VARCHAR(250) NOT NULL');
		$this->dbforge->add_field('bobot FLOAT NOT NULL DEFAULT 0');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (kegiatan_id) REFERENCES kegiatan (id)');
		$this->dbforge->add_field('FOREIGN KEY (tahapan_id) REFERENCES tahapan (id)');
		$this->dbforge->create_table('komponen_penilaian', TRUE);
		echo "OK\n";
		
		echo "  > create table hasil_penilaian ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('tahapan_proposal_id INT NOT NULL');
		$this->dbforge->add_field('komponen_penilaian_id INT NOT NULL');
		$this->dbforge->add_field('reviewer_id INT NOT NULL');
		$this->dbforge->add_field('skor FLOAT NOT NULL DEFAULT 0');
		$this->dbforge->add_field('nilai FLOAT NOT NULL DEFAULT 0 COMMENT \'Bobot x Skor\'');  // skor * bobot
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME NULL');
		$this->dbforge->add_field('FOREIGN KEY (tahapan_proposal_id) REFERENCES tahapan_proposal (id)');
		$this->dbforge->add_field('FOREIGN KEY (komponen_penilaian_id) REFERENCES komponen_penilaian (id)');
		$this->dbforge->add_field('FOREIGN KEY (reviewer_id) REFERENCES reviewer (id)');
		$this->dbforge->create_table('hasil_penilaian', TRUE);
		echo "OK\n";

		
		echo "  > insert into tahapan initial data ... ";
		$this->db->insert('tahapan', ['id' => 1, 'tahapan' => 'Evaluasi Proposal']);  // proopsal yang di upload/submit
		$this->db->insert('tahapan', ['id' => 2, 'tahapan' => 'Didanai']);			// proposal yang di danai
		$this->db->insert('tahapan', ['id' => 3, 'tahapan' => 'Evaluasi Pelaksanaan Program']);	// pelaksanaan
		$this->db->insert('tahapan', ['id' => 4, 'tahapan' => 'Evaluasi Hasil Monitoring']);		// setelah pelaksanaan
		$this->db->insert('tahapan', ['id' => 5, 'tahapan' => 'Rekomendasi EXPO']);		// setelah pelaksanaan
		echo "OK\n";
		
		echo "  > insert into tahapan_proposal (proposal tahun = 2017) ... ";
		$this->db->query("insert into tahapan_proposal (kegiatan_id, proposal_id, tahapan_id) select kegiatan_id, id, 1 from proposal");
		echo "OK\n";
		
		// insert data reviewer
		echo "  > insert into reviewer (pbbt 2017) ... ";
		$this->db->insert('reviewer', ['id' => 1, 'nama' => 'Widyastuti', 'perguruan_tinggi_id' => 3203]); // ITS
		$this->db->insert('reviewer', ['id' => 2, 'nama' => 'Saryono', 'perguruan_tinggi_id' => 3155]); // UNRI
		$this->db->insert('reviewer', ['id' => 3, 'nama' => 'Surfa Yondri', 'perguruan_tinggi_id' => 3223]); // Poltek Padang
		$this->db->insert('reviewer', ['id' => 4, 'nama' => 'Athor Subroto', 'perguruan_tinggi_id' => 3140]); // UI
		$this->db->insert('reviewer', ['id' => 5, 'nama' => 'Moch Surjani', 'asal_institusi' => "AMKI"]);
		echo "OK\n";
		
		// insert user login reviewer
		echo "  > insert into user (reviewer) ... ";
		$this->db->insert('user', ['username' => 'widyastuti', 'password' => 'pkmi2017', 'password_hash' => sha1('pkmi2017'), 'tipe_user' => 2, 'program_id' => 1, 'reviewer_id' => 1]);
		$this->db->insert('user', ['username' => 'saryono', 'password' => 'pkmi2017', 'password_hash' => sha1('pkmi2017'), 'tipe_user' => 2, 'program_id' => 1, 'reviewer_id' => 2]);
		$this->db->insert('user', ['username' => 'surfa', 'password' => 'pkmi2017', 'password_hash' => sha1('pkmi2017'), 'tipe_user' => 2, 'program_id' => 1, 'reviewer_id' => 3]);
		$this->db->insert('user', ['username' => 'athor', 'password' => 'pkmi2017', 'password_hash' => sha1('pkmi2017'), 'tipe_user' => 2, 'program_id' => 1, 'reviewer_id' => 4]);
		$this->db->insert('user', ['username' => 'surjani', 'password' => 'pkmi2017', 'password_hash' => sha1('pkmi2017'), 'tipe_user' => 2, 'program_id' => 1, 'reviewer_id' => 5]);
		echo "OK\n";
		
		// insert data komponen penilaian
		echo "  > insert into komponen_penilaian (kegiatan tahun = 2017) ... ";
		// Penilaian PBBT 2017 Inisial
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 1, 'tahapan_id' => 1, 'urutan' => 1, 'kriteria' => "Perumusan masalah:\na. Ketajaman perumusan masalah UMKM\nb. Solusi yang ditawarkan", 'bobot' => 25]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 1, 'tahapan_id' => 1, 'urutan' => 2, 'kriteria' => "Tujuan dan manfaat program untuk:\na. Mahasiswa\nb. UMKM\nc. PT", 'bobot' => 25]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 1, 'tahapan_id' => 1, 'urutan' => 3, 'kriteria' => "Tahapan dan Metode Pelaksanaan\n- Ketepatan dan kesesuaian metode yang digunakan", 'bobot' => 25]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 1, 'tahapan_id' => 1, 'urutan' => 4, 'kriteria' => "Organisasi Pelaksana Program:\na. Relevansi unit pengusul\nb. Ketersediaan Mentor", 'bobot' => 15]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 1, 'tahapan_id' => 1, 'urutan' => 5, 'kriteria' => "Kelayakan penelitian :\na. Kesesuaian waktu\nb. Kesesuaian biaya\nc. Kontribusi PT dan UMKM", 'bobot' => 10]);
		// Penilaian KBMI 2017 Inisial
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 1, 'urutan' => 1, 'kriteria' => "Deskripsi Usaha :\na. Bahan baku/sumber\nb. Proses produksi\nc. Mitra usaha", 'bobot' => 10]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 1, 'urutan' => 2, 'kriteria' => "Produk Barang/Jasa\na. Kreatifitas\nb. Inovasi", 'bobot' => 25]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 1, 'urutan' => 3, 'kriteria' => "Pemasaran:\na. Jangkauan Pasar\nb. Strategi Pemasaran", 'bobot' => 25]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 1, 'urutan' => 4, 'kriteria' => "Pengelolaan Usaha", 'bobot' => 10]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 1, 'urutan' => 5, 'kriteria' => "Permodalan", 'bobot' => 10]);
		$this->db->insert('komponen_penilaian', ['kegiatan_id' => 2, 'tahapan_id' => 1, 'urutan' => 6, 'kriteria' => "Keuangan :\na. Cash flow\nb. Pertumbuhan dan keuntungan rata-rata per bulan", 'bobot' => 20]);
		echo "OK\n";
	}
	
	function down()
	{
		// -------------------------------
		// Tabel Kegiatan
		// -------------------------------
		// drop column
		echo "  > drop column kegiatan.is_aktif ... ";
		$this->dbforge->drop_column('kegiatan', 'is_aktif');
		echo "OK\n";
		
		// -------------------------------
		// Tabel Proposal
		// -------------------------------
		// re-add column
		echo "  > add column proposal.program_id ... ";
		$this->dbforge->add_column('proposal', array("COLUMN program_id INT(11) NOT NULL DEFAULT '0' AFTER kegiatan_id"));
		echo "OK\n";
		
		// update data
		echo "  > update proposal.program_id data ... ";
		$this->db->query("update proposal p set program_id = (select program_id from kegiatan k where k.id = p.kegiatan_id)");
		echo "OK\n";
		
		// re-create foreign key
		echo "  > add foreign key proposal.program_id to program.id ... ";
		$this->dbforge->add_column('proposal', array("FOREIGN KEY proposal_ibfk_2 (program_id) REFERENCES program (id)"));
		echo "OK\n";
		
		// drop foreign key
		echo "  > drop foreign key proposal.kegiatan_id ... ";
		$this->db->query("alter table proposal drop foreign key proposal_ibfk_4");
		echo "OK\n";
		
		// drop column
		echo "  > drop column proposal.kegiatan_id ... ";
		$this->dbforge->drop_column('proposal', 'kegiatan_id');
		echo "OK\n";
		
		// -------------------------------
		// Tabel Syarat
		// -------------------------------
		// re-add column
		echo "  > add column syarat.program_id ... ";
		$this->dbforge->add_column('syarat', array("COLUMN program_id INT(11) NOT NULL DEFAULT '0' AFTER kegiatan_id"));
		echo "OK\n";
		
		// update data
		echo "  > update syarat.program_id data ... ";
		$this->db->query("update syarat s set program_id = (select program_id from kegiatan k where k.id = s.kegiatan_id)");
		echo "OK\n";
		
		// re-create foreign key
		echo "  > add foreign key syarat.program_id to program.id ... ";
		$this->dbforge->add_column('syarat', array("FOREIGN KEY syarat_ibfk_1 (program_id) REFERENCES program (id)"));
		echo "OK\n";
		
		// drop foreign key
		echo "  > drop foreign key syarat.kegiatan_id ... ";
		$this->db->query("alter table syarat drop foreign key syarat_ibfk_2");
		echo "OK\n";
		
		// drop column
		echo "  > drop column syarat.kegiatan_id ... ";
		$this->dbforge->drop_column('syarat', 'kegiatan_id');
		echo "OK\n";
		
		// delete user yg reviewer
		echo "  > delete from user (reviewer) ... ";
		$this->db->query("delete from user where reviewer_id <= 5");
		echo "OK\n";
		
		// drop foreign key
		echo "  > drop foreign key user.reviewer_id ... ";
		$this->db->query("alter table user drop foreign key user_ibfk_3");
		echo "OK\n";
		
		// drop column
		echo "  > drop column user.reviewer_id ... ";
		$this->dbforge->drop_column('user', 'reviewer_id');
		echo "OK\n";
		
		// Drop Table Section
		
		// drop table
		echo "  > drop table hasil_penilaian ... ";
		$this->dbforge->drop_table('hasil_penilaian');
		echo "OK\n";
		
		// drop table
		echo "  > drop table komponen_penilaian ... ";
		$this->dbforge->drop_table('komponen_penilaian');
		echo "OK\n";
		
		// drop table
		echo "  > drop table plot_reviewer ... ";
		$this->dbforge->drop_table('plot_reviewer');
		echo "OK\n";
		
		// drop table
		echo "  > drop table reviewer ... ";
		$this->dbforge->drop_table('reviewer');
		echo "OK\n";
		
		// drop table
		echo "  > drop table tahapan_proposal ... ";
		$this->dbforge->drop_table('tahapan_proposal');
		echo "OK\n";
		
		// drop table
		echo "  > drop table tahapan ... ";
		$this->dbforge->drop_table('tahapan');
		echo "OK\n";
	}
}