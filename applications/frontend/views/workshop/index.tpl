{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h2 class="page-header">Pendaftaran Peserta Workshop Kewirausahaan</h2>
    <div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-condensed table-striped" id="tablePeserta">
				<thead>
					<tr>
						<th style="width: 35px">No</th>
						<th>NIM</th>
						<th>Nama</th>
						<th style="width: 65px">Angkatan</th>
						<th>Program Studi</th>
						<th>Lokasi Workshop</th>
						<th style="width: 40px"></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="7">
							<a href="{site_url('workshop/add-peserta')}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Mahasiswa</a>
						</td>
					</tr>
				</tfoot>
				<tbody>
					{foreach $peserta_set as $peserta}
						<tr>
							<td>{$peserta@index + 1}</td>
							<td>{$peserta->nim}</td>
							<td>{$peserta->nama}</td>
							<td>{$peserta->angkatan}</td>
							<td>{$peserta->program_studi}</td>
							<td>{$peserta->kota}</td>
							<td>
								<a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal"
								   data-id="{$peserta->id}" data-nim="{$peserta->nim}" data-nama="{$peserta->nama}"
								   data-angkatan="{$peserta->angkatan}" data-prodi="{$peserta->program_studi}">Hapus</a>
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="7"><em>Tidak ada data</em></td>
						</tr>
					{/foreach}
				</tbody>
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
					<div class="form-horizontal">
						<div class="form-group" style="margin-bottom: 0">
							<label class="col-sm-3 control-label">NIM</label>
							<div class="col-sm-7">
							  <p class="form-control-static" id="nim-text"></p>
							</div>
						</div>
						<div class="form-group" style="margin-bottom: 0">
							<label class="col-sm-3 control-label">Nama</label>
							<div class="col-sm-7">
							  <p class="form-control-static" id="nama-text"></p>
							</div>
						</div>
					</div>
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
	<script type="text/javascript">
		$(document).ready(function () {
			
			var selectedRow = null;

			var tablePeserta = $('#tablePeserta').DataTable({
				stateSave: true,
				columnDefs: [
					{ targets: -1, orderable: false }
				]
			});
			
			$('#tablePeserta tbody').on('click', 'tr', function() {
				selectedRow = this;
			});
			
			$('#myModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget);
				var modal = $(this);
				modal.find('#nim-text').html(button.data('nim'));
				modal.find('#nama-text').html(button.data('nama'));
				$('#hapusButton').data('id', button.data('id'));
			});
			
			$('#hapusButton').on('click', function() {
				$.post('{site_url('workshop/delete-peserta')}/'+$(this).data('id'), null, function(data) {
					if (data === '1') {
						tablePeserta.row(selectedRow).remove().draw();
						$('#myModal').modal('toggle');
					}
				});
				
			});

		});
	</script>
{/block}