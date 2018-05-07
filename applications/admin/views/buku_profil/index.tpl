{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h1 class="page-header">Daftar Isian Buku Profil</h1>

	<div class="row">
		<div class="col-lg-12">
			<table id="table" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Perguruan Tinggi</th>
						<th>Status PT</th>
						<th>D1</th>
						<th>D2</th>
						<th>D3</th>
						<th>D4 / S1</th>
						<th>Unit Wirausaha</th>
						<th>Mhs Binaan</th>
						<th>KBMI</th>
						<th>Workshop</th>
						<th>PBBT</th>
						<th>KMI Expo</th>
						<th>Pelatihan</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->nama_pt}</td>
							<td>
								{if $data->status_pt == 'ptnbh'}
									PTNBH
								{elseif $data->status_pt == 'blu'}
									BLU
								{elseif $data->status_pt == 'swasta'}
									Swasta
								{/if}
							</td>
							<td class="text-center">{$data->jumlah_d1}</td>
							<td class="text-center">{$data->jumlah_d2}</td>
							<td class="text-center">{$data->jumlah_d3}</td>
							<td class="text-center">{$data->jumlah_d4s1}</td>
							<td class="text-center">
								{if $data->ada_unit_kewirausahaan == 1}
									<label class="label label-info">Ada</label>
								{else}
									<label class="label label-warning">Tidak Ada</label>
								{/if}
							</td>
							<td class="text-center">
								{$data->jumlah_binaan}
							</td>
							<td class="text-center">
								{if $data->pernah_kbmi}
									<i class="glyphicon glyphicon-ok"></i>
								{else}
									<i class="glyphicon glyphicon-minus"></i>
								{/if}
							</td>
							<td class="text-center">
								{if $data->pernah_workshop}
									<i class="glyphicon glyphicon-ok"></i>
								{else}
									<i class="glyphicon glyphicon-minus"></i>
								{/if}
							</td>
							<td class="text-center">
								{if $data->pernah_pbbt}
									<i class="glyphicon glyphicon-ok"></i>
								{else}
									<i class="glyphicon glyphicon-minus"></i>
								{/if}
							</td>
							<td class="text-center">
								{if $data->pernah_expo}
									<i class="glyphicon glyphicon-ok"></i>
								{else}
									<i class="glyphicon glyphicon-minus"></i>
								{/if}
							</td>
							<td class="text-center">
								{if $data->pernah_pelatihan}
									<i class="glyphicon glyphicon-ok"></i>
								{else}
									<i class="glyphicon glyphicon-minus"></i>
								{/if}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
				
			<div class="text-center">
				<a href="{site_url('buku-profil/download-excel')}" class="btn btn-success">Download Excel</a>
			</div>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				ordering: false,
				stateSave: true
			});
		});
	</script>
{/block}