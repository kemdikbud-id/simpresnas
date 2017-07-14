{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Master Kegiatan</h1>
	
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Tahun</th>
						<th>Program</th>
						<th>Maksimal Proposal</th>
						<th>Status</th>
						<th>Awal Upload</th>
						<th>Tanggal Akhir Upload</th>
						<th>Tanggal Awal Review</th>
						<th>Tanggal Akhir Review</th>
						<th>Tanggal Pengumuman</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->tahun}</td>
							<td>{$data->nama_program}</td>
							<td class="text-center">{$data->proposal_per_pt}</td>
							<td>
								{if $data->is_aktif == 1}<span class="label label-success">AKTIF</span>{else}<span class="label label-default">NONAKTIF</span>{/if}
							</td>
							<td>{$data->tgl_awal_upload|date_format:"%d %b %Y %T"}</td>
							<td>{$data->tgl_akhir_upload|date_format:"%d %b %Y %T"}</td>
							<td>{$data->tgl_awal_review|date_format:"%d %b %Y %T"}</td>
							<td>{$data->tgl_akhir_review|date_format:"%d %b %Y %T"}</td>
							<td>{$data->tgl_pengumuman|date_format:"%d %b %Y %T"}</td>
							<td>
								<a href="{site_url("kegiatan/update/{$data->id}")}" class="btn btn-sm btn-default">Edit</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
				{if count($data_set) > 0}
					<tfoot>
						<tr>
							<td colspan="10">
								<a href="{site_url('kegiatan/add/')}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Kegiatan</a>
							</td>
						</tr>
					</tfoot>
				{/if}
			</table>
		</div>
	</div>
{/block}