{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h1 class="page-header">Daftar Perguruan Tinggi</h1>
	
	<div class="row">
		<div class="col-lg-12">
			<table id="table" class="table table-bordered table-condensed table-striped" style="display: none">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Perguruan Tinggi</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->npsn}</td>
							<td>{$data->nama_pt}</td>
							<td>{$data->email_pt}</td>
							<td><a href="{site_url("pt/update/{$data->id}")}" class="btn btn-sm btn-default">Edit</a></td>
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
	<script>
		$(document).ready(function() {
			$('#table').DataTable();
			$('#table').show('slow');
		});
	</script>
{/block}