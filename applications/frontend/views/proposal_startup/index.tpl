{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style type="text/css">
		.table { font-size: 14px; }
		.table > tbody > tr > td:last-child { width: 1%; white-space: nowrap; }
		td > p { margin-bottom: 0 }
		p.judul { font-weight: bold; }
		p.sub-judul { font-size: 12px; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Daftar Usulan Akselerasi Startup {if $kegiatan != NULL}{$kegiatan->tahun}{/if}</h2>
	<div class="row">
		<div class="col-lg-12">

			<table class="table table-bordered table-hover" id="table">
				<thead>
					<tr>
						<th></th>
						<th>Usulan</th>
						<th class="text-center">Pitchdeck</th>
						<th class="text-center">Presentasi</th>
						<th class="text-center">Produk</th>
						<th class="text-center">Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>
								<p class="judul">{$data->judul}</p>
								<p class="sub-judul">{$data->nama} - {$data->nim} - {$data->nama_program_studi}</p>
							</td>
							<td class="text-center">
								{if $data->file_pitchdeck != ''}
									<a href="{base_url()}upload/lampiran/{$data->file_pitchdeck}" target="_blank"><i class="glyphicon glyphicon-paperclip"></i></a>
									{else}
									<span class="label label-default">Belum Upload</span>
								{/if}
							</td>
							<td class="text-center">
								{if $data->link_presentasi != ''}
									<a href="{$data->link_presentasi}" target="_blank"><i class="glyphicon glyphicon-film"></i></a>
									{else}
									<span class="label label-default">Belum Ada</span>
								{/if}
							</td>
							<td class="text-center">
								{if $data->link_produk != ''}
									<a href="{$data->link_produk}" target="_blank"><i class="glyphicon glyphicon-new-window"></i></a>
									{else}
									<span class="label label-default">Belum Ada</span>
								{/if}
							</td>
							<td class="text-center">
								{if $data->is_reviewed == TRUE}
									<label class="label label-primary">Direview</label>
								{else if $data->is_submited == TRUE}
									<label class="label label-success">Submit</label>
								{else}
									<label class="label label-default">Pengisian</label>
								{/if}
							</td>
							<td>
								<form action="{site_url('proposal-startup/send-login')}" method="post" style="display: inline">
									<input type="submit" value="Kirim Login" class="btn btn-xs btn-info" />
									<input type="hidden" name="mahasiswa_id" value="{$data->mahasiswa_id}" />
								</form>
								<a href="{site_url('proposal-startup/update')}/{$data->id}" class="btn btn-xs btn-success">Edit</a>
								{if time() < strtotime($kegiatan->tgl_akhir_upload)}
									{if $data->is_submited == 0}{* Jika belum disubmit, bisa dihapus *}
										<a href="{site_url('proposal-startup/delete')}/{$data->id}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
									{else if $data->is_reviewed == 0}{* Jika belum di review, bisa dibatalkan *}
										<a href="{site_url('proposal-startup/cancel-submit')}/{$data->id}" class="btn btn-xs btn-default" style="margin-top: 5px">Batalkan Submit</a>
									{/if}
								{/if}
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="7">Data kosong</td>
						</tr>
					{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7">
							{if $kegiatan != null}
								<a href="{site_url('proposal-startup/create')}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah</a>
							{else}
								Tidak ada kegiatan aktif.
							{/if}
						</td>
					</tr>
				</tfoot>
			</table>

			<p style="font-size: small">* Login mahasiswa bisa dilihat di menu Edit apabila email tidak terkirim melalui menu Kirim Login.</p>

		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		$('#table').DataTable({
			ordering: false,
			stateSave: true
		});
	</script>
{/block}