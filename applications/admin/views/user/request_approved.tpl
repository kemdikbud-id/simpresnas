{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h2 class="page-header">Daftar User Request Disetujui</h2>

	<div class="row">
		<div class="col-lg-12">
			<div id="loading">Load data...</div>
			<table class="table table-bordered table-condensed" id="table" style="display: none">
				<thead>
					<tr>
						<th>Perguruan Tinggi</th>
						<th>Lembaga / Unit</th>
						<th>Nama Pengusul</th>
						<th>Kontak</th>
						<th>Email</th>
						<th>File</th>
						<th>Program</th>
						<th>Waktu Usul</th>
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
							<td><a href="{base_url("../upload/request-user/{$data->nama_file}")}" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a></td>
							<td>{if $data->program_id == 1}PBBT{else}KBMI{/if}</td>
							<td>{$data->waktu}</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="8" class="text-muted">Tidak ada yang ditampilkan</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		$('#table').DataTable();
		$('#table').show();
		$('#loading').hide();
	</script>
{/block}