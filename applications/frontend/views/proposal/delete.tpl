{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Hapus Proposal</h1>
	<div class="row">
		<div class="col-lg-6 col-md-12">

			<div class="panel panel-danger">
				<div class="panel-heading">Konfirmasi Hapus</div>
				<div class="panel-body">
					<form action="{site_url("proposal/delete/{$data->id}")}" method="post">
					<p>Apakah proposal <strong>{$data->judul}</strong> akan dihapus ?</p>
					<p class="text-right">
						<a href="{site_url("proposal/index")}" class="btn btn-default">Kembali</a>
						<input type="submit" value="Submit" class="btn btn-danger" />
					</p>
					</form>
				</div>
			</div>

		</div>
	</div>
{/block}