<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
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
}
