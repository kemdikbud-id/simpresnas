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
						<th>Judul Usaha</th>
						<th>Kategori</th>
						<th>Perguruan Tinggi</th>
						<th>Anggota</th>
						<th>Program KBMI</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->nama_usaha}</td>
							<td>{$data->nama_kategori}</td>
							<td>{$data->nama_pt}</td>
							<td class="text-center">{$data->jumlah_anggota}</td>
							<td class="text-center">
								{if $data->proposal_id != null}
									<span class="label label-primary">Program KBMI</span>
								{else}
									<span class="label label-default">Non-Program KBMI</span>
								{/if}
							</td>
							<td>
								{if $data->proposal_id == null}
									<a href="">Approval</a>
								{/if}
							</td>
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