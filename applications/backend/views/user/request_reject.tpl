{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Daftar User Request</h1>

	<div class="row">
		<div class="col-lg-6 col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">Konfirmasi Reject</div>
				<div class="panel-body">
					<form action="{site_url("user/request-reject?id={$data->id}")}" method="post">
					<p>Apakah request dari <strong>{$data->perguruan_tinggi}</strong> akan direject ?</p>
					<p class="text-info">Informasi reject akan dikirimkan ke email {$data->email}</p>
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