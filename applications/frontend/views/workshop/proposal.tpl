{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h2 class="page-header">Unggah Proposal Workshop</h2>
    <div class="row">
		<div class="col-lg-12">
			
			<table class="table table-bordered table-condensed table-striped" id="tableProposal">
				<thead>
					<tr>
						<th>Judul</th>
						<th style="width: 20px">File</th>
						<th>Lokasi Workshop</th>
						<th style="width: 40px"></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->judul}</td>
							<td>
								{if $data->nama_file != ''}	
									<a href="{base_url()}upload/file-proposal/workshop/{$ci->session->user->username}/{$data->nama_file}" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a>
								{/if}
							</td>
							<td>{$data->kota}</td>
							<td>
								<a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal"
								   data-id="{$data->id}" data-judul="{htmlentities($data->judul)}">Hapus</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<a href="{site_url('workshop/add-proposal')}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Proposal</a>
						</td>
					</tr>
				</tfoot>
			</table>
			
		</div>
	</div>
							
	<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Apakah data ini akan dihapus ?</h4>
				</div>
				<div class="modal-body">
					Proposal: <p id="judul-text"></p>
				</div>
				<div class="modal-footer">
					<a class="btn btn-danger" id="hapusButton" data-id="">Hapus</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type='text/javascript'>
		$(document).ready(function() {
			
			var selectedRow = null;

			var tableProposal = $('#tableProposal').DataTable({ 
				stateSave: true,
				columnDefs: [
					{ orderable: false, targets: [-1, -3] }
				]
			});
			
			$('#tableProposal tbody').on('click', 'tr', function() {
				selectedRow = this;
			});
			
			$('#myModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget);
				var modal = $(this);
				modal.find('#judul-text').html(button.data('judul'));
				$('#hapusButton').data('id', button.data('id'));
			});
			
			$('#hapusButton').on('click', function() {
				$.post('{site_url('workshop/delete-proposal')}/'+$(this).data('id'), null, function(data) {
					if (data === '1') {
						tableProposal.row(selectedRow).remove().draw();
						$('#myModal').modal('toggle');
					}
				});
			});
			
		});
	</script>
{/block}