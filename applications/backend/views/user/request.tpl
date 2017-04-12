{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar User Request</h1>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Perguruan Tinggi</th>
						<th>Nama Lembaga / Unit</th>
						<th>Nama Pengusul</th>
						<th>Kontak</th>
						<th>Email</th>
						<th>File</th>
						<th>Program</th>
						<th>Waktu Usul</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->perguruan_tinggi}</td>
							<td>{$data->unit_lembaga}</td>
							<td>{$data->nama_pengusul}</td>
							<td>{$data->kontak_pengusul}</td>
							<td><code>{$data->email}</code></td>
							<td><a href="{base_url("../upload/request-user/{$data->nama_file}")}" target="_blank">Lihat Berkas</a></td>
							<td>{if $data->program_id == 1}PBBT{else}KBMI{/if}</td>
							<td>{$data->waktu}</td>
							<td>
								<a href="{site_url("user/request-reject?id={$data->id}")}" class="btn btn-sm btn-warning reject">Tolak</a>
								<a href="{site_url("user/request-approve?id={$data->id}")}" class="btn btn-sm btn-success approve">Setujui</a>
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="9" class="text-muted">Tidak ada yang ditampilkan</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/block}