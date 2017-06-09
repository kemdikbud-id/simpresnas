{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style>.table>thead>tr>th, .table>tbody>tr>td { font-size: 13px }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Daftar Reviewer</h2>
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-condensed table-striped" id="table" style="display:none;">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Kompetensi</th>
						<th>Asal</th>
						<th>No Kontak</th>
						<th>Username</th>
						<th>Password</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->nama}</td>
							<td>{$data->kompetensi}</td>
							<td>{$data->asal}</td>
							<td>{$data->no_kontak}</td>
							<td>{$data->username}</td>
							<td>{$data->password}</td>
							<td>
								<a class="btn btn-xs btn-default" href="{site_url('user-reviewer/update/')}{$data->id}">Edit</a>
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
		$('#table').DataTable();
		$('#table').show();
	</script>
{/block}