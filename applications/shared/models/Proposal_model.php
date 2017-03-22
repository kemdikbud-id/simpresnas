<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Proposal_model extends CI_Model
{
	public function list_pbbt_all()
	{
		return $this->db->query(
			"select 
				proposal.id, judul, nama_kategori, nim_ketua, nama_ketua,
				count(syarat.id) jumlah_syarat, 
				count(file_proposal.id) syarat_terupload,
				sum(syarat.is_wajib) syarat_wajib, 
				sum(if(syarat.is_wajib = 1 AND file_proposal.id IS NOT NULL, 1,0)) syarat_wajib_terupload,
				proposal.created_at
			from proposal
			join program on program.id = proposal.program_id
			join kategori on kategori.id = proposal.kategori_id
			join syarat on syarat.program_id = program.id
			left join file_proposal on file_proposal.proposal_id = proposal.id and file_proposal.syarat_id = syarat.id
			where
				proposal.program_id = 1
			group by proposal.id, judul, nama_kategori, nim_ketua, nama_ketua, proposal.created_at
			order by proposal.id")->result();
	}
	
	public function list_kbmi_all()
	{
		return $this->db->query(
			"select 
				proposal.id, judul, nama_kategori, nim_ketua, nama_ketua,
				count(syarat.id) jumlah_syarat, 
				count(file_proposal.id) syarat_terupload,
				sum(syarat.is_wajib) syarat_wajib, 
				sum(if(syarat.is_wajib = 1 AND file_proposal.id IS NOT NULL, 1,0)) syarat_wajib_terupload,
				proposal.created_at
			from proposal
			join program on program.id = proposal.program_id
			join kategori on kategori.id = proposal.kategori_id
			join syarat on syarat.program_id = program.id
			left join file_proposal on file_proposal.proposal_id = proposal.id and file_proposal.syarat_id = syarat.id
			where
				proposal.program_id = 2
			group by proposal.id, judul, nama_kategori, nim_ketua, nama_ketua, proposal.created_at
			order by proposal.id")->result();
	}
	
	/**
	 * Mengambil satu data Proposal
	 * @param int $id
	 * @param int $perguruan_tinggi_id Harus ada untuk tampilan frontend sebagai pengaman
	 */
	public function get_single($id, $perguruan_tinggi_id = NULL)
	{
		if ($perguruan_tinggi_id != NULL)
		{
			return $this->db->get_where('proposal', array(
				'id' => $id,
				'perguruan_tinggi_id' => $perguruan_tinggi_id
			), 1)->row();
		}
		else
		{
			return $this->db->get_where('proposal', array(
				'id' => $id
			), 1)->row();
		}
	}
	
	public function delete($id, $perguruan_tinggi_id = NULL)
	{
		if ($perguruan_tinggi_id != NULL)
		{
			return $this->db->delete('proposal', array(
				'id' => $id,
				'perguruan_tinggi_id' => $perguruan_tinggi_id
			), 1);
		}
	}
}
