{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Daftar User Request Ditolak</h2>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Perguruan Tinggi</th>
						<th>Lembaga / Unit</th>
						<th>Nama Pengusul</th>
						<th>Kontak</th>
						<th>Email</th>
						<th>File</th>
						<th>Program</th>
						<th>Waktu Usul</th>
						<th style="width: 80px"></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->perguruan_tinggi}</td>
							<td>{$data->unit_lembaga}</td>
							<td>{$data->nama_pengusul}</td>
							<td>{$data->kontak_pengusul}</td>
							<td><code>{$data->email}</code></td>
							<td><a href="{base_url("../upload/request-user/{$data->nama_file}")}" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a></td>
							<td>{if $data->program_id == 1}PBBT{else}KBMI{/if}</td>
							<td>{$data->waktu}</td>
							<td>
								<button class="btn btn-xs btn-default" data-toggle="modal" data-target="#confirmDialog" data-id="{$data->id}">Batalkan</button>
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="9" class="text-muted">Tidak ada yang ditampilkan</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
	<div id="confirmDialog" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h4>Apakah yakin akan dibatalkan ?</h4>
					<p>Request ditolak yang dibatalkan akan kembali muncul di halaman Request User</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary" id="btnSubmit">Ya</button>
				</div>
			</div>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script type="text/javascript">
		$('#confirmDialog').on('show.bs.modal', function (event) {
			var buttonSrc = $(event.relatedTarget);
			$('#btnSubmit').data('id', buttonSrc.data('id'));
		});
		
		$('#btnSubmit').on('click', function() {
			var id = $(this).data('id');
			
			$.ajax({
				url: "{site_url('user/request-unreject')}?id="+id,
				type: 'POST'
			});
			
			$('button[data-id="'+id+'"]').parentsUntil('tbody').remove();
			$('#confirmDialog').modal('hide');
		});
	</script>
{/block}