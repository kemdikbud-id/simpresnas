{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
	<style>
		.table>thead>tr>th, .table>tbody>tr>td { font-size: 13px }
		.table>tbody>tr>td:last-child { width: 1%; white-space: nowrap; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Daftar User</h2>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-condensed table-striped" id="table" style="display:none;">
				<thead>
					<tr>
						<th>Username</th>
						<th>Password</th>
						<th>Perguruan Tinggi</th>
						<th>Program</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->username}</td>
							<td>{$data->password}</td>
							<td>{$data->nama_pt}</td>
							<td>{$data->nama_program_singkat}</td>
							<td><code>{$data->email}</code></td>
							<td>
								<a href="{site_url("user/update/{$data->id}")}" class="btn btn-xs btn-default">Edit</a>
								<a class="btn btn-xs btn-danger" 
									data-toggle="modal" data-target="#resetDialog"
									data-id="{$data->id}" data-email="{$data->email}">Reset</a>
								{if $data->password != ''}
									<a class="btn btn-xs btn-info"
									   data-toggle="modal" data-target="#resendDialog"
									   data-id="{$data->id}" data-email="{$data->email}">Kirim Ulang</a>
								{/if}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			<p class="small">* User yang tidak muncul passwordnya, tidak bisa dikirim ulang passwordnya sebelum di reset.<br/>
				* Mereset password akan otomatis mengirim ke email begitu juga dengan kirim ulang.<p>
		</div>
	</div>

	<div id="resetDialog" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h4>Apakah user ini akan di reset passwordnya ?</h4>
					<p>User akan menerima password terbaru melalui email sesaat setelah di reset.
						Email akan di kirimkan ke : <span id="resetEmail"></span></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-danger" id="resetSubmitButton">Reset</button>
				</div>
			</div>
		</div>
	</div>
				
	<div id="resendDialog" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h4>Apakah info login user akan di kirim ulang ?</h4>
					<p>User akan menerima info login ke email : <span id="resendEmail"></span></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-info" id="resendSubmitButton">Kirim Ulang User</button>
				</div>
			</div>
		</div>
	</div>
				
	<div id="infoDialog" class="modal fade" tabindex="-2" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<p id="infoMessage"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript: window.location.reload(); return false;">OK</button>
				</div>
			</div>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type="text/javascript">
		
		$('#table').DataTable();
		$('#table').show();
		
		$('#resetDialog').on('show.bs.modal', function (event) {
			var sourceButton = $(event.relatedTarget);
			$('#resetSubmitButton').data('id', sourceButton.data('id'));
			$(this).find('#resetEmail').text(sourceButton.data('email'));
		});
		
		$('#resendDialog').on('show.bs.modal', function (event) {
			var sourceButton = $(event.relatedTarget);
			$('#resendSubmitButton').data('id', sourceButton.data('id'));
			$(this).find('#resendEmail').text(sourceButton.data('email'));
		});

		$('#resetSubmitButton').on('click', function () {
			var id = $(this).data('id');
			$.ajax({
				url: "{site_url('user/reset')}?id="+id,
				type: 'POST',
				dataType: 'json',
				success: function (data) {
					if (data.change_result && data.mail_result) {
						$('#resetDialog').modal('hide');
						$('#infoMessage').text('Password berhasil di reset dan informasi hasil reset sudah terkirim ke email');
						$('#infoDialog').modal();
					}
					else {
						alert('terjadi kesalahan');
					}
				}
			});
		});
		
		$('#resendSubmitButton').on('click', function () {
			var id = $(this).data('id');
			$.ajax({
				url: "{site_url('user/resend')}?id="+id,
				type: 'POST',
				dataType: 'json',
				success: function (data) {
					if (data.result) {
						$('#resendDialog').modal('hide');
						$('#infoMessage').text('User login berhasil di kirim ulang ke email');
						$('#infoDialog').modal();
					}
					else {
						alert('terjadi kesalahan');
					}
				}
			});
		});
	</script>
{/block}