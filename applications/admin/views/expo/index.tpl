{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style>
		.table>thead>tr>th, .table>tbody>tr>td { font-size: 13px; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Daftar Expo KMI</h2>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-striped table-condensed" id="table">
				<thead>
					<tr>
						<th>Perguruan Tinggi</th>
						<th>Kategori</th>
						<th>Judul Usaha</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->nama_pt}</td>
							<td>{$data->nama_kategori}</td>
							<td>{$data->nama_usaha}</td>
							<td></td>
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
		$('#table').DataTable({
			ordering: false,
			stateSave: true
		});
	</script>
{/block}