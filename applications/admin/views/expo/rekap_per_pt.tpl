{extends file='site_layout.tpl'}
{block name='head'}
	<style>
		.table>thead>tr>th:nth-child(1),
		.table>thead>tr>th:nth-child(3),
		.table>thead>tr>th:nth-child(4),
		.table>tbody>tr>td:nth-child(1),
		.table>tbody>tr>td:nth-child(3),
		.table>tbody>tr>td:nth-child(4) { text-align: center }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Rekap Expo KMI</h2>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-striped table-condensed" id="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Perguruan Tinggi</th>
						<th>Jumlah Submit</th>
						<th>Jumlah Lolos</th>
						<th>Jumlah Tidak Lolos</th>
					</tr>
				</thead>
				<tbody>
					{$jumlah_submit = 0}{$jumlah_lolos = 0}{$jumlah_ditolak = 0}
					{foreach $data_set as $data}
						<tr {if $data->jumlah_lolos == 0 and $data->jumlah_ditolak == 0}class="warning"{/if}>
							<td>{$data@index + 1}</td>
							<td>{$data->npsn} - {$data->nama_pt}</td>
							<td>{$data->jumlah_submit}</td>
							<td>{$data->jumlah_lolos}</td>
							<td>{$data->jumlah_ditolak}</td>
						</tr>
						{$jumlah_submit = $jumlah_submit + $data->jumlah_submit}
						{$jumlah_lolos = $jumlah_lolos + $data->jumlah_lolos}
						{$jumlah_ditolak = $jumlah_ditolak + $data->jumlah_ditolak}
					{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td class="text-center">{$jumlah_submit}</td>
						<td class="text-center">{$jumlah_lolos}</td>
						<td class="text-center">{$jumlah_ditolak}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
{/block}