{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Submit Proposal</h2>
	<div class="row">
		<div class="col-lg-6 col-md-12">

			<div class="panel panel-success">
				<div class="panel-heading">Konfirmasi Submit</div>
				<div class="panel-body">
					<form action="{site_url("proposal/submit/{$data->id}")}" method="post">
					<p>Apakah proposal <strong>{$data->judul}</strong> akan disubmit ?</p>
					<p><i>* Proposal yang sudah disubmit tidak akan bisa di edit maupun dihapus</i></p>
					<p class="text-right">
						<a href="{site_url("proposal/index")}" class="btn btn-default">Kembali</a>
						<input type="submit" value="Submit" class="btn btn-success" />
					</p>
					</form>
				</div>
			</div>

		</div>
	</div>
{/block}