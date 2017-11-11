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
						<th>File</th>
						<th>Kategori</th>
						<th>Judul Usaha</th>
						<th>KMI Award</th>
						<th>Status</th>
						<th style="width: 100px">Aksi</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->nama_pt}</td>
							<td class="text-center">{if $data->nama_file != ''}<a href="{base_url()}../upload/usulan-expo/{$data->nama_file}"><i class="glyphicon glyphicon-file" aria-hidden="true"></i></a>{else}<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>{/if}</td>
							<td>{$data->nama_kategori}</td>
							<td>{$data->judul}</td>
							<td class="text-center">{if $data->is_kmi_award == 1}<span class="label label-primary">KMI Award</span>{/if}</td>
							<td class="text-center" id="statusLolos{$data->id}">{if $data->is_didanai == 1}<span class="label label-success">Lolos</span>{/if}</td>
							<td>
								<a href="#" data-id="{$data->id}" class="btn btn-xs btn-success set-lolos">Lolos</a>
								<a href="#" data-id="{$data->id}" class="btn btn-xs btn-danger set-tidak-lolos">Tidak Lolos</a>
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
		$('.set-lolos').on('click', function() {
			var id = $(this).data('id');
			$.ajax({ url: '{site_url('expo/set-didanai')}', data: { proposal_id: id, is_didanai: 1 }, method: 'POST' })
				.done(function() {
					$('#statusLolos' + id).html('<span class="label label-success">Lolos</span>');
				})
				.fail(function() {
					alert('Terjadi kesalahan');
				});
		});
		$('.set-tidak-lolos').on('click', function() {
			var id = $(this).data('id');
			$.ajax({ url: '{site_url('expo/set-didanai')}', data: { proposal_id: id, is_didanai: 0 }, method: 'POST' })
				.done(function() {
					$('#statusLolos' + id).html('');
				})
				.fail(function() {
					alert('Terjadi kesalahan');
				});
		});
	</script>
{/block}