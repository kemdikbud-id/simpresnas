<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_DB_mysqli_driver $db
 */
class Migration_Add_program_kompetisi_daring extends CI_Migration
{
	function up()
	{
		echo "  > insert program Kompetisi Daring (Penulisan Opini, Poster, Video Opini) ... ";
		$this->db->insert('program', [
			'id' => PROGRAM_PENULISAN_OPINI,
			'nama_program' => 'Kompetisi Penulisan Opini', 
			'nama_program_singkat' => 'Opini'
		]);
        $this->db->insert('program', [
			'id' => PROGRAM_POSTER,
			'nama_program' => 'Kompetisi Poster', 
			'nama_program_singkat' => 'Poster'
		]);
        $this->db->insert('program', [
			'id' => PROGRAM_VIDEO_OPINI,
			'nama_program' => 'Kompetisi Video Opini', 
			'nama_program_singkat' => 'Video'
		]);
		echo "OK\n";
	}
	
	function down()
	{
        $program_daring = implode(',', [PROGRAM_PENULISAN_OPINI, PROGRAM_POSTER, PROGRAM_VIDEO_OPINI]);
        
		echo "  > remove program Kompetisi Daring (Penulisan Opini, Poster, Video Opini) ... ";
		// Transaksi Anggota Proposal
		$this->db->where_in('proposal_id', 'select id from proposal where kegiatan_id in (select id from kegiatan where program_id in (' . $program_daring . '))', FALSE);
		$this->db->delete('anggota_proposal');
		// Transaksi Proposal
		$this->db->where_in('kegiatan_id', 'select id from kegiatan where program_id in (' . $program_daring . ')', FALSE);
		$this->db->delete('proposal');
		// Master Syarat
		$this->db->where_in('kegiatan_id', 'select id from kegiatan where program_id in (' . $program_daring . ')', FALSE);
		$this->db->delete('syarat');
		// Transaksi user request
        $this->db->where_in('program_id', [PROGRAM_PENULISAN_OPINI, PROGRAM_POSTER, PROGRAM_VIDEO_OPINI]);
		$this->db->delete('request_user');
        // Transaksi user
        $this->db->where_in('program_id', [PROGRAM_PENULISAN_OPINI, PROGRAM_POSTER, PROGRAM_VIDEO_OPINI]);
		$this->db->delete('user');
		// Transaksi Kegiatan
		$this->db->where_in('program_id', [PROGRAM_PENULISAN_OPINI, PROGRAM_POSTER, PROGRAM_VIDEO_OPINI]);
        $this->db->delete('kegiatan');
		// Program
        $this->db->where_in('id', [PROGRAM_PENULISAN_OPINI, PROGRAM_POSTER, PROGRAM_VIDEO_OPINI]);
		$this->db->delete('program');
		echo "OK\n";
	}
}