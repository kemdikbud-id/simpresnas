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
							<td class="text-center" id="statusLolos{$data->id}">
								{if $data->is_didanai == 1}<span class="label label-success">Lolos</span>{/if}
								{if $data->is_ditolak == 1}<span class="label label-danger">Tidak Lolos</span><br/>{$data->keterangan_ditolak}{/if}
							</td>
							<td>
								<a href="#" data-id="{$data->id}" class="btn btn-xs btn-success set-didanai">Lolos</a>
								<a href="#" data-id="{$data->id}" data-toggle="modal" data-target="#confirmModal" class="btn btn-xs btn-danger">Tidak Lolos</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>

		</div>
	</div>
					
	<div class="modal fade" tabindex="-1" role="dialog" id="confirmModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body" class="padding: 20px">
					<div class="form-horizontal">
						<div class="form-group" style="margin-bottom: 0">
							<label>Keterangan tidak lolos</label>
							<input type="text" name="keterangan" value="" class="form-control" />
						</div>
					</div>	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger set-ditolak" data-id="">Submit Tidak Lolos</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		$('#table').DataTable({
			ordering: false,
			stateSave: true
		});
		$('.set-didanai').on('click', function() {
			var id = $(this).data('id');
			$.ajax({ url: '{site_url('expo/set-didanai')}', data: { proposal_id: id }, method: 'POST' })
				.done(function() {
					$('#statusLolos' + id).html('<span class="label label-success">Lolos</span>');
				})
				.fail(function() {
					alert('Terjadi kesalahan');
				});
		});
		$('.set-ditolak').on('click', function() {
			var id = $(this).data('id');
			var keterangan = $('input[name="keterangan"]').val();
			$.ajax({ url: '{site_url('expo/set-ditolak')}', data: { proposal_id: id, keterangan: keterangan }, method: 'POST' })
				.done(function() {
					$('#statusLolos' + id).html('<span class="label label-danger">Tidak Lolos</span><br/>' + keterangan);
				})
				.fail(function() {
					alert('Terjadi kesalahan');
				});
			$('#confirmModal').modal('toggle');
		});
		$('#confirmModal').on('shown.bs.modal', function(e) {
			$('input[name="keterangan"]').val(''); // mengosongkan inputan
			$('.set-ditolak').data('id', $(e.relatedTarget).data('id'));
		});
	</script>
{/block}