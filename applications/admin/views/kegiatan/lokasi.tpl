{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Lokasi Workshop</h1>

	<div class="row">
		<div class="col-lg-12">
			<form class="form-inline" action="{current_url()}" method="get" style="margin-bottom: 20px">
				<div class="form-group">
					<select name="kegiatan_id" class="form-control">
						<option value="">-- Pilih Kegiatan --</option>
						{foreach $kegiatan_set as $kegiatan}
							<option value="{$kegiatan->id}" {if !empty($smarty.get.kegiatan_id)}{if $smarty.get.kegiatan_id == $kegiatan->id}selected{/if}{/if}>{$kegiatan->nama_program} {$kegiatan->tahun}</option>
						{/foreach}
					</select>
				</div>
				<button type="submit" class="btn btn-default">
					Lihat
				</button>
			</form>
			{if !empty($smarty.get.kegiatan_id)}
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Kota</th>
						<th>Tempat</th>
						<th>Waktu Pelaksanaan</th>
						<th>Awal Registrasi</th>
						<th>Akhir Registrasi</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $lokasi_set as $lokasi}
						<tr>
							<td>{$lokasi->kota}</td>
							<td>{$lokasi->tempat}</td>
							<td>{$lokasi->waktu_pelaksanaan|date_format:"%d %B %Y"}</td>
							<td>{$lokasi->tgl_awal_registrasi|date_format:"%d %b %Y %T"}</td>
							<td>{$lokasi->tgl_akhir_registrasi|date_format:"%d %b %Y %T"}</td>
							<td>
								<a href="{site_url("kegiatan/edit-lokasi/{$lokasi->id}")}" class="btn btn-sm btn-default">Edit</a>
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="6"><em>Tidak ada data</em></td>
						</tr>
					{/foreach}
					
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6">
							<a href="{site_url('kegiatan/add-lokasi/')}?kegiatan_id={$smarty.get.kegiatan_id}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Lokasi</a>
						</td>
					</tr>
				</tfoot>	
			</table>
			{/if}
		</div>
	</div>
{/block}