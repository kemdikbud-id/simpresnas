<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_database_12 extends CI_Migration
{
	function up()
	{
		$this->db->trans_begin();
		
		// tabel anggota_proposal
		echo "  > create table anggota_proposal ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('proposal_id INT NOT NULL');
		$this->dbforge->add_field('no_urut INT NOT NULL');
		$this->dbforge->add_field('nim varchar(20)');
		$this->dbforge->add_field('nama varchar(100)');
		$this->dbforge->add_field('is_biaya_dikti INT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at DATETIME');
		$this->dbforge->add_key('proposal_id');
		$this->dbforge->create_table('anggota_proposal', TRUE);
		echo "OK\n";
		
		// tabel anggota_proposal
		echo "  > add key to anggota_proposal ... ";
		$this->dbforge->add_column('anggota_proposal', array(
			'FOREIGN KEY (proposal_id) REFERENCES proposal (id)',
			'UNIQUE KEY (proposal_id, no_urut asc)'
		));
		echo "OK\n";
		
		// move data
		echo "  > move data anggota to anggota_proposal ... ";
		$this->db->query(
			"insert into anggota_proposal (proposal_id, no_urut, nim, nama)
			select * from (
			select proposal.id, 1 as no_urut, nim_anggota_1 as nim, nama_anggota_1 as nama from proposal where length(nim_anggota_1) > 0 or length(nama_anggota_1) > 0
			union all
			select proposal.id, 2 as no_urut, nim_anggota_2 as nim, nama_anggota_2 as nama from proposal where length(nim_anggota_2) > 0 or length(nama_anggota_2) > 0
			union all
			select proposal.id, 3 as no_urut, nim_anggota_3 as nim, nama_anggota_3 as nama from proposal where length(nim_anggota_3) > 0 or length(nama_anggota_3) > 0
			union all
			select proposal.id, 4 as no_urut, nim_anggota_4 as nim, nama_anggota_4 as nama from proposal where length(nim_anggota_4) > 0 or length(nama_anggota_4) > 0
			union all
			select proposal.id, 5 as no_urut, nim_anggota_5 as nim, nama_anggota_5 as nama from proposal where length(nim_anggota_5) > 0 or length(nama_anggota_5) > 0
			) anggota order by 1, 2");
		echo "OK\n";
		
		// insert program expo kmi
		echo "  > insert program Expo KMI ... ";
		$this->db->insert('program', ['id' => 3, 'nama_program' => 'Expo Kewirausahaan Mahasiswa Indonesia', 'nama_program_singkat' => 'Expo KMI']);
		echo "OK\n";
		
		// kategori
		echo "  > insert kategori Expo KMI ... ";
		$this->db->insert_batch('kategori', array(
			['id' => 7, 'program_id' => 3, 'nama_kategori' => 'Makanan Minuman'],
			['id' => 8, 'program_id' => 3, 'nama_kategori' => 'Jasa dan Perdagangan'],
			['id' => 9, 'program_id' => 3, 'nama_kategori' => 'Industri Kreatif'],
			['id' => 10, 'program_id' => 3, 'nama_kategori' => 'Teknologi'],
			['id' => 11, 'program_id' => 3, 'nama_kategori' => 'Produksi / Budidaya']
		));
		echo "OK\n";
		
		// insert kegiatan expo kmi
		echo "  > insert kegiatan Expo KMI ... ";
		$this->db->insert('kegiatan', ['id' => 3, 'program_id' => 3, 'tahun' => 2017, 'proposal_per_pt' => 3,
			'tgl_awal_upload' => '2017-10-25 00:00:00', 'tgl_akhir_upload' => '2017-11-07 23:59:59',
			'tgl_awal_review' => '2017-10-25 00:00:00', 'tgl_akhir_review' => '2017-11-12 23:59:59',
			'tgl_pengumuman' => '2017-11-13 12:00:00', 'is_aktif' => 1
		]);
		echo "OK\n";
		
		// insert syarat
		echo "  > insert syarat Expo KMI ... ";
		$this->db->insert('syarat', ['kegiatan_id' => 3, 'syarat' => 'Profil Usaha', 'keterangan' => 'Profil usaha ', 'urutan' => 1]);
		echo "OK\n";
		
		$this->db->trans_commit();
	}
	
	function down()
	{
		$this->db->trans_begin();
		
		// Drop table
		echo "  > drop table anggota_proposal ... ";
		$this->dbforge->drop_table('anggota_proposal');
		echo "OK\n";
		
		// delete record
		echo "  > delete request_user, user, syarat, kategori, kegiatan, dan program Expo KMI ... ";
		$this->db->delete('request_user', ['program_id' => 3]);
		$this->db->delete('user', ['program_id' => 3]);
		$this->db->delete('kategori', ['program_id' => 3]);
		$this->db->delete('syarat', ['kegiatan_id' => 3]);
		$this->db->delete('kegiatan', ['id' => 3]);
		$this->db->delete('program', ['id' => 3]);
		echo "OK\n";
		
		$this->db->trans_commit();
	}
}