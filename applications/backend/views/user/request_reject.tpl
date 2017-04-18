{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar User Request</h1>

	<div class="row">
		<div class="col-lg-8 col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">Konfirmasi Reject</div>
				<div class="panel-body">
					<form action="{site_url("user/request-reject?id={$data->id}")}" method="post">
						<p>Apakah permintaan user dari <strong>{$data->perguruan_tinggi}</strong> akan ditolak ?</p>
						<p class="text-info small">Informasi reject akan dikirimkan ke email {$data->email}</p>
						<div class="form-group">
							<label for="message">Pesan</label>
							<select class="form-control" name="reject_message_id">
								{foreach $reject_message_set as $rm}
									<option value="{$rm->id}">{$rm->message}</option>
								{/foreach}
								<option value="-1">Lain-lain</option>
							</select>
						</div>
						<textarea name="reject_message" class="form-control" style="display: none"></textarea>
						<br/>
						<p class="text-right">
							<a href="{site_url('user/request')}" class="btn btn-default">Kembali</a>
							<input type="submit" value="Submit" class="btn btn-primary" />
						</p>
					</form>
				</div>
			</div>

		</div>
	</div>
{/block}
{block name='footer-script'}
	<script type="text/javascript">
		$('select[name="reject_message_id"]').change(function() {
			if ($(this).val() === '-1') {
				$('textarea').show().text('').attr('placeholder', 'Tulis pesan informasi lain di sini');
			}
			else {
				$('textarea').hide().text();
			}
		});
	</script>
{/block}